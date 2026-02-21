<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Http;
use App\Models\Announcements;
use App\Models\Products;
use Carbon\Carbon;

class AnnouncementsController extends Controller
{
    //

    // table name
    private $table_name="announcements";

    // table columns
        public $id;
        public $product;
        public $announcement;
        public $shown;
        public $start_date;
        public $update_date;
        public $end_date;



    public function Products()
    {
        return $this->belongTo(Products::class,'id');
    }

    public function index()
    {
        $announcements= Announcements::orderBy('id', 'desc')->get();

        
        return response()->json($announcements);
    }


    public function show(Announcements $announcements)
    {
        return $announcements;
    }

    public function getId($id)
    {
        return Announcements::find($id);
    }

    public function getProduct()
    {
        return Announcements::all()->orderBy('product');
    }

    public function getEnabled()
    {
        return Announcements::all();
    }
    public function getByProduct($id){
        return Announcements::where('product',$id)
                            ->get();
    }
//$dt = Carbon::create(2012, 1, 31, 0);


    public function store(Request $request)
    {
        // $product= Products::with('')->whereRelation('id','product');
        $id= $request->input('hidden');


        $announcements = new Announcements;
        $announcements->announcement = $request->input('announcementText');
        $announcements->product=$id;
        $announcements ->save();


        $info_request = env('BOT_API_URL') . "/send_announcements";
        $data = [
            'product' => $id,
            "message" => $request->input('announcementText')
        ];
        $response = Http::withBody(json_encode($data), 'application/json')->get($info_request);
        $response->throw();
        $guilds = json_decode($response->getbody(), true);

        session()->put('success','Announcement Posted');
         return redirect('/admin/product/edit/'.$id);

    }

    public function update(Request $request, Announcements $announcement)
    {
        $validated = $request->only(['announcement', 'product', 'shown']);
        $announcement->update($validated);
        return response()->json($announcement, 200);

    }

    public function delete($id)
    {   
           $announcement = Announcements::findOrFail($id);
        $announcement -> delete();
      return redirect()->back();
    }
}
