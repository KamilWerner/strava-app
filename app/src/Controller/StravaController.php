<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ApiCaller\InvalidResponseStatusException;
use App\Service\Strava\ActivitiesFetcher;
use App\Service\Strava\Integrator;
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
	 * @param Request    $request
	 * @param Integrator $integrator
	 *
	 * @return RedirectResponse
	 */
	public function exchangeTokenAction(Request $request, Integrator $integrator): RedirectResponse
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

		try {
			$integrator->integrate($request->query->get('code'));
		} catch (InvalidResponseStatusException $e) {
			$this->addError('Invalid response from Strava… try again later!');

			return $this->redirectToRoute('homepage');
		}

		$this->addNotice('Successfully integrated with Strava!');

		return $this->redirectToRoute('homepage');
	}

	/**
	 * @Route("/strava/fetch_activities", name="strava_fetch_activities")
	 *
	 * @param ActivitiesFetcher $activitiesFetcher
	 *
	 * @return RedirectResponse
	 */
	public function fetchActivitiesAction(ActivitiesFetcher $activitiesFetcher): RedirectResponse
	{
		if (!$this->getUser()->getStravaIntegration()->isIntegrated()) {
			$this->addError('You need to integrate with Strava first!');

			return $this->redirectToRoute('homepage');
		}

		try {
			$fetchedActivitiesCount = $activitiesFetcher->fetch();
		} catch (InvalidResponseStatusException $e) {
			$this->addError('Invalid response from Strava… try again later!');

			return $this->redirectToRoute('homepage');
		}

		$this->addNotice(
			$fetchedActivitiesCount
				? 'Successfully fetched '.$fetchedActivitiesCount.' new routes!'
				: 'There are no new routes!'
		);

		return $this->redirectToRoute('user_routes', ['id' => $this->getUser()->getId()]);
	}
}
