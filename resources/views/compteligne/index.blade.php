@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-10" style="margin:auto">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="fa fa-list"></i> Ligne  budgétaire</h4>

            <div class="page-title-right">
            <a href="javascript::;" chauffeur="button" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Ajouter la ligne budgétaire </a>

            </div>

          </div>
        </div>
      </div>
     
      <div class="row">
        <div class="col-lg-10" style="margin:auto">
          <div class="card">
            <div class="table-responsive">
              <table class="table table-bordered mb-0">
                <thead>
                  <tr style="background-color:#82E0AA">
                    <th style="width:5%">#</th>
                    <th  style="width:10%">Code</th>
                    <th >Description</th>
                    <th style="width:6%"><center>Actions</center></th>
                  </tr>
                </thead>
                <tbody id="show_all_compte">
                  <tr>
                    <td colspan="4">
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
  <div class="modal-dialog   modal-dialog-centered">
      <div class="modal-content">
      <form method="POST" id="addcompteform">
      @method('post')
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouvelle ligne budgétaire </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        <div class="row g-3">

          <div class="col-sm-6 col-lg-12 col-xl-12">
            <label class="text-1000 fw-bold mb-2">Acc. Non</label>
                    
            <div class="row g-2">
              <div class="col">
              <input value="{{ Session::get('id') }}" type="hidden" name="projetid" id="projetid" >
                <input id="code" name="code" class="form-control" type="text" placeholder="Entrer le code" required/></div>     
              </div>
            </div>

            <div class="col-sm-6 col-lg-12 col-xl-12">
              <label class="text-1000 fw-bold mb-2">Intitulé du compte</label>
              <textarea class="form-control" id="libelle" name="libelle"  type="text" placeholder="Entrer la description" style="height:150px" required></textarea>
            </div>
            
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit"name="sendCompte" id="sendCompte" class="btn btn-primary" type="button"> <i class="fa fa-cloud-upload-alt"></i>  Sauvegarder</button>
        </div>
        </form>
    </div>
  </div>
