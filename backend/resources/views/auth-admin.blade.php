@extends("partials/main")

    <head>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

        @extends("partials/title-meta")
        @section('pageTitle')
        Login
        @stop

        @extends("partials/head-css")

    </head>

    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-white p-4">
                                            <h5 class="">Welcome Back !</h5>
                                            <p>Sign in to continue to Mocean.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="p-2">
                                    <form method="POST" action="{{url('/admin')}}">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6 offset-md-4">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                                        </div>

                                        

                                        <div class="mt-4 text-center">
                                            <a href="/auth-recoverpw" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->

        @extends("partials/vendor-scripts")

        <!-- App js -->
        <script src="assets/js/app.js"></script>

       <!-- <script>
            $(function() {
            // handle submit event of form
              $(document).on("submit", "#handleAjax", function() {
                var e = this;
                // change login button text before ajax
                $(this).find("[type='submit']").html("LOGIN...");

                $.post($(this).attr('action'), $(this).serialize(), function(data) {

                  $(e).find("[type='submit']").html("LOGIN");
                  if (data.status) { // If success then redirect to login url
                    window.location = data.redirect_location;
                  }
                }).fail(function(response) {
                    // handle error and show in html
                  $(e).find("[type='submit']").html("LOGIN");
                  $(".alert").remove();
                  var erroJson = JSON.parse(response.responseText);
                  for (var err in erroJson) {
                    for (var errstr of erroJson[err])
                      $("#errors-list").append("<div class='alert alert-danger'>" + errstr + "</div>");
                  }

                });
                return false;
              });
            });
          </script>
        -->

    </body>
</html>
