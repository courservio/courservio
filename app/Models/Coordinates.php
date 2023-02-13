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

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Coordinates
 *
 * @property int $id
 * @property string $country_code
 * @property string $zipcode
 * @property string $location
 * @property string $state
 * @property string $lat
 * @property string $lon
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Coordinates newModelQuery()
 * @method static Builder|Coordinates newQuery()
 * @method static Builder|Coordinates query()
 * @method static Builder|Coordinates whereCountryCode($value)
 * @method static Builder|Coordinates whereCreatedAt($value)
 * @method static Builder|Coordinates whereId($value)
 * @method static Builder|Coordinates whereLat($value)
 * @method static Builder|Coordinates whereLocation($value)
 * @method static Builder|Coordinates whereLon($value)
 * @method static Builder|Coordinates whereState($value)
 * @method static Builder|Coordinates whereUpdatedAt($value)
 * @method static Builder|Coordinates whereZipcode($value)
 *
 * @mixin Eloquent
 */
class Coordinates extends Model
{
    use HasFactory;
    use Search;

    protected array $searchable = [
        'zipcode',
        'location',
    ];
}
