<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TypeFinish extends Model
{
    //
    protected $table = 'type_finishes';
    protected $fillable = ['type_en','type_ar'];
    protected $hidden = [];
    public $timestamps = false;

    public function property(){
        return $this->hasOne('App\Model\Property','type_finish_id','id');
    }
}
