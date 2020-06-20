<?php

declare(strict_types=1);

namespace App\Service\Strava;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class TokenRefresher extends AbstractTokenUpdater
{
	/**
	 * @var RefreshTokenAbstractApiCaller
	 */
	private $apiCaller;

	/**
	 * @var Security
	 */
	private $security;

	public function __construct(
		RefreshTokenAbstractApiCaller $apiCaller,
		Security $security,
		EntityManagerInterface $entityManager
	) {
		parent::__construct($apiCaller, $security, $entityManager);

		$this->apiCaller = $apiCaller;
		$this->security = $security;
	}

	public function refresh(): void
	{
		$user = $this->security->getUser();

		if (!$user->getStravaIntegration()->isAccessTokenExpired()) {
			return;
		}

		$this->apiCaller->setRefreshToken($user->getStravaIntegration()->getRefreshToken());

		parent::update();
	}
}
