@extends('layout/app')
@section('page-content')
<div class="content pt-0">
    <div class="email-container">
    <div class="row gx-lg-6 gx-3 py-4 z-index-2 position-sticky bg-soft email-header">
      <div class="col-12 col-md">
      <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="fa fa-server"></i> Archivage </h4>
      </div>
      <div class="col col-md-auto">
        <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
        <a href="javascript::;" chauffeur="button" data-bs-toggle="modal" data-bs-target="#addModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau </a>
          </nav>
          
        </div>
      </div>


          <div class="row g-lg-6 mb-8">
            <div class="col-lg-auto">
              <div class="email-sidebar email-sidebar-width bg-soft phoenix-offcanvas phoenix-offcanvas-fixed" id="emailSidebarColumn">
                <div class="email-content scrollbar-overlay">
                  <div class="d-flex justify-content-between align-items-center">
                    <p class="text-uppercase fs--2 text-600 mb-2 fw-bold"><i class="fa fa-folder-open" ></i> Classeur </p>
                    <a class="fs--2 fw-bold" href="javascript::;" data-bs-toggle="modal" data-bs-target="#addClasseurModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fa-solid fa-plus me-2"></span>Ajouter classeur </a> 
                  </div>
                  <ul class="nav flex-column border-top fs--1 vertical-nav mb-4">
                 @forelse ($classeur as $classeurs)
                    <li class="nav-item"><a class="nav-link py-2 ps-0 pe-3 border-end border-bottom text-start outline-none recupreclasseur" aria-current="page" href="javascript::;" id="{{ $classeurs->id }}">
                        <div class="d-flex align-items-center"><span class="me-2 nav-icons uil uil-inbox"></span><span class="flex-1">{{ $classeurs->libellec }}</span><span class="nav-item-count">5</span></div>
                      </a>
                    </li>
                  @empty
                   Pas de classeur
                  @endforelse

                 
                   
                    
                  </ul>
                </div>
              </div>
              <div class="phoenix-offcanvas-backdrop d-lg-none" data-phoenix-backdrop="data-phoenix-backdrop" style="top: 0;"></div>
            </div>
            <div class="col-lg">
              <div class="px-lg-1" >

              <div id="show_all_recherche" class="show_all_recherche">
               
               <h4 style="margin-top:10% ;color:#c0c0c0"> <center><font size="100px"><i class="fa fa-search"  ></i> </font><br><br>
               Sélectionner le classeur</center> </h4>
             
              

              </div>
             
               
              </div>
            </div>
          </div>
        </div>
        
      </div>

      @include('archive.modale')
      
   
  



<script>
    $(function() {

      $('#addModal').modal({
        backdrop: 'static',
        keyboard: false
      });


      $(document).on('click', '.recupreclasseur', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: "{{ route('getarchive') }}",
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
         
            $('#show_all_recherche').html(response);
          }
        });
      });

     
      

      // Add user ajax 
      $("#addform").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#addbtn").text('Ajouter...');
        $.ajax({
          url: "{{ route('storeexpediction') }}",
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

            if (response.status == 201) {
              $.notify("Attention: la lettre  existe déjà !", "info");
              $("#addModal").modal('show');
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
