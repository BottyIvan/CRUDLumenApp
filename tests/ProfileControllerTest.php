<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ProfileControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateProfile()
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

    public function testShowAll()
    {
        // Effettua una richiesta GET all'endpoint /show/all
        $response = $this->json('GET', '/show/all');

        // Verifica che lo status della risposta sia 200
        $response->seeStatusCode(200);

        // Decodifica la risposta JSON in un array
        $responseData = json_decode($response->response->getContent(), true);

        // Verifica che la risposta sia decodificata correttamente
        $this->assertIsArray($responseData, 'Response data is not an array');

        // Verifica la struttura della risposta
        $this->assertNotEmpty($responseData, 'Response data is empty');
        foreach ($responseData as $profile) {
            $this->assertArrayHasKey('id', $profile);
            $this->assertArrayHasKey('nome', $profile);
            $this->assertArrayHasKey('cognome', $profile);
            $this->assertArrayHasKey('attribute', $profile);
            $this->assertIsArray($profile['attribute'], 'Attribute is not an array');
            foreach ($profile['attribute'] as $attribute) {
                $this->assertArrayHasKey('id', $attribute);
                $this->assertArrayHasKey('profile_id', $attribute);
                $this->assertArrayHasKey('attribute', $attribute);
            }
        }
    }

    public function testShowProfile()
    {
        $profileId = 2;

        $response = $this->json('GET', "/profile/show/{$profileId}");
        $response->seeStatusCode(200);

        $responseData = json_decode($response->response->getContent(), true);
        $this->assertIsArray($responseData, 'Response data is not an array');
        $this->assertArrayHasKey('id', $responseData);
        $this->assertArrayHasKey('nome', $responseData);
        $this->assertArrayHasKey('cognome', $responseData);
    }

    public function testUpdateProfile()
    {
        $profileId = 2;

        $data = [
            'nome' => 'Mario',
            'cognome' => 'Rossi',
            'telefono' => rand(10000000, 9999999999)
        ];

        $response = $this->json('PUT', "/profile/update/{$profileId}", $data, ['Authorization' => 'Bearer Lumen']);
        $response->seeStatusCode(200);

        $responseData = json_decode($response->response->getContent(), true);
        $this->assertIsArray($responseData, 'Response data is not an array');
        $this->assertArrayHasKey('id', $responseData);
        $this->assertArrayHasKey('nome', $responseData);
        $this->assertArrayHasKey('cognome', $responseData);
    }

    public function testDeleteProfile()
    {
        $profileId = 2;

        $response = $this->json('DELETE', "/profile/delete/{$profileId}", [], ['Authorization' => 'Bearer Lumen']);
        $response->seeStatusCode(200);

        $responseData = json_decode($response->response->getContent(), true);
        $this->assertIsArray($responseData, 'Response data is not an array');
        $this->assertArrayHasKey('success', $responseData);
        $this->assertEquals('Profile deleted successfully', $responseData['success']);
    }
}
