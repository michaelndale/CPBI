@extends('layout/app')
@section('page-content')

<div class="content">
  <div class="row">
    <div class="col-xl-12" >
        <div class="row g-3 justify-content-between align-items-center">
          <div class="col-12 col-md">
           <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="fa fa-list"></i> Activités</h4>
          </div>
          <div class="col col-md-auto">
            <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
            <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addModale" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouvelle activité</a>

            </nav>
          </div>
          <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;name&quot;,&quot;email&quot;,&quot;age&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
            <div class="table-responsive">

            <table class="table table-striped table-sm fs--1 mb-0">
              <thead>
                <tr>
                  <th class="sort border-top" data-sort="num">#</th>
                  <th class="sort border-top" data-sort="date">Description detaillee des besoins</th>
                  <th class="sort border-top" data-sort="date">Annee</th>
                  <th class="sort border-top" data-sort="date"> Monnaie BIF</th>
                  <th class="sort border-top" data-sort="date"> Date</th>
                  <th class="sort border-top" >ACTION</th>
                </tr>
              </thead>
              <tbody class="show_all" id="show_all_activite">
                <tr>
                  <td colspan="6"><h5 class="text-center text-secondery my-5">
                    <center> @include('layout.partiels.load') </center>
                  </td>
                </tr>
              </tbody>
            </table>

           
            </div>
          </div>     
        </div>
    </div>
  </div>


  @include('activite.modale')

<script>
    $(function() {

      $('#addModale').modal({
        backdrop: 'static',
        keyboard: false
      });


      // Add user ajax 
      $("#addactiviteForm").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#addactivitebtn").text('Ajouter...');
        $.ajax({
          url: "{{ route('storeact') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) 
            {
              fetchActivite();
              
              $.notify("Activité ajouté avec succès !", "success");

              $("#addactivitebtn").text('Enregistrement');
              $("#addModale").modal('hide');
              $("#addactiviteForm")[0].reset();
            }
           
            if (response.status == 202) {
              $.notify("Erreur d'execution, verifier votre internet", "error");
              $("#addModale").modal('show');
              $("#addactivitebtn").text('Enregitrer');
            }
           
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
          text: "Une activité est sur le point d'être DÉTRUITE ! Faut-il vraiment exécuter « la Suppression » ? !",
     
          showCancelButton: true,
          confirmButtonColor: 'green',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Oui , Supprimer !'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "{{ route('deleteact') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                $.notify("Activite supprimer avec succès !", "success");
                fetchActivite();
              }
            });
          }
        })
      });

      fetchActivite();
      function fetchActivite() {
        $.ajax({
          url: "{{ route('fetchActivite') }}",
          method: 'get',
          success: function(reponse) {
            $("#show_all_activite").html(reponse);
          }
        });
      }
    });
  </script>

@endsection



























