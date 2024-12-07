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
    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style="margin: 0; margin:auto">
      
      <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"  style="padding: 0.10rem 3rem;" >
        <h4 class="mb-sm-0"><i class="mdi mdi-book-open-page-variant"></i> Fiche d'Expression des Besoins "FEB"</h4>
        
        <div class="page-title-right d-flex align-items-center justify-content-between gap-2" style="margin: 0;" >


         
          <!-- Formulaire de recherche -->
          <form id="searchForm" class="app-search d-none d-lg-block" method="GET">
            <div class="position-relative">
              <input type="text" id="searchInput" name="search_numerofeb" class="form-control" placeholder="Recherche ...">
              <span class="ri-search-line"></span>
            </div>
          </form>
        
          <!-- Bouton Actualiser -->
          <!-- Bouton Actualiser -->
          <a href="javascript:void(0)" id="fetchDataLink" class="btn btn-outline-primary rounded-pill btn-sm" title="Actualiser">
            <i class="fas fa-sync-alt"></i>
          </a>

        
          <!-- Bouton Créer -->
          <a href="{{ route('nouveau.feb') }}" class="btn btn-outline-primary rounded-pill btn-sm">
            <span class="fa fa-plus-circle"></span> Créer
          </a>
        
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
                  <th class="sort border-top"><center><b>Actions</b></center></th>
                  <th class="sort border-top"><center><b>N<sup>o</sup> FEB</b></center></th>
                  <th class="sort border-top"><center><b>Montant total</b></center></th>
                  <th class="sort border-top"><center><b>Période</b></center></th>
                  <th class="sort border-top"><center><b>Code</b></center></th>
                  <th class="sort border-top"><b>Description</b></th>
                  <th class="sort border-top ps-3"><center><b>Pièce</b></center></th>
                  <th class="sort border-top ps-3"><center><b>Statut</b></center></th>
                  <th class="sort border-top"><center><b>Date FEB</b></center></th>
                  <th class="sort border-top"><center><b>Créé le</b></center></th>
                  <th class="sort border-top"><b>Créé par</b></th>
                  <th class="sort border-top"><center><b>%</b></center></th>
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

            <div id="pagination-container">
              <!-- La pagination sera ajoutée ici par JavaScript -->
          </div>


            
            <br><br><br><br>
            <br><br><br><br>
            <br>


          </div>

        </div>
      </div>
    </div>
  </div>
</div>

@include('document.feb.modale')

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


<script>
 document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');
    let timer;

    // Récupérer les données au chargement de la page
    fetchData();

    // Fonction pour récupérer les données
    function fetchData(searchTerm = '') {
        const fetchUrl = `{{ route('fetchAllfeb') }}?search_numerofeb=${searchTerm}`;
        fetch(fetchUrl)
            .then(response => response.text())
            .then(data => {
                document.getElementById('show_all').innerHTML = data;
            });
    }

    // Écoute l'événement de saisie pour la recherche en temps réel
    searchInput.addEventListener('input', function () {
        clearTimeout(timer);  // Annule l'exécution précédente si l'utilisateur tape à nouveau
        timer = setTimeout(function () {
            const searchTerm = searchInput.value.trim();

            // Si la recherche a 3 caractères ou plus, on effectue la recherche
            fetchData(searchTerm);
        }, 300);  // 300 ms de délai après que l'utilisateur ait cessé de taper
    });
});

</script>



@endsection