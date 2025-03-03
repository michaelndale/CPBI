@extends('layout/app')

@section('page-content')


    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-7" style="margin:auto">
                    <div class="card">
                        <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"
                            style="padding: 0.40rem 1rem;">
                            <h4 class="mb-sm-0"><i class="fa fa-university"></i> Les tâches du responsabilité :
                                {{ $responsabilite->titre }}</h4>
                            <div class="page-title-right">
                                <a href="{{ route('responsabilite.index',  $responsabilite->id ) }}" id="fetchDataLink"
                                    class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm">
                                   &nbsp; <i class="fas fa-arrow-left"></i> &nbsp;

                                </a>
                                <button type="button" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa fa-plus-circle"></i>
                                    Créer</button>
                            </div>
                        </div>
                        <div class="card-body pt-0 pb-3">
                            <div class="table-responsive" id="show_all">
                                <center>
                                    <br><br>
                                    @include('layout.partiels.load')
                                    <br></br>
                                </center>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('taches.new')

    <script>
        $(function() {
            // Passer l'ID de la fonction depuis Blade
            const respId = {{ isset($responsabilite->id) ? $responsabilite->id : 'null' }};

            if (!respId) {
                alert('Aucun ID de responsabilité spécifié.');
                return;
            }

            function fetchAllTaches(respId) {
                $.ajax({
                    url: "{{ route('tache.liste', ':id') }}".replace(':id', respId),
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            // Insérer l'HTML généré par la vue partielle dans le tableau
                            $('#show_all').html(response.html);

                        } else {
                            alert(response.message || 'Une erreur est survenue dans le serveur');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors du chargement des taches :', xhr
                            .responseText);
                        alert('Une erreur est survenue.');
                    }
                });
            }

            // Passer l'ID de la fonction depuis Blade

            fetchAllTaches(respId);



            // Sauvegarder les donnees
            $("#addform").submit(function(e) 
            {
                e.preventDefault();
                const fd = new FormData(this);

                $("#addsave").html('<i class="fas fa-spinner fa-spin"></i>');
                document.getElementById("addsave").disabled = true;

                $.ajax({
                    url: "{{ route('tache.store') }}",
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {


                            toastr.success(
                                "La tâche enregistré avec succès!", // Message
                                "Succès !", // Titre
                                {
                                    closeButton: true, // Ajoute un bouton de fermeture
                                    progressBar: true, // Affiche une barre de progression
                                    //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                    timeOut: 3000, // Durée d'affichage (en millisecondes)
                                    extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                }
                            );


                            $("#addform")[0].reset();
                            $("#addModal").modal('hide');
                            fetchAllTaches(respId);

                        } else if (response.status == 201) {


                            toastr.info(
                                "Attention: La tâche existe déjà!", // Message
                                "Info !", // Titre
                                {
                                    closeButton: true, // Ajoute un bouton de fermeture
                                    progressBar: true, // Affiche une barre de progression
                                    //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                    timeOut: 3000, // Durée d'affichage (en millisecondes)
                                    extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                }
                            );

                        } else if (response.status == 202) {
                            toastr.info(
                                "Attention: La tâche existe déjà!", // Message
                                "Info !", // Titre
                                {
                                    closeButton: true, // Ajoute un bouton de fermeture
                                    progressBar: true, // Affiche une barre de progression
                                    //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                    timeOut: 3000, // Durée d'affichage (en millisecondes)
                                    extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                }
                            );
                        }

                        document.getElementById("addsave").disabled = false;
                        $("#addsave").html(
                        '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                    },
                    error: function(xhr, status, error) {


                        toastr.error(
                            "Une erreur s'est produite. Veuillez réessayer plus tard.", // Message
                            "Erreur !", // Titre
                            {
                                closeButton: true, // Ajoute un bouton de fermeture
                                progressBar: true, // Affiche une barre de progression
                                //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                timeOut: 3000, // Durée d'affichage (en millisecondes)
                                extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                            }
                        );

                        document.getElementById("addsave").disabled = false;
                        $("#addsave").html(
                        '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                    }
                });
            });


            // pour supprimer

            $(document).on('click', '.deleteIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let titre = $(this).data('titre');
                let csrf = '{{ csrf_token() }}';

                Swal.fire({
                    icon: 'warning',
                    title: 'Supprimer la tâche ?',
                    html: "<p class='swal-text'>Cette action entraînera la suppression la tache  <b> :  '" +
                        titre +
                        "'</b>",
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
                                url: "{{ route('tache.delete') }}",
                                method: 'delete',
                                data: {
                                    id: id,
                                    _token: csrf
                                },
                                success: function(response) {
                                    if (response.status == 200) {
                                        toastr.info(
                                            "Suppression en cours...",
                                            "Suppression");
                                        // Attendre un court délai pour que l'utilisateur voie le message
                                        setTimeout(() => {
                                            resolve(
                                            response); // Résoudre la promesse avec la réponse de la requête AJAX
                                        },
                                        1500); // Temps en millisecondes avant de résoudre la promesse
                                    } else {
                                        let errorMessage = response
                                            .message ||
                                            "Erreur lors de la suppression de la tâche.";
                                        toastr.error(errorMessage,
                                        "Erreur");
                                        if (response.error) {
                                            toastr.error("Erreur: " +
                                                response.error, "Erreur"
                                                );
                                        }
                                        if (response.exception) {
                                            toastr.error("Exception: " +
                                                response.exception,
                                                "Erreur");
                                        }
                                        resolve(
                                        response); // Résoudre même en cas d'erreur pour débloquer la modal
                                    }
                                },
                                error: function(xhr, status, error) {
                                    let errorMsg = xhr.responseJSON ? xhr
                                        .responseJSON.message :
                                        "Erreur de réseau. Veuillez réessayer.";
                                    toastr.error(errorMsg, "Erreur");
                                    if (xhr.responseJSON && xhr.responseJSON
                                        .exception) {
                                        toastr.error("Exception: " + xhr
                                            .responseJSON.exception,
                                            "Erreur");
                                    }
                                    resolve({
                                        status: 500,
                                        message: errorMsg,
                                        error: error,
                                        exception: xhr
                                            .responseJSON ? xhr
                                            .responseJSON
                                            .exception :
                                            "Aucune exception détaillée disponible"
                                    }); // Résoudre en cas d'erreur réseau pour débloquer la modal
                                }
                            });
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed && result.value && result.value.status == 200) {
                        toastr.success("La tâche supprimé avec succès !", "Suppression");
                        fetchAllTaches(respId);
                       
                    }
                });
            });

        });
    </script>
@endsection
