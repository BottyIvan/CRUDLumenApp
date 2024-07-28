<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ProfileAttributeControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testCreateProfileAttributes()
    {
        $profileId = 1;

        $data = [
            'attribute' => 'DEMOOOOO'
        ];

        $response = $this->json('POST', "/profile/{$profileId}/attributes/create", $data, ['Authorization' => 'Bearer Lumen']);
        $response->seeStatusCode(201);

        $responseData = json_decode($response->response->getContent(), true);
        $this->assertIsArray($responseData, 'Response data is not an array');
        $this->assertArrayHasKey('id', $responseData);
        $this->assertArrayHasKey('profile_id', $responseData);
        $this->assertArrayHasKey('attribute', $responseData);
    }

    public function testShowProfileAttributes()
    {
        $profileId = 1;

        $response = $this->json('GET', "/profile/{$profileId}/attributes/");
        $response->seeStatusCode(200);

        $responseData = json_decode($response->response->getContent(), true);
        $this->assertIsArray($responseData, 'Response data is not an array');
        foreach ($responseData as $attribute) {
            $this->assertArrayHasKey('id', $attribute);
            $this->assertArrayHasKey('profile_id', $attribute);
            $this->assertArrayHasKey('attribute', $attribute);
        }
    }

    public function testUpdateProfileAttributes()
    {
        $id = 2;
        $profileId = 1;

        $data = [
            'attribute' => 'DEMOOOOO'
        ];

        $response = $this->json('PUT', "/profile/{$profileId}/attributes/update/{$id}", $data, ['Authorization' => 'Bearer Lumen']);
        $response->seeStatusCode(200);

        $responseData = json_decode($response->response->getContent(), true);
        $this->assertIsArray($responseData, 'Response data is not an array');
        $this->assertArrayHasKey('id', $responseData);
        $this->assertArrayHasKey('profile_id', $responseData);
        $this->assertArrayHasKey('attribute', $responseData);
    }

    public function testDeleteProfileAttributes()
    {
        $id = 2;
        $profileId = 1;

        $response = $this->json('DELETE', "/profile/{$profileId}/attributes/delete/{$id}", [], ['Authorization' => 'Bearer Lumen']);
        $response->seeStatusCode(200);

        $responseData = json_decode($response->response->getContent(), true);
        $this->assertIsArray($responseData, 'Response data is not an array');
        $this->assertArrayHasKey('success', $responseData);
        $this->assertEquals('Profile Attribute deleted successfully', $responseData['success']);
    }
}
