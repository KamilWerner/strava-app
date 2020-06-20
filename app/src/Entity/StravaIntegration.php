<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class StravaIntegration
{
	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $accessToken;

	/**
	 * @var DateTimeInterface|null
	 *
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $accessTokenExpiresAt;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $refreshToken;

	public function getAccessToken(): ?string
	{
		return $this->accessToken;
	}

	public function setAccessToken(string $accessToken): self
	{
		$this->accessToken = $accessToken;

		return $this;
	}

	public function getAccessTokenExpiresAt(): ?DateTimeInterface
	{
		return $this->accessTokenExpiresAt;
	}

	public function setAccessTokenExpiresAt(DateTimeInterface $accessTokenExpiresAt): self
	{
		$this->accessTokenExpiresAt = $accessTokenExpiresAt;

		return $this;
	}

	public function getRefreshToken(): ?string
	{
		return $this->refreshToken;
	}

	public function setRefreshToken(string $refreshToken): self
	{
		$this->refreshToken = $refreshToken;

		return $this;
	}

	public function isIntegrated(): bool
	{
		return $this->accessToken && $this->refreshToken;
	}

	public function isAccessTokenExpired(): bool
	{
		return $this->isIntegrated() && $this->accessTokenExpiresAt < new DateTime();
	}
}
