@extends('layout/app')
@section('page-content')
<style>
    .swal-custom-content .swal-text {
        font-size: 14px;
        /* Ajustez la taille selon vos besoins */
    }

    .has-error {
        border: 1px solid red;
        /* Bordure rouge pour indiquer une erreur */
        background-color: #ffe6e6;
        /* Fond rouge clair */
        color: red;
        /* Texte rouge */
    }

    .has-success {
        border: 1px solid green;
        /* Bordure verte pour indiquer le succès */
        background-color: #e6ffe6;
        /* Fond vert clair */
        color: green;
        /* Texte vert */
    }
</style>
    <div class="main-content">
        <div class="page-content">
            <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card"
                style=" margin:auto">
                <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"
                    style="padding: 0.3rem 3rem;">


                    <h4 class="mb-sm-0"><i class="mdi mdi-plus-circle"></i> Nouvel Fiche d'Expression des Besoins "FEB" </h4>
                    <div class="page-title-right">


                        <a href="{{ route('nouveau.feb') }}" id="fetchDataLink"
                            class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" title=" Actualiser">
                            <i class="fas fa-sync-alt"></i>
                        </a>

                        <a href="{{ route('listfeb') }}" id="fetchDataLink"
                            class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"> <span class="fa fa-list"></span>
                            Liste</a>

                    </div>

                </div>


                <div class="card-body p-0">



                    <form method="POST" id="addfebForm">
                        @method('post')
                        @csrf
                        <div class="card-body p-0">
                            <div id="tableExample2">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm fs--1 mb-0">
                                        <tbody class="list">
                                            <tr>
                                                <td class="align-middle ps-3 name" colspan="3"> <label>Composante/
                                                        Projet/Section</label> <br>

                                                    <input value="{{ Session::get('id') }} " type="hidden" name="projetid"
                                                        id="projetid">
                                                    <input value="{{ Session::get('title') }} "
                                                        class="form-control form-control-sm" disabled>
                                                </td>
                                                <td rowspan="2" style="width:40%">
                                                    Référence des documents à attacher
                                                    <select class="form-control form-control-sm" id="annex"
                                                        name="annex[]" multiple style="height: 100px;">
                                                        <option disabled selected value="">-- Sélectionner les
                                                            documents attachés --</option>
                                                        @foreach ($attache as $attaches)
                                                            <option value="{{ $attaches->id }}">{{ $attaches->libelle }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle ps-3 name" colspan="3">Ligne budgétaire: <span
                                                        class="text-danger">*</span>
                                                    <select class="form-control  form-control-sm ligneid" id="referenceid"
                                                        name="referenceid" required>
                                                        <option disabled="true" selected="true" value="">Sélectionner
                                                            la
                                                            ligne budgétaire</option>
                                                        @foreach ($compte as $comptes)
                                                            <optgroup label="{{ $comptes->libelle }}">
                                                                @php
                                                                    $idc = $comptes->id;
                                                                    $res = DB::select(
                                                                        "SELECT * FROM comptes WHERE compteid= $idc",
                                                                    );
                                                                @endphp
                                                                @foreach ($res as $re)
                                                                    <option
                                                                        value="{{ $comptes->id }} - {{ $re->id }}">
                                                                        {{ $re->numero }}. {{ $re->libelle }} </option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                    <div id="showcondition">
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" class="align-middle ps-3 name">Activités <span
                                                        class="text-danger">*</span>

                                                    <input type="text" class="form-control form-control-sm"
                                                        name="descriptionf" id="descriptionf" required>
                                                </td>



                                                <td colspan="0">Bénéficiaire <span class="text-danger">*</span> <br>

                                                    <select class="form-control  form-control-sm" id="beneficiaire"
                                                        name="beneficiaire" required>
                                                        <option disabled="true" selected="true" value="">
                                                            --Sélectionner bénéficiaire--</option>';
                                                        @foreach ($beneficaire as $beneficaires)
                                                            <option value="{{ $beneficaires->id }}">
                                                                {{ $beneficaires->libelle }}</option>
                                                        @endforeach
                                                        <option value="autres">Autres</option>
                                                    </select>
                                                </td>
                                                <td colspan="0">
                                                    <div id="nomPrenomContainer" style="display: none;">
                                                        Nom & Prénom du bénéficiaire<br>
                                                        <input type="text" name="autresBeneficiaire"
                                                            id="nomPrenomBeneficiaire" class="form-control form-control-sm"
                                                            style="width: 100%;">
                                                    </div>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table style="width:80%">
                                        <tbody>
                                            <tr>

                                                <td class="align-middle ps-3 name" colspan="0">
                                                    Numéro du fiche FEB<span class="text-danger">*</span> <br>
                                                    <input type="number" name="numerofeb" value="{{ $newNumero }}"
                                                        id="numerofeb" class="form-control form-control-sm"
                                                        style="width: 100% ;">
                                                    <smal id="numerofeb_error" name="numerofeb_error"
                                                        class="text text-danger">
                                                    </smal>
                                                    <smal id="numerofeb_info" class="text text-primary"> </smal>
                                                </td>
                                                <td class="align-middle ps-3 name">Période: <span
                                                        class="text-danger">*</span> &nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp; <br>
                                                    <select type="text" class="form-control form-control-sm"
                                                        name="periode" id="periode" style="width: 100%" required>
                                                        @php
                                                            $periode = Session::get('periode');
                                                        @endphp
                                                        @for ($i = 1; $i <= $periode; $i++)
                                                            <option value="T{{ $i }}"> T{{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                    <br>
                                                </td>
                                                <td class="align-middle ps-3 name"> Date du dossier FEB:<span
                                                        class="text-danger">*</span><br>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="datefeb" id="datefeb" style="width: 100%" required>
                                                        <br>
                                                </td>
                                                <td class="align-middle ps-3 name"> Date limite:<span
                                                        class="text-danger">*</span><br>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="datelimite" id="datelimite" style="width: 100%">
                                                        <br>
                                                </td>




                                            </tr>

                                        </tbody>
                                    </table>

                                    <div class="table-responsive">
                                        <br>
                                        <table class="table table-striped table-sm fs--1 mb-0" id="tableEstimate">
                                            <thead style="background-color:#3CB371; color:white">
                                                <tr>
                                                    <th style="width:40px; color:white; "><b>N<sup>o</sup></b></th>
                                                    <th style="  color:white"><b> Designation des activités de la
                                                            ligne<span class="text-danger">*</span> </b></th>
                                                    <th style=" color:white"> <b> Description<span
                                                                class="text-danger">*</span></b></th>
                                                    <th style="width:150px;  color:white"><b>Unité<span
                                                                class="text-danger">*</span></b></th>
                                                    <th style="width:100px ;  color:white"><b>Q<sup>té <span
                                                                    class="text-danger">*</span></b></sup></th>
                                                    <th style="width:70px; color:white"><b title="Frequence">Fréq.<span
                                                                class="text-danger">*</span></b></th>
                                                    <th style="width:130px;  color:white"><b
                                                            title="Prix Unitaire">P.U<span class="text-danger">*</span>
                                                        </b></th>
                                                    <th style="width:150px;  color:white"><b>P.T<span
                                                                class="text-danger">*</span></b></th>

                                                    <th style="width:30px"> <a href="javascript:void(0)" class="text-default font-18"
                                                            title="Ajouter la ligne" id="addBtn" style="color:white;">
                                                            <i class="fa fa-plus-circle fa-1x"></i>
                                                        </a>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input style="width:100%; background-color:#c0c0c0 ; Padding:0px"
                                                            type="text" id="numerodetail" name="numerodetail[]"
                                                            class="form-control form-control-sm" value="1" readonly></td>
                                                    <td style="width:450px;">
                                                        <div id="Showpoll" class="Showpoll">
                                                            <select style="width:100%" type="text"
                                                                class="form-control form-control-sm">
                                                                <option disabled="true" selected="true">Aucun</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td><input style="width:100%" type="text" id="libelle_description"
                                                            name="libelle_description[]"
                                                            class="form-control form-control-sm" required></td>
                                                    <td><input style="width:100%" type="text" id="unit_cost"
                                                            name="unit_cost[]"
                                                            class="form-control form-control-sm unit_price" required></td>
                                                    <td><input style="width:100%" type="text" id="qty" value="1"
                                                            name="qty[]" class="form-control form-control-sm qty"
                                                            required>
                                                    </td>
                                                    <td><input style="width:100%" type="number" id="frenquency" value="1"
                                                            min="1" name="frenquency[]"
                                                            class="form-control form-control-sm frenquency" required></td>
                                                    <td><input style="width:100%" type="number" id="pu"
                                                            name="pu[]" min="0"
                                                            class="form-control form-control-sm pu" required></td>
                                                    <td><input style="width:100%; background-color:#c0c0c0" type="text"
                                                            min="0" id="amount" name="amount[]"
                                                            class="form-control form-control-sm total" value="0"
                                                            readonly></td>

                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-striped table-sm fs--1 mb-0">
                                            <tfoot style="background-color:#8FBC8F">
                                                <tr>
                                                    <td colspan="8">Total global </td>
                                                    <td align="right"><span class="total-global">0
                                                            {{ Session::get('devise') }} </span></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <hr>
                                    </div>
                                    <div class="table-repsonsive">
                                        <span id="error"></span>

                                        <table class="table table-striped table-sm fs--1 mb-0">
                                            <tr>
                                            <tr>
                                                <td>Etablie par (AC/CE/CS) <span class="text-danger">*</span> </td>
                                                <td>Vérifiée par (Comptable) <span class="text-danger">*</span></td>
                                                <td>Approuvée par (Chef de Composante/Projet/Section): <span
                                                        class="text-danger">*</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select type="text" class="form-control form-control-sm"
                                                        name="acce" id="acce" required>
                                                        <option disabled="true" selected="true" value="">
                                                            --Sélectionner
                                                            (AC/CE/CS)--</option>
                                                        @foreach ($personnel as $personnels)
                                                            <option value="{{ $personnels->userid }}">
                                                                {{ $personnels->nom }}
                                                                {{ $personnels->prenom }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select type="text" class="form-control form-control-sm"
                                                        name="comptable" id="comptable" required>
                                                        <option disabled="true" selected="true" value="">
                                                            --Sélectionner
                                                            comptable--</option>
                                                        @foreach ($personnel as $personnels)
                                                            <option value="{{ $personnels->userid }}">
                                                                {{ $personnels->nom }}
                                                                {{ $personnels->prenom }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select type="text" class="form-control form-control-sm"
                                                        name="chefcomposante" id="chefcomposante" required>
                                                        <option disabled="true" selected="true" value="">
                                                            --Sélectionner
                                                            Chef de Composante/Projet/Section--</option>
                                                        @foreach ($personnel as $personnels)
                                                            <option value="{{ $personnels->userid }}">
                                                                {{ $personnels->nom }}
                                                                {{ $personnels->prenom }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>

                            </div>


                        </div>

                        <div class="card-header p-4 border-bottom border-300 bg-soft">
                            <div class="row g-3 justify-content-between align-items-end">
                                <div class="col-12 col-md" style="padding: 0.3rem 3rem;">

                                </div>
                                <div class="col col-md-auto">
                                    <button type="submit" class="btn btn-primary" id="addfebbtn" name="addfebbtn" > <i
                                            class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="modal fade" id="erreurMessage" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="text-700 lh-lg mb-0">
                            <center>
                                <font size="100" color="red"> <i class="fas fa-info-circle "></i></font>
                                <br>
                                <font size="4"> Tu ne peux pas exécuter cette opération car tu as dépassé le montant
                                    autorisé. </font> <br> <br>
                                <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i
                                        class="fas fa-times-circle"></i> Ok </button>
                            </center>
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script>
            document.getElementById('beneficiaire').addEventListener('change', function() {
                const nomPrenomContainer = document.getElementById('nomPrenomContainer');
                if (this.value === 'autres') {
                    nomPrenomContainer.style.display = 'block'; // Affiche le conteneur avec le texte et l'input
                } else {
                    nomPrenomContainer.style.display = 'none'; // Cache le conteneur pour toutes les autres options
                }
            });
        </script>


        <script>
            function adjustTableHeight() {
                var windowHeight = window.innerHeight;
                var tableContainer = document.getElementById('table-container');

                // Ajustez la hauteur du conteneur du tableau en fonction de la hauteur de l'écran, moins une marge (par exemple, 200px)
                tableContainer.style.height = (windowHeight - 200) + 'px';
            }

            // Appelez la fonction lorsque la page est chargée
            window.onload = adjustTableHeight;

            // Appelez la fonction lorsque la fenêtre est redimensionnée
            window.onresize = adjustTableHeight;
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                // Par défaut, le bouton "Non" sera sélectionné grâce à l'attribut 'checked' dans le HTML.

                // Si vous souhaitez ajouter un comportement spécifique lors de la sélection des boutons radio
                const radioOui = document.getElementById('alimentantionOui');
                const radioNon = document.getElementById('alimentantionNon');

                radioOui.addEventListener('change', function() {
                    if (this.checked) {
                        console.log('Option "Oui" sélectionnée');
                    }
                });

                radioNon.addEventListener('change', function() {
                    if (this.checked) {
                        console.log('Option "Non" sélectionnée');
                    }
                });
            });
        </script>

        <script type="text/javascript">
        $(document).ready(function () {
            // Fonction pour vérifier le numéro FEB
            function verifierNumeroFEB(numerofeb) {
                // Vérifier si le champ est vide
                if (numerofeb.trim() === '') {
                    $('#numerofeb_error').text('Renseigner le champ numéro F.E.B');
                    $('#numerofeb').removeClass('has-success has-error'); // Supprime toutes les classes
                    $('#numerofeb_info').text('');
                    document.getElementById("addfebbtn").disabled = true; // Désactive le bouton
                    return; // Ne pas envoyer la requête
                }

                // Envoi de la requête AJAX
                $.ajax({
                    url: '{{ route('check.feb') }}', // Votre route Laravel
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token pour Laravel
                        numerofeb: numerofeb
                    },
                    success: function (response) {
                        if (response.exists) {
                            $("#numerofeb_error").html(
                                '<i class="fa fa-times-circle"></i> Numéro FEB existe déjà'
                            );
                            $('#numerofeb').removeClass('has-success'); // Supprime la classe de succès
                            $('#numerofeb').addClass('has-error'); // Ajoute la classe d'erreur
                            $('#numerofeb_info').text('');
                            document.getElementById("addfebbtn").disabled = true; // Désactive le bouton
                        } else {
                            $("#numerofeb_info").html(
                                '<i class="fa fa-check-circle"></i> Numéro Disponible'
                            );
                            $('#numerofeb').removeClass('has-error'); // Supprime la classe d'erreur
                            $('#numerofeb').addClass('has-success'); // Ajoute la classe de succès
                            $('#numerofeb_error').text('');
                            document.getElementById("addfebbtn").disabled = false; // Active le bouton
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            // Vérification automatique à l'ouverture de la page
            let numerofebInitial = $('#numerofeb').val(); // Récupère la valeur initiale
            verifierNumeroFEB(numerofebInitial);

            // Vérification lors du blur (quand l'utilisateur quitte le champ)
            $('#numerofeb').blur(function () {
                let numerofeb = $(this).val();
                verifierNumeroFEB(numerofeb);
            });
        });


        $(document).ready(function() {

                $(document).on('change', '.ligneid', function() {
                    var cat_id = $(this).val();
                    var div = $(this).parent();

                    $.ajax({
                        type: 'get',
                        url: "{{ route('condictionsearch') }}",
                        data: {
                            'id': cat_id
                        },
                        success: function(reponse) {
                            if (reponse.trim() !== "") {
                                // La réponse n'est pas vide, mettre à jour le contenu HTML
                                $("#showcondition").html(reponse);
                            } else {
                                // La réponse est vide ou nulle, faire quelque chose d'autre ou ne rien faire
                                console.log("La réponse est vide ou nulle.");
                            }
                        }
                    });
                });

                $(document).on('change', '.ligneid', function() {
                    var ligid = $(this).val();
                    var div = $(this).parent();
                    var op = " ";
                    $.ajax({
                        type: 'get',
                        url: "{{ route('getactivite') }}",
                        data: {
                            'id': ligid
                        },
                        success: function(reponse) {
                            $("#Showpoll").html(reponse);
                        },
                        error: function() {
                            alert(
                                "Attention! \n Erreur de connexion a la base de donnee ,\n verifier votre connection"
                            );
                        }
                    });
                });
        });
        </script>

        <script>
            document.getElementById('datelimite').addEventListener('change', function() {
                const dateFeb = new Date(document.getElementById('datefeb').value);
                const dateLimite = new Date(this.value);

                if (dateFeb && dateLimite && dateLimite < dateFeb) {
                    toastr.error("La Date limite doit être supérieure ou égale à la Date du dossier FEB.");
                    this.value = ''; // Réinitialise la date limite pour forcer une nouvelle sélection valide
                }
            });



            // Variable pour stocker le numéro de ligne actuel
            // Variable pour stocker le numéro de ligne actuel
            var rowIdx = 2;

            // Ajouter une ligne au clic sur le bouton "Ajouter"
            $("#addBtn").on("click", function() {
                // Ajouter une nouvelle ligne au tableau
                $("#tableEstimate tbody").append(`
                        <tr id="R${rowIdx}">
                            <td><input style="width:100%; background-color:#c0c0c0; Padding:0px" type="text" id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="${rowIdx}"  readonly></td>
                            <td><div id="Showpoll${rowIdx}" class="Showpoll"> </div> </td>
                            <td><input style="width:100%" type="text" id="libelle_description" name="libelle_description[]" class="form-control form-control-sm" required></td>
                            <td><input style="width:100%" type="text" id="unit_cost" name="unit_cost[]" class="form-control form-control-sm" required></td>
                            <td><input style="width:100%" type="text" id="qty" name="qty[]" value="1" class="form-control form-control-sm qty" required ></td>
                            <td><input style="width:100%" type="number" min="1" id="frenquency" value="1" name="frenquency[]" class="form-control form-control-sm frenquency" required ></td>
                            <td><input style="width:100%" type="number" min="0" id="pu" name="pu[]" class="form-control form-control-sm pu" required></td>
                            <td><input style="width:100%; background-color:#c0c0c0" type="text" min="0" id="amount" name="amount[]" class="form-control form-control-sm total" value="0" readonly></td>
                            <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Enlever"><i class="far fa-trash-alt"></i></a></td>
                        </tr>
                `);

                // Cloner le contenu de l'élément Showpoll dans la nouvelle ligne
                var $originalShowpoll = $('#Showpoll');
                var $newShowpoll = $originalShowpoll.clone().attr('id', `Showpoll${rowIdx}`);
                $(`#R${rowIdx}`).find('.Showpoll').replaceWith($newShowpoll);

                // Incrémenter le numéro de ligne
                rowIdx++;
            });

            // Supprimer une ligne au clic sur le bouton "Enlever"
            $("#tableEstimate tbody").on("click", ".remove", function() {
                // Supprimer la ligne
                $(this).closest("tr").remove();

                // Mettre à jour les numéros de ligne pour les lignes suivantes
                $("#tableEstimate tbody tr").each(function(index) {
                    $(this).attr("id", `R${index + 2}`);
                    $(this).find("#numerodetail").val(index + 2);
                });

                // Mettre à jour le total global
                calc_total();
            });

            // Mettre à jour les totaux lors de la modification des champs "pu", "qty", et "frenquency"
            $("#tableEstimate tbody").on("input", ".pu, .qty, .frenquency", function() {
                var pu = parseFloat($(this).closest("tr").find(".pu").val().replace(/\s/g, '')) || 0;
                var qty = parseFloat($(this).closest("tr").find(".qty").val().replace(/\s/g, '')) || 0;
                var frenquency = parseFloat($(this).closest("tr").find(".frenquency").val().replace(/\s/g, '')) || 0;

                var total = pu * qty * frenquency;

                // Afficher le total sans décimales si elles sont nulles
                var formattedTotal = (total % 1 === 0) ?
                    total.toLocaleString('fr-FR') :
                    total.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                $(this).closest("tr").find(".total").val(formattedTotal);

                calc_total();
            });

            // Fonction pour calculer le total
            function calc_total() {
                var sum = 0;

                // Additionner les valeurs des champs "total" de chaque ligne
                $(".total").each(function() {
                    // Enlever les espaces pour s'assurer d'un bon calcul
                    sum += parseFloat($(this).val().replace(/\s/g, '')) || 0;
                });

                // Formater le total sans décimales si elles sont nulles
                var formattedSum = (sum % 1 === 0) ?
                    sum.toLocaleString('fr-FR') :
                    sum.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, " ");

                // Mettre à jour le total global
                $(".subtotal").text(formattedSum);
                $(".total-global").text(formattedSum);
            }


            $(function() {
                $(document).on('change', '.soldeligne', function() {
                    var cat_id = $(this).val();
                    var div = $(this).parent();
                    var op = " ";
                    $.ajax({
                        type: 'get',
                        url: "{{ route('findligne') }}",
                        data: {
                            'id': cat_id
                        },
                        success: function(data) {
                            console.log(data);

                            if (status == 200) {
                                if (data.length == 0) {
                                    op += '<input value="0" selected disabled />';
                                    document.getElementById("tauxexecution").innerHTML = op
                                } else {

                                    for (var i = 0; i < data.length; i++) {
                                        op += '<input  value="' + data[i].annee + '" />';
                                        document.getElementById("tauxecution").innerHTML = op
                                    }
                                }


                            }
                            if (status == 201) {
                                toastr.error('Erreur de recupeation');
                            }

                            if (status == 202) {
                                toastr.success("Feb ajouté avec succès !", "Enregistrement");
                            }




                        },
                        error: function() {
                            toastr.error(
                                "Attention! \n Erreur de connexion a la base de donnee ,\n verifier votre connection"
                            );
                        }
                    });
                });


                $("#addfebForm").submit(function(e) {
                    e.preventDefault();
                    const fd = new FormData(this);
                    $("#addfebbtn").html('<i class="fas fa-spinner fa-spin"></i>');
                    document.getElementById("addfebbtn").disabled = true;

                    $.ajax({
                        url: "{{ route('storefeb') }}",
                        method: 'post',
                        data: fd,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 200 && response.redirect) {

                                toastr.success(
                                    "Feb ajouté avec succès !", // Message
                                    "Succès !", // Titre
                                    {
                                        closeButton: true, // Ajoute un bouton de fermeture
                                        progressBar: true, // Affiche une barre de progression
                                        //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                        timeOut: 3000, // Durée d'affichage (en millisecondes)
                                        extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                    }
                                );
                                      
                                window.location.href = response.redirect;

                            } else if (response.status == 201) {
                                toastr.error("Attention: FEB numéro existe déjà !", "Attention");
                                $("#numerofeb_error").text("Numéro existe");
                                $('#numerofeb').addClass('has-error');
                                document.getElementById("addfebbtn").disabled = false;
                                $("#addfebbtn").html(
                                    '<i class="fa fa-cloud-upload-alt"></i>  Sauvegarder');
                            } else if (response.status == 202) {
                                toastr.error("Erreur d'exécution: " + response.error, "Erreur");
                                document.getElementById("addfebbtn").disabled = false;
                                $("#addfebbtn").html(
                                    '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            } else if (response.status == 203) {
                                // Affiche la modale d'erreur avec le message d'avertissement
                                $('#errorMessage').text(
                                    "Tu ne peux pas exécuter cette opération car tu as dépassé le montant autorisé."
                                );
                                $('#erreurMessage').modal('show'); // Affiche la modale

                                document.getElementById("addfebbtn").disabled = false;
                                $("#addfebbtn").html(
                                    '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            } else if (response.status == 204) {
                                toastr.error(response.message, "Attention");

                                document.getElementById("addfebbtn").disabled = false;
                                $("#addfebbtn").html(
                                    '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            }

                            $("#addfebbtn").text('Sauvegarder');
                            setTimeout(function() {

                            }, 600); // 600 millisecondes = 0.6 secondes
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            toastr.error("Erreur de communication avec le serveur.", "Erreur");
                            document.getElementById("addfebbtn").disabled = false;
                            $("#addfebbtn").html(
                                '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');

                        }
                    });
                });


            });
        </script>


     
    @endsection
