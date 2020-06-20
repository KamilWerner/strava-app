<?php

declare(strict_types=1);

namespace App\Service\ApiCaller;

use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class ResponseStatusValidatingAbstractApiCaller extends AbstractApiCaller
{
	private const HTTP_STATUS_OK = 200;

	public function call(): ResponseInterface
	{
		$response = parent::call();

		if (self::HTTP_STATUS_OK !== $response->getStatusCode()) {
			throw new InvalidResponseStatusException();
		}

		return $response;
	}
}
