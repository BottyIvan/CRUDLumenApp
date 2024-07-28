<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BarerAurthTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testCheckBarerAuth()
    {
        $data = [
            'nome' => 'Mario',
            'cognome' => 'Rossi',
            'telefono' => rand(10000000, 9999999999)
        ];

        $response = $this->json('POST', '/profile/create', $data, ['Authorization' => 'Bearer Lumen']);
        $response->seeStatusCode(201);

        $responseData = json_decode($response->response->getContent(), true);
        $this->assertIsArray($responseData, 'Response data is not an array');
        $this->assertArrayHasKey('id', $responseData);
        $this->assertArrayHasKey('nome', $responseData);
        $this->assertArrayHasKey('cognome', $responseData);
    }

    public function testCheckBarerAuthFalseResult()
    {
        $data = [
            'nome' => 'Mario',
            'cognome' => 'Rossi',
            'telefono' => rand(10000000, 9999999999)
        ];

        $response = $this->json('POST', '/profile/create', $data, ['Authorization' => 'Bearer Lumen2']);
        $response->seeStatusCode(401);

        $responseData = json_decode($response->response->getContent(), true);
        $this->assertIsArray($responseData, 'Response data is not an array');
        $this->assertArrayHasKey('error', $responseData);
    }
}
