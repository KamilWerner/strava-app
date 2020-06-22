<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\ActivityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
			'activities' => $this->activityRepository->findByUser($user,$offset, self::ROUTES_PER_PAGE, $isAuthUser),
		];
	}
}
