@extends('layout/app')
@section('page-content')
<style>
  /* Style pour le texte caché */
  .hidden-link {
    display: none;
  }

  /* Style de la classe difference */
  .difference {
    /* Ajoutez votre style pour différencier visuellement la cellule */
    background-color: #ffcccc;
    /* Par exemple, couleur de fond différente */
  }
</style>
<div class="main-content">
  <div class="page-content">
    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style="margin:auto">
      <div class="card-header p-4 border-bottom border-300 bg-soft">
        <div class="row g-3 justify-content-between align-items-end">
          <div class="col-12 col-md">
          <h4 class="card-title mb-0"> <i class="mdi mdi-book-open-page-variant-outline"></i> Budgétisation</h4>
          </div>
          <div class="col col-md-auto">
            <a href="javascript::;" id="fetchDataLink">
              <span class="fa fa-sync-alt"></span> Actualiser
            </a>
            @if($projetdatat->autorisation == 1)
            <a href="javascript::;" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
              <span class="fa fa-plus-circle"></span> Ajouter le budget
            </a>
            @endif
          </div>
        </div>
      </div>

      <div class="card-body p-0" id="table-container" style="overflow-y: auto;">
        <div class="card">
          <div class="table-responsive">
            <div class="sticky-header">
              <div class="float-end d-none d-md-inline-block" style="background-color: white;">
                <div class="scrollable-content">
                  <div id="show_all_rallonge" class="scrollme">
                    <center>
                      <br><br><br><br> @include('layout.partiels.load') <br><br><br><br>
                    </center>
                  </div>
                </div>
                <br><br><br><br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<br> <br> <br> <br>


@include('rallonge.modale')



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
  function toggleUrldocInput(checkbox) {
    var urldocInput = document.getElementById("urldoc");
    urldocInput.style.display = checkbox.checked ? "block" : "none";
  }

  // Vérifier l'état initial de la case à cocher au chargement de la page
  window.onload = function() {
    var retructionCheckbox = document.getElementById("retruction");
    toggleUrldocInput(retructionCheckbox);
  };

  // Sélection des lignes (<tr>) avec la classe "hoverable-tr"
  const hoverableTrs = document.querySelectorAll('.hoverable-tr');

  // Écoute des événements de survol pour chaque ligne
  hoverableTrs.forEach(tr => {
    tr.addEventListener('mouseover', () => {
      // Sélection de l'élément <a> à l'intérieur de la ligne
      const editLink = tr.querySelector('.edit-link');
      // Ajout de la classe pour afficher le lien
      editLink.classList.remove('hidden-link');
    });
    // Événement pour cacher le lien lorsque la souris quitte la ligne
    tr.addEventListener('mouseleave', () => {
      // Sélection de l'élément <a> à l'intérieur de la ligne
      const editLink = tr.querySelector('.edit-link');
      // Suppression de la classe pour cacher le lien
      editLink.classList.add('hidden-link');
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#dtHorizontalVerticalExample').DataTable({
      "scrollX": true,
      "scrollY": 200,
    });
    $('.dataTables_length').addClass('bs-select');
  });
</script>


<script type="text/javascript">
  $(document).ready(function() {

    $(document).on('change', '.compteid', function() {
      var cat_id = $(this).val();
      var op = "";

      $.ajax({
        type: 'get',
        url: "{{ route ('findSousCompte') }}",
        data: {
          'id': cat_id
        },
        success: function(data) {
          console.log(data);
          if (data.length == 0) {
            op += '<option value="0" selected disabled>-- Ligne compte --</option>';
            op += '<option value="0" selected disabled>Aucun</option>';
            toastr.error("Attention !! La ligne n'a pas de sous-ligne", "Information");
          } else {
            $.each(data, function(index, item) {
              op += '<option value="' + item.id + '">' + item.numero + '.' + item.libelle + '</option>';
            });
          }
          // Mettre à jour le menu déroulant une seule fois après la boucle
          $("#scomptef").html(op);
        },
        error: function() {
          toastr.error("Erreur de connexion à la base de données, vérifiez votre connexion", "Attention");
        }
      });
    });
  });
