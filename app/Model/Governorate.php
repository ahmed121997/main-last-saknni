<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    //
    protected $table = 'governorates';
    protected $fillable = ['governorate_name','governorate_name_en'];
    protected $hidden = [];
    public $timestamps = false;
    public function cities(){
        return $this->hasMany('App\Model\City','gov_id','id');
    }
}
