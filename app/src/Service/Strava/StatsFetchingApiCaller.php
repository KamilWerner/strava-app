<?php

declare(strict_types=1);

namespace App\Service\Strava;

use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class StatsFetchingApiCaller extends FetchingApiCaller
{
	private const STRAVA_API_STATS_PATH = '/athletes/%d/stats';

	/**
	 * @var Security
	 */
	private $security;

	public function __construct(
		HttpClientInterface $client,
		TokenRefresher $tokenRefresher,
		Security $security
	) {
		parent::__construct($client, $tokenRefresher, $security);

		$this->security = $security;
	}

	protected function getPath(): string
	{
		return sprintf(
			self::STRAVA_API_STATS_PATH,
			$this->security->getUser()->getStravaAthlete()->getId()
		);
	}
}
