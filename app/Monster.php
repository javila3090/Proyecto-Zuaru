<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monster extends Model
{
    protected $table = 'monsters';
    protected $fillable = ['name', 'level', 'created_at', 'updated_at'];
    protected $guarded = ['id'];
}
