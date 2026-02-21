<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Http;
use App\Models\Plans;
use App\Models\User;
use Stripe;

class PlansController extends Controller
{ //

    // table name
    private $table_name="plans";

    // table columns
        public $id;
        public $user;
        public $start_date;
        public $update_date;
        public $end_date;
        public $name;
        public $color;
        public $picture;



    public function index()
    {
        return Plans::all();
    }

    public function show(Plans $plan)
    {
        return $plan;
    }

    public function store(Request $request)
    {   
        return Plans::where('user', $request->id)->update($request->all());

    }
    public function getById($id)
    {
       $plan = Plans::find($id);
       return view('plan', ['plan'=>$plan]);
    }
    public function adminUpdate(Request $request){
        $plan = Plans::where('id', $request->id)->first();
        $plan->name = $request->planName;
        $plan->color = $request->planColor;
        $plan->picture = $request->planImage;
        $plan->role = $request->planRole;
        $plan->save();
        session()->put('success','Record updated successfully.');
        return redirect('admin/plan/'.$plan->id);
    }
    public function getId(Request $request)
    {  
        $cookie = $request->cookie('user');
        if (!$cookie) return false;
        $value = json_decode($cookie, true)["user"]["id"];
        if ($request->id != $value) return false;
        $planuserid = Plans::where('user', $request->id)->first();
        if (!$planuserid) return false; 
        if ($planuserid->user != $value) return false;
        return $planuserid;
    }
    public function getUsers()
    {
        return Plans::all()->orderBy('users');
    }

    public function getProduct()
    {
        return Plans::all()->orderBy('product');
    }

    public function getSubId()
    {
        return Plans::all()->orderBy('subscription');
    }

    public function update(Request $request, Plan $plan)
    {
        $plan->update($request->all());
        return response()->json($plan, 200);
    }

    public function delete(Plan $plan)
    {
        $plan -> delete();
        return response()-> json(null, 204);
    }

    public function deleteById(Request $request){
        // Find plan

        $plan = Plans::where('id', '=', $request->id);

        if (!$plan){
            session()->put('error','Record not found!');
            return redirect('admin/products');
        }

        if ($plan->enabled == 0){
            session()->put('error','This plan has already been canceled!');
            return redirect('admin/products');
        }

        if ($plan->getProduct->price > 0){
            $subscriptionObject = Subscriptions::where([
                ['business', '=', $plan->getBusiness->id],
                ['product', '=', $plan->getProduct->id]
            ])->first();
            if($subscriptionObject){
                $stripe = new \Stripe\StripeClient(config('stripe.secret'));

                try {
                    $cancelEvent = $stripe->subscriptions->cancel($subscriptionObject->stripe_sid);
                } catch (\Exception $e) {
                    session()->put('error','There has been an error!');
                    return redirect('admin/product/edit/'.$plan->getProduct->id);
                }
            }
        }

        $plan->enabled = 0;
        $plan->save();


        session()->put('success','Plan has been cancelled!');
        return redirect('admin/product/edit/'.$plan->getProduct->id);

    }
}
