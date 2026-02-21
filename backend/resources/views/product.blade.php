@include("partials/main")

<?php

use App\Http\Controllers\StripeController;
    
$prices = StripeController::getPrices($product);


?>
<head>

    @extends("partials/title-meta")
    @section('pageTitle')
    Product Page
    @stop
     @extends("partials/head-css")
     <style type="text/css">
        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript, 
        if it's not present, don't show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(https://c.tenor.com/s-u8sx-iaiQAAAAM/loading-dots.gif) center no-repeat #30343a;
        }
    </style>
</head>


@include("partials/body")
@extends("partials/vendor-scripts")

    <div class="se-pre-con"></div>
<script src="{{asset('assets/css/app-dark.min.css')}}" defer></script>
<script src="{{asset('assets/css/icons.min.css')}}" defer></script>
<script src="{{asset('assets/css/bootstrap-dark.min.css')}}" defer></script>

<!-- Required datatable js -->
<script src="{{asset('js/libs/datatables.net/js/jquery.dataTables.min.js')}}" defer></script>
<script src="{{asset('js/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}" defer></script>
<!-- Buttons examples -->
<script src="{{asset('js/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}" defer></script>
<script src="{{asset('js/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}" defer></script>
<script src="{{asset('js/libs/jszip/jszip.min.js')}}" defer></script>
<script src="{{asset('js/libs/pdfmake/build/pdfmake.min.js')}}" defer></script>
<script src="{{asset('js/libs/pdfmake/build/vfs_fonts.js')}}" defer></script>
<script src="{{asset('js/libs/datatables.net-buttons/js/buttons.html5.min.js')}}" defer></script>
<script src="{{asset('js/libs/datatables.net-buttons/js/buttons.print.min.js')}}" defer></script>
<script src="{{asset('js/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}" defer></script>

<!-- Responsive examples -->
<script src="{{asset('js/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}" defer></script>
<script src="{{asset('js/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}" defer></script>

<!-- Datatable init js -->
<script src="{{asset('js/pages/datatables.init.js')}}"defer></script>

<!-- <script src="{{asset('js/app.js')}}" defer></script> -->

