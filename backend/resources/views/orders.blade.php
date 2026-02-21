@extends("partials/main")

<head>

    @extends("partials/title-meta") 
    @section('page-title')
    Orders page
    @endSection
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

@extends("partials/body")

<div class="se-pre-con"></div>
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
                            <h4 class="mb-sm-0 font-size-18">Invoices</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                    <li class="breadcrumb-item active">Invoices</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title">Invoice Table</h4>

                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="align-middle">Order ID</th>
                                            <th class="align-middle">Server Name</th>
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
                                            <td>{{$order->getBusiness->server->name}}</td>
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
                                            <td style="width: 100px">
                                                <a href="{{$order->invoice_url}}" class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <a href="/admin/invoice/{{$order->id}}" class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
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
@extends("partials/vendor-scripts")



</body>

</html>
