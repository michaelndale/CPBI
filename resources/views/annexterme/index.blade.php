@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-10" style="margin:auto">
                    <div class="card">
                      <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0"><i class="fa fa-folder"></i> Annex terme de reference</h4>
                                <div class="page-title-right">
                                        <a href="javascript::;" type="button"  class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" data-bs-toggle="modal" data-bs-target="#addModal"  aria-haspopup="true" aria-expanded="false">
                                          <i class="fa fa-plus-circle"></i> Créer </a>
                                    </a>
                                </div>
                            
                        </div>
                        <div class="card-body pt-0 pb-3">
                            <div id="overview-chart" data-colors='["#1f58c7"]' class="apex-charts" dir="ltr"></div>
                            <div class="table-responsive">

                                <table class="table table-striped table-sm fs--1 mb-0">
                                  <thead>
                                    <tr>
                                      <th><b>#</b></th>
                                      <th><b>Abreviation</b></th>
                                      <th><b>Description</b></th>
                                      <th><b>Créé par</b></th>
                                      <th><b>Créé le</b></th>
                                      <th><b>Actions</b></th>
                                    </tr>
                                  </thead>
                                  <tbody id="show_all">
                                    <tr>
                                      <td colspan="6">
                                        <h5 class="text-center text-secondery my-5">
                                          @include('layout.partiels.load')
                                      </td>
                                    </tr>
                                  </tbody>
                                   
                                
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <form method="POST" id="addform">
                @method('post')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addDealModalTitle"><i class="fa fa-plus-circle"></i> Nouvelle annex terme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <label class="text-1000 fw-bold mb-2">Abreviation</label>
                  <input class="form-control" id="abreviation" name="abreviation" type="text" placeholder="Entrer abreviation" required /> <br>
                
                  <label class="text-1000 fw-bold mb-2">Nom </label>
                  <input class="form-control" id="libelle" name="libelle" type="text" placeholder="Entrer nom" required /> <br>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" name="add" id="add" class="btn btn-primary waves-effect waves-light"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                </div>

              </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <form method="POST" id="editform">
              @method('post')
              @csrf
              <div class="modal-header">
                  <h5 class="modal-title" id="addDealModalTitle"><i class="fa fa-edit"></i> Modification  terme de refference</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <label class="text-1000 fw-bold mb-2">Abreviation</label>
                <input class="form-control" id="a_id" name="a_id" type="hidden" placeholder="Entrer abreviation" required /> <br>
                <input class="form-control" id="a_abreviation" name="a_abreviation" type="text" placeholder="Entrer abreviation" required /> <br>
              
                <label class="text-1000 fw-bold mb-2">Nom </label>
                <input class="form-control" id="a_libelle" name="a_libelle" type="text" placeholder="Entrer nom" required /> <br>
                  
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                  <button type="submit" name="editbtn" id="editbtn" class="btn btn-primary waves-effect waves-light"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
              </div>

            </form>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div>

    <script>
      $(function() {
        // Add profil ajax 
        $("#addform").submit(function(e) {
          e.preventDefault();
          const fd = new FormData(this);
    
          $("#add").html('<i class="fas fa-spinner fa-spin"></i>');
          document.getElementById("add").disabled = true;
    
    
          $.ajax({
            url: "{{ route('storeabr') }}",
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
    
              if (response.status == 200) {
                toastr.success("Abreviation enregistrer avec succès!", "Enregistrement");
               fetchAllabre();
                $("#addform")[0].reset();
                $("#addModal").modal('hide');
                document.getElementById("add").disabled = false;
                $("#add").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
              }
              if (response.status == 201) {
                toastr.error("Attention: Libellé abreviation existe déjà !", "info");
                $("#addModal").modal('hide');
                $("#add").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
    
                document.getElementById("add").disabled = false;
              }
    
              if (response.status == 202) {
                toastr.error("Le banque  existe déjà !", "Erreur");
                $("#addModal").modal('show');
                $("#add").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                document.getElementById("add").disabled = false;
              }
    
            }
          });
        });
    
        // Edit profil ajax request
        $(document).on('click', '.editIcon', function(e) {
          e.preventDefault();
          let id = $(this).attr('id');
          $.ajax({
            url: "{{ route('ediabr') }}",
            method: 'get',
            data: {
              id: id,
              _token: '{{ csrf_token() }}'
            },
            success: function(response) {

              $("#a_id").val(response.id);
              $("#a_libelle").val(response.libelle);
              $("#a_abreviation").val(response.abreviation);
            }
          });
        });
    
        $("#editform").submit(function(e) {
          e.preventDefault();
          const fd = new FormData(this);
        
          $("#editbtn").html('<i class="fas fa-spinner fa-spin"></i>');
          document.getElementById("editbtn").disabled = true;
    
          $.ajax({
            url: "{{ route('updateabr') }}",
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              if (response.status == 200) {
                  toastr.success("Terme de refference modifier avec succès !", "Modification");
                 fetchAllabre();
               
                  $("#editbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                  $("#editform")[0].reset();
                  $("#editModal").modal('hide');
                  document.getElementById("editbtn").disabled = false;
              }
    
              if (response.status == 201) {
                  toastr.error("Le titre du terme de refference !", "Erreur");
                  $("#editbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                  document.getElementById("editbtn").disabled = false;
              }
    
              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de Modifier le terme de refference!", "Erreur");
    
                $("#editbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                document.getElementById("editbtn").disabled = false;
              }
    
            }
          });
        });
    
      
    
        // Delete classeur ajax request'
    
        $(document).on('click', '.deleteIcon', function(e) {
          e.preventDefault();
          let id = $(this).attr('id');
          let csrf = '{{ csrf_token() }}';
          Swal.fire({
            title: 'Êtes vous sûr de vouloir supprimer?',
            text: "Si vous le faite vous ne pouvez plus revenir en arrière !",
    
            showCancelButton: true,
            confirmButtonColor: 'Green',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, Supprimer!',
            cancelButtonText: 'Annuler',
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: "{{ route('deleteabr') }}",
                method: 'delete',
                data: {
                  id: id,
                  _token: csrf
                },
                success: function(response) {
    
    
                  if (response.status == 200) {
                    toastr.success("Abreviation supprimer avec succès !", "Suppression");
                   fetchAllabre();
                  }
    
                  if (response.status == 205) {
                    toastr.error("Vous n'avez pas l'accreditation de supprimer ce abreviation!", "Erreur");
                  }
    
                  if (response.status == 202) {
                    toastr.error("Erreur d'execution !", "Erreur");
                  }
                }
              });
            }
          })
        });
    
       
    
       fetchAllabre();
    
        function fetchAllabre() {
          $.ajax({
            url: "{{ route('fetchAllabre') }}",
            method: 'get',
            success: function(reponse) {
              $("#show_all").html(reponse);
            }
          });
        }
      });
    </script>



@endsection
