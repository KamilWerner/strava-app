<?php

declare(strict_types=1);

namespace App\Service\Strava;

use App\Service\ApiCaller\ResponseStatusValidatingAbstractApiCaller;
use DomainException;

class ExchangeTokenApiCaller extends ResponseStatusValidatingAbstractApiCaller
{
	private const REQUEST_URL = 'https://www.strava.com/oauth/token';

	private const APP_ID = '49924';
	private const APP_SECRET = '40e934853ab4405a354a47fa7508aa549aed2ac0';

	private const AUTH_GRANT_TYPE_EXCHANGE = 'authorization_code';

	/**
	 * @var string|null
	 */
	private $authorizationCode;

	public function setAuthorizationCode(string $authorizationCode): void
	{
		$this->authorizationCode = $authorizationCode;
	}

	protected function getMethod(): string
	{
		return self::REQUEST_METHOD_POST;
	}

	protected function getUrl(): string
	{
		return self::REQUEST_URL;
	}

	protected function getOptions(): array
	{
		if (!$this->authorizationCode) {
			throw new DomainException();
		}

		return [
			'body' => [
				'client_id' => self::APP_ID,
				'client_secret' => self::APP_SECRET,
				'code' => $this->authorizationCode,
				'grant_type' => self::AUTH_GRANT_TYPE_EXCHANGE,
			],
		];
	}
}
