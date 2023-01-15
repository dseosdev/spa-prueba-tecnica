<?php

namespace App\Service\SpaServices;

use DateTime;
use DateInterval;
use App\Entity\Booking;
use App\Entity\Schedule;
use App\Entity\SpaService;
use App\Repository\BookingRepositoryInterface;
use App\Repository\ScheduleRepositoryInterface;
use App\Repository\SpaServiceRepositoryInterface;
use App\Service\Schedule\GetHoursInInterval;
use Symfony\Component\HttpFoundation\Request;



class GetSpaServiceAvailability
{
    public function __construct (
        private BookingRepositoryInterface $bookingRepository, 
        private SpaServiceRepositoryInterface $spaServiceRepository, 
        private ScheduleRepositoryInterface $scheduleRepository,
        private GetHoursInInterval $getHoursInInterval)
        {

        }
    public function __invoke(
        dateTime $day, SpaService $spaService
    ): array {
        $hoursAvailables=[];

        $schedules = $this->scheduleRepository->getSchedulesByDate($day,$spaService);
        foreach ($schedules as $schedule){
            $hoursAvailables = $this->getHoursInInterval->__invoke($schedule->getStartHour(),$schedule->getEndHour());
        }

        foreach ($hoursAvailables as $hour){
            $reserved = $this->bookingRepository->isReserved($spaService,$day,new DateTime($hour));
            if ($reserved){
                $hoursAvailables = $this->removeHour($hour, $hoursAvailables);
            }
        }

        return $hoursAvailables;
    }

    private function removeHour(string $hour, array $hoursAvailables):array {
        $key = array_search($hour, $hoursAvailables);
        if (false !== $key) {
            unset($hoursAvailables[$key]);
        }
        return $hoursAvailables;
    }

   
}
