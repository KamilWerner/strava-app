<?php

declare(strict_types=1);

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class HomepageController extends AbstractController
{
	/**
	 * @Route("/", name="homepage")
	 * @Template
	 *
	 * @return array
	 */
	public function showAction(): array
	{
		return [];
	}
}
