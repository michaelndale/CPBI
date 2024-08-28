@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">
      <div class="card-header p-4 border-bottom border-300 bg-soft">
        <div class="row g-3 justify-content-between align-items-end">
          <div class="col-12 col-md">
            <h4 class="card-title mb-0"> <i class="fa fa-list"></i> Bon petite caisse</h4>
          </div>
          <div class="col col-md-auto">
            <a href="#" id="fetchDataLink"> <i class="fas fa-sync-alt"></i> Actualiser</a>
            <a href="javascript::;" chauffeur="button" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Ajouter la petite caisse </a>
          </div>
        </div>
      </div>
      <div class="card-body p-0">

        <div id="tableExample2">
          <div class="table-responsive" id="table-container" style="overflow-y: auto;">
            <table class="table table-bordered table-striped table-sm fs--1 mb-0">
              <thead style="position: sticky; top: 0; background-color: white; z-index: 1;">
              
                <tr style="background-color:#82E0AA">
                <th>Action</th>
                  <th >Numero</th>
                  <th style="width: 30%">Motif</th>
                  <th>Montant</th>
                  <th>Nom prenom</th>

                  <th>Créé par</th>
                  <th>Créé le</th>
                  <th> <center>Actions</center></th>
                </tr>
              </thead>
              <tbody id="show_all">
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





