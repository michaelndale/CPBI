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

      <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">                 
        <h4 class="mb-sm-0"><i class="fa fa-list"></i> Petite caisse > Liste  d'Expression des Besoins "FEB" pour la petite caisse</h4>
            <div class="page-title-right">
              <a href="#" id="fetchDataLink" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"> <i class="fas fa-sync-alt"></i> Actualiser</a>
            <a href="javascript::;" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" data-bs-toggle="modal" data-bs-target="#addfebModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fa fa-plus-circle"></span> Nouvel fiche FEB</a>

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
          <div class="table-responsive" id="table-container" style="overflow-y: auto;">
            <table class="table table-bordered table-striped table-sm fs--1 mb-0">
              <thead style="position: sticky; top: 0; background-color: white; z-index: 1;">
                <tr>
                  <th class="sort border-top ">
                    <center> <b> Actions </b></center>
                  </th>
                  <th class="sort border-top" data-sort="febnum">
                    <center><b>N<sup>o</sup> FEB </b></center>
                  </th>
                  <th class="sort border-top" data-sort="febnum">
                   <b>Description de la demande </b>
                  </th>
                  <th class="sort border-top" data-sort="om"> <b>
                      <center>Montant total </center>
                    </b></th>

                  <th class="sort border-top" data-sort="om"> <b>
                      <center>Compte </center>
                    </b></th>

                  <th class="sort border-top ps-3" data-sort="facture">
                    <center><b>Date FEB </b></center>
                  </th>

                  <th class="sort border-top" data-sort="date">
                    <center><b>Date limite</b></center>
                  </th>
                  <th class="sort border-top" data-sort="date">
                    <center><b>Créé le</b></center>
                  </th>
                  <th class="sort border-top" data-sort="date">
                    <center><b>Mises à jour le</b></center>
                  </th>
                  <th class="sort border-top" data-sort="date"><b>Créé par</b></th>


                </tr>
              </thead>


              <tbody class="show_all" id="show_all">
                <tr>
                  <td colspan="16">
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




@include('bonpetitecaisse.feb.modale')

