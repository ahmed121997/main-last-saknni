<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $table = 'cities';
    protected $fillable = ['city_name','city_name_en','gov_id'];
    protected $hidden = [];
    public $timestamps = false;

    public function govs(){
        return $this->belongsTo('App\Model\Governorate','gov_id','id');
    }
    public function property(){
        return $this->hasOne('App\Model\Property','city_id','id');
    }
}
