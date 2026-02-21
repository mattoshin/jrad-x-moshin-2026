<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Http;
use App\Models\Products;
use App\Models\Announcements;
use App\Models\User;
use App\Models\Business;
use App\Models\Categories;
use App\Models\Subscriptions;
use Stripe;
use Storage;


class ProductsController extends Controller
{ //

    // table name
    private $table_name="products";

    // table columns
        public $id;
        public $category_id;
        public $name;
        public $description;
        public $stock;
        public $visible;
        public $enabled;



    public function index(){
        $matchThese = [["stock", ">=", 0], ["visible", "=", 1]];
        $products = Products::where($matchThese)->get();
        $results = collect($products)
        ->map(function ($row) {
            return [
                "id"=>$row->id,
                "category"=>$row->category->name,
                "name"=>$row->name,
                "description"=>$row->description,
                "price"=>$row->price
            ];
        });
        return $results;
    }

    public function adminIndex()
    {   $announcement= Announcements::all();
        $products = Products::all()->where('isDelete','=',0);
        $users=User::all();
        return view('products',['products'=>$products,'announcement'=>$announcement,'users'=>$users]);
    }

    public function show(Products $products)
    {        
        $product= Products::get();
        return view('product',['product'=>$product]);
    }

    
    public function getById(Request $request)
    {
        $product = Products::where("id", $request->product)->first();
        if($product === null){
            return [
                "status"=>"error",
                "message"=>"Product not found"
            ];
        }
        return [
            "id"=>$product->id,
            "category"=> [
                "id"=>$product->category->id,
                "name"=>$product->category->name
            ],
            "name"=>$product->name,
            "description"=>$product->description,
            "price"=>$product->price
        ];
    }

    public function store(Request $request)
    {

        $product = new Products;
        $product->category_id='12435676';
        $product->name=$request->input('pName_outer-group.0.taskname');
        $product->description = $request->input('pDesc_outer-group.0.area');
        $product->stock=$request->input('product-id_outer-group.0.taskbudget');
        $product->visible='1';
        $product->enabled='1';
        $product->save();

        return redirect('product');
    }

    public function getId($id)
    {   
        $announcement=Announcements::where("product", "=", $id)->get();
        $product= Products::find($id);
        $categories = Categories::all();

        // $monthly_income_r = Subscriptions::whereMonth('created_at', date('m'))
        //             ->whereYear('created_at', date('Y'))->where(['product'=>$id,'status'=>'active'])->sum('stripe_price');

        // $total_revenue = Subscriptions::where(['product'=>$id])->sum('stripe_price');

        // $total_subscriber = Subscriptions::where(['product'=>$id, 'status'=>'active'])
        //                     ->get()->groupBy('user')->count();

        // $recent_payments = Subscriptions::join('users', 'subscriptions.user', '=', 'users.id')
        //                 ->limit(5)
        //                 ->get(['users.*', 'subscriptions.stripe_price']);
    
// 'mrr_count'=>$monthly_income_r, 'total_revenue'=>$total_revenue, 'total_subscriber'=>$total_subscriber, 'recent_payments'=>$recent_payments
        return view('product',['product'=>$product, 'announcement'=>$announcement, 'categories'=> $categories]);
    }
    
    public function updateProduct(Request $request){
        
        $product = Products::where("id", "=", $request->id)->first();
        if($product !== null){
            
            
            if($request->productName){
                $product->name = $request->productName;
            }
            if($request->productDescription){
            $product->description = $request->productDescription;
            }
            if($request->productPrice){
                $stripe = new \Stripe\StripeClient(config('stripe.secret'));

                if($product->price <= 0 && is_null($product->stripeProduct)) {
                    $stripeProduct = $stripe->products->create([
                        'name' => $product->name,
                    ]);
                    $product_id = $stripeProduct->id;
        
                    $price = $stripe->prices->create([
                        'unit_amount' => (int)$request->productPrice * 100,
                        'currency' => 'usd',
                        'recurring' => ['interval' => 'month'],
                        'product' => $product_id,
                    ]);
        
                    $price_id = $price->id;
                    $product->stripeProduct = $product_id;
                    $product->stripePid = $price->id;
                } 
                // Check if the product price is already zero and make sure the new price is at zero
                if ($product->price != 0 && $request->productPrice == 0) {
                    // Cancel all subscriptions
                    // Remove stripe product


                    // get subscriptions
                    $productSubscriptions = $product->getSubscriptions();

                    // loop subscriptions
                    foreach ($productSubscriptions as $subscription){
                        // find subscription
                        $stripeSubscription = $stripe->subscriptions->retrieve(
                            $subscription->stripe_sid,
                            []
                        );

                        // check if the subscription exists
                        if ($stripeSubscription) {
                            $stripe->subscriptions->cancel(
                                $subscription->stripe_sid,
                                []
                            );
                        }
                        
                    }
                    // after the subscriptions are canceled remvoe the stripe product
                    // remove product
                    $product->stripeProduct = '';
                    $product->stripePid = '';
                    $product->save();

                }
                $product->price = $request->productPrice;
                
            } else {
                $product->stripePid = $request->stripePid;
            }
            if($request->trialDays){
            $product->trial_period = $request->trialDays;
            }
            $product->visible = $request->productStatus;
            $product->trial = $request->trialStatus;
            $product->save();
            
            session()->put('success','Record updated successfully.');
            return redirect('admin/product/edit/'.$product->id);
        }
    }
    public function productsBy()
    {
        return Products::all()->orderBy('category_id');
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return response()->json($product, 200);

    }

    public function delete(Product $product)
    {
        $product -> delete();
        return response()-> json(null, 204);
    }
    public function productCategory()
    {
        $categories = Categories::all();
        return view('product-category')->with('categories', $categories);
    }

    public function productCategoryView()
    {
        return view('add-product-category');
    }

    public function saveProductCategory(Request $request)
    {
        // dd($stripe_add_product);
        $category = new Categories();
        $category->name = $request->cate_name;
        $category->description = $request->cate_descr;
        $category->type = $request->cate_type;
        $category->save();   

        session()->put('success','Record added successfully.');
        return redirect('admin/categories');
    }

    public function editCategory_view($id)
    {
        $category_data = Categories::find($id);
        return view('edit-category', ['category_data'=>$category_data]);
    }


    public function mrr_records($id)
    {
        $mrr_count = Products::all()
            ->where(['isDelete'=>0])->sum('plan_amount');;
        return view('add-product-category')->with('mrr_count', $mrr_count);
    }

    public function editCategory_save(Request $request)
    {
        $request->validate([
            'cate_name' => 'required',
            'cate_descr' => 'required',
            'cate_type' => 'required',
        ]);

        $category_id = $request->id;
        $category = Categories::find($category_id);
        $category->name = $request->cate_name;
        $category->description = $request->cate_descr;
        $category->type = $request->cate_type;
        $category->save();  

        session()->put('success','Record edit successfully.');
        return redirect('admin/categories');
    }

    public function viewAddProduct()
    {
        return view('productSS');
    }
}
