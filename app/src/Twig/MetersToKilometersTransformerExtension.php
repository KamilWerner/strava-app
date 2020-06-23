<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MetersToKilometersTransformerExtension extends AbstractExtension
{
	private const KILOMETER_IN_METERS = 1000;
	private const HOUR_IN_SECONDS = 3600;

	/**
	 * @return TwigFilter[]
	 */
	public function getFilters(): array
	{
		return [
			new TwigFilter('meters_to_kilometers', [$this, 'transformMetersToKilometers']),
			new TwigFilter('meters_per_second_to_kilometers_per_hour', [$this, 'transformMetersPerSecondToKilometersPerHour']),
		];
	}

	public function transformMetersToKilometers(float $meters): string
	{
		return sprintf(
			'%02.2f km',
			round($meters /self::KILOMETER_IN_METERS, 2)
		);
	}

	public function transformMetersPerSecondToKilometersPerHour(float $metersPerSecond): string
	{
		return sprintf(
			'%02.2f km/h',
			round(($metersPerSecond * self::HOUR_IN_SECONDS) /self::KILOMETER_IN_METERS, 2)
		);
	}
}
