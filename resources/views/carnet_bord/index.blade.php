@extends('layout/app')
@section('page-content')

<style type="text/css">
  .has-error {
    border: 1px solid red;
  }
</style>

<div class="main-content">
  <div class="page-content">
    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">
      <div class="card-header p-4 border-bottom border-300 bg-soft">
        <div class="row g-3 justify-content-between align-items-end">
          <div class="col-12 col-md">
            <h6 class="text-900 mb-0" data-anchor="data-anchor"><i class="fas fa-car-crash"></i> GESTION DU CARNET DE BORD </h6>
          </div>
          <div class="col col-md-auto">
            <a href="#" id="fetchDataLink"> <i class="fas fa-sync-alt"></i> Actualiser</a>
            <a href="javascript::;" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fa fa-plus-circle"></span> Nouvel fiche FEB</a>
          </div>
        </div>
      </div>
      <div class="card-body p-0">
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
                <th>Index arrive</th>
                <th>Kilometrage</th>
                <th>Carburent littre</th>
                <th>Créé par</th>
                <th>Créé le</th>
                <th>
                  <center>Actions</center>
                </th>
              </tr>
            </thead>
            <tbody id="show_carnet">
              <tr>
                <td colspan="15">
                  <h5 class="text-center text-secondery my-5">
                    @include('layout.partiels.load')
                </td>
              </tr>
            </tbody>

          </table>

          <br><br><br><br>
        </div>
      </div>
    </div>

  </div>
</div>

</div> <!-- container-fluid -->
</div>
</div>

@include('carnet_bord.modale')



<script>
  $(function() {

    $('#addDealModal').modal({
      backdrop: 'static',
      keyboard: false
    });


    $("#addform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#btnsave").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("btnsave").disabled = true;

      $.ajax({
        url: "{{ route('storeCarnet') }}",
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
            $("#btnsave").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addDealModal").modal('hide');
            $("#addform")[0].reset();

            document.getElementById("btnsave").disabled = false;

          } else if (response.status === 400) {
            toastr.error("Erreur de validation : " + JSON.stringify(response.errors), "Erreur de validation");
            $("#btnsave").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("btnsave").disabled = false;
          } else if (response.status === 500) {
            toastr.error("Erreur du serveur : " + response.error, "Erreur du serveur");
            $("#btnsave").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("btnsave").disabled = false;
          } else if (response.status === 201) {
            toastr.error("Le véhicule avec cette matricule existe déjà !", "Erreur");
            $("#btnsave").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addform").modal('show');
            document.getElementById("btnsave").disabled = false;
          } else if (response.status === 202) {
            toastr.error("Erreur d'exécution, vérifiez votre internet", "Erreur");
            $("#btnsave").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("btnsave").disabled = false;
          }
        },
        error: function(xhr, status, error) {
          toastr.error("Une erreur est survenue : " + error, "Erreur");
          $("#btnsave").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
          document.getElementById("btnsave").disabled = false;
        }
      });
    });

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
            url: "{{ route('delete_carnet') }}",
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
                toastr.error("Vous n'avez pas l'accreditation de supprimer !", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
            }
          });
        }
      })
    });

    $(document).on('click', '.editIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('showCarnet') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#cprojetid").val(response.projetid);
          $("#cituneraire").val(response.itineraire);
          $("#cobject").val(response.objectmission);
          $("#cdatejour").val(response.datejour);
          $("#ckilometrage").val(response.kms_parcourus);
          $("#ccarburant").val(response.carburant_littre);
          $("#cindexdepart").val(response.index_depart);
          $("#cindexretour").val(response.index_retour);
          $("#cservice").val(response.service_id);
          $("#cvehicule").val(response.numero_plaque);
          $("#cchefmission").val(response.chefmission);
          $("#idc").val(response.id);
        }
      });
    });

    $("#Editform").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);

            $("#cbtnsave").html('<i class="fas fa-spinner fa-spin"></i>');
            document.getElementById("cbtnsave").disabled = true;

            $.ajax({
                url: "{{ route('updateCarnet') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        toastr.success("Carnet de bord modifier avec succès !", "Modification");
                        show_carnet();
                        $("#cbtnsave").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        $("#EditDealModal").modal('hide');
                        document.getElementById("cbtnsave").disabled = false;

                    }

                    if (response.status == 201) {
                        $("#EditDealModal").modal('show');
                        toastr.error("Le titre du dossier existe déjà !", "Erreur");
                        document.getElementById("cbtnsave").disabled = false;
                        $("#cbtnsave").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                    }

                    if (response.status == 205) {
                        $("#EditDealModal").modal('show');
                        toastr.error("Vous n'avez pas l'accreditation de Modifier!", "Erreur");
                        document.getElementById("cbtnsave").disabled = false;
                        $("#cbtnsave").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                    }

                }
            });
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