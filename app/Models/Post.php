<?php

namespace App\Models;

use App\Concern\Likeable;
use App\Scopes\PostedScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Post
 *
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property \Carbon\Carbon $posted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $thumbnail_id
 * @property-read \App\User $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Like[] $likes
 * @property-read \App\Media|null $thumbnail
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post lastMonth($limit = 5)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post lastWeek()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post latest()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post search($search)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post wherePostedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereThumbnailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Post extends Model
{
    use Likeable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'title',
        'content',
        'posted_at',
        'slug',
        'thumbnail_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'posted_at'
    ];

    /**
     * The "booting" method of the model.
     */
    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new PostedScope);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        if (request()->expectsJson()) {
            return 'id';
        }

        return 'slug';
    }

    /**
     * Scope a query to search posts
     */
    public function scopeSearch(Builder $query, ?string $search)
    {
        if ($search) {
            return $query->where('title', 'LIKE', "%{$search}%");
        }
    }

    /**
     * Scope a query to order posts by latest posted
     */
    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderBy('posted_at', 'desc');
    }

    /**
     * Scope a query to only include posts posted last month.
     */
    public function scopeLastMonth(Builder $query, int $limit = 5): Builder
    {
        return $query->whereBetween('posted_at', [now()->subMonth(), now()])
                     ->latest()
                     ->limit($limit);
    }

    /**
     * Scope a query to only include posts posted last week.
     */
    public function scopeLastWeek(Builder $query): Builder
    {
        return $query->whereBetween('posted_at', [now()->subWeek(), now()])
                     ->latest();
    }

    /**
     * Return the post's author
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Return the post's thumbnail
     */
    public function thumbnail(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    /**
     * Return the post's comments
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * return the excerpt of the post content
     */
    public function excerpt(int $length = 50): string
    {
        return str_limit($this->content, $length);
    }

    /**
     * return true if the post has a thumbnail
     */
    public function hasThumbnail(): bool
    {
        return filled($this->thumbnail_id);
    }
}