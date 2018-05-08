<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedSource extends Model
{
    protected $fillable = ['name', 'link'];

    /**
     * Get the feeds for the category.
     */
    public function feeds()
    {
        return $this->hasMany('App\Feed');
    }
}
