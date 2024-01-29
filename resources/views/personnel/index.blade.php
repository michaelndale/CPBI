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
          <h4 class="text-bold text-1100 mb-5"><i class="fa fa-users"></i> Personnel</h4>
        </div>
      </div>
      <div class="col-auto">
        <div class="d-flex align-items-center">
        
         <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent" > <i class="fa fa-plus-circle"></i> Nouveau personnel</a>

        </div>
      </div>
    </div>
   

    <div class="mx-n4 mx-lg-n6 px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
      <div class="table-responsive scrollbar ms-n1 ps-1">
        <table class="table table-sm fs--1 mb-0">
          <thead>
            <tr>
              <th class="sort align-middle" scope="col" data-sort="nom"> Nom & prénom </th>
              <th class="sort align-middle" scope="col" data-sort="email">Email</th>
              <th class="sort align-middle" scope="col" data-sort="phone">Téléphone</th>
              <th class="sort align-middle" scope="col" data-sort="fonction" >Fonction</th>
              <th class="sort align-middle" scope="col" data-sort="statut">Statut</th>
              <th class="sort align-middle" scope="col" data-sort="date">Date</th>
              <th ><center>Action</center></th>
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

  {{-- new personnel modal --}}

<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addForm" autocomplete="off">
      @method('post')
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-plus"></i> Nouveau personnel</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
        </div>
        <div class="modal-body">
        <div class="row" >
                <div class="col-sm-6 col-md-6">
                  <div class="form-floating mb-3">
                    <input class="form-control" id="nom"  name="nom"  type="text"required="required" placeholder="Identifiant" />
                    <label for="Identifiant">Nom</label>
                    <span id="identifiant_error" name="nom_error" class="text text-danger" > </span>
                  </div>
                </div>
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <input class="form-control" id="prenom" type="text" name="prenom" required="required" placeholder="Password" />
                  <label for="Password">Prénom </label>
                </div>
                </div>
              </div>

              <div class="row" >
                <div class="col-sm-6 col-md-6">
                  <div class="form-floating mb-3">
                    <select class="form-control" id="sexe"  name="sexe"  type="text"required="required" placeholder="Identifiant">
                      <option value="">Séléctionner genre</option>
                      <option value="Femme">Femme</option>
                      <option value="Homme">Homme</option>
                    </select>
                    <label for="sexe">Sexe</label>
                  </div>
                </div>
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <input class="form-control" id="phone" type="text" name="phone" required="required" placeholder="Téléphone" />
                  <label for="Password">Téléphone </label>
                </div>
                </div>
              </div>

              <div class="row" >
                <div class="col-sm-12 col-md-12">
                  <div class="form-floating mb-3">
                    <input class="form-control" id="email"  name="email"  type="text" required="required" placeholder="Email" />
                    <label for="email">Email</label>
                    <span id="email_error" name="email_error" class="text text-danger" > </span>
                  </div>
                </div>
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <input class="form-control" id="dateemboche" type="date" name="dateemboche" required="required"  />
                  <label for="dateemboche">Date amboche </label>
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
            
              <div class="row" >
                <div class="col-sm-12 col-md-12">
                <div class="form-floating mb-5">
                  <select class="form-select" id="fonction" name="fonction">
                      <option value="" selected="selected">Fonction</option>
                        @foreach ($fonction as $fonctions)
                          <option value="{{ $fonctions->title }}">  {{ $fonctions->title  }}</option>
                        @endforeach
                    </select>
                    <label for="eventLabel">Fonction</label>
                </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="addbtn" id="addbtn" class="btn btn-primary">Sauvegarder</button>
        </div>
      </div>
    </form>
  </div>
</div>


  <script>
    $(function() {
      // Add user ajax 
      $("#addForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#addbtn").text('Enregistrement encours ...');
        $.ajax({
          url: "{{ route('storepersonnel') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) 
            {
               fetchAll();
              $.notify("User Added Successfully !", "success");
              $("#addbtn").text('Sauvegarder');
              $("#email_error").text("");
              $('#email').addClass('');
              $("#addModal").modal('hide');
              $("#addForm")[0].reset();
            }

            if (response.status == 201) 
            {
              $.notify("L'email personnel existe déjà !", "error");
              //Toastr::error('User add new account fail :)','Error');
              $("#addbtn").text('Sauvegarder');
              $("#addModal").modal('show');
              $("#email_error").text("L'email personnel existe déjà !");
              $('#email').addClass('has-error');
            }

            if (response.status == 202) 
            {
              $.notify("Un personnel n'est peut etre enregitrer deux fois !", "error");
              //Toastr::error('User add new account fail :)','Error');
              $("#addbtn").text('Sauvegarder');
              $("#addModal").modal('show');
              $("#email_error").text("Un personnel n'est peut avoir deux compte utilisateur !");
              $('#email').addClass('has-error');
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
               fetchAll();
              
            }
            $("#edit_function_btn").text('Update function');
            $("#edit_function_form")[0].reset();
            $("#edit_functionModal").modal('hide');
          }
        });
      });

      // Delete user ajax request
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
                $.notify("Personnel supprimer !", "success");
                fetchAll();
              }
            });
          }
        })
      });

      fetchAll();

      function fetchAll() {
        $.ajax({
          url: "{{ route('fetchpersonnel') }}",
          method: 'get',
          success: function(reponse) {
            $("#show_all").html(reponse);
          }
        });
      }
    });
  </script>


  @endsection