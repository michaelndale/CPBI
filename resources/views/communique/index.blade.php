@extends('layout/app')
@section('page-content')
<style type="text/css">
    .has-error {
        border: 1px solid red;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style="margin:auto">
            <div class="card-header p-4 border-bottom border-300 bg-soft">
                <div class="row g-3 justify-content-between align-items-end">
                    <div class="col-12 col-md">
                        <h4 class="card-title mb-0"> <i class="fa fa-info-circle"></i> Communication d'alerte a toutes l'equipe </h4>
                    </div>
                    <div class="col col-md-auto">
                        <a href="javascript::;"  class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#addModale" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Créer </a>

                    </div>
                </div>
            </div>
            

            <div class="card-body p-0" id="table-container" style="overflow-y: auto;">
                <div class="card">
                    <div class="table-responsive">
                        <div class="table-responsive" id="table-container" style="overflow-y: auto;">
                            <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                <thead>
                                    <tr>
                                        
                                        <th>Titre</th>
                                        <th>Description</th>
                                        <th style="width:100px">Date limite</th>
                                        <th style="width:150px">Créé le</th>
                                        <th style="width:100px"><center>Statut <center></th>
                                        <th style="width:150px">Créé par</th>
                                        <th style="width:100px"><center>Actions</center></th>
                                    </tr>
                                </thead>
                                <tbody  id="ShowAllCom">
                                    <tr>
                                        <td colspan="7">
                                            <h5 class="text-center text-secondery my-5">
                                                @include('layout.partiels.load')
                                        </td>
                                    </tr>
                                </tbody>
                                </tbody>
                            </table>
                            <br><br> <br> <br> <br> <br> <br>  <br>  <br>  <br>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>


@include('communique.modal')


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
    $(function() {

        $('#addModale').modal({
            backdrop: 'static',
            keyboard: false
        });


        // Add user ajax 
        $("#addForm").submit(function(e) 
        {
            e.preventDefault();
            const fd = new FormData(this);
            $("#addbtn").html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
            $.ajax({
                url: "{{ route('storeCom') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        communique();
                        toastr.success("La communiqué a été ajoutée avec succès", "Succès");
                        $("#addForm")[0].reset();
                        $("#addModale").modal('hide');
                    } else if (response.status == 201) {
                        toastr.error("Une erreur est survenu lors de la creation !", "Attention");
                    } else {
                        toastr.error("Une erreur est survenue lors de l'ajout de la communication", "Erreur");
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error("Une erreur est survenue lors de l'envoi de la requête au serveur", "Erreur");
                    console.error(xhr.responseText);
                },
                complete: function() {
                    $("#addbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder').prop('disabled', false);
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
                text: "Une communiqué est sur le point d'être DÉTRUITE ! Faut-il vraiment exécuter « la Suppression » ? ",
                showCancelButton: true,
                confirmButtonColor: 'green',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, Supprimer !'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('deleteCom') }}",
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            if (response.status == 200) {
                                toastr.success("Communiqué supprimée avec succès.", "Succès");
                                communique();
                            } else if (response.status == 201) {
                                toastr.error("Vous n'avez pas l'autorisation de supprimer cette Communiqué.", "Erreur");
                            } else {
                                toastr.error("Une erreur est survenue lors de la suppression du Communiqué.", "Erreur");
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error("Une erreur est survenue lors de la suppression de Communiqué.", "Erreur");
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });


        communique();
        function communique() {
            $.ajax({
                url: "{{ route('listeCom') }}", // URL de la route à interroger
                method: 'get', // Méthode de la requête HTTP
                success: function(response) { // Fonction à exécuter en cas de succès de la requête
                    if (response.status == 500) { // Vérifie le statut de la réponse
                        toastr.error("Une erreur est survenue lors de la récupération des données.", "Erreur"); // Affiche un message d'erreur
                    } else {
                        $("#ShowAllCom").html(response); // Met à jour le contenu de l'élément avec l'ID 'show_all_activite' avec la réponse
                    }
                },
                error: function() { // Fonction à exécuter en cas d'erreur de la requête
                    toastr.error("Une erreur est survenue lors de la récupération des données.", "Erreur"); // Affiche un message d'erreur
                }
            });

        }

    });
</script>

@endsection