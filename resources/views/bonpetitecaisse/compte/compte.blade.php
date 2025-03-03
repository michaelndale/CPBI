@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">

      <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">                 
        <h4 class="mb-sm-0"><i class="fa fa-list"></i> Compte petite caisse</h4>
            <div class="page-title-right">
              <a href="#" id="fetchDataLink" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"> <i class="fas fa-sync-alt"></i> Actualiser</a>
              <a href="javascript::;" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" chauffeur="button" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Ajouter Compte petite caisse </a>
        </div>
    </div>




      <div class="card-body p-0">
        <div id="tableExample2">
          <div class="table-responsive" id="table-container" style="overflow-y: auto;">
            <table class="table table-bordered table-striped table-sm fs--1 mb-0">
              <thead style="position: sticky; top: 0; background-color: white; z-index: 1;">
                <tr style="background-color:#82E0AA">
                  <th> <center>Actions</center> </th>
                  <th style="width:5%">Code</th>
                  <th style="width:30%">Libellé du compte</th>
                  <th><center>Solde</center></th>
                  <th>Créé par</th>
                  <th>Créé le</th>
                  <th>Mises à jour le</th>
                  
                </tr>
              </thead>
              <tbody id="show_all_compte">
                <tr>
                  <td colspan="7">
                    <h5 class="text-center text-secondery my-5">
                      @include('layout.partiels.load')
                  </td>
                </tr>
              </tbody>
            </table>
            <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- container-fluid -->
</div>


{{-- new compte modal --}}


<div class="modal fade" id="modifierLigneModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modifierLigneModal" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="editcodeform"> <!-- Utilisation de id="modifierLigneForm" au lieu de id="modifierLigneModal" pour le formulaire -->
        @method('post')
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Modification Compte petite caisse</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">

            <div class="col-sm-6 col-lg-12 col-xl-3">
              <label class="text-1000 fw-bold mb-4">Code :</label>
              <input type="text" name="c_code" id="c_code" class="form-control" required />
            </div>
            <div class="col-sm-12 col-lg-12 col-xl-8">
              <label class="text-1000 fw-bold mb-4"> Libellé du compte :</label>
              <input type="hidden" name="c_id" id="c_id" class="form-control" />
              <input type="text" name="c_description" id="c_description" class="form-control" required />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="editcomptebtn" id="editcomptebtn" class="btn btn-primary" type="button"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addDealModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDealModal" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="addcompteform">
        @method('post')
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouvelle Compte petite caisse </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="row g-3">
            <div class="col-sm-6 col-lg-12 col-xl-12">
              <label class="text-1000 fw-bold mb-2"> Composante/ Projet/Section </label>
              <input value="{{ Session::get('id') }} " type="hidden" name="projetid" id="projetid">
              <input value="{{ Session::get('title') }} " class="form-control form-control-sm" style="background-color:#c0c0c0" disabled>
            </div>

            <div class="col-sm-6 col-lg-12 col-xl-3">
              <label class="text-1000 fw-bold mb-2">Code :</label>
              <input type="text" name="code" id="code" class="form-control" required/>
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-9">
              <label class="text-1000 fw-bold mb-2">Libellé du compte :</label>
              <input type="text" name="libelle" id="libelle" class="form-control" required />
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="sendCompte" id="sendCompte" class="btn btn-primary" type="button"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- new sous compte modal --}}


{{-- new sous compte modal --}}


<!-- Modal -->
<div class="modal fade bs-historique-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myExtraLargeModalLabel">MOUVEMENT ENCOURS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <!-- Le contenu dynamique sera injecté ici -->
      </div>
    </div>
  </div>
</div>

</div>

