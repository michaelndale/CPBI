@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">

      <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">

            <h4 class="mb-sm-0"><i class="fa fa-list"></i> Ligne budgétaire  </h4>
            </h4>

            <div class="page-title-right d-flex align-items-center justify-content-between gap-2" style="margin: 0;">
               
                <!-- Bouton Créer -->
                <a href="{{ route('gestioncompte') }}" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" type="button" title="Actualiser"><i class="fas fa-redo-alt"></i>  </a>
                
                <a href="javascript:voide();" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"
                data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true"
                aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Créer</a>


            </div>
        </div>


    
     
      <div class="card-body p-0">

        <div id="tableExample2">
          <div class="table-responsive" id="table-container" style="overflow-y: auto;">
            <table class="table table-bordered table-striped table-sm fs--1 mb-0">
              <thead style="position: sticky; top: 0; background-color: white; z-index: 1;">
                <tr style="background-color:#82E0AA">
                  <th style="width:5%">Compte</th>
                  <th style="width:45%">Postes Budgétaires</th>
                  <th>Type du budgét</th>
                  <th>Type Coût </th>
               
                  <th>Créé par</th>
                  <th>Créé le</th>
                  <th>Statut</th>
                  <th> <center>Actions</center></th>
                </tr>
              </thead>
              <tbody id="show_all_compte">
                <tr>
                  <td colspan="8">
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
          <h5 class="modal-title" id="verticallyCenteredModalLabel"> <i class="fa fa-edit"></i> Modification de la ligne budgétaire</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-sm-12 col-lg-12 col-xl-12">
              Description
              <input type="hidden" name="idgl" id="idgl" class="form-control" />
              <textarea type="text" name="libelle_gr" id="libelle_gr" class="form-control" style="height:100px"></textarea>
            </div>
            <div class="col-sm-6 col-lg-12 col-xl-3">
              <label class="text-1000 fw-bold mb-2">Code :</label>

              <input type="text" name="numero_gl" id="numero_gl" class="form-control" />
            </div>


            <div class="col-sm-6 col-lg-12 col-xl-9">
              <label class="text-1000 fw-bold mb-2">Type du budget :</label>
              <br>
              @foreach ($typebudget as $index => $typebudgets)
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="typeprojet" id="budgetactuel{{ $index }}" value="{{ $typebudgets->id }}" required>
                <label class="form-check-label" for="budgetactuel{{ $index }}">{{ $typebudgets->titre }}</label>
              </div>
              @endforeach
            </div>

            <div class="col-sm-6 col-lg-12 col-xl-12">
              <label class="text-1000 fw-bold mb-2">Type Coût de la ligne budgétaire :</label>
              <br>
              @foreach ($coutbudget as $inde => $coutbudgets)
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="coutbudget" id="coutbudget{{ $inde }}" value="{{ $coutbudgets->id }}" required>
                <label class="form-check-label" for="coutbudget{{ $inde }}">{{ $coutbudgets->titre }}</label>
              </div>
              @endforeach
            </div>



          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
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
          <h5 class="modal-title" id="verticallyCenteredModalLabel"><i class="fa fa-plus-circle"></i> Nouvelle ligne budgétaire </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="row g-3">

            <div class="col-sm-6 col-lg-12 col-xl-12">
              <label class="text-1000 fw-bold mb-2">Intitulé du Compte</label>
              <textarea class="form-control" id="libelle" name="libelle" type="text" placeholder="Entrer la description" required></textarea>
            </div>

            <div class="col-sm-6 col-lg-12 col-xl-3">
              <label class="text-1000 fw-bold mb-2">Compte (Acc. Non)</label>

              <div class="row g-2">
                <div class="col">
                  <input value="{{ Session::get('id') }}" type="hidden" name="projetid" id="projetid">
                  <input id="code" name="code" class="form-control" type="text" placeholder="Entrer le compte" required />
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-lg-12 col-xl-9">
              <center>
                <label class="text-1000 fw-bold mb-2"> Type du budgét ? &nbsp; &nbsp; &nbsp; </label> <br>
                @foreach ($typebudget as $index => $typebudgets)
                <input class="form-check-input" type="radio" id="type_projet{{ $index }}" name="type_projet" type="radio" value="{{ $typebudgets->id }}" @if($index==0) checked @endif required /> {{ $typebudgets->titre }} &nbsp; &nbsp;
                @endforeach
              </center>
            </div>

            <div class="col-sm-6 col-lg-12 col-xl-12">
              <label class="text-1000 fw-bold mb-2">Type Coût de la ligne budgétaire :</label>
              <br>
              @foreach ($coutbudget as $inde => $coutbudgets)
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type_cout" id="type_cout{{ $inde }}" value="{{  $coutbudgets->id }}" @if($inde==0) checked @endif required />
                <label class="form-check-label" for="type_cout{{ $inde }}">{{ $coutbudgets->titre }}</label>
              </div>
              @endforeach
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
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
          <h5 class="modal-title" id="verticallyCenteredModalLabel"> <i class="fa fa-plus-circle" ></i> Nouvelle sous ligne budgétaire </h5>
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
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
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

            <div class="col-sm-6 col-lg-12 col-xl-12">
              <label class="text-1000 fw-bold mb-2">Type Coût de la ligne budgétaire :</label>
              <br>
              @foreach ($coutbudget as $inde => $coutbudgets)
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type_cout_budget" id="type_cout_budget{{ $inde }}" value="{{ $coutbudgets->id }}" required>
                <label class="form-check-label" for="type_cout_budget{{ $inde }}">{{ $coutbudgets->titre }}</label>
              </div>
              @endforeach
            </div>




          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
          <button type="submit" name="editlignebtn" id="editlignebtn" class="btn btn-primary" type="button"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>
      </form>
    </div>
  </div>
