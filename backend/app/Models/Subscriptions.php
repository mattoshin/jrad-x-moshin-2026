<?php

namespace App\Models;

use Stripe;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\SubscriptionsFactory;
use App\Models\User;

class Subscriptions extends Model
{
    use HasFactory,HasApiTokens;

    protected $table = 'user-subscriptions';

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run(){
        Database\Factories\Subscriptions::factory()->count(15)->create(15);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    public $timestamps=false;
    protected $fillable=[
        'id',
        'product',
        'user',
        'business',
        'creation_date',
        'stripe_sid',
        'stripe_pid',
        'pay_amount',
        'joinDate',
        'endDate'
    ];


    /**
     *
     * @var string()
    */
    protected $hidden=[
        'stripe_sid',
        'stripe_pid'
    ];


     /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id'=>'integer',
        'server_id'=>'integer',
        'stripe_sid'=>'string',
        'stripe_sid'=>'string',
        'plan'=>'integer',
        'user'=>'integer',
        'creation_date'=>'timestamp',
        'joinDate'=>'timestamp',
        'creation_date'=>'timestamp',
        'stripeSId'=>'string',
        'stripePId'=>'string',
        'user'=>'integer',
        'joinDate'=>'timpestamp',
        'endDate'=>'timestamp'
        
    ];
    public function getUser()
    {
        return $this->hasOne(User::class, "user", "id");
    }
    public function getBusiness()
    {
        return $this->hasOne(Business::class, "id", "business");
    }

    public function getNextChargeDate(){

        // Ensure there is a subscription id
        if (is_null($this->stripe_sid)) return null;

        // Init stripe
        $stripe = new \Stripe\StripeClient(config('stripe.secret'));

        // Find subscription
        $stripeSubscription = $stripe->subscriptions->retrieve(
            $this->stripe_sid,
            []
        );
                
        // convert timestamp to mm/dd/yyyy
        return date('m/d/Y', $stripeSubscription->current_period_end);
    }


}
