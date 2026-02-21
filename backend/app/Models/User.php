<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use App\Models\Business;
use App\Models\Plans;
use App\Models\Invoices;
use App\Models\Subscriptions;
use App\Helper\Tokenable;
use Illuminate\Support\Str;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'discord_id',
        'username',
        'email',
        'avatar',
        'refresh_token',
        'expires_in',
        'api_token',
        'access_token'
    ];

    /**
     * The attributes that are NOT mass assignable.
     * 'admin' must be set explicitly to prevent privilege escalation.
     */
    protected $guarded = ['admin'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
        'refresh_token',
        
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'admin'=>'boolean'
    ];
    public function findByUsernameOrCreate($user)
    {
        return $this->updateOrCreate(
            ['discord_id' => $user["id"]],
            [
                'username' => $user["nickname"],
                'avatar' => $user["avatar"],
                'email' => $user["email"],
                'refresh_token' => $user["refreshToken"],
                'expires_in' => $user["expiresIn"],
                // 'ip' => $user->ip,
                'access_token' => $user["token"]
                
            ]
        );
    }
    
    public function findByUsername($user){
        return $this->where('discord_id', '=', $user)->first();
    }


    public function getAcessTokenById($id)
    {
           $user = $this->find($id);
           return $user->access_token;
    }

    public function getAccessToken(){
        $url='https://discord.com/api';
        $response = Http::asForm()->post(sprintf('%s/oauth2/token', $url),[
            'client_id'=> env('DISCORD_CLIENT_ID'),
            'client_secret'=>env('DISCORD_CLIENT_SECRET'),
            'grant_type'=>'refresh_token',
            'redirect_uri'=>('DISCORD_REDIRECT_URI'),
            'scope'=>'email identify guilds.join bot guilds',
        ]);
        if ($response->ok()){
            $this->refresh_token=$response->object()->refresh_token;
            $this->expires_in = $response->object()->expires_in;
            $this->save();

            return $response->object()->access_token;
        }else{
            Auth::logout();
            abort(403);
        }
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function business()
    {
        return $this->belongsTo('App\Business');
    }
    public function getBusinesses()
    {
        return $this->hasMany(Business::class, "owner")->get();
    }
    public function getPlans()
    {
        return $this->hasMany(Plans::class, "user")->get();
    }
    public function getInvoices()
    {
        return $this->hasMany(Invoices::class, "user")->get();
    }
    public function getTotalSpent()
    {
        return $this->hasMany(Invoices::class, "user")->get()->sum("pay_amount");
    }
    public function getMonthlySpend()
    {
        return $this->hasMany(Subscriptions::class, "user")->get()->sum("pay_amount");
    }
    public function plans()
    {
        return $this->belongsTo('App\Plans');
    }
    public function isAdmin($admin){
        return $this->admin==$admin;
    }
    public function getBusinessesWithProducts(){
        $matchThese = [['enabled', '=', 1], ['user', '=', $this->id]];
        
        $businesses = Business::all();
        $plans = Plans::where($matchThese)->get();

        $bizArray = $plans->pluck('business');

        $filteredBusinesses = $businesses->filter(function($business) use ($bizArray) {
            if($bizArray->contains($business["id"])){                   
                return $business;
            }
        });

        $filtered = $filteredBusinesses->map(function($business) {
            if($business->hasPlans()){        
                if(!is_null($business->server->name)) return $business->server->name;
            }
        });

        return join(", ", $filtered->toArray());
    }

    public function getBusinessesWithProductsFull(){
        $matchThese = [['enabled', '=', 1], ['user', '=', $this->id]];
        
        $businesses = Business::all();
        $plans = Plans::where($matchThese)->get();

        $bizArray = $plans->pluck('business');

        $filteredBusinesses = $businesses->filter(function($business) use ($bizArray) {
            if($bizArray->contains($business["id"])){                   
                return $business;
            }
        });

        return $filteredBusinesses;
    }
    public function gnerateAndSaveApiAuthToken()
    {
        $token =Str::random(60);

        $this->api_token =$token;
        $this->save();
        return $this;
    }
   

}
