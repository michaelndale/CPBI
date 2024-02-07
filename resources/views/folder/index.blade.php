@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-6" style="margin:auto">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="fa fa-users"></i> Classeur</h4>

            <div class="page-title-right">
            <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent" > <i class="fa fa-plus-circle"></i> Nouveau </a>

            </div>

          </div>
        </div>
      </div>
     
      <div class="row">
        <div class="col-lg-6" style="margin:auto">
          <div class="card">
            <div class="table-responsive">
              <table class="table table-bordered mb-0">
                <thead>
                 
                  <tr style="background-color:#82E0AA">
                  <th style="width:5%"></th>
                  <th >Libelle</th>
                  
                  <th style="width:25%"><center>Action</center></th>

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
    </div> <!-- container-fluid -->
  </div>
</div>


  {{-- new department modal --}}
  <div class="modal fade" id="addDealModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDealModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-100 p-4">
        <form method="POST" id="add_folder_form">
          @method('post')
          @csrf
          <div class="modal-header border-0 p-0 mb-2">
            <h3 class="mb-0">Ajouter classeur dossier</h3><button class="btn btn-sm btn-phoenix-secondary" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times text-danger"></span></button>
          </div>
          <div class="modal-body px-0">
            <div class="row g-3">
              <div class="col-lg-12">
                <div class="mb-4">
                  <label class="text-1000 fw-bold mb-2">Titre</label>
                  <input class="form-control" name="ftitle" id="ftitle" type="text" placeholder="Entrer le titre"  required />
                 
                </div>
                <div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer border-0 pt-6 px-0 pb-0">
         
            <input type="submit" name="sendFolder" id="add_service" value="Sauvegarder" class="btn btn-primary my-0" />
          </div>
        </form>
      </div>
    </div>
  </div>


  {{-- Edit function modal --}}

  <div class="modal fade " id="edit_FolderModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="edit_FolderModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-100 p-4">
        <form method="POST" id="edit_folder_form">
          @method('post')
          @csrf
          <div class="modal-header border-0 p-0 mb-2">
            <h3 class="mb-0">Edit Folder</h3><button class="btn btn-sm btn-phoenix-secondary" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times text-danger"></span></button>
          </div>
          <div class="modal-body px-0">
            <div class="row g-3">
              <div class="col-lg-12">
                <div class="mb-4">
                  <label class="text-1000 fw-bold mb-2">Title</label>
                  <input type="hidden" name="fid" id="fid">
                  <input class="form-control" name="flibelle" id="flibelle" type="text" placeholder="Entrer folder"  required />
                
                </div>
         
              </div>
            </div>
          </div>
          <div class="modal-footer border-0 pt-6 px-0 pb-0">
            <button type="button" class="btn btn-danger px-3 my-0" data-bs-dismiss="modal" aria-label="Close"> Cancel </button>
            <button type="submit"  id="edit_folder_btn" class="btn btn-primary my-0"> Update folder </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    $(function() {
      // Add department ajax 
      $("#add_folder_form").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_folder").text('Adding...');
        $.ajax({
          url: "{{ route('storefl') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) 
          {
            if (response.status == 200) {
              toastr.success("Dossier enregistrer avec success!", "Enregistrement");
              fetchAlldfolder();
            }
            $("#add_folder").text('Add folder');
            $("#add_folder_form")[0].reset();
            $("#addDealModal").modal('hide');
          }
        });
      });

      // Edit fonction ajax request
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
          success: function(response) 
          {
            $("#flibelle").val(response.flibelle);
            $("#fid").val(response.id);
          }
        });
      });

      // update function ajax request
      $("#edit_folder_form").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_folder_btn").text('Mises encours...');
        $.ajax({
          url:"{{ route('updatefl') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) 
            {
              toastr.success("Dossier enregistrer avec succees !", "Modification");
              fetchAlldfolder();
            }
            $("#edit_folder_btn").text('Update folder');
            $("#edit_FolderModal").modal('hide');
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
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
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
                console.log(response);
                toastr.success("Folder deleted Successfully !", "success");
                fetchAlldfolder();
              }
            });
          }
        })
      });

      fetchAlldfolder();
      function fetchAlldfolder() 
      {
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