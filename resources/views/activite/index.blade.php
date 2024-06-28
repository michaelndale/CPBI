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
          <h4 class="card-title mb-0"> <i class="mdi mdi-book-open-page-variant-outline"></i> Activités</h4>
          </div>
          <div class="col col-md-auto">
          <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addModale" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouvelle activité</a>
           
          </div>
        </div>
      </div>

      <div class="card-body p-0" id="table-container" style="overflow-y: auto;">
        <div class="card">
          <div class="table-responsive">


    <div class="table-responsive" id="table-container" style="overflow-y: auto;">
        <table class="table table-bordered table-striped table-sm fs--1 mb-0" id="show_all_activite">
          
                <tbody>
                  <tr>
                    <td colspan="8">
                      <h5 class="text-center text-secondery my-5">
                        @include('layout.partiels.load')
                    </td>
                  </tr>
                </tbody>
                </tbody>
              </table>

              <br><br><br><br>
            </div>
          </div>
        </div>
      </div>
    </div> <!-- container-fluid -->
  </div>
</div>

@include('activite.modale')




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

    $(document).on('change', '.condictionsearch', function() {
      var cat_id = $(this).val();
      var div = $(this).parent();

      $.ajax({
        type: 'get',
        url: "{{ route ('condictionsearch') }}",
        data: {
          'id': cat_id
        },
        success: function(reponse) {
          if (reponse.trim() !== "") {
            // La réponse n'est pas vide, mettre à jour le contenu HTML
            $("#showcondition").html(reponse);
          } else {
            // La réponse est vide ou nulle, faire quelque chose d'autre ou ne rien faire
            console.log("La réponse est vide ou nulle.");
          }
        }
      });
    });

    $('#addModale').modal({
      backdrop: 'static',
      keyboard: false
    });


    // Add user ajax 
    $("#addactiviteForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#addactivitebtn").html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

      $.ajax({
        url: "{{ route('storeact') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            fetchActivite();
            toastr.success("L'activité a été ajoutée avec succès", "Succès");
            $("#addactiviteForm")[0].reset();
            $("#addModale").modal('hide');
          } else if (response.status == 201) {
            toastr.error("La somme des activités dépasse le montant disponible sur la ligne !", "Attention");
          } else {
            toastr.error("Une erreur est survenue lors de l'ajout de l'activité", "Erreur");
          }
        },
        error: function(xhr, status, error) {
          toastr.error("Une erreur est survenue lors de l'envoi de la requête au serveur", "Erreur");
          console.error(xhr.responseText);
        },
        complete: function() {
          $("#addactivitebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder').prop('disabled', false);
        }
      });
    });



    // ajouter le observation 
    $("#AddCommenteForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#Addcommentebtn").html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

      $.ajax({
        url: "{{ route('storeobeserve') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            fetchActivite();
            toastr.success("Observation ajoutée avec succès !", "Succès");
            $("#AddObserve").modal('hide');
            $("#AddCommenteForm")[0].reset();
          } else {
            toastr.error("Échec de l'ajout de l'observation", "Erreur");
            $("#AddObserve").modal('show');
          }
        },
        error: function(xhr, status, error) {
          toastr.error("Une erreur est survenue lors de l'envoi de la requête au serveur", "Erreur");
          console.error(xhr.responseText);
          $("#AddObserve").modal('show');
        },
        complete: function() {
          $("#Addcommentebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder').prop('disabled', false);
        }
      });
    });


    $(document).on('click', '.editIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('showactivity') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#libelle").val(response.libellecompte);
          $("#montantact").val(response.montantbudget);
          $("#titreact").val(response.titre);
          $("#etatact").val(response.etat_activite);
          $("#aid").val(response.id);
        },
        error: function(xhr, status, error) {
          toastr.error("Une erreur est survenue lors de la récupération des détails de l'activité", "Erreur");
        }
      });
    });


    // update activite ajax request
    $("#editactiviteForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#editactivitebtn").text('Mise à jour...').prop('disabled', true);
      $.ajax({
        url: "{{ route('updateActivite') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Activité mise à jour avec succès !", "Succès");
            fetchActivite();
            $("#EditModale").modal('hide');
          } else {
            toastr.error("Échec de la mise à jour de l'activité", "Erreur");
            $("#EditModale").modal('show');
          }
        },
        error: function(xhr, status, error) {
          toastr.error("Une erreur est survenue lors de la mise à jour de l'activité", "Erreur");
          console.error(xhr.responseText);
          $("#EditModale").modal('show');
        },
        complete: function() {
          $("#editactivitebtn").text('Modifier').prop('disabled', false);
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
        text: "Une activité est sur le point d'être DÉTRUITE ! Faut-il vraiment exécuter « la Suppression » ? ",
        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer !'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('deleteact') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {
              if (response.status == 200) {
                toastr.success("Activité supprimée avec succès.", "Succès");
                fetchActivite();
              } else if (response.status == 201) {
                toastr.error("Vous n'avez pas l'autorisation de supprimer cette activité.", "Erreur");
              } else {
                toastr.error("Une erreur est survenue lors de la suppression de l'activité.", "Erreur");
              }
            },
            error: function(xhr, status, error) {
              toastr.error("Une erreur est survenue lors de la suppression de l'activité.", "Erreur");
              console.error(xhr.responseText);
            }
          });
        }
      });
    });

    $(document).on('click', '.observationshow', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');

      // Ajout d'un indicateur de chargement
      $("#showAllcommente").html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Chargement des commentaires...</div>');

      $.ajax({
        url: "{{ route('showcommente') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(reponse) {
          // Affichage des commentaires
          $("#showAllcommente").html(reponse);
        },
        error: function(xhr, status, error) {
          // Gestion des erreurs
          $("#showAllcommente").html('<div class="alert alert-danger">Une erreur s\'est produite lors du chargement des commentaires.</div>');
          console.error(xhr.responseText);
        }
      });
    });



    $(document).on('click', '.ajouteroberveget', function(e) {
      e.preventDefault(); // Empêche le comportement par défaut du lien

      let id = $(this).attr('id'); // Récupère l'ID de l'élément cliqué

      // Envoie une requête AJAX pour récupérer les détails de l'activité associée à cet ID
      $.ajax({
        url: "{{ route('showactivityobserve') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          // Met à jour le champ de formulaire avec l'ID de l'activité
          $("#idact").val(response.idact);
        }
      });
    });


    fetchActivite();

    function fetchActivite() {
      $.ajax({
        url: "{{ route('fetchActivite') }}", // URL de la route à interroger
        method: 'get', // Méthode de la requête HTTP
        success: function(response) { // Fonction à exécuter en cas de succès de la requête
          if (response.status == 500) { // Vérifie le statut de la réponse
            toastr.error("Une erreur est survenue lors de la récupération des données.", "Erreur"); // Affiche un message d'erreur
          } else {
            $("#show_all_activite").html(response); // Met à jour le contenu de l'élément avec l'ID 'show_all_activite' avec la réponse
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