<?php

declare(strict_types=1);

namespace App\Service\Strava;

use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class FetchAbstractApiCaller extends TokenRefreshingAbstractApiCaller
{
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

	protected function getOptions(): array
	{
		return [
			'auth_bearer' => $this->security->getUser()->getStravaIntegration()->getAccessToken(),
		];
	}
}
