<?php

namespace Biobanques\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontendControllerTest extends WebTestCase
{

    /**
     *
     * @return Collection
     */
    public function getCollection() {

        return $this->getContainer()->get('mongo')->getCollection('user');
    }

    public function testLogin() {
        $client = static::createClient([], ['HTTP_HOST' => 'qualityform_v2.local']);
        $client->followRedirects(true);

        $crawler = $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('#username')->count());
        $this->assertGreaterThan(0, $crawler->filter('#password')->count());
    }

}