</div>
</div>

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
    // Add Compte ajax 
    $("#addcompteform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#sendCompte").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("sendCompte").disabled = true;

      $.ajax({
        url: "{{ route('storecpc') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {

          if (response.status == 200) {
           

            toastr.success(
                          "Petite compte ajouté avec succès. !", // Message
                          "Succès !", // Titre
                          {
                              closeButton: true, // Ajoute un bouton de fermeture
                              progressBar: true, // Affiche une barre de progression
                              //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                              timeOut: 3000, // Durée d'affichage (en millisecondes)
                              extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                          }
                      );

            fetchAlldcompte();


            $("#sendCompte").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addcompteform")[0].reset();
            $("#addDealModal").modal('hide');
            document.getElementById("sendCompte").disabled = false;

          }

          if (response.status == 201) {
          
            toastr.error(
                          "Le compte avec le code et libellé dans ce projet existe déjà. !", // Message
                          "Info !", // Titre
                          {
                              closeButton: true, // Ajoute un bouton de fermeture
                              progressBar: true, // Affiche une barre de progression
                              //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                              timeOut: 3000, // Durée d'affichage (en millisecondes)
                              extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                          }
                      );



            $("#sendCompte").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addDealModal").modal('show');
            document.getElementById("sendCompte").disabled = false;


          }

          if (response.status == 202) {
            toastr.info("Erreur d'execution, Vérifier l’état de votre connexion", "Erreur");
            $("#sendCompte").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addDealModal").modal('show');
            document.getElementById("sendCompte").disabled = false;

          }

        }
      });
    });

    // Edit fonction ajax request
    $(document).on('click', '.editCaisse', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      
      $.ajax({
        url: "{{ route('editCompte') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#c_id").val(response.id);
          $("#c_code").val(response.code);
          $("#c_description").val(response.libelle);
        }
      });
    });

    // update function ajax request
    $("#editcodeform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
   
      $("#editcomptebtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("editcomptebtn").disabled = true;
      $.ajax({
        url: "{{ route('updateCompte') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Mises ajours reussi avec succees", "Compte modifie");
            fetchAlldcompte();
          }
         

          $("#editcomptebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#editcompteModal").modal('show');
            document.getElementById("editcomptebtn").disabled = false;


        }
      });
    });


    // Delete compte ajax request
    $(document).on('click', '.deleteIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Êtes-vous sûr ?',
        html:  "<p class='swal-text'> Vous ne pourrez plus revenir en arrière , <br>  <i class='fa fa-info-circle' style='color: red;'></i> A savoir  le compte peut etre supprimer si le solde est a zero  ! </p> ",

        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer !',
        customClass: {
          content: 'swal-custom-content'
        },
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('deletecpc') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {
              console.log(response);

              if (response.status == 200) {
                toastr.success("Compte supprimer avec succès !", "Suppression");
                fetchAlldcompte();
              }

              if (response.status == 205) {
                toastr.error("Vous n\'avez pas l\'autorisation de supprimer le compte qui est encours d\'exécution.", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }

            }
          });
        }
      })
    });

    fetchAlldcompte();

    function fetchAlldcompte() {
      $.ajax({
        url: "{{ route('liste_cpc') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all_compte").html(reponse);
        }
      });
    }
  });
</script>

<script>
  $(document).ready(function() {
    var currentId;

    $(document).on('click', '.voirHistorique', function() {
      currentId = $(this).attr('id');
      $.ajax({
        url: "{{ route('historiqueCaisse') }}",
        type: 'GET',
        data: {
          id: currentId
        },
        success: function(response) {
          $('.bs-historique-modal-xl .modal-body').html(response);
        },
        error: function() {
          $('.bs-historique-modal-xl .modal-body').html('<p>Une erreur est survenue lors du chargement des données.</p>');
        }
      });
    });

    $(document).on('click', '#refreshData', function() {
      if (currentId) {
        $.ajax({
          url: "{{ route('historiqueCaisse') }}",
          type: 'GET',
          data: {
            id: currentId
          },
          success: function(response) {
            $('.bs-historique-modal-xl .modal-body').html(response);
          },
          error: function() {
            $('.bs-historique-modal-xl .modal-body').html('<p>Une erreur est survenue lors du chargement des données.</p>');
          }
        });
      } else {
        $('.bs-historique-modal-xl .modal-body').html('<p>Aucun ID disponible pour actualiser les données.</p>');
      }
    });

    $(document).on('click', '#searchBetweenDates', function() {
      var dateDebut = $('#dateDebut').val();
      var dateFin = $('#dateFin').val();

      if (dateDebut && dateFin && currentId) {
        $.ajax({
          url: "{{ route('historiqueCaisse') }}",
          type: 'GET',
          data: {
            id: currentId,
            dateDebut: dateDebut,
            dateFin: dateFin
          },
          success: function(response) {
            $('.bs-historique-modal-xl .modal-body').html(response);
          },
          error: function() {
            $('.bs-historique-modal-xl .modal-body').html('<p>Une erreur est survenue lors du chargement des données.</p>');
          }
        });
      } else {
        $('.bs-historique-modal-xl .modal-body').html('<p>Veuillez sélectionner les deux dates et l\'ID avant de rechercher.</p>');
      }
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const printLinks = document.querySelectorAll('.PrintHistorique');

    printLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const reportId = this.dataset.id; // Utilisation de dataset pour récupérer l'ID
        if (reportId) {
          const url = `/historiqueCaisse/print/${reportId}`;
          window.open(url, '_blank'); // Ouvre l'URL dans un nouvel onglet pour imprimer
          console.log(`URL générée : ${url}`);

        } else {
          console.error("L'ID du rapport est manquant.");
        }
      });
    });
  });
</script>

<style>
  .swal-custom-content .swal-text {
    font-size: 14px;
    /* Ajustez la taille selon vos besoins */
  }
</style>

@endsection