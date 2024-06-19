@extends('layout/app')
@section('page-content')
<style>
    .custom-modal-dialog {
        max-width: 400px;
        /* Réglez la largeur maximale du popup selon vos besoins */
        max-height: 50px;
        /* Réglez la hauteur maximale du popup selon vos besoins */
    }
</style>
<div class="main-content">
  <div class="page-content">
        <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">
            <div class="card-header p-4 border-bottom border-300 bg-soft">
                <div class="row g-3 justify-content-between align-items-end">
                    <div class="col-12 col-md">
                        <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="mdi mdi-book-open-page-variant-outline"></i> BON DE PETITE CAISSE </h4>
                    </div>
                    <div class="col col-md-auto">

                        <a href="#" id="fetchDataLink"> <i class="fas fa-sync-alt"></i> Actualiser</a>


                        <a href="javascript::;" data-bs-toggle="modal" data-bs-target="#addbpcModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fa fa-plus-circle"></span> Nouvel Bon de petite caisse</a>

                    </div>
                </div>
            </div>
            <div class="card-body p-0">

                <div id="tableExample2">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm fs--1 mb-0" style="background-color:#3CB371;color:white">

                            <tbody id="showSommefeb">

                            </tbody>

                        </table>

                    </div>

                </div>



                <div id="tableExample2">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort border-top ">
                                        <center> <b> Actions </b></center>
                                    </th>
                                    <th class="sort border-top">
                                        <center><b>N<sup>o</sup> BPC </b></center>
                                    </th>



                                    <th class="sort border-top"> <b>
                                            <center>Motif</center>
                                        </b>
                                    </th>

                                    <th class="sort border-top"> <b>
                                            <center>Montant total </center>
                                        </b>
                                    </th>

                                    <th class="sort border-top"> <b>
                                            <center>Sous signe </center>
                                        </b>
                                    </th>

                                    <th class="sort border-top"> <b>
                                            <center>Date BPC</center>
                                        </b>
                                    </th>

                                    <th class="sort border-top"> <b>
                                            <center>Créé par </center>
                                        </b>
                                    </th>


                                    <th class="sort border-top"> <b>
                                            <center>Créé par </center>
                                        </b>
                                    </th>





                                </tr>
                            </thead>


                            <tbody class="show_all" id="show_all">
                                <tr>
                                    <td colspan="15">
                                        <h5 class="text-center text-secondery my-5">
                                            <center> @include('layout.partiels.load') </center>
                                    </td>
                                </tr>
                            </tbody>

                        </table>

                        <br><br><br><br>
                        <br><br><br><br>
                        <br>


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@include('document.bonpetitcaise.modale')

