<?php

/**
 * Copyright 2023 courservio.de
 *
 * Licensed under the EUPL, Version 1.2 or – as soon they
 * will be approved by the European Commission - subsequent
 * versions of the EUPL (the "Licence");
 * You may not use this work except in compliance with the
 * Licence.
 * You may obtain a copy of the Licence at:
 *
 * https://joinup.ec.europa.eu/software/page/eupl
 *
 * Unless required by applicable law or agreed to in
 * writing, software distributed under the Licence is
 * distributed on an "AS IS" basis,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied.
 * See the Licence for the specific language governing
 * permissions and limitations under the Licence.
 */

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Events\GeoDataUpdated;
use App\Models\User;
use Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Prevplan\HeartbeatStatus\Http\Controllers\HeartbeatStatusController;

class Setup extends Component
{
    public string $name = '';

    public string $email = '';

    public string $update_type = 'release';

    public bool $heartbeat = false;

    protected array $rules = [
        'name' => 'required',
        'email' => 'required|email',
    ];

    public function register()
    {
        $this->validate();

        abort_unless($this->email === config('app.owner'), 401);

        // Check (again) if a user already exists
        $user = (new User())->first();
        abort_if(isset($user), 403);

        $keyPairs = [];
        if ($this->update_type === 'release') {
            $keyPairs = [
                'SELF_UPDATER_REPO_VENDOR' => 'courservio',
                'SELF_UPDATER_REPO_NAME' => 'courservio',
                'SELF_UPDATER_AUTO_UPDATE' => 'true', // It has to be a string and no boolean for the .env file
                'SELF_UPDATER_VERSION_INSTALLED' => 'v0.0.0',
                'SELF_UPDATER_USE_BRANCH' => '',
                'SELF_UPDATER_MAILTO_ADDRESS' => $this->email,
            ];
        }

        if ($this->update_type === 'commit') {
            $keyPairs = [
                'SELF_UPDATER_REPO_VENDOR' => 'courservio',
                'SELF_UPDATER_REPO_NAME' => 'courservio',
                'SELF_UPDATER_AUTO_UPDATE' => 'true', // It has to be a string and no boolean for the .env file
                'SELF_UPDATER_VERSION_INSTALLED' => '0000-00-00T00:00:00Z',
                'SELF_UPDATER_USE_BRANCH' => 'main',
                'SELF_UPDATER_MAILTO_ADDRESS' => $this->email,
            ];
        }

        if ($keyPairs) {
            // Set update settings and run update to actual version
            if (File::exists(base_path('.git'))) {
                File::deleteDirectory(base_path('.git'));
            }
            saveArrayToEnv($keyPairs);

            Artisan::call('updater:self-update');
        } else {
            // Deactivate self update
            $keyPairs = [
                'SELF_UPDATER_AUTO_UPDATE' => 'false',
            ];
            saveArrayToEnv($keyPairs);
        }

        // Reset and seed database
        $exitCode = Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);

        abort_unless(! $exitCode, 503);

        // Create user
        $user = (new User())->create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => '',
            'active' => 1,
        ]);

        $user->attachRole('admin');

        event(new GeoDataUpdated());

        $this->redirect(route('login'));
    }

    public function render()
    {
        abort_unless(config('app.owner'), 404);

        // Check if a user already exists
        $user = (new User())->first();
        abort_if(isset($user), 404);

        $response = Http::get(action([HeartbeatStatusController::class, 'html']));

        if ($response->ok()) {
            $this->heartbeat = true;
        }

        return view('livewire.setup')
            ->layout('layouts.auth', ['metaTitle' => 'Setup']);
    }
}
