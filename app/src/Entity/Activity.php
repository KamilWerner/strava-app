<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
	 * @var int|null
	 *
	 * @ORM\Column(type="bigint", nullable=true)
	 */
	private $originId;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", length=300, nullable=true)
	 */
	private $title;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="text")
	 */
	private $description = '';

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
	 * @var float|null
	 *
	 * @ORM\Column(type="float", nullable=true)
	 */
	private $highElevation;

	/**
	 * @var float|null
	 *
	 * @ORM\Column(type="float", nullable=true)
	 */
	private $lowElevation;

	/**
	 * @var bool
	 *
	 * @ORM\Column(type="boolean")
	 */
	private $public = false;

	/**
	 * @var DateTimeInterface
	 *
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $publishedAt;

	/**
	 * @var User|null
	 *
	 * @ORM\ManyToOne(targetEntity=User::class, inversedBy="activities")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $user;

	/**
	 * @var Collection|Comment[]
	 *
	 * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="activity")
	 */
	private $comments;

	public function __construct()
	{
		$this->comments = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getOriginId(): ?int
	{
		return $this->originId;
	}

	public function setOriginId(int $originId): self
	{
		$this->originId = $originId;

		return $this;
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

	public function getDescription(): string
	{
		return $this->description;
	}

	public function setDescription(string $description): self
	{
		$this->description = $description;

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

	public function getHighElevation(): ?float
	{
		return $this->highElevation;
	}

	public function setHighElevation(float $highElevation): self
	{
		$this->highElevation = $highElevation;

		return $this;
	}

	public function getLowElevation(): ?float
	{
		return $this->lowElevation;
	}

	public function setLowElevation(float $lowElevation): self
	{
		$this->lowElevation = $lowElevation;

		return $this;
	}

	public function getElevation(): float
	{
		return $this->highElevation && $this->lowElevation
			? $this->highElevation - $this->lowElevation
			: 0;
	}

	public function isPublic(): bool
	{
		return $this->public;
	}

	public function setPublic(bool $public): self
	{
		if ($public !== $this->public) {
			$this->publishedAt = $public
				? new DateTime()
				: null;
		}

		$this->public = $public;

		return $this;
	}

	public function getPublishedAt(): ?DateTimeInterface
	{
		return $this->publishedAt;
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

	/**
	 * @return Collection|Comment[]
	 */
	public function getComments(): Collection
	{
		return $this->comments;
	}

	public function addComment(Comment $comment): self
	{
		if (!$this->comments->contains($comment)) {
			$this->comments[] = $comment;

			$comment->setActivity($this);
		}

		return $this;
	}

	private function removeComment(Comment $comment): self
	{
		if ($this->comments->contains($comment)) {
			$this->comments->removeElement($comment);

			if ($comment->getUser() === $this) {
				$comment->setUser(null);
			}
		}

		return $this;
	}
}
