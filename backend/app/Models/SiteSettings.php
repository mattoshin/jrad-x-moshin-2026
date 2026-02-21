<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    use HasFactory;
    public $timestamps=false;
    /**
     *
     * @var string[]
    */
    //Fillable 
    protected $fillable=[
        'id',
        'type',
        'value',
        'updateDate'
    ];


    protected $cast=[
        'type' =>'string',
        'value' =>'string',
        'updateDate'=>'timestamp',
    ];
}
