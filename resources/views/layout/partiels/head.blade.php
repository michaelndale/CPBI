<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title> {{ @$title }} | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Application des gestions projet CEPBU" name="GoProjet" />
    <meta content="IMPACT-JOB" name="MICHAEL NDALE" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('element/assets/images/logo.png') }}">
    <link href="{{ asset('element/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <!-- plugin css -->
    <link href="{{ asset('element/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link href="{{ asset('element/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('element/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('element/assets/libs/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ asset('element/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Layout Js -->
    <script src="{{ asset('element/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('element/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('element/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('element/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert-->
    <link href="{{ asset('element/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <style type="text/css">
        .has-error {
            border: 1px solid red;
        }

        .savebtn {
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

        .offline {
            display: none;
            color: white;
            background-color: red;
            text-align: center;
        }

        body {
            font-size: 80%;
            font-family: 'Roboto', sans-serif;
            /* taille de police de base */
        }

        h1 {
            font-size: 1em;
            /* taille de la police pour les titres */
        }

        p {
            font-size: 1em;
            /* taille de la police pour les paragraphes */
        }

        .small-text {
            font-size: 0.8em;
            /* taille de la police pour les textes de petite taille */
        }

        /* Exemple de CSS */
        

        h1,
        h2,
        h3 {
            font-family: 'Open Sans', sans-serif;
            /* Utilisation d'une autre police web légère pour les titres */
        }


        #message {
    display: none;
    position: fixed;
    top: 10%;
    left: 50%;
    transform: translate(-50%, -50%);
  
    padding: 10px;
    border: 1px solid Crimson;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    z-index: 9999;
    background-color: Crimson;
    width: 30%;
    border-radius: 10px; /* Ajout du border-radius */
}

    </style>


</head>