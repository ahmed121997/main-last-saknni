<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /*
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'comments';
    protected $fillable = ['user_id', 'property_id', 'parent_id', 'body'];

    /*
     * The belongs to Relationship
     *
     * @var array
     */
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    /*
     * The has Many Relationship
     *
     * @var array
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
