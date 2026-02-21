@extends("partials/main")

<head>

    @extends("partials/title-meta", {"title": "Starter Page"}) @extends("partials/head-css")

</head>

@extends("partials/body")

<!-- Begin page -->
<div id="layout-wrapper">

    @extends("partials/menu")

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                @extends("partials/page-title", {"pagetitle": "Contacts", "title": "Profile"})

                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab" aria-selected="true">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">General</span> 
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
                                                        <h4 class="mb-0">$99.99</h4>
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
                                                        <h4 class="mb-0">$27,120/mo</h4>
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
                                                        <h4 class="mb-0">$524,912</h4>
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
                                                        <h4 class="mb-0">274</h4>
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
                                        <h4 class="card-title mb-4">Create New Product</h4>
                                        <form class="outer-repeater" method="post">
                                            <div data-repeater-list="outer-group" class="outer">
                                                <div data-repeater-item="" class="outer">
                                                    <div class="form-group mb-4">
                                                        <label for="taskname" class="col-form-label">Product Name</label>
                                                        <input id="taskname" name="outer-group[0][taskname]" type="text" class="form-control" placeholder="NFT Monitor">
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label class="col-form-label">Product Description</label>
                                                        <textarea id="taskdesc-editor" class="form-control" name="outer-group[0][area]"></textarea>
                                                    </div>
                                                    <div class="form-group row mb-4">
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Price</label>
                                                            <input id="taskbudget" name="outer-group[0][taskbudget]" type="text" placeholder="Enter Product Price..." class="form-control">
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Stripe Product</label>
                                                            <select class="form-select">
                                                                <option>askjfasf</option>
                                                                <option>askjfasf</option>
                                                                <option>askjfasf</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Product Status</label>
                                                            <select class="form-select">
                                                                <option>Live</option>
                                                                <option>Offline</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Free Trial</label>
                                                            <select class="form-select">
                                                                <option>True</option>
                                                                <option>False</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-4">
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Trial Time</label>
                                                            <input id="taskbudget" name="outer-group[0][taskbudget]" type="text" placeholder="Enter Product Price..." class="form-control">
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Product Type</label>
                                                            <select class="form-select">
                                                                <option>Sync</option>
                                                                <option>Webhook</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Moveable Channels</label>
                                                            <select class="form-select">
                                                                <option>True</option>
                                                                <option>False</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-3">
                                                            <label for="taskbudget" class="col-form-label">Category ID</label>
                                                            <input id="taskbudget" name="outer-group[0][taskbudget]" type="text" placeholder="Enter Product Price..." class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </form>
                                        <div class="justify-content-center">
                                            <button type="submit" class="btn btn-primary">Edit Product</button>
                                        </div>
        
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
                                                <tr>
                                                    <td>
                                                        <div class="form-check font-size-16">
                                                            <input class="form-check-input" type="checkbox" id="orderidcheck01">
                                                            <label class="form-check-label" for="orderidcheck01"></label>
                                                        </div>
                                                    </td>
                                                    <td><a href="javascript: void(0);" class="text-body fw-bold">#SK2540</a> </td>
                                                    <td>Neal Matthews</td>
                                                    <td>
                                                        07 Oct, 2019
                                                    </td>
                                                    <td>
                                                        $400
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pill badge-soft-success font-size-12">Paid</span>
                                                    </td>
                                                    <td>
                                                        <i class="fab fa-cc-mastercard me-1"></i> Mastercard
                                                    </td>
                                                    <td>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target=".orderdetailsModal">
                                                            View Details
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-3">
                                                            <a href="javascript:void(0);" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            
                                                <tr>
                                                    <td>
                                                        <div class="form-check font-size-16">
                                                            <input class="form-check-input" type="checkbox" id="orderidcheck02">
                                                            <label class="form-check-label" for="orderidcheck02"></label>
                                                        </div>
                                                    </td>
                                                    <td><a href="javascript: void(0);" class="text-body fw-bold">#SK2541</a> </td>
                                                    <td>Jamal Burnett</td>
                                                    <td>
                                                        07 Oct, 2019
                                                    </td>
                                                    <td>
                                                        $380
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pill badge-soft-danger font-size-12">Chargeback</span>
                                                    </td>
                                                    <td>
                                                        <i class="fab fa-cc-visa me-1"></i> Visa
                                                    </td>
                                                    <td>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target=".orderdetailsModal">
                                                            View Details
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-3">
                                                            <a href="javascript:void(0);" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            
                                                <tr>
                                                    <td>
                                                        <div class="form-check font-size-16">
                                                            <input class="form-check-input" type="checkbox" id="orderidcheck03">
                                                            <label class="form-check-label" for="orderidcheck03"></label>
                                                        </div>
                                                    </td>
                                                    <td><a href="javascript: void(0);" class="text-body fw-bold">#SK2542</a> </td>
                                                    <td>Juan Mitchell</td>
                                                    <td>
                                                        06 Oct, 2019
                                                    </td>
                                                    <td>
                                                        $384
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pill badge-soft-success font-size-12">Paid</span>
                                                    </td>
                                                    <td>
                                                        <i class="fab fa-cc-paypal me-1"></i> Paypal
                                                    </td>
                                                    <td>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target=".orderdetailsModal">
                                                            View Details
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-3">
                                                            <a href="javascript:void(0);" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check font-size-16">
                                                            <input class="form-check-input" type="checkbox" id="orderidcheck04">
                                                            <label class="form-check-label" for="orderidcheck04"></label>
                                                        </div>
                                                    </td>
                                                    <td><a href="javascript: void(0);" class="text-body fw-bold">#SK2543</a> </td>
                                                    <td>Barry Dick</td>
                                                    <td>
                                                        05 Oct, 2019
                                                    </td>
                                                    <td>
                                                        $412
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pill badge-soft-success font-size-12">Paid</span>
                                                    </td>
                                                    <td>
                                                        <i class="fab fa-cc-mastercard me-1"></i> Mastercard
                                                    </td>
                                                    <td>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target=".orderdetailsModal">
                                                            View Details
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-3">
                                                            <a href="javascript:void(0);" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check font-size-16">
                                                            <input class="form-check-input" type="checkbox" id="orderidcheck05">
                                                            <label class="form-check-label" for="orderidcheck05"></label>
                                                        </div>
                                                    </td>
                                                    <td><a href="javascript: void(0);" class="text-body fw-bold">#SK2544</a> </td>
                                                    <td>Ronald Taylor</td>
                                                    <td>
                                                        04 Oct, 2019
                                                    </td>
                                                    <td>
                                                        $404
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-pill badge-soft-warning font-size-12">Refund</span>
                                                    </td>
                                                    <td>
                                                        <i class="fab fa-cc-visa me-1"></i> Visa
                                                    </td>
                                                    <td>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target=".orderdetailsModal">
                                                            View Details
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-3">
                                                            <a href="javascript:void(0);" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                            <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
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
                                    <form class="outer-repeater" method="post">
                                        <div data-repeater-list="outer-group" class="outer">
                                            <div data-repeater-item="" class="outer">
                                                <div class="form-group mb-4">
                                                    <label class="col-form-label">Announcement</label>
                                                    <textarea id="taskdesc-editor" class="form-control" name="outer-group[0][area]"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="justify-content-center">
                                        <button type="submit" class="btn btn-primary">Post Announcement</button>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Announcement</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</td>
                                                    <td>04/05/2022</td>
                                                    <td style="width: 100px">
                                                        <a href="#" class="btn btn-outline-secondary btn-sm edit" title="Delete">
                                                                    Delete
                                                                </a>
                                                    </td>
                                                </tr>
        
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
        <!-- End Page-content -->


        @extends("partials/footer")
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

@extends("partials/right-sidebar") @extends("partials/vendor-scripts")

<!-- JAVASCRIPT -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<script src="assets/js/pages/profile.init.js"></script>

<!-- Required datatable js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="assets/libs/jszip/jszip.min.js"></script>
<script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<!-- Responsive examples -->
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<!-- Datatable init js -->
<script src="assets/js/pages/datatables.init.js"></script>
        <!-- App js -->
        <script src="assets/js/app.js"></script>

</body>

</html>