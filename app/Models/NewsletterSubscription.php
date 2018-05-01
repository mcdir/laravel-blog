<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\NewsletterSubscription
 *
 * @property int $id
 * @property string $email
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsletterSubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsletterSubscription whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsletterSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsletterSubscription whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NewsletterSubscription extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'email' ];
}
