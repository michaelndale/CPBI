@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">
      <div class="card-header p-4 border-bottom border-300 bg-soft">
        <div class="row g-3 justify-content-between align-items-end">
          <div class="col-12 col-md">
            <h4 class="card-title mb-0"> <i class="fa fa-list"></i> Liste des Bon de Petite Caisse (B.P.C)</h4>
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
                  <th>Actions</th>
                  <th>Numéro</th>
                  <th style="width: 30%">Motif</th>
                  <th><center>Montant</center></th>
                  <th>Code Ligne</th>
                  <th>Nom prénom</th>
                  <th>Créé par</th>
                  <th><center>Date op</center></th>
                  <th>
                    <center>Créé le</center>
                  </th>
                </tr>
              </thead>
              <tbody id="show_all">
                <tr>
                  <td colspan="9">
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


<div class="modal fade" id="addDealModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <form method="POST" id="addcompteform">
    @method('post')
    @csrf
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle">Nouveau décaissement </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">

          <div class="row g-3">
            <div class="col-sm-6 col-lg-12 col-xl-12">
              <label class="text-1000 fw-bold mb-2"> Composante/ Projet/Section </label>
              <input value="{{ Session::get('id') }} " type="hidden" name="projetid" id="projetid">
              <input value="{{ Session::get('title') }} " class="form-control form-control-sm" style="background-color:#c0c0c0" disabled>
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-2">
              <label class="text-1000 fw-bold mb-2">Numéro </label>
              <input type="text" name="numero" id="numero" class="form-control form-control-sm" require />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-2">
              <label class="text-1000 fw-bold mb-2">Date </label>
              <input type="date" name="date" id="date" class="form-control form-control-sm" require />
            </div>


            <div class="col-sm-6 col-lg-12 col-xl-5">
              <label class="text-1000 fw-bold mb-2">Compte d'approvisionnement :</label>
              <select class="form-control  form-control-sm" id="compteid" name="compteid" required>
                <option disabled="true" selected="true" value="">Sélectionner le compte</option>
                @forelse ($compte_bpc as $compte_bpc)
                                        <option value="{{ $compte_bpc->id }}"> {{ $compte_bpc->code }} : {{ $compte_bpc->libelle }} </option>
                                    @empty
                                        
                                        <option disabled="true" selected="true" value="">Pas de compte disponible pour ce projet</option>
                                  
                                    @endforelse

              </select>
            </div>


            <div class="col-sm-6 col-lg-12 col-xl-3">
              <center>
               
                <label class="text-1000 fw-bold mb-2">Est une personne interne ?</label>
                <br>
                <label>Oui</label>
                <input type="radio" class="form-check-input" name="internal_status" value="yes" id="oui" id="internalYes" checked>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <label>Non</label>
                <input type="radio" class="form-check-input" name="internal_status" value="no" id="non">
                <br>
            </div>



            <div class="col-sm-12 col-lg-12 col-xl-4 ">
              <label class="text-1000 fw-bold mb-2">Je soussigné (nom complet) :</label>
              <input type="text" name="nom_sousigne" id="nom_sousigne"  class="form-control form-control-sm" />
              </center>
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-4 ">
              <label class="text-1000 fw-bold mb-2">Titre (+ nom de l’organisation si différente de la CEPBU):</label>
              <input type="text" name="titre" id="titre"  class="form-control form-control-sm" />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-4 ">
              <label class="text-1000 fw-bold mb-2">Type de carte d’identité :</label>
              <input type="text" name="type_identite" id="type_identite" class="form-control form-control-sm" />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-4 ">
              <label class="text-1000 fw-bold mb-2">Numéro de la pièce d’identité:</label>
              <input type="text" name="numero_piece" id="numero_piece" class="form-control form-control-sm" />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-4 ">
              <label class="text-1000 fw-bold mb-2">Addresse :</label>
              <input type="text" name="adresse" id="adresse" class="form-control form-control-sm" />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-4 ">
              <label class="text-1000 fw-bold mb-2">Téléphone/Emai</label>
              <input type="text" name="telephone_email" id="telephone_email" class="form-control form-control-sm" />
            </div>

           


           
         


            <div class="table-responsive">
              <table class="table table-striped table-sm fs--1 mb-0" id="tableEstimate">
                <thead style="background-color:#3CB371; color:white">
                  <tr>
                    <th hidden><b>Num<span class="text-danger">*</span></b></th>
                    <th style="  color:white;"><b> Designation des activités de la ligne<span class="text-danger">*</span> </b></th>
                    <th style=" color:white"> <b> Motif  <span class="text-danger">*</span></b></th>
                    <th style=" color:white"> <b> Montant <span class="text-danger">*</span></b></th>

                    <th> </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td hidden><input style="width:100%" type="hidden" id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="1"></td>
                    <td style="width:40%">

                      <select class="form-control  form-control-sm select2-search-disable" id="referenceid" name="referenceid[]" >
                        <option value="">Ligne budgétaire</option>
                        @foreach ($compte as $comptes)
                        <optgroup label="{{ $comptes->libelle }}">
                          @php
                          $idc = $comptes->id ;
                          $res= DB::select("SELECT * FROM comptes WHERE compteid= $idc");
                          @endphp
                          @foreach($res as $re)
                          <option value="{{ $comptes->id }}-{{ $re->id }}-{{ $re->numero }}">{{ $re->numero }}. {{ $re->libelle }} </option>
                          @endforeach

                        </optgroup>
                        @endforeach

                      </select>

                    </td>
                    <td style="width:30%"><input style="width:100%" type="text" id="motif[]" name="motif[]" class="form-control form-control-sm" required></td>

                    <td><input style="width:100%" type="number" id="montant_details[]" name="montant_details[]" class="form-control form-control-sm" required></td>

                    <td><a href="javascript:void(0)" class="text-primary font-18" title="Add" id="addBtn"><i class="fa fa-plus-circle"></i></a></td>
                  </tr>
                </tbody>
              </table>
              <table class="table table-striped table-sm fs--1 mb-0">
                <tfoot style="background-color:#c0c0c0">
                  <tr>
                    <td colspan="8">Total global </td>
                    <td align="right">
                    <input type="hidden" id="totalInput" name="total_global" class="form-control" readonly>
                    <p class="total-global"></p>
                  
                  </td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>

            <br><br>



            <div class="table-repsonsive">
              <span id="error"></span>
              <table class="table table-striped table-sm fs--1 mb-0">
                <tr>
                <tr>
                  <td>Nom et signature du Bénéficiaire <span class="text-danger">*</span> </td>
                  <td>Nom et signature du  Distributeur <span class="text-danger">*</span></td>
                  <td>Nom et signature pour approbation <span class="text-danger">*</span></td>
                </tr>
                <tr>
                  <td>
                  <div class="col-sm-12 col-lg-12 col-xl-12 internal-fields d-none">
                    <select type="text" class="form-control form-control-sm" name="acce" id="acce" >
                      <option disabled="true" selected="true" value="">--Sélectionner personnel --</option>
                      @foreach ($personnel as $personnels)
                      <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-sm-12 col-lg-12 col-xl-12 external-fields d-none">
                  <input type="text" name="beneficiaire" class="form-control form-control-sm"   />

                  </div>
                  
                  </td>
                  <td>
                    <select type="text" class="form-control form-control-sm" name="comptable" id="comptable" required>
                      <option disabled="true" selected="true" value="">--Sélectionner personnel --</option>
                      @foreach ($personnel as $personnels)
                      <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <select type="text" class="form-control form-control-sm" name="chefcomposante" id="chefcomposante" required>
                      <option disabled="true" selected="true" value="">--Sélectionner personnel --</option>
                      @foreach ($personnel as $personnels)
                      <option value="{{ $personnels->userid }}"> {{ $personnels->nom }} {{ $personnels->prenom }}</option>
                      @endforeach
                    </select>
                  </td>
                </tr>
              </table>
            </div>
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="sendCompte" id="sendCompte" class="btn btn-primary waves-effect waves-light"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </form>
</div><!-- /.modal -->

