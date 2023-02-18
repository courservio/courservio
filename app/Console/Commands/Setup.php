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
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @throws FileNotFoundException
     */
    public function handle(): int
    {
        $mysql_values = shell_exec('my_print_defaults client');

        $explode = [];
        if ($mysql_values) {
            $explode = explode('=', $mysql_values);
        }

        $user = '';
        $password = '';
        $keyPairs = [];

        if (count($explode) === 4) {
            $user = substr($explode[2], 0, -11);
            $password = substr($explode[3], 0, -1);

            $keyPairs = [
                'DB_CONNECTION' => 'mysql',
                'DB_HOST' => '127.0.0.1',
                'DB_PORT' => '3306',
                'DB_DATABASE' => $user,
                'DB_USERNAME' => $user,
                'DB_PASSWORD' => $password,
            ];
        }

        if (! $user || ! $password) {
            $this->warn('No MySQL credentials found. No uberspace?');

            return Command::FAILURE;
        }

        if (! File::exists(base_path('.env'))) {
            File::copy(base_path('.env.example'), base_path('.env'));
            Artisan::call('key:generate');
        }

        $app = '';
        while (! $app) {
            $app = $this->ask('What is the Name of your company?');
        }

        $app_array = [
            'APP_NAME' => '"'.$app.'"',
            'APP_ENV' => 'production',
            'APP_DEBUG' => 'false',
            'QUEUE_CONNECTION' => 'database',
        ];

        $keyPairs = array_merge($keyPairs, $app_array);

        $this->info('getting domains ... please wait ...');

        $domains = shell_exec('uberspace web domain list');
        $explode_domains = array_filter(explode(PHP_EOL, $domains));

        $domain = $this->choice('What is the domain for courservio?', $explode_domains);

        $domain_array = [
            'APP_URL' => 'https://'.$domain,
        ];

        $keyPairs = array_merge($keyPairs, $domain_array);

        $qseh = $this->confirm('QSEH authorized entity?', false);

        if ($qseh) {
            while (true) {
                $qseh_number = $this->ask('What is your QSEH Number (Format X.XXXX)?');
                $qseh_password = '';

                $save_credentials = $this->confirm('Do you want to save the QSEH login password?', true);

                if ($save_credentials) {
                    $qseh_password = $this->secret('What is your QSEH Password? (Input won\'t shown)');
                }

                $regex = '/^\\d\\.\\d\\d\\d\\d$/i';
                $number_check = preg_match($regex, $qseh_number);

                if ($number_check) {
                    if (
                        str_starts_with($qseh_number, '0') ||
                        str_starts_with($qseh_number, '9')
                    ) {
                        $number_check = false;
                    }
                }

                if (! $number_check) {
                    $this->warn('The QSEH Number is in the wrong format!');
                }

                if ($save_credentials && ! $qseh_password) {
                    $this->warn('The password can\'t be saved if empty ...');
                }

                if ($number_check && ! $save_credentials) {
                    $qseh_array = [
                        'QSEH_CODENUMBER' => $qseh_number,
                        'QSEH_PASSWORD' => '',
                    ];
                }

                if ($number_check && $qseh_password) {
                    $qseh_array = [
                        'QSEH_CODENUMBER' => $qseh_number,
                        'QSEH_PASSWORD' => $qseh_password,
                    ];
                }

                if (isset($qseh_array)) {
                    $keyPairs = array_merge($keyPairs, $qseh_array);

                    break;
                }
            }
        }

        while (true) {
            $email = $this->ask('What is your e-mail address?');

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email_array = [
                    'OWNER_EMAIL' => $email,
                ];

                $keyPairs = array_merge($keyPairs, $email_array);

                break;
            }

            $this->warn('Please enter a valid e-mail address');
        }

        $smtp_server = $this->ask('SMTP server address?');
        $smtp_port = $this->ask('SMTP port?', '587');
        $smtp_user = $this->ask('SMTP user?');
        $smtp_password = $this->secret('SMTP password? (not shown)');
        $smtp_sender = $this->ask('From sender e-mail address?');

        $smtp_array = [
            'MAIL_MAILER' => 'smtp',
            'MAIL_HOST' => $smtp_server,
            'MAIL_PORT' => $smtp_port,
            'MAIL_USERNAME' => $smtp_user,
            'MAIL_PASSWORD' => $smtp_password,
            'MAIL_ENCRYPTION' => 'tls',
            'MAIL_FROM_ADDRESS' => $smtp_sender,
        ];

        $keyPairs = array_merge($keyPairs, $smtp_array);

        $hash_salt = Str::random(50);
        $hash_array = [
            'HASH_SALT' => $hash_salt,
        ];

        $keyPairs = array_merge($keyPairs, $hash_array);

        saveArrayToEnv($keyPairs);

        $install_services = $this->confirm('Should schedule and worker be installed and activated?');

        if ($install_services) {
            shell_exec('(crontab -l ; echo "* * * * * cd /var/www/virtual/'.$user.'/courservio && php artisan schedule:run >> /dev/null 2>&1") | crontab -');

            $worker = File::get(base_path('courservio-worker.ini'));

            $replaced = Str::replace('$USER', $user, $worker);
            File::put('/home/'.$user.'/etc/services.d/courservio-worker.ini', $replaced);

            //File::copy(base_path('courservio-worker.ini'), '/home/'.$user.'/etc/services.d/courservio-worker.ini');
            shell_exec('/usr/bin/supervisorctl reread');
            shell_exec('/usr/bin/supervisorctl update');
        }

        shell_exec('npm install');
        shell_exec('npm run build');

        if (File::exists('/var/www/virtual/'.$user.'/html/nocontent.html')) {
            File::delete('/var/www/virtual/'.$user.'/html/nocontent.html');
            File::deleteDirectory('/var/www/virtual/'.$user.'/html');
            shell_exec('ln -s /var/www/virtual/'.$user.'/courservio/public /var/www/virtual/'.$user.'/html');
        } else {
            $this->warn('html Directory not empty. No symlink created!');
        }

        $this->info('Please proceed setup at https://'.$domain.'/setup');

        return Command::SUCCESS;
    }
}
