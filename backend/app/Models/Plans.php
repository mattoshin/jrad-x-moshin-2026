<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use App\Models\User;
use App\Models\Business;
use App\Models\Servers;
use App\Models\ClientChannels;
use App\Models\CategoriesChannels;
use App\Models\Webhooks;


class Plans extends Model
{
    use HasFactory;

    public $timestamps=false;
    /**
     *
     * @var string[]
    */
    protected $fillable=[
        'id',
        'user',
        'business',
        'name',
        'color' ,
        'picture',
        'startDate',
        'endDate',
        'product',
        'subscription',
        'role',
        'hadTrial',
        'activeTrial',
        'trialStart',
        'trialEnd'
    ];
  /**
     * The attributes that should be cast.
     *
     * @var array
     */

    protected $casts =[
        'id'=>'integer',
        'user'=>'integer',
        'name'=>'string',
        'color'=>'string',
        'picture'=>'string',
        'startDate'=>'timestamp',
        'endDate'=>'timestamp',
        'product' => 'integer',
        'subscription' => 'integer',
        'role' => 'string',
        'hadTrial' => 'boolean',
        'activeTrial' => 'boolean',
        'trialStart' => 'timestamp',
        'trialEnd' => 'timestamp'
    ];

    
    public function getProduct()
    {
        return $this->belongsTo(Products::class, 'product', 'id');
    }
    public function getBusiness()
    {
        return $this->belongsTo(Business::class, 'business', 'id');
    }
    public function getUser()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }
    
    public function webhooks()
    {
        return $this->hasMany(Webhooks::class, 'plan');
    }
    public function channels()
    {
        return $this->hasMany(ClientChannels::class, 'plan');
    }
    public function getAccessChannels()
    {
        $accessChannels = Channels::where("product", "=", $this->product)->get();
        return $accessChannels;
    }
    public function getSubscription()
    {
        return $this->belongsTo(Subscriptions::class, 'id');
    }
}
