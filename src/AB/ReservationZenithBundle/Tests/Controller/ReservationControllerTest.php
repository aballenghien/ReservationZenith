<?php

namespace AB\ReservationZenithBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservationControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/reservation/index');
    }

    public function testAjouter()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/reservation/ajouter');
    }

    public function testVoir()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/reservation/voir/{id}');
    }

    public function testModifier()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/reservation/modifier/{id}');
    }

    public function testSupprimer()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/reservation/supprimer/{id}');
    }

}
