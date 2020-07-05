<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\UserEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @IsGranted("ROLE_USER")
 */
class UsersController extends AbstractController
{
	/**
	 * @var UserPasswordEncoderInterface
	 */
	private $userPasswordEncoder;

	public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
	{
		$this->userPasswordEncoder = $userPasswordEncoder;
	}

	/**
	 * @Route("/user/edit", name="user_edit")
	 * @Template
	 *
	 * @param Request $request
	 *
	 * @return array|RedirectResponse
	 */
	public function editAction(Request $request)
	{
		$form = $this->createForm(UserEditType::class, $this->getUser());

		$form->handleRequest($request);

		if (!$form->isSubmitted() || !$form->isValid()) {
			return [
				'form' => $form->createView(),
			];
		}

		$user = $form->getData();
		$plainPassword = $form->get('password')->getData();

		if ($plainPassword) {
			$user->setPassword(
				$this->userPasswordEncoder->encodePassword($user, $plainPassword)
			);
		}

		$this->getDoctrine()->getManager()->flush();

		$this->addNotice('User successfully edited!');

		return $this->redirectToRoute('homepage');
	}
}
