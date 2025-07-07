<?php

test('users can get all the zones.', function () {
    $response = $this->getJson('/api/v1/zones');
    $response->assertStatus(200)
        ->assertJsonStructure(['data'])
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure(['data' => [
            ['*' => 'id', 'name', 'price_per_hour'],
        ]])
        ->assertJsonPath('data.0.id', 1)
        ->assertJsonPath('data.0.name', 'Kwame Mall')
        ->assertJsonPath('data.0.price_per_hour', 100);
});
