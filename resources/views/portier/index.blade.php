@extends('layout/app')
@section('page-content')

<div class="content">
  <div class="row">
    <div class="col-xl-12" >
        <div class="row g-3 justify-content-between align-items-center">
          <div class="col-12 col-md">
           <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="fa fa-truck"></i> Sortier / entrer </h4>
          </div>
          <div class="col col-md-auto">
            <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
                @include('portier.modale')
            </nav>
          </div>
          <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;name&quot;,&quot;email&quot;,&quot;age&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
            <div class="table-responsive" id="show_all">
                <h4 class="text-center text-secondery my-5"> Chargement des données ...</h4>
            </div>
            <div class="d-flex justify-content-center mt-3">
              <button class="page-link disabled" data-list-pagination="prev" disabled="">
                <svg class="svg-inline--fa fa-chevron-left" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"></path></svg><!-- <span class="fas fa-chevron-left"></span> Font Awesome fontawesome.com --></button>
                  <ul class="mb-0 pagination"><li class="active"><button class="page" type="button" data-i="1" data-page="5">1</button></li>
                  <li><button class="page" type="button" data-i="2" data-page="5">2</button></li><li><button class="page" type="button" data-i="3" data-page="5">3</button></li><li class="disabled"><button class="page" type="button">...</button></li><li><button class="page" type="button" data-i="9" data-page="5">9</button></li></ul><button class="page-link pe-0" data-list-pagination="next"><svg class="svg-inline--fa fa-chevron-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"></path></svg><!-- <span class="fas fa-chevron-right"></span> Font Awesome fontawesome.com --></button>
            </div>
          </div>     
        </div>
    </div>
  </div>
</div>


<script>
    $(function() {

      $('#addModal').modal({
        backdrop: 'static',
        keyboard: false
      });


      // Add user ajax 
      $("#addform").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#addbtn").text('Ajouter...');
        $.ajax({
          url: "{{ route('storepor') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) 
            {
              fetchAllportie();
              $.notify("Enregitrer avec succès !", "success");
              $("#addbtn").text('Enregistrement');
              $("#addModal").modal('hide');
              $("#addform")[0].reset();
              
            }

            if (response.status == 202) {
              $.notify("Erreur d'execution, verifier votre internet", "error");
              $("#addModal").modal('show');
              $("#addbtn").text('Enregitrer');
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
              fetchAllportie();
              
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
          title: 'Êtes-vous sûr ?',
          text: "Vous ne pourrez pas revenir en arrière !",
     
          showCancelButton: true,
          confirmButtonColor: 'green',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Oui , Supprimer !'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "{{ route('deletepor') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                $.notify("Supprimer avec succès !", "success");
                fetchAllportie();
              }
            });
          }
        })
      });

      fetchAllportie();
      function fetchAllportie() {
        $.ajax({
          url: "{{ route('fetchAllpor') }}",
          method: 'get',
          success: function(reponse) {
            $("#show_all").html(reponse);
          }
        });
      }
    });
  </script>

@endsection
