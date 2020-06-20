<?php

declare(strict_types=1);

namespace App\Service\Strava;

use App\Service\ApiCaller\ResponseStatusValidatingAbstractApiCaller;

abstract class BaseAbstractApiCaller extends ResponseStatusValidatingAbstractApiCaller
{
	private const STRAVA_API_URL = 'https://www.strava.com/api/v3';

	protected final function getUrl(): string
	{
		return self::STRAVA_API_URL.$this->getPath();
	}

	protected abstract function getPath(): string;
}
