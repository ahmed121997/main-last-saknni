<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DescriptionProperty extends Model
{
    //
    protected $table = 'description_properties';
    protected $fillable = ['id','title','details','property_id'];
    protected $hidden = ['created_at','updated_at'];
    public $timestamps = true;

    public function property(){
        return $this->belongsTo('App\Model\Property','property_id','id');
    }
}
