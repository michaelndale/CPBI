@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      
      <!-- end page title -->

      <div class="row" >
        
        <div class="col-xl-12" >
          <div class="card">

            @php
            $IDPJ= Session::get('id');
            $cryptedId = Crypt::encrypt($IDPJ);
            @endphp
           
            <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"
            style="psaveBailleurBtning: 0.20rem 1rem;">

            <h4 class="mb-sm-0"><i class="fa fa-users"></i> Les Bailleurs des Fonds </h4>
            </h4>

            <div class="page-title-right d-flex align-items-center justify-content-between gap-2" style="margin: 0;">
               
                <!-- Bouton Créer -->
               
                <a href="javascript:void(0)" id="fetchDataLink" class="btn btn-outline-primary rounded-pill btn-sm"
                    title="Actualiser">
                    <i class="fas fa-sync-alt"></i>
                </a>

                <a href="#" class="btn btn-outline-primary rounded-pill btn-sm" data-bs-toggle="modal" data-bs-target="#createBailleurModal">
                    <span class="fa fa-plus-circle"></span> Créer
                </a>
                


            </div>
        </div>



            <div class="card-body">
              <div class="col-12 col-xl-12 col-xxl-12 pe-xl-0">
                <div class="mb-12 mb-xl-12">
                  <div class="row gx-0 gx-sm-12">
                    <div class="col-12">
                      <p>Les membres intervenants du projet ont apporté leur expertise et leur contribution à sa réalisation</p>

          
                     
                        <div class="col-sm-6 col-md-12">
                            <input id="project_id" class="form-control" name="project_id" type="hidden" value="{{ Session::get('id') }} " readonly />
          
                            <input type="text" class="form-control" value="{{ Session::get('numeroprojet') }} : {{ Session::get('title') }} " disabled="disabled" />
                        </div>
          
                        <br>
          
                        <div class="col-sm-8 col-md-12">
                          <div class="form-floating">

                            <div id="loading-message" style="display: none; text-align: center; margin: 20px;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Chargement...</span>
                                </div>
                            </div>

                            <table id="bailleursTable" class="table table-bordered table-striped table-sm fs--1 mb-0">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>Nom</th>
                                        <th>Pays Origine</th>
                                       
                                        <th>Nom du Contact</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Site Web</th>
                                        <th>Créé le</th>
                                        <th>code</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Les données seront injectées ici via AJAX -->
                                </tbody>
                            </table>
                            
          
                         
                          </div>
                        </div>
          
                        <br><br>
                      
                    </div>
                  </div>
                </div>
              </div>

              
            </div>
          </div>
         
        </div>
        </div>
      </div>
    </div> <!-- container-fluid -->
  </div>
  <!-- End Page-content -->

  <!--  Extra Large modal example -->

</div>

