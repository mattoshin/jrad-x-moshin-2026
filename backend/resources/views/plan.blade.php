@extends("partials/main")
<?php 

use App\Http\Controllers\BusinessController;
    
$discordDetails = BusinessController::getDiscordDetails($plan->getBusiness);

?>
<head>

    @extends("partials/title-meta")
    @section('pageTitle')
    Monitor Page
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
                                    <p class="text-muted fw-medium mb-2">Active Channels</p>
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
                    <h4 class="card-title mb-4">Plan Information</h4>
                    <form method="POST" action="{{url("/admin/plan/".$plan->id."/update")}}">
                        <div class="row">
                            <div class="col-6 col-xs-12">
                                <div class="mb-3">
                                    <label for="productname">Name</label>
                                    <input class="form-control" type="text" value="{{$plan->name}}" id="example-text-input" name="planName">
                                </div>
                            </div>
                            
                            <div class="col-6 col-xs-12">
                                <div class="mb-3">
                                    <label for="productname">Hexcode</label>
                                    <input class="form-control" type="text" value="{{$plan->color}}" id="example-text-input" name="planColor">
                                </div>
                            </div>
                            <div class="col-6 col-xs-12">
                                <div class="mb-3">
                                    <label for="productname">Image</label>
                                    <input class="form-control" type="text" value="{{$plan->image}}" id="example-text-input" name="planImage">
                                </div>
                            </div>
                            
                            <div class="col-6 col-xs-12">
                                <div class="mb-3">
                                    <label for="productname">Role</label>
                                    <input class="form-control" type="text" value="{{$plan->role}}" id="example-text-input" name="planRole">
                                </div>
                            </div>                                                
                            
                        </div>
                        
                        <div class="justify-content-center">
                            <button type="submit" class="btn btn-primary">Edit Plan</button>
                        </div>
    
                    </form>
    
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
