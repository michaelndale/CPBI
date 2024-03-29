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
        <div class="col-12" style="margin:auto">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="fa fa-users"></i> Conducteur</h4>

            <div class="page-title-right">
            
            </div>

          </div>
        </div>
      </div>
     
      <div class="row">
        <div class="col-lg-12" style="margin:auto">
          <div class="card">
            <div class="table-responsive">
              <table class="table table-bordered mb-0">
                <thead>
                 
                  <tr style="background-color:#82E0AA">
                  <th> Nom & prenom </th>
              <th>Telephone</th>
              <th >Fonction</th>
              <th>Permis de conduire</th>
              <th>Statut</th>
              <th>Date</th>
             
              
                  <th ><center>Action</center></th>
                  </tr>
             
                </thead>
                <tbody class="list" id="show_all">
                  <tr>
                    <td colspan="8">
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
          url: "{{ route('fetchAllcond') }}",
          method: 'get',
          success: function(reponse) {
            $("#show_all").html(reponse);
          }
        });
      }
    });
  </script>


  @endsection