<?php

namespace App\Service\Schedule;

use DateTime;

use Symfony\Component\HttpFoundation\Request;


class GetHoursInInterval
{
    public function __construct ()
    {
       
    }
    public function __invoke(
       DateTime $startHour, DateTime $endHour,
    ): array {
        $hours = [];
        $hour = $startHour;
            while ($hour <= $endHour){
                $hours[] = $hour->format('H:i');
                $hour = $startHour->add(\DateInterval::createFromDateString('1 hours'));
            }

        return $hours;
    }

   
}
