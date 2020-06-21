<?php

declare(strict_types=1);

namespace App\Service\Strava;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class StatsUpdater
{
	/**
	 * @var FetchStatsApiCaller
	 */
	private $apiCaller;

	/**
	 * @var Security
	 */
	private $security;

	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

	public function __construct(
		FetchStatsApiCaller $apiCaller,
		Security $security,
		EntityManagerInterface $entityManager
	) {
		$this->apiCaller = $apiCaller;
		$this->security = $security;
		$this->entityManager = $entityManager;
	}

	public function update(): void
	{
		$responseData = $this->apiCaller->call()->toArray();
		$user = $this->security->getUser();

		$user->getStravaAthlete()->setBiggestRideDistance((float) $responseData['biggest_ride_distance']);
		$user->getStravaAthlete()->setTotalRideDistance((float) $responseData['all_ride_totals']['distance']);

		$this->entityManager->flush();
	}
}
