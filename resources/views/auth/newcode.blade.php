<!doctype html>
<html>

<head>
  <meta charset="utf-8" />
  <title>Envoi code CEPBU | GoProjects</title>
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
                        <div class="divider-content-center">Code de verification <br><br>    Entrer le code de verification de 6 ciffre envoyez sur {{ $email }} !</div>
                      </div>
                      <br>
                      
                      <form class="auth-input" name="form_code" id="frm_code" autocomplete="off">
                        @csrf
                        <input type="hidden" class="form-control" id="email" name="email" value="{{ $email }}" autofocus>
                        <div class="mb-2">
                            <label for="code" class="form-label">Code </label>
                            <input type="number" class="form-control" id="code" name="code" 
                                   placeholder="Code" 
                                   autocomplete="off" 
                                   maxlength="6" 
                                   min="0"
                                

                                   readonly 
                                   onfocus="this.removeAttribute('readonly');" 
                                   autofocus>
                            <small id="errorcode" style="color:red"></small>
                        </div>
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
   document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('code');
    const errorcode = document.getElementById('errorcode');

    // Limite à 6 chiffres
    codeInput.addEventListener('input', function(e) {
        // Supprimer les caractères non numériques
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Limite à 6 chiffres
        if (this.value.length > 6) {
            this.value = this.value.slice(0, 6);
        }

        // Vérification automatique quand 6 chiffres sont saisis
        if (this.value.length === 6) {
            verifyCode();
        }
    });

    function verifyCode() {
        const code = codeInput.value;
        const email = document.getElementById('email').value;
        const csrfToken = document.querySelector('input[name="_token"]').value;

         // Afficher le loader
    if (loader) {
        loader.style.display = 'block';
    }

        fetch('{{ route("verify.code") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ 
                email: email, 
                code: code 
            })
        })
        .then(response => response.json())
        .then(data => {

             // Afficher le loader
    if (loader) {
        loader.style.display = 'block';
    }

            if (data.success) {
                // Redirection vers la page de réinitialisation de mot de passe
                window.location.href = "{{ route('reset.password') }}";
            } else {
                errorcode.textContent = data.message;
                // Optionnel : effacer le champ après une erreur
                codeInput.value = '';
            }
        })
        .catch(error => {
            if (loader) {
            loader.style.display = 'none';
        }

            console.error('Erreur:', error);
            errorcode.textContent = 'Une erreur est survenue. Réessayez.';
        });
    }
});
  </script>
</body>
<style>
    #loader {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 18px;
    color: #555;
}

.spinner {
    border: 5px solid #f3f3f3;
    border-top: 5px solid #3498db;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

</style>



<div id="loader" style="display: none;">
    <div class="spinner"></div>
    Chargement...
</div>


</html>
