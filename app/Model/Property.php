<?php

namespace App\Model;

use ChristianKuri\LaravelFavorite\Traits\Favoriteable;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use Favoriteable;
    //
    protected $table = 'properties';

    protected $fillable = ['id','user_id','type_property_id', 'list_section','type_rent','area', 'list_view_id', 'num_floor',
        'num_rooms', 'num_bathroom', 'type_finish_id','city_id', 'location', 'des_property_id',
        'type_payment_id', 'price', 'link_youtube','status','trans_payment_id','created_at','updated_at'];

    protected $hidden = ['created_at', 'updated_at'];

    public $timestamps = true;

########################### Relation with Property Model ########################
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
    public function des(){
        // details for properties
        return $this->hasOne('App\Model\DescriptionProperty','property_id','id');
    }
    public function images(){
        // images for properties
        return $this->hasOne('App\Model\Image', 'property_id','id');
    }
    public function typeProperty(){
        // type of properties
        return $this->belongsTo('App\Model\TypeProperty','type_property_id','id');
    }

    public function view(){
        // list views of  properties
        return $this->belongsTo('App\Model\ListView','list_view_id','id');
    }
    public function finish(){
        // list views of  properties
        return $this->belongsTo('App\Model\TypeFinish','type_finish_id','id');
    }
    public function payment(){
        // type payments to pay
        return $this->belongsTo('App\Model\TypePayment','type_payment_id','id');
    }
    public function city(){
        // type payments to pay
        return $this->belongsTo('App\Model\City','city_id','id');
    }
    public function comments()
    {
        return $this->hasMany('App\Model\Comment')->whereNull('parent_id');
    }
###########################  End Relation with Property Model ########################

}