<!-- Begin page -->
<div id="layout-wrapper">

    @include("partials/menu")

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Product</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                                    <li class="breadcrumb-item"><a href="/admin/products">Products</a></li>
                                    <li class="breadcrumb-item active">Product Edit</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab" aria-selected="true">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">General</span> 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#discord" role="tab" aria-selected="false">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Discord</span> 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab" aria-selected="false">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Subscriptions</span> 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab" aria-selected="false">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Announcements</span>   
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="home1" role="tabpanel">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium mb-2">Price</p>
                                                        <h4 class="mb-0">${{$product->price}}</h4>
                                                    </div>
        
                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-check-circle font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium mb-2">MRR</p>
                                                        <h4 class="mb-0">${{$product->getmrr()}}/mo</h4>
                                                    </div>
        
                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-package font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium mb-2">Total Revenue</p>
                                                        <h4 class="mb-0">${{$product->totalRevenue()}}</h4>
                                                    </div>
        
                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-hourglass font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium mb-2">Subscribers</p>
                                                        <h4 class="mb-0">{{count($product->getSubscriptions)}}</h4>
                                                    </div>
        
                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                            <i class="bx bx-hourglass font-size-24"></i>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Edit Product</h4>
                                        <form class="outer-repeater" method="post">
                                            <div data-repeater-list="outer-group" class="outer">
                                                <div data-repeater-item="" class="outer">
                                                    <div class="form-group mb-4">
                                                        <label for="taskname" class="col-form-label">Product Name</label>
                                                        <input id="taskname" name="productName" type="text" class="form-control" value="{{$product->name}}">
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label class="col-form-label">Product Description</label>
                                                        <textarea id="taskdesc-editor" class="form-control" name="productDescription">{{$product->description}}</textarea>
                                                    </div>
                                                    <div class="form-group row mb-4">
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Display Price (USD)</label>
                                                            <input id="taskbudget" name="productPrice" type="text" value="{{$product->price}}" class="form-control">
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Stripe Product</label>
                                                            <select name="stripePid" class="form-select">
                                                                @foreach ($prices as $price)
                                                                    <option value="{{$price->id}}" {{($price->id == $product->stripePid ? "selected" : "")}}>${{ $price->unit_amount/100 }} || {{ $price->id }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Product Status</label>
                                                            <select name="productStatus" class="form-select">
                                                                <option  {{ ($product->visible == 1) ? 'selected' : '' }} value="1">Live</option>
                                                                <option  {{ ($product->visible == 0) ? 'selected' : '' }} value="0">Offline</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Free Trial</label>
                                                            <select name="trialStatus" class="form-select">
                                                                <option  {{ ($product->trial == 0) ? 'selected' : '' }} value="0">False</option>
                                                                <option  {{ ($product->trial == 1) ? 'selected' : '' }} value="1">True</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-4">
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Trial Length</label>
                                                            <input id="taskbudget" name="trialDays" type="text" value="{{$product->trial_period}}" placeholder="Enter Trial Period..." class="form-control">
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Product Type</label>
                                                            <input id="taskbudget" type="text" value="{{$product->channel_type == 1 ? 'Curated Category' : 'Webhook'}}" readonly class="form-control">
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="justify-content-center">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                    <div class="tab-pane" id="discord" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Category</h4>
                                <?php if ($product->controlCategory !== null){?>
                                <form class="outer-repeater" method="POST" action="{{url("/admin/product/category/update")}}">
                                    @csrf
                                    <div data-repeater-list="outer-group" class="outer">
                                        <div data-repeater-item="" class="outer">
                                            <div class="form-group mb-4">
                                                <label class="col-form-label">Discord Category ID</label>
                                                <input id="taskname" name="category" type="text" class="form-control" value="{{$product->controlCategory->categoryId}}" readonly>
                                                <input type="hidden" value="{{$product->id}}" name="product"/>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="justify-content-center">
                                        <button type="submit" class="btn btn-primary">Change Category</button>
                                    </div> -->
                                </form>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-nowrap table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Channel Name</th>
                                                <th scope="col">Channel Id</th>
                                                <th scope="col">Linked Channels</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product->controlCategory->controlchannels as $channel)

                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$channel->name}}</td>
                                                <td>{{$channel->channel_id}}</td>
                                                <td>{{count($channel->channels)}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <?php } else { ?>
                                <form class="outer-repeater" method="POST" action="{{url("/admin/product/category/create")}}">
                                    @csrf
                                    <div data-repeater-list="outer-group" class="outer">
                                        <div data-repeater-item="" class="outer">
                                            <div class="form-group mb-4">
                                                <label class="col-form-label">Discord Category ID</label>
                                                <input id="taskname" name="category" type="text" class="form-control" placeholder="Enter Discord Category ID">
                                                <input type="hidden" value="{{$product->id}}" name="product"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="justify-content-center">
                                        <button type="submit" class="btn btn-primary">Create Category</button>
                                    </div>
                                </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="profile1" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <h4 class="card-title">Subscriptions Table</h4>
        
                                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 20px;" class="align-middle">
                                                        <div class="form-check font-size-16">
                                                            <input class="form-check-input" type="checkbox" id="checkAll">
                                                            <label class="form-check-label" for="checkAll"></label>
                                                        </div>
                                                    </th>
                                                    <th class="align-middle">Server Name</th>
                                                    <th class="align-middle">Server ID</th>
                                                    <th class="align-middle">User</th>
                                                    <th class="align-middle">Total</th>
                                                    <th class="align-middle">Payment Method</th>
                                                    <th class="align-middle">Start Date</th>
                                                    <th class="align-middle">Next Charge Date</th>
                                                    <th class="align-middle">View Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                @foreach($product->getPlans as $plan)
                                                <tr>
                                                    <th scope="row">{{$plan->id}}</th>
                                                    <th scope="row">{{$plan->getBusiness->server->name}}</th>
                                                    <th scope="row">{{$plan->getBusiness->server->guild_id}}</th>
                                                    <th scope="row"><a href="https://admin.mocean.info/admin/user/{{$plan->getUser->id}}">{{$plan->getUser->username}}</a></th>
                                                    <th scope="row">${{$plan->getSubscription->pay_amount ?? 0}}/mo</th>
                                                    <td><span class="badge badge-pill badge-soft-primary font-size-12">Stripe</span></td>
                                                    <th scope="row">{{$plan->creationDate}}</th>
                                                    <th scope="row">{{($plan->getSubscription) ? $plan->getSubscription->getNextChargeDate() : null}}</th>
                                                    <td style="width: 100px">
                                                        <a href="/admin/plan/{{$plan->id}}/delete" class="btn btn-outline-secondary btn-sm edit" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                    </div>
                    <div class="tab-pane" id="messages1" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Announcements</h4>
                            <form class="outer-repeater" method="POST" action="{{url("/api/announcement")}}">
                                @csrf
                                <div data-repeater-list="outer-group" class="outer">
                                    <div data-repeater-item="" class="outer">
                                        <div class="form-group mb-4">
                                            <label class="col-form-label">Announcement</label>
                                            <textarea id="taskdesc-editor" class="form-control" name="announcementText"></textarea>
                                            <!-- {{ !! csrf_field() }} -->
                                            <input type="hidden" value="{{$product->id}}" name="hidden"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="justify-content-center">
                                    <button type="submit" class="btn btn-primary">Post Announcement</button>
                                </div>
                            </form>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-nowrap table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Announcement</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($announcement as $item)

                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$item->announcement}}</td>
                                            <td style="width: 100px">
                                                <form method="POST" action="{{Route('delete',['id'=>$item->id])}}">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                    <button href="" class="btn btn-outline-secondary btn-sm edit" type="submit" title="Delete">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

            </div>
            <!-- container-fluid -->
        </div>
        
    </div>
</div>
</div>
<!-- end row -->

</div>
<!-- container-fluid -->
</div>
<!-- End Page-content -->


@extends("partials/footer")
</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->

@extends("partials/right-sidebar")




</body>

</html>
