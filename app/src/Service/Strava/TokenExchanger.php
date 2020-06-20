<?php

declare(strict_types=1);

namespace App\Service\Strava;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class TokenExchanger
{
	/**
	 * @var ExchangeTokenApiCaller
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
		ExchangeTokenApiCaller $apiCaller,
		Security $security,
		EntityManagerInterface $entityManager
	) {
		$this->apiCaller = $apiCaller;
		$this->security = $security;
		$this->entityManager = $entityManager;
	}

	public function exchange(string $authorizationCode): void
	{
		$this->apiCaller->setAuthorizationCode($authorizationCode);

		$responseData = $this->apiCaller->call()->toArray();
		$user = $this->security->getUser();

		$user->getStravaIntegration()->setAccessToken($responseData['access_token']);
		$user->getStravaIntegration()->setAccessTokenExpiresAt(new DateTime('@'.$responseData['expires_at']));
		$user->getStravaIntegration()->setRefreshToken($responseData['refresh_token']);
		$user->getStravaAthlete()->setId((int) $responseData['athlete']['id']);
		$user->getStravaAthlete()->setThumbUrl($responseData['athlete']['profile']);

		$this->entityManager->flush();
	}
}
