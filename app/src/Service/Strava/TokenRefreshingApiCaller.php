<?php

declare(strict_types=1);

namespace App\Service\Strava;

class TokenRefreshingApiCaller extends AuthorizationAbstractApiCaller
{
	private const AUTH_GRANT_TYPE_REFRESH = 'refresh_token';

	/**
	 * @var string|null
	 */
	private $refreshToken;

	public function setRefreshToken(string $refreshToken): void
	{
		$this->refreshToken = $refreshToken;
	}

	protected function getOptions(): array
	{
		return [
			'body' => [
				'client_id' => self::APP_ID,
				'client_secret' => self::APP_SECRET,
				'refresh_token' => $this->refreshToken,
				'grant_type' => self::AUTH_GRANT_TYPE_REFRESH,
			],
		];
	}
}
