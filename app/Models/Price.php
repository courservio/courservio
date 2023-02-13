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

use Database\Factories\PriceFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Price
 *
 * @property int $id
 * @property int|null $team_id
 * @property int|null $cert_template_id
 * @property string $title
 * @property string|null $description
 * @property string $amount_net
 * @property string $amount_gross
 * @property string $currency
 * @property string $payment
 * @property int|null $tax_rate
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read CertTemplate|null $certTemplate
 * @property-read Collection|Course[] $courses
 * @property-read int|null $courses_count
 * @property-read Team|null $team
 *
 * @method static PriceFactory factory(...$parameters)
 * @method static Builder|Price newModelQuery()
 * @method static Builder|Price newQuery()
 * @method static Builder|Price query()
 * @method static Builder|Price whereActive($value)
 * @method static Builder|Price whereAmountGross($value)
 * @method static Builder|Price whereAmountNet($value)
 * @method static Builder|Price whereCertTemplateId($value)
 * @method static Builder|Price whereCreatedAt($value)
 * @method static Builder|Price whereCurrency($value)
 * @method static Builder|Price whereDescription($value)
 * @method static Builder|Price whereId($value)
 * @method static Builder|Price wherePayment($value)
 * @method static Builder|Price whereTaxRate($value)
 * @method static Builder|Price whereTeamId($value)
 * @method static Builder|Price whereTitle($value)
 * @method static Builder|Price whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Price extends Model
{
    use HasFactory;

    public const CURRENCY = [
        'EUR',
        'USD',
    ];

    public const SIGN = [
        'EUR' => '€',
        'USD' => '$',
    ];

    public const TAX = [
        '0' => '0 %',
        '7' => '7 %',
        '19' => '19 %',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function certTemplate(): BelongsTo
    {
        return $this->belongsTo(CertTemplate::class);
    }
}
