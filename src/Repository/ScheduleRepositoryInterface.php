<?php

namespace App\Repository;

use App\Entity\Schedule;
use App\Entity\SpaService;
use DateTime;

interface ScheduleRepositoryInterface 
{

    public function save(Schedule $entity, bool $flush = false): void;

    public function remove(Schedule $entity, bool $flush = false): void;

    public function getSchedulesByDate(DateTime $day, SpaService $spaService): ?array;

}
