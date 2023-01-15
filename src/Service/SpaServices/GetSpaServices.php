<?php

namespace App\Service\SpaServices;

use App\Repository\SpaServiceRepositoryInterface;



class GetSpaServices
{
    public function __construct (private SpaServiceRepositoryInterface $spaServiceRepository){

    }
    public function __invoke(
        string $locale = 'es',
    ): array {

        $spaServices = $this->spaServiceRepository->getAllServicesWithLocale($locale);

        $spaServicesData = $this->getSpaServiceData($spaServices);

        return $spaServicesData;
    }

    private function getSpaServiceData(array $spaServices): array
    {
        $spaServicesData = [];
        foreach ($spaServices as $spaService) {
            $spaServicesData[] = ['name' => $spaService->getName(), 'price' => $spaService->getPrice()];
        }
        return $spaServicesData;
    }
}
