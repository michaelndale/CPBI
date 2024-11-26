@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
      <div class="row">
          <div class="col-xl-7" style="margin:auto">
              <div class="card">
                  <div class="card-header">
                      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                          <h4 class="mb-sm-0"><i class="fa fa-folder"></i> Listes des Dossier </h4>
                          <div class="page-title-right">
                            <a href="javascript:voide();"  class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addDealModal"
                            aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i
                                class="fa fa-plus-circle"></i> Nouveau </a>
                           </a>
                           
                          </div>
                      </div>
                  </div>
                  <div class="card-body pt-0 pb-3">
                      <div id="overview-chart" data-colors='["#1f58c7"]' class="apex-charts" dir="ltr"></div>
                      <div class="table-responsive">
                         

                          <table class="table table-striped table-sm fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th> <b>Libellé</b></th>
                                    <th> <center><b>Action</b></center></th>
                                </tr>
                            </thead>
                            <tbody id="show_all_folder">
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
      </div>
  </div>
</div>



    {{-- new department modal --}}
    <div class="modal fade" id="addDealModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="add_folder_form" autocomplete="off">
                @method('post')
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-folder-plus"></i> Nouvelle dossier
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="text-1000 fw-bold mb-2">Titre</label>
                        <input class="form-control" name="ftitle" id="ftitle" type="text"
                            placeholder="Entrer le titre" required />
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="sendFolder" id="sendFolder" value="Sauvegarder"
                            class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit dossier modal --}}
    <div class="modal fade" id="editFolderModal" tabindex="-1" aria-labelledby="editFolderModal" aria-hidden="true">
        <div class="modal-dialog">
            <form autocomplete="off" id="edit_folder_form">
                @method('post')
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-folder-plus"></i> Modification
                            dossier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="text-1000 fw-bold mb-2">Titre</label>
                        <input type="hidden" name="fid" id="fid">
                        <input class="form-control" name="flibelle" id="flibelle" type="text"
                            placeholder="Entrer dossier" required />

                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="editfolderbtn" id="editfolderbtn" value="Sauvegarder"
                            class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(function() {
            // Add department ajax 
            $("#add_folder_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);

                $("#sendFolder").html('<i class="fas fa-spinner fa-spin"></i>');
                document.getElementById("sendFolder").disabled = true;

                $.ajax({
                    url: "{{ route('storefl') }}",
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            toastr.success("Dossier enregistrer avec succès!",
                                "Enregistrement");
                            fetchAlldfolder();

                            $("#sendFolder").html(
                                '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            $("#add_folder_form")[0].reset();
                            $("#addDealModal").modal('hide');
                            document.getElementById("sendFolder").disabled = false;
                        }

                        if (response.status == 201) {
                            toastr.error("Le titre du dossier existe déjà !", "Erreur");
                            $("#add_folder").text('Sauvegarder');
                            $("#addDealModal").modal('show');
                            document.getElementById("sendFolder").disabled = false;
                        }
                    }



                });
            });

            // Edit folder ajax request
            $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('editfl') }}",
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $("#flibelle").val(response.title);
                        $("#fid").val(response.id);
                    }
                });
            });

            // update function ajax request
            $("#edit_folder_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);

                $("#editfolderbtn").html('<i class="fas fa-spinner fa-spin"></i>');
                document.getElementById("editfolderbtn").disabled = true;

                $.ajax({
                    url: "{{ route('updatefl') }}",
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            toastr.success("Dossier modifier avec succès !", "Modification");
                            fetchAlldfolder();

                            $("#editfolderbtn").html(
                                '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            $("#edit_folder_form")[0].reset();
                            $("#editFolderModal").modal('hide');
                            document.getElementById("editfolderbtn").disabled = false;
                        }

                        if (response.status == 201) {
                            toastr.error("Le titre du dossier existe déjà !", "Erreur");
                            $("#editfolderbtn").html(
                                '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            document.getElementById("editfolderbtn").disabled = false;
                        }

                        if (response.status == 205) {
                            toastr.error(
                                "Vous n'avez pas l'accreditation de Modifier ce dossier!",
                                "Erreur");

                            $("#editfolderbtn").html(
                                '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            document.getElementById("editfolderbtn").disabled = false;
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
                            url: "{{ route('deletefl') }}",
                            method: 'delete',
                            data: {
                                id: id,
                                _token: csrf
                            },
                            success: function(response) {


                                if (response.status == 200) {
                                    toastr.success("Dossier supprimer avec succès !",
                                        "Suppression");
                                    fetchAlldfolder();
                                }

                                if (response.status == 205) {
                                    toastr.error(
                                        "Vous n'avez pas l'accreditation de supprimer ce dossier!",
                                        "Erreur");
                                }

                                if (response.status == 202) {
                                    toastr.error("Erreur d'execution !", "Erreur");
                                }
                            }
                        });
                    }
                })
            });

            fetchAlldfolder();

            function fetchAlldfolder() {
                $.ajax({
                    url: "{{ route('fetchAllfl') }}",
                    method: 'get',
                    success: function(reponse) {
                        $("#show_all_folder").html(reponse);
                    }
                });
            }
        });
    </script>
@endsection


