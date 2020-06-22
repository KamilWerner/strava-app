<?php

declare(strict_types=1);

namespace App\Service;

class GooglePolylineDecoder
{
	private const PRECISION = 5;

	public function decode(string $string): array
	{
		$point = [];
		$points = [];
		$index = $i = 0;
		$previous = [0, 0];

		while ($i < strlen($string)) {
			$shift = $result = 0x00;

			do {
				$bit = ord(substr($string, $i++)) - 63;
				$result |= ($bit & 0x1f) << $shift;
				$shift += 5;
			} while ($bit >= 0x20);

			$diff = ($result & 1) ? ~($result >> 1) : ($result >> 1);
			$number = $previous[$index % 2] + $diff;
			$previous[$index % 2] = $number;

			$index++;

			$point[] = $number * 1 / pow(10, self::PRECISION);

			if (2 === count($point)) {
				$points[] = $point;
				$point = [];
			}
		}

		return $points;
	}
}
