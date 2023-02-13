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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Participant
 *
 * @property int $id
 * @property int $course_id
 * @property int|null $contact_id
 * @property int|null $team_id
 * @property string $lastname
 * @property string $firstname
 * @property string $date_of_birth
 * @property string|null $company
 * @property string|null $street
 * @property string|null $zipcode
 * @property string|null $location
 * @property string|null $phone
 * @property string|null $email
 * @property mixed|null $email_reminder
 * @property int $rating
 * @property string|null $payee
 * @property int $participated
 * @property string $price_net
 * @property string $price_gross
 * @property string $currency
 * @property string $payment
 * @property int $price_id
 * @property int $payed
 * @property string|null $transaction_id
 * @property mixed|null $cancelled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ContactPerson|null $contactPerson
 * @property-read Course $course
 *
 * @method static Builder|Participant newModelQuery()
 * @method static Builder|Participant newQuery()
 * @method static Builder|Participant query()
 * @method static Builder|Participant whereCancelled($value)
 * @method static Builder|Participant whereCompany($value)
 * @method static Builder|Participant whereContactId($value)
 * @method static Builder|Participant whereCourseId($value)
 * @method static Builder|Participant whereCreatedAt($value)
 * @method static Builder|Participant whereCurrency($value)
 * @method static Builder|Participant whereDateOfBirth($value)
 * @method static Builder|Participant whereEmail($value)
 * @method static Builder|Participant whereEmailReminder($value)
 * @method static Builder|Participant whereFirstname($value)
 * @method static Builder|Participant whereId($value)
 * @method static Builder|Participant whereLastname($value)
 * @method static Builder|Participant whereLocation($value)
 * @method static Builder|Participant whereParticipated($value)
 * @method static Builder|Participant wherePayed($value)
 * @method static Builder|Participant wherePayee($value)
 * @method static Builder|Participant wherePayment($value)
 * @method static Builder|Participant wherePhone($value)
 * @method static Builder|Participant wherePriceGross($value)
 * @method static Builder|Participant wherePriceId($value)
 * @method static Builder|Participant wherePriceNet($value)
 * @method static Builder|Participant whereRating($value)
 * @method static Builder|Participant whereStreet($value)
 * @method static Builder|Participant whereTeamId($value)
 * @method static Builder|Participant whereTransactionId($value)
 * @method static Builder|Participant whereUpdatedAt($value)
 * @method static Builder|Participant whereZipcode($value)
 *
 * @mixin Eloquent
 */
class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'contact_id',
        'team_id',
        'lastname',
        'firstname',
        'date_of_birth',
        'company',
        'street',
        'zipcode',
        'location',
        'phone',
        'email',
        'price_net',
        'price_gross',
        'currency',
        'payment',
        'price_id',
    ];

    public const PAYMENTMETHOD = [
        'cash' => 'fa-solid fa-money-bill-wave',
        'card' => 'fa-solid fa-credit-card',
        'invoice' => 'fa-solid fa-receipt',
        'prepay' => 'fa-solid fa-landmark',
        'accountingForm' => 'fa-solid fa-file-invoice',
        'paypal' => 'fa-brands fa-paypal',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function contactPerson(): BelongsTo
    {
        return $this->belongsTo(ContactPerson::class, 'contact_id');
    }
}
