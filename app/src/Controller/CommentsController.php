<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Comment;
use App\Form\Type\CommentAddType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class CommentsController extends AbstractController
{
	/**
	 * @Route("/route/{id}/comment_add", name="public_route_comment_add")
	 * @Template
	 *
	 * @param Request  $request
	 * @param Activity $activity
	 *
	 * @return array|RedirectResponse
	 */
	public function addAction(Request $request, Activity $activity)
	{
		if (!$activity->isPublic()) {
			$this->addError('You cannot comment private route!');

			return $this->redirectToRoute('homepage');
		}

		$form = $this->createForm(CommentAddType::class, null, [
			'action' => $this->generateUrl('public_route_comment_add', ['id' => $activity->getId()]),
		]);

		$form->handleRequest($request);

		if (!$form->isSubmitted() || !$form->isValid()) {
			return [
				'form' => $form->createView(),
			];
		}

		$comment = $form->getData();

		$comment
			->setUser($this->getUser())
			->setActivity($activity);

		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->persist($comment);
		$entityManager->flush();

		$this->addNotice('Successfully added comment!');

		return $this->redirectToRoute('route', ['id' => $activity->getId()]);
	}

	/**
	 * @Route("/comment/{id}/remove", name="public_route_comment_remove")
	 *
	 * @param Comment $comment
	 *
	 * @return RedirectResponse
	 */
	public function removeAction(Comment $comment): RedirectResponse
	{
		if ($this->getUser()->getId() !== $comment->getUser()->getId()) {
			$this->addError('You cannot remove someone else comment!');

			return $this->redirectToRoute('route', ['id' => $comment->getActivity()->getId()]);
		}

		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->remove($comment);
		$entityManager->flush();

		$this->addNotice('Comment successfully removed!');

		return $this->redirectToRoute('route', ['id' => $comment->getActivity()->getId()]);
	}
}