<BR><BR>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

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
    $(document).ready(function () {
            // Fonction pour vérifier le numéro FEB
            function verifierNumeroFEB(numerofeb) {
                // Vérifier si le champ est vide
                if (numerofeb.trim() === '') {
                    $('#numerofeb_error').text('Renseigner le champ numéro F.A.C');
                    $('#numerofeb').removeClass('has-success has-error'); // Supprime toutes les classes
                    $('#numerofeb_info').text('');
                    document.getElementById("addfebbtn").disabled = true; // Désactive le bouton
                    return; // Ne pas envoyer la requête
                }

                // Envoi de la requête AJAX
                $.ajax({
                    url: '{{ route('check.febpc') }}', // Votre route Laravel
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token pour Laravel
                        numerofeb: numerofeb
                    },
                    success: function (response) {
                        if (response.exists) {
                            $("#numerofeb_error").html(
                                '<i class="fa fa-times-circle"></i> Numéro FAC existe déjà'
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

        document.getElementById('datelimite').addEventListener('change', function() {
                const dateFeb = new Date(document.getElementById('datefeb').value);
                const dateLimite = new Date(this.value);

                if (dateFeb && dateLimite && dateLimite < dateFeb) {
                    toastr.error("La Date limite doit être supérieure ou égale à la Date du dossier FAC.");
                    this.value = ''; // Réinitialise la date limite pour forcer une nouvelle sélection valide
                }
            });

</script>


<script type="text/javascript">
  

  

  $("#addfebForm").submit(function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    $("#addfebbtn").html('<i class="fas fa-spinner fa-spin"></i>');
    document.getElementById("addfebbtn").disabled = true;
    $("#loadingModal").modal('show'); // Affiche le popup de chargement

    $.ajax({
      url: "{{ route('storefebpc') }}",
      method: 'post',
      data: fd,
      cache: false,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function(response) {
        if (response.status == 200) {
          fetchAll();

          $("#addfebbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
          $("#numerofeb_error").text("");
          $('#numerofeb').removeClass('has-error has-success'); // Supprime les classes de validation
          $("#numerofeb_info").text(''); // Réinitialise le texte d'info
          $("#addfebForm")[0].reset();
          $("#addfebModal").modal('hide');
          document.getElementById("addfebbtn").disabled = false;
         

          toastr.success(
                          "FAC ajouté avec succès", // Message
                          "Succès !", // Titre
                          {
                              closeButton: true, // Ajoute un bouton de fermeture
                              progressBar: true, // Affiche une barre de progression
                              //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                              timeOut: 3000, // Durée d'affichage (en millisecondes)
                              extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                          }
                      );



        } else if (response.status == 201) {
        
          toastr.error(
                          "Attention: FEB numéro existe déjà", // Message
                          "Info !", // Titre
                          {
                              closeButton: true, // Ajoute un bouton de fermeture
                              progressBar: true, // Affiche une barre de progression
                              //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                              timeOut: 3000, // Durée d'affichage (en millisecondes)
                              extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                          }
                      );


          $("#addfebModal").modal('show');
          $("#numerofeb_error").text("Numéro existe");
          $('#numerofeb').addClass('has-error');
          document.getElementById("addfebbtn").disabled = false;
          $("#addfebbtn").html('<i class="fa fa-cloud-upload-alt"></i>  Sauvegarder');
        } else if (response.status == 202) {
          toastr.error("Erreur d'exécution: " + response.error, "Erreur");
          $("#addfebModal").modal('show');
          document.getElementById("addfebbtn").disabled = false;
          $("#addfebbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
        } else if (response.status == 203) {
          if (confirm(response.message)) {
            $('<input>').attr({
              type: 'hidden',
              name: 'confirm_ligne',
              value: '1'
            }).appendTo('#addfebForm');
            $('#addfebForm').submit();
          } else {
            toastr.info("Vous avez annulé l'opération.", "Info");
            $("#addfebModal").modal('show');
            document.getElementById("addfebbtn").disabled = false;
            $("#addfebbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
          }
        } else if (response.status == 204) {
          toastr.error(response.message, "Attention");
          $("#addfebModal").modal('show');
          document.getElementById("addfebbtn").disabled = false;
          $("#addfebbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
        }

        $("#addfebbtn").text('Sauvegarder');
        $("#loadingModal").modal('hide');
        setTimeout(function() {
          $("#loadingModal").modal('hide');
        }, 600); // 600 millisecondes = 0.6 secondes
      },
      error: function(xhr, status, error) {
        console.error(error);
        toastr.error("Erreur de communication avec le serveur.", "Erreur");
        document.getElementById("addfebbtn").disabled = false;
        $("#addfebbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
        $("#loadingModal").modal('hide');
      }
    });
  });


  $(document).on('click', '.deleteIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let numero = $(this).data('numero');
      let csrf = '{{ csrf_token() }}';

      Swal.fire({
        title: 'Supprimer le FEB ?',
        html: "<p class='swal-text'>Cette action entraînera la suppression du  <b> FEB Petite Caisse Numéro: " + numero + "</b>  </p><p class='swal-text'><i class='fa fa-info-circle' style='color: red;'></i> Cette action entraînera également la suppression de les élements du FEB dans le DAP, DJA associés aux FEB.</p>",
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
              url: "{{ route('deletefebpc') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                if (response.status == 200) {
                  toastr.info("Suppression en cours...", "Suppression");
                  // Attendre un court délai pour que l'utilisateur voie le message
                  setTimeout(() => {
                    resolve(response); // Résoudre la promesse avec la réponse de la requête AJAX
                  }, 1500); // Temps en millisecondes avant de résoudre la promesse
                } else {
                  let errorMessage = response.message || "Erreur lors de la suppression du FEB.";
                  toastr.error(errorMessage, "Erreur");
                  if (response.error) {
                    toastr.error("Erreur: " + response.error, "Erreur");
                  }
                  if (response.exception) {
                    toastr.error("Exception: " + response.exception, "Erreur");
                  }
                  resolve(response); // Résoudre même en cas d'erreur pour débloquer la modal
                }
              },
              error: function(xhr, status, error) {
                let errorMsg = xhr.responseJSON ? xhr.responseJSON.message : "Erreur de réseau. Veuillez réessayer.";
                toastr.error(errorMsg, "Erreur");
                if (xhr.responseJSON && xhr.responseJSON.exception) {
                  toastr.error("Exception: " + xhr.responseJSON.exception, "Erreur");
                }
                resolve({
                  status: 500,
                  message: errorMsg,
                  error: error,
                  exception: xhr.responseJSON ? xhr.responseJSON.exception : "Aucune exception détaillée disponible"
                }); // Résoudre en cas d'erreur réseau pour débloquer la modal
              }
            });
          });
        }
      }).then((result) => {
        if (result.isConfirmed && result.value && result.value.status == 200) {
          toastr.success("FEB supprimé avec succès !", "Suppression");
          fetchAll();
        }
      });
    });

  fetchAll();


  function fetchAll() {
    $.ajax({
      url: "{{ route('liste_febpc') }}",
      method: 'get',
      success: function(reponse) {
        $("#show_all").html(reponse);
      }
    });
  }
</script>


<style>
  .swal-custom-content .swal-text {
    font-size: 14px;
    /* Ajustez la taille selon vos besoins */
  }
</style>

@endsection