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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\CourseDay
 *
 * @property int $id
 * @property int $course_id
 * @property string $date
 * @property string $startPlan
 * @property string|null $startReal
 * @property string $endPlan
 * @property string|null $endReal
 * @property int $unitsPlan
 * @property int $unitsReal
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|TrainerDay[] $trainer
 * @property-read int|null $trainer_count
 *
 * @method static Builder|CourseDay newModelQuery()
 * @method static Builder|CourseDay newQuery()
 * @method static Builder|CourseDay query()
 * @method static Builder|CourseDay whereCourseId($value)
 * @method static Builder|CourseDay whereCreatedAt($value)
 * @method static Builder|CourseDay whereDate($value)
 * @method static Builder|CourseDay whereEndPlan($value)
 * @method static Builder|CourseDay whereEndReal($value)
 * @method static Builder|CourseDay whereId($value)
 * @method static Builder|CourseDay whereStartPlan($value)
 * @method static Builder|CourseDay whereStartReal($value)
 * @method static Builder|CourseDay whereUnitsPlan($value)
 * @method static Builder|CourseDay whereUnitsReal($value)
 * @method static Builder|CourseDay whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class CourseDay extends Model
{
    use HasFactory;

    public function trainer(): HasMany
    {
        return $this->hasMany(TrainerDay::class, 'course_day_id');
    }

//    protected $casts = [
//        'startPlan' => 'datetime:Y-m-d H:i',
//        'endPlan' => 'datetime:Y-m-d H:i',
//    ];
}
