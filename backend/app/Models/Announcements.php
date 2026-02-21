<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class Announcements extends Model
{
    use HasFactory;

    public $timestamps = false;
    /**
     *
     * @var string[]
    */
    protected $fillable=[
        'id',
        'product',
        'announcement',
        'shown',
        'start_date',
        'update_date',
        'end_date'
    ];

  /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts =[
        'id'=>'integer',
        'product'=>'integer',
        'announcement'=>'string',
        'shown'=>'integer',
        'start_date'=>'timestamp',
        'update_date'=>'timestamp',
        'end_date'=>'timestamp'
    ];


    public function getProduct()
    {
        return Products::where('id', '=', $this->product)->first()->name ?? "";
    }
}
