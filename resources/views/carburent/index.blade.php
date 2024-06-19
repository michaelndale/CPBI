@extends('layout/app')
@section('page-content')

<style type="text/css">
    .has-error {
        border: 1px solid red;
    }
</style>
<div class="main-content">
  <div class="page-content">
       
            <div class="row">
                <div class="col-12" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><i class="fa fa-gas-pump""></i> Gestion des Carburants  </h4>
            <div class=" page-title-right">
                                <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addCarburentModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Ajouter consommations de carburant.</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm fs--1 mb-0">
                        <thead>
                            <tr style="background-color:#82E0AA">
                                <th class="align-middle ps-3 name">#</th>
                                <th>Véhicule</th>
                                <th>Type carburant</th>
                                <th>Quantité</th>
                                <th>Coût</th>
                                <th>Fournisseur</th>
                                <th>Kilometrage debut</th>
                                <th>Kilometrage fin</th>
                                <th>Note</th>
                                <th>Date</th>
                                <th>
                                    <center>Action</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="showpleincarburent">
                            <tr>
                                <td colspan="11">
                                    <h5 class="text-center text-secondery my-5">
                                        @include('layout.partiels.load')
                                </td>
                            </tr>
                        </tbody>
                        </tbody>
                    </table>
                    <br><br><br><br><br><br>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@include('carburent.modale')

<script>
    $(function() {

        $('#addVehiculeModal').modal({
            backdrop: 'static',
            keyboard: false
        });

        // Add vehicule ajax 
        $("#addform").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);

            $("#addbtn").html('<i class="fas fa-spinner fa-spin"></i>');
            document.getElementById("addbtn").disabled = true;

            $.ajax({
                url: "{{ route('storevl') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        fetchAllvehicule();
                        toastr.success("Enregistrement reussi avec succès !", "Enregistrement");
                        $("#addbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        $("#matricule_error").text("");
                        $('#matricule').addClass('');
                        $("#addVehiculeModal").modal('hide');
                        $("#addform")[0].reset();
                        document.getElementById("addbtn").disabled = false;
                    }

                    if (response.status == 201) {
                        toastr.error("Le véhicule avec cette matricule existe déjà !", "error");
                        $("#addbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        $("#addVehiculeModal").modal('show');
                        $("#matricule_error").text("Matricule existe déjà !");
                        $('#matricule').addClass('has-error');
                        document.getElementById("addbtn").disabled = false;
                    }

                    if (response.status == 202) {
                        toastr.error("Erreur d'execution, verifier votre internet", "error");
                        $("#addVehiculeModal").modal('show');
                        $("#addbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        document.getElementById("addbtn").disabled = false;
                    }

                }
            });
        });

        // Get vehicule  request
        $(document).on('click', '.editvehicule', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: "{{ route('editveh') }}",
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#idv").val(response.id);
                    $("#matriculev").val(response.matricule);
                    $("#marquev").val(response.marque);
                    $("#modelev").val(response.modele);
                    $("#couleurv").val(response.couleur);
                    $("#numseriev").val(response.numeroserie);
                    $("#typev").val(response.type);
                    $("#carburentv").val(response.carburent);
                    $("#statutv").val(response.statut);
                }
            });
        });

        // update user ajax request
        $("#editform").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);


            $("#editbtn").html('<i class="fas fa-spinner fa-spin"></i>');
            document.getElementById("editbtn").disabled = true;

            $.ajax({
                url: "{{ route('updateveh') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        toastr.success("Mises ajours reussi  avec succès !", "Suppression");
                        $("#edit_vehiculeModal").modal('hide');
                        $("#editbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        document.getElementById("editbtn").disabled = false;

                        fetchAllvehicule();

                    }

                    if (response.status == 201) {
                        toastr.error("Le véhicule avec cette matricule existe déjà !", "error");
                        $("#editbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        $("#edit_vehiculeModal").modal('show');
                        document.getElementById("editbtn").disabled = false;
                    }

                    if (response.status == 202) {
                        toastr.error("Erreur d'execution, verifier votre internet", "error");
                        $("#edit_vehiculeModal").modal('show');
                        $("#editbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        document.getElementById("editbtn").disabled = false;
                    }


                }
            });
        });

        // Delete user ajax request
        $(document).on('click', '.deleteIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Vous ne pourrez pas revenir en arrière !",

                showCancelButton: true,
                confirmButtonColor: 'green',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui , Supprimer !'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('deletevl') }}",
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {

                            if (response.status == 200) {
                                toastr.success("Suppression  avec succès !", "Suppression");

                                fetchAllvehicule();
                            }

                            if (response.status == 205) {
                                toastr.error("Vous n'avez pas l'accreditation de supprimer ce type de véhicule!", "Erreur");
                            }

                            if (response.status == 202) {
                                toastr.error("Erreur d'execution !", "Erreur");
                            }
                        }
                    });
                }
            })
        });



        fetchcarburent();

        function fetchcarburent() {
            $.ajax({
                url: "{{ route('allcarburents') }}",
                method: 'get',
                success: function(reponse) {
                    $("#showpleincarburent").html(reponse);
                }
            });
        }

    });
</script>

@endsection