<?php

declare(strict_types=1);

namespace App\Twig;

use App\Service\GooglePolylineDecoder;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class GooglePolylineDecoderExtension extends AbstractExtension
{
	/**
	 * @var GooglePolylineDecoder
	 */
	private $googlePolylineDecoder;

	public function __construct(GooglePolylineDecoder $googlePolylineDecoder)
	{
		$this->googlePolylineDecoder = $googlePolylineDecoder;
	}

	/**
	 * @return TwigFilter[]
	 */
	public function getFilters(): array
	{
		return [
			new TwigFilter('google_polyline_decode', [$this->googlePolylineDecoder, 'decode']),
		];
	}
}
