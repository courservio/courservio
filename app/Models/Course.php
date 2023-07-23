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

use Database\Factories\CourseFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Course
 *
 * @property int $id
 * @property int $course_type_id
 * @property int|null $team_id
 * @property string|null $internal_number
 * @property string|null $registration_number
 * @property string $seminar_location
 * @property string $street
 * @property string $zipcode
 * @property string $location
 * @property \Carbon\Carbon $start
 * @property \Carbon\Carbon $end
 * @property mixed|null $cancelled
 * @property int $seats
 * @property int|null $public_bookable
 * @property string|null $bag
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|CourseDay[] $days
 * @property-read int|null $days_count
 * @property-read Collection|Participant[] $participants
 * @property-read int|null $participants_count
 * @property-read Collection|Price[] $prices
 * @property-read int|null $prices_count
 * @property-read Team|null $team
 * @property-read Collection|TrainerDay[] $trainer
 * @property-read int|null $trainer_count
 * @property-read CourseType $type
 *
 * @method static CourseFactory factory(...$parameters)
 * @method static Builder|Course newModelQuery()
 * @method static Builder|Course newQuery()
 * @method static Builder|Course query()
 * @method static Builder|Course whereBag($value)
 * @method static Builder|Course whereCancelled($value)
 * @method static Builder|Course whereCourseTypeId($value)
 * @method static Builder|Course whereCreatedAt($value)
 * @method static Builder|Course whereEnd($value)
 * @method static Builder|Course whereId($value)
 * @method static Builder|Course whereInternalNumber($value)
 * @method static Builder|Course whereLocation($value)
 * @method static Builder|Course wherePublicBookable($value)
 * @method static Builder|Course whereRegistrationNumber($value)
 * @method static Builder|Course whereSeats($value)
 * @method static Builder|Course whereSeminarLocation($value)
 * @method static Builder|Course whereStart($value)
 * @method static Builder|Course whereStreet($value)
 * @method static Builder|Course whereTeamId($value)
 * @method static Builder|Course whereUpdatedAt($value)
 * @method static Builder|Course whereZipcode($value)
 *
 * @mixin Eloquent
 */
class Course extends Model
{
    use HasFactory;

    protected $casts = [
        'start' => 'datetime:d.m.Y H:i',
        'end' => 'datetime:d.m.Y H:i',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(CourseType::class, 'course_type_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function prices(): BelongsToMany
    {
        return $this->belongsToMany(Price::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function days(): HasMany
    {
        return $this->hasMany(CourseDay::class, 'course_id');
    }

    public function trainer(): HasMany
    {
        return $this->hasMany(TrainerDay::class, 'course_id');
    }

    //    static public function getFreeSeats(Course $course): int
    //    {
    //        $participants = Participant::whereCourseId( $course->id)->where('cancelled', '=', 0)->count();
    //
    //        return intval($course->seats) - $participants;
    //    }
    //
    //    static public function getFreePercent(Course $course): int
    //    {
    //        $participants = Participant::whereCourseId( $course->id)->where('cancelled', '=', 0)->count();
    //        $freeSeats = intval($course->seats) - $participants;
    //
    //        return $freeSeats / intval($course->seats) * 100;
    //    }
}
