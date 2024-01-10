@extends('layout/app')
@section('page-content')
<div class="content">
  <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style="width:60%; margin:auto">
    <div class="card-header p-4 border-bottom border-300 bg-soft">
      <div class="row g-3 justify-content-between align-items-end">
        <div class="col-12 col-md">
          <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="fa fa-list"></i> Fonction</h4>
        </div>
        <div class="col col-md-auto">
          <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#add_functionModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouvelle Fonction</a>
        </div>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="collapse code-collapse" id="search-example-code">
      </div>
      <div class="p-4 code-to-copy">
        <div id="tableExample3" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
          <div class="search-box mb-3 mx-auto">
            <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input class="form-control search-input search form-control-sm" type="search" placeholder="Recherche" aria-label="Search" />
              <span class="fas fa-search search-box-icon"></span>
            </form>
          </div>
          <div class="table-responsive" id="show_all_function">
          <h4 class="text-center text-secondery my-5"> Chargement des données ...</h4>
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


  {{-- new fonction modal --}}

<div class="modal fade" id="add_functionModal" tabindex="-1" aria-labelledby="add_functionModal"" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <form method="POST" id="add_function_form">
      @method('post')
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouveau fonction </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg></button>
        </div>
        <div class="modal-body">

          <label class="text-1000 fw-bold mb-2">Libellé </label>
          <input class="form-control" name="title" type="text" placeholder="Entrer libellé"  required />

        </div>
        <div class="modal-footer">
          <button type="submit" name="sendfonction" id="add_function" class="btn btn-primary" type="button">Enregistrer</button>
        </div>
        </form>
    </div>
  </div>
</div>

{{-- Fin fonction --}}
                          


{{-- Edit fonction modal --}}

<div class="modal fade" id="edit_functionModal" tabindex="-1" aria-labelledby="edit_functionModal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <form method="POST" id="edit_function_form">
      @method('post')
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Modification fonction </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg></button>
        </div>
        <div class="modal-body">

          <label class="text-1000 fw-bold mb-2">Libellé </label>
            <input type="hidden" name="fun_id" id="fun_id">
            <input class="form-control" name="fun_title" id="fun_title" type="text" placeholder="Entrer function" name="nom_fonction" required />
                
        </div>
        <div class="modal-footer">
          <button type="submit"  id="edit_function_btn"  class="btn btn-primary" type="button">Modifier</button>
        </div>
        </form>
    </div>
  </div>
</div>
{{-- Fin modifier fonction  --}}





  <script>
    $(function() {
      // Add function ajax 
      $("#add_function_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_function").text('Ajouter...');
        $.ajax({
          url: "{{ route('store') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {

            if (response.status == 200) {
              $.notify("Fonction ajouté avec succès !", "success");
              fetchAllfunction();
              $("#add_function_form")[0].reset();
              $("#add_functionModal").modal('hide');
            }
            if (response.status == 201) {
              $.notify("Attention: Libellé fonction existe déjà !", "info");
              $("#add_functionModal").modal('show');
            }

            if (response.status == 202) {
              $.notify("Erreur d'execution, verifier votre internet", "error");
              $("#add_functionModal").modal('show');
            }

            $("#add_function").text('Enregitrer');

          }
        });
      });

      // Edit fonction ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: "{{ route('editF') }}",
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

      // update function ajax request
      $("#edit_function_form").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_function_btn").text('Mise à jour...');
        $.ajax({
          url:"{{ route('updateFon') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {

            if (response.status == 200) {
              $.notify("Mise à jour  avec succès !", "success");
              fetchAllfunction();
              $("#edit_function_form")[0].reset();
              $("#edit_functionModal").modal('hide');
            }
            if (response.status == 201) {
              $.notify("Attention: Libellé fonction existe déjà !", "info");
              $("#edit_functionModal").modal('hide');
            }

            if (response.status == 202) {
              $.notify("Erreur d'execution, verifier votre internet", "error");
              $("#edit_functionModal").modal('show');
            }

            $("#edit_function_btn").text('Modifier');

          }
        });
      });

      // Delete fonction ajax request

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
              url: "{{ route('deleteFon') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                $.notify("Fonction supprimer avec succès !", "success");
                fetchAllfunction();
              }
            });
          }
        })
      });


   

      fetchAllfunction();
      function fetchAllfunction() {
        $.ajax({
          url: "{{ route('fetchAll') }}",
          method: 'get',
          success: function(reponse) {
            $("#show_all_function").html(reponse);
          }
        });
      }
    });
  </script>


  @endsection