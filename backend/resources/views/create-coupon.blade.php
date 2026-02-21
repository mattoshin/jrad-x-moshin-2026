@extends("partials/main")
<!-- <?php
    ?> -->
<head>
    @extends("partials/title-meta")
    @section('pageTitle')
    Create Coupons
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
<script src="{{asset('js/app.js')}}" defer></script>
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
            <!-- end page title -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Create Coupon</h4>
                            <form class="outer-repeater" name="product" method="post" action="/admin/save-coupon">
                                @csrf
                                <div data-repeater-list="outer-group" class="outer">
                                    <div data-repeater-item="" class="outer">
                                        <div class="form-group mb-4">
                                            <label for="prod_name" class="col-form-label">Coupon Name</label>
                                            <input id="prod_name" name="prod_name" type="text" class="form-control" placeholder="100off">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="col-form-label">Coupon Description</label>
                                            <textarea id="prod_descr" class="form-control" name="prod_descr"></textarea>
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
                                    <a href="/admin/coupon/1" class="btn btn-primary">Create Coupon</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page-content -->
        <!-- end modal -->
        @extends("partials/footer")
    </div>
    <!-- end main content-->
</div>
</div>
<!-- END layout-wrapper -->
@extends("partials/right-sidebar")
</body>
</html>