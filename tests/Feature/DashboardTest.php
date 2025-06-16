<?php

use App\Models\User;
use Database\Seeders\StatusSeeder;

beforeEach(function () {
    \Pest\Laravel\seed(StatusSeeder::class);;
});
test('guests are redirected to the login page', function () {
    $response = $this->get('/dashboard');
    $response->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/dashboard');
    $response->assertStatus(200);
});
