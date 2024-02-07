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
            <h4 class="mb-sm-0"><i class="fa fa-folder-open"></i> Activite par projet </h4>

            <div class="page-title-right">
            <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addModale" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouvelle activité</a>

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
                  <th>#</th>
                  <th>Description detaillee des besoins</th>
                  <th>Année</th>
                  <th>Montant</th>
                  <th>Etat de l'activité</th>
                  
                  <th> Date</th>
                  <th class="sort border-top" >ACTION</th>
                  </tr>
             
                </thead>
                <tbody id="show_all_activite">
                  <tr>
                    <td colspan="8">
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

  @include('activite.modale')

<script>
    $(function() {

      $('#addModale').modal({
        backdrop: 'static',
        keyboard: false
      });


      // Add user ajax 
      $("#addactiviteForm").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#addactivitebtn").text('Ajouter...');
        $.ajax({
          url: "{{ route('storeact') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) 
            {
              fetchActivite();
              
              toastr.success("Activité ajouté avec succès !", "success");

              $("#addactivitebtn").text('Enregistrement');
              $("#addModale").modal('hide');
              $("#addactiviteForm")[0].reset();
            }
           
            if (response.status == 202) {
              toastr.info("Erreur d'execution, verifier votre internet", "error");
              $("#addModale").modal('show');
              $("#addactivitebtn").text('Enregitrer');
            }
           
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
          text: "Une activité est sur le point d'être DÉTRUITE ! Faut-il vraiment exécuter « la Suppression » ? !",
     
          showCancelButton: true,
          confirmButtonColor: 'green',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Oui , Supprimer !'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "{{ route('deleteact') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                toastr.error("Activité supprimer avec succès !", "success");
                fetchActivite();
              }
            });
          }
        })
      });

      fetchActivite();
      function fetchActivite() {
        $.ajax({
          url: "{{ route('fetchActivite') }}",
          method: 'get',
          success: function(reponse) {
            $("#show_all_activite").html(reponse);
          }
        });
      }
    });
  </script>

@endsection



























