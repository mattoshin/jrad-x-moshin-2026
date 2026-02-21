<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Channels;
use App\Models\Plans;

class Webhooks extends Model
{
    use HasFactory, HasApiTokens;

    public $timestamps=false;
    /**
     * most variables fit under this data type
     * @var string
    */
    protected $fillable=[
        'id',
        'plan',
        'channel_id',
        'webhook_url',
        'enabled',
        'user',
        'startDate',
        'updateDate',
        'endDate'
    ];
    public function channel(){
        return $this->belongsTo(Channels::class, 'channel_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $Casts=[
        'id'=>'integer',
        'plan'=>'integer',
        'channel_id'=>'integer',
        'webhook_url'=>'string',
        'enabled'=>'boolean',
        'user' => 'integer',
        'startDate' => 'timestamp',
        'updateDate' => 'timestamp',
        'endDate' => 'timestamp'

    ];
 
    public function getPlan()
    {
        return $this->belongsTo(Plans::class, 'plan', 'id');
    }

}
