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
            <h4 class="mb-sm-0"><i class="fa fa-car"></i> Vehicule </h4>

            <div class="page-title-right">
            <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addVehiculeModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau véhicule</a>

            </div>

          </div>
        </div>
      </div>
     
      <div class="row">
        <div class="col-lg-12" style="margin:auto">
          <div class="card">
            <div class="table-responsive">
              <table class="table table-bordered mb-0">
                <thead>
                 
                  <tr style="background-color:#82E0AA">
                  <th class="align-middle ps-3 name">#</th>
                  <th >Blaque</th>
                  <th >Marque</th>
                  <th >Modèle</th>
                  <th >N<sup>o</sup> Série</th>
                  <th >Couleur</th>
                  <th >Type</th>
                  <th >Carburent</th>
                  <th >Statut</th>
                  <th >Date</th>
              
              
                  <th ><center>Action</center></th>
                  </tr>
             
                </thead>
                <tbody id="show_all_vehicule">
                  <tr>
                    <td colspan="11">
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
    </div> <!-- container-fluid -->
  </div>
</div>

@include('vehicule.modale')

<script>
    $(function() {

      $('#addVehiculeModal').modal({
        backdrop: 'static',
        keyboard: false
      });


      // Add user ajax 
      $("#addform").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#addbtn").text('Ajouter...');
        $.ajax({
          url: "{{ route('storevl') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) 
            {
              fetchAllvehicule();
              $.notify("Véhicule ajouté avec succès !", "success");
              $("#addbtn").text('Enregistrement');
              $("#matricule_error").text("");
              $('#matricule').addClass('');
              $("#addVehiculeModal").modal('hide');
              $("#addform")[0].reset();
              
            }

            if (response.status == 201) 
            {
              $.notify("Le véhicule avec cette matricule existe déjà !", "error");
              $("#addbtn").text('Enregistrement');
              $("#addVehiculeModal").modal('show');
              $("#matricule_error").text("Matricule existe déjà !");
              $('#matricule').addClass('has-error');
            }

            if (response.status == 202) {
              $.notify("Erreur d'execution, verifier votre internet", "error");
              $("#addVehiculeModal").modal('show');
              $("#addbtn").text('Enregitrer');
            }
           
          }
        });
      });

      // Edit user ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: "{{ route('editUs') }}",
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#fun_title").val(response.title);
            $("#fun_id").val(response.id);
          }
        });
      });

      // update user ajax request
      $("#edit_function_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_function_btn").text('Mises ajours...');
        $.ajax({
          url: "{{ route('updateUs') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              $.notify("Function update Successfully !", "success");
              fetchAllvehicule();
              
            }
            $("#edit_function_btn").text('Update function');
            $("#edit_function_form")[0].reset();
            $("#edit_functionModal").modal('hide');
          }
        });
      });

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
              url: "{{ route('deletevl') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                $.notify("Vehicuke supprimer avec succès !", "success");
                fetchAllvehicule();
              }
            });
          }
        })
      });

      fetchAllvehicule();
      function fetchAllvehicule() {
        $.ajax({
          url: "{{ route('fetchAllvl') }}",
          method: 'get',
          success: function(reponse) {
            $("#show_all_vehicule").html(reponse);
          }
        });
      }
    });
  </script>

@endsection
