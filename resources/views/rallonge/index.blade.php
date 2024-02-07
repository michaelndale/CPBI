@extends('layout/app')
@section('page-content')
@foreach ($userData as $userDatas)
@endforeach
<div class="main-content">
 <br>
    
<div class="content">
  <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">
    <div class="card-header p-4 border-bottom border-300 bg-soft">
      <div class="row g-3 justify-content-between align-items-end">
        <div class="col-12 col-md">
          <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="fa fa-edit"></i> Demande de révision budgétaire ou de rallonge budgétaire </h4>
        </div>
        <div class="col col-md-auto">

          <a href="javascript::;" chauffeur="button" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Ajouter la ligne </a>

         
        </div>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="collapse code-collapse" id="search-example-code">
      </div>
      <div class="p-4 code-to-copy">
        <div id="tableExample3" data-list='{"valueNames":["name","email"],"page":5,"pagination":true}'>
         
          <div class="table-responsive" >
          <table class="table table-bordered  table-sm fs--1 mb-0">
            <tr scope="col" >
              <td scope="col" style="padding:5px">Rubrique du projet</td>
              <td scope="col" style="padding:5px">Pays / region</td>
              <td scope="col" style="padding:5px">No du projet</td>
            </tr>
            <tr>
              <td style="padding:5px; width:50%"> {{ $showData->title }} </td>
              <td style="padding:5px"> {{ $showData->region }} </td>
              <td style="padding:5px"> {{ $showData->numeroprojet }} </td>
              <td style="padding:5px"> </td>
            </tr>

            <tr>
              <td style="padding:5px">La demande a ete redige par (nom du responsable <br> Lieu et date du projet)</td>
              <td style="padding:5px" >Devise de comptabilite</td>
              <td style="padding:5px">No financier</td>
              <td style="padding:5px">Balance reporte no 12</td>
            </tr>
            <tr>
              <td style="padding:5px"> {{ $userDatas->nom }} {{ $userDatas->prenom }} , 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             </td>
              <td style="padding:5px"> {{ $showData->devise }} </td>
              <td style="padding:5px">  {{ $showData->numerofinance }} </td>
              <td style="padding:5px"> {{ $showData->budget }} </td>
            </tr>


            <tr></tr>
          </table>

          <br>

          <table class="table table-bordered  table-sm fs--1 mb-0">
          <thead>
            <tr>
              <th class="sort border-top"> Ligne budgetaire </th>
              <th class="sort border-top">        <center> Budget      </center>  </th>
              <th class="sort border-top ps-3">  <center> Depense  </center>  </th>
              <th class="sort border-top" >          <center>  T1  </center>  </th>
              <th class="sort border-top" >          <center>  T2  </center>  </th>
              <th class="sort border-top" >            <center> T3  </center>  </th>
              <th class="sort border-top" >       <center>  T4  </center>  </th>
              <th class="sort border-top" >%                                           </th>
            </tr>
          </thead>
          <tbody id="show_all_rallonge">
            <tr>
              <td colspan="8">
                <h5 class="text-center text-secondery my-5">
                  @include('layout.partiels.load') <br><br>
              </td>
            </tr>
          </tbody>
        </table>


          
        </div>
        </div>
          </div>
         
        </div>
      </div>
    </div>
  </div>
  <br><br>
  </div>

  @include('rallonge.modale')

 
  <script>
    $(function() {
      // Add rallonge budgetaire ajax 
      $("#addFOrm").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#addcompte").text('Enregistrement encours...');
        $.ajax({
          url: "{{ route('storerallonge') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) 
          {
            if (response.status == 200) {
              $.notify("Enregistrement reussi !", "success");
               fetchAllrallonge();
            }
            $("#savebtn").text('Sauvegarder');
            $("#addFOrm")[0].reset();
            $("#addDealModal").modal('hide');
          }
        });
      });


      // Edit fonction ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: "{{ route('editGc') }}",
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#gc_title").val(response.title);
            $("#gc_id").val(response.id);
          }
        });
      });


       // Edit fonction ajax request
       $(document).on('click', '.savesc', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: "{{ route('ShowCompte') }}",
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#ctitle").val(response.libelle);
            $("#cid").val(response.id);
          }
        });
      });

      // Edit fonction ajax request
      $(document).on('click', '.ssavesc', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: "{{ route('ShowCompte') }}",
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#sctitle").val(response.libelle);
            $("#scid").val(response.compteid);
            $("#sscid").val(response.id);
          }
        });
      });

      // update function ajax request
      $("#editcompteform").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#editcomptebtn").text('Updating...');
        $.ajax({
          url:"{{ route('updateGc') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              $.notify("Compte update Successfully !", "success");
              Selectdcompte();
                fetchAlldcompte();
                Selectsouscompte();
            }
            $("#editcomptebtn").text('Update compte');
            $("#editcompteModal").modal('hide');
          }
        });
      });

      // Delete compte ajax request
      $(document).on('click', '.deleteIcon', function(e) 
      {
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
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "{{ route('deleteGc') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                $.notify("Compte deleted Successfully !", "success");
                fetchAllrallonge();
              }
            });
          }
        })
      });

      fetchAllrallonge();
      function fetchAllrallonge()
      {
        $.ajax({
          url: "{{ route('fetchRallonge') }}",
          method: 'get',
          success: function(reponse) {
            $("#show_all_rallonge").html(reponse);
          }
        });
      }

    
     
    });
  </script>

  @endsection