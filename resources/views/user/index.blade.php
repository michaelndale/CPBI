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
          <!-- <input class="form-control search-input search" type="search" placeholder="Search First and last name" aria-label="Search" /> -->
         <button class="btn btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#addUserModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent" style="background-color:#228B22;color:white" > <i class="fa fa-plus-circle"></i> Ajouter </button>
         <!-- <button class="btn btn-link text-900 me-4 px-0">
            <select type="text" class="form-control" name="forma" onchange="location = this.value;">
              <option> </option>
              <option value="#">5</option>
            </select>
          </button> -->
        </div>
      </div>
    </div>
    <nav class="mb-2" aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"> Utilisateurs</li>
      </ol>
    </nav>

    <div class="mx-n4 mx-lg-n6 px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
      <div class="table-responsive scrollbar ms-n1 ps-1">
        <table class="table table-sm fs--1 mb-0">
          <thead>
            <tr>
              <th class="sort align-middle" scope="col" data-sort="customer"> Nom & prenom </th>
              <th class="sort align-middle" scope="col" data-sort="email">Email</th>
              <th class="sort align-middle" scope="col" data-sort="email">Telephone</th>
              <th class="sort align-middle" scope="col" data-sort="city" >Fonction</th>
              <th class="sort align-middle" scope="col" data-sort="city">Department</th>
              <th class="sort align-middle" scope="col" data-sort="city">Profile</th>
              <th class="sort align-middle" scope="col" data-sort="city">Statut</th>
              <th class="sort align-middle" scope="col" data-sort="city">Date</th>
              <th class="sort align-middle" scope="col" data-sort="city">Action</th>
            </tr>
          </thead>
          <tbody class="list" id="show_all_users">
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

  <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content border">
            <form id="addUserForm" autocomplete="off">
                @method('post')
                @csrf
              <div class="modal-header px-card border-0">
                <div class="w-100 d-flex justify-content-between align-items-start">
                  <div>
                    <h5 class="mb-0 lh-sm text-1000"><i class="fa fa-user-plus"></i> Nouveau utilisateur</h5>
                  </div><button class="btn p-1 fs--2 text-900" type="button" data-bs-dismiss="modal" aria-label="Close">DISCARD </button>
                </div>
              </div>
              <div class="modal-body p-card py-0">

             

              <div class="form-floating mb-5">
                <select class="form-select" id="profileid" name="profileid" >
                    <option value="" selected="selected">Profile</option>
                    @foreach ($profile as $profiles)
                      <option value="{{ $profiles->title }}">  {{ $profiles->title }}</option>
                    @endforeach
                  </select>
                  <label for="eventLabel">Profile</label>
              </div>
              <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-5">
                  <select class="form-select" id="department" name="department">
                      <option value="" selected="selected">Departement</option>
                        <option value="Tout"> Tout</option>
                        @foreach ($department as $departments)
                          <option value="{{ $departments->title }}">  {{ $departments->title  }}</option>
                        @endforeach
                    </select>
                    <label for="eventLabel">Departement</label>
                </div>
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-5">
                  <select class="form-select" id="statut" name="statut">
                      <option value="" selected="selected">Statut</option>
                      @foreach ($statut as $statuts)
                        <option value="{{ $statuts->libelle }}">  {{ $statuts->libelle }}</option>
                      @endforeach
                    </select>
                    <label for="eventLabel">Status</label>
                </div>
                </div>
            </div>
                
              <div class="form-floating mb-3">
                <input class="form-control" id="identifiant"  name="identifiant"  type="text"required="required" placeholder="Identifiant" />
                <label for="Identifiant">Identifiant</label>
                <span id="identifiant_error" name="identifiant_error" class="text text-danger" > </span>
              </div>
              <div class="form-floating mb-3"><input class="form-control" id="password" type="password" name="password" required="required" placeholder="Password" /><label for="Password">Mot de passe </label></div>
            
                </div>
              <div class="modal-footer d-flex justify-content-between align-items-center border-0">
                <button class="btn btn-danger px-4"  type="button" data-bs-dismiss="modal" aria-label="Close">Annuller</button>
                <button class="btn btn-primary px-4"  name="add_user_btn" id="add_user_btn"  type="submit" style="background-color:#228B22">Enregistrement</button></div>
            </form>
          </div>
        </div>
      </div>




  {{-- Edit function modal --}}

  <div class="modal fade " id="edit_profileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDealModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-100 p-4">
        <form method="POST" id="edit_profile_form">
          @method('post')
          @csrf
          <div class="modal-header border-0 p-0 mb-2">
            <h3 class="mb-0">Edit profile</h3><button class="btn btn-sm btn-phoenix-secondary" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times text-danger"></span></button>
          </div>
          <div class="modal-body px-0">
            <div class="row g-3">
              <div class="col-lg-12">
                <div class="mb-4">
                  <label class="text-1000 fw-bold mb-2">Title</label>
                  <input type="hidden" name="pro_id" id="pro_id">
                  <input class="form-control" name="pro_title" id="pro_title" type="text" placeholder="Entrer profil" required />
                 
                </div>
         
              </div>
            </div>
          </div>
          <div class="modal-footer border-0 pt-6 px-0 pb-0">
            <button type="button" class="btn btn-danger px-3 my-0" data-bs-dismiss="modal" aria-label="Close"> Cancel </button>
            <button type="submit"  id="edit_profile_btn" class="btn btn-primary my-0"> Update profile</button>
          </div>
        </form>
      </div>
    </div>
  </div>


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
              $("#add_user_btn").text('Enregistrement');
              $("#identifiant_error").text("");
              $('#identifiant').addClass('');
              $("#addUserModal").modal('hide');
              $("#addUserForm")[0].reset();
            }

            if (response.status == 201) 
            {
              $.notify("L'indetifiant utilisateur existe déjà !", "error");
              //Toastr::error('User add new account fail :)','Error');
              $("#add_user_btn").text('Enregistrement');
              $("#addUserModal").modal('show');
              $("#identifiant_error").text("L'indetifiant utilisateur existe déjà !");
              $('#identifiant').addClass('has-error');
            }

            if (response.status == 202) 
            {
              $.notify("Un personnel n'est peut avoir deux compte utilisateur !", "error");
              //Toastr::error('User add new account fail :)','Error');
              $("#add_user_btn").text('Enregistrement');
              $("#addUserModal").modal('show');
              $("#identifiant_error").text("Un personnel n'est peut avoir deux compte utilisateur !");
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
            $("#show_all_users").html(reponse);
          }
        });
      }
    });
  </script>


  @endsection