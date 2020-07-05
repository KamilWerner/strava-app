<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\User;
use App\Form\Type\ActivityEditType;
use App\Repository\ActivityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class RoutesController extends AbstractController
{
	private const ROUTES_PER_PAGE = 20;

	/**
	 * @var ActivityRepository
	 */
	private $activityRepository;

	public function __construct(ActivityRepository $activityRepository)
	{
		$this->activityRepository = $activityRepository;
	}

	/**
	 * @Route("/route/{id}", name="route")
	 * @Template
	 *
	 * @param Activity $activity
	 */
	public function showAction(Activity $activity)
	{
		return [
			'activity' => $activity,
		];
	}

	/**
	 * @Route(
	 *	"/user/{id}/routes/{page}",
	 *	name="user_routes",
	 *	defaults={"page": 1}
	 * )
	 * @Template("routes/list.html.twig")
	 *
	 * @param User $user
	 * @param int  $page
	 *
	 * @return array|RedirectResponse
	 */
	public function userRoutesListAction(User $user, int $page)
	{
		$offset = ($page - 1) * self::ROUTES_PER_PAGE;
		$isAuthUser = $user === $this->getUser();

		if ($page < 1 || $offset >= $this->activityRepository->countByUser($user, $isAuthUser)) {
			$this->addError('Invalid page number!');

			return $this->redirectToRoute('user_routes', ['id' => $user->getId()]);
		}

		return [
			'pageTitle' => $user->getName().' '.$user->getSurname().' routes',
			'isAuthUser' => $isAuthUser,
			'activities' => $this->activityRepository->findByUser($user, $offset, self::ROUTES_PER_PAGE, $isAuthUser),
		];
	}

	/**
	 * @Route(
	 *	"/routes/{page}",
	 *	name="public_routes",
	 *	defaults={"page": 1}
	 * )
	 * @Template("routes/list.html.twig")
	 *
	 * @param int $page
	 *
	 * @return array|RedirectResponse
	 */
	public function publicRoutesListAction(int $page)
	{
		$offset = ($page - 1) * self::ROUTES_PER_PAGE;
		$activitiesCount = $this->activityRepository->countByPublic();

		if (0 === $activitiesCount) {
			$this->addWarning('There are not any public routes!');

			return $this->redirectToRoute('homepage');
		}

		if ($page < 1 || $offset >= $this->activityRepository->countByPublic()) {
			$this->addError('Invalid page number!');

			return $this->redirectToRoute('public_routes');
		}

		return [
			'pageTitle' => 'Public routes',
			'isAuthUser' => false,
			'activities' => $this->activityRepository->findByPublic($offset, self::ROUTES_PER_PAGE),
		];
	}

	/**
	 * @Route("/route/{id}/edit", name="user_route_edit")
	 * @Template("routes/edit.html.twig")
	 *
	 * @param Request  $request
	 * @param Activity $activity
	 *
	 * @return array|RedirectResponse
	 */
	public function userRouteEditAction(Request $request, Activity $activity)
	{
		if ($this->getUser()->getId() !== $activity->getUser()->getId()) {
			$this->addError('You can not change someone else route!');

			return $this->redirectToRoute('homepage');
		}

		$form = $this->createForm(ActivityEditType::class, $activity);

		$form->handleRequest($request);

		if (!$form->isSubmitted() || !$form->isValid()) {
			return [
				'form' => $form->createView(),
				'activity' => $activity,
			];
		}

		$this->getDoctrine()->getManager()->flush();

		$this->addNotice('Successfully edited route informations!');

		return $this->redirectToRoute('route', ['id' => $activity->getId()]);
	}

	/**
	 * @Route("/route/{id}/toggle_public", name="user_route_toggle_public")
	 *
	 * @param Activity $activity
	 *
	 * @return RedirectResponse
	 */
	public function userRouteTogglePublishAction(Activity $activity): RedirectResponse
	{
		if ($this->getUser()->getId() !== $activity->getUser()->getId()) {
			$this->addError('You can not change someone else route!');

			return $this->redirectToRoute('homepage');
		}

		$activity->setPublic(!$activity->isPublic());

		$this->getDoctrine()->getManager()->flush();

		$this->addNotice(
			$activity->isPublic()
				? 'Route marked as publish!'
				: 'Route marked as hidden!'
		);

		return $this->redirectToRoute('user_routes', ['id' => $activity->getUser()->getId()]);
	}
}
