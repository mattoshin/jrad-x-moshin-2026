@extends("partials/main")

<head>

    @extends("partials/title-meta")
    @section('pageTitle')
    User Page
    @stop
    @extends("partials/head-css")
    <style type="text/css">
        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript, 
        if it's not present, don't show loader */
        .no-js #loader {
            display: none;
        }

        .js #loader {
            display: block;
            position: absolute;
            left: 100px;
            top: 0;
        }

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
                            <span class="d-none d-sm-block">Invoices</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab" aria-selected="false">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Products</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#messages2" role="tab" aria-selected="false">
                            <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                            <span class="d-none d-sm-block">Message User</span>
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
                                                        <p class="text-muted fw-medium mb-2">Active Businesses</p>
                                                        <h4 class="mb-0">{{count($user->getBusinesses())}}</h4>
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
                                                        <p class="text-muted fw-medium mb-2">Active Products</p>
                                                        <h4 class="mb-0">{{count($user->getPlans())}}</h4>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-store font-size-24"></i>
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
                                                        <p class="text-muted fw-medium mb-2">Per Month Spending</p>
                                                        <h4 class="mb-0">${{$user->getMonthlySpend()}}</h4>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
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
                                                        <p class="text-muted fw-medium mb-2">Total Spent</p>
                                                        <h4 class="mb-0">${{$user->getTotalSpent()}}</h4>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">

                                <!-- end card -->
                                <div class="card overflow-hidden">
                                    <div class="bg-primary bg-soft">
                                        <div class="row">
                                            <div class="col-7">
                                            </div>
                                            <div class="col-5 align-self-end">
                                                <img src="/assets/images/profile-img.png" alt="" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="avatar-md profile-user-wid mb-4">
                                                    <img src="{{$user->avatar}}" alt="" class="img-thumbnail rounded-circle">
                                                </div>
                                                <h5 class="font-size-15 text-truncate">{{$user->username}}</h5>
                                                <p class="text-muted mb-0 text-truncate">{{($user->admin == 1 ) ? 'Admin' : 'Customer';}}</p>
                                            </div>

                                            <div class="col-sm-8">
                                                <div class="pt-4">

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <h5 class="font-size-15">{{count($user->getBusinesses())}}</h5>
                                                            <p class="text-muted mb-0">Businesses</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <h5 class="font-size-15">${{$user->getTotalSpent()}}</h5>
                                                            <p class="text-muted mb-0">Spent</p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4 row gx-0">

                                                        <div class="col-7">
                                                            <?php
                                                            if ($user->stripe_customer !== null) {
                                                            ?>
                                                                <a href="https://dashboard.stripe.com/customers/{{$user->stripe_customer}}" class="btn btn-primary waves-effect waves-light btn-sm">View User's Stripe <i class="mdi mdi-arrow-right ms-1"></i></a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="btn btn-primary waves-effect waves-light btn-sm">View User's Stripe <i class="mdi mdi-arrow-right ms-1"></i></a>

                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="col-5">
                                                            <form method="post" action="/admin/user/{{$user->id}}/toggleAdmin">
                                                                <button type="submit" class="btn btn-primary waves-effect waves-light btn-sm">Admin Toggle</button>
                                                            <form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-5">User Servers</h4>
                                        <div class="">
                                            <ul class="verti-timeline list-unstyled">
                                                @foreach ($user->getBusinessesWithProductsFull() as $business)
                                                <li class="event-list">
                                                    <a href="/admin/business/{{$business->id}}">
                                                        <div class="event-timeline-dot">
                                                            <i class="bx bx-right-arrow-circle bx-fade-right"></i>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="flex-shrink-0 me-3">
                                                                <i class="bx bx-server h4 text-primary"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div>
                                                                    <h5 class="font-size-15">{{$business->server->name}}</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <!-- end card -->
                            </div>

                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">User Information</h4>
                                        <form>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="productname">Discord Name</label>
                                                        <input class="form-control" type="text" value="{{$user->username}}" id="example-text-input" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="productname">Discord Email</label>
                                                        <input class="form-control" type="text" value="{{$user->email}}" id="example-text-input" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="productname">IP Address</label>
                                                        <input class="form-control" type="text" value="Disabled on Demo" id="example-text-input" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="productname">Stripe Customer</label>
                                                        <input class="form-control" type="text" value="{{$user->stripe_customer}}" id="example-text-input" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>

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

                                        <h4 class="card-title">Invoice Table</h4>

                                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead class="table-light">
                                                <tr>
                                                    <!-- <th style="width: 20px;" class="align-middle">
                                                        <div class="form-check font-size-16">
                                                            <input class="form-check-input" type="checkbox" id="checkAll">
                                                            <label class="form-check-label" for="checkAll"></label>
                                                        </div>
                                                    </th> -->
                                                    <th class="align-middle">Order ID</th>
                                                    <th class="align-middle">Product</th>
                                                    <th class="align-middle">Discord Username</th>
                                                    <th class="align-middle">Billing Name</th>
                                                    <th class="align-middle">Billing Email</th>
                                                    <th class="align-middle">Creation Date</th>
                                                    <th class="align-middle">Total</th>
                                                    <th class="align-middle">Payment Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($user->getInvoices() as $invoice)
                                                <tr>
                                                    <th scope="row">{{$invoice->id}}</th>
                                                    <td>{{$invoice->getProduct->name}}</td>
                                                    <td>{{$invoice->getUser->username}}</td>
                                                    <td>{{$invoice->billing_name}}</td>
                                                    <td>{{$invoice->billing_email}}</td>
                                                    <td>{{date_format(date_create($invoice->creationDate), 'm/d/Y H:i:s')}}</td>
                                                    <td>${{$invoice->pay_amount}}</td>
                                                    <td><?php
                                                        echo ($invoice->paid ? '<span class="badge badge-pill badge-soft-success font-size-12">Paid</span>' : '<span class="badge badge-pill badge-soft-danger font-size-12">Unpaid</span>')
                                                        ?></td>
                                                </tr>

                                                @endforeach
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
                                <h4 class="card-title mb-4">Active Products</h4>
                                <div class="table-responsive">
                                    <table class="table table-nowrap table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Business Name</th>
                                                <th scope="col">Server ID</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Product Type</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Upcoming Charge</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user->getPlans() as $monitor)
                                            <tr>
                                                <th scope="row">{{$monitor->id}}</th>
                                                <td>{{$monitor->getBusiness->name}}</td>
                                                <td>{{$monitor->getBusiness->server->guild_id}}</td>
                                                <td>{{$monitor->getProduct->name}}</td>
                                                <td>{{($monitor->getProduct->channel_type == 1 ? "Curated" : "Webhooks")}}</td>
                                                <td>{{date('m/d/Y H:i:s', $monitor->startDate)}}</td>
                                                <td>{{($monitor->getSubscription ? $monitor->getSubscription->pay_amount ? '$'.$monitor->getSubscription->pay_amount.'.00' : 'No Subscription': 'No Subscription')}}</td>
                                                <td><?php
                                                    $d = new \DateTime();
                                                    $d->setTimestamp($monitor->endDate);
                                                    $daysleft = $d->diff(new \DateTime())->format('%a') + 1;
                                                    echo $daysleft . " days";
                                                    ?></td>
                                                <td>
                                                    <div class="d-flex gap-3">
                                                        <a href="/admin/plan/{{$monitor->id}}" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="messages2" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Direct Message</h4>
                                <div id="result"></div>
                                <form class="outer-repeater" method="post" id="messagehandler" action="/api/user/{{$user->id}}/message">
                                    <div data-repeater-list="outer-group" class="outer">
                                        <div data-repeater-item="" class="outer">
                                            <div class="form-group mb-4">
                                                <label class="col-form-label">Direct Messages</label>
                                                <textarea id="message" class="message form-control" name="message"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="justify-content-center">
                                        <button type="submit" class="btn btn-primary">Send Message</button>
                                    </div>
                                </form>
                                <br>
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
