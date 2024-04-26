@extends('layout/app')
@section('page-content')
<style type="text/css">
  .has-error {
    border: 1px solid red;
  }
</style>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-11" style="margin:auto">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="fa fa-users"></i> Utilisateur</h4>

            <div class="page-title-right">
              <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addUserModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Ajouter l'utilisateur </a>
            </div>

          </div>
        </div>
      </div>
     
      <div class="row">
        <div class="col-lg-11" style="margin:auto">
          <div class="card">
            <div class="table-responsive">
              <table class="table table-bordered  table-sm fs--1 mb-0">
                <thead>
                 
                  <tr style="background-color:#82E0AA">
                    <th> Nom & prénom </th>
                    <th> Identifiant </th>
                    <th>Profile</th>
                    <th><center>Signature</center></th>
                    <th>Action</th>
                  </tr>
             
                </thead>
                <tbody >
                  @foreach ($personnel as $personnels)
                  <tr>
                    <td> {{ $personnels->nom }} {{ $personnels->prenom }}</td>
                    <td> {{ $personnels->identifiant }} </td>
                    <td> {{ $personnels->fonction }}</td>
                    <td>
                      <center>
                    @php
                                $signature = $personnels->signature;
                                $imagePath = public_path($signature);
                            @endphp

                            @if(file_exists($imagePath))
                            <i class="fa fa-check-circle text-primary"></i>  
                            @else
                            <i class="fa fa-times-circle text-danger"></i>
                            @endif
                            </center>
                    </td>
                    <td> 
                      <a href="{{ route('changepassword', $personnels->id)}}" title="Modification mot de passe"> <i class="fa fa-edit"></i></a> 
                      <a href="{{ route('shomesignature', $personnels->id)}}" title="Modification signature"> <i class="fa fa-image"></i></a></td>
                  </tr>
                  @endforeach
                 
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


{{-- new user modal --}}
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addUserForm" autocomplete="off">
      @method('post')
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-plus"></i> Nouveau utilisateur</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
        </div>
        <div class="modal-body">

          <div class="form-floating mb-1">
            <select class="form-select" id="personnelid" name="personnelid">
              <option value="" selected="selected">Nom & prenom </option>
              @foreach ($users as $users)
              <option value="{{ $users->id }}"> {{ ucfirst($users->nom) }} {{ ucfirst($users->prenom) }}</option>
              @endforeach
            </select>
            <label for="eventLabel">Nom & prenom </label>
          </div>

          <div class="form-floating mb-1">
            <select class="form-select" id="profileid" name="profileid">
              <option value="" selected="selected">Profile</option>
              @foreach ($profile as $profiles)
              <option value="{{ $profiles->title }}"> {{ $profiles->title }}</option>
              @endforeach
            </select>
            <label for="eventLabel">Profile</label>
          </div>


          <div class="form-floating mb-1">
            <input class="form-control" id="identifiant" name="identifiant" type="text" required="required" placeholder="Identifiant" />
            <label for="Identifiant">Identifiant</label>
            <smal id="identifiant_error" name="identifiant_error" class="text text-danger"> </smal>
          </div>

          <div class="form-floating mb-1">
            <input class="form-control" id="password" type="password" name="password" required="required" placeholder="Password" />
            <label for="Password">Mot de passe </label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_user_btn" id="add_user_btn" class="btn btn-primary"><i class="fas fa-check-circle"></i> Sauvegarder</button>
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
          if (response.status == 200) {
            fetchAllUsers();
      
           toastr.success('Utilisateur enregitrer avec succes .', 'Enregitrement');
            $("#add_user_btn").text('Sauvegarder');
            $("#identifiant_error").text("");
            $('#identifiant').addClass('');
            $("#addUserModal").modal('hide');
            $("#addUserForm")[0].reset();
          }

          if (response.status == 201) {
           // $.notify("L'indetifiant utilisateur existe déjà !", "error");
            //Toastr::error('User add new account fail :)','Error');
            toastr.info('L\'indetifiant utilisateur existe déjà .', 'Erreur');
            $("#add_user_btn").text('Sauvegarder');
            $("#addUserModal").modal('show');
            $("#identifiant_error").text("L'indetifiant utilisateur existe déjà !");
            $('#identifiant').addClass('has-error');
          }

          if (response.status == 202) {
            //$.notify("Une personnel n'est peut avoir deux compte utilisateur !", "error");
            //Toastr::error('User add new account fail :)','Error');
            toastr.error('Une personnel n\'est peut avoir deux compte utilisateur.', 'Erreur');
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
          //  $.notify("Function update Successfully !", "success");
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
            //  $.notify("User deleted Successfully !", "success");
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