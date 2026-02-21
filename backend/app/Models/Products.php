<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;
use App\Models\ControlCategories;
use App\Models\Plans;

class Products extends Model
{
    use HasFactory;
    public $timestamps = false;
    /**
     *
     * @var string[]
    */
    protected $fillable=[
        'id',
        'category_id',
        'name',
        'description',
        'startDate',
        'stripeProduct',
        'stripePid',
        'price',
        'stock',
        'visible',
        'enabled',
        'trial',
        'trialPeriod'

    ];


  /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts =[
        'id'=>'integer',
        'category_id'=>'integer',
        'name'=>'string',
        'description'=>'string',
        'startDate'=>'timestamp',
        'stripeProduct' => 'string',
        'stripePid' => 'string',
        'price' => 'float',
        'stock' => 'boolean',
        'visible' => 'boolean',
        'enabled' => 'boolean',
        'trial' => 'boolean',
        'trialPeriod' => 'integer'
    ];

    /**
     * The category that belong to the product.
     */
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
    public function controlCategory()
    {
        return $this->hasOne(ControlCategories::class, "product");
    }
    public function getSubscriptions()
    {
        return $this->hasMany(Subscriptions::class, "product");
    }
    public function getPlans()
    {
        return $this->hasMany(Plans::class, "product");
    }
    public function getmrr()
    {
        return $this->hasMany(Subscriptions::class, "product")->sum("pay_amount");
    }
    public function totalRevenue()
    {
        return $this->hasMany(Invoices::class, "product")->where("paid","=", 1)->sum("pay_amount");
    }
    public function isFree(){
        return ($this->price <= 0) ? True : False ;
    }
}
