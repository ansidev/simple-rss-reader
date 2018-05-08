<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $fillable = ['title', 'content', 'description', 'link', 'published_at'];

    protected $hidden = ['category_id', 'source_id'];

    /**
     * Get the category that owns the feed.
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * Get the source that owns the feed.
     */
    public function source()
    {
        return $this->belongsTo('App\FeedSource');
    }
}
