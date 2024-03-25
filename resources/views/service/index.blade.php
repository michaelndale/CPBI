@extends('layout/app')
@section('page-content')

<div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-6" style="margin:auto">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Service</h4>

                                    <div class="page-title-right">
                                    <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau service</a>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                       
        
        
                        <div class="row">
                            <div class="col-lg-6"style="margin:auto">
                                <div class="card">
                                  
                                         
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">
        
                                                <thead>
                                                        <tr style="background-color:#82E0AA">
                                                        <th style="width:10%">#</th>
                                                        <th>Libellé</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody  id="show_all_service">
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
              

  {{-- new service modal --}}

    <div class="modal fade" id="addDealModal" tabindex="-1" aria-labelledby="addDealModal"" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
          <form method="POST" id="add_service_form">
          @method('post')
          @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouveau service </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg></button>
            </div>
            <div class="modal-body">

              <label class="text-1000 fw-bold mb-2">Libellé </label>
              <input class="form-control" name="title" type="text" placeholder="Entrer libellé"  required />

            </div>
            <div class="modal-footer">
              <button type="submit" name="sendService" id="add_service" class="btn btn-primary" >Enregistrer</button>
            </div>
            </form>
        </div>
      </div>
    </div>

    {{-- Fin service --}}
                              


  {{-- Edit service modal --}}

  <div class="modal fade" id="edit_ServiceModal" tabindex="-1" aria-labelledby="edit_ServiceModal" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
          <form method="POST" id="edit_service_form">
          @method('post')
          @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="verticallyCenteredModalLabel">Modifier service </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg></button>
            </div>
            <div class="modal-body">

              <label class="text-1000 fw-bold mb-2">Libellé </label>
              <input type="hidden" name="ser_id" id="ser_id">
              <input class="form-control" name="ser_title" id="ser_title" type="text" placeholder="Entrer service"  required />
            </div>
            <div class="modal-footer">
              <button type="submit" name="ser_title" id="ser_title" class="btn btn-primary" type="button">Modifier</button>
            </div>
            </form>
        </div>
      </div>
    </div>
  {{-- Fin modifier service  --}}

  <script>
    $(function() {
      $('#addDealModal').modal({
        backdrop: 'static',
        keyboard: false
      });
      // Add department ajax 
      $("#add_service_form").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_service").text('Enregitrement encours...');
        $.ajax({
          url: "{{ route('storeSer') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) 
          {
            if (response.status == 200) {
              toastr.success('Service ajouté avec succès .', 'Enregitrement');
              fetchAlldservice();
              $("#add_service_form")[0].reset();
              $("#addDealModal").modal('hide');
            }
            if (response.status == 201) {
              
              toastr.info('Libellé service existe déjà .', 'Attention');
              $("#addDealModal").modal('show');
            }

            if (response.status == 202) {
             
              toastr.error('Erreur d\'execution, verifier votre internet', 'Erreur');
              $("#addDealModal").modal('show');
            }

            $("#add_service").text('Enregitrer');
           
          }
        });
      });

      // Edit fonction ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: "{{ route('editSer') }}",
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#ser_title").val(response.title);
            $("#ser_id").val(response.id);
          }
        });
      });



      // update function ajax request
      $("#edit_service_form").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_service_btn").text('Actualisation...');
        $.ajax({
          url:"{{ route('updateSer') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {

            if (response.status == 200) {
           
              toastr.success('Mises a jours fais avec succès  .', 'Enregitrement');
              fetchAlldservice();
              $("#edit_service_form")[0].reset();
              $("#edit_ServiceModal").modal('hide');
            }
            if (response.status == 201) {
              toastr.info("Aucune mises ajour apporter !", "Info");
              $("#edit_ServiceModal").modal('hide');
            }

            if (response.status == 202) {
              toastr.error("Erreur d'execution, verifier votre internet", "Error");
              $("#edit_ServiceModal").modal('show');
            }
           
          }
        });
      });

      // Delete service ajax request
      $(document).on('click', '.deleteIcon', function(e) 
      {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Êtes-vous sûr ?',
          text: "Vous ne pourrez plus revenir en arrière !",
        
          showCancelButton: true,
          confirmButtonColor: 'green',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Oui, Supprimer !'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "{{ route('deleteSer') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                $.notify("Service supprimer avec succès !", "success");
                fetchAlldservice();
              }
            });
          }
        })
      });

      fetchAlldservice();
      function fetchAlldservice() 
      {
        $.ajax({
          url: "{{ route('fetchAllSer') }}",
          method: 'get',
          success: function(reponse) {
            $("#show_all_service").html(reponse);
          }
        });
      }
    });
  </script>

  @endsection