<div class="modal fade" id="addDealModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDealModal" aria-hidden="true">
  <div class="modal-dialog modal-xl">
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
          
          <div class="col-sm-6 col-lg-12 col-xl-8">
              <label class="text-1000 fw-bold mb-2">Compte d'approvisionnement :</label>
              <select class="form-control  form-control-sm ligneid" id="referenceid" name="referenceid" required>
                <option disabled="true" selected="true" value="">Sélectionner le compte</option>
                @foreach ($compte_bpc as $compte_bpc)
                    <option value="{{ $compte_bpc->id }}"> {{ $compte_bpc->code }} : {{ $compte_bpc->libelle }} </option>  
                @endforeach
                
              </select>
            </div>

            <div class="col-sm-6 col-lg-12 col-xl-4">
              <br><label class="text-1000 fw-bold mb-2">Est une personne interne ?</label> <br>
              <label>Oui</label> <input type="checkbox" class="form-check-input" name="facture" id="facture">  
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <label>Non</label> <input type="checkbox" class="form-check-input" name="facture" id="facture">
            </div>


            <div class="col-sm-12 col-lg-12 col-xl-4">
            <label class="text-1000 fw-bold mb-2">Je soussigné (nom complet) :</label> 
              <input type="text" name="libelle" id="libelle" class="form-control form-control-sm"  />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-4">
            <label class="text-1000 fw-bold mb-2">Titre (+ nom de l’organisation si différente de la CEPBU):</label> 
              <input type="text" name="libelle" id="libelle" class="form-control form-control-sm"  />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-4">
            <label class="text-1000 fw-bold mb-2">Type de carte d’identité :</label> 
              <input type="text" name="libelle" id="libelle" class="form-control form-control-sm"  />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-4">
            <label class="text-1000 fw-bold mb-2">Numéro de la pièce d’identité:</label> 
              <input type="text" name="libelle" id="libelle" class="form-control form-control-sm"  />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-4">
            <label class="text-1000 fw-bold mb-2">Addresse :</label> 
              <input type="text" name="libelle" id="libelle" class="form-control form-control-sm"  />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-4">
            <label class="text-1000 fw-bold mb-2">Téléphone/Emai</label> 
              <input type="text" name="libelle" id="libelle" class="form-control form-control-sm"  />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-12">
            <label class="text-1000 fw-bold mb-2">Personnel</label> 
            <select  class="form-control  form-control-sm ligneid" name="acce" id="acce" required>
                                                <option disabled="true" selected="true" value="">--Sélectionner Personnel --</option>
                                                @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->nom }} {{ $personnels->prenom }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                @endforeach
                                            </select>
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-12">
            <label class="text-1000 fw-bold mb-2">Motif (Objective): </label> 
              <input type="text" name="libelle" id="libelle" class="form-control form-control-sm"  />
            </div>

            <div class="table-responsive">
                                <table class="table table-striped table-sm fs--1 mb-0" id="tableEstimate">
                                    <thead style="background-color:#3CB371; color:white">
                                        <tr>
                                            <th style="width:80px; color:white"><b>Num<span class="text-danger">*</span></b></th>
                                            <th style="  color:white"><b> Designation des activités de la ligne<span class="text-danger">*</span> </b></th>
                                            <th style=" color:white"> <b> Description<span class="text-danger">*</span></b></th>
                                           
                                            <th> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input style="width:100%" type="number" id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="1"></td>
                                            <td style="width:70%">
                                                
                                                     <select   class="form-control  form-control-sm select2-search-disable condictionsearch" id="compteid" name="compteid" required>
                                                        <option value="">Ligne budgétaire</option>
                                                        @foreach ($compte as $comptes)
                                                        <optgroup label="{{ $comptes->libelle }}">
                                                        @php
                                                        $idc = $comptes->id ;
                                                        $res= DB::select("SELECT * FROM comptes WHERE compteid= $idc");
                                                        @endphp
                                                        @foreach($res as $re)
                                                        <option value="{{ $comptes->id }}-{{ $re->id }}">{{ $re->numero }}. {{ $re->libelle }} </option>
                                                        @endforeach

                                                        </optgroup>
                                                        @endforeach

                                                    </select>
                                                
                                            </td>
                                            <td><input style="width:100%" type="text" id="libelle_description" name="libelle_description[]" class="form-control form-control-sm" required></td>
                                           
                                            <td><a href="javascript:void(0)" class="text-primary font-18" title="Add" id="addBtn"><i class="fa fa-plus-circle"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-striped table-sm fs--1 mb-0">
                                    <tfoot style="background-color:#c0c0c0">
                                        <tr>
                                            <td colspan="8">Total global </td>
                                            <td align="right"><span class="total-global">0.00 {{ Session::get('devise') }} </span></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <hr>
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
  // Variable pour stocker le numéro de ligne actuel
  var rowIdx = 2;

  // Ajouter une ligne au clic sur le bouton "Ajouter"
  // Ajouter une ligne au clic sur le bouton "Ajouter"
  $("#addBtn").on("click", function() {
    // Ajouter une nouvelle ligne au tableau
    $("#tableEstimate tbody").append(`
        <tr id="R${rowIdx}">
            <td><input style="width:100%" type="number" id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="${rowIdx}" ></td>
            <td><div id="Showpoll${rowIdx}" class="Showpoll"> </div> </td>
            <td><input style="width:100%" type="text" id="libelle_description" name="libelle_description[]" class="form-control form-control-sm" required></td>
            <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Enlever"><i class="far fa-trash-alt"></i></a></td>
        </tr>
    `);

    // Cloner le contenu de l'élément Showpoll dans la nouvelle ligne
    var $originalShowpoll = $('#Showpoll');
    var $newShowpoll = $originalShowpoll.clone().attr('id', `Showpoll${rowIdx}`);
    $(`#R${rowIdx}`).find('.Showpoll').replaceWith($newShowpoll);

    // Incrémenter le numéro de ligne
    rowIdx++;
  });


  // Supprimer une ligne au clic sur le bouton "Enlever"
  $("#tableEstimate tbody").on("click", ".remove", function() {
    // Récupérer toutes les lignes suivant la ligne supprimée
    var child = $(this).closest("tr").nextAll();

    // Modifier les numéros de ligne des lignes suivantes
    child.each(function() {
      var id = $(this).attr("id");
      var dig = parseInt(id.substring(1));
      $(this).attr("id", `R${dig - 1}`);
      $(this).find(".row-index").text(dig - 1);
    });

    // Supprimer la ligne
    $(this).closest("tr").remove();

    // Mettre à jour le numéro de ligne
    rowIdx--;
  });

 
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
          
            fetchallbpc();
           

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
            fetchallbpc();
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
                fetchallbpc();
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

   

    fetchallbpc();

    function fetchallbpc() {
      $.ajax({
        url: "{{ route('liste_bpc') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all").html(reponse);
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