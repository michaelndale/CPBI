@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-8" style="margin:auto">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="fa fa-users"></i> Compte ligne </h4>

            <div class="page-title-right">
            <a href="javascript::;" chauffeur="button" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau compte </a>

            </div>

          </div>
        </div>
      </div>
     
      <div class="row">
        <div class="col-lg-8" style="margin:auto">
          <div class="card">
            <div class="table-responsive">
              <table class="table table-bordered mb-0">
                <thead>
                 
                  <tr style="background-color:#82E0AA">
                  <th style="width:5%"></th>
                  <th  style="width:10%">Code</th>
                  <th >Libelle</th>
                  <th style="width:25%"><center>Action</center></th>

                  </tr>
             
                </thead>
                <tbody id="show_all_compte">
                  <tr>
                    <td colspan="3">
                      <h5 class="text-center text-secondery my-5">
                        @include('layout.partiels.load')
                    </td>
                  </tr>
                </tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div> <!-- container-fluid -->
  </div>
</div>

  {{-- new compte modal --}}

  <div class="modal fade" id="addDealModal"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDealModal" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered">
      <div class="modal-content">
      <form method="POST" id="addcompteform">
      @method('post')
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouveau department </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg></button>
        </div>
        <div class="modal-body">

        <div class="row g-3">

          <div class="col-sm-6 col-lg-12 col-xl-2">
            <label class="text-1000 fw-bold mb-2">Acc. Non</label>
                    
            <div class="row g-2">
              <div class="col"><input id="code" name="code" class="form-control" type="number" placeholder="Enter code" /></div>     
              </div>
            </div>

            <div class="col-sm-6 col-lg-12 col-xl-10">
              <label class="text-1000 fw-bold mb-2">Intitulé du compte</label>
              <input class="form-control" id="libelle" name="libelle"  type="text" placeholder="Enter libelle" />
            </div>
            
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit"name="sendCompte" id="sendCompte" class="btn btn-primary" type="button">Enregistrer</button>
        </div>
        </form>
    </div>
  </div>
</div>




  {{-- new sous compte modal --}}

  <div class="modal fade" id="addDealModalSousCompte"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDealModalSousCompte" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered">
      <div class="modal-content">
      <form method="POST" id="addsouscompteform">
      @method('post')
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouveau department </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg></button>
        </div>
        <div class="modal-body">

        <div class="row g-3">

          <input type="text" name="ctitle" id="ctitle" class="form-control" readonly />
          <input type="hidden" name="cid" id="cid"  />

          <div class="col-sm-6 col-lg-12 col-xl-2">
            <label class="text-1000 fw-bold mb-2">Acc. Non</label>
                    
            <div class="row g-2">
              <div class="col"><input id="code" name="code" class="form-control" type="number" placeholder="Enter code" /></div>     
              </div>
            </div>

            <div class="col-sm-6 col-lg-12 col-xl-10">
              <label class="text-1000 fw-bold mb-2">Intitulé du compte</label>
              <input class="form-control" id="libelle" name="libelle"  type="text" placeholder="Enter libelle" />
            </div>
            
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit"  name="sendsousCompte" id="sendsousCompte" class="btn btn-primary" type="button">Enregistrer</button>
        </div>
        </form>
    </div>
  </div>
  </div>





  {{-- new sous sous modal --}}


  <div class="modal fade" id="addssousDealModal"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="addssousDealModal" aria-hidden="true">
  <div class="modal-dialog modal-xl  modal-dialog-centered">
      <div class="modal-content">
      <form method="POST" id="addsoussouscompteform">
      @method('post')
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Sous compte du sous compte </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg></button>
        </div>
        <div class="modal-body">

        <div class="row g-3">

          <input type="text" name="sctitle" id="sctitle" class="form-control" readonly />
            <input type="hidden" name="scid" id="scid"  />
            <input type="hidden" name="sscid" id="sscid"  />


            <div class="col-sm-6 col-lg-12 col-xl-2">
              <label class="text-1000 fw-bold mb-2">Acc. Non</label>

              <div class="row g-2">
                <div class="col"><input id="code" name="code" class="form-control" type="number" placeholder="Enter code" /></div>
              </div>
            </div>

            <div class="col-sm-6 col-lg-12 col-xl-10">
              <label class="text-1000 fw-bold mb-2">Intitulé du compte</label>
              <input class="form-control" id="libelle" name="libelle" type="text" placeholder="Enter libelle" />
            </div>

          </div>
        <div class="modal-footer">
          <button type="submit" name="sendsoussousCompte" id="sendsoussousCompte" class="btn btn-primary" type="button">Enregistrer</button>
        </div>
        </form>
    </div>
  </div>
</div>






  {{-- Edit compte modal --}}

  <div class="modal fade " id="editcompteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editcompteModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-100 p-4">
        <form method="POST" id="editcompteform">
          @method('post')
          @csrf
          <div class="modal-header border-0 p-0 mb-2">
            <h3 class="mb-0">Edit compte</h3><button class="btn btn-sm btn-phoenix-secondary" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times text-danger"></span></button>
          </div>
          <div class="modal-body px-0">
            <div class="row g-3">
              <div class="col-lg-12">
                <div class="mb-4">
                  <label class="text-1000 fw-bold mb-2">Title</label>
                  <input type="hidden" name="gc_id" id="gc_id">
                  <input class="form-control" name="gc_title" id="gc_title" type="text" placeholder="Entrer compte"  required />
                  @error('cp_title')
                  <div class="text text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
         
              </div>
            </div>
          </div>
          <div class="modal-footer border-0 pt-6 px-0 pb-0">
            <button type="button" class="btn btn-danger px-3 my-0" data-bs-dismiss="modal" aria-label="Close"> Cancel </button>
            <button type="submit"  id="editcomptebtn" class="btn btn-primary my-0"> Update compte</button>
          </div>
        </form>
      </div>
    </div>
  </div>

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
                toastr.success("Compte ajouter avec succees !", "Enregistrement");
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
              toastr.success("Sous compte ajouter avec succees !", "Enregitrement");
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
              toastr.success("Sous compte ajouter avec succees !", "Enregistrement");
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