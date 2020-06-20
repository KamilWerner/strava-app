<?php

declare(strict_types=1);

namespace App\Service\Strava;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

abstract class AbstractTokenUpdater
{
	/**
	 * @var AuthorizationAbstractApiCaller
	 */
	private $apiCaller;

	/**
	 * @var Security
	 */
	private $security;

	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

	public function __construct(
		AuthorizationAbstractApiCaller $apiCaller,
		Security $security,
		EntityManagerInterface $entityManager
	) {
		$this->apiCaller = $apiCaller;
		$this->security = $security;
		$this->entityManager = $entityManager;
	}

	protected function update(): void
	{
		$responseData = $this->apiCaller->call()->toArray();
		$user = $this->security->getUser();

		$user->getStravaIntegration()->setAccessToken($responseData['access_token']);
		$user->getStravaIntegration()->setAccessTokenExpiresAt(new DateTime('@'.$responseData['expires_at']));
		$user->getStravaIntegration()->setRefreshToken($responseData['refresh_token']);

		if (isset($responseData['athlete'])) {
			$user->getStravaAthlete()->setId((int)$responseData['athlete']['id']);
			$user->getStravaAthlete()->setThumbUrl($responseData['athlete']['profile']);
		}

		$this->entityManager->flush();
	}
}
