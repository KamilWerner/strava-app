<?php

declare(strict_types=1);

namespace App\Service\Strava;

use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FetchStatsApiCaller extends TokenRefreshingAbstractApiCaller
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
		parent::__construct($client, $tokenRefresher);

		$this->security = $security;
	}

	protected function getMethod(): string
	{
		return self::REQUEST_METHOD_GET;
	}

	protected function getPath(): string
	{
		return sprintf(
			self::STRAVA_API_STATS_PATH,
			$this->security->getUser()->getStravaAthlete()->getId()
		);
	}

	protected function getOptions(): array
	{
		return [
			'auth_bearer' => $this->security->getUser()->getStravaIntegration()->getAccessToken(),
		];
	}
}
