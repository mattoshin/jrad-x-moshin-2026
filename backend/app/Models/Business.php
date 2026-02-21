<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Servers;
use App\Models\Plans;

class Business extends Model
{
    use HasFactory;
    /**
     *
     * @var string[]
    */
    public $timestamps=false;
    protected $fillable=[
        'name',
        'owner',
        'email',
        'twitter',
        'description',
        'location',
        'currency',
        'website',
        'phone',
        'notifications',
        'order_confirmation',
        'order_status',
        'order_delivered',
        'creationDate',
        'updateDate',
        'api_token'

    ];

  /**
     * The attributes that should be cast.
     *
     * @var array
     * @var char
     *
     */
    protected $casts =[
        'owner'=>'integer',
        'name'=>'string',
        'email'=>'string',
        'twitter'=>'string',
        'description'=>'string',
        'location' => 'string',
        'currency' => 'string',
        'website' => 'string',
        'phone' => 'string',
        'notifications' => 'boolean',
        'order_confirmation' => 'boolean',
        'order_status' => 'boolean',
        'order_delivered' => 'boolean',
        'creationDate' => 'timestamp',
        'updateDate' => 'timestamp',
        'api_token' => 'string'

    ];

    public function getOwner()
    {
        return $this->belongsTo(User::class, 'owner', 'id');
    }
    public function server()
    {
        return $this->hasOne(Servers::class, 'business', 'id');
    }
    public function hasPlans()
    {
        $plans = $this->hasMany(Plans::class, 'business')->get();
        return (count($plans) != 0) ? TRUE : FALSE;
    }
}
