<?php

use App\Models\User;

test('users can authenticate with correct credentials', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/v1/auth/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(200);
});

test('users cannot authenticate with incorrect credentials', function () {
    $user = User::factory()->create();
    $response = $this->postJson('/api/v1/auth/login', [
        'email' => $user->email,
        'password' => 'wrong_password',
    ]);

    $this->assertGuest();
    $response->assertStatus(422);

});

test('users can register', function () {
    $response = $this->postJson('/api/v1/auth/register', [
        'name'                  => 'John Doe',
        'email'                 => 'john@example.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'access_token',
        ]);

    $this->assertDatabaseHas('users', [
        'name'  => 'John Doe',
        'email' => 'john@example.com',
    ]);
});

test('users cannot register with incorrect payload', function () {
    $response = $this->postJson('/api/v1/auth/register', [
        'name'                  => 'John Doe',
        'email'                 => 'john@example.com',
        'password'              => 'password',
        'password_confirmation' => 'wrong_password',
    ]);

    $response->assertStatus(422);

    $this->assertDatabaseMissing('users', [
        'name'  => 'John Doe',
        'email' => 'john@example.com',
    ]);
});
