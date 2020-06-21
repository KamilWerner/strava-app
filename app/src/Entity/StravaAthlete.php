<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class StravaAthlete
{
	/**
	 * @var int|null
	 *
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $id;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", length=300, nullable=true)
	 */
	private $thumbUrl;

	/**
	 * @var float|null
	 *
	 * @ORM\Column(type="float", nullable=true)
	 */
	private $biggestRideDistance;

	/**
	 * @var float|null
	 *
	 * @ORM\Column(type="float", nullable=true)
	 */
	private $totalRideDistance;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setId(int $id): self
	{
		$this->id = $id;

		return $this;
	}

	public function getThumbUrl(): ?string
	{
		return $this->thumbUrl;
	}

	public function setThumbUrl(string $thumbUrl): self
	{
		$this->thumbUrl = $thumbUrl;

		return $this;
	}

	public function getBiggestRideDistance(): ?float
	{
		return $this->biggestRideDistance;
	}

	public function setBiggestRideDistance(float $biggestRideDistance): self
	{
		$this->biggestRideDistance = $biggestRideDistance;

		return $this;
	}

	public function getTotalRideDistance(): ?float
	{
		return $this->totalRideDistance;
	}

	public function setTotalRideDistance(float $totalRideDistance): self
	{
		$this->totalRideDistance = $totalRideDistance;

		return $this;
	}
}
