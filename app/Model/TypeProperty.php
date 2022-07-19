<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TypeProperty extends Model
{
    //
    protected $table = 'type_property';
    protected $fillable = ['type_en','type_ar'];
    protected $hidden = [];
    public $timestamps = false;

    public function property(){
        return $this->hasOne('App\Model\Property','type_property_id','id');
    }
}
