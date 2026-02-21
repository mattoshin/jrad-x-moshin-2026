<!-- JAVASCRIPT -->
<script src="{{asset('/js/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('/js/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/js/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('/js/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('/js/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('/js/loading.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap/bootstrap.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
<script type="text/javascript">
	setTimeout(function() { notification.close() }, 2000);
	@if(Session::has('success'))
        $.notify("{{ Session::get('success') }}", "success",[{autoHideDelay : 200000000}]);
        @php
            Session::forget('success');
        @endphp
    @endif
    @if(Session::has('danger'))
        $.notify("{{ Session::get('danger') }}", "danger",[{autoHideDelay : 200000000}]);
        @php
            Session::forget('danger');
        @endphp
    @endif
</script>


@yield('script')

<!-- App js -->
<script src="{{asset('js/admin.js')}}"></script>

@yield('script-bottom')