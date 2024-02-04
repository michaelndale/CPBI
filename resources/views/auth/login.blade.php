<!doctype html>
<html >
<head>
        <meta charset="utf-8" />
        <title>Connexion | GoProjects</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Application des gestions des projets" name="GoProject" />
        <meta content="GoProject" name="Michael Ndale" />
        <link rel="shortcut icon" href="{{ asset('element/assets/images/logo.png') }}">
        <script src="{{ asset('element/assets/js/layout.js') }}"></script>
        <link href="{{ asset('element/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <link href="{{ asset('element/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('element/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <style type="text/css">
          .has-error {
              border: 1px solid red;
          }

        </style>
    </head>

    <body>
        <div class="auth-maintenance d-flex align-items-center min-vh-100">
            <div class="bg-overlay bg-light"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-9 col-sm-12">
                        <div>
                            
                            <div class="row justify-content-center align-items-center pt-4">
                                <div class="col-lg-6 col-md-8">
                                   <div class="card">
                                        <div class="card-body">
                                            <div class="p-3">
                                              <div class="text-center mt-1">
                                                <h4 class="font-size-18" >  <font size="6px"> <b><i class="far fa-chart-bar"></i> CEPBU</b></font> </h4>
                                                <div class="divider-content-center">Accédez à votre compte GoProject</div>
                                              </div>

                                              <div id="ok" style="color: white; text-align: center; background-color:green ;border-radius:3px 3px 3px 3px;"></div>
                                              <div id="err" style="color: white; text-align: center; background-color:Tomato;border-radius:3px 3px 3px 3px;"></div>

                                              <form  class="auth-input" name="frm_login" id="frm_login">
                                              @csrf
                                                <div class="mb-2">
                                                    <label for="indetifiant" class="form-label">Identifiant</label>
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="Identifiant" autocomplete="off" >
                                                    <small id="erroremail" style="color:red"></small>
                                                  </div>
                                        
                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">Mot de passe</label>
                                                    <input type="password" class="form-control" placeholder="Mot de passe" id="password" name="password" autocomplete="off" >
                                                    <small id="errorpassword" style="color:red" ></small>
                                                  </div>
                                        
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"  >
                                                    <label class="form-check-label" for="auth-remember-check">Souvenez-vous de moi</label>
                                                   
                                                  </div>
                                        
                                                <div class="mt-4">
                                                    <button class="btn btn-primary w-100" type="button" id="connectBtn"  onclick="login()">Se connecter</button>
                                                </div>
                                        
                                               
                                            </form>
                                            </div>
                                            <div class="mt-4 text-center">
                                                <p> Gestion Suivi Projets  <br>©  2023 - <script>document.write(new Date().getFullYear())</script> GoProject  </p>
                                            </div>
                                        </div>
                                   </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                    </div>
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
            $("#erroremail").hide().html("L'identifiant est obligatoire").fadeIn('slow');
            return false;
        }
        else if($('#password').val() == "")
        {
            $('#password').addClass('has-error');
            $("#errorpassword").hide().html("Le mot de passe est obligatoire").fadeIn('slow');
            return false;
        }
        else {
            var data = $("#frm_login").serialize();
            
            $("#errorpassword").hide()
            $("#erroremail").hide()
            $('#email').addClass('has-success');
            $('#password').addClass('has-success');


            $("#connectBtn").text('Connexion...');
            document.getElementById("connectBtn").disabled = true;
            $("#ok").hide().html("Autentification...").fadeIn('slow');
 
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
                        $("#ok").hide().html("Connexion établie. Redirection en cours…").fadeIn('slow');
                        $("#err").hide()
                        setTimeout("location.href = '{{ route('dashboard')}}';",1000);
                    }
                    else if(response == 2)
                    {
                        $("#ok").hide()
                        $("#err").hide().html("Votre compte est bloqué. Vérifiez s'il vous plaît").fadeIn('slow');
                        $("#connectBtn").text('Se connecter');
                        connectBtn
                      }

                    else if(response == 3)
                    {
                        $("#ok").hide()
                        $("#err").hide().html("Votre compte est désactivé. Vérifiez s'il vous plaît").fadeIn('slow');
                        $("#connectBtn").text('Se connecter');
                      }

                    else if(response == 4)
                    {
                      $("#ok").hide()
                      $("#err").hide().html("Identifiant ou mot de passe incorrect. Vérifiez s'il vous plaît").fadeIn('slow');
                      $("#connectBtn").text('Se connecter');
                    }

                    else if(response == 4)
                    {
                      $("#ok").hide()
                      $("#err").hide().html("Attention : votre serveur distant n'est pas connecter").fadeIn('slow');
                      $("#connectBtn").text('Se connecter');
                    }

                    document.getElementById("connectBtn").disabled = false;

                }
            });
        }
    }
</script>
        <script src="{{ asset('element/assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('element/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('element/assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('element/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('element/assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('element/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('element/assets/js/app.js"></script>
    </body>
</html>
