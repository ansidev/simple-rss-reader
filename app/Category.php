<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    /**
     * Get the feeds for the category.
     */
    public function feeds()
    {
        return $this->hasMany('App\Feed');
    }
}
