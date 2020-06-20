<?php

declare(strict_types=1);

namespace App\Service\Strava;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class TokenExchanger extends AbstractTokenUpdater
{
	/**
	 * @var ExchangeTokenAbstractApiCaller
	 */
	private $apiCaller;

	public function __construct(
		ExchangeTokenAbstractApiCaller $apiCaller,
		Security $security,
		EntityManagerInterface $entityManager
	) {
		parent::__construct($apiCaller, $security, $entityManager);

		$this->apiCaller = $apiCaller;
	}

	public function exchange(string $authorizationCode): void
	{
		$this->apiCaller->setAuthorizationCode($authorizationCode);

		parent::update();
	}
}
