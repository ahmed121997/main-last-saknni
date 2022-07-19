<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ListView extends Model
{
    //
    protected $table = 'list_views';
    protected $fillable = ['list_en','list_ar'];
    protected $hidden = [];
    public $timestamps = false;

    public function property(){
        return $this->hasOne('App\Model\Property','list_view_id','id');
    }
}
