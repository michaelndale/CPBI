@extends('layout/app')
@section('page-content')



      <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-7" style="margin:auto">
                    <div class="card">
                        <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"
                            style="padding: 0.40rem 1rem;">
                            <h4 class="mb-sm-0"><i class="fa fa-university"></i> Fonction</h4>
                            <div class="page-title-right">
                                
                                <a href="javascript::;" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#add_functionModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouvelle Fonction</a>
                            </div>
                        </div>




                        <div class="card-body pt-0 pb-3">


            <div class="table-responsive">
              <table class="table table-striped table-sm fs--1 mb-0">
                <thead>
                  <tr>
                    <th style="width:10%">#</th>
                    <th>Titre</th>
                    <th><center>Action</center></th>
                  </tr>
                </thead>
                <tbody id="show_all_function">
                  <tr>
                    <td colspan="3">
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
  <!-- End Page-content -->

  {{-- new fonction modal --}}

  <div class="modal fade" id="add_functionModal" tabindex="-1" aria-labelledby="add_functionModal"" style=" display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form method="POST" id="add_function_form">
          @method('post')
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouveau fonction </h5>
            
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <label class="text-1000 fw-bold mb-2">Libellé </label>
            <input class="form-control" name="title" type="text" placeholder="Entrer libellé" required />

          </div>
          <div class="modal-footer">
            <button type="submit" name="sendfonction" id="add_function" class="btn btn-primary" type="button">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Fin fonction --}}



  {{-- Edit fonction modal --}}

  <div class="modal fade" id="edit_functionModal" tabindex="-1" aria-labelledby="edit_functionModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form method="POST" id="edit_function_form">
          @method('post')
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="verticallyCenteredModalLabel">Modification fonction </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <label class="text-1000 fw-bold mb-2">Libellé </label>
            <input type="hidden" name="fun_id" id="fun_id">
            <input class="form-control" name="fun_title" id="fun_title" type="text" placeholder="Entrer function" name="nom_fonction" required />

          </div>
          <div class="modal-footer">
            <button type="submit" id="edit_function_btn" class="btn btn-primary" type="button">Modifier</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  {{-- Fin modifier fonction  --}}





  <script>
    $(function() {
      // Add function ajax 
      $("#add_function_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_function").text('Ajouter...');
        $.ajax({
          url: "{{ route('store') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {

            if (response.status == 200) {
              toastr.success("Fonction ajouté avec succès !", "Enregistrement");
              fetchAllfunction();
              $("#add_function_form")[0].reset();
              $("#add_functionModal").modal('hide');
            }
            if (response.status == 201) {
              toastr.info("Attention: Libellé fonction existe déjà !", "info");
              $("#add_functionModal").modal('show');
            }

            if (response.status == 202) {
              toastr.error("Erreur d'execution, verifier votre internet", "Error");
              $("#add_functionModal").modal('show');
            }

            $("#add_function").text('Enregitrer');

          }
        });
      });

      // Edit fonction ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: "{{ route('editF') }}",
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

      // update function ajax request
      $("#edit_function_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_function_btn").text('Mise à jour...');
        $.ajax({
          url: "{{ route('updateFon') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {

            if (response.status == 200) {
              toastr.success("Mise à jour  avec succès !", "success");
              fetchAllfunction();
              $("#edit_function_form")[0].reset();
              $("#edit_functionModal").modal('hide');
            }
            if (response.status == 201) {
              toastr.info("Attention: Libellé fonction existe déjà !", "info");
              $("#edit_functionModal").modal('hide');
            }

            if (response.status == 202) {
              toastr.error("Erreur d'execution, verifier votre internet", "error");
              $("#edit_functionModal").modal('show');
            }

            $("#edit_function_btn").text('Modifier');

          }
        });
      });

      // Delete fonction ajax request

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
          confirmButtonText: 'Oui, Supprimer !'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "{{ route('deleteFon') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                toastr.error("Fonction supprimer avec succès !", "success");
                fetchAllfunction();
              }
            });
          }
        })
      });




      fetchAllfunction();

      function fetchAllfunction() {
        $.ajax({
          url: "{{ route('fetchAll') }}",
          method: 'get',
          success: function(reponse) {
            $("#show_all_function").html(reponse);
          }
        });
      }
    });
  </script>


  @endsection