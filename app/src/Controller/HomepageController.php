<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ActivityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class HomepageController extends AbstractController
{
	/**
	 * @var ActivityRepository
	 */
	private $activityRepository;

	public function __construct(ActivityRepository $activityRepository)
	{
		$this->activityRepository = $activityRepository;
	}

	/**
	 * @Route("/", name="homepage")
	 * @Template
	 *
	 * @return array
	 */
	public function showAction(): array
	{
		return [
			'activities' => $this->activityRepository->findByPublic(0, 5),
		];
	}
}
