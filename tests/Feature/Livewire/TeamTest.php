<?php

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->seed(PermissionSeeder::class);

    $this->team = Team::create([
        'name' => 'example-team',
        'display_name' => 'example team',
    ]);

    $this->teams = $this->team;

    $this->user = User::factory()->create();
    $this->user->teams()->attach($this->team);
    $this->user->addRole('admin');

    actingAs($this->user);
});

it('has team page', function () {
    $this->withoutVite();

    $response = $this->get(route('teams'));

    $response->assertStatus(200);

    $response->assertSeeLivewire('team');
});

it('shows team menu only to authorized users', function () {
    $this->withoutVite();

    $this->get(route('home'))->assertSee('Teams');

    $this->user->removeRole('admin');
    $this->get(route('home'))->assertDontSee('Teams');

    $this->user->addRole('admin', $this->team);
    $this->get(route('home'))->assertSee('Teams');
});

it('can see every team', function () {
    $this->user->removeRole('admin');
    $this->assertFalse($this->user->can('viewEvery', Team::class));

    $this->user->addRole('admin');
    $this->assertTrue($this->user->can('viewEvery', Team::class));
});

it('needs authorization to create a team', function () {
    $this->role = Role::find(1);
    $this->role->removePermission('team.create');

    Livewire::test('team')
        ->call('create')
        ->assertForbidden();
});

it('needs authorization to edit a team', function () {
    $this->role = Role::find(1);
    $this->role->removePermission('team.update');

    Livewire::test('team')
        ->call('edit')
        ->assertForbidden();
});

it('has validations', function () {
    Livewire::test('team')
        ->set('editing.name', '')
        ->set('editing.display_name', '')
        ->assertHasErrors([
            'editing.name',
            'editing.display_name',
        ]);
});

it('needs a unique team name', function () {
    Livewire::test('team')
        ->set('editing.name', 'example-team')
        ->set('editing.display_name', 'example team')
        ->assertHasErrors([
            'editing.name',
            'editing.display_name',
        ]);
});
