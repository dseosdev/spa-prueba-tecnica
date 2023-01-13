<?php

namespace App\Controller;

use App\Service\Booking\CreateBooking;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\SpaServices\GetSpaServiceAvailability;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateBookingController extends AbstractController
{

    public function __construct(private CreateBooking $createBooking)
    {
        
    }

    #[Route('/api/v1/create-booking', name: 'app_create_booking' )]
    public function index(
        Request $request
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), false);
        $booking = $this->createBooking->__invoke($data);

        if ($booking["error"] !== false){
            return new JsonResponse(['Error'=>$booking["error"]], Response::HTTP_BAD_REQUEST );
        }
        
        return new JsonResponse((array)$booking["entity"], Response::HTTP_OK);
    }

  }