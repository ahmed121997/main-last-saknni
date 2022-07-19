<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    //
    use Notifiable;

    protected $table = 'admins';
    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $hidden = [
        'password',
    ];

    protected $guard  = "admin";
}
