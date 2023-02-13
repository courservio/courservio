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
 * App\Models\TrainerDay
 *
 * @property int $course_id
 * @property int|null $user_id
 * @property int|null $course_day_id
 * @property int|null $position
 * @property int $order
 * @property string|null $option
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|TrainerDay newModelQuery()
 * @method static Builder|TrainerDay newQuery()
 * @method static Builder|TrainerDay query()
 * @method static Builder|TrainerDay whereCourseDayId($value)
 * @method static Builder|TrainerDay whereCourseId($value)
 * @method static Builder|TrainerDay whereCreatedAt($value)
 * @method static Builder|TrainerDay whereOption($value)
 * @method static Builder|TrainerDay whereOrder($value)
 * @method static Builder|TrainerDay wherePosition($value)
 * @method static Builder|TrainerDay whereUpdatedAt($value)
 * @method static Builder|TrainerDay whereUserId($value)
 *
 * @mixin Eloquent
 */
class TrainerDay extends Model
{
    use HasFactory;
}
