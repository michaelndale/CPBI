@extends('layout/app')
@section('page-content')

<style type="text/css">
  .has-error {
    border: 1px solid red;
  }
</style>
<div class="main-content">
  <div class="page-content">
    
      <div class="row">
        <div class="col-12" style="margin:auto">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="fas fa-car-crash"></i> GESTION DES ENTRETIENS & réparations</h4>
          </div>
        </div>
      </div>

      <div class="col-xl-12">
        <div class="card">
          <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                  <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                  <span class="d-none d-sm-block"><i class="fas fa-car-crash"></i> Entretiens & Réparations</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab">
                  <span class="d-block d-sm-none"><i class="fa fa-list"></i></span>
                  <span class="d-none d-sm-block"> <i class="fas fa-list"></i> Programme entrertien </span>
                </a>
              </li>

            </ul>

            <!-- Tab panes -->
            <div class="tab-content p-3 text-muted">
              <div class="tab-pane active" id="home1" role="tabpanel">

                <div class="col-12" style="margin:auto">
                  <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h6><i class="fa fa-car"></i> Gestions des entretiens </h6>
                    <div class="page-title-right">
                      <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#entretientModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Enregistrement des entretiens</a>
                    </div>
                  </div>
                </div>

                <div class="table-responsive">
                  <table class="table table-bordered table-sm fs--1 mb-0">
                    <thead>
                      <tr style="background-color:#82E0AA">
                        <th class="align-middle ps-3 name">#</th>
                        <th>Véhicule</th>
                        <th>Date entretien</th>
                        <th>Type d'entretien </th>
                        <th>Coût</th>
                        <th>Kilométrage</th>
                        <th>Garage</th>
                        <th>Créé par</th>
                        <th>Créé le</th>
                        <th>
                          <center>Actions</center>
                        </th>
                      </tr>
                    </thead>
                    <tbody id="show_entretien">
                      <tr>
                        <td colspan="11">
                          <h5 class="text-center text-secondery my-5">
                            @include('layout.partiels.load')
                        </td>
                      </tr>
                    </tbody>
                    </tbody>
                  </table>
                </div>
              </div>



              <div class="tab-pane" id="messages1" role="tabpanel">

                <div class="col-12" style="margin:auto">
                  <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h6><i class="fa fa-car"></i> Programme entrertien</h6>
                    <div class="page-title-right">
                      <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addprogrammeModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Enregistrer Programme entrertien</a>
                    </div>
                  </div>
                </div>

                <div class="table-responsive">
                  <table class="table table-bordered table-sm fs--1 mb-0">
                    <thead>
                      <tr style="background-color:#82E0AA">
                        <th class="align-middle ps-3 name">#</th>
                        <th>Véhicule</th>
                        <th>Type d'entretien</th>
                        <th>Date prevu</th>
                        <th>Description</th>
                        <th>Créé par</th>
                        <th>Créé le</th>
                        <th>
                          <center>Action</center>
                        </th>
                      </tr>
                    </thead>
                    <tbody id="show_programme">
                      <tr>
                        <td colspan="11">
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
        </div>
      </div>




      <div class="row">
        <div class="col-lg-12" style="margin:auto">
          <div class="card">

          </div>
        </div>
      </div>
    </div> <!-- container-fluid -->
  </div>
</div>

@include('entretient.modale')
@include('entretient.achat_modale')

