
<script>
    setTimeout("location.href = '{{ route('login')}}';", 0);
</script>
<!doctype html>
<html lang="en">
<head>
        
        <meta charset="utf-8" />
        <title>500 Error | GoProjet</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Layout Js -->
        <script src="{{ asset('element/assets/js/layout.js') }}"></script>

        <!-- Bootstrap Css -->
        <link href="{{ asset('element/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('element/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('element/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body>

        <div class="auth-error d-flex align-items-center min-vh-100">
            <div class="bg-overlay bg-light"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-8">
                        <div>
                            <div class="text-center mb-4">

                              <div class="row justify-content-center">
                                <div class="col-lg-9">
                                        <img src="{{ asset('element/assets/images/error-img.html') }}" class="img-fluid" alt="">
                                </div>
                              </div>

                            <div class="mt-5">
                                <h1 class="error-title"> <span class="blink-infinite">500</span></h1>
                                <h4 class="mt-2 text-uppercase">Maintenance du serveur</h4>
                                <p class="mt-4 text-muted w-50 mx-auto">Service temporairement indisponible pour cause de maintenance du serveur. Veuillez revenir ultérieurement.</p>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JAVASCRIPT -->
        <script src="{{ asset('element/assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('element/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('element/assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('element/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('element/assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('element/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('element/assets/js/app.js') }}"></script>
    </body>
</html>
