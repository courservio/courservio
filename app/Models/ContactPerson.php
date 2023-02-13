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
 * App\Models\ContactPerson
 *
 * @property int $id
 * @property int|null $team_id
 * @property string $lastname
 * @property string $firstname
 * @property string|null $company
 * @property string|null $street
 * @property string|null $zipcode
 * @property string|null $location
 * @property string|null $phone
 * @property string|null $email
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|ContactPerson newModelQuery()
 * @method static Builder|ContactPerson newQuery()
 * @method static Builder|ContactPerson query()
 * @method static Builder|ContactPerson whereCompany($value)
 * @method static Builder|ContactPerson whereCreatedAt($value)
 * @method static Builder|ContactPerson whereEmail($value)
 * @method static Builder|ContactPerson whereFirstname($value)
 * @method static Builder|ContactPerson whereId($value)
 * @method static Builder|ContactPerson whereLastname($value)
 * @method static Builder|ContactPerson whereLocation($value)
 * @method static Builder|ContactPerson wherePhone($value)
 * @method static Builder|ContactPerson whereStreet($value)
 * @method static Builder|ContactPerson whereTeamId($value)
 * @method static Builder|ContactPerson whereUpdatedAt($value)
 * @method static Builder|ContactPerson whereZipcode($value)
 *
 * @mixin Eloquent
 */
class ContactPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'lastname',
        'firstname',
        'company',
        'street',
        'zipcode',
        'location',
        'phone',
        'email',
    ];
}
