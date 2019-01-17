<?php

class Placeholder
{
    /**
    * Get all of the posts for the country.
    */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}