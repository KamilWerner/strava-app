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
}
