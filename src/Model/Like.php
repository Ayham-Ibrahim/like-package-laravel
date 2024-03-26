<?php

namespace Ayham\Like\Model;


use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
        'reaction'
    ];

    // define likeable relationship

    public function likeable()
    {
        return $this->morphTo();
    }

    // define the user relationship
    public function user()
    {
        $userClassName = Config::get('auth.model');
        if (is_null($userClassName)) {
            $userClassName = Config::get('auth.providers.users.model');
        }

        return $this->belongsTo($userClassName);
    }
}



