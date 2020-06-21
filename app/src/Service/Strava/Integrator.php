<?php

declare(strict_types=1);

namespace App\Service\Strava;

class Integrator
{
	/**
	 * @var TokenExchanger
	 */
	private $tokenExchanger;

	/**
	 * @var StatsUpdater
	 */
	private $statsUpdater;

	/**
	 * @var ActivitiesFetcher
	 */
	private $activitiesFetcher;

	public function __construct(
		TokenExchanger $tokenExchanger,
		StatsUpdater $statsUpdater,
		ActivitiesFetcher $activitiesFetcher
	) {
		$this->tokenExchanger = $tokenExchanger;
		$this->statsUpdater = $statsUpdater;
		$this->activitiesFetcher = $activitiesFetcher;
	}

	public function integrate(string $authorizationCode): void
	{
		$this->tokenExchanger->exchange($authorizationCode);
		$this->statsUpdater->update();
		$this->activitiesFetcher->fetch();
	}
}