</div>




  {{-- new sous compte modal --}}

  <div class="modal fade" id="addDealModalSousCompte"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDealModalSousCompte" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
      <div class="modal-content">
      <form method="POST" id="addsouscompteform">
      @method('post')
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouvelle sous ligne budgétaire    </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        <div class="row g-3">
        <div class="col-sm-6 col-lg-12 col-xl-3">
          Code
          <input type="text" name="ccode" id="ccode" class="form-control"  disabled style="background-color:#F5F5F5" /> 
        </div>
        <div class="col-sm-6 col-lg-12 col-xl-9">
          Titre
          <input type="text" name="ctitle" id="ctitle" class="form-control"  disabled style="background-color:#F5F5F5" />
          <input type="hidden" name="cid" id="cid"  />
        </div>

          <div class="col-sm-6 col-lg-12 col-xl-12">
            <label class="text-1000 fw-bold mb-2">Acc. Non</label>
                    
            <div class="row g-2">
              <div class="col">
              <input value="{{ Session::get('id') }}" type="hidden" name="projetid" id="projetid" >  
              <input id="code" name="code" class="form-control" type="text" placeholder="Entrer Acc. Non" required/></div>     
              </div>
            </div>

            <div class="col-sm-6 col-lg-12 col-xl-12">
              <label class="text-1000 fw-bold mb-2">Intitulé du compte</label>
              <textarea class="form-control" id="libelle" name="libelle"  type="text" placeholder="Entrer la description" style="height:100px" required></textarea>
            </div>
            
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit"  name="sendsousCompte" id="sendsousCompte" class="btn btn-primary" type="button"> <i class="fa fa-cloud-upload-alt"></i>  Sauvegarder</button>
        </div>
        </form>
    </div>
  </div>
  </div>





  {{-- new sous sous modal --}}


  <div class="modal fade" id="addssousDealModal"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="addssousDealModal" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
      <div class="modal-content">
      <form method="POST" id="addsoussouscompteform">
      @method('post')
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Sous compte du sous compte   </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
        </div>
        <div class="modal-body">

        <div class="row g-3">

          <input type="text" name="sctitle" id="sctitle" class="form-control" readonly />
            <input type="hidden" name="scid" id="scid"  />
            <input type="hidden" name="sscid" id="sscid"  />
            <input value="{{ Session::get('id') }}" type="hidden" name="projetid" id="projetid" >  

            <div class="col-sm-6 col-lg-12 col-xl-12">
              <label class="text-1000 fw-bold mb-2">Acc. Non</label>

              <div class="row g-2">
                <div class="col"><input id="code" name="code" class="form-control" type="number" placeholder="Entrer code" required/></div>
              </div>
            </div>

            <div class="col-sm-6 col-lg-12 col-xl-12">
              <label class="text-1000 fw-bold mb-2">Intitulé du compte</label>
              <textarea class="form-control" id="libelle" name="libelle" type="text" placeholder="Entrer description" style="height:100px" required> </textarea>
            </div>

          </div>
        <div class="modal-footer">
          <button type="submit" name="sendsoussousCompte" id="sendsoussousCompte" class="btn btn-primary" type="button">Sauvegarder</button>
        </div>
        </form>
    </div>
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
       

        $("#sendCompte").html('<i class="fas fa-spinner fa-spin"></i>');
        document.getElementById("sendCompte").disabled = true;


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
              toastr.success("La ligne de compte ajouté avec succès. !", "Enregistrement");
                Selectdcompte();
                fetchAlldcompte();
                Selectsouscompte();

                $("#sendCompte").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                $("#addcompteform")[0].reset();
                $("#addDealModal").modal('hide');
                document.getElementById("sendCompte").disabled = false;

          }

          if (response.status == 201) {
            toastr.error("La ligne de compte dans ce projet existe déjà !", "Attention");
            $("#sendCompte").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addDealModal").modal('show');
            document.getElementById("sendCompte").disabled = false;

            
          }

          if (response.status == 202) {
            toastr.info("Erreur d'execution, Vérifier l’état de votre connexion", "Erreur");
            $("#sendCompte").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addDealModal").modal('show');
            document.getElementById("sendCompte").disabled = false;

          }

          }
        });
      });

      $("#addsouscompteform").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
     

        $("#sendsousCompte").html('<i class="fas fa-spinner fa-spin"></i>');
        document.getElementById("sendsousCompte").disabled = true;

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

                $("#sendsousCompte").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                $("#addsouscompteform")[0].reset();
                $("#addDealModalSousCompte").modal('hide');
                document.getElementById("sendsousCompte").disabled = false;

            }

            if (response.status == 201) {
            toastr.info("Erreur , vous ne pouvez pas creer deux fois la ligne.", "Attention");
            $("#addDealModalSousCompte").modal('show');
            $("#sendsousCompte").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("sendsousCompte").disabled = false;
          }
        
          }
        });
      });

      $("#addsoussouscompteform").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#addsouscompte").html('<i class="fas fa-spinner fa-spin"></i>');
        document.getElementById("sendFolder").disabled = true;

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
            $("#sendsousCompte").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addsoussouscompteform")[0].reset();
            $("#addDealModalSousCompte").modal('hide');
            document.getElementById("sendsousCompte").disabled = false;
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
            $("#ccode").val(response.numero);
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
        $("#editcomptebtn").text('Modification...');
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
              toastr.success("Compte modifie !", "Modification");
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
          title: 'Êtes-vous sûr ?',
          text: "Vous ne pourrez plus revenir en arrière !",
        
          showCancelButton: true,
          confirmButtonColor: 'green',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Oui, Supprimer !'
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

               

                if (response.status == 200) {
                toastr.success("Ligne supprimer avec succès !", "Suppression");
                Selectdcompte();
                fetchAlldcompte();
                Selectsouscompte();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de supprimer cette ligne!", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
               
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