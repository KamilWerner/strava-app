<?php

declare(strict_types=1);

namespace App\Service\Strava;

class ActivitiesFetchingApiCaller extends FetchingApiCaller
{
	private const STRAVA_API_ACTIVITIES_PATH = '/athlete/activities';

	protected function getPath(): string
	{
		return self::STRAVA_API_ACTIVITIES_PATH;
	}
}
