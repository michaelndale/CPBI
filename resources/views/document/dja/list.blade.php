@extends('layout/app')
@section('page-content')
<div class="main-content">
  <br>

  <div class="content">
    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">
      <div class="card-header p-4 border-bottom border-300 bg-soft">
        <div class="row g-3 justify-content-between align-items-end">
          <div class="col-12 col-md">
            <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="mdi mdi-book-open-page-variant-outline"></i> Demande et Justification d'Avance "DJA" </h4>
          </div>
          <!-- <div class="col col-md-auto">
            <a href="javascript:void()" ><span class="me-2" data-feather="plus-circle"></span> <i class="fa fa-plus-circle"></i> Nouvel justification</a></nav>
            </div>  -->

        </div>
      </div>
      <div class="card-body p-0">

        <div id="tableExample2">
          <div class="table-responsive">
            <table class="table table-striped table-sm fs--1 mb-0 table-bordere" style="background-color:#c0c0c0">
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
                  <th>
                    <center><b>Actions</b></center>
                  </th>
                  <th><b>N<sup>o</sup> DJA</b> </th>
                  <th><b>N<sup>o</sup> DAP</b></th>
                  <th><b>OV </b></th>
                  <th><b> Justifier ?</b></th>
                  <th><b> Date enr. </b></th>

                </tr>
              </thead>


              <tbody class="show_all" id="show_all">
                <tr>
                  <td colspan="9">
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



@include('document.dja.modale')



<script>
  $(document).on('input', 'input[name="montant_utiliser[]"]', function() {
    var montantAvance = $(this).closest('tr').find('input[name="montantavance[]"]').val();
    var montantUtilise = $(this).val();
    var surplusManque = parseFloat(montantAvance) - parseFloat(montantUtilise);
    $(this).closest('tr').find('input[name="surplus[]"]').val(surplusManque);
  });

  $(document).on('input', 'input[name="montant_retourne[]"]', function() {
    var surplusManque = parseFloat($(this).closest('tr').find('input[name="surplus[]"]').val());
    var montantRetourne = parseFloat($(this).val());
    var errorMessage = $(this).closest('tr').find('.error-message');
    var addjustifierbtn = $('#addjustifierbtn');

    if (montantRetourne !== surplusManque) {
      errorMessage.text("Le Montant Retourné doit être égal au Surplus/Manque.");
      $(this).addClass('is-invalid');
      addjustifierbtn.prop('disabled', true);
    } else {
      errorMessage.text("");
      $(this).removeClass('is-invalid');
      addjustifierbtn.prop('disabled', false);
    }
  });

  $(document).on('input', '.description-input', function() {
    var descriptionValue = $(this).val().toLowerCase();
    var relatedPlaqueTd = $(this).closest('tr').find('.plaque-input').parent();
    if (descriptionValue.includes('carburant')) {
      relatedPlaqueTd.show();
    } else {
      relatedPlaqueTd.hide();
    }
  });





  $(function() {

    // Add  ajax 
    $("#addjdaForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#addjustifierbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("addjustifierbtn").disabled = true; // Désactivez le bouton pour éviter les doubles soumissions
      $("#loadingModal").modal('show'); // Affiche le popup de chargement

      $.ajax({
        url: "{{ route('storejustification') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            fetchAlldja();
            toastr.success("DJA ajouté avec succès !", "success");
            $("#djaModale").modal('hide');
          } else if (response.status == 201) {
            toastr.error("Attention: DJA fonction existe déjà !", "info");
            $("#djaModale").modal('show');
            document.getElementById("addjustifierbtn").disabled = false; // Réactive le bouton
          } else if (response.status == 202) {
            toastr.error("Erreur d'execution, verifier votre internet", "error");
            $("#djaModale").modal('show');

            document.getElementById("addjustifierbtn").disabled = false; // Réactive le bouton
          } else if (response.status == 203) {
            toastr.error("Erreur d'exécution : " + response.error, "error");
            $("#djaModale").modal('show');
            document.getElementById("addjustifierbtn").disabled = false; // Réactive le bouton
          }

          $("#addjustifierbtn").html('Sauvegarder'); // Réinitialise le texte du bouton
          document.getElementById("djaModale").disabled = false; // Réactive le bouton
          $("#loadingModal").modal('hide');
          setTimeout(function() {
            $("#loadingModal").modal('hide');
          }, 600); // 600 millisecondes = 0.6 secondes
        },
        error: function(xhr, status, error) {
          toastr.error("Une erreur s'est produite : " + error, "error");
          $("#addjustifierbtn").html('Sauvegarder'); // Réinitialise le texte du bouton
          document.getElementById("addjustifierbtn").disabled = false; // Réactive le bouton
          $("#loadingModal").modal('hide');
        }
      });
    });


    $(document).on('click', '.deleteIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "DJA est sur le point d'être DÉTRUITE ! Faut-il vraiment exécuter « la Suppression » ?  ",

        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer !',
        cancelButtonText: 'Annuller'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('deletedja') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {
              console.log(response);
              toastr.success("DJA supprimer avec succès !", "Suppression");
              fetchAlldja();
            }
          });
        }
      })
    });


    $(document).on('click', '.voirdja', function(e) {
      e.preventDefault(); // Empêcher le comportement par défaut du lien
      var febrefs = $(this).attr('id'); // Utilisez attr() pour obtenir l'ID du lien
      $.ajax({
        type: 'get',
        url: "{{ route('getdjas') }}",
        data: {
          'id': febrefs
        },
        success: function(response) {
          $("#show_justificatif").html(response);
        },
        error: function(xhr, status, error) {
          var errorMessage = "Attention! \n Erreur de connexion à la base de données, \n veuillez vérifier votre connexion";
          if (xhr.responseJSON && xhr.responseJSON.error) {
            errorMessage = xhr.responseJSON.error;
          }
          toastr.error(errorMessage, "Erreur");
        }
      });
    });




    fetchAlldja();

    function fetchAlldja() {
      $.ajax({
        url: "{{ route('fetchdja') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all").html(reponse);
        }
      });
    }
  });
</script>

@endsection