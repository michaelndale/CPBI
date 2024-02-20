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
          <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="mdi mdi-book-open-page-variant-outline"></i> Budgétisation  <a href=""><i class="ri-refresh-line"></i></a> </h4>
        </div>
        <div class="col col-md-auto">

          <a href="javascript::;" chauffeur="button" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Ajouter le budget </a>

         
        </div>
      </div>
    </div>
    <div class="card-body p-0">
     
      <div class="p-4 code-to-copy">
        <div id="tableExample3" data-list='{"valueNames":["name","email"],"page":5,"pagination":true}'>
         
          <div class="table-responsive" >
          <table class="table table-bordered  table-sm fs--1 mb-0">
            <tr scope="col" >
              <td scope="col" style="padding:5px"><b>Rubrique du projet</b></td>
              <td scope="col" style="padding:5px"><b>Pays / region</b></td>
              <td scope="col" style="padding:5px"><b>N<sup>o</sup> Projet</b></td>
              <td scope="col" style="padding:5px"><b>Budget</b></td>
              <td scope="col" style="padding:5px"><b><center>Statut</center></b></td>
            </tr>
            <tr>
              <td style="padding:5px; width:50%"> {{ $showData->title }} </td>
              <td style="padding:5px"> {{ $showData->region }} </td>
              <td style="padding:5px"> {{ $showData->numeroprojet }} </td>
              <td style="padding:5px"> {{ number_format($showData->budget ,0, ',', ' ') }} {{ $showData->devise }}   </td>
              <td> 
                @if($sommerapartie == $showData->budget)
                <center><span class="badge rounded-pill bg-primary font-size-11">Terminer</span></center>
                @else
                <center><span class="badge rounded-pill bg-success font-size-11">Encours</span></center>
                @endif
              </td>
           
          </table>

          <br>

          <table class="table table-bordered  table-sm fs--1 mb-0">
          <thead>
            <tr>
              <th class="sort border-top"><b>Ligne budgétaire</b></th>
              <th class="sort border-top"><center><b>Budget</b></center></th>
              <th class="sort border-top"> <center><b>T1</b></center></th>
              <th class="sort border-top" ><center><B>T2</B></center></th>
              <th class="sort border-top" ><center><B>T3</B></center></th>
              <th class="sort border-top" ><center><B>T4</B></center></th>
              <th class="sort border-top ps-3"><center> <B>Dépense</B></center></th>

              <th class="sort border-top" ><b>%</b> </th>
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
              toastr.success("Budget reussi avec succès !", "Enregistrement");
              fetchAllrallonge();
               $("#addFOrm")[0].reset();
              $("#addDealModal").modal('hide');
            }

            if (response.status == 201) {
              toastr.error("Le budget est supérieur au montant globale du budget !", "Attention");
              
            $("#addDealModal").modal('show');
            }

            if (response.status == 202) {
              toastr.error("Erreur d'execution  !", "Erreur");
              
            $("#addDealModal").modal('show');
            }

            if (response.status == 203) {
              toastr.error("Une ligne de compte n'est peut recevoir de fois le montant !", "Erreur");
              
            $("#addDealModal").modal('show');
            }

            $("#savebtn").text('Sauvegarder');
           
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
              toastr.info("Compte update Successfully !", "success");
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
                toastr.success("Compte deleted Successfully !", "success");
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