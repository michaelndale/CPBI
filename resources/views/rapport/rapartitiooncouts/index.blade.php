@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card"
                style=" margin:auto">

                <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">                 
                    <h4 class="mb-sm-0"><i class="fa fa-list"></i> Répartition des Coûts administratifs -Exercices </h4>
                        <div class="page-title-right">
                          <a href="#" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" id="fetchDataLink"> <i class="fas fa-sync-alt"></i> </a>
                          <a href="javascript::;"  class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" chauffeur="button" data-bs-toggle="modal" data-bs-target="#addDealModal"
                          aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Ajouter </a>
                    </div>
                </div>


              


                <div class="card-body p-0">

                    <div id="tableExample2">
                        <div class="table-responsive" id="table-container" style="overflow-y: auto;">
                            
                            <br> <br> <br> <br> 
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>


    {{-- new compte modal --}}



    <div class="modal fade" id="addDealModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDealModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="addrapportform">
                    @method('post')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="verticallyCenteredModalLabel">Recherche de la du rapport </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row g-3">

                            <div class="col-sm-12 col-lg-12 col-xl-7">
                                <label class="text-1000 fw-bold mb-2">Projet </label>
                                <div class="row g-2">
                                    <div class="col">
                                        <input value="{{ Session::get('id') }}" type="hidden" name="projetid"
                                            id="projetid">
                                        <input value="{{ Session::get('title') }}" class="form-control form-control-sm"
                                            style="width: 100%; background-color:#c0c0c0" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 col-lg-6 col-xl-5">
                                <label class="text-1000 fw-bold mb-2">Service </label>
                                <div class="row g-2">
                                    <div class="col">
                                        <select type="text" name="serviceid" id="serviceid" style="width: 100%"
                                            class="form-control form-control-sm" required>
                                            <option disabled="true" selected="true" value="">--Aucun--</option>
                                           
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 col-lg-6 col-xl-2">
                                <label class="text-1000 fw-bold mb-2">Periode du </label>
                                <div class="row g-2">
                                    <div class="col">
                                        <input id="datede" name="datede" class="form-control form-control-sm"
                                            type="date" required />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 col-lg-6 col-xl-2">
                                <label class="text-1000 fw-bold mb-2">Au</label>
                                <div class="row g-2">
                                    <div class="col">
                                        <input id="dateau" name="dateau" class="form-control form-control-sm"
                                            type="date" required />
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 col-lg-6 col-xl-4">
                                <label class="text-1000 fw-bold mb-2"> Etablie </label>
                                <div class="row g-2">
                                    <div class="col">
                                        <select type="text" class="form-control form-control-sm" name="etabliepar"
                                            id="etabliepar" required>
                                            <option disabled="true" selected="true" value="">--Sélectionner --
                                            </option>
                                           
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 col-lg-6 col-xl-4">
                                <label class="text-1000 fw-bold mb-2">Verifier par</label>
                                <div class="row g-2">
                                    <div class="col">
                                        <select type="text" class="form-control form-control-sm" name="verifier"
                                            id="verifier" required>
                                            <option disabled="true" selected="true" value="">--Sélectionner --
                                            </option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="sendSave" id="sendSave" class="btn btn-primary" type="button">
                            <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    </div>
    </div>


    <style>
        .swal-custom-content .swal-text {
            font-size: 14px;
            /* Ajustez la taille selon vos besoins */
        }
    </style>

<script>
    $(function() {
        // Soumission du formulaire pour ajouter un rapport via AJAX
        $("#addrapportform").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#sendSave").html('<i class="fas fa-spinner fa-spin"></i>');
            document.getElementById("sendSave").disabled = true;

            $.ajax({
                url: "{{ route('storeRapprochement') }}", // URL de l'enregistrement
                method: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    try {
                        if (response.status === 200) {
                            toastr.success("Rapport ajouté avec succès !", "Enregistrement");
                            $("#addrapportform")[0].reset(); // Réinitialiser le formulaire
                            $("#addDealModal").modal('hide'); // Fermer le modal
                            fetchRapports(); // Recharger la liste des rapports
                        } else if (response.status === 201) {
                            toastr.error("La ligne de compte dans ce projet existe déjà !", "Attention");
                        } else if (response.status === 202) {
                            toastr.error("Erreur lors de l'exécution : " + response.error, "Erreur");
                        } else {
                            toastr.error("Réponse inattendue du serveur.", "Erreur");
                        }
                    } catch (error) {
                        toastr.error("Erreur inattendue : " + error.message, "Erreur");
                    } finally {
                        $("#sendSave").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        document.getElementById("sendSave").disabled = false;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    let errorMessage = jqXHR.responseJSON && jqXHR.responseJSON.error 
                        ? jqXHR.responseJSON.error 
                        : errorThrown || textStatus || "Erreur inconnue";

                    toastr.error("Erreur lors de la requête : " + errorMessage, "Erreur");
                    $("#sendSave").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                    document.getElementById("sendSave").disabled = false;
                }
            });
        });

        // Fonction pour récupérer et afficher les rapports
        function fetchRapports() {
            $.ajax({
                url: "{{ route('getlisteRapportage') }}", // URL pour récupérer les rapports
                method: 'GET',
                success: function(response) {
                    $("#rapportTableContainer").html(response); // Remplacer le contenu du conteneur
                },
                error: function() {
                    toastr.error("Erreur lors de la récupération des rapports", "Erreur");
                }
            });
        }

        // Charger les rapports lorsque la page est prête
        $(document).ready(function() {
            fetchRapports(); // Appel initial pour charger les rapports
        });
    });
</script>

@endsection
