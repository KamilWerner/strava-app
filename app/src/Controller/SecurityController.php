<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\UserRegisterType;
use LogicException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
	/**
	 * @Route("/sign_in", name="user_sign_in")
	 *
	 * @param AuthenticationUtils $authenticationUtils
	 *
	 * @return Response
	 */
	public function login(AuthenticationUtils $authenticationUtils): Response
	{
		if ($this->getUser()) {
			return $this->redirectLoggedUser();
		}

		return $this->render('security/login.html.twig', [
			'last_username' => $authenticationUtils->getLastUsername(),
			'error' => $authenticationUtils->getLastAuthenticationError(),
		]);
	}

	/**
	 * @Route("/sign_up", name="user_sign_up")
	 *
	 * @param Request                      $request
	 * @param UserPasswordEncoderInterface $userPasswordEncoder
	 *
	 * @return Response
	 */
	public function register(
		Request $request,
		UserPasswordEncoderInterface $userPasswordEncoder
	): Response {
		if ($this->getUser()) {
			return $this->redirectLoggedUser();
		}

		$form = $this->createForm(UserRegisterType::class);

		$form->handleRequest($request);

		if (!$form->isSubmitted() || !$form->isValid()) {
			return $this->render('security/register.html.twig', [
				'form' => $form->createView(),
			]);
		}

		$user = $form->getData();

		$user->setPassword(
			$userPasswordEncoder->encodePassword($user, $user->getPassword())
		);

		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->persist($user);
		$entityManager->flush();

		$this->addNotice(
			sprintf(
				'User %s has been added. You can now log in!',
				$user->getEmail()
			)
		);

		return $this->redirectToRoute('user_sign_in');
	}

	/**
	 * @Route("/logout", name="user_logout")
	 *
	 * @throws LogicException
	 */
	public function logout(): void
	{
		throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
	}

	private function redirectLoggedUser(): RedirectResponse
	{
		$this->addNotice(
			sprintf(
				'You are currently logged in as %s!',
				$this->getUser()->getEmail()
			)
		);

		return $this->redirectToRoute('homepage');
	}
}
