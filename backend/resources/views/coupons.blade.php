
@extends("partials/main")

<head>

    @extends("partials/title-meta")
    @section('pageTitle')
    Starter Page
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
                            <h4 class="mb-sm-0 font-size-18">Coupons</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                    <li class="breadcrumb-item active">Coupons</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12 mb-3">
                        <a href="/admin/create-coupon" class="btn btn-primary float-right">Create Coupon</a>
                    </div>
                
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Coupon Table</h4>
                                <!-- <button type="button"><i class="class"></i></button> -->

                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Coupon Name</th>
                                            <th>Amount Off</th>
                                            <th>Affected Products</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                        
                                        <tr>
                                        <td>1</td>
                                        <td>freecoupon100off</td>
                                        <td>100%</td>
                                        <td>3</td>
                                        <td style="width: 100px">
                                            <a href="coupon/1" class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <a href="coupon/1" class="btn btn-outline-secondary btn-sm edit" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        </tr>
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
        <!-- end modal -->

    @extends("partials/footer")
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

@extends("partials/right-sidebar")



</body>

</html>