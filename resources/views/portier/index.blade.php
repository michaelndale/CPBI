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
            <div class="table-responsive" >
            <table class="table table-striped table-sm fs--1 mb-0">
              <thead>
                <tr>
                  <th class="sort border-top" data-sort="num">#</th>
                  <th class="sort border-top" data-sort="date">Date</th>
                  <th class="sort border-top ps-3" data-sort="object">Object</th>
                  <th class="sort border-top" data-sort="ultineraire">Utineraire</th>
                  <th class="sort border-top" data-sort="Heuredepart"><center> Heure <br> de depart </center> </th>
                  <th class="sort border-top" data-sort="Heurearriver"><center> Heure <br> d'arriver </center></th>
                  <th class="sort border-top" data-sort="Chauffeur">Chauffeur</th>
                  <th class="sort border-top" data-sort="Blaque">Blaque</th>
                  <th class="sort border-top" data-sort="Chefmission">Chef de mission</th>
                  <th class="sort border-top" data-sort="signature">Signature</th>
                  <th class="sort border-top " >ACTION</th>
                </tr>
              </thead>
              <tbody class="show_all" id="show_all">
                <tr>
                  <td colspan="11"><h5 class="text-center text-secondery my-5">
                    @include('layout.partiels.load')
                  </td>
                </tr>
              </tbody>
            </table>
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
