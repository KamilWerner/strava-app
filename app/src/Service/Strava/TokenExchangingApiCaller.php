<?php

declare(strict_types=1);

namespace App\Service\Strava;

use DomainException;

class TokenExchangingApiCaller extends AuthorizationAbstractApiCaller
{
	private const AUTH_GRANT_TYPE_EXCHANGE = 'authorization_code';

	/**
	 * @var string|null
	 */
	private $authorizationCode;

	public function setAuthorizationCode(string $authorizationCode): void
	{
		$this->authorizationCode = $authorizationCode;
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
