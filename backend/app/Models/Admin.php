<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{
    use Notifiable;
    

    protected $table = 'admins';
    protected $guarded = array();
    public $timestamps= false;


    protected $fillable=[
        'id',
        'email',
        'password'
    ];
    protected $hidden=[
        'password',
        'remember_token'
    ];

    protected $casts=[
        'id'=>'integer',
        'email'=>'string',
        'password'=> 'encrypted'
    ];
}
