@extends('layout/app')
@section('page-content')

<style type="text/css">
  .has-error {
    border: 1px solid red;
  }

  .has-success {
    border: 1px solid #82E0AA;
  }
</style>

<div class="main-content">
  <div class="page-content">
    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style="margin:auto">

      <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.30rem 3rem;">
        <h4 class="mb-sm-0"><i class="mdi mdi-book-open-page-variant-outline"></i> Demande d'Autorisation de Paiement "DAP" </h4>

        <div class="page-title-right d-flex align-items-center justify-content-between gap-2" style="margin: 0;">
          <form id="searchForm" class="app-search d-none d-lg-block" method="GET">
            <div class="position-relative">
                <input type="text" id="searchInput" name="search_dap" class="form-control"
                    placeholder="Recherche ...">
                <span class="ri-search-line"></span>
            </div>
        </form>
          <a href="{{ route('dap.list.print', ['date' => date('dmYHis')]) }}" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" title="Imprimer la liste">
            <i class="fa fa-print"></i>
          </a>

          <a href="{{ route('listdap') }}" id="fetchDataLink" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" title="Actualiser">
            <i class="fas fa-sync-alt"></i>
          </a>

          <a href="{{ route('nouveau.dap') }}" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm">
            <i class="fa fa-plus-circle"></i> Créer 
          </a>
        </div>
      </div>

      <div class="card-body p-0">
        <div id="tableExample2">
            <div class="table-responsive" id="table-container" style="overflow-y: auto;">
                <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                    <thead style="position: sticky; top: 0; background-color: white; z-index: 1;">
                        <tr>
                          <th class="sort border-top"><center><b></b></center></th>
                            <th class="sort border-top"><center><b>Actions</b></center></th>
                            <th class="sort border-top"><center><b>N<sup>o</sup> DAP</b></center></th>
                            <th class="sort border-top"><center><b>N<sup>o</sup> FEB</b></center></th>
                            <th class="sort border-top"><center><b>Montant</b></center></th>
                            <th class="sort border-top"><center><b>Lieu</b></center></th>
                            <th class="sort border-top"><b>OV/Chèque</b></th>
                            <th class="sort border-top"><b>Compte bancaire</b></th>
                            <th class="sort border-top"><b>Banque</b></th>
                            <th class="sort border-top"><b>Etabli au nom</b></th>
                            <th class="sort border-top"><b>Avance</b></th>
                            <th class="sort border-top"><center><b>Justifiée ?</b></center></th>
                            <th class="sort border-top"><center><b>Créé le</b></center></th>
                            <th class="sort border-top"><b>Créé par</b></th>
                        </tr>
                    </thead>
                    <tbody class="show_all" id="show_all">
                      <tr>
                          <td colspan="15" id="loading-message">
                              <div class="text-center">
                                  <div class="spinner-border text-primary" role="status">
                                      <span class="visually-hidden">Chargement...</span>
                                  </div>
                                  <h5 class="text-center text-secondary my-5">Chargement des données...</h5>
                              </div>
                          </td>
                      </tr>
                  </tbody>
                </table>
    
                <div style="display: flex; justify-content: center; align-items: center; margin-top: 10px;">
                    <div id="pagination-container" class="mt-3">
                        <!-- Pagination sera injectée ici -->
                    </div>
                </div>
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
    tableContainer.style.height = (windowHeight - 200) + 'px';
  }

  window.onload = adjustTableHeight;
  window.onresize = adjustTableHeight;

  $(function() {
    // Suppression avec confirmation
    $(document).on('click', '.deleteIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let numero = $(this).data('numero');
      let csrf = '{{ csrf_token() }}';

      Swal.fire({
        title: 'Supprimer le DAP ?',
        html: "<p class='swal-text'>Cette action entraînera la suppression du <b> DAP Numéro: " + numero + "</b></p><p class='swal-text'><i class='fa fa-info-circle' style='color: red;'></i> Cette action entraînera également la suppression des DJA associés aux DAP, et réinitialisera le numéro FEB pour sa réutilisation.</p>",
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
              url: "{{ route('deletedap') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                if (response.status == 200) {
                  toastr.info("Suppression en cours...", "Suppression");
                  setTimeout(() => {
                    resolve(response);
                  }, 1500);
                } else {
                  let errorMessage = response.message || "Erreur lors de la suppression du DAP.";
                  toastr.error(errorMessage, "Erreur");
                  resolve(response);
                }
              },
              error: function(xhr, status, error) {
                let errorMsg = xhr.responseJSON ? xhr.responseJSON.message : "Erreur de réseau. Veuillez réessayer.";
                toastr.error(errorMsg, "Erreur");
                resolve({
                  status: 500,
                  message: errorMsg,
                  error: error
                });
              }
            });
          });
        }
      }).then((result) => {
        if (result.isConfirmed && result.value && result.value.status == 200) {
          toastr.success("DAP supprimé avec succès !", "Suppression");
          var ur = "{{ route('listdap') }}";
          window.location.href = ur;
        }
      });
    });

    $(document).ready(function() {
                // Attachement de l'événement click au lien

                $("#fetchDataLink").click(function(e) {
                    $("#loadingModal").modal('show'); // Affiche le popup de chargement
                    e
                .preventDefault(); // Empêche le comportement par défaut du lien (rechargement de la page)
                    fetchAllfeb(); // Appel à la fonction pour charger les données
                    setTimeout(function() {
                        $("#loadingModal").modal('hide');
                    }, 1000); // 2000 millisecondes = 2 secondes
                });
            });

            function fetchAllfeb(page = 1) {
                // Afficher l'indicateur de chargement
                $("#loading-message").show(); // Afficher l'indicateur dans le corps de la table
                $("#pagination-container").html(
                    '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Chargement...</span></div>'
                    ); // Afficher un spinner dans la pagination

                // Désactiver les liens de pagination pour éviter plusieurs appels AJAX simultanés
                $("#pagination-container a").addClass("disabled");

                $.ajax({
                    url: "{{ route('fetchdap') }}",
                    method: "GET",
                    data: {
                        page: page
                    },
                    success: function(response) {
                        // Mettre à jour le contenu de la table et de la pagination
                        $("#show_all").html(response.table);
                        $("#pagination-container").html(response.pagination);

                        // Cacher l'indicateur de chargement une fois les données chargées
                        $("#loading-message").hide();
                        $("#pagination-container a").removeClass("disabled");
                    },
                    error: function() {
                        // Cacher l'indicateur de chargement en cas d'erreur
                        $("#loading-message").hide();
                        alert("Une erreur s'est produite lors du chargement des données.");
                    }
                });
            }

            // Charger la première page
            fetchAllfeb();

            // Gérer les clics de pagination
            $(document).on("click", "#pagination-container a", function(e) {
                e.preventDefault();

                // Désactiver le lien de pagination pendant le chargement
                $(this).addClass("disabled");

                const url = $(this).attr("href");
                const page = new URL(url).searchParams.get("page");
                fetchAllfeb(page);
            });

   
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
      const searchForm = document.getElementById('searchForm');
      const searchInput = document.getElementById('searchInput');
      let timer;

      // Récupérer les données au chargement de la page
      fetchData();

      // Fonction pour récupérer les données
      function fetchData(searchTerm = '') {
          const fetchUrl = `{{ route('fetchdap') }}?search_dap=${searchTerm}`;
          fetch(fetchUrl)
              .then(response => response.json())
              .then(data => {
                  if (data.table) {
                      document.getElementById('show_all').innerHTML = data.table;
                  } else {
                      document.getElementById('show_all').innerHTML = 'Aucun résultat trouvé';
                  }
              });
      }

      // Écoute l'événement de saisie pour la recherche en temps réel
      searchInput.addEventListener('input', function() {
          clearTimeout(timer); // Annule l'exécution précédente si l'utilisateur tape à nouveau
          timer = setTimeout(function() {
              const searchTerm = searchInput.value.trim();

              // Si la recherche a 3 caractères ou plus, on effectue la recherche
              fetchData(searchTerm);
          }, 300); // 300 ms de délai après que l'utilisateur ait cessé de taper
      });
  });
</script>



@endsection
