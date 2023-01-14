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

class CreateBookingController extends BaseTestJsonResponse
{


    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCreateBookingSuccess()
    {
       $requestBody = '
{
    "customer_name": "Juan Gonzalez",
    "customer_email": "juangonzalez@email.com",
    "day": "2023-01-01",
    "hour": "10:00",
    "spa_service": 1
}
';
    $expectedJsonResponse='{"Message":"Booking Created Successfully"}';
    
    $this->jsonResponseTestBase(
        '/api/v1/create-booking', 
        $expectedJsonResponse,
        'POST',
        200,
        $requestBody);
    
    $expectedJsonResponse='{"Error":"SPA Service not available"}';    
    $this->jsonResponseTestBase(
        '/api/v1/create-booking', 
        $expectedJsonResponse,
        'POST',
        400,
        $requestBody);
    
    }


    public function testCreateBookingWithOutCustomerName()
    {
       $requestBody = '
{
    "customer_name": "",
    "customer_email": "juangonzalez@email.com",
    "day": "2023-01-01",
    "hour": "10:00",
    "spa_service": 1
}
';
    $expectedJsonResponse='{"Error":"customerName:This value should not be blank. customerName:This value is too short. It should have 3 characters or more. "}';
    $this->jsonResponseTestBase(
        '/api/v1/create-booking', 
        $expectedJsonResponse,
        'POST',
        400,
        $requestBody);
    }


    public function testCreateBookingWithOutCustomerEmail()
    {
       $requestBody = '
{
    "customer_name": "Juan Gonzalez",
    "customer_email": "",
    "day": "2023-01-01",
    "hour": "10:00",
    "spa_service": 1
}
';
    $expectedJsonResponse='{"Error":"customerEmail:This value should not be blank. "}';
    $this->jsonResponseTestBase(
        '/api/v1/create-booking', 
        $expectedJsonResponse,
        'POST',
        400,
        $requestBody);
    }


    public function testCreateBookingWithWrongCustomerEmail()
    {
       $requestBody = '
{
    "customer_name": "Juan Gonzalez",
    "customer_email": "email_not_valid",
    "day": "2023-01-01",
    "hour": "10:00",
    "spa_service": 1
}
';
    $expectedJsonResponse='{"Error":"customerEmail:This value is not a valid email address. "}';
    $this->jsonResponseTestBase(
        '/api/v1/create-booking', 
        $expectedJsonResponse,
        'POST',
        400,
        $requestBody);
    }

    public function testCreateBookingWithWrongSpaService()
    {
       $requestBody = '
{
    "customer_name": "Juan Gonzalez",
    "customer_email": "juangonzalez@email.com",
    "day": "2023-01-01",
    "hour": "10:00",
    "spa_service": 1000
}
';
    $expectedJsonResponse='{"Error":"SPA Service not available"}';
    $this->jsonResponseTestBase(
        '/api/v1/create-booking', 
        $expectedJsonResponse,
        'POST',
        400,
        $requestBody);
    }

    public function testCreateBookingWithOutSpaServiceAvailability()
    {
       $requestBody = '
{
    "customer_name": "Juan Gonzalez",
    "customer_email": "juangonzalez@email.com",
    "day": "2023-01-01",
    "hour": "05:00",
    "spa_service": 1
}
';
    $expectedJsonResponse='{"Error":"SPA Service not available"}';
    $this->jsonResponseTestBase(
        '/api/v1/create-booking', 
        $expectedJsonResponse,
        'POST',
        400,
        $requestBody);
    }

}