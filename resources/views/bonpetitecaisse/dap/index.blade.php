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


      <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">                 
        <h4 class="mb-sm-0"><i class="fa fa-list"></i>  Petite caisse > Liste de Demande d'Autorisation de Paiement pour la petite caisse  </h4>
            <div class="page-title-right">
              <a href="#" id="fetchDataLink" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"> <i class="fas fa-sync-alt"></i> Actualiser</a>
  
            <a href="javascript:void()" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"  data-bs-toggle="modal" data-bs-target="#dapModale"><span class="me-2" data-feather="plus-circle"></span> <i class="fa fa-plus-circle"></i> Nouvel fiche FEB</a>
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
                    <th>#</th>
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
                  <th class="sort border-top"> <b>Cheque </b></th>
                  <th class="sort border-top"> <b>Compte bancaire </b></th>
                  <th class="sort border-top"> <b>Banque </b></th>
                  <th class="sort border-top"> <b>Etabli au nom</b></th>
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



<BR><BR>
@include('bonpetitecaisse.dap.modale')
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
  // Vérification du numéro DAP lors de la perte de focus
$('#numerodap').blur(function() {
    var numerodap = $(this).val();
  
    if (numerodap.trim() === '') {
        $('#numerodap_error').text('Veuillez renseigner le champ numéro DAP.');
        $('#numerodap').removeClass('has-success has-error');
        $('#numerodap_info').text('');
        return;
    }

    $.ajax({
        url: '{{ route("check.dappc") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            numerodap: numerodap
        },
        success: function(response) {
            if (response.exists) {
                $("#numerodap_error").html('<i class="fa fa-times-circle"></i> Numéro DAP existe déjà');
                $('#numerodap').removeClass('has-success').addClass('has-error');
                $('#numerodap_info').text('');
            } else {
                $("#numerodap_info").html('<i class="fa fa-check-circle"></i> Numéro Disponible');
                $('#numerodap').removeClass('has-error').addClass('has-success');
                $('#numerodap_error').text('');
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});

// Fonction pour activer/désactiver les champs en fonction de l'état des cases à cocher
function toggleInputs() {
    var checkboxes = document.querySelectorAll('.seleckbox');
    var inputs = document.querySelectorAll('.dapref');
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].readOnly = !checkboxes[0].checked;
    }
}

// Changement dans les sélections de febid
$(document).on('change', '.febid', function() {
    var febrefs = $(this).val();
    var div = $(this).parent();

    $.ajax({
        type: 'get',
        url: "{{ route ('findfebpc') }}",
        data: { 'ids': febrefs },
        success: function(reponse) {
            $("#Showpoll").html(reponse);
        },
        error: function() {
            alert("Attention! \n Erreur de connexion à la base de données, \n veuillez vérifier votre connexion");
        }
    });
});

// Deuxième requête AJAX lors du changement dans les sélections de febid
$(document).on('change', '.febid', function() {
    var febrefs = $(this).val();
    var div = $(this).parent();

    $.ajax({
        type: 'get',
        url: "{{ route ('getfebretour') }}",
        data: { 'ids': febrefs },
        success: function(reponse) {
            $("#Showretour").html(reponse);
        },
        error: function() {
            alert("Attention! \n Erreur de connexion à la base de données, \n veuillez vérifier votre connexion");
        }
    });
});

// Soumission du formulaire d'ajout de DAP
$("#adddapForm").submit(function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    $("#adddapbtn").html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
   // $("#loadingModal").modal('show');

    $.ajax({
        url: "{{ route('storedappc') }}", 
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            $("#loadingModal").modal('hide');

            if (response.status == 200) {
                $("#adddapForm")[0].reset();
                $("#dapModale").modal('hide');
                toastr.success("DAP ajouté avec succès !", "Succès");
                window.location.href = "{{ route('dappc') }}";
            } else {
                handleFormResponse(response);
            }

            $("#adddapbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder').prop('disabled', false);
        },
        error: function(xhr, status, error) {
            handleAjaxError(xhr, status, error);
        }
    });
});

