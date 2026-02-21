@extends("partials/main")
<!-- <?php
    ?> -->
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
            <!-- end page title -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Add Product</h4>
                            <form class="outer-repeater" name="product" method="post" action="/admin/save-product">
                                @csrf
                                <div data-repeater-list="outer-group" class="outer">
                                    <div data-repeater-item="" class="outer">
                                        <div class="form-group mb-4">
                                            <label for="prod_name" class="col-form-label">Product Name</label>
                                            <input id="prod_name" name="prod_name" type="text" class="form-control" placeholder="Enter Product Name">
                                        </div>
                                        @error('prod_name')
                                        <span class="text-danger">
                                        <strong>
                                        Please enter product name.
                                        </strong>
                                        </span>
                                        @enderror
                                        <div class="form-group mb-4">
                                            <label class="col-form-label">Product Description</label>
                                            <textarea id="prod_descr" class="form-control" name="prod_descr"></textarea>
                                            @error('prod_descr')
                                            <span class="text-danger">
                                            <strong>
                                            Please select category.
                                            </strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-4">
                                            <div class="col-3">
                                                <label for="prod_amount" class="col-form-label">Price</label>
                                                <input id="prod_amount" name="prod_amount" type="text" placeholder="Enter Product Price..." class="form-control">
                                                @error('prod_amount')
                                                <span class="text-danger">
                                                <strong>
                                                Please enter amount.
                                                </strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <!-- <div class="col-3">
                                                <label for="taskbudget" class="col-form-label">Category</label>
                                                <select class="form-select" name="product_cate" id="product_cate" >
                                                    <option value="">--Select--</option>
                                                    @foreach($categories as $cate_option)
                                                    <option value="{{$cate_option->id}}">{{$cate_option->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('product_cate')
                                                <span class="text-danger">
                                                <strong>
                                                Please select category.
                                                </strong>
                                                </span>
                                                @enderror
                                            </div> -->
                                            <div class="col-3">
                                                <label for="taskbudget" class="col-form-label">Product Type</label>
                                                <select name="product_type" id="trial_status" class="form-select">
                                                    <option value="1">Curated</option>
                                                    <option value="2">Webhook</option>
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <label for="product_status" class="col-form-label">Product Status</label>
                                                <select name="product_status" id="product_status" class="form-select">
                                                    <option value="1">Live</option>
                                                    <option value="0">Offline</option>
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <label for="taskbudget" class="col-form-label">Free Trial</label>
                                                <select name="trial_status" id="trial_status" class="form-select">
                                                    <option value="1">True</option>
                                                    <option value="0" selected>False</option>
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <label for="taskbudget" class="col-form-label">Trial Length</label>
                                                <input type="input" class="form-control" name="trial_day" id="trial_day" minlength="1" maxlength="730">
                                                @error('trial_day')
                                                <span class="text-danger">
                                                <strong>
                                                Please select product status.
                                                </strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-3">
                                                <label for="category_id" class="col-form-label">Discord Category ID</label>
                                                <input id="category_id" name="category_id" type="text" placeholder="Enter Category ID..." class="form-control">
                                                @error('prod_amount')
                                                <span class="text-danger">
                                                    <strong>
                                                    Please enter amount.
                                                    </strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="justify-content-center">
                                    <button type="submit" class="btn btn-primary">Add Product</button>
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
