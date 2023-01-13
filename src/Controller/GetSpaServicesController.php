<?php

namespace App\Controller;

use App\Service\SpaServices\GetSpaServices;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetSpaServicesController extends AbstractController
{

    #[Route('/api/v1/spa-services/{locale}', name: 'app_spa_services')]
    public function index(
        GetSpaServices $getSpaServices,
        $locale = 'es',
    ): JsonResponse
    {

        $localesAvailables=['es','en','de','fr'];

        if (!in_array($locale,$localesAvailables )){
            $response = ["Error:" => "Locale not available"];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }

        $spaServicesData = $getSpaServices->__invoke($locale);
        return new JsonResponse($spaServicesData, Response::HTTP_OK);
    }

  }