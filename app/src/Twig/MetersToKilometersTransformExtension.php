<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MetersToKilometersTransformExtension extends AbstractExtension
{
	private const KILOMETER_IN_METERS = 1000;

	/**
	 * @return TwigFilter[]
	 */
	public function getFilters(): array
	{
		return [
			new TwigFilter('meters_to_kilometers', [$this, 'transformMetersToKilometers']),
		];
	}

	public function transformMetersToKilometers(float $meters): string
	{
		return sprintf(
			'%02.2f km',
			round($meters /self::KILOMETER_IN_METERS, 2)
		);
	}
}
