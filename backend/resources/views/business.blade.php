@extends("partials/main")
<?php 
    use App\Http\Controllers\BusinessController;
    
    $invoiceDetails = BusinessController::getAdminInvoices($business);
    $discordDetails = BusinessController::getDiscordDetails($business);
    $activeProducts = BusinessController::getAdminActiveProducts($business);
    $owner = BusinessController::getAdminOwner($business);
?>
<head>

    @extends("partials/title-meta")
    @section('pageTitle')
    Business Page
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

<div class="se-pre-con"></div>
<!-- Begin page -->
<div id="layout-wrapper">

    @extends("partials/menu")

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab" aria-selected="true">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">General</span> 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#users2" role="tab" aria-selected="false">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Users</span> 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab" aria-selected="false">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Invoices</span> 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab" aria-selected="false">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Products</span>   
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#messages2" role="tab" aria-selected="false">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Discord</span>   
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
                                                        <p class="text-muted fw-medium mb-2">Admins</p>
                                                        <h4 class="mb-0">1</h4>
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
                                                        <p class="text-muted fw-medium mb-2">Active Products</p>
                                                        <h4 class="mb-0">{{ $activeProducts["total"] }}</h4>
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
                                                        <p class="text-muted fw-medium mb-2">Discord Users</p>
                                                        <h4 class="mb-0">{{ $discordDetails['guild']['members'] }}</h4>
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
                                                        <p class="text-muted fw-medium mb-2">Total Spent</p>
                                                        <h4 class="mb-0">${{ $invoiceDetails["totalPaid"] }}</h4>
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
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Business Information</h4>
                                        <form>
                                            <div class="row">
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Name</label>
                                                        <input class="form-control" type="text" value="{{ $business->name }}" id="example-text-input" disabled>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Email</label>
                                                        <input class="form-control" type="text" value="{{$business->email}}" id="example-text-input" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Twitter</label>
                                                        <input class="form-control" type="text" value="{{$business->twitter}}" id="example-text-input" disabled>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Website</label>
                                                        <input class="form-control" type="text" value="{{$business->website}}" id="example-text-input" disabled>
                                                    </div>
                                                </div>                                                
                                                <div class="col-12 mb-4">
                                                    <label class="col-form-label">Description</label>
                                                    <textarea id="taskdesc-editor" class="form-control" name="outer-group[0][area]" disabled>{{$business->description}}</textarea>
                                                </div>
                                                
                                                
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Location</label>
                                                        <input class="form-control" type="text" value="{{$business->location}}" id="example-text-input" disabled>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Currency</label>
                                                        <input class="form-control" type="text" value="{{$business->currency}}" id="example-text-input" disabled>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Phone</label>
                                                        <input class="form-control" type="text" value="{{$business->phone}}" id="example-text-input" disabled>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Creation Date</label>
                                                        <input class="form-control" type="text" value="{{$business->creationDate}}" id="example-text-input" disabled>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Last Updated</label>
                                                        <input class="form-control" type="text" value="{{$business->updateDate}}" id="example-text-input" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- <div class="justify-content-center">
                                                <button type="submit" class="btn btn-primary">Edit Business</button>
                                            </div> -->
                        
                                        </form>
                        
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                    <div class="tab-pane" id="profile1" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <h4 class="card-title">Invoice Table</h4>
        
                                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead class="table-light">
                                                <tr>
                                                    <!-- <th style="width: 20px;" class="align-middle">
                                                        <div class="form-check font-size-16">
                                                            <input class="form-check-input" type="checkbox" id="checkAll">
                                                            <label class="form-check-label" for="checkAll"></label>
                                                        </div>
                                                    </th> -->
                                                    <th class="align-middle">Order ID</th>
                                                    <th class="align-middle">Product</th>
                                                    <th class="align-middle">Billing Name</th>
                                                    <th class="align-middle">Total</th>
                                                    <th class="align-middle">Payment Status</th>
                                                    <th class="align-middle">Payment Method</th>
                                                    <th class="align-middle">Start Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($invoiceDetails["invoices"] as $invoice)
                                                <tr>
                                                    <th scope="row">{{$invoice["id"]}}</th>
                                                    <td>{{$invoice["product"]["name"]}}</td>
                                                    <td>{{$invoice["billing_name"]}}</td>
                                                    <td>{{$invoice["payment_amount"]}}</td>
                                                    <td><?php
                                                        echo ($invoice["paid"] ? '<span class="badge badge-pill badge-soft-success font-size-12">Paid</span>': '<span class="badge badge-pill badge-soft-danger font-size-12">Unpaid</span>')
                                                    ?></td>
                                                    <td><span class="badge badge-pill badge-soft-primary font-size-12">Stripe</span></td>
                                                    <td>{{$invoice["creation_date"]}}</td>
                                                </tr>
                                                
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                    </div><div class="tab-pane" id="users2" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <h4 class="card-title">Users Table</h4>
        
                                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 20px;" class="align-middle">
                                                        <div class="form-check font-size-16">
                                                            <input class="form-check-input" type="checkbox" id="checkAll">
                                                            <label class="form-check-label" for="checkAll"></label>
                                                        </div>
                                                    </th>
                                                    <th class="align-middle">User ID</th>
                                                    <th class="align-middle">Discord ID</th>
                                                    <th class="align-middle">Discord Name</th>
                                                    <th class="align-middle">Permissions</th>
                                                    <th class="align-middle">Date Joined</th>
                                                    <th class="align-middle">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            <tr>
                                                    <td>
                                                        <div class="form-check font-size-16">
                                                            <input class="form-check-input" type="checkbox" id="orderidcheck01">
                                                            <label class="form-check-label" for="orderidcheck01"></label>
                                                        </div>
                                                    </td>
                                                    <td><a href="javascript: void(0);" class="text-body fw-bold">{{$owner["id"]}}</a> </td>
                                                    <td>{{$owner["discord_id"]}}</td>
                                                    <td>
                                                        {{$owner["username"]}}
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pill badge-soft-primary font-size-12">Owner</span>
                                                    </td>
                                                    <td>
                                                        {{$owner["join_date"]}}
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-3">
                                                            <a href="/admin/user/{{$owner['id']}}" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <!-- <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a> -->
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- <tr>
                                                    <td>
                                                        <div class="form-check font-size-16">
                                                            <input class="form-check-input" type="checkbox" id="orderidcheck01">
                                                            <label class="form-check-label" for="orderidcheck01"></label>
                                                        </div>
                                                    </td>
                                                    <td><a href="javascript: void(0);" class="text-body fw-bold">1</a> </td>
                                                    <td>452425590382002176</td>
                                                    <td>
                                                        fakeuser#0001
                                                    </td>
                                                    <td>
                                                    <span class="badge badge-pill badge-soft-danger font-size-12">Admin</span> <span class="badge badge-pill badge-soft-success font-size-12">Billing</span> <span class="badge badge-pill badge-soft-info font-size-12">Users</span>
                                                    </td>
                                                    <td>
                                                        05/02/2022
                                                    </td>
                                                    <td>
                                                        05/02/2022
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-3">
                                                            <a href="order" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a>
                                                        </div>
                                                    </td>
                                                </tr> -->
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
                                <h4 class="card-title mb-4">Active Products</h4>
                                <div class="table-responsive">
                                    <table class="table table-nowrap table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Product Type</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">Monthly</th>
                                                <th scope="col">Action</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($activeProducts["products"] as $product)
                                            <tr>
                                                <th scope="row">{{$product["id"]}}</th>
                                                <td>{{$product["name"]}}</td>
                                                <td>{{$product["channel_type"]}}</td>
                                                <td>{{$product["start_date"]}}</td>
                                                <td>{{$product["price"]}}</td>
                                                <td>
                                                    <div class="d-flex gap-3">
                                                        <a href="/admin/plan/{{$product['id']}}" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="messages2" role="tabpanel">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium mb-2">Admins</p>
                                                <h4 class="mb-0">1</h4>
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
                                                <p class="text-muted fw-medium mb-2">Discord Users</p>
                                                <h4 class="mb-0">{{ $discordDetails['guild']['members'] }}</h4>
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
                                                <p class="text-muted fw-medium mb-2">Active Products</p>
                                                <h4 class="mb-0">disabled</h4>
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
                                                <p class="text-muted fw-medium mb-2">Total Mocean Channels</p>
                                                <h4 class="mb-0">disabled</h4>
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
                        <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Business Information</h4>
                                        <form>
                                            <div class="row">
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Server Owner</label>
                                                        <input class="form-control" type="text" value="{{ $discordDetails['guild']['owner'] }}" id="example-text-input" readonly>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Server ID</label>
                                                        <input class="form-control" type="text" value="{{ $discordDetails['guild']['id'] }}" id="example-text-input" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Categories</label>
                                                        <input class="form-control" type="text" value="{{ $discordDetails['guild']['categories'] }}" id="example-text-input" readonly>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Text Channels</label>
                                                        <input class="form-control" type="text" value="{{ $discordDetails['guild']['text_channels'] }}" id="example-text-input" readonly>
                                                    </div>
                                                </div>   
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Voice Channels</label>
                                                        <input class="form-control" type="text" value="{{ $discordDetails['guild']['voice_channels'] }}" id="example-text-input" readonly>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Roles</label>
                                                        <input class="form-control" type="text" value="{{ $discordDetails['guild']['roles'] }}" id="example-text-input" readonly>
                                                    </div>
                                                </div>      
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Region</label>
                                                        <input class="form-control" type="text" value="{{ $discordDetails['guild']['region'] }}" id="example-text-input" readonly>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-6 col-xs-12">
                                                    <div class="mb-3">
                                                        <label for="productname">Members</label>
                                                        <input class="form-control" type="text" value="{{ $discordDetails['guild']['members'] }}" id="example-text-input" readonly>
                                                    </div>
                                                </div>                   
                                            </div>
<!--                                             
                                            <div class="justify-content-center">
                                                <button type="submit" class="btn btn-primary">Reset Discord</button>
                                            </div> -->
                        
                                        </form>
                        
                                    </div>
                                </div>    
                    </div>
                </div>

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


        @extends("partials/footer")
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

@extends("partials/vendor-scripts")



</body>

</html>
