<?php

namespace App\Service\Booking;

use DateTime;
use stdClass;
use App\Entity\Booking;

use App\Repository\BookingRepositoryInterface;
use App\Repository\SpaServiceRepositoryInterface;
use App\Service\SpaServices\CheckSpaServiceAvailability;
use App\Validator\BookingValidator;

class CreateBooking
{
    public function __construct (
        private BookingRepositoryInterface $bookingRepository, 
        private SpaServiceRepositoryInterface $spaServiceRepository,
        private CheckSpaServiceAvailability $checkSpaServiceAvailability,
        private BookingValidator $bookingValidator
        ){

    }
    public function __invoke(
        stdClass $data,
    ) : array {
        $response = [];
        $response["error"] = false;
        $spaService = $this->spaServiceRepository->find($data->spa_service);
        if (!$spaService){
            $response["error"]="SPA Service not available";
            return $response;
        }
        $bookingData=[
            'customerName' => $data->customer_name,
            'customerEmail' => $data->customer_email,
            'day' => new DateTime($data->day),
            'hour' => new DateTime($data->hour),
            'spaService' => $spaService,
            'price' => $spaService->getPrice(),
        ];

        $spaServiceAvailable = $this->checkSpaServiceAvailability->__invoke($bookingData['day'],$bookingData['hour'],$spaService);
        
        if ($spaServiceAvailable){
            $bookingEntity = new Booking();
            $bookingEntity->setCustomerName($bookingData['customerName']);  
            $bookingEntity->setCustomerEmail($bookingData['customerEmail']);  
            $bookingEntity->setDay($bookingData['day']);  
            $bookingEntity->setHour($bookingData['hour']);
            $bookingEntity->setSpaService($bookingData['spaService']);
            $bookingEntity->setPrice($bookingData['price']);

            $validateResponse = $this->bookingValidator->validate($bookingEntity);
            if ($validateResponse === true){
                $booking = $this->bookingRepository->save($bookingEntity,true);
                $response["entity"] = $bookingEntity;
            }
            else{

                $response["error"] = $validateResponse;
            }

            
        }
        else{
            $response["error"]="SPA Service not available";
        }
        

        return $response;
    }

   
}
