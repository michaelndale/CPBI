@extends('layout/app')
@section('page-content')
<div class="content">
  <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style="width:50%; margin:auto">
    <div class="card-header p-4 border-bottom border-300 bg-soft">
      <div class="row g-3 justify-content-between align-items-end">
        <div class="col-12 col-md">
          <h4 class="text-900 mb-0" data-anchor="data-anchor"> <i class="fa fa-folder-open"></i> Folder </h4>

        </div>
        <div class="col col-md-auto">
          <button class="btn btn-sm btn-phoenix-secondary bg-white hover-bg-100 me-2" type="button" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Add folder</button>

        </div>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="collapse code-collapse" id="search-example-code">
      </div>
      <div class="p-4 code-to-copy">
        <div id="tableExample3" data-list='{"valueNames":["name","email"],"page":5,"pagination":true}'>
          <div class="search-box mb-3 mx-auto">
            <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input class="form-control search-input search form-control-sm" type="search" placeholder="Search" aria-label="Search" />
              <span class="fas fa-search search-box-icon"></span>
            </form>
          </div>
          <div class="table-responsive" id="show_all_folder">
            <h4 class="text-center text-secondery my-5"> Loading data ...</h4>

          </div>
          <div class="d-flex justify-content-between mt-3"><span class="d-none d-sm-inline-block" data-list-info="data-list-info"></span>
            <div class="d-flex"><button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
              <ul class="mb-0 pagination"></ul><button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
            </div>
          </div>
        </div>
      </div>
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
            <h3 class="mb-0">Add folder </h3><button class="btn btn-sm btn-phoenix-secondary" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times text-danger"></span></button>
          </div>
          <div class="modal-body px-0">
            <div class="row g-3">
              <div class="col-lg-12">
                <div class="mb-4">
                  <label class="text-1000 fw-bold mb-2">Title</label>
                  <input class="form-control" name="ftitle" id="ftitle" type="text" placeholder="Entrer title folder"  required />
                 
                </div>
                <div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer border-0 pt-6 px-0 pb-0">
            <button class="btn btn-danger px-3 my-0" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
            <input type="submit" name="sendFolder" id="add_service" value="Save folder" class="btn btn-primary my-0" />
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
              $.notify("Folder Added Successfully !", "success");
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
        $("#edit_folder_btn").text('Updating...');
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
              $.notify("Folder update Successfully !", "success");
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
                $.notify("Folder deleted Successfully !", "success");
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