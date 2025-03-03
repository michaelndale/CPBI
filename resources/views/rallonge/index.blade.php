@extends('layout/app')
@section('page-content')
    <style>
        .hidden-link {
            display: none;
        }

        .difference {
            background-color: #ffcccc;
        }

        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 1;
            background-color: white;
        }

        .scrollable-content {
            overflow-y: auto;
            max-height: 600px;
        }
    </style>
    <div class="main-content">
        <div class="page-content">

            <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style="margin:auto">
                <!-- Card Header avec position sticky -->
                <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"
                    style="padding: 0.5rem 1rem; position: sticky; top: 0; z-index: 10;">

                    <h4 class="mb-sm-0"><i class="fa fa-list"></i> Budgétisation </h4>
                    <div class="page-title-right">
                        <a href="#" id="telecharger-pdf"
                            class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" title="Télécharger le Rapport budgétaire"><i class="fa fa-download"></i> Télécharger Rapport budgétaire</a> &nbsp; &nbsp;

                            <a href="javascript:void(0);" id="fetchDataLink" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm">
                              <span class="fa fa-sync-alt"></span>
                          </a>
                        @if ($projetdatat->autorisation == 1)
                            <a href="javascript::;" data-bs-toggle="modal" data-bs-target="#addDealModal"
                                class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm">
                                <span class="fa fa-plus-circle"></span> Créer
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Contenu principal (qui sera défilable) -->
                <div class="card-body p-0" id="table-container" style="max-height: 600px; overflow-y: auto;">
                    <div class="card">
                        <div class="float-end d-none d-md-inline-block" style="background-color: white;">
                            <div id="show_all_rallonge">
                                <br><br><br><br>
                                <center>
                                    @include('layout.partiels.load')
                                </center>
                                <br><br><br><br>
                            </div>
                        </div>
                    </div>
                </div>
                @include('rallonge.modale')
                @include('rallonge.historique')
            </div>

           <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
            <!--<script>
                function adjustTableHeight() {
                    var windowHeight = window.innerHeight;
                    var tableContainer = document.getElementById('table-container');
                    tableContainer.style.height = (windowHeight - 200) + 'px';
                }

                window.onload = adjustTableHeight;
                window.onresize = adjustTableHeight;
            </script>

            <script>
                function toggleUrldocInput(checkbox) {
                    var urldocInput = document.getElementById("urldoc");
                    urldocInput.style.display = checkbox.checked ? "block" : "none";
                }

                window.onload = function() {
                    var retructionCheckbox = document.getElementById("retruction");
                    toggleUrldocInput(retructionCheckbox);
                };

                document.querySelectorAll('.hoverable-tr').forEach(tr => {
                    tr.addEventListener('mouseover', () => {
                        tr.querySelector('.edit-link').classList.remove('hidden-link');
                    });
                    tr.addEventListener('mouseleave', () => {
                        tr.querySelector('.edit-link').classList.add('hidden-link');
                    });
                });
            </script> -->

            <script>
                $(document).ready(function() {
                    $('#dtHorizontalVerticalExample').DataTable({
                        "scrollX": true,
                        "scrollY": 200,
                    });
                    $('.dataTables_length').addClass('bs-select');
                });

                $(document).on('change', '.compteid', function() {
                    var cat_id = $(this).val();
                    var op = "";

                    $.ajax({
                        type: 'get',
                        url: "{{ route('findSousCompte') }}",
                        data: {
                            'id': cat_id
                        },
                        success: function(data) {
                            if (data.length == 0) {
                                op += '<option value="0" selected disabled>-- Ligne compte --</option>';
                                op += '<option value="0" selected disabled>Aucun</option>';
                                toastr.error("Attention !! La ligne n'a pas de sous-ligne", "Information");
                            } else {
                                data.forEach(item => {
                                    op +=
                                        `<option value="${item.id}">${item.numero}.${item.libelle}</option>`;
                                });
                            }
                            $("#scomptef").html(op);
                        },
                        error: function() {
                            toastr.error("Erreur de connexion à la base de données, vérifiez votre connexion",
                                "Attention");
                        }
                    });
                });

                $("#addFOrm").submit(function(e) {
                    e.preventDefault();
                    const fd = new FormData(this);
                    const saveButton = $("#savebtn");

                    saveButton.html('<i class="fas fa-spinner fa-spin"></i>').prop("disabled", true);

                    $.ajax({
                        url: "{{ route('storerallonge') }}",
                        method: 'POST',
                        data: fd,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            switch (response.status) {
                                case 200:
                                    toastr.success("Budget enregistré avec succès !", "Enregistrement");
                                    fetchAllrallonge();
                                    $("#addFOrm")[0].reset();
                                    $("#addDealModal").modal('hide');
                                    break;
                                case 201:
                                    toastr.error("Le montant est supérieur au montant global du budget !",
                                        "Attention");
                                    break;
                                case 202:
                                    toastr.error("Erreur d'exécution !", "Erreur");
                                    break;
                                case 203:
                                    toastr.error(
                                        "Une ligne de compte ne peut recevoir le montant plusieurs fois !",
                                        "Erreur");
                                    break;
                                default:
                                    toastr.error("Erreur inconnue !", "Erreur");
                            }
                            saveButton.html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder').prop(
                                "disabled", false);
                            $("#addDealModal").modal('show');
                        },
                        error: function() {
                            toastr.error("Erreur de communication avec le serveur !", "Erreur");
                            saveButton.html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder').prop(
                                "disabled", false);
                        }
                    });
                });
                

                $(document).on('click', '.showrevision', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');

                    $.ajax({
                        url: "{{ route('showrallonge') }}",
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.length > 0) {
                                let data = response[0];
                                $("#r_libelle").val(data.libelle);
                                $("#r_code").val(data.numero);
                                $("#r_budgetactuel").val(data.budgetactuel);
                                $("#ancienmontantligne").val(data.budgetactuel);
                                $("#r_souscompte").val(data.souscompte);
                                $("#r_idligne").val(data.idr);
                                $("#r_idr").val(data.idr);
                            } else {
                                toastr.error('Aucune donnée trouvée pour cet ID.');
                            }
                        },
                        error: function(xhr) {
                            toastr.error('Erreur lors de la récupération des données.');
                            console.error('Erreur:', xhr);
                        },
                        statusCode: {
                            404: function() {
                                toastr.error('Ressource non trouvée (404).');
                            },
                            500: function() {
                                toastr.error('Erreur interne du serveur (500).');
                            }
                        }
                    });
                });


                $(document).on('click', '.showeHistorique', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');

                    $.ajax({
                        url: "{{ route('historiqueliste') }}",
                        method: 'get',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            toastr.success('Chargement des donnees encours...');

                        },
                        error: function(xhr) {
                            toastr.error('Erreur lors de la récupération des données.');
                            console.error('Erreur:', xhr);
                        },
                        statusCode: {
                            404: function() {
                                toastr.error('Ressource non trouvée (404).');
                            },
                            500: function() {
                                toastr.error('Erreur interne du serveur (500).');
                            }
                        }
                    });
                });

                $("#editrevisionform").submit(function(e) {
                    e.preventDefault();
                    const fd = new FormData(this);

                    $("#revisionbtn").html('<i class="fas fa-spinner fa-spin"></i>').prop("disabled", true);

                    $.ajax({
                        url: "{{ route('updaterallonge') }}",
                        method: 'post',
                        data: fd,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 200) {
                                fetchAllrallonge();
                                toastr.success("Très bien! Le budget a été bien modifié.", "Modification");
                                $("#revisionbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                                $("#editrevisionform")[0].reset();
                                $("#revisionModal").modal('hide');
                                $("#revisionbtn").prop("disabled", false);
                            } else {
                                let errorMessage = "Échec ! Le budget n'a pas été modifié.";
                                if (response.status == 205) errorMessage =
                                    "Attention ! Vous ne devez pas dépasser le montant du budget global.";
                                toastr.error(errorMessage, "Erreur");
                                $("#revisionbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder')
                                    .prop("disabled", false);
                                $("#revisionModal").modal('show');
                            }
                        }
                    });
                });

                $(document).on('click', '.deleterevision', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    let csrf = '{{ csrf_token() }}';

                    Swal.fire({
                        title: 'Êtes-vous sûr ?',
                        text: "Une ligne budgétaire est sur le point d'être DÉTRUITE ! Faut-il vraiment exécuter « la Suppression » ? ",
                        showCancelButton: true,
                        confirmButtonColor: 'green',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, Supprimer !'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('deleteligne') }}",
                                method: 'delete',
                                data: {
                                    id: id,
                                    _token: csrf
                                },
                                success: function(response) {
                                    if (response.status == 200) {
                                        fetchAllrallonge();
                                        toastr.success("Ligne budgétaire supprimée avec succès.",
                                            "Succès");
                                    } else {
                                        toastr.error(response.status == 201 ?
                                            "Vous n'avez pas l'autorisation de supprimer cette ligne budgétaire." :
                                            "Une erreur est survenue lors de la suppression de la ligne budgétaire.",
                                            "Erreur");
                                    }
                                },
                                error: function(xhr) {
                                    toastr.error(
                                        "Une erreur est survenue lors de la suppression de la ligne budgétaire.",
                                        "Erreur");
                                    console.error(xhr.responseText);
                                }
                            });
                        }
                    });
                });

                                // Fonction pour récupérer et afficher toutes les données
                function fetchAllrallonge() {
                    $.ajax({
                        url: "{{ route('fetchRallonge') }}", // Route Laravel pour récupérer les données
                        method: 'get',
                        success: function(response) {
                            $("#show_all_rallonge").html(response); // Insérer la réponse dans le conteneur
                        },
                        error: function(xhr, status, error) {
                          toastr.error("Erreur lors du chargement des données :", error);
                        }
                    });
                }

                // Appel initial pour charger les données au chargement de la page
                $(document).ready(function() {
                    fetchAllrallonge(); // Charger les données dès le début

                    // Écouteur de clic sur le bouton pour rafraîchir les données
                    $("#fetchDataLink").on("click", function() {
                      

                        toastr.success(
                          "Chargement des données encours", // Message
                          "Succès !", // Titre
                          {
                              closeButton: true, // Ajoute un bouton de fermeture
                              progressBar: true, // Affiche une barre de progression
                              //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                              timeOut: 3000, // Durée d'affichage (en millisecondes)
                              extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                          }
                      );
                        fetchAllrallonge(); // Appeler la fonction pour rafraîchir les données
                    });
                });
                fetchAllrallonge();
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('telecharger-pdf').addEventListener('click', function(event) {
                        event.preventDefault(); // Empêche le comportement par défaut du lien

                        // Effectue une requête pour télécharger le PDF
                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', '/telecharger-rapport-budget', true);
                        xhr.responseType = 'blob'; // Type de réponse attendue

                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                // Création d'un objet URL pour le blob
                                var url = window.URL.createObjectURL(xhr.response);

                                // Création d'un lien temporaire et déclenchement du téléchargement
                                var a = document.createElement('a');
                                a.href = url;
                                a.download = 'rapport_projet.pdf'; // Nom du fichier à télécharger
                                document.body.appendChild(a);
                                a.click();
                                document.body.removeChild(a);

                                toastr.success(
                                  "Téléchargement du rapport  encours terminer", // Message
                                  "Succès !", // Titre
                                  {
                                      closeButton: true, // Ajoute un bouton de fermeture
                                      progressBar: true, // Affiche une barre de progression
                                      positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                      timeOut: 3000, // Durée d'affichage (en millisecondes)
                                      extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                  }
                              );
                            }
                        };

                        xhr.send();
                    });
                });
            </script>
        @endsection
