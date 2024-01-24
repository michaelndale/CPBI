@extends('layout/app')
@section('page-content')
<div class="content">
  <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">
    <div class="card-header p-4 border-bottom border-300 bg-soft">
      <div class="row g-3 justify-content-between align-items-end">
        <div class="col-12 col-md">
          <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="fa fa-list"></i> Compte interne</h4>
        </div>
        <div class="col col-md-auto">

          <a href="javascript::;" chauffeur="button" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau compte </a>

         
        </div>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="collapse code-collapse" id="search-example-code">
      </div>
      <div class="p-4 code-to-copy">
        <div id="tableExample3" data-list='{"valueNames":["name","email"],"page":5,"pagination":true}'>
          <div class="search-box mb-3 mx-auto">
            <form class="position-relative" data-bs-toggle="search" data-bs-display="static"><input class="form-control search-input search form-control-sm" type="search" placeholder="Search" aria-label="Search" />
              <span class="fas fa-search search-box-icon"></span>
            </form>
          </div>
          <div class="table-responsive" id="show_all_compte">
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

  @include('rallonge.modale')

 
  <script>
    $(function() {
      // Add Compte ajax 
      $("#addcompteform").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#addcompte").text('Ajouter...');
        $.ajax({
          url: "{{ route('storeGc') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) 
          {
            if (response.status == 200) {
              $.notify("Compte enregistrer  !", "success");
                Selectdcompte();
                fetchAlldcompte();
                Selectsouscompte();
            }
            $("#sendCompte").text('Add compte');
            $("#addcompteform")[0].reset();
            $("#addDealModal").modal('hide');
          }
        });
      });

      $("#addsouscompteform").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#addsouscompte").text('Adding...');
        $.ajax({
          url: "{{ route('storeSc') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) 
          {
            if (response.status == 200) {
              $.notify("Sous compte Added Successfully !", "success");
                Selectdcompte();
                fetchAlldcompte();
                Selectsouscompte();
            }
            $("#sendsousCompte").text('Add compte');
            $("#addsouscompteform")[0].reset();
            $("#addDealModalSousCompte").modal('hide');
          }
        });
      });

      $("#addsoussouscompteform").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#addsouscompte").text('Adding...');
        $.ajax({
          url: "{{ route('storeSSc') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) 
          {
            if (response.status == 200) {
              $.notify("Sous compte Added Successfully !", "success");
                Selectdcompte();
                fetchAlldcompte();
                Selectsouscompte();
            }
            $("#sendsoussousCompte").text('Add compte');
            $("#addsoussouscompteform")[0].reset();
            $("#addssousDealModal").modal('hide');
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
                Selectdcompte();
                fetchAlldcompte();
                Selectsouscompte();
              }
            });
          }
        })
      });

      fetchAlldcompte();
      function fetchAlldcompte()
      {
        $.ajax({
          url: "{{ route('fetchAllGc') }}",
          method: 'get',
          success: function(reponse) {
            $("#show_all_compte").html(reponse);
          }
        });
      }

      Selectdcompte();
      function Selectdcompte()
      {
        $.ajax({
          url: "{{ route('Selectcompte') }}",
          method: 'get',
          success: function(reponse) {
            $("#select_all_compte").html(reponse);
          }
        });
      }
      Selectsouscompte();
      function Selectsouscompte()
      {
        $.ajax({
          url: "{{ route('SelectSousCompte') }}",
          method: 'get',
          success: function(reponse) {
            $("#select_all_sous_compte").html(reponse);
          }
        });
      }
    });
  </script>

  @endsection