</div>


{{-- new sous sous modal --}}

<div class="modal fade" id="addssousDealModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addssousDealModal" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="addsoussouscompteform">
        @method('post')
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Sous compte du sous compte </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
        </div>
        <div class="modal-body">

          <div class="row g-3">

            <input type="text" name="sctitle" id="sctitle" class="form-control" readonly />
            <input type="hidden" name="scid" id="scid" />
            <input type="hidden" name="sscid" id="sscid" />
            <input value="{{ Session::get('id') }}" type="hidden" name="projetid" id="projetid">

            <div class="col-sm-6 col-lg-12 col-xl-12">
              <label class="text-1000 fw-bold mb-2">Acc. Non</label>

              <div class="row g-2">
                <div class="col"><input id="code" name="code" class="form-control" type="number" placeholder="Entrer code" required /></div>
              </div>
            </div>

            <div class="col-sm-6 col-lg-12 col-xl-12">
              <label class="text-1000 fw-bold mb-2">Intitulé du compte</label>
              <textarea class="form-control" id="libelle" name="libelle" type="text" placeholder="Entrer description" style="height:100px" required> </textarea>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" name="sendsoussousCompte" id="sendsoussousCompte" class="btn btn-primary" type="button">Sauvegarder</button>
          </div>
      </form>
    </div>
  </div>
</div>


{{-- Edit compte modal --}}

