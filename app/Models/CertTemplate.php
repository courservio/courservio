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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\CertTemplate
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $background
 * @property int $registration_required
 * @property string $filename
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|CourseType[] $courseTypes
 * @property-read int|null $course_types_count
 *
 * @method static Builder|CertTemplate newModelQuery()
 * @method static Builder|CertTemplate newQuery()
 * @method static Builder|CertTemplate query()
 * @method static Builder|CertTemplate whereBackground($value)
 * @method static Builder|CertTemplate whereCreatedAt($value)
 * @method static Builder|CertTemplate whereDescription($value)
 * @method static Builder|CertTemplate whereFilename($value)
 * @method static Builder|CertTemplate whereId($value)
 * @method static Builder|CertTemplate whereRegistrationRequired($value)
 * @method static Builder|CertTemplate whereTitle($value)
 * @method static Builder|CertTemplate whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class CertTemplate extends Model
{
    use HasFactory;

    public function courseTypes(): BelongsToMany
    {
        return $this->belongsToMany(CourseType::class);
    }
}
