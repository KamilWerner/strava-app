<?php

declare(strict_types=1);

namespace App\Controller;

abstract class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
	private const NOTICE_MESSAGE_TYPE = 'notice';
	private const WARNING_MESSAGE_TYPE = 'warning';
	private const ERROR_MESSAGE_TYPE = 'error';

	protected function addNotice(string $message): void
	{
		$this->addFlash(self::NOTICE_MESSAGE_TYPE, $message);
	}

	protected function addWarning(string $message): void
	{
		$this->addFlash(self::WARNING_MESSAGE_TYPE, $message);
	}

	protected function addError(string $message): void
	{
		$this->addFlash(self::ERROR_MESSAGE_TYPE, $message);
	}
}
