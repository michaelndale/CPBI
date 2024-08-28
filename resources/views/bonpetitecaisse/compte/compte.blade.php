@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">
      <div class="card-header p-4 border-bottom border-300 bg-soft">
        <div class="row g-3 justify-content-between align-items-end">
          <div class="col-12 col-md">
            <h4 class="card-title mb-0"> <i class="fa fa-list"></i> Compte petite caisse</h4>
          </div>
          <div class="col col-md-auto">
            <a href="#" id="fetchDataLink"> <i class="fas fa-sync-alt"></i> Actualiser</a>
            <a href="javascript::;" chauffeur="button" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Ajouter Compte petite caisse </a>
          </div>
        </div>
      </div>
      <div class="card-body p-0">

        <div id="tableExample2">
          <div class="table-responsive" id="table-container" style="overflow-y: auto;">
            <table class="table table-bordered table-striped table-sm fs--1 mb-0">
              <thead style="position: sticky; top: 0; background-color: white; z-index: 1;">
                <tr style="background-color:#82E0AA">
                  <th style="width:5%">Code</th>
                  <th style="width:45%">Description</th>
                  <th>Solde</th>
                  <th>Créé par</th>
                  <th>Créé le</th>
                  <th> <center>Actions</center></th>
                </tr>
              </thead>
              <tbody id="show_all_compte">
                <tr>
                  <td colspan="6">
                    <h5 class="text-center text-secondery my-5">
                      @include('layout.partiels.load')
                  </td>
                </tr>
              </tbody>
            </table>
            <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- container-fluid -->
</div>


{{-- new compte modal --}}






<div class="modal fade" id="modifierLigneModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modifierLigneModal" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="editGrandform"> <!-- Utilisation de id="modifierLigneForm" au lieu de id="modifierLigneModal" pour le formulaire -->
        @method('post')
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Modification de la ligne budgétaire</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">

          <div class="col-sm-6 col-lg-12 col-xl-3">
              <label class="text-1000 fw-bold mb-4">Code :</label>

              <input type="text" name="numero_gl" id="numero_gl" class="form-control" />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-8">
              Description
              <input type="hidden" name="projetid" id="projetid" class="form-control" />
              <input type="text" name="libelle_gr" id="libelle_gr" class="form-control"  />
            </div>
           

          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="sendGrand" id="sendGrand" class="btn btn-primary" type="button"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addDealModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDealModal" aria-hidden="true">
  <div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="addcompteform">
        @method('post')
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouvelle  Compte petite caisse </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="row g-3">
          <div class="col-sm-6 col-lg-12 col-xl-12">
            <label class="text-1000 fw-bold mb-2"> Composante/ Projet/Section </label>
          <input value="{{ Session::get('id') }} " type="hidden" name="projetid" id="projetid">
          <input value="{{ Session::get('title') }} " class="form-control form-control-sm" style="background-color:#c0c0c0" disabled>
            </div>
          
          <div class="col-sm-6 col-lg-12 col-xl-3">
              <label class="text-1000 fw-bold mb-2">Code :</label>
              <input type="text" name="code" id="code" class="form-control" />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-9">
            <label class="text-1000 fw-bold mb-2">Description :</label> 
              <input type="text" name="libelle" id="libelle" class="form-control"  />
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="sendCompte" id="sendCompte" class="btn btn-primary" type="button"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- new sous compte modal --}}

<div class="modal fade" id="addDealModalSousCompte" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDealModalSousCompte" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="addsouscompteform">
        @method('post')
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouvelle sous ligne budgétaire </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="row g-3">
            <div class="col-sm-6 col-lg-12 col-xl-3">
              Code
              <input type="text" name="ccode" id="ccode" class="form-control" disabled style="background-color:#F5F5F5" />
            </div>
            <div class="col-sm-6 col-lg-12 col-xl-9">
              Titre
              <input type="text" name="ctitle" id="ctitle" class="form-control" disabled style="background-color:#F5F5F5" />
              <input type="hidden" name="cid" id="cid" />
            </div>

            <div class="col-sm-6 col-lg-12 col-xl-12">
              <label class="text-1000 fw-bold mb-2">Acc. Non</label>

              <div class="row g-2">
                <div class="col">
                  <input value="{{ Session::get('id') }}" type="hidden" name="projetid" id="projetid">

                  <input type="hidden" name="scle_type_projet" id="scle_type_projet">
                  <input type="hidden" name="scle_cout" id="scle_cout">

                  <input id="code" name="code" class="form-control" type="text" placeholder="Entrer Acc. Non" required />
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-lg-12 col-xl-12">
              <label class="text-1000 fw-bold mb-2">Intitulé du compte</label>
              <textarea class="form-control" id="libelle" name="libelle" type="text" placeholder="Entrer la description" style="height:100px" required></textarea>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="sendsousCompte" id="sendsousCompte" class="btn btn-primary" type="button"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- new sous compte modal --}}

<div class="modal fade" id="EditModalSousCompte" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditModalSousCompte" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="editsouscompteform">
        @method('post')
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel"><i class="fa fa-edit"></i> Modifier la ligne budgétaire </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="row g-3">
            <div class="col-sm-6 col-lg-12 col-xl-3">
              Code
              <input type="text" name="ccodeedit" id="ccodeedit" class="form-control" />
            </div>
            <div class="col-sm-6 col-lg-12 col-xl-9">
              Description
              <textarea type="text" name="ctitleedit" id="ctitleedit" class="form-control" style="height:100px"></textarea>
              <input type="hidden" name="cidedit" id="cidedit" />
            </div>

          


          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="editlignebtn" id="editlignebtn" class="btn btn-primary" type="button"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>
      </form>
    </div>
  </div>
</div>


</div>
</div>

<script>
  function adjustTableHeight() {
    var windowHeight = window.innerHeight;
    var tableContainer = document.getElementById('table-container');

    // Ajustez la hauteur du conteneur du tableau en fonction de la hauteur de l'écran, moins une marge (par exemple, 200px)
    tableContainer.style.height = (windowHeight - 200) + 'px';
  }

  // Appelez la fonction lorsque la page est chargée
  window.onload = adjustTableHeight;

  // Appelez la fonction lorsque la fenêtre est redimensionnée
  window.onresize = adjustTableHeight;
</script>
<script>
  $(function() {
    // Add Compte ajax 
    $("#addcompteform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#sendCompte").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("sendCompte").disabled = true;

      $.ajax({
        url: "{{ route('storecpc') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {

          if (response.status == 200) {
            toastr.success("Petite compte ajouté avec succès. !", "Enregistrement");
          
            fetchAlldcompte();
           

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

    // update function ajax request
    $("#editcompteform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#editcomptebtn").text('Modification...');
      $.ajax({
        url: "{{ route('updateGc') }}",
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
    $(document).on('click', '.deleteIcon', function(e) {
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
            url: "{{ route('deletecpc') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {
              console.log(response);

              if (response.status == 200) {
                toastr.success("Compte supprimer avec succès !", "Suppression");
                fetchAlldcompte();
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

    function fetchAlldcompte() {
      $.ajax({
        url: "{{ route('liste_cpc') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all_compte").html(reponse);
        }
      });
    }


  
  });
</script>

<style>
  .swal-custom-content .swal-text {
    font-size: 14px;
    /* Ajustez la taille selon vos besoins */
  }
</style>

@endsection