<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ActivityRepository;

/**
 * @ORM\Entity(repositoryClass=ActivityRepository::class)
 */
class Activity
{
	/**
	 * @var int|null
	 *
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", length=300, nullable=true)
	 */
	private $title;

	/**
	 * @var float|null
	 *
	 * @ORM\Column(type="float", nullable=true)
	 */
	private $distance;

	/**
	 * @var int|null
	 *
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private $movingTime;

	/**
	 * @var DateTimeInterface|null
	 *
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $startAt;

	/**
	 * @var float[]|null
	 *
	 * @ORM\Column(type="json", nullable=true)
	 */
	private $startPoint;

	/**
	 * @var float[]|null
	 *
	 * @ORM\Column(type="json", nullable=true)
	 */
	private $endPoint;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="text", nullable=true)
	 */
	private $encodedPolyline;

	/**
	 * @var float|null
	 *
	 * @ORM\Column(type="float", nullable=true)
	 */
	private $averageSpeed;

	/**
	 * @var float|null
	 *
	 * @ORM\Column(type="float", nullable=true)
	 */
	private $maxSpeed;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle(string $title): self
	{
		$this->title = $title;

		return $this;
	}

	public function getDistance(): ?float
	{
		return $this->distance;
	}

	public function setDistance(float $distance): self
	{
		$this->distance = $distance;

		return $this;
	}

	public function getMovingTime(): ?int
	{
		return $this->movingTime;
	}

	public function setMovingTime(int $movingTime): self
	{
		$this->movingTime = $movingTime;

		return $this;
	}

	public function getStartAt(): ?DateTimeInterface
	{
		return $this->startAt;
	}

	public function setStartAt(DateTimeInterface $startAt): self
	{
		$this->startAt = $startAt;

		return $this;
	}

	/**
	 * @return float[]|null
	 */
	public function getStartPoint(): ?array
	{
		return $this->startPoint;
	}

	/**
	 * @param float[] $startPoint
	 *
	 * @return self
	 */
	public function setStartPoint(array $startPoint): self
	{
		$this->startPoint = $startPoint;

		return $this;
	}

	/**
	 * @return float[]|null
	 */
	public function getEndPoint(): ?array
	{
		return $this->endPoint;
	}

	/**
	 * @param float[] $endPoint
	 *
	 * @return self
	 */
	public function setEndPoint(array $endPoint): self
	{
		$this->endPoint = $endPoint;

		return $this;
	}

	public function getEncodedPolyline(): ?string
	{
		return $this->encodedPolyline;
	}

	public function setEncodedPolyline(string $encodedPolyline): self
	{
		$this->encodedPolyline = $encodedPolyline;

		return $this;
	}

	public function getAverageSpeed(): ?float
	{
		return $this->averageSpeed;
	}

	public function setAverageSpeed(float $averageSpeed): self
	{
		$this->averageSpeed = $averageSpeed;

		return $this;
	}

	public function getMaxSpeed(): ?float
	{
		return $this->maxSpeed;
	}

	public function setMaxSpeed(float $maxSpeed): self
	{
		$this->maxSpeed = $maxSpeed;

		return $this;
	}

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
