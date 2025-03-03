@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-7" style="margin:auto">
                    <div class="card">
                        <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"
                            style="padding: 0.40rem 1rem;">

                            <h4 class="mb-sm-0"><i class="fa fa-folder"></i> Listes des Dossier </h4>
                            <div class="page-title-right">
                                <a href="javascript:voide();" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true"
                                    aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i>
                                    Créer </a>
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-0 pb-3">
                            <div id="overview-chart" data-colors='["#1f58c7"]' class="apex-charts" dir="ltr"></div>
                            <div class="table-responsive">

                                <table class="table table-striped table-sm fs--1 mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><b>Titre</b></th>
                                            <th><b>Créé par </b></th>
                                            <th><b>Créé le</b></th>
                                            <th>
                                                <center><b>Action</b></center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_all_folder">
                                        <tr>
                                            <td colspan="4">
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

    <div class="modal fade" id="addDealModal" tabindex="-1" role="dialog" aria-labelledby="addDealModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="add_folder_form" autocomplete="off">
                    @method('post')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDealModalTitle"><i class="fa fa-plus-circle"></i> Nouvelle dossier
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="text-1000 fw-bold mb-2">Titre</label>
                        <input class="form-control" name="ftitle" id="ftitle" type="text"
                            placeholder="Entrer le titre" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" name="sendFolder" id="sendFolder"
                            class="btn btn-primary waves-effect waves-light"> <i class="fa fa-cloud-upload-alt"></i>
                            Sauvegarder</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="editFolderModal" tabindex="-1" role="dialog" aria-labelledby="editFolderModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="edit_folder_form" autocomplete="off">
                    @method('post')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDealModalTitle"><i class="fa fa-edit"></i> Modification dossier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="text-1000 fw-bold mb-2">Titre</label>
                        <input type="hidden" name="fid" id="fid">
                        <input class="form-control" name="flibelle" id="flibelle" type="text"
                            placeholder="Entrer dossier" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" name="editfolderbtn" id="editfolderbtn" value="Sauvegarder"
                            class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>

                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <script>
        $(function() {
            // Add department ajax 
            $("#add_folder_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);

                $("#sendFolder").html('<i class="fas fa-spinner fa-spin"></i>');
                document.getElementById("sendFolder").disabled = true;

                $.ajax({
                    url: "{{ route('storefl') }}",
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {

                            toastr.success(
                                "Dossier enregistrer avec succès !", // Message
                                "Succès !", // Titre
                                {
                                    closeButton: true, // Ajoute un bouton de fermeture
                                    progressBar: true, // Affiche une barre de progression
                                    //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                    timeOut: 3000, // Durée d'affichage (en millisecondes)
                                    extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                }
                            );


                            fetchAlldfolder();

                            $("#addDealModal").modal('hide');
                            $("#add_folder_form")[0].reset();
                            document.getElementById("sendFolder").disabled = false;
                            $("#sendFolder").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');

                        }

                        if (response.status == 201) {

                            toastr.error(
                                "Le titre du dossier existe déjà, deux dossiers avec le même titre n'est possible.", // Message
                                "Attention !", // Titre
                                {
                                    closeButton: true, // Ajoute un bouton de fermeture
                                    progressBar: true, // Affiche une barre de progression
                                    positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                    timeOut: 8000, // Durée d'affichage (en millisecondes)
                                    extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                }
                            );

                            $("#addDealModal").modal('show');
                            document.getElementById("sendFolder").disabled = false;
                            $("#sendFolder").html(
                                '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        }
                    }



                });
            });

            // Edit folder ajax request
            $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('editfl') }}",
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $("#flibelle").val(response.title);
                        $("#fid").val(response.id);
                    }
                });
            });

            // update function ajax request
            $("#edit_folder_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);

                $("#editfolderbtn").html('<i class="fas fa-spinner fa-spin"></i>');
                document.getElementById("editfolderbtn").disabled = true;

                $.ajax({
                    url: "{{ route('updatefl') }}",
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            toastr.success(
                                "Dossier modifier avec succès !", // Message
                                "Succès !", // Titre
                                {
                                    closeButton: true, // Ajoute un bouton de fermeture
                                    progressBar: true, // Affiche une barre de progression
                                    //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                    timeOut: 3000, // Durée d'affichage (en millisecondes)
                                    extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                }
                            );


                            fetchAlldfolder();

                            $("#editFolderModal").modal('hide');
                            $("#edit_folder_form")[0].reset();
                            document.getElementById("editfolderbtn").disabled = false;
                            $("#editfolderbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        }

                        if (response.status == 201) {
                            toastr.error(
                                "Le titre du dossier existe déjà, deux dossiers avec le même titre n'est possible.", // Message
                                "Attention !", // Titre
                                {
                                    closeButton: true, // Ajoute un bouton de fermeture
                                    progressBar: true, // Affiche une barre de progression
                                    positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                    timeOut: 8000, // Durée d'affichage (en millisecondes)
                                    extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                }
                            );

                            $("#editfolderbtn").html(
                                '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            document.getElementById("editfolderbtn").disabled = false;
                        }

                        if (response.status == 205) {

                            toastr.error(
                                "Vous n'avez pas l'accreditation de Modifier ce dossier!", // Message
                                "Attention !", // Titre
                                {
                                    closeButton: true, // Ajoute un bouton de fermeture
                                    progressBar: true, // Affiche une barre de progression
                                    //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                    timeOut: 5000, // Durée d'affichage (en millisecondes)
                                    extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                }
                            );

                            $("#editfolderbtn").html(
                                '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            document.getElementById("editfolderbtn").disabled = false;
                        }

                    }
                });
            });

            // Delete service ajax request
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
                                url: "{{ route('deletefl') }}",
                                method: 'delete',
                                data: { id: id, _token: csrf },
                                success: function(response) {
                                    if (response.status == 200) {
                                        // Résoudre directement sans afficher "Suppression en cours..."
                                        resolve(response);
                                    } else if (response.status == 205) {
                                      
                                        toastr.error(
                                            "Vous n'avez pas l'accréditation de supprimer ce dossier.", // Message
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
                                        let errorMessage = response.message || "Erreur lors de la suppression du dossier.";
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
                        toastr.success("Dossier supprimé avec succès !", "Succès", {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 3000,
                            extendedTimeOut: 1000
                        });
                        fetchAlldfolder();
                    }
                });
            });


            fetchAlldfolder();

            function fetchAlldfolder() {
            $.ajax({
                url: "{{ route('fetchAllfl') }}",
                method: 'get',
                success: function(response) {
                    // Si la requête réussit, mettez à jour le contenu
                    $("#show_all_folder").html(response);
                },
                error: function(xhr, status, error) {
                    // Gestion des erreurs
                    let errorMessage = "Une erreur est survenue lors du chargement des dossiers.";
                    
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