// Suppression d'un DAP avec confirmation
$(document).on('click', '.deleteIcon', function(e) {
    e.preventDefault();
    let id = $(this).attr('id');
    let numero = $(this).data('numero');
    let csrf = '{{ csrf_token() }}';

    Swal.fire({
        title: 'Supprimer le DAP ?',
        html: "<p class='swal-text'>Cette action entraînera la suppression du  <b> DAP Numéro: " + numero + "</b></p><p class='swal-text'><i class='fa fa-info-circle' style='color: red;'></i> Cette action entraînera également la suppression des DJA associés aux DAP, et réinitialisera le numéro FEB pour sa réutilisation.</p>",
        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer !',
        cancelButtonText: 'Annuler',
        allowOutsideClick: false,
        customClass: {
            content: 'swal-custom-content'
        },
        preConfirm: () => deleteDAP(id, csrf)
    }).then((result) => {
        if (result.isConfirmed && result.value && result.value.status == 200) {
            toastr.success("DAP supprimé avec succès !", "Suppression");
            window.location.href = "{{ route('dappc') }}";
        }
    });
});

// Désactivation d'un signal
$(document).on('click', '.desactiversignale', function(e) {
    e.preventDefault();
    let id = $(this).attr('id');
    let csrf = '{{ csrf_token() }}';

    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Vous êtes sur le point de désactiver le signal",
        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, desactiver !',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('desactiverlesignaledap') }}",
                method: 'delete',
                data: { id: id, _token: csrf },
                success: function(response) {
                    if (response.status == 200) {
                        toastr.success("Signal désactivé avec succès !", "Désactivation");
                        fetchAlldap();
                    } else {
                        handleFormResponse(response);
                    }
                }
            });
        }
    });
});

fetchAlldap() ;
// Fonction pour récupérer et afficher tous les DAPs
function fetchAlldap() {
    $.ajax({
        url: "{{ route('fetchdappc') }}",
        method: 'get',
        success: function(reponse) {
            $("#show_all").html(reponse);
        }
    });
}

// Fonction pour gérer la réponse lors de l'ajout/suppression
function handleFormResponse(response) {
    if (response.status == 201) {
        toastr.error("Attention: DAP fonction existe déjà !", "Info");
    } else if (response.status == 202) {
        toastr.error("Erreur d'exécution, vérifiez votre connexion Internet", "Erreur");
    } else if (response.status == 203) {
        toastr.error("Erreur d'exécution: " + response.error, "Erreur");
    } else {
        // Si la réponse contient des erreurs spécifiques, affichez-les
        var errorMessage = "Erreur inconnue";
        if (response.errors) {
            errorMessage = "Erreurs : " + response.errors.join(", ");
        } else if (response.message) {
            errorMessage = "Erreur : " + response.message;
        }
        toastr.error(errorMessage, "Erreur");
    }
    $("#dapModale").modal('show');
}


// Fonction pour gérer les erreurs AJAX
function handleAjaxError(xhr, status, error) {
    $("#loadingModal").modal('hide');

    if (xhr.status === 0) {
        toastr.error("Aucune connexion. Vérifiez le réseau.", "Erreur Réseau");
    } else if (xhr.status == 404) {
        toastr.error("Erreur 404: Ressource non trouvée.", "Erreur 404");
    } else if (xhr.status == 500) {
        toastr.error("Erreur 500: Erreur interne du serveur.", "Erreur Serveur");
    } else if (status === "timeout") {
        toastr.error("Erreur: Temps de réponse écoulé.", "Timeout");
    } else if (status === "abort") {
        toastr.error("Requête AJAX annulée.", "Annulé");
    } else {
        toastr.error("Erreur d'exécution: " + error, "Erreur");
    }

    $("#dapModale").modal('show');
    $("#adddapbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder').prop('disabled', false);
}

// Fonction pour supprimer un DAP
function deleteDAP(id, csrf) {
    return new Promise((resolve) => {
        $.ajax({
            url: "{{ route('deletedappc') }}",
            method: 'delete',
            data: { id: id, _token: csrf },
            success: function(response) {
                if (response.status == 200) {
                    toastr.info("Suppression en cours...", "Suppression");
                    setTimeout(() => resolve(response), 1500);
                } else {
                    let errorMessage = response.message || "Erreur lors de la suppression du DAP.";
                    toastr.error(errorMessage, "Erreur");
                    resolve(response);
                }
            },
            error: function() {
                toastr.error("Erreur de connexion à la base de données.", "Erreur");
                resolve({ status: 500 });
            }
        });
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