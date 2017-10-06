<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';
    protected $fillable = ['user_id', 'monster_id', 'result','result_type','created_at', 'updated_at'];
    protected $guarded = ['id'];
}
