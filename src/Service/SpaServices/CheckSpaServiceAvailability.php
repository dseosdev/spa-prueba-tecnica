<?php

namespace App\Service\SpaServices;

use DateTime;
use DateInterval;

use App\Entity\SpaService;

use App\Service\SpaServices\GetSpaServiceAvailability;



class CheckSpaServiceAvailability
{
    public function __construct (
        private GetSpaServiceAvailability $getSpaServiceAvailability)
        {

        }
    public function __invoke(
        dateTime $day, dateTime $hour,  SpaService $spaService
    ): bool {
        $hoursAvailables = $this->getSpaServiceAvailability->__invoke($day,$spaService);
        
        if (in_array($hour->format("H:i"),$hoursAvailables)){
            return true;
        }

        return false;
    }

   
   

   
}
