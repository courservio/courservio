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

namespace App\Listeners;

use App\Classes\CsvImportClass;
use App\Models\Location;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use League\Csv\Exception;
use League\Csv\InvalidArgument;

class ImportGeoLocations implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(): bool
    {
        $csv = new CsvImportClass();
        $csv->setUrl(config('geo-data.url'));
        $csv->setFile('locations.csv');

        try {
            $records = $csv->getContent();
        } catch (InvalidArgument|Exception $e) {
            report($e);

            return false;
        }

        $data = [];

        //query your records from the document
        foreach ($records as $record) {
            $record['location'] = correctGeolocation($record['location']);

            $data[] = $record; // to our new array
        }

        $array_chunk = array_chunk($data, 500); // chunk to 500 each, cause of mysql / mariadb limits

        Location::truncate();

        foreach ($array_chunk as $chunk) {
            Location::insert($chunk);
        }

        return true;
    }
}
