<?php

namespace App\Tests\Controller;

use App\DataFixtures\AppFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GetSpaServiceAvailabilityControllerTest extends WebTestCase
{

    protected AbstractDatabaseTool $databaseTool;
    protected EntityManagerInterface $entityManager;
    private $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadFixtures([
            AppFixtures::class
        ]);
        self::ensureKernelShutdown();
        $this->client = $this->createClient();
    }

    public function testSpanishRequestSuccess()
    {
       
        $crawler = $this->client->request('GET', '/api/v1/spa-services/es');

        $this->assertResponseIsSuccessful();

        $response = $this->client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $this->assertJsonStringEqualsJsonString(
            $response->getContent(),
            '[{"name":"Masaje de espalda","price":"30.00"},{"name":"Circuito Spa","price":"100.00"},{"name":"Ritual spa tailand\u00e9s","price":"120.00"}]'
        );
    }

    public function testEnglishRequestSuccess()
    {
   

        $crawler = $this->client->request('GET', '/api/v1/spa-services/en');

        $this->assertResponseIsSuccessful();

        $response = $this->client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $this->assertJsonStringEqualsJsonString(
            $response->getContent(),
            '[{"name":"Back massage","price":"30.00"},{"name":"Spa circuit","price":"100.00"},{"name":"Ritual Thai Massage","price":"120.00"}]'
        );
    }


    public function testGermanRequestSuccess()
    {

        $crawler = $this->client->request('GET', '/api/v1/spa-services/de');

        $this->assertResponseIsSuccessful();

        $response = $this->client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $this->assertJsonStringEqualsJsonString(
            $response->getContent(),
            '[{"name":"Antwort","price":"30.00"},{"name":"Spa-Zirkel","price":"100.00"},{"name":"Ritual Spa Thail","price":"120.00"}]'
        );
    }

    public function testFrenchRequestSuccess()
    {


        $crawler = $this->client->request('GET', '/api/v1/spa-services/fr');

        $this->assertResponseIsSuccessful();

        $response = $this->client->getResponse();
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $this->assertJsonStringEqualsJsonString(
            $response->getContent(),
            '[{"name":"Massage du dos","price":"30.00"},{"name":"Circuit thermal","price":"100.00"},{"name":"rituel spa tha\u00ef","price":"120.00"}]'
        );
    }


    public function testWrongLocaleRequestSuccess()
    {
        

        $crawler = $this->client->request('GET', '/api/v1/spa-services/hgh');

        $response = $this->client->getResponse();

        $this->assertSame(400, $response->getStatusCode());

        
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());


        $this->assertJsonStringEqualsJsonString(
            $response->getContent(),
            '{"Error:":"Locale not available"}'
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }

   
}