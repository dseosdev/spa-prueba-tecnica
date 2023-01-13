<?php

namespace App\Controller;

use DateTime;
use App\Entity\SpaService;
use App\Service\Booking\CreateBooking;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\SpaServices\GetSpaServiceAvailability;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class GetSpaServiceAvailabilityController extends AbstractController
{
    public function __construct (
        private GetSpaServiceAvailability $getSpaServiceAvailability
        ){

    }


    #[Route('/api/v1/spa-service-availability/{spaService}/{day}', name: 'app_spa_services_availability')]
    public function index(
        SpaService $spaService = null,
        DateTime $day = null
    ): JsonResponse
    {
        if ($spaService === null){
            $response = ['Error:' => 'Spa Service does not exist'];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST );
        }

        if ($day === null){
            $response = ['Error:' => 'Day is not a valid Date'];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST );
        }

        $hoursAvailables = $this->getSpaServiceAvailability->__invoke($day,$spaService);

        return new JsonResponse($hoursAvailables, Response::HTTP_OK);
    }

  }