@extends('layout/app')
@section('page-content')

<style type="text/css">
.has-error {
    border: 1px solid red;
}
</style>

<div class="content">
  
  <div id="members" data-list='{"valueNames":["customer","email","mobile_number","city","last_active","joined"],"page":10,"pagination":true}'>
    <div class="row align-items-center justify-content-between g-3 mb-4">
      <div class="col col-auto">
        <div class="search-box">
          <h4 class="text-bold text-1100 mb-5"><i class="fa fa-users"></i> Utilisateurs</h4>
        </div>
      </div>
      <div class="col-auto">
        <div class="d-flex align-items-center">
       
         <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addUserModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"  > <i class="fa fa-plus-circle"></i> Ajouter l'utilisateur </a>
      
        </div>
      </div>
    </div>
   

    <div class="mx-n4 mx-lg-n6 px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
      <div class="table-responsive scrollbar ms-n1 ps-1">
        <table class="table table-sm fs--1 mb-0">
          <thead>
            <tr>
              <th class="sort align-middle" scope="col" data-sort="customer"> Nom & prénom </th>
              <th class="sort align-middle" scope="col" data-sort="customer"> Identifiant </th>
              <th class="sort align-middle" scope="col" data-sort="city">Profile</th>
              <th class="sort align-middle" scope="col" data-sort="city">Statut</th>
              <th class="sort align-middle" scope="col" data-sort="city">Date</th>
              <th class="sort align-middle" scope="col" data-sort="city">Action</th>
            </tr>
          </thead>

          <tbody  id="show_all">
            <tr>
              <td colspan="8"><h5 class="text-center text-secondery my-5">
                  @include('layout.partiels.load')
                </td>
              </tr>
          </tbody>


        </table>
      </div>
      <div class="row align-items-center justify-content-between py-2 pe-0 fs--1">
        <div class="col-auto d-flex">
          <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info"></p><a class="fw-semi-bold" href="#!" data-list-view="*">Show all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
        </div>
        <div class="col-auto d-flex"><button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
          <ul class="mb-0 pagination"></ul><button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
        </div>
      </div>
    </div>
  </div>

  {{-- new user modal --}}
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addUserForm" autocomplete="off">
      @method('post')
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-plus"></i> Nouveau utilisateur</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
        </div>
        <div class="modal-body">
       
        <div class="form-floating mb-5">
                <select class="form-select" id="personnelid" name="personnelid" >
                    <option value="" selected="selected">Nom & prenom </option>
                      @foreach ($personnel as $personnels)
                        <option value="{{ $personnels->id }}">  {{ ucfirst($personnels->nom) }}  {{ ucfirst($personnels->prenom) }}</option>
                      @endforeach
                  </select>
                  <label for="eventLabel">Nom & prenom </label>
              </div>

              <div class="form-floating mb-5">
                <select class="form-select" id="profileid" name="profileid" >
                    <option value="" selected="selected">Profile</option>
                    @foreach ($profile as $profiles)
                      <option value="{{ $profiles->title }}">  {{ $profiles->title }}</option>
                    @endforeach
                  </select>
                  <label for="eventLabel">Profile</label>
              </div>
             
                
              <div class="form-floating mb-3">
                <input class="form-control" id="identifiant"  name="identifiant"  type="text" required="required" placeholder="Identifiant" />
                <label for="Identifiant">Identifiant</label>
                <smal id="identifiant_error" name="identifiant_error" class="text text-danger" > </smal>
              </div>

              <div class="form-floating mb-3">
                <input class="form-control" id="password" type="password" name="password" required="required" placeholder="Password" />
                <label for="Password">Mot de passe </label></div>
              </div>
        <div class="modal-footer">
          <button type="submit"  name="add_user_btn" id="add_user_btn" class="btn btn-primary">Sauvegarder</button>
        </div>
      </div>
    </form>
  </div>
</div>

  {{-- Edit function modal --}}

  <script>
    $(function() {
      // Add user ajax 
      $("#addUserForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_user_btn").text('Enregistrement encour ...');
        $.ajax({
          url: "{{ route('storeus') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) 
            {
              fetchAllUsers();
              $.notify("User Added Successfully !", "success");
              $("#add_user_btn").text('Sauvegarder');
              $("#identifiant_error").text("");
              $('#identifiant').addClass('');
              $("#addUserModal").modal('hide');
              $("#addUserForm")[0].reset();
            }

            if (response.status == 201) 
            {
              $.notify("L'indetifiant utilisateur existe déjà !", "error");
              //Toastr::error('User add new account fail :)','Error');
              $("#add_user_btn").text('Sauvegarder');
              $("#addUserModal").modal('show');
              $("#identifiant_error").text("L'indetifiant utilisateur existe déjà !");
              $('#identifiant').addClass('has-error');
            }

            if (response.status == 202) 
            {
              $.notify("Une personnel n'est peut avoir deux compte utilisateur !", "error");
              //Toastr::error('User add new account fail :)','Error');
              $("#add_user_btn").text('Sauvegarder');
              $("#addUserModal").modal('show');
              $("#identifiant_error").text("Une personnel n'est peut avoir deux compte utilisateur !");
              $('#identifiant').addClass('has-error');
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
              fetchAllUsers();
              
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
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Oui , Supprimer  ceci !'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "{{ route('deleteUs') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                $.notify("User deleted Successfully !", "success");
                fetchAllUsers();
              }
            });
          }
        })
      });

      fetchAllUsers();

      function fetchAllUsers() {
        $.ajax({
          url: "{{ route('fetchAllUs') }}",
          method: 'get',
          success: function(reponse) {
            $("#show_all").html(reponse);
          }
        });
      }
    });
  </script>
  @endsection