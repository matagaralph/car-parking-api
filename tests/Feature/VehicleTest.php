<?php

use App\Models\User;
use App\Models\Vehicle;

test('users can get their own vehicles.', function () {
    $john = User::factory()->create();
    $vehicleForJohn = Vehicle::factory()->create([
        'user_id' => $john->id
    ]);

    $adam = User::factory()->create();
    $vehicleForAdam = Vehicle::factory()->create([
        'user_id' => $adam->id
    ]);

    $response = $this->actingAs($john)->getJson('/api/v1/vehicles');

    $response->assertStatus(200)
        ->assertJsonStructure(['data'])
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.plate_number', $vehicleForJohn->plate_number)
        ->assertJsonMissing($vehicleForAdam->toArray());
});

test('users can create vehicles.', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/v1/vehicles', [
        'plate_number' => 'AAA111',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure(['data'])
        ->assertJsonCount(2, 'data')
        ->assertJsonStructure([
            'data' => ['0' => 'plate_number'],
        ])
        ->assertJsonPath('data.plate_number', 'AAA111');

    $this->assertDatabaseHas('vehicles', [
        'plate_number' => 'AAA111',
    ]);
});

test('users can update their vehicles.', function () {
    $user = User::factory()->create();
    $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->putJson('/api/v1/vehicles/' . $vehicle->id, [
        'plate_number' => 'AAA123',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['plate_number'])
        ->assertJsonPath('plate_number', 'AAA123');

    $this->assertDatabaseHas('vehicles', [
        'plate_number' => 'AAA123',
    ]);
});

test('users can delete vehicles.', closure: function () {
    $user = User::factory()->create();
    $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->deleteJson('/api/v1/vehicles/' . $vehicle->id);

    $response->assertNoContent();

    $this->assertDatabaseMissing('vehicles', [
        'id' => $vehicle->id,
        'deleted_at' => NULL
    ])->assertDatabaseCount('vehicles', 1); // we have SoftDeletes, remember?
});