</script>



<script>
  $(function() {
    // Add rallonge budgetaire ajax 
    $("#addFOrm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      const saveButton = $("#savebtn");
      saveButton.html('<i class="fas fa-spinner fa-spin"></i>');
      saveButton.prop("disabled", true);

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
              toastr.error("Le montant est supérieur au montant global du budget !", "Attention");
              break;
            case 202:
              toastr.error("Erreur d'exécution !", "Erreur");
              break;
            case 203:
              toastr.error("Une ligne de compte ne peut recevoir le montant plusieurs fois !", "Erreur");
              break;
            default:
              toastr.error("Erreur inconnue !", "Erreur");
          }
          saveButton.html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
          saveButton.prop("disabled", false);
          $("#addDealModal").modal('show');
        },
        error: function() {
          toastr.error("Erreur de communication avec le serveur !", "Erreur");
          saveButton.html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
          saveButton.prop("disabled", false);
        }
      });
    });

    // Edit fonction ajax request
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
            let data = response[0]; // Supposons que la réponse est un tableau et que nous avons besoin du premier élément
            $("#r_libelle").val(data.libelle);
            $("#r_code").val(data.numero);
            $("#r_budgetactuel").val(data.budgetactuel);
            $("#ancienmontantligne").val(data.budgetactuel);
            $("#r_souscompte").val(data.souscompte);
            $("#r_idligne").val(data.idr);
            $("#r_idr").val(data.idr);
          } else {
            // Affichez un message d'alerte si aucune donnée n'est trouvée
            toastr.error('Aucune donnée trouvée pour cet ID.');
          }
        },
        error: function(xhr, status, error) {
          // Gérez les erreurs de la requête AJAX
          console.error('Erreur:', error);
          toastr.error('Erreur lors de la récupération des données.');
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

    // Revision ajax request
    $("#editrevisionform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#revisionbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("revisionbtn").disabled = true;

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
            document.getElementById("revisionbtn").disabled = false;

          }

          if (response.status == 202) {
            toastr.error("Échec ! Le budget n'a pas été modifié.", "Erreur");
            $("#revisionbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#revisionModal").modal('show');
            document.getElementById("revisionbtn").disabled = false;
          }

          if (response.status == 205) {
            toastr.error("Attention ! Vous ne devez pas dépasser le montant du budget global.", "Erreur");
            $("#revisionbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#revisionModal").modal('show');
            document.getElementById("revisionbtn").disabled = false;
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
                toastr.success("Ligne budgétaire supprimée avec succès.", "Succès");

              } else if (response.status == 201) {
                toastr.error("Vous n'avez pas l'autorisation de supprimer cette ligne budgétaire.", "Erreur");
              } else {
                toastr.error("Une erreur est survenue lors de la suppression du ligne budgétaaire.", "Erreur");
              }
            },
            error: function(xhr, status, error) {
              toastr.error("Une erreur est survenue lors de la suppression de la ligne budgétaire.", "Erreur");
              console.error(xhr.responseText);
            }
          });
        }
      });
    });

    fetchAllrallonge();

    function fetchAllrallonge() {
      $.ajax({
        url: "{{ route('fetchRallonge') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all_rallonge").html(reponse);
        }
      });
    }

    fetchAllrallonge();

    function fetchAllrallonge() {
      $.ajax({
        url: "{{ route('fetchRallonge') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all_rallonge").html(reponse);
        }
      });
    }

  });
</script>

<style>
  .sticky-header {
    position: sticky;
    top: 0;
    z-index: 1;
    background-color: white;
    /* Assurez-vous que l'arrière-plan de la partie fixe est blanc pour qu'elle recouvre le contenu en dessous lors du défilement */
  }

  .scrollable-content {
    overflow-y: auto;
    max-height: 400px;
    /* Ajustez cette valeur selon vos besoins */
  }
</style>

@endsection