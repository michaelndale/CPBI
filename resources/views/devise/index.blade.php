@extends('layout/app')
@section('page-content')

    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-7" style="margin:auto">
                    <div class="card">
                      <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">
                                <h4 class="mb-sm-0"><i class="fa fa-folder"></i> Listes des Devises </h4>
                                <div class="page-title-right">
                                    <a href="javascript:voide();" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> 
                                      <i class="fa fa-plus-circle"></i> Créer </a>
                                </div>
                          
                        </div>
                        <div class="card-body pt-0 pb-3">
                            <div id="overview-chart" data-colors='["#1f58c7"]' class="apex-charts" dir="ltr"></div>
                            <div class="table-responsive">

                                <table class="table table-striped table-sm fs--1 mb-0">
                                  <thead>
                                    <tr>
                                      <th style="width:5%"><b>#</b></th>
                                      <th><b>Libellé</b></th>
                                      <th><b>Pays</b></th>
                                      <th><b>Code</b></th>
                                      <th><b><center>Action</center></b></th>
                                    </tr>
                                  </thead>
                                  <tbody id="show_all_devise">
                                    <tr>
                                      <td colspan="5">
                                        <h5 class="text-center text-secondery my-5">
                                          @include('layout.partiels.load')
                                      </td>
                                    </tr>
                                  </tbody>
                                  </tbody>
                                </table>

                                <br><br> <br><br>  

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addDealModal" tabindex="-1" role="dialog" aria-labelledby="addDealModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="add_devise_form" autocomplete="off">
                  @method('post')
                  @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDealModalTitle"><i class="fa fa-plus-circle"></i>   Nouvelle devise</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-sm-12 col-md-12">
                          <label class="text-1000 fw-bold mb-2">Pays</label>
                          <input class="form-control" name="pays" id="pays" type="text" placeholder="Entrer le Pays" required />
                        </div>
            
                        <div class="col-sm-6 col-md-6">
                          <br>
                          <label class="text-1000 fw-bold mb-2">Devise</label>
                          <input class="form-control" name="devise" id="devise" type="text" placeholder="Entrer le devise" required />
                        </div>
            
                        <div class="col-sm-6 col-md-6">
                          <br>
                          <label class="text-1000 fw-bold mb-2">Code</label>
                          <input class="form-control" name="code" id="code" type="text" placeholder="Entrer le code" required />
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" name="add_devise" id="add_devise" class="btn btn-primary waves-effect waves-light"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="editdeviseModal" tabindex="-1" role="dialog" aria-labelledby="editdeviseTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="edit_folder_form" autocomplete="off">
                    @method('post')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDealModalTitle"><i class="fa fa-edit"></i> Modification dossier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="iddevise" id="iddevise">
          
                      <div class="row">
                        <div class="col-sm-12 col-md-12">
                          <label class="text-1000 fw-bold mb-2">Pays</label>
                          <input class="form-control" name="dpays" id="dpays" type="text" placeholder="Entrer le Pays" required />
                        </div>
            
                        <div class="col-sm-6 col-md-6">
                          <br>
                          <label class="text-1000 fw-bold mb-2">Devise</label>
                          <input class="form-control" name="ddevise" id="ddevise" type="text" placeholder="Entrer le devise" required />
                        </div>
            
                        <div class="col-sm-6 col-md-6">
                          <br>
                          <label class="text-1000 fw-bold mb-2">Code</label>
                          <input class="form-control" name="dcode" id="dcode" type="text" placeholder="Entrer le code" required />
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" name="editdevisebtn" id="editdevisebtn" value="Sauvegarder"
                         class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                       
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <script>
      $(function() {
        // Add devise ajax 
        $("#add_devise_form").submit(function(e) {
          e.preventDefault();
          const fd = new FormData(this);
    
          $("#add_devise").html('<i class="fas fa-spinner fa-spin"></i>');
          document.getElementById("add_devise").disabled = true;
    
          $.ajax({
            url: "{{ route('storedevise') }}",
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              if (response.status == 200) {
                toastr.success("Devise enregistrer avec succès !", "Enregistrement");
                fetchAllddevise();
    
                  $("#add_devise").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                  $("#add_devise_form")[0].reset();
                  $("#addDealModal").modal('hide');
                  document.getElementById("add_devise").disabled = false;
              }
    
              if (response.status == 201) {
                toastr.error("Le devise existe déjà !", "Erreur");
                $("#add_devise").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                $("#addDealModal").modal('show');
                document.getElementById("add_devise").disabled = false;
              }
            }
    
          });
        });
    
        // Edit folder ajax request
        $(document).on('click', '.editIcon', function(e) {
          e.preventDefault();
          let id = $(this).attr('id');
          $.ajax({
            url: "{{ route('editdevise') }}",
            method: 'get',
            data: {
              id: id,
              _token: '{{ csrf_token() }}'
            },
            success: function(response) {
              $("#dpays").val(response.pays);
              $("#dcode").val(response.code);
              $("#ddevise").val(response.libelle);
              $("#iddevise").val(response.id);
              
            }
          });
        });
        
    
        // update function ajax request
        $("#edit_devise_form").submit(function(e) {
          e.preventDefault();
          const fd = new FormData(this);
    
          $("#editdevisebtn").html('<i class="fas fa-spinner fa-spin"></i>');
          document.getElementById("editdevisebtn").disabled = true;
    
          $.ajax({
            url: "{{ route('updatedevise') }}",
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              if (response.status == 200) {
                toastr.success("Devise modifier avec succès !", "Modification");
                fetchAllddevise();
    
                $("#editdevisebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                $("#edit_devise_form")[0].reset();
                $("#editdeviseModal").modal('hide');
                document.getElementById("editdevisebtn").disabled = false;
    
              }
    
              if (response.status == 201) {
                toastr.error("Le devise existe déjà !", "Erreur");
                $("#editdevisebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                document.getElementById("editdevisebtn").disabled = false;
              }
    
              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de Modifier ce devise !", "Erreur");
                $("#editdevisebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                document.getElementById("editdevisebtn").disabled = false;
              }
    
            }
          });
        });
    
        // Delete service ajax request
        $(document).on('click', '.deleteIcon', function(e) {
          e.preventDefault();
          let id = $(this).attr('id');
          let csrf = '{{ csrf_token() }}';
          Swal.fire({
            title: 'Êtes vous sûr de vouloir supprimer définitivement ?',
            text: "Si vous le faite vous ne pouvez plus revenir en arrière !",
    
            showCancelButton: true,
            confirmButtonColor: 'Green',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, Supprimer!',
            cancelButtonText: 'Annuler',
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: "{{ route('deletedevise') }}",
                method: 'delete',
                data: {
                  id: id,
                  _token: csrf
                },
                success: function(response) {
    
                  if (response.status == 200) {
                    toastr.success("Devise supprimer avec succès !", "Suppression");
                    fetchAllddevise();
                  }
    
                  if (response.status == 205) {
                    toastr.error("Vous n'avez pas l'accreditation de supprimer ce devise !", "Erreur");
                  }
    
                  if (response.status == 202) {
                    toastr.error("Erreur d'execution !", "Erreur");
                  }
                }
              });
            }
          })
        });
    
        fetchAllddevise();
    
        function fetchAllddevise() {
          $.ajax({
            url: "{{ route('alldevise') }}",
            method: 'get',
            success: function(reponse) {
              $("#show_all_devise").html(reponse);
            }
          });
        }
      });
    </script>
    
@endsection
