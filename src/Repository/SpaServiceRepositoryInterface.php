<?php

namespace App\Repository;

use App\Entity\SpaService;
use DateTime;

interface SpaServiceRepositoryInterface 
{

    public function save(SpaService $entity, bool $flush = false): void;

    public function remove(SpaService $entity, bool $flush = false): void;

    public function getAllServicesWithLocale(string $locale = 'es'): array;

}
