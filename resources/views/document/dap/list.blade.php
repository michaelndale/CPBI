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
  <br>
  <div class="content">
    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">
      <div class="card-header p-4 border-bottom border-300 bg-soft">
        <div class="row g-3 justify-content-between align-items-end">
          <div class="col-12 col-md">
            <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="mdi mdi-book-open-page-variant-outline"></i> Demande d'Autorisation de Paiement "DAP" </h4>
          </div>
          <div class="col col-md-auto">

            <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#dapModale"><span class="me-2" data-feather="plus-circle"></span> <i class="fa fa-plus-circle"></i> Nouvel fiche DAP</a></nav>
          </div>
        </div>
      </div>
      <div class="card-body p-0">

        <div id="tableExample2" >
          <div class="table-responsive">
            <table class="table table-striped table-sm fs--1 mb-0" style="background-color:#c0c0c0">

              <tbody id="showSommefeb">

              </tbody>

            </table>
           
          </div>

        </div>



        <div id="tableExample2">
          <div class="table-responsive">
            <table class="table table-striped table-sm fs--1 mb-0">
              <thead>
                <tr>
                  <th class="sort border-top ">
                    <center><b>Actions</b></center>
                  </th>

                  <th class="sort border-top "> <center><b>N<sup>o</sup>  DAP </b></center> </th>
                  <th class="sort border-top "> <center> <b>N<sup>o</sup>  FEB </b></center> </th>
                  <th class="sort border-top "> <b>Lieu </b></th>
                  <th class="sort border-top "><center> <b>OV  </b></center></th>
                  <th class="sort border-top "> <center><b>CHO </b></center></th>
                  <th class="sort border-top "> <center><b>Compte bancaire </b></center></th>
                  <th class="sort border-top "> <center><b>DJA (Justifier) </b></center></th>
                  <th class="sort border-top "> <center><b> Créé le. </b></center></th>
                  <th class="sort border-top "> <center><b> Créé par </b></center></th>
                </tr>
              </thead>


              <tbody class="show_all" id="show_all">
                <tr>
                  <td colspan="11">
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
                $('#numerodap_error').text('Erreur : Numéro DAP existe déjà.');
                $('#numerodap').removeClass('has-success') // Supprime la classe de succès
                $('#numerodap').addClass('has-error');
                $('#numerodap_info').text('');
            } else {
                $('#numerodap_info').text('Numéro Disponible');
                $('#numerodap').removeClass('has-error')  // Supprime la classe de succès
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

    function updateDisplay() {
        if (justifierCheckbox.checked) {
            factureColumn.style.display = 'table';
            showRetourDiv.style.display = 'block';
            nonjustifierCheckbox.checked = false;
        } else if (nonjustifierCheckbox.checked) {
            factureColumn.style.display = 'none';
            showRetourDiv.style.display = 'none';
            justifierCheckbox.checked = false;
        } else {
            factureColumn.style.display = 'none';
            showRetourDiv.style.display = 'none';
        }
    }

    justifierCheckbox.addEventListener('change', function() {
        updateDisplay();
    });

    nonjustifierCheckbox.addEventListener('change', function() {
        if (nonjustifierCheckbox.checked) {
            factureColumn.style.display = 'none';
            showRetourDiv.style.display = 'none';
            justifierCheckbox.checked = false;
        }
    });

    // Au chargement initial, assurez-vous que les éléments restent masqués
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
                fetchAlldap();
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
    let csrf = '{{ csrf_token() }}';
    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "DAP est sur le point d'être DÉTRUITE ! Faut-il vraiment exécuter « la Suppression » ?  ",
        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer !',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('deletedap') }}",
                method: 'delete',
                data: {
                    id: id,
                    _token: csrf
                },
                success: function(response) {
                    if (response.status == 200) {
                        toastr.success("DAP supprimé avec succès !", "Suppression");
                        fetchAlldap();
                         window.location.href = "{{ route('listdap') }}";
                    } else if (response.status == 205) {
                        toastr.error("Vous n'avez pas l'accréditation de supprimer ce DAP !", "Erreur");
                    } 
                   else if (response.status == 403) {
                        toastr.error("Unauthorized action !", "Erreur");
                    } 
                    else if (response.status == 404) {
                        toastr.error("DAP not found", "Erreur");
                    } 
                    else {
                        toastr.error("Erreur d'exécution !", "Erreur");
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error("Erreur d'exécution lors de la suppression du DAP : " + error, "Erreur");
                }
            });
        }
    });
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

@endsection