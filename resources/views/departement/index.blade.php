@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-7" style="margin:auto">
                    <div class="card">
                        <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"
                            style="padding: 0.40rem 1rem;">
                            <h4 class="mb-sm-0"><i class="fa fa-university"></i> Departement</h4>
                            <div class="page-title-right">

                              <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau departement</a>
                            </div>
                        </div>

                      

                        <div class="card-body pt-0 pb-3">

                         
                            <div class="table-responsive">
                              <table class="table table-striped table-sm fs--1 mb-0">

                                <thead>
                                <tr >
                                  <th style="width:10%">#</th>
                                  <th>Libellé</th>
                                  <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody  id="show_all_department">
                                  <tr>
                                    <td colspan="3"><h5 class="text-center text-secondery my-5">
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

  {{-- new departement modal --}}

  <div class="modal fade" id="addDealModal" tabindex="-1" aria-labelledby="addDealModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <form method="POST" id="add_department_form">
        @method('post')
        @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouveau department </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg></button>
          </div>
          <div class="modal-body">
  
            <label class="text-1000 fw-bold mb-2">Libellé </label>
            <input class="form-control" name="title" type="text" placeholder="Entrer libellé"  required />
  
          </div>
          <div class="modal-footer">
            <button type="submit" name="sendDepartment" id="add_department"  class="btn btn-primary" type="button">Enregistrer</button>
          </div>
          </form>
      </div>
    </div>
  </div>
  
  {{-- Fin fonction --}}
                            
  
  
  {{-- Edit fonction modal --}}
  
  <div class="modal fade" id="edit_DepatmentModal" tabindex="-1" aria-labelledby="edit_departmentModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <form method="POST" id="edit_department_form">
        @method('post')
        @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="verticallyCenteredModalLabel">Modification departement </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg></button>
          </div>
          <div class="modal-body">
  
            <label class="text-1000 fw-bold mb-2">Libellé </label>
              <input type="hidden" name="dep_id" id="dep_id">
              <input class="form-control" name="dep_title" id="dep_title" type="text" placeholder="Entrer function" name="nom_fonction" required />
                  
          </div>
          <div class="modal-footer">
            <button type="submit"  id="edit_departement_btn"  class="btn btn-primary" type="button">Modifier</button>
          </div>
          </form>
      </div>
    </div>
  </div>
  {{-- Fin modifier departement  --}}
  
  
  
    <script>
  
  
  
      $(function() {
        // 
        $('#addDealModal').modal({
          backdrop: 'static',
          keyboard: false
        });
  
        // Add department ajax 
        $("#add_department_form").submit(function(e) 
        {
          e.preventDefault();
          const fd = new FormData(this);
          $("#add_department").text('Ajouter...');
          $.ajax({
            url: "{{ route('storeDp') }}",
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) 
            {
             
              if (response.status == 200) {
                toastr.success("Departement ajouté avec succès !", "success");
                fetchAlldepartment();
                $("#add_department_form")[0].reset();
                $("#addDealModal").modal('hide');
              }
              if (response.status == 201) {
                toastr.info("Attention: Libellé departement existe déjà !", "info");
                $("#addDealModal").modal('show');
              }
  
              if (response.status == 202) {
                toastr.error("Erreur d'execution, verifier votre internet", "error");
                $("#addDealModal").modal('show');
              }
  
              $("#add_department").text('Enregitrer');
            }
          });
        });
  
        // Edit fonction ajax request
        $(document).on('click', '.editIcon', function(e) {
          e.preventDefault();
          let id = $(this).attr('id');
          $.ajax({
            url: "{{ route('editDp') }}",
            method: 'get',
            data: {
              id: id,
              _token: '{{ csrf_token() }}'
            },
            success: function(response) {
              $("#dep_title").val(response.title);
              $("#dep_id").val(response.id);
            }
          });
        });
  
        // update function ajax request
        $("#edit_department_form").submit(function(e) 
        {
          e.preventDefault();
          const fd = new FormData(this);
          $("#edit_departement_btn").text('Mise à jour...');
          $.ajax({
            url:"{{ route('updateDp') }}",
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              if (response.status == 200) {
                toastr.success("Mise à jour  avec succès !", "success");
                fetchAlldepartment();
                $("#edit_department_form")[0].reset();
                $("#edit_DepatmentModal").modal('hide');
              }
              if (response.status == 201) {
                toastr.info("Attention: Libellé fonction existe déjà !", "info");
                $("#edit_DepatmentModal").modal('hide');
              }
  
              if (response.status == 202) {
                toastr.error("Erreur d'execution, verifier votre internet", "error");
                $("#edit_DepatmentModal").modal('show');
              }
  
              $("#edit_departement_btn").text('Modifier');
            }
          });
        });
  
        // Delete department ajax request
        $(document).on('click', '.deleteIcon', function(e) 
        {
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
                url: "{{ route('deleteDp') }}",
                method: 'delete',
                data: {
                  id: id,
                  _token: csrf
                },
                success: function(response) {
                  console.log(response);
                  toastr.info("Departement supprimer avec succès !", "success");
                  fetchAlldepartment();
                }
              });
            }
          })
        });
        
        fetchAlldepartment();
        function fetchAlldepartment() 
        {
          $.ajax({
            url: "{{ route('fetchAllDep') }}",
            method: 'get',
            success: function(reponse) {
              $("#show_all_department").html(reponse);
            }
          });
        }
      });
    </script>
  
   
    @endsection


