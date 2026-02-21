<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     *
     * @var string[]
    */
    protected $fillable=[
        'id',
        'owner',
        'business',
        'guild_id',
        'name',
        'server_avatar',
        'creation_date',
        'join_date'
    ];

  /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts =[
        'id'=>'integer',
        'owner'=>'integer',
        'business'=>'integer',
        'guild_id'=>'integer',
        'name'=>'string',
        'server_avatar'=>'string',
        'creation_date'=>'timestamp',
        'join_date'=>'timestamp'
    ];

    
    /**
     * The category that belong to the product.
     */
    public function businessToken()
    {
        return $this->belongsTo(Business::class, 'business', 'id');
    }
}
