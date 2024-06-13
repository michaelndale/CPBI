@extends('layout/app')
@section('page-content')

<style type="text/css">
  .has-error {
    border: 1px solid red;
  }
</style>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12" style="margin:auto">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="fas fa-car-crash"></i> GESTION DU CARNET DE BORD</h4>
          </div>
        </div>
      </div>

      <div class="col-xl-12">
        <div class="card">
          <div class="table-responsive">
            <table class="table table-bordered table-sm fs--1 mb-0">
              <thead>
                <tr style="background-color:#82E0AA">
                  <th class="align-middle ps-3 name">#</th>
                  <th>Véhicule</th>
                  <th>Date </th>
                  <th>Service </th>
                  <th>Initineraire</th>
                  <th>Object mission</th>
                  <th>Chef service</th>
                  <th>Projet</th>
                  <th>Index depart </th>
                  <th>INdex arrive</th>
                  <th>Créé par</th>
                  <th>Créé le</th>
                  <th>
                    <center>Actions</center>
                  </th>
                </tr>
              </thead>
              <tbody id="show_carnet">
                <tr>
                  <td colspan="13">
                    <h5 class="text-center text-secondery my-5">
                      @include('layout.partiels.load')
                  </td>
                </tr>
              </tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>

</div> <!-- container-fluid -->
</div>
</div>

@include('entretient.modale')



<script>
  $(function() {

    $('#entretientModal').modal({
      backdrop: 'static',
      keyboard: false
    });


    // Add Entretien
    $("#addEntretienForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#addentretientbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("addentretientbtn").disabled = true;

      $.ajax({
        url: "{{ route('storeEntretien') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status === 200) {
            show_carnet();

            toastr.success("Enregistrement réussi avec succès !", "Enregistrement");
            $("#addentretientbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#entretientModal").modal('hide');
            $("#addEntretienForm")[0].reset();

            document.getElementById("addentretientbtn").disabled = false;

          } else if (response.status === 400) {
            toastr.error("Erreur de validation : " + JSON.stringify(response.errors), "Erreur de validation");
            $("#addentretientbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("addentretientbtn").disabled = false;
          } else if (response.status === 500) {
            toastr.error("Erreur du serveur : " + response.error, "Erreur du serveur");
            $("#addentretientbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("addentretientbtn").disabled = false;
          } else if (response.status === 201) {
            toastr.error("Le véhicule avec cette matricule existe déjà !", "Erreur");
            $("#addentretientbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addEntretienForm").modal('show');
            document.getElementById("addentretientbtn").disabled = false;
          } else if (response.status === 202) {
            toastr.error("Erreur d'exécution, vérifiez votre internet", "Erreur");
            $("#addentretientbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("addentretientbtn").disabled = false;
          }
        },
        error: function(xhr, status, error) {
          toastr.error("Une erreur est survenue : " + error, "Erreur");
          $("#addentretientbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
          document.getElementById("addentretientbtn").disabled = false;
        }
      });
    });

    // Add Programme

    // Delete user ajax request
    $(document).on('click', '.deleteIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Vous ne pourrez pas revenir en arrière !",

        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui , Supprimer !'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('deleteEntretien') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {

              if (response.status == 200) {
                toastr.success("Suppression  avec succès !", "Suppression");

                show_carnet();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de supprimer ce type de véhicule!", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
            }
          });
        }
      })
    });



    show_carnet();

    function show_carnet() {
      $.ajax({
        url: "{{ route('all_carnet') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_carnet").html(reponse);
        }
      });
    }


  });
</script>

@endsection