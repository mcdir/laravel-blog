<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * App\MediaLibrary
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Media[] $media
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MediaLibrary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MediaLibrary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MediaLibrary whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MediaLibrary extends Model implements HasMedia
{
    use HasMediaTrait;

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(350)
              ->height(250);
    }
}
