<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Nouveau mot de
        passe | GoProjects</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Application des gestions des projets" name="GoProject" />
    <meta content="GoProject" name="Michael Ndale" />
    <link rel="shortcut icon" href="{{ asset('element/assets/images/logo.png') }}">
    <link href="{{ asset('element/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
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
                                                    <font size="6px"> <b><i class="far fa-chart-bar"></i> CEPBU</b>
                                                    </font>
                                                </h4>
                                              
                                            </div>
                                            <br>

                                            <form class="auth-input" name="form_reset_password" id="frm_reset_password"
                                                autocomplete="off">
                                                @csrf
                                                <input type="hidden" id="email" name="email"
                                                    value="{{ $email }}">

                                                <div class="mb-2">
                                                    <label for="password" class="form-label">Nouveau mot de
                                                        passe</label>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" placeholder="Nouveau mot de passe"
                                                        autocomplete="new-password" readonly
                                                        onfocus="this.removeAttribute('readonly');">
                                                    <small id="errorpassword" class="text-danger"></small>
                                                </div>

                                                <div class="mb-2">
                                                    <label for="password_confirmation" class="form-label">Confirmer le
                                                        mot de passe</label>
                                                    <input type="password" class="form-control"
                                                        id="password_confirmation" name="password_confirmation"
                                                        placeholder="Confirmer le mot de passe"
                                                        autocomplete="new-password" readonly
                                                        onfocus="this.removeAttribute('readonly');">
                                                    <small id="errorpassword_confirmation" class="text-danger"></small>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="savebtn btn btn-primary w-100" type="button"
                                                        id="resetPasswordBtn">
                                                        Réinitialiser le mot de passe
                                                    </button>
                                                </div>
                                            </form>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <center>
                            <small> Gestion Suivi Projets | RH | ParcAuto | Archivage <br>© 2023 -
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> GoProject
                            </small>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" defer></script>
  
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const resetPasswordBtn = document.getElementById('resetPasswordBtn');
                const passwordInput = document.getElementById('password');
                const passwordConfirmInput = document.getElementById('password_confirmation');
                const emailInput = document.getElementById('email');
                const errorPassword = document.getElementById('errorpassword');
                const errorPasswordConfirm = document.getElementById('errorpassword_confirmation');

                resetPasswordBtn.addEventListener('click', function() {
                    // Réinitialiser les messages d'erreur
                    errorPassword.textContent = '';
                    errorPasswordConfirm.textContent = '';

                    const password = passwordInput.value.trim();
                    const passwordConfirm = passwordConfirmInput.value.trim();
                    const email = emailInput.value;

                    // Validation côté client
                    let hasError = false;

                    if (password === '') {
                        errorPassword.textContent = 'Le mot de passe est requis';
                        hasError = true;
                    } else if (password.length < 8) {
                        errorPassword.textContent = 'Le mot de passe doit contenir au moins 8 caractères';
                        hasError = true;
                    }

                    if (passwordConfirm === '') {
                        errorPasswordConfirm.textContent = 'La confirmation du mot de passe est requise';
                        hasError = true;
                    } else if (password !== passwordConfirm) {
                        errorPasswordConfirm.textContent = 'Les mots de passe ne correspondent pas';
                        hasError = true;
                    }

                    if (hasError) return;

                    // Envoi de la requête
                    fetch('{{ route('update.password') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            },
                            body: JSON.stringify({
                                email: email,
                                password: password,
                                password_confirmation: passwordConfirm
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Redirection avec message de succès
                                window.location.href = "{{ route('login') }}";
                            } else {
                                // Afficher les erreurs du serveur
                                if (data.errors) {
                                    if (data.errors.password) {
                                        errorPassword.textContent = data.errors.password[0];
                                    }
                                    if (data.errors.email) {
                                        errorPassword.textContent = data.errors.email[0];
                                    }
                                } else {
                                    errorPassword.textContent = data.message || 'Une erreur est survenue';
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            errorPassword.textContent = 'Une erreur de réseau est survenue';
                        });
                });
            });
        </script>


</body>
</html>
