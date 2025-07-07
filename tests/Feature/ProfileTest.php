<?php

use App\Models\User;

test('users can get their profile', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->getJson('/api/v1/profile');

    $response->assertStatus(200)
        ->assertJsonStructure(['name', 'email'])
        ->assertJsonCount(2)
        ->assertJsonFragment(['name' => $user->name]);
});

test('users update their profile', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->putJson('/api/v1/profile', [
        'name' => 'John Updated',
        'email' => 'john_updated@example.com',
    ]);

    $response->assertStatus(202)
        ->assertJsonStructure(['name', 'email'])
        ->assertJsonCount(2)
        ->assertJsonFragment(['name' => 'John Updated']);

    $this->assertDatabaseHas('users', [
        'name' => 'John Updated',
        'email' => 'john_updated@example.com',
    ]);
});

test('users can change their password', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->putJson('/api/v1/password', [
        'current_password'      => 'password',
        'password'              => 'testing123',
    ]);

    $response->assertStatus(200);
});

