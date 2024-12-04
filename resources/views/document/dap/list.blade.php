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
        
          <a href="javascript:void()" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"  data-bs-toggle="modal" data-bs-target="#dapModale">
            
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

@include('document.dap.modale')

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
  $('#numerodap').blur(function() {
    var numerodap = $(this).val();

    // Vérification si le champ est vide
    if (numerodap.trim() === '') {
      $('#numerodap_error').text('Veuillez renseigner le champ numéro DAP.');
      $('#numerodap').removeClass('has-success has-error'); // Supprime toutes les classes de succès ou d'erreur
      $('#numerodap_info').text('');
      return; // Sortir de la fonction si le champ est vide
    }

    // Envoi de la requête AJAX au serveur
    $.ajax({
      url: '{{ route("check.dap") }}',
      method: 'POST',
      data: {
        _token: '{{ csrf_token() }}', // CSRF token pour Laravel
        numerodap: numerodap
      },
      success: function(response) {
        if (response.exists) {
          $("#numerodap_error").html('<i class="fa fa-times-circle"></i> Numéro DAP existe déjà');
          $('#numerodap').removeClass('has-success') // Supprime la classe de succès
          $('#numerodap').addClass('has-error');
          $('#numerodap_info').text('');
        } else {

          $("#numerodap_info").html('<i class="fa fa-check-circle"></i> Numéro Disponible');
          $('#numerodap').removeClass('has-error') // Supprime la classe de succès
          $('#numerodap').addClass('has-success');
          $('#numerodap_error').text('');
        }
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });
  });
  
  document.addEventListener('DOMContentLoaded', function() {
  var justifierCheckbox = document.getElementById('justifier');
  var nonjustifierCheckbox = document.getElementById('nonjustifier');
  var factureColumn = document.getElementById('facture-column');
  var showRetourDiv = document.getElementById('Showretour');

  // La table `factureColumn` est affichée par défaut dans tous les cas
  factureColumn.style.display = 'table';

  function updateDisplay() {
    if (justifierCheckbox.checked) {
      showRetourDiv.style.display = 'block';
      nonjustifierCheckbox.checked = false;
    } else {
      showRetourDiv.style.display = 'block';
      nonjustifierCheckbox.checked = false;
    }
  }

  justifierCheckbox.addEventListener('change', function() {
    updateDisplay();
  });

  nonjustifierCheckbox.addEventListener('change', function() {
    if (nonjustifierCheckbox.checked) {
      justifierCheckbox.checked = false;
      showRetourDiv.style.display = 'block';

    }
  });

  // Initialisation de l'affichage
  updateDisplay();
});


  function toggleInputs() {
    var checkboxes = document.querySelectorAll('.seleckbox');
    var inputs = document.querySelectorAll('.dapref');
    for (var i = 0; i < inputs.length; i++) {
      inputs[i].readOnly = !checkboxes[0].checked;
    }
  }


  $(document).ready(function() {
    $(document).on('change', '.febid', function() {
      var febrefs = $(this).val(); // Utilisez val() pour obtenir toutes les valeurs sélectionnées
      var div = $(this).parent();
      var op = " ";
      $.ajax({
        type: 'get',
        url: "{{ route ('getfeb') }}",
        data: {
          'ids': febrefs // Utilisez 'ids' au lieu de 'id' pour envoyer toutes les valeurs sélectionnées
        },
        success: function(reponse) {
          $("#Showpoll").html(reponse);
        },
        error: function() {
          alert("Attention! \n Erreur de connexion à la base de données, \n veuillez vérifier votre connexion");
        }
      });
    });
  });


  $(document).ready(function() {
    $(document).on('change', '.febid', function() {
      var febrefs = $(this).val(); // Utilisez val() pour obtenir toutes les valeurs sélectionnées
      var div = $(this).parent();
      var op = " ";
      $.ajax({
        type: 'get',
        url: "{{ route ('getfebretour') }}",
        data: {
          'ids': febrefs // Utilisez 'ids' au lieu de 'id' pour envoyer toutes les valeurs sélectionnées
        },
        success: function(reponse) {
          $("#Showretour").html(reponse);
        },
        error: function() {
          alert("Attention! \n Erreur de connexion à la base de données, \n veuillez vérifier votre connexion");
        }
      });
    });
  });




  $(function() {

    $("#adddapForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#adddapbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("adddapbtn").disabled = true; // Désactiver le bouton
      $("#loadingModal").modal('show'); // Affiche le popup de chargement

      $.ajax({
        url: "{{ route('storedap') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          $("#loadingModal").modal('hide'); // Cacher le popup de chargement

          if (response.status == 200) {
            $("#adddapForm")[0].reset();
            $("#dapModale").modal('hide');
            toastr.success("DAP ajouté avec succès !", "Succès");
            window.location.href = "{{ route('listdap') }}";
          } else if (response.status == 201) {
            toastr.error("Attention: DAP fonction existe déjà !", "Info");
            $("#dapModale").modal('show');
          } else if (response.status == 202) {
            toastr.error("Erreur d'exécution, vérifiez votre connexion Internet", "Erreur");
            $("#dapModale").modal('show');
          } else if (response.status == 203) {
            toastr.error("Erreur d'exécution: " + response.error, "Erreur");
            $("#dapModale").modal('show');
          }

          $("#adddapbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
          document.getElementById("adddapbtn").disabled = false; // Réactiver le bouton
        },
        error: function(xhr, status, error) {
          $("#loadingModal").modal('hide'); // Cacher le popup de chargement
          toastr.error("Erreur d'exécution: " + error, "Erreur");
          $("#dapModale").modal('show');
          $("#adddapbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
          document.getElementById("adddapbtn").disabled = false; // Réactiver le bouton
        }
      });
    });


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

<script>
  document.getElementById('beneficiaire').addEventListener('change', function () {
      const nomPrenomContainer = document.getElementById('nomPrenomContainer');
      if (this.value === 'autres') {
          nomPrenomContainer.style.display = 'block';  // Affiche le conteneur avec le texte et l'input
      } else {
          nomPrenomContainer.style.display = 'none';  // Cache le conteneur pour toutes les autres options
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