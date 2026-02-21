@extends("partials/main")

    <head>

        @extends("partials/title-meta")
        @section('title')
        Horizontal Layout
        @stop

        @extends("partials/head-css")

    </head>

    <body data-topbar="dark" data-layout="horizontal">

        <!-- Begin page -->
        <div id="layout-wrapper">

            @extends("partials/horizontal")

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        @extends("partials/page-title")
                        @section('pageTitle')
                        Layouts
                        @stop
                        @section('title')
                        Horizontal Layout
                        @stop

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                @extends("partials/footer")
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        @extends("partials/right-sidebar")

        @extends("partials/vendor-scripts")

        <script src="assets/js/app.js"></script>
    </body>
</html>