<!-- Modal pour créer un nouveau bailleur de fonds -->
<!-- Modal pour créer un nouveau bailleur de fonds -->
<!-- Modal pour créer un nouveau bailleur de fonds -->
<!-- Modal pour créer un nouveau bailleur de fonds -->
<div class="modal fade" id="createBailleurModal" tabindex="-1" aria-labelledby="createBailleurModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBailleurModalLabel">Créer un nouveau bailleur de fonds</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createBailleurForm" method="POST">
            <div class="modal-body">
                <!-- Formulaire de création de bailleur de fonds -->
              

                    @method('post')
                    @csrf
                    <!-- Nom du bailleur -->
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom organisation</label>
                        <input type="text" class="form-control form-control-sm" id="nom" name="nom" required placeholder="Entrez le nom de l'organisation">
                    </div>

                    <!-- Pays d'origine -->
                    <div class="mb-3">
                        <label for="pays_origine" class="form-label">Pays d'origine</label>
                        <select type="text" class="form-control form-control-sm" id="pays_origine" name="pays_origine" required >
                            <option value="">Selectionner</option>
                            @forelse ($pays as $payss)
                                <option value="{{ $payss->name }}"> {{ $payss->name}} </option>
                            @empty
                            <option value=""> Pas d'elements disponible </option>
                            @endforelse
                        </select>
                    </div>

                    

                    <!-- Nom du contact -->
                    <div class="mb-3">
                        <label for="contact_nom" class="form-label">Nom du contact</label>
                        <input type="text" class="form-control form-control-sm" id="contact_nom" name="contact_nom" required placeholder="Nom du contact">
                    </div>

                    <!-- Email et Téléphone en parallèle -->
                    <div class="row">
                        <!-- Email du contact -->
                        <div class="col-6 mb-3">
                            <label for="contact_email" class="form-label">Email </label>
                            <input type="email" class="form-control form-control-sm" id="contact_email" name="contact_email" required placeholder="Entrez l'email ">
                        </div>

                        <!-- Téléphone du contact -->
                        <div class="col-6 mb-3">
                            <label for="contact_telephone" class="form-label">Téléphone </label>
                            <input type="tel" class="form-control form-control-sm" id="contact_telephone" name="contact_telephone" required placeholder="Entrez le numéro de téléphone">
                        </div>
                    </div>

                    <!-- Site web -->
                    <div class="mb-3">
                        <label for="site_web" class="form-label">Site web</label>
                        <input type="url" class="form-control form-control-sm" id="site_web" name="site_web" placeholder="Entrez l'URL du site web (optionnel)">
                    </div>
                
            </div>

            <!-- Footer avec les boutons -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
              
                <button type="submit" name="saveBailleurBtn" id="saveBailleurBtn" class="btn btn-primary waves-effect waves-light">
                    <i class="fa fa-cloud-upload-alt"></i> Sauvegarder
                </button>
                
            </div>
        </form>
        </div>
    </div>
</div>

<div class="modal fade" id="creeAccessModal" tabindex="-1" aria-labelledby="creeAccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="creeAccessForm"  method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="creeAccessModalLabel">Créer un Compte d'Accès</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Champ caché pour l'ID du bailleur -->
                    <input type="hidden" id="bailleur_id" name="bailleur_id">

                    <!-- Champ caché pour l'ID du bailleur -->
                    <input type="hidden" id="projet_id" name="projet_id" value="{{ $IDPJ }}">

                    <div class="mb-3">
                        <label for="verification_code" class="form-label">Code de Vérification</label>
                        <input type="text"  class="form-control" id="verification_code" name="verification_code"  readonly required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" id="creeAccessBtn" name="creeAccessBtn" class="btn btn-primary">  <i class="fa fa-cloud-upload-alt"></i>  Sauvegarder </button>
                </div>
            </form>
        </div>
    </div>
</div>








<style>
  .swal-custom-content .swal-text {
    font-size: 14px;
    /* Ajustez la taille selon vos besoins */
  }

  th {
        font-weight: bold;
    }
</style>

