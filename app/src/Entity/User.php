<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
	private const ROLE_USER = 'ROLE_USER';

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
	 * @ORM\Column(type="string", length=180, unique=true)
	 *
	 * @Assert\Email
	 */
	private $email = '';

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=100)
	 *
	 * @Assert\NotBlank
	 */
	private $name = '';

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=100)
	 *
	 * @Assert\NotBlank
	 */
	private $surname = '';

	/**
	 * @var string[]
	 *
	 * @ORM\Column(type="json")
	 */
	private $roles = [];

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string")
	 *
	 * @Assert\NotBlank
	 */
	private $password = '';

	/**
	 * @var StravaIntegration
	 *
	 * @ORM\Embedded(class="StravaIntegration", columnPrefix="strava_integration_")
	 */
	private $stravaIntegration;

	/**
	 * @var StravaAthlete
	 *
	 * @ORM\Embedded(class="StravaAthlete", columnPrefix="strava_athlete_")
	 */
	private $stravaAthlete;

	/**
	 * @var DateTimeInterface
	 *
	 * @ORM\Column(type="datetime")
	 */
	private $registeredAt;

	/**
	 * @var DateTimeInterface
	 *
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $lastLoginAt;

	/**
	 * @var Collection|Activity[]
	 *
	 * @ORM\OneToMany(targetEntity=Activity::class, mappedBy="user")
	 */
	private $activities;

	/**
	 * @var Collection|Comment[]
	 *
	 * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="user")
	 */
	private $comments;

	public function __construct()
	{
		$this->stravaIntegration = new StravaIntegration();
		$this->stravaAthlete = new StravaAthlete();
		$this->registeredAt = new DateTime();
		$this->activities = new ArrayCollection();
		$this->comments = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;

		return $this;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function getSurname(): string
	{
		return $this->surname;
	}

	public function setSurname(string $surname): self
	{
		$this->surname = $surname;

		return $this;
	}

	public function getUsername(): string
	{
		return $this->email;
	}

	/**
	 * @return string[]
	 */
	public function getRoles(): array
	{
		$roles = $this->roles;

		$roles[] = self::ROLE_USER;

		return array_unique($roles);
	}

	public function setRoles(array $roles): self
	{
		$this->roles = $roles;

		return $this;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function setPassword(string $password): self
	{
		$this->password = $password;

		return $this;
	}

	public function getStravaIntegration(): StravaIntegration
	{
		return $this->stravaIntegration;
	}

	public function getStravaAthlete(): StravaAthlete
	{
		return $this->stravaAthlete;
	}

	public function getRegisteredAt(): DateTimeInterface
	{
		return $this->registeredAt;
	}

	public function getLastLoginAt(): DateTimeInterface
	{
		return $this->lastLoginAt;
	}

	public function setLastLoginAt(DateTimeInterface $lastLoginAt): self
	{
		$this->lastLoginAt = $lastLoginAt;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSalt()
	{
		// not needed when using the "bcrypt" algorithm in security.yaml
	}

	/**
	 * {@inheritdoc}
	 */
	public function eraseCredentials()
	{
		// If you store any temporary, sensitive data on the user, clear it here
		// $this->plainPassword = null;
	}

	/**
	 * @return Collection|Activity[]
	 */
	public function getActivities(): Collection
	{
		return $this->activities;
	}

	public function addActivity(Activity $activity): self
	{
		if (!$this->activities->contains($activity)) {
			$this->activities[] = $activity;
			$activity->setUser($this);
		}

		return $this;
	}

	public function removeActivity(Activity $activity): self
	{
		if ($this->activities->contains($activity)) {
			$this->activities->removeElement($activity);

			if ($activity->getUser() === $this) {
				$activity->setUser(null);
			}
		}

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

			$comment->setUser($this);
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
