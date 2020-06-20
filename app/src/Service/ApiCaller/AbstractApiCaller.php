<?php

declare(strict_types=1);

namespace App\Service\ApiCaller;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractApiCaller
{
	protected const REQUEST_METHOD_GET = 'GET';
	protected const REQUEST_METHOD_POST = 'POST';

	/**
	 * @var HttpClientInterface
	 */
	private $client;

	public function __construct(HttpClientInterface $client)
	{
		$this->client = $client;
	}

	public function call(): ResponseInterface
	{
		return $this->client->request(
			$this->getMethod(),
			$this->getUrl(),
			$this->getOptions()
		);
	}

	protected abstract function getMethod(): string;

	protected abstract function getUrl(): string;

	protected abstract function getOptions(): array;
}
