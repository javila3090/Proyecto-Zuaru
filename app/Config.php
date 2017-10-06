<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'configs';
    protected $fillable = ['user_id', 'data'];
    protected $casts = [
        'data' => 'array',
    ];
    protected $guarded = ['id'];
}
