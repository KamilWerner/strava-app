<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ApiCaller\InvalidResponseStatusException;
use App\Service\Strava\ExchangeTokenApiCaller;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class StravaController extends AbstractController
{
	private const SCOPE = 'read,activity:read';

	/**
	 * @Route("/strava/exchange_token")
	 *
	 * @param Request                $request
	 * @param ExchangeTokenApiCaller $apiCaller
	 *
	 * @return RedirectResponse
	 */
	public function exchangeTokenAction(Request $request, ExchangeTokenApiCaller $apiCaller): RedirectResponse
	{
		if ($this->getUser()->getStravaIntegration()->isIntegrated()) {
			$this->addError('You are already integrated with Strava!');

			return $this->redirectToRoute('homepage');
		}

		if ($request->query->has('error')) {
			$this->addError('Error occured when integrating with Strava… try again later');

			return $this->redirectToRoute('homepage');
		}

		if (!$request->query->has('scope') || !$request->query->has('code')) {
			$this->addError('Request does not provide all necessary values!');

			return $this->redirectToRoute('homepage');
		}

		if (self::SCOPE !== $request->query->get('scope')) {
			$this->addError('You need to accept all options during Strava authorization!');

			return $this->redirectToRoute('homepage');
		}

		$apiCaller->setAuthorizationCode($request->query->get('code'));

		try {
			$response = $apiCaller->call();
		} catch (InvalidResponseStatusException $e) {
			$this->addError('Invalid response from Strava… try again later!');

			return $this->redirectToRoute('homepage');
		}

		$responseData = $response->toArray();

		$user = $this->getUser();
		$user->getStravaIntegration()->setAccessToken($responseData['access_token']);
		$user->getStravaIntegration()->setAccessTokenExpiresAt(new DateTime('@'.$responseData['expires_at']));
		$user->getStravaIntegration()->setRefreshToken($responseData['refresh_token']);
		$user->getStravaAthlete()->setId((int) $responseData['athlete']['id']);
		$user->getStravaAthlete()->setThumbUrl($responseData['athlete']['profile']);

		$this->getDoctrine()->getManager()->flush();

		$this->addNotice('Successfully integrated with Strava!');

		return $this->redirectToRoute('homepage');
	}
}
