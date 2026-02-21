@include("partials/main")
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
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Product Category</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('manageCategory') }}">Category</a></li>
                                    <li class="breadcrumb-item active">Add Category</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
				<div class="alert alert-success alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>	
				        <strong>{{ $message }}</strong>
				</div>
				@endif
                <!-- end page title -->
                <div class="row">
                   <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Product Category</h4>
                                <form class="outer-repeater" name="add-category" method="post" action="/admin/category/update/{{$category_data->id}}">
                                    @csrf
                                    <div data-repeater-list="outer-group" class="outer">
                                        <div data-repeater-item="" class="outer">
                                            <div class="form-group mb-4 col-6">
                                                <label for="taskname" class="col-form-label">Category name</label>
                                                <input id="cate_name" name="cate_name" type="text" class="form-control" placeholder="Enter category name" value="{{$category_data->name}}">
                                            </div>

                                            <div class="form-group mb-4 col-6">
                                                <label class="col-form-label">Description</label>
                                                <textarea id="cate_descr" class="form-control" name="cate_descr">{{$category_data->description}}</textarea>
                                            </div>

                                            <div class="col-3">
                                                <label for="taskbudget" class="col-form-label">Category Type</label>
                                                <select name="cate_type" id="cate_type" class="form-select">
                                                    <option {{ ($category_data->type == '1') ? 'selected' : '' }} value="1">Curated</option>
                                                    <option {{ ($category_data->type == '2') ? 'selected' : '' }} value="2">Webhook</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="justify-content-center mt-3">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
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
