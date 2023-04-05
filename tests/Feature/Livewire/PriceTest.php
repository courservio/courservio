<?php

use App\Http\Livewire\Price;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);

//    $this->team = Team::create([
//        'name' => 'example-team',
//        'display_name' => 'example team',
//    ]);
//
//    $this->teams = $this->team;

    $this->user = User::factory()->create();
//    $this->user->teams()->attach($this->team);
//    $this->user->addRole('admin');

    actingAs($this->user);
});

it('can render the component', function () {
    $this->user->addRole('admin');

    $component = Livewire::test(Price::class);

    $component->assertStatus(200);
});

it('has price page which needs to be logged in and authorized', function () {
    $this->withoutVite();

    $response = $this->get(route('prices'));
    $response->assertForbidden();

    $this->user->givePermission('price.create');

    $response = $this->get(route('prices'));
    $response->assertStatus(200);
    $response->assertSeeLivewire('price');

    $this->user->removePermission('price.create');
    $this->user->givePermission('price.update');

    $response = $this->get(route('prices'));
    $response->assertStatus(200);
    $response->assertSeeLivewire('price');

    auth()->logout($this->user);
    $response = $this->get(route('roles'));
    $response->assertRedirect(route('login'));
});

it('shows price menu only to authorized users', function () {
    $this->withoutVite();

    $this->get(route('home'))->assertDontSee(_i('Prices'));

    $this->user->givePermission('price.create');

    $this->get(route('home'))->assertSee(_i('Prices'));
});

it('needs authorization to create a price', function () {
    $this->user->givePermission('price.create');

    Livewire::test('price')
        ->call('create')
        ->assertSuccessful();

    $this->user->removePermission('price.create');
    $this->user->givePermission('price.update'); // 'placeholder' to avoid fingerprint error

    Livewire::test('price')
        ->call('create')
        ->assertForbidden();
});
