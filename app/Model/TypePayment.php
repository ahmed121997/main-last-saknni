<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TypePayment extends Model
{
    //
    protected $table = 'type_payments';
    protected $fillable = ['id','type_en','type_ar'];
    protected $hidden = [];
    public $timestamps = false;

    public function property(){
        return $this->hasOne('App\Model\Property','type_payment_id','id');
    }
}