<script>

    $("#createBailleurForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);

        $("#saveBailleurBtn").html('<i class="fas fa-spinner fa-spin"></i>');
        document.getElementById("saveBailleurBtn").disabled = true;

        $.ajax({
            url: "{{ route('bailleurs.store') }}",
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 200) {
                  

                    toastr.success(
                          "Bailleur enregistré avec succès!", // Message
                          "Succès !", // Titre
                          {
                              closeButton: true, // Ajoute un bouton de fermeture
                              progressBar: true, // Affiche une barre de progression
                              //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                              timeOut: 3000, // Durée d'affichage (en millisecondes)
                              extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                          }
                      );

                    loadBailleurs();
                    $("#createBailleurForm")[0].reset();
                    $("#createBailleurModal").modal('hide');

                } else if (response.status == 201) {
                  

                    toastr.info(
                          "Attention: Le Bailleur existe déjà!", // Message
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
                          "Attention: Le Bailleur existe déjà!", // Message
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

                document.getElementById("saveBailleurBtn").disabled = false;
                $("#saveBailleurBtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
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

                document.getElementById("saveBailleurBtn").disabled = false;
                $("#saveBailleurBtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            }
        });
    });

    $("#creeAccessForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);

        $("#creeAccessBtn").html('<i class="fas fa-spinner fa-spin"></i>');
        document.getElementById("creeAccessBtn").disabled = true;

        $.ajax({
            url: "{{ route('acces.bailleurs.store') }}",
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 200) {
                   

                    toastr.success(
                          "Compte d\'accès créé avec succès!", // Message
                          "Succès !", // Titre
                          {
                              closeButton: true, // Ajoute un bouton de fermeture
                              progressBar: true, // Affiche une barre de progression
                              //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                              timeOut: 3000, // Durée d'affichage (en millisecondes)
                              extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                          }
                      );

                    loadBailleurs();
                    $("#creeAccessForm")[0].reset();
                    $("#creeAccessModal").modal('hide');

                } else if (response.status == 201) {
                    

                    toastr.error(
                          "Ce bailleur possède déjà un compte vérifié.", // Message
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
                    toastr.error("Le Bailleur existe déjà!", "Erreur");
                }

                document.getElementById("creeAccessBtn").disabled = false;
                $("#creeAccessBtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            },
            error: function(xhr, status, error) {
                toastr.error("Le compte d\'accès n\'a pas pu être sauvegardé. Veuillez réessayer..", "Erreur");
                document.getElementById("creeAccessBtn").disabled = false;
                $("#creeAccessBtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            }
        });
    });


    loadBailleurs();

    // Fonction pour générer un code de vérification de 6 chiffres
    function generateVerificationCode() {
        return Math.floor(100000 + Math.random() * 900000); // Génère un nombre entre 100000 et 999999
    }

    function loadBailleurs() {
    $.ajax({
        url: "{{ route('liste.bailleursDeFonds') }}", // Route pour récupérer la liste des bailleurs
        type: 'GET',
        success: function (response) {
            // Vider le tableau avant d'ajouter les données
            $('#bailleursTable tbody').empty();

            // Boucle pour chaque bailleur
            $.each(response.bailleurs, function (index, bailleur) {
                // Formater la date au format d-m-y
                let formattedDate = new Date(bailleur.created_at).toLocaleDateString('fr-FR', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });

                // Vérifier si le bailleur a un compte d'accès vérifié
                let isVerified = bailleur.is_verified ? "checked" : "";

                // Ajouter une ligne au tableau avec une case à cocher
                $('#bailleursTable tbody').append(`
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input bailleur-checkbox" 
                                   value="${bailleur.id}" ${isVerified}>
                        </td>
                        <td>${bailleur.nom}</td>
                        <td>${bailleur.pays_origine}</td>
                        <td>${bailleur.contact_nom}</td>
                        <td>${bailleur.contact_email}</td>
                        <td>${bailleur.contact_telephone}</td>
                        <td>${bailleur.site_web}</td>
                        <td>${formattedDate}</td>
                        <td>${bailleur.verification_code || 'N/A'}</td>
                        <td>
                            <div class="btn-group me-2 mb-2 mb-sm-0">
                                <a data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical ms-2"></i>
                                </a>
                                <div class="dropdown-menu">
                                <a class="dropdown-item text-default mx-1 creeAccess" 
                                    id="${bailleur.id}" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#creeAccessModal" 
                                    title="Compte d'accès">
                                        <i class="fa fa-user-edit"></i> Compte d'accès
                                </a>
                                    <a class="dropdown-item text-default mx-1 editIcon" 
                                    id="${bailleur.id}" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal" 
                                    title="Modifier">
                                        <i class="far fa-edit"></i> Modifier
                                    </a>
                                    <a class="dropdown-item text-danger mx-1 deleteIcon" 
                                    id="${bailleur.id}" 
                                    href="#">
                                        <i class="far fa-trash-alt"></i> Supprimer
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                `);
            });

            // Gestionnaire d'événements pour récupérer l'ID du bailleur
            $('.creeAccess').on('click', function () {
                var bailleurId = $(this).attr('id'); // Récupérer l'ID du bailleur

                $('#bailleur_id').val(bailleurId); // Placer l'ID dans le champ caché du formulaire
                

                // Générer un code de vérification à 6 chiffres et le placer dans le champ
                var verificationCode = generateVerificationCode();
                $('#verification_code').val(verificationCode); // Placer le code généré dans le champ
            });
        },
        error: function (xhr) {
            console.error("Erreur lors du chargement des bailleurs :", xhr.responseText);
        }
    });
}


</script>

@endsection