</div>
</div>

</div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const internalStatusRadios = document.querySelectorAll('input[name="internal_status"]');
    const internalFields = document.querySelectorAll('.internal-fields');
    const externalFields = document.querySelectorAll('.external-fields');

    // Function to update field visibility based on selected radio button
    function updateFields() {
      const selectedValue = document.querySelector('input[name="internal_status"]:checked')?.value;
      if (selectedValue === 'yes') {
        internalFields.forEach(field => field.classList.remove('d-none'));
        externalFields.forEach(field => field.classList.add('d-none'));
      } else {
        internalFields.forEach(field => field.classList.add('d-none'));
        externalFields.forEach(field => field.classList.remove('d-none'));
      }
    }

    // Attach event listener to each radio button
    internalStatusRadios.forEach(radio => {
      radio.addEventListener('change', updateFields);
    });

    // Initialize the display on page load
    updateFields();
  });
</script>

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
  var rowIdx = 2;

  $("#addBtn").on("click", function() {
    $("#tableEstimate tbody").append(`
        <tr id="R${rowIdx}">
            <td hidden><input style="width:100%" type="hidden" id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="${rowIdx}"></td>
            <td style="width:40%">
                <select class="form-control form-control-sm select2-search-disable" id="referenceid${rowIdx}" name="referenceid[]" required>
                    <option value="">Ligne budgétaire</option>
                    @foreach ($compte as $comptes)
                    <optgroup label="{{ $comptes->libelle }}">
                    @php
                    $idc = $comptes->id ;
                    $res = DB::select("SELECT * FROM comptes WHERE compteid= $idc");
                    @endphp
                    @foreach($res as $re)
                    <option value="{{ $comptes->id }}-{{ $re->id }}-{{ $re->numero }}">{{ $re->numero }}. {{ $re->libelle }}</option>
                    @endforeach
                    </optgroup>
                    @endforeach
                </select>
            </td>
            <td style="width:20%"><input style="width:100%" type="text" id="motif[]" name="motif[]" class="form-control form-control-sm" required></td>
            <td><input style="width:100%" type="number" id="montant_details[]" name="montant_details[]" class="form-control form-control-sm" required></td>
            <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Enlever"><i class="far fa-trash-alt"></i></a></td>
        </tr>
    `);

    rowIdx++;
  });

  $("#tableEstimate tbody").on("click", ".remove", function() {
    $(this).closest("tr").remove();
    rowIdx--;

    // Recalculate row numbers after deletion
    $("#tableEstimate tbody tr").each(function(index, element) {
      $(element).find('input[id="numerodetail"]').val(index + 1);
    });

    calculateTotal();
  });

  function calculateTotal() {
    var total = 0;
    $('input[name="montant_details[]"]').each(function() {
      total += parseFloat($(this).val()) || 0;
    });

    // Formater le total avec des espaces pour les milliers
    var formattedTotal = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");

    // Afficher le total dans l'input et dans le texte
    $('#totalInput').val(total);  // Le champ input pour envoyer au contrôleur
    $('.total-global').text(formattedTotal + ' {{ Session::get("devise") }}');
  }

  $(document).on('input', 'input[name="montant_details[]"]', calculateTotal);
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
        url: "{{ route('storebpc') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          try {
            if (response.status == 200) {
              toastr.success("Petite compte ajouté avec succès. !", "Enregistrement");
              fetchallbpc();
              $("#sendCompte").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
              $("#addcompteform")[0].reset();
              $("#addDealModal").modal('hide');
            } else if (response.status == 201) {
              toastr.error("La ligne de compte dans ce projet existe déjà !", "Attention");
            } else if (response.status == 202) {
              toastr.error("Erreur lors de l'exécution : " + response.error, "Erreur");
            } else if (response.status == 203) {
              toastr.error("Le solde du compte est insuffisant pour exécuter cette demande. Veuillez créditer le compte. : " + response.error, "Erreur");
            } else {
              toastr.error("Réponse inattendue du serveur.", "Erreur");
            }
          } catch (error) {
            toastr.error("Erreur inattendue : " + error.message, "Erreur");
          } finally {
            $("#sendCompte").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("sendCompte").disabled = false;
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          let errorMessage;
          if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
            errorMessage = jqXHR.responseJSON.error;
          } else if (jqXHR.responseText) {
            errorMessage = jqXHR.responseText;
          } else if (textStatus) {
            errorMessage = textStatus;
          } else if (errorThrown) {
            errorMessage = errorThrown;
          } else {
            errorMessage = "Erreur inconnue";
          }

          toastr.error("Erreur lors de la requête : " + errorMessage, "Erreur");
          $("#sendCompte").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
          document.getElementById("sendCompte").disabled = false;
        }
      });
    });



    // Edit fonction ajax request
    $(document).on('click', '.editCaisse', function(e) {
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
          $("#c_code").val(response.code);
          $("#c_description").val(response.description);
          $("#c_id").val(response.id);
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