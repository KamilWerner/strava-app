<?php

declare(strict_types=1);

namespace App\Service\Strava;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class TokenRefreshingAbstractApiCaller extends BaseAbstractApiCaller
{
	/**
	 * @var TokenRefresher
	 */
	private $tokenRefresher;

	public function __construct(HttpClientInterface $client, TokenRefresher $tokenRefresher)
	{
		parent::__construct($client);

		$this->tokenRefresher = $tokenRefresher;
	}

	public function call(): ResponseInterface
	{
		$this->tokenRefresher->refresh();

		return parent::call();
	}
}
