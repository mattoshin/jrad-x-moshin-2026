@include("partials/main")

<head>

    @extends("partials/title-meta")
    @section('pageTitle')
    Coupon Page
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
                            <h4 class="mb-sm-0 font-size-18">Coupon</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                                    <li class="breadcrumb-item"><a href="/admin/coupons">Coupons</a></li>
                                    <li class="breadcrumb-item active">Coupon Edit</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>


                    <div class="tab-pane active" id="home1" role="tabpanel">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <p class="text-muted fw-medium mb-2">Uses</p>
                                                        <h4 class="mb-0">10</h4>
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
                                                        <p class="text-muted fw-medium mb-2">Total Revenue</p>
                                                        <h4 class="mb-0">$1,000</h4>
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
                                                        <p class="text-muted fw-medium mb-2">Total Discounted Revenue</p>
                                                        <h4 class="mb-0">$220</h4>
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
                                                        <p class="text-muted fw-medium mb-2">placeholder</p>
                                                        <h4 class="mb-0">0</h4>
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
                                        <h4 class="card-title mb-4">Edit Coupon</h4>
                                        <form class="outer-repeater" method="post">
                                            <div data-repeater-list="outer-group" class="outer">
                                                <div data-repeater-item="" class="outer">
                                                    <div class="form-group mb-4">
                                                        <label for="taskname" class="col-form-label">Coupon Name</label>
                                                        <input id="taskname" name="outer-group[0][taskname]" type="text" class="form-control" value="example">
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label class="col-form-label">Coupon Description</label>
                                                        <textarea id="taskdesc-editor" class="form-control" name="outer-group[0][area]">example</textarea>
                                                    </div>
                                                    <div class="form-group row mb-4">
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Price Off (USD or %)</label>
                                                            <input id="taskbudget" name="outer-group[0][taskbudget]" type="text" value="100%" class="form-control">
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Products</label>
                                                            <select class="form-select">
                                                                <option>ok</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Coupon Status</label>
                                                            <select class="form-select">
                                                                <option>Live</option>
                                                                <option>Offline</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Coupon Time Period</label>
                                                            <input id="taskbudget" name="outer-group[0][taskbudget]" type="text" value="2 months" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="justify-content-center">
                                                <button type="submit" class="btn btn-primary">Edit Coupon</button>
                                                <button type="submit" class="btn btn-danger">Delete Coupon</button>
                                            </div>
                                        </form>
        
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="card-title">Lastest Invoices</h4>

                                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 20px;" class="align-middle">
                                                        <div class="form-check font-size-16">
                                                            <input class="form-check-input" type="checkbox" id="checkAll">
                                                            <label class="form-check-label" for="checkAll"></label>
                                                        </div>
                                                    </th>
                                                    <th class="align-middle">Order ID</th>
                                                    <th class="align-middle">Billing Name</th>
                                                    <th class="align-middle">Date</th>
                                                    <th class="align-middle">Total</th>
                                                    <th class="align-middle">Payment Status</th>
                                                    <th class="align-middle">Payment Method</th>
                                                    <th class="align-middle">View Details</th>
                                                    <th class="align-middle">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- <tr>
                                                    <td>
                                                        <div class="form-check font-size-16">
                                                            <input class="form-check-input" type="checkbox" id="orderidcheck01">
                                                            <label class="form-check-label" for="orderidcheck01"></label>
                                                        </div>
                                                    </td>
                                                    <td><a href="javascript: void(0);" class="text-body fw-bold">#JKASfjASf</a> </td>
                                                    <td>Joseph Socket</td>
                                                    <td>
                                                        05/02/2022
                                                    </td>
                                                    <td>
                                                        $230
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pill badge-soft-success font-size-12">Paid</span>
                                                    </td>
                                                    <td>
                                                        <i class="fab fa-cc-mastercard me-1"></i> 1232
                                                    </td>
                                                    <td>
                                                        
                                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target=".orderdetailsModal">
                                                            <a href="/orders/details/2">
                                                                View Details
                                                            </a>
                                                        </button>
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
