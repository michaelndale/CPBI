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
    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">

      <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0"><i class="mdi mdi-book-open-page-variant-outline"></i> Demande d'Autorisation de Paiement "DAP" </h4>

        <div class="page-title-right">
             
          <a href="{{ route('dap.list.print', ['date' => date('dmYHis')]) }}" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" title="Imprimer la liste">
            <i class="fa fa-print"></i>
           </a>
        
           <a href="{{ route('listdap') }}" id="fetchDataLink" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" title=" Actualiser">
            <i class="fas fa-sync-alt"></i>
          </a>
    
          <a href="{{ route('nouveau.dap') }}" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" >
            <i class="fa fa-plus-circle"></i> Créer 
        </a>
      </div>
    </div>


      <div class="card-body p-0">
        <div id="tableExample2">
          <div class="table-responsive">
            <table class="table table-striped table-sm fs--1 mb-0" style="background-color:#c0c0c0">
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
                    <center><b>Actions</b></center>
                  </th>

                  <th class="sort border-top ">
                    <center><b>N<sup>o</sup> DAP </b></center>
                  </th>
                  <th class="sort border-top ">
                    <center> <b>N<sup>o</sup> FEB </b></center>
                  </th>
                  <th class="sort border-top "> <b><center>Montant</center> </b></th>
                  <th class="sort border-top "> <b>Lieu </b></th>
                  <th class="sort border-top"> <b>OV/Chèque</b></th>
                  <th class="sort border-top"> <b>Compte bancaire </b></th>
                  <th class="sort border-top"> <b>Banque </b></th>
                  <th class="sort border-top"> <b>Etabli au nom</b></th>
                  <th class="sort border-top"> <b>Avance</b></th>
                  <th class="sort border-top"> <center><b> Justifiée ? </b></center> </th>
                  <th class="sort border-top "> <center><b> Créé le. </b></center> </th>
                  <th class="sort border-top "> <b> Créé par </b></th>
                </tr>
              </thead>
              <tbody class="show_all" id="show_all">
                <tr>
                  <td colspan="13">
                    <h5 class="text-center text-secondery my-5">
                      @include('layout.partiels.load')
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

  $(function() {

    // Delete feb ajax request
    $(document).on('click', '.deleteIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let numero = $(this).data('numero');
      let csrf = '{{ csrf_token() }}';

      Swal.fire({
        title: 'Supprimer le DAP ?',
        html: "<p class='swal-text'>Cette action entraînera la suppression du  <b> DAP Numéro: " + numero + "</b>  </p><p class='swal-text'><i class='fa fa-info-circle' style='color: red;'></i> Cette action entraînera également la suppression des DJA associés aux DAP, et réinitialisera le numéro FEB pour sa réutilisation. </p>",
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
                  // Attendre un court délai pour que l'utilisateur voie le message
                  setTimeout(() => {
                    resolve(response); // Résoudre la promesse avec la réponse de la requête AJAX
                  }, 1500); // Temps en millisecondes avant de résoudre la promesse
                } else {
                  let errorMessage = response.message || "Erreur lors de la suppression du DAP.";
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
          toastr.success("DAP supprimé avec succès !", "Suppression");
          var ur = "{{ route('listdap') }}";
          window.location.href = ur;
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
            url: "{{ route('desactiverlesignaledap') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {

              if (response.status == 200) {
                toastr.success("Signale desactive succès !", "Desactivation");
                fetchAlldap();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de desactive le signale du DAP!", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
              fetchAlldap();

            }
          });
        }
      })
    });

    fetchAlldap();

    function fetchAlldap() {
      $.ajax({
        url: "{{ route('fetchdap') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all").html(reponse);
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