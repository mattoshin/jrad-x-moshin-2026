<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Webhooks;
use App\Models\Products;

class Channels extends Model
{
    use HasFactory;
    public function channel(){
        return $this->belongsTo(Webhooks::class, 'channel_id');
    }
    protected $primaryKey = 'channel_id';

    public $incrementing = false;
    public $timestamps = false;

    /**
     * most variables fit under this data type
     * @var string
    */
    protected $fillable=[
        'id',
        'product',
        'channel_id',
        'category',
        'name'
    

    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $Casts=[
        'id'=>'integer',
        'product'=>'integer',
        'channel_id'=>'integer',
        'name'=>'string',
    ];

    public function channels()
    {
        return $this->hasMany(ClientChannels::class, "controlChannel", "id");
    }
    public function webhooks()
    {
        return $this->hasMany(Webhooks::class, 'channel_id', 'id');
    }
    public function webhook($id)
    {
        return $this->hasMany(Webhooks::class, 'channel_id', 'id')->where('plan', '=', $id)->first();
    }
    public function getProduct()
    {
        return $this->belongsTo(Products::class, 'product', 'id');
    }
}
