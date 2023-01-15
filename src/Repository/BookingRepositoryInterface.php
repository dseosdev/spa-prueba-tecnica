<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Entity\SpaService;
use DateTime;

interface BookingRepositoryInterface 
{

    public function save(Booking $entity, bool $flush = false): void;

    public function remove(Booking $entity, bool $flush = false): void;

    public function isReserved(SpaService $spaService, DateTime $day , DateTime $hour ): bool;

}
