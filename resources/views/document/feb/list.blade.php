@extends('layout/app')
@section('page-content')
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
      <div class="card-header p-4 border-bottom border-300 bg-soft">
        <div class="row g-3 justify-content-between align-items-end">
          <div class="col-12 col-md">
            <h4 class="card-title mb-0"> <i class="mdi mdi-book-open-page-variant-outline"></i> Fiche d'Expression des Besoins "FEB"  </h4>
          </div>
          <div class="col col-md-auto">
            <a href="#" id="fetchDataLink" class="btn btn-sm btn-primary">
              <i class="fas fa-sync-alt"></i> Actualiser
          </a>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <a href="{{ route('nouveau.feb') }}" class="btn btn-sm btn-success">
              <span class="fa fa-plus-circle"></span> Nouvel fiche FEB
          </a>
          
          </div>
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
                  <th class="sort border-top" data-sort="om"> <b>
                      <center>Montant total </center>
                    </b></th>
                  <th class="sort border-top" data-sort="periode">
                    <center><b>Période</b></center>
                  </th>
                  <th class="sort border-top" data-sort="code">
                    <center><b>Code</b></center>
                  </th>
                  <th class="sort border-top" data-sort="Description">
                   <b>Description</b>
                  </th>
                  <th class="sort border-top ps-3" data-sort="facture">
                   <b>Pièce jointe</b>
                  </th>
                  
                
                  <th class="sort border-top" data-sort="date">
                    <center><b>Date FEB</b></center>
                  </th>
                  <th class="sort border-top" data-sort="date">
                    <center><b>Créé le</b></center>
                  </th>
                  <th class="sort border-top" data-sort="date"><b>Créé par</b></th>
                  <th class="sort border-top" data-sort="%">
                    <center> <b>%</b></center>
                  </th>

                </tr>
              </thead>


              <tbody class="show_all" id="show_all">
                <tr>
                  <td colspan="15">
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

  $(function() {
   
    // Delete feb ajax request

    $(document).on('click', '.deleteIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let numero = $(this).data('numero');
      let csrf = '{{ csrf_token() }}';

      Swal.fire({
        title: 'Supprimer le FEB ?',
        html: "<p class='swal-text'>Cette action entraînera la suppression du  <b> FEB Numéro: " + numero + "</b>  </p><p class='swal-text'><i class='fa fa-info-circle' style='color: red;'></i> Cette action entraînera également la suppression de les élements du FEB dans le DAP, DJA associés aux FEB.</p>",
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
              url: "{{ route('deletefeb') }}",
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
          fetchAllfeb();
          Sommefeb();
        }
      });
    });

    $(document).on('click', '.desactiversignale', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Vous êtes sur le point de désactiver le signal ",
        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, desactiver !',
        cancelButtonText: 'Annuller'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('desactiverlesignalefeb') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {

              if (response.status == 200) {
                toastr.success("Signale desactive succès !", "Desactivation");
                fetchAllfeb();
                Sommefeb();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de desactive le signale du FEB!", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
              fetchAllfeb();
              Sommefeb();

            }
          });
        }
      })
    });

    $(document).ready(function() {
      // Attachement de l'événement click au lien

      $("#fetchDataLink").click(function(e) {
        $("#loadingModal").modal('show'); // Affiche le popup de chargement
        e.preventDefault(); // Empêche le comportement par défaut du lien (rechargement de la page)
        fetchAllfeb(); // Appel à la fonction pour charger les données
        setTimeout(function() {
          $("#loadingModal").modal('hide');
        }, 1000); // 2000 millisecondes = 2 secondes
      });
    });


    fetchAllfeb();

    function fetchAllfeb() {
      $.ajax({
        url: "{{ route('fetchAllfeb') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all").html(reponse);
        }
      });
    }
    Sommefeb();
    function Sommefeb() {
      $.ajax({
        url: "{{ route('Sommefeb') }}",
        method: 'get',
        success: function(reponse) {
          $("#showSommefeb").html(reponse);
        }
      });
    }
  });
</script>
<style>
  .swal-custom-content .swal-text {
    font-size: 14px;
    /* Ajustez la taille selon vos besoins */
  }
</style>
@endsection