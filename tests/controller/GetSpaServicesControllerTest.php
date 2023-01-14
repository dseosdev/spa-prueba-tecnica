<?php

namespace App\Tests\Controller;

use App\DataFixtures\AppFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use App\Service\Test\BaseTestJsonResponse;

class GetSpaServicesControllerTest extends BaseTestJsonResponse
{


    public function testSpaServiceSuccessServiceId1()
    {
        $this->jsonResponseTestBase(
            '/api/v1/spa-service-availability/1/2023-01-01', 
            '["10:00","11:00","12:00","13:00"]',
            'GET',
            200);
       
    }

    public function testSpaServiceSuccessServiceId2()
    {
        $this->jsonResponseTestBase(
            '/api/v1/spa-service-availability/2/2023-01-01', 
            '["09:00","10:00","11:00","12:00","13:00","14:00"]',
            'GET',
            200);
    }


   
}