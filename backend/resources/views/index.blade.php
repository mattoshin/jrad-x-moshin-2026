
@extends("partials/main")

<head>

    @extends("partials/title-meta")
    @section('pageTitle')
    Home Page
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
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

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

    @extends("partials/menu")

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

    <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="/admin/invoices">
                                    <div class="card mini-stats-wid">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-muted fw-medium">Recurring Revenue</p>
                                                    <h4 class="mb-0">${{$mrr}}/mo</h4>
                                                </div>

                                                <div class="flex-shrink-0 align-self-center">
                                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                        <span class="avatar-title rounded-circle bg-primary">
                                                                    <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="/admin/users">
                                    <div class="card mini-stats-wid">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-muted fw-medium">Active Users</p>
                                                    <h4 class="mb-0">{{$userCount}}</h4>
                                                </div>

                                                <div class="flex-shrink-0 align-self-center">
                                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                        <span class="avatar-title">
                                                                    <i class="bx bx-user-circle font-size-24"></i>
                                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Active Subscriptions</p>
                                                <h4 class="mb-0">{{$monitorsRunning}}</h4>
                                            </div>

                                            <div class="flex-shrink-0 align-self-center ">
                                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                    <span class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-archive-in font-size-24"></i>
                                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <a href="/admin/products">
                                    <div class="card mini-stats-wid">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <p class="text-muted fw-medium">Products Online</p>
                                                    <h4 class="mb-0">{{$products}}</h4>
                                                </div>

                                                <div class="flex-shrink-0 align-self-center">
                                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                        <span class="avatar-title rounded-circle bg-primary">
                                                                    <i class="bx bx-package font-size-24"></i>
                                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>
                <!-- end row -->
<!-- 
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="float-end">
                                        <div class="input-group input-group-sm">
                                            <select class="form-select form-select-sm">
                                                <option value="JA" selected>Jan</option>
                                                <option value="DE">Dec</option>
                                                <option value="NO">Nov</option>
                                                <option value="OC">Oct</option>
                                                <option value="SE">Sep</option>
                                                <option value="AU">AUG</option>
                                                <option value="JULY">July</option>
                                                <option value="JUNE">June</option>
                                                <option value="MAY">May</option>
                                                <option value="AP">April</option>
                                                <option value="MAR">Mar</option>
                                                <option value="FE">Feb</option>
                                            </select>
                                            <label class="input-group-text">Month</label>
                                        </div>
                                    </div>
                                    <h4 class="card-title mb-4">Earning</h4>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="text-muted">
                                            <div class="mb-4">
                                                <p>This month</p>
                                                <h4>$0</h4>
                                                <div><span class="badge badge-soft-success font-size-12 me-1"> + 0.0% </span> From previous period</div>
                                            </div>

                                            <div>
                                                <a href="javascript: void(0);" class="btn btn-primary waves-effect waves-light btn-sm">View Details <i class="mdi mdi-chevron-right ms-1"></i></a>
                                            </div>
                                            
                                            <div class="mt-4">
                                                <p class="mb-2">Last month</p>
                                                <h5>$0</h5>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div id="line-chart" class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Sales Analytics</h4>

                                <div>
                                    <div id="donut-chart" class="apex-charts"></div>
                                </div>

                                <div class="text-center text-muted">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mt-4">
                                                <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-primary me-1"></i> Product A</p>
                                                <h5>$ 0</h5>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mt-4">
                                                <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-success me-1"></i> Product B</p>
                                                <h5>$ 0</h5>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mt-4">
                                                <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-danger me-1"></i> Product C</p>
                                                <h5>$ 0</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Latest Transaction</h4>
                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="align-middle">Order ID</th>
                                                <th class="align-middle">Discord Username</th>
                                                <th class="align-middle">Billing Name</th>
                                                <th class="align-middle">Billing Email</th>
                                                <th class="align-middle">Date</th>
                                                <th class="align-middle">Total</th>
                                                <th class="align-middle">Payment Status</th>
                                                <th class="align-middle">View Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                            <tr>
                                                <td><a href="javascript: void(0);" class="text-body fw-bold">#{{$order->id}}</a> </td>
                                                <td>{{$order->getUser->username}}</td>
                                                <td>{{$order->billing_name}}</td>
                                                <td>{{$order->billing_email}}</td>
                                                
                                                <td>{{date_format(date_create($order->creationDate), 'm/d/Y H:i:s')}}</td>
                                                <td>
                                                    ${{$order->pay_amount}}
                                                </td>
                                                <td><?php
                                                            echo ($order->paid ? '<span class="badge badge-pill badge-soft-success font-size-12">Paid</span>': '<span class="badge badge-pill badge-soft-danger font-size-12">Unpaid</span>')
                                                        ?></td>
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <a class="btn btn-primary btn-sm btn-rounded" href="/admin/invoice/{{$order->id}}">
                                                        View Details
                                                    </a>
                                                </td>
                                                
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end table-responsive -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

    </div>
    <!-- container-fluid -->
</div>
<!-- End Page-content -->
<!-- end modal -->

@extends("partials/footer")
</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->


@section('script')
<!-- apexcharts -->
<script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- dashboard init -->
<script src="{{ URL::asset('/assets/js/pages/apexcharts.init.js') }}"></script>
@endsection

</body>

</html>
