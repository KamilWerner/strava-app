<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SecondsToTimeFormatterExtension extends AbstractExtension
{
	/**
	 * @return TwigFilter[]
	 */
	public function getFilters(): array
	{
		return [
			new TwigFilter('time_format', [$this, 'formatSecondsToTime']),
		];
	}

	public function formatSecondsToTime(int $seconds): string
	{
		return gmdate('H:i:s', $seconds);
	}
}
