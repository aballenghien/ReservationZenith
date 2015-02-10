<?php

namespace AB\ReservationZenithBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TarifControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/index');
    }

    public function testAjouter()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ajouter');
    }

    public function testVoir()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tarif/voir/{id}');
    }

    public function testModifier()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tarif/modifier/{id}');
    }

    public function testSupprimer()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tarif/supprimer/{id}');
    }

}
