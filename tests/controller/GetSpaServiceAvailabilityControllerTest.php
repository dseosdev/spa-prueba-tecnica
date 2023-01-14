<?php

namespace App\Tests\Controller;

use App\DataFixtures\AppFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\Test\BaseTestJsonResponse;

class GetSpaServiceAvailabilityControllerTest extends BaseTestJsonResponse
{


    public function setUp(): void
    {
        parent::setUp();
        
    }

    public function testSpanishRequestSuccess()
    {
       
        $this->jsonResponseTestBase('/api/v1/spa-services/es', '[{"name":"Masaje de espalda","price":"30.00"},{"name":"Circuito Spa","price":"100.00"},{"name":"Ritual spa tailand\u00e9s","price":"120.00"}]','GET',200);
    }

    public function testEnglishRequestSuccess()
    {
        $this->jsonResponseTestBase('/api/v1/spa-services/en', '[{"name":"Back massage","price":"30.00"},{"name":"Spa circuit","price":"100.00"},{"name":"Ritual Thai Massage","price":"120.00"}]','GET',200);
   
         }


    public function testGermanRequestSuccess()
    {
        $this->jsonResponseTestBase('/api/v1/spa-services/de', '[{"name":"Antwort","price":"30.00"},{"name":"Spa-Zirkel","price":"100.00"},{"name":"Ritual Spa Thail","price":"120.00"}]','GET',200);
    }

    public function testFrenchRequestSuccess()
    {
        $this->jsonResponseTestBase('/api/v1/spa-services/fr', '[{"name":"Massage du dos","price":"30.00"},{"name":"Circuit thermal","price":"100.00"},{"name":"rituel spa tha\u00ef","price":"120.00"}]','GET',200);
    
    }


   
}