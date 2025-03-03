@extends('layout/app')
@section('page-content')
    <div class="main-content">

        <div class="page-content">
            <div class="row">
                <div class="col-xl-7" style="margin:auto">
                    <div class="card">
                        <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"
                            style="padding: 0.40rem 1rem;">

                            <h4 class="mb-sm-0"><i class="fa fa-university"></i> Listes des banques</h4>
                            <div class="page-title-right">
                                <button type="button" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa fa-plus-circle"></i>
                                    Créer</button>
                            </div>

                        </div>
                        <div class="card-body pt-0 pb-3">
                            <div id="overview-chart" data-colors='["#1f58c7"]' class="apex-charts" dir="ltr"></div>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm fs--1 mb-0">
                                    <thead>
                                        <tr>
                                            <th><b>#</b></th>
                                            <th><b>Nom affiché</b></th>
                                            <th><b>Créé par</b></th>
                                            <th><b>Créé le</b></th>
                                            <th><b>Actions</b></th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_all">
                                        <tr>
                                            <td colspan="5">
                                                <h5 class="text-center text-secondery my-5">
                                                    @include('layout.partiels.load')
                                            </td>
                                        </tr>
                                    </tbody>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- new banque modal --}}
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalTitle"><i class="fa fa-plus-circle"></i> Nouvelle Banque</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="addform">
                    @method('post')
                    @csrf
                    <div class="modal-body">
                        <input class="form-control" id="libelle" name="libelle" type="text" placeholder="Entrer nom"
                            required /> <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" name="add" id="add"
                            class="btn btn-primary waves-effect waves-light"><i class="fa fa-cloud-upload-alt"></i>
                            Sauvegarder</button>
                    </div>
                </form>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    {{-- Edit banque modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="editform">
                    @method('post')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="verticallyCenteredModalLabel"><i class="fa fa-edit"></i> Modification
                            banque </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label class="text-1000 fw-bold mb-2">Libellé </label>
                        <input type="hidden" name="bid" id="bid">
                        <input class="form-control" name="blibelle" id="blibelle" type="text"
                            placeholder="Entrer function" name="blibelle" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" id="editbtn" class="btn btn-primary" type="button"><i
                                class="fa fa-cloud-upload-alt"></i> Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(function() {
            // Add profil ajax 
            $("#addform").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);

                $("#add").html('<i class="fas fa-spinner fa-spin"></i>');
                document.getElementById("add").disabled = true;


                $.ajax({
                    url: "{{ route('storebanque') }}",
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {

                        if (response.status == 200) {
                            toastr.success(
                                "Banque enregistrer avec succès !", // Message
                                "Succès !", // Titre
                                {
                                    closeButton: true, // Ajoute un bouton de fermeture
                                    progressBar: true, // Affiche une barre de progression
                                    //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                    timeOut: 3000, // Durée d'affichage (en millisecondes)
                                    extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                }
                            );


                            fetchAllbanque();
                            $("#addModal").modal('hide');
                            $("#addform")[0].reset();
                            document.getElementById("add").disabled = false;
                            $("#add").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');

                        }
                        if (response.status == 201) {
                          

                            toastr.error(
                                "Libellé banque existe déjà !.", // Message
                                "Attention !", // Titre
                                {
                                    closeButton: true, // Ajoute un bouton de fermeture
                                    progressBar: true, // Affiche une barre de progression
                                    positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                    timeOut: 8000, // Durée d'affichage (en millisecondes)
                                    extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                }
                            );


                            $("#addModal").modal('hide');
                            $("#add").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            document.getElementById("add").disabled = false;

                        }

                        if (response.status == 202) {
                          
                            toastr.error(
                                "Le banque  existe déjà !.", // Message
                                "Attention !", // Titre
                                {
                                    closeButton: true, // Ajoute un bouton de fermeture
                                    progressBar: true, // Affiche une barre de progression
                                    positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                    timeOut: 8000, // Durée d'affichage (en millisecondes)
                                    extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                }
                            );


                            $("#addModal").modal('show');
                            $("#add").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            document.getElementById("add").disabled = false;
                        }

                    }
                });
            });

            // Edit profil ajax request
            $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('edibanque') }}",
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $("#blibelle").val(response.libelle);
                        $("#bid").val(response.id);
                    }
                });
            });

            $("#editform").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);

                $("#editbtn").html('<i class="fas fa-spinner fa-spin"></i>');
                document.getElementById("editbtn").disabled = true;

                $.ajax({
                    url: "{{ route('updatebanque') }}",
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                        
                            toastr.success(
                                "Banque modifier avec succès !", // Message
                                "Succès !", // Titre
                                {
                                    closeButton: true, // Ajoute un bouton de fermeture
                                    progressBar: true, // Affiche une barre de progression
                                    timeOut: 3000, // Durée d'affichage (en millisecondes)
                                    extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                }
                            );

                            fetchAllbanque();

                            $("#editModal").modal('hide');
                            $("#editform")[0].reset();
                            $("#editbtn").html( '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            document.getElementById("editbtn").disabled = false;
                        }

                        if (response.status == 201) {
                           
                            toastr.error(
                                "Le titre de la banque existe déjà ", // Message
                                "Attention !", // Titre
                                {
                                    closeButton: true, // Ajoute un bouton de fermeture
                                    progressBar: true, // Affiche une barre de progression
                                    positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                    timeOut: 8000, // Durée d'affichage (en millisecondes)
                                    extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                }
                            );

                            $("#editbtn").html(
                                '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            document.getElementById("editbtn").disabled = false;
                        }

                        if (response.status == 205) {
                          

                            toastr.error(
                                "Vous n'avez pas l'accreditation de Modifier cette banque", // Message
                                "Attention !", // Titre
                                {
                                    closeButton: true, // Ajoute un bouton de fermeture
                                    progressBar: true, // Affiche une barre de progression
                                    positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                    timeOut: 8000, // Durée d'affichage (en millisecondes)
                                    extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                }
                            );


                            $("#editbtn").html(
                                '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            document.getElementById("editbtn").disabled = false;
                        }

                    }
                });
            });

            // Delete classeur ajax request'

            

            $(document).on('click', '.deleteIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let titre = $(this).data('titre');
                let csrf = '{{ csrf_token() }}';

                Swal.fire({
                    icon: 'warning',
                    title: 'Supprimer ?',
                    html: `<p class='swal-text'>Cette action entraînera la suppression du <b>${titre}</b>.</p><p class='swal-text'><i class='fa fa-info-circle' style='color: red;'></i> Attention, il n'y a pas de retour en arrière.</p>`,
                    showCancelButton: true,
                    confirmButtonColor: 'green',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer !',
                    cancelButtonText: 'Annuler',
                    allowOutsideClick: false,
                    customClass: {
                        content: 'swal-custom-content'
                    },
                    preConfirm: () => {
                        return new Promise((resolve) => {
                            $.ajax({
                                url: "{{ route('deletebanque') }}",
                                method: 'delete',
                                data: { id: id, _token: csrf },
                                success: function(response) {
                                    if (response.status == 200) {
                                        // Résoudre directement sans afficher "Suppression en cours..."
                                        resolve(response);
                                    } else if (response.status == 205) {
                                      
                                        toastr.error(
                                            "Vous n'avez pas l'accréditation de supprimer.", // Message
                                            "Attention !", // Titre
                                            {
                                                closeButton: true, // Ajoute un bouton de fermeture
                                                progressBar: true, // Affiche une barre de progression
                                                positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                                timeOut: 9000, // Durée d'affichage (en millisecondes)
                                                extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                            }
                                        );


                                        resolve(response);
                                    } else {
                                        let errorMessage = response.message || "Erreur lors de la suppression .";
                                        if (response.error) {
                                            errorMessage += `\nErreur technique : ${response.error}`;
                                        }
                                        if (response.exception) {
                                            errorMessage += `\nException : ${response.exception}`;
                                        }
                                        toastr.error(errorMessage, "Erreur");
                                        resolve(response);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    let errorMsg = xhr.responseJSON ? xhr.responseJSON.message : "Erreur de réseau. Veuillez réessayer.";
                                    if (xhr.responseJSON && xhr.responseJSON.exception) {
                                        errorMsg += `\nException : ${xhr.responseJSON.exception}`;
                                    }
                                    toastr.error(errorMsg, "Erreur");
                                    resolve({ status: 500, message: errorMsg });
                                }
                            });
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed && result.value && result.value.status == 200) {
                        // Afficher uniquement le message de succès
                        toastr.success("Banque supprimé avec succès !", "Succès", {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 3000,
                            extendedTimeOut: 1000
                        });
                        fetchAllbanque();
                    }
                });
            });




            fetchAllbanque();


            function fetchAllbanque() {
            $.ajax({
                url: "{{ route('fetchAllBanque') }}",
                method: 'get',
                success: function(response) {
                    // Si la requête réussit, mettez à jour le contenu
                    $("#show_all").html(response);
                },
                error: function(xhr, status, error) {
                    // Gestion des erreurs
                    let errorMessage = "Une erreur est survenue lors du chargement des banque.";
                    
                    // Ajoutez plus de détails si des informations sont disponibles
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += "\nDétails : " + xhr.responseJSON.message;
                    } else if (status === "timeout") {
                        errorMessage = "Le serveur n'a pas répondu à temps. Veuillez réessayer plus tard.";
                    } else if (status === "error") {
                        errorMessage = "Erreur réseau. Veuillez vérifier votre connexion internet.";
                    }

                    // Affichez l'erreur via toastr
                    toastr.error(errorMessage, "Erreur de Chargement");
                }
            });
        }
        });
    </script>
@endsection
