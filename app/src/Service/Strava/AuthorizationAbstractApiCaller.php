<?php

declare(strict_types=1);

namespace App\Service\Strava;

abstract class AuthorizationAbstractApiCaller extends BaseAbstractApiCaller
{
	private const STRAVA_API_AUTHORIZATION_PATH = '/oauth/token';

	protected const APP_ID = '49924';
	protected const APP_SECRET = '40e934853ab4405a354a47fa7508aa549aed2ac0';

	protected function getMethod(): string
	{
		return self::REQUEST_METHOD_POST;
	}

	protected function getPath(): string
	{
		return self::STRAVA_API_AUTHORIZATION_PATH;
	}
}
