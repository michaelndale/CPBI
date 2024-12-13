<!doctype html>
<html>

<head>
  <meta charset="utf-8" />
  <title>Restoration du compte  | GoProjects</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Application des gestions des projets" name="GoProject" />
  <meta content="GoProject" name="Michael Ndale" />
  <link rel="shortcut icon" href="{{ asset('element/assets/images/logo.png') }}">
  <link href="{{ asset('element/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
  <link href="{{ asset('element/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('element/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
  <style type="text/css">
    .has-error {
      border: 1px solid red;
    }

    .btn {
      display: grid;
      place-content: center;
    }

    .loader {
      pointer-events: none;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      border: 3px solid transparent;
      border-top-color: #fff;
      animation: an1 1s ease infinite;
    }

    @keyframes an1 {
      0% {
        transform: rotate(0turn);
      }

      100% {
        transform: rotate(1turn);
      }
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
                <div id="ok"></div>
                <div id="err"></div>
                <div class="card">
                  <div class="card-body">
                    <div class="p-3">
                      <div class="text-center mt-1">
                        <h4 class="font-size-18">
                          <font size="6px"> <b><i class="far fa-chart-bar"></i> CEPBU</b></font>
                        </h4>
                        <div class="divider-content-center">Réinitialiser le mot de passe <br><br> Entrez votre adresse e-mail et des instructions vous seront envoyées !</div>
                      </div>
                    
                      
                      <form class="auth-input" id="frm_login" autocomplete="off">
                        @csrf
                        <div class="mb-2">
                            <label for="email" class="form-label">Email </label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Entrer votre e-mail" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" autofocus>
                            <small id="erroremail" class="text-danger"></small>
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-primary w-100" type="button" id="connectBtn">
                                Envoyer
                            </button>
                        </div>
                        <div id="feedback" class="mt-3"></div>
                    </form>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <center>
              <small> Gestion Suivi Projets | RH | ParcAuto | Archivage <br>© 2023 - <script>
                  document.write(new Date().getFullYear())
                </script> GoProject </small>
            </center>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" defer></script>

  <script>
    document.getElementById('connectBtn').onclick = function() {
        const emailField = document.getElementById('email');
        const errorField = document.getElementById('erroremail');
        const feedback = document.getElementById('feedback');
        const btn = this;

        // Validation simple de l'email
        if (!emailField.value) {
            emailField.classList.add('is-invalid');
            errorField.textContent = "L'email est obligatoire.";
            return;
        }

        emailField.classList.remove('is-invalid');
        errorField.textContent = "";

        // Désactiver le bouton pour éviter plusieurs clics
        btn.disabled = true;
        btn.innerHTML = "En cours...";

        // Envoyer la requête AJAX
        $.ajax({
            type: 'POST',
            url: "{{ route('verification.email.user') }}",
            data: { email: emailField.value, _token: "{{ csrf_token() }}" },
            success: function(response) {
                btn.disabled = false;
                btn.innerHTML = "Envoyer";

                // Si l'email existe
                if (response.success) {
                    
                    if (response.success) {
                                if (response.exists) {
                                    feedback.innerHTML = "<div class='alert alert-success'>Email valide. Redirection...</div>";
                                    setTimeout(() => {
                                        window.location.href = "{{ route('new.code') }}";
                                    }, 1000);
                                } else {
                                    feedback.innerHTML = "<div class='alert alert-danger'>Cet email n'existe pas. Veuillez vérifier.</div>";
                                }
                            } else {
                                feedback.innerHTML = "<div class='alert alert-danger'>" + response.message + "</div>";
                            }

                } else {
                    // Si l'API retourne un message d'erreur
                    feedback.innerHTML = "<div class='alert alert-danger'>" + response.message + "</div>";
                }
            },
            error: function(xhr, status, error) {
                btn.disabled = false;
                btn.innerHTML = "Envoyer";

                // Vérifier si la réponse contient des erreurs JSON
                let errorMessage = 'Erreur de connexion. Veuillez réessayer.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;  // Utiliser le message d'erreur retourné par le serveur
                }

                feedback.innerHTML = "<div class='alert alert-danger'>" + errorMessage + "</div>";
            }
        });
    };
</script>


</body>

</html>
