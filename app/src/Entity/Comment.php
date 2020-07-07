<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Comment
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
	 * @var string
	 *
	 * @ORM\Column(type="text")
	 */
	private $content = '';

	/**
	 * @var DateTimeInterface
	 *
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;

	/**
	 * @var User|null
	 *
	 * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $user;

	/**
	 * @var Activity|null
	 *
	 * @ORM\ManyToOne(targetEntity=Activity::class, inversedBy="comments")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $activity;

	public function __construct()
	{
		$this->createdAt = new DateTime();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getContent(): string
	{
		return $this->content;
	}

	public function setContent(string $content): self
	{
		$this->content = $content;

		return $this;
	}

	public function getCreatedAt(): DateTimeInterface
	{
		return $this->createdAt;
	}

	public function setCreatedAt(DateTimeInterface $createdAt): self
	{
		$this->createdAt = $createdAt;

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

	public function getActivity(): ?Activity
	{
		return $this->activity;
	}

	public function setActivity(?Activity $activity): self
	{
		$this->activity = $activity;

		return $this;
	}
}
