<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'configs';
    protected $fillable = ['user_id', 'name', 'data1','data2','created_at', 'updated_at'];
    protected $guarded = ['id'];
}
