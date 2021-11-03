<?php

namespace App\Tests\Api\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{
    public function testCreateBookInvalidData(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        /*The full signature of the request() method is:
         * request(
            $method,
            $uri,
            array $parameters = [],
            array $files = [],
            array $server = [],
            $content = null,
            $changeHistory = true
        )*/
        $client = static::createClient();

        /*$client->request(
            'POST',
            '/submit',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"name":"Fabien"}'
        );*/

        // Request a specific page
//        $crawler = $client->request('POST', '/api/save_books',[],[],['Content-Type'=>'application/json'],'{"title":""}');
        $client->request('POST', '/api/save_books',[],[],['CONTENT_TYPE' => 'application/json'],'{"name":""}');
        /*$client->request(
                    'POST',
                    '/api/save_books',
                    [],
                    [],
                    ['CONTENT_TYPE' => 'application/json'],
                    '{"name":"Fabien"}'
                );*/
        // Validate a successful response and some content
//        $this->assertResponseIsSuccessful();
//        $this->assertSelectorTextContains('h1', 'Hello World');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }


    public function testCreateBookEmptyData(): void
    {
        $client = static::createClient();
        // Request a specific page
        $crawler = $client->request('POST', '/api/save_books',[],[],['Content-Type'=>'application/json'],'');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testCreateBookSuccess(): void
    {
        $client = static::createClient();
        // Request a specific page
        $client->request('POST', '/api/save_books',[],[],['CONTENT_TYPE' => 'application/json'],'{"title":"Papu for the papu"}');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
