<?php

declare(strict_types=1);

namespace App\Service\Strava;

use App\Service\ApiCaller\ResponseStatusValidatingAbstractApiCaller;

abstract class AuthorizationAbstractApiCaller extends ResponseStatusValidatingAbstractApiCaller
{
	private const REQUEST_URL = 'https://www.strava.com/oauth/token';

	protected const APP_ID = '49924';
	protected const APP_SECRET = '40e934853ab4405a354a47fa7508aa549aed2ac0';

	protected function getMethod(): string
	{
		return self::REQUEST_METHOD_POST;
	}

	protected function getUrl(): string
	{
		return self::REQUEST_URL;
	}
}