<script>
  // Variable pour stocker le numéro de ligne actuel
  var rowIdx = 2;
  // Ajouter une ligne au clic sur le bouton "Ajouter"
  $("#addBtn").on("click", function() {
    // Ajouter une nouvelle ligne au tableau
    $("#tableEstimate tbody").append(`
        <tr id="R${rowIdx}">
            <td><input style="width:100%" type="number"  id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="${rowIdx}" ></td>
            <td><input style="width:100%" type="text"    id="libelle"      name="libelle[]"      class="form-control form-control-sm" required></td>
            <td><input style="width:100%" type="text"    id="unit_cost"    name="unit_cost[]"    class="form-control form-control-sm" required></td>
            <td><input style="width:100%" type="text"    id="qty"          name="qty[]"          class="form-control form-control-sm qty" required ></td>
            <td><input style="width:100%" type="number"  id="pu"           name="pu[]"   min="0" class="form-control form-control-sm pu"  required></td>
            <td><input style="width:100%" type="number"  id="amount"       name="amount[]"   min="0"  class="form-control form-control-sm total" value="0" readonly></td>
            <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Enlever"><i class="far fa-trash-alt"></i></a></td>
        </tr>
    `);
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

  // Mettre à jour les totaux lors de la modification des champs "pu" et "qty"
  $("#tableEstimate tbody").on("input", ".pu, .qty", function() {
    var pu = parseFloat($(this).closest("tr").find(".pu").val()) || 0;
    var qty = parseFloat($(this).closest("tr").find(".qty").val()) || 0;
    var total = pu * qty;
    $(this).closest("tr").find(".total").val(total.toFixed(2));
    calc_total();
  });

  // Fonction pour calculer le total
  function calc_total() {
    var sum = 0;
    $(".total").each(function() {
      sum += parseFloat($(this).val()) || 0;
    });
    $(".subtotal").text(sum.toFixed(2));
    // Mettre à jour le total global
    $(".total-global").text(sum.toFixed(2));
    // Mettre à jour la valeur de l'input caché
    $("input[name='couttotal']").val(sum.toFixed(2));
  }
</script>

<script>
  $(function() {

    $('#entretientModal').modal({
      backdrop: 'static',
      keyboard: false
    });

    $('#addprogrammeModal').modal({
      backdrop: 'static',
      keyboard: false
    });

    

    // Add Entretien
    $("#addEntretienForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#addentretientbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("addentretientbtn").disabled = true;

      $.ajax({
        url: "{{ route('storeEntretien') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status === 200) {
            show_entretien();
            show_programme();
            toastr.success("Enregistrement réussi avec succès !", "Enregistrement");
            $("#addentretientbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#entretientModal").modal('hide');
            $("#addEntretienForm")[0].reset();

            document.getElementById("addentretientbtn").disabled = false;

          } else if (response.status === 400) {
            toastr.error("Erreur de validation : " + JSON.stringify(response.errors), "Erreur de validation");
            $("#addentretientbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("addentretientbtn").disabled = false;
          } else if (response.status === 500) {
            toastr.error("Erreur du serveur : " + response.error, "Erreur du serveur");
            $("#addentretientbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("addentretientbtn").disabled = false;
          } else if (response.status === 201) {
            toastr.error("Le véhicule avec cette matricule existe déjà !", "Erreur");
            $("#addentretientbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addEntretienForm").modal('show');
            document.getElementById("addentretientbtn").disabled = false;
          } else if (response.status === 202) {
            toastr.error("Erreur d'exécution, vérifiez votre internet", "Erreur");
            $("#addentretientbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("addentretientbtn").disabled = false;
          }
        },
        error: function(xhr, status, error) {
          toastr.error("Une erreur est survenue : " + error, "Erreur");
          $("#addentretientbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
          document.getElementById("addentretientbtn").disabled = false;
        }
      });
    });

    // Add Programme
    $("#addprogrammeform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#addProgrammebtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("addProgrammebtn").disabled = true;

      $.ajax({
        url: "{{ route('storeProgramme') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status === 200) {
            show_programme();
            toastr.success("Enregistrement réussi avec succès !", "Enregistrement");
            $("#addProgrammebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addprogrammeModal").modal('hide');
            $("#addprogrammeform")[0].reset();
            document.getElementById("addProgrammebtn").disabled = false;
          } 
          else if (response.status === 400) {
            toastr.error("Erreur de validation : " + JSON.stringify(response.errors), "Erreur de validation");
            $("#addProgrammebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("addProgrammebtn").disabled = false;
          } 
          else if (response.status === 500) {
            toastr.error("Erreur du serveur : " + response.error, "Erreur du serveur");
            $("#addProgrammebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("addProgrammebtn").disabled = false;
          } 
          else if (response.status === 201) {
            toastr.error("Le véhicule avec cette matricule existe déjà !", "Erreur");
            $("#addProgrammebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addEntretienForm").modal('show');
            document.getElementById("addProgrammebtn").disabled = false;
          } 
          else if (response.status === 202) {
            toastr.error("Erreur d'exécution, vérifiez votre internet", "Erreur");
            $("#addProgrammebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("addProgrammebtn").disabled = false;
          }
        },
        error: function(xhr, status, error) {
          toastr.error("Une erreur est survenue : " + error, "Erreur");
          $("#addProgrammebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
          document.getElementById("addProgrammebtn").disabled = false;
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
            url: "{{ route('deleteEntretien') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {

              if (response.status == 200) {
                toastr.success("Suppression  avec succès !", "Suppression");

                show_entretien();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de supprimer ce type de véhicule!", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
            }
          });
        }
      })
    });

    $(document).on('click', '.deleteEntretient', function(e) {
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
            url: "{{ route('deleteProgramme') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {

              if (response.status == 200) {
                toastr.success("Suppression  avec succès !", "Suppression");

                show_programme();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de supprimer ce type de véhicule!", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
            }
          });
        }
      })
    });

    show_entretien();

    function show_entretien() {
      $.ajax({
        url: "{{ route('allentretien') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_entretien").html(reponse);
        }
      });
    }

    show_programme();
    function show_programme() {
      $.ajax({
        url: "{{ route('allprogramme') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_programme").html(reponse);
        }
      });
    }

  });
</script>

@endsection