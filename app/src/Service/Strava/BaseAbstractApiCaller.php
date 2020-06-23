<?php

declare(strict_types=1);

namespace App\Service\Strava;

use App\Service\ApiCaller\ResponseStatusValidatingAbstractApiCaller;

abstract class BaseAbstractApiCaller extends ResponseStatusValidatingAbstractApiCaller
{
	private const STRAVA_API_URL = 'https://www.strava.com/api/v3';

	final protected function getUrl(): string
	{
		return self::STRAVA_API_URL.$this->getPath();
	}

	abstract protected function getPath(): string;
}
