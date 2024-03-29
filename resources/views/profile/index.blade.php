@extends('layout/app')
@section('page-content')

<div class="content">
  <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style="width:60%; margin:auto">
    <div class="card-header p-4 border-bottom border-300 bg-soft">
      <div class="row g-3 justify-content-between align-items-end">
        <div class="col-12 col-md">
          <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="fa fa-list"></i> Profil</h4>

        </div>
        <div class="col col-md-auto">
          <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addProfileModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau Profil</a>
        </div>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="collapse code-collapse" id="search-example-code">
      </div>
      <div class="p-4 code-to-copy">
        <div id="tableExample3" data-list='{"valueNames":["name","pagination":true}'>
          <div class="search-box mb-3 mx-auto">
            <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input class="form-control search-input search form-control-sm" type="search" placeholder="Recherche" aria-label="Search" />
              <span class="fas fa-search search-box-icon"></span>
            </form>
          </div>
          <div class="table-responsive" >
          <table class="table table-sm fs--1 mb-0">
          <thead>
            <tr>
            <th class="sort align-middle" scope="col" data-sort="nom"> #</th>
              <th class="sort align-middle" scope="col" data-sort="nom"> Libellé </th>
              <th ><center>Action</center></th>
            </tr>
          </thead>
          <tbody  id="show_all_profile">
            <tr>
              <td colspan="8"><h5 class="text-center text-secondery my-5">
                  @include('layout.partiels.load')
                </td>
              </tr>
          </tbody>
        </table>
            
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



  {{-- new profile modal --}}

<div class="modal fade" id="addProfileModal" tabindex="-1" aria-labelledby="addProfileModal"" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <form method="POST" id="add_profile_form">
      @method('post')
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouveau profil </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg></button>
        </div>
        <div class="modal-body">

          <label class="text-1000 fw-bold mb-2">Libellé </label>
          <input class="form-control" name="title" type="text" placeholder="Entrer libellé"  required />

        </div>
        <div class="modal-footer">
          <button type="submit" name="sendprofile" id="add_profile" class="btn btn-primary" type="button">Enregistrer</button>
        </div>
        </form>
    </div>
  </div>
</div>

{{-- Fin profile --}}
                          


{{-- Edit profile modal --}}

<div class="modal fade" id="edit_profileModal" tabindex="-1" aria-labelledby="edit_profileModal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <form method="POST" id="edit_profile_form">
      @method('post')
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Modification profil </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg></button>
        </div>
        <div class="modal-body">

          <label class="text-1000 fw-bold mb-2">Libellé </label>
            <input type="hidden" name="pro_id" id="pro_id">
            <input class="form-control" name="pro_title" id="pro_title" type="text" placeholder="Entrer function" name="nom_fonction" required />
                
        </div>
        <div class="modal-footer">
          <button type="submit"  id="edit_profil_btn"  class="btn btn-primary" type="button">Modifier</button>
        </div>
        </form>
    </div>
  </div>
</div>

  <script>
    $(function() {
      // Add profil ajax 
      $("#add_profile_form").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_profile").text('Ajouter...');
        $.ajax({
          url: "{{ route('storeP') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {

            if (response.status == 200) {
              $.notify("Profil ajouté avec succès !", "success");
              fetchAllprofile();
              $("#add_profile_form")[0].reset();
              $("#addProfileModal").modal('hide');
            }
            if (response.status == 201) {
              $.notify("Attention: Libellé profil existe déjà !", "info");
              $("#addProfileModal").modal('hide');
            }

            if (response.status == 202) {
              $.notify("Erreur d'execution, verifier votre internet", "error");
              $("#addProfileModal").modal('show');
            }

            $("#add_profile").text('Enregitrer');
          }
        });
      });

      // Edit profil ajax request
      $(document).on('click', '.editIcon', function(e) 
      {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: "{{ route('editP') }}",
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#pro_title").val(response.title);
            $("#pro_id").val(response.id);
          }
        });
      });

      // update profil ajax request
      $("#edit_profile_form").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_profile_btn").text('Mise à jour...');
        $.ajax({
          url:"{{ route('updateP') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) 
          {
            if (response.status == 200) {
              $.notify("Mise à jour  avec succès !", "success");
              fetchAllprofile();
              $("#edit_profile_form")[0].reset();
              $("#edit_profileModal").modal('hide');
            }
            if (response.status == 201) {
              $.notify("Attention: Libellé profil existe déjà !", "info");
              $("#edit_profileModal").modal('hide');
            }

            if (response.status == 202) {
              $.notify("Erreur d'execution, verifier votre internet", "error");
              $("#edit_profileModal").modal('show');
            }

            $("#edit_profile_btn").text('Modifier');

          }
        });
      });

      // Delete profil ajax request

      $(document).on('click', '.deleteIcon', function(e) 
      {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Êtes-vous sûr ?',
          text: "Vous ne pourrez pas revenir en arrière !",
        
          showCancelButton: true,
          confirmButtonColor: 'green',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Oui, Supprimer !'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "{{ route('deleteP') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                $.notify("Profil supprimer avec succès !", "success");
                fetchAllprofile();
              }
            });
          }
        })
      });


      fetchAllprofile();
      function fetchAllprofile() {
        $.ajax({
          url: "{{ route('fetchAllP') }}",
          method: 'get',
          success: function(reponse) {
            $("#show_all_profile").html(reponse);
          }
        });
      }
    });
  </script>

  @endsection