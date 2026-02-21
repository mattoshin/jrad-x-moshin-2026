@extends("partials/main")

<head>

    @extends("partials/title-meta")
    @section("page-title")
    Order {{$order->id}}
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
                            <h4 class="mb-sm-0 font-size-18">Orders</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                    <li class="breadcrumb-item active">Orders</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="invoice-title">
                                    <h4 class="float-end font-size-16">Order # {{$order->id}}</h4>
                                    <div class="mb-4">
                                        <img src="assets/images/logo-dark.png" alt="" height="20">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="productname">Billing Name</label>
                                            <input class="form-control" type="text" value="{{ $order->billing_name }}" id="example-text-input" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="productname">Billing Address</label>
                                            <input class="form-control" type="text" value="{{$order->billing_address}}" id="example-text-input" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="productname">Billing Email</label>
                                            <input class="form-control" type="text" value="{{ $order->billing_email }}" id="example-text-input" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-6 col-xs-12">
                                        <div class="mb-3">
                                            <label for="productname">Date Issued</label>
                                            <input class="form-control" type="text" value="{{$order->creationDate}}" id="example-text-input" readonly>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="py-2 mt-3">
                                    <h3 class="font-size-15 fw-bold">Order summary</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 70px;">No.</th>
                                                <th>Item</th>
                                                <th class="text-end">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>01</td>
                                                <td>{{$order->getProduct->name}}</td>
                                                <td class="text-end">${{$order->pay_amount}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="border-0 text-end">
                                                    <strong>Total</strong></td>
                                                <td class="border-0 text-end"><h4 class="m-0">${{$order->pay_amount}}</h4></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-print-none">
                                    <div class="float-end">
                                        <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i></a>

                                        <form method="POST"  action="/api/invoices/{{$order->id}}/refund">
                                            @csrf
                                            <button href="" class="btn btn-primary btn-sm" type="submit" title="Refund">
                                                Refund
                                            </button>
                                        </form>
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

        <!-- Transaction Modal -->
        <div class="modal fade transaction-detailModal" tabindex="-1" role="dialog" aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transaction-detailModalLabel">Order Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-2">Product id: <span class="text-primary">#SK2540</span></p>
                        <p class="mb-4">Billing Name: <span class="text-primary">Neal Matthews</span></p>

                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">
                                            <div>
                                                <img src="assets/images/product/img-7.png" alt="" class="avatar-sm">
                                            </div>
                                        </th>
                                        <td>
                                            <div>
                                                <h5 class="text-truncate font-size-14">Wireless Headphone (Black)</h5>
                                                <p class="text-muted mb-0">$ 225 x 1</p>
                                            </div>
                                        </td>
                                        <td>$ 255</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <div>
                                                <img src="assets/images/product/img-4.png" alt="" class="avatar-sm">
                                            </div>
                                        </th>
                                        <td>
                                            <div>
                                                <h5 class="text-truncate font-size-14">Phone patterned cases</h5>
                                                <p class="text-muted mb-0">$ 145 x 1</p>
                                            </div>
                                        </td>
                                        <td>$ 145</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <h6 class="m-0 text-right">Sub Total:</h6>
                                        </td>
                                        <td>
                                            $ 400
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <h6 class="m-0 text-right">Shipping:</h6>
                                        </td>
                                        <td>
                                            Free
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <h6 class="m-0 text-right">Total:</h6>
                                        </td>
                                        <td>
                                            $ 400
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal -->

        <!-- subscribeModal -->
        <div class="modal fade" id="subscribeModal" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <div class="avatar-md mx-auto mb-4">
                                <div class="avatar-title bg-light rounded-circle text-primary h1">
                                    <i class="mdi mdi-email-open"></i>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-xl-10">
                                    <h4 class="text-primary">Subscribe !</h4>
                                    <p class="text-muted font-size-14 mb-4">Subscribe our newletter and get notification to stay update.</p>

                                    <div class="input-group bg-light rounded">
                                        <input type="email" class="form-control bg-transparent border-0" placeholder="Enter Email address" aria-label="Recipient's username" aria-describedby="button-addon2">

                                        <button class="btn btn-primary" type="button" id="button-addon2">
                                                    <i class="bx bxs-paper-plane"></i>
                                                </button>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal -->

        @extends("partials/footer")
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

@extends("partials/vendor-scripts")
<script>
    /* attach a submit handler to the form */
    $("#messagehandler").submit(function(event) {

        /* stop form from submitting normally */
        event.preventDefault();

        /* get the action attribute from the <form action=""> element */
        var $form = $(this),
            url = $form.attr('action');

        /* Send the data using post with element id name and name2*/
        var posting = $.post(url, {
            message: $('#message').val()
        });
        /* Alerts the results */
        posting.done(function(data) {
            $.notify("Message created successfully", "success", [{
                autoHideDelay: 200000
            }]);
        });
        posting.fail(function() {
            $.notify("Error creating message!", "danger", [{
                autoHideDelay: 200000
            }]);
        });
    });
</script>


</body>

</html>