<div class="modal fade" id="editcompteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editcompteModal" aria-hidden="true">
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
                <input class="form-control" name="gc_title" id="gc_title" type="text" placeholder="Entrer compte" required />
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
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
          <button type="submit" id="editcomptebtn" class="btn btn-primary my-0"> Update compte</button>
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
        url: "{{ route('storeGc') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {

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

    $("#addsouscompteform").submit(function(e) {
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
        success: function(response) {
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

    $("#addsoussouscompteform").submit(function(e) {
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
        success: function(response) {
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
          $("#scle_type_projet").val(response.cle_type_projet);
          $("#scle_cout").val(response.cle_cout);
        }
      });
    });

    // Edit fonction ajax request
    $(document).on('click', '.editsc', function(e) {
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
          $("#ccodeedit").val(response.numero);
          $("#ctitleedit").val(response.libelle);
          $("#cidedit").val(response.id);
          $("#type_cout_budget").val(response.cid);
          $("#idgl").val(response.id);
          // Sélectionner le type de coût correspondant
          $("input[name='type_cout_budget']").filter("[value='" + response.cid + "']").prop('checked', true);
        }
      });
    });

    $(document).on('click', '.editGrand', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('ShowCompteGrand') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#numero_gl").val(response.numero);
          $("#libelle_gr").val(response.libelle);
          $("#id_gr").val(response.id);
          $("#coutbudget").val(response.cid);
          $("#typeprojet").val(response.tid);
          $("#idgl").val(response.id);

          // Sélectionner le type de projet correspondant
          $("input[name='typeprojet']").filter("[value='" + response.tid + "']").prop('checked', true);

          // Sélectionner le type de coût correspondant
          $("input[name='coutbudget']").filter("[value='" + response.cid + "']").prop('checked', true);
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
          $("#scle_type_projet").val(response.cle_type_projet);
          $("#scle_cout").val(response.cle_cout);
          $("#sscid").val(response.id);
        }
      });
    });

    $("#editGrandform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#sendGrand").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("sendGrand").disabled = true;


      $.ajax({
        url: "{{ route('updateGrandcompte') }}",
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

            $("#sendGrand").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');

            $("#modifierLigneModal").modal('hide');
            document.getElementById("sendGrand").disabled = false;
          }


          if (response.status == 205) {
            toastr.error("Erreur d'exécution, vous n'avez pas l'autorisation de modifier ce compte.", "Erreur");
            $("#sendGrand").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#modifierLigneModal").modal('show');
            document.getElementById("sendGrand").disabled = false;

          }

          if (response.status == 202) {
            toastr.info("Erreur d'execution, Vérifier l’état de votre connexion", "Erreur");
            $("#sendGrand").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#modifierLigneModal").modal('show');
            document.getElementById("sendGrand").disabled = false;

          }
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

    // update ligne ajax request
    $("#editsouscompteform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#editlignebtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("editlignebtn").disabled = true;


      $.ajax({
        url: "{{ route('updatecompte') }}",
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

            $("#editlignebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#editsouscompteform")[0].reset();
            $("#EditModalSousCompte").modal('hide');
            document.getElementById("editlignebtn").disabled = false;
          }


          if (response.status == 205) {
            toastr.error("Erreur d'exécution, vous n'avez pas l'autorisation de modifier ce compte.", "Erreur");
            $("#editlignebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#EditModalSousCompte").modal('show');
            document.getElementById("editlignebtn").disabled = false;

          }

          if (response.status == 202) {
            toastr.info("Erreur d'execution, Vérifier l’état de votre connexion", "Erreur");
            $("#editlignebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#EditModalSousCompte").modal('show');
            document.getElementById("editlignebtn").disabled = false;

          }
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

    $(document).on('click', '.deleteIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';

      Swal.fire({
        title: 'Supprimer la ligne ?',
        html: "<p class='swal-text'>Cette action entraînera la suppression de la ligne budgétaire </p><p class='swal-text'><i class='fa fa-info-circle' style='color: red;'></i> Cette action entraînera également la suppression de toutes les sous-lignes, activités, FEB, DAP, DJA, et bons de petites caisses associés à cette ligne budgétaire.</p>",
        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer !',
        cancelButtonText: 'Annuler',
        allowOutsideClick: false,
        customClass: {
          content: 'swal-custom-content'
        },
        preConfirm: () => {
          return new Promise((resolve) => {
            $.ajax({
              url: "{{ route('deleteGc') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                if (response.status == 200) {
                  toastr.info("Suppression en cours...", "Suppression");
                  // Attendre un court délai pour que l'utilisateur voie le message
                  setTimeout(() => {
                    resolve(response); // Résoudre la promesse avec la réponse de la requête AJAX
                  }, 1500); // Temps en millisecondes avant de résoudre la promesse
                } else {
                  let errorMessage = response.message || "Erreur lors de la suppression du ligne.";
                  toastr.error(errorMessage, "Erreur");
                  if (response.error) {
                    toastr.error("Erreur: " + response.error, "Erreur");
                  }
                  if (response.exception) {
                    toastr.error("Exception: " + response.exception, "Erreur");
                  }
                  resolve(response); // Résoudre même en cas d'erreur pour débloquer la modal
                }
              },
              error: function(xhr, status, error) {
                let errorMsg = xhr.responseJSON ? xhr.responseJSON.message : "Erreur de réseau. Veuillez réessayer.";
                toastr.error(errorMsg, "Erreur");
                if (xhr.responseJSON && xhr.responseJSON.exception) {
                  toastr.error("Exception: " + xhr.responseJSON.exception, "Erreur");
                }
                resolve({
                  status: 500,
                  message: errorMsg,
                  error: error,
                  exception: xhr.responseJSON ? xhr.responseJSON.exception : "Aucune exception détaillée disponible"
                }); // Résoudre en cas d'erreur réseau pour débloquer la modal
              }
            });
          });
        }
      }).then((result) => {
        if (result.isConfirmed && result.value && result.value.status == 200) {
          toastr.success("Ligne supprimé avec succès !", "Suppression");
          fetchAlldcompte();
        }
      });
    });


    fetchAlldcompte();

    function fetchAlldcompte() {
      $.ajax({
        url: "{{ route('fetchAllGc') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all_compte").html(reponse);
        }
      });
    }

    Selectdcompte();

    function Selectdcompte() {
      $.ajax({
        url: "{{ route('Selectcompte') }}",
        method: 'get',
        success: function(reponse) {
          $("#select_all_compte").html(reponse);
        }
      });
    }

    Selectsouscompte();

    function Selectsouscompte() {
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

<style>
  .swal-custom-content .swal-text {
    font-size: 14px;
    /* Ajustez la taille selon vos besoins */
  }
</style>

@endsection