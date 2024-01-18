<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Login | GoProjects</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('elements/assets/img/favicons/logo.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('elements/vendors/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('elements/vendors/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('elements/assets/js/config.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('elements/vendors/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('elements/unicons.iconscout.com/release/v4.0.8/css/line.css') }}">
    <link href="{{ asset('elements/assets/css/theme-rtl.min.css') }}" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('elements/assets/css/theme.min.css') }}" type="text/css" rel="stylesheet" id="style-default">
    <link href="{{ asset('elements/assets/css/user-rtl.min.css') }}" type="text/css" rel="stylesheet" id="user-style-rtl">
   
    <script>
      var phoenixIsRTL = window.config.config.phoenixIsRTL;
      if (phoenixIsRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>

<style type="text/css">
.has-error {
    border: 1px solid red;
}

</style>
  </head>
  <body>
    
    <main class="main" id="top">
      <div class="container">
        <div class="row flex-center min-vh-100 py-5">
          <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3"><a class="d-flex flex-center text-decoration-none mb-4" href="../../../index.html">
              <div class="d-flex align-items-center fw-bolder fs-5 d-inline-block"  >
               
                <p class="logo-text ms-2 d-none d-sm-block" style="color:#228B22;">
                  <font size="6px"> <b><i class="far fa-chart-bar"></i>CEPBU</b></font> </p>
              </div>
            </a>
            
            <div class="position-relative">
              <hr class="bg-200 mt-5 mb-4" />
              <div class="divider-content-center">Accédez à votre compte GoProject</div>
            </div>
            
            <div id="ok" style="color: white; text-align: center; background-color:green ;border-radius:3px 3px 3px 3px;"></div>
            <div id="err" style="color: white; text-align: center; background-color:Tomato;border-radius:3px 3px 3px 3px;"></div>
            <form name="frm_login" class="form" id="frm_login">    
                            @csrf
            
              <div class="mb-3 text-start"><label class="form-label" for="admin" class="text-info" >Identifiant</label>
              <div class="form-icon-container">
                <input class="form-control form-icon-input" id="email" name="email" type="text" placeholder="Identifiant" autocomplete="off"  />
                <span class="fas fa-user text-900 fs--1 form-icon"></span></div>
            </div>


            <div class="mb-3 text-start"><label class="form-label" for="password">Mot de passe </label>
              <div class="form-icon-container">
                <input class="form-control form-icon-input" id="password" name="password" type="password" placeholder="Mot de passe"/>
                <span class="fas fa-key text-900 fs--1 form-icon"></span></div>
            </div>
            
            <button type="button" id="connectBtn"  onclick="login()" style="background-color:#228B22" class="btn btn-primary w-100 mb-3">Se connecter</button>
            <br><br>
            <small>
                
            <center>
              
            <p class="mb-0 mt-2 mt-sm-0 text-900"> Gestion Suivi Projets<span class="d-none d-sm-inline-block"></span><span class="d-none d-sm-inline-block mx-1">|</span> 
            <br class="d-sm-none" />2023 &copy;<a class="mx-1" target="_blank" href="https://impactjob.space/"> GoProjects</a></p>
            </center></small>
          </form>
          </div>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>

  
    function login()
    { 
        if($('#email').val() == "")
        { 
            $('#email').addClass('has-error');
            return false;
        }
        else if($('#password').val() == "")
        {
            $('#password').addClass('has-error');
            return false;
        }
        else {
            var data = $("#frm_login").serialize();

            $("#connectBtn").text('Connexion...');
            document.getElementById("connectBtn").disabled = true;
 
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
 
            $.ajax({
                type : 'POST',
                url: "{{ route('handlelogin') }}",
                data : data,
                success : function(response)
                {
                    console.log(response); 
                    if(response == 1)
                    {
                        $("#ok").hide().html("Votre connexion réussie").fadeIn('slow');
                        $("#err").hide()
                        setTimeout("location.href = '{{ route('dashboard')}}';",1000);
                    }
                    else if(response == 2)
                    {
                        $("#err").hide().html("Votre compte est bloqué. Vérifiez s'il vous plaît").fadeIn('slow');
                        $("#connectBtn").text('Se connecter');
                        connectBtn
                      }

                    else if(response == 3)
                    {
                        $("#err").hide().html("Votre compte est désactivé. Vérifiez s'il vous plaît").fadeIn('slow');
                        $("#connectBtn").text('Se connecter');
                      }

                    else if(response == 4)
                    {
                      $("#err").hide().html("Identifiant ou mot de passe incorrect. Vérifiez s'il vous plaît").fadeIn('slow');
                      $("#connectBtn").text('Se connecter');
                    }

                    else if(response == 4)
                    {
                      $("#err").hide().html("Attention : votre serveur distant n'est pas connecter").fadeIn('slow');
                      $("#connectBtn").text('Se connecter');
                    }

                    document.getElementById("connectBtn").disabled = false;

                }
            });
        }
    }
</script>
    </main>
    <script src="{{ asset('elements/vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('elements/vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('elements/vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('elements/vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('elements/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('elements/vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('elements/polyfill.io/v3/polyfill.min58be.js?features=window.scroll') }}"></script>
    <script src="{{ asset('elements/vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('elements/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('elements/vendors/dayjs/dayjs.min.js') }}"></script>
    <script src="{{ asset('elements/assets/js/phoenix.js') }}"></script>
  </body>
</html>