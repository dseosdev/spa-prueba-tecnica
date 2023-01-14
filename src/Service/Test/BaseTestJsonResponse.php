<?php

namespace App\Service\Test;

use App\DataFixtures\AppFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BaseTestJsonResponse extends WebTestCase
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

    public function testWrongLocaleRequestSuccess()
    {
        $this->jsonResponseTestBase('/api/v1/spa-services/hgh', '{"Error:":"Locale not available"}','GET',400);
    
    }


    protected function jsonResponseTestBase(string $url, string $jsonExpected, string $method ="GET" , int $expectedHttpCode = 200, string $requestBody = ""): void
    {
       
        $crawler = $this->client->request(
            $method,
            $url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $requestBody
        );
        $response = $this->client->getResponse();
        $this->assertSame($expectedHttpCode, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'));
        $this->assertJson($response->getContent());

        $this->assertJsonStringEqualsJsonString(
            html_entity_decode($response->getContent()),
            html_entity_decode($jsonExpected)
        );
    }

    

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}