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

namespace App\Console\Commands;

use Artisan;
use Cache;
use Codedge\Updater\UpdaterManager;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SelfUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updater:self-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update courservio, if there is a newer version.';

    protected UpdaterManager $updater;

    public function __construct(UpdaterManager $updater)
    {
        parent::__construct();
        $this->updater = $updater;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // We can’t update if .git folder still exists.
        if (File::exists(base_path('.git'))) {
            $this->warn('The .git folder exists. You have to delete it before using the self-update function!');

            return \Symfony\Component\Console\Command\Command::FAILURE;
        }

        $latest_version = Cache::remember('latest_version', 15, function () {
            return $this->updater->source()->getVersionAvailable();
        });

        if (
            ! $latest_version
            || ! version_compare($latest_version, config('self-update.version_installed'), '>')
        ) {
            $this->comment('There\'s no new version available.');

            return \Symfony\Component\Console\Command\Command::SUCCESS;
        }

        try {
            // Create a release
            $release = $this->updater->source()->fetch($latest_version);

            // Run the update process
            $update = $this->updater->source()->update($release);
        } catch (Exception $exception) {
            report($exception);

            return \Symfony\Component\Console\Command\Command::FAILURE;
        }

        if (! $update) {
            $this->warn('Update failed!');

            return \Symfony\Component\Console\Command\Command::FAILURE;
        }

        shell_exec('composer install &>/dev/null');
        shell_exec('npm install &>/dev/null');
        shell_exec('npm run build &>/dev/null');

        $migrate = Artisan::call('migrate', [
            '--force' => true,
        ]);

        if ($migrate) {
            $this->warn('Migration failed!');

            return \Symfony\Component\Console\Command\Command::FAILURE;
        }

        // Set the new installed version
        $keyPairs = [
            'SELF_UPDATER_VERSION_INSTALLED' => $latest_version,
        ];
        saveArrayToEnv($keyPairs);

        // Restart the worker
        $worker_restart = shell_exec('/usr/bin/supervisorctl restart all');

        if (! $worker_restart) {
            $this->warn('Updated successfully but couldn\'t restart the workers');

            return \Symfony\Component\Console\Command\Command::FAILURE;
        }

        $this->info('Updated successfully.');

        return \Symfony\Component\Console\Command\Command::SUCCESS;
    }
}
