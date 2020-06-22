<?php

declare(strict_types=1);

namespace App\Service\Strava;

use App\Entity\Activity;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class ActivitiesFetcher
{
	/**
	 * @var FetchActivitiesApiCaller
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
		FetchActivitiesApiCaller $apiCaller,
		Security $security,
		EntityManagerInterface $entityManager
	) {
		$this->apiCaller = $apiCaller;
		$this->security = $security;
		$this->entityManager = $entityManager;
	}

	public function fetch(): void
	{
		$activitiesData = $this->apiCaller->call()->toArray();

		foreach ($activitiesData as $activityData) {
			$activity = new Activity();

			$activity
				->setOriginId($activityData['id'])
				->setTitle($activityData['name'])
				->setDistance((float) $activityData['distance'])
				->setMovingTime((int) $activityData['moving_time'])
				->setStartAt(new DateTime($activityData['start_date']))
				->setStartPoint($activityData['start_latlng'])
				->setEndPoint($activityData['end_latlng'])
				->setEncodedPolyline($activityData['map']['summary_polyline'])
				->setAverageSpeed((float) $activityData['average_speed'])
				->setMaxSpeed((float) $activityData['max_speed'])
				->setHighElevation((float) $activityData['elev_high'])
				->setLowElevation((float) $activityData['elev_low'])
				->setUser($this->security->getUser());

			$this->entityManager->persist($activity);
		}

		$this->entityManager->flush();
	}
}