<BR><BR>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script type="text/javascript">
    $('#numerobpc').blur(function() {
        var numero = $(this).val();
        // Vérification si le champ est vide
        if (numero.trim() === '') {
            $('#numero_error ').text('Renseigner le champ numéro B.P.C');
            $('#numero').removeClass('has-success has-error'); // Supprime toutes les classes de succès ou d'erreur
            $('#numero_info').text('');
            return; // Sortir de la fonction si le champ est vide
        }

        // Envoi de la requête AJAX au serveur
        $.ajax({
            url: '{{ route("check.feb") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // CSRF token pour Laravel
                numero: numero
            },
            success: function(response) {
                if (response.exists) {

                    $("#numero_error ").html('<i class="fa fa-times-circle"></i> Numéro BCP existe déjà');
                    $('#numero').removeClass('has-success') // Supprime la classe de succès
                    $('#numero').addClass('has-error');
                    $('#numero_info').text('');
                    document.getElementById("addbpcbtn").disabled = true;
                } else {

                    $("#numero_info").html('<i class="fa fa-check-circle"></i> Numéro Disponible');
                    $('#numero').removeClass('has-error') // Supprime la classe de succès
                    $('#numero').addClass('has-success');
                    $('#numero_error ').text('');
                    document.getElementById("addbpcbtn").disabled = false;
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
</script>

<script>
    // Variable pour stocker le numéro de ligne actuel
    var rowIdx = 2;

    // Ajouter une ligne au clic sur le bouton "Ajouter"
    $("#addBtn").on("click", function() {
        // Ajouter une nouvelle ligne au tableau
        $("#tableEstimate tbody").append(`
        <tr id="R${rowIdx}">
            <td><input style="width:100%" type="number" id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="${rowIdx}"></td>
            <td>
                <select class="form-control form-control-sm" id="referenceid" name="referenceid" required>
                    <option disabled="true" selected="true" value="">Sélectionner la ligne budgétaire</option>
                    @foreach ($compte as $comptes)
                    <optgroup label="{{ $comptes->libelle }}">
                        @php
                        $idc = $comptes->id;
                        $res= DB::select("SELECT * FROM comptes WHERE compteid= $idc");
                        @endphp
                        @foreach($res as $re)
                        <option value="{{ $re->id }}"> {{ $re->numero }}. {{ $re->libelle }} </option>
                        @endforeach
                    </optgroup>
                    @endforeach
                </select>
            </td>
            <td><input style="width:100%" type="number" id="montant" name="montant[]" class="form-control form-control-sm montant" min="0" required></td>
            <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Enlever"><i class="far fa-trash-alt"></i></a></td>
        </tr>
    `);

        // Incrémenter le numéro de ligne
        rowIdx++;
        calc_total();
    });

    // Supprimer une ligne au clic sur le bouton "Enlever"
    $("#tableEstimate tbody").on("click", ".remove", function() {
        // Supprimer la ligne
        $(this).closest("tr").remove();

        // Réinitialiser les numéros de ligne
        reset_row_indexes();

        // Recalculer le total
        calc_total();
    });

    // Mettre à jour les totaux lors de la modification des champs "montant"
    $("#tableEstimate tbody").on("input", ".montant", function() {
        calc_total();
    });

    // Fonction pour calculer le total
    function calc_total() {
        var sum = 0;
        $(".montant").each(function() {
            sum += parseFloat($(this).val()) || 0;
        });
        $(".total-global").text(sum.toFixed(2));
    }
    // Fonction pour réinitialiser les numéros de ligne après suppression
    function reset_row_indexes() {
        rowIdx = 1;
        $("#tableEstimate tbody tr").each(function() {
            $(this).attr("id", `R${rowIdx}`);
            $(this).find("#numerodetail").val(rowIdx);
            rowIdx++;
        });
    }

    // Calcul initial du total au chargement de la page
    $(document).ready(function() {
        calc_total();
    });
</script>


<script>
    $(function() {

        $("#addbpcForm").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#addbpcbtn").html('<i class="fas fa-spinner fa-spin"></i>');
            document.getElementById("addbpcbtn").disabled = true;
            $("#loadingModal").modal('show'); // Affiche le popup de chargement

            $.ajax({
                url: "{{ route('storebpc') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        fetchAll();

                        $("#addbpcbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        $("#numero_error ").text("");
                        $('#numero').addClass('');
                        $("#addbpcForm")[0].reset();
                        $("#addbpcModal").modal('hide');
                        document.getElementById("addbpcbtn").disabled = false;
                        toastr.success("Bon de petit caisse ajouté avec succès !", "Enregistrement");
                    }
                    if (response.status == 201) {
                        toastr.error("Attention: BPC numéro existe déjà !", "Attention");
                        $("#addbpcModal").modal('show');
                        $("#numero_error ").text("Numéro existe");
                        $('#numero').addClass('has-error');
                        document.getElementById("addbpcbtn").disabled = false;
                        $("#addbpcbtn").html('<i class="fa fa-cloud-upload-alt"></i>  Sauvegarder');
                    }
                    if (response.status == 202) {
                        toastr.error("Erreur d'exécution: " + response.error, "Erreur");
                        $("#addbpcModal").modal('show');
                        document.getElementById("addbpcbtn").disabled = false;
                        $("#addbpcbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                    }
                    if (response.status == 203) {
                        if (confirm(response.message)) {
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'confirm_ligne',
                                value: '1'
                            }).appendTo('#addbpcForm');
                            $('#addbpcForm').submit();

                        } else {
                            toastr.info("Vous avez annulée l'opération.", "Info");
                            $("#addbpcModal").modal('show');
                            document.getElementById("addbpcbtn").disabled = false;
                            $("#addbpcbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        }
                    }
                    if (response.status == 204) {
                        toastr.error(response.message, "Attention");
                        $("#addbpcModal").modal('show');
                        document.getElementById("addbpcbtn").disabled = false;
                        $("#addbpcbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                    }

                    $("#addbpcbtn").text('Sauvegarder');
                    $("#loadingModal").modal('hide');
                    setTimeout(function() {
                        $("#loadingModal").modal('hide');
                    }, 600); // 2000 millisecondes = 2 secondes
                }
            });
        });
        fetchAll();

        function fetchAll() {
            $.ajax({
                url: "{{ route('liste_bpc') }}",
                method: 'get',
                success: function(reponse) {
                    $("#show_all").html(reponse);
                }
            });
        }
    });
</script>
@endsection