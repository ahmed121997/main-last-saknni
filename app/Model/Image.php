<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $table = 'images';
    protected $fillable = ['id','source','property_id','created_at','updated_at'];
    protected $hidden = ['created_at','updated_at'];
    public $timestamps = true;

    public function property(){
        return $this->belongsTo('App\Model\Property','property_id','id');
    }
}
