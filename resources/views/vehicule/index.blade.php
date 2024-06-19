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
            <h4 class="mb-sm-0"><i class="fa fa-car"></i> GESTION DES VÉHICULES </h4>
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
                  <span class="d-none d-sm-block"><i class="fa fa-car"></i> Véhicules</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                  <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                  <span class="d-none d-sm-block"><i class="fa fa-users"></i> Conducteurs</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab">
                  <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                  <span class="d-none d-sm-block">Achats/Location</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#settings1" role="tab">
                  <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                  <span class="d-none d-sm-block">Assurances/taxes/visites</span>
                </a>
              </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content p-3 text-muted">
              <div class="tab-pane active" id="home1" role="tabpanel">

                <div class="col-12" style="margin:auto">
                  <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h6><i class="fa fa-car"></i> Gestions des véhicules </h6>
                    <div class="page-title-right">
                      <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addVehiculeModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Ajout de nouveaux véhicules</a>
                    </div>
                  </div>
                </div>

                <div class="table-responsive">
                  <table class="table table-bordered table-sm fs--1 mb-0">
                    <thead>
                      <tr style="background-color:#82E0AA">
                        <th class="align-middle ps-3 name">#</th>
                        <th>Plaque</th>
                        <th>Marque</th>
                        <th>Modèle</th>
                        <th>N<sup>o</sup> Série</th>
                        <th>Couleur</th>
                        <th>Type</th>
                        <th>Carburant</th>
                        <th>Année</th>
                        <th>Numéro chassis</th>
                        <th>Statut</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody id="show_all_vehicule">
                      <tr>
                        <td colspan="11">
                          <h5 class="text-center text-secondery my-5">
                            @include('layout.partiels.load')
                        </td>
                      </tr>
                    </tbody>
                   
                  </table>

                  <br><br><br><br><br><br>
                </div>
              </div>


              <div class="tab-pane" id="profile1" role="tabpanel">
                <div class="table-responsive">
                  <table class="table table-bordered  table-sm fs--1 mb-0">
                    <thead>

                      <tr style="background-color:#82E0AA">
                        <th> Nom & prénom </th>
                        <th>Téléphone</th>
                        <th>Fonction</th>
                        <th>Permis de conduire</th>
                        <th>Statut</th>

                      </tr>

                    </thead>
                    <tbody class="list" id="show_all">
                      <tr>
                        <td colspan="8">
                          <h5 class="text-center text-secondery my-5">
                            @include('layout.partiels.load')
                        </td>
                      </tr>
                    </tbody>

                  </table>
                  <br><br><br><br><br><br>
                </div>

              </div>
              <div class="tab-pane" id="messages1" role="tabpanel">

                <div class="col-12" style="margin:auto">
                  <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h6><i class="fa fa-car"></i> Achats / Location</h6>
                    <div class="page-title-right">
                      <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addAchatModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau Achats / Location</a>
                    </div>
                  </div>
                </div>

                <div class="table-responsive">
                  <table class="table table-bordered table-sm fs--1 mb-0">
                    <thead>
                      <tr style="background-color:#82E0AA">
                        <th class="align-middle ps-3 name">#</th>
                        <th>Location/Achat</th>
                        <th>Date</th>
                        <th>Kilomètrage</th>
                        <th>Prix vente</th>
                        <th>Expiration</th>
                        <th>Véhicule</th>
                        <th>Fournisseur</th>
                        <th>Note</th>
                        <th>Créé le</th>
                        <th><center>Actions</center></th>
                      </tr>
                    </thead>
                    <tbody id="show_location">
                      <tr>
                        <td colspan="11">
                          <h5 class="text-center text-secondery my-5">
                            @include('layout.partiels.load')
                        </td>
                      </tr>
                    </tbody>
                    </tbody>
                  </table>
                  <br><br><br><br><br><br>
                </div>

              </div>


              <div class="tab-pane" id="settings1" role="tabpanel">
              <div class="col-12" style="margin:auto">
                  <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h6><i class="fa fa-car"></i> Assurances/Taxes/Visites</h6>
                    <div class="page-title-right">
                      <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addassurenceModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau Assurances/Taxes/Visites</a>
                    </div>
                  </div>
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

@include('vehicule.modale')
@include('vehicule.achat_modale')

<script>
  $(function() {

    $('#addVehiculeModal').modal({
      backdrop: 'static',
      keyboard: false
    });

    // Add vehicule ajax 
    $("#addform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#addbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("addbtn").disabled = true;

      $.ajax({
        url: "{{ route('storevl') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            fetchAllvehicule();
            toastr.success("Enregistrement reussi avec succès !", "Enregistrement");
            $("#addbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#matricule_error").text("");
            $('#matricule').addClass('');
            $("#addVehiculeModal").modal('hide');
            $("#addform")[0].reset();
            document.getElementById("addbtn").disabled = false;
          }

          if (response.status == 201) {
            toastr.error("Le véhicule avec cette matricule existe déjà !", "error");
            $("#addbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addVehiculeModal").modal('show');
            $("#matricule_error").text("Matricule existe déjà !");
            $('#matricule').addClass('has-error');
            document.getElementById("addbtn").disabled = false;
          }

          if (response.status == 202) {
            toastr.error("Erreur d'execution, verifier votre internet", "error");
            $("#addVehiculeModal").modal('show');
            $("#addbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("addbtn").disabled = false;
          }

        }
      });
    });

    // Add Achat/Location ajax 
    $("#addaform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#addabtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("addabtn").disabled = true;

      $.ajax({
        url: "{{ route('storeachat') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            fetchlocation();
            toastr.success("Enregistrement reussi avec succès !", "Enregistrement");
            $("#addabtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addAchatModal").modal('hide');
            $("#addaform")[0].reset();
            document.getElementById("addabtn").disabled = false;
          }

          if (response.status == 201) {
            $("#addabtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addAchatModal").modal('show');
            document.getElementById("addabtn").disabled = false;
          }

          if (response.status == 202) {
            toastr.error("Erreur d'exécution: " + response.message, "Erreur");
            $("#addAchatModal").modal('show');
            $("#addabtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("addabtn").disabled = false;
          }

        }
      });
    });

    // Get vehicule  request 
    $(document).on('click', '.editvehicule', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('editveh') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#idv").val(response.id);
          $("#matriculev").val(response.matricule);
          $("#marquev").val(response.marque);
          $("#modelev").val(response.modele);
          $("#couleurv").val(response.couleur);
          $("#numseriev").val(response.numeroserie);
          $("#typev").val(response.type);
          $("#carburentv").val(response.carburent);
          $("#statutv").val(response.statut);
          $("#cannee").val(response.annee);
          $("#cnumero_chassis").val(response.numero_chassis);
        }
      });
    });

    $(document).on('click', '.voirvehicule', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('showvehicule') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
     
          $("#dmatricule").val(response.matricule);
          $("#dmarque").val(response.marque);
          $("#dmodele").val(response.modele);
          $("#dcouleur").val(response.couleur);
          $("#dnumserie").val(response.numeroserie);
          $("#dtype").val(response.type);
          $("#dcarburent").val(response.carburent);
          $("#dstatut").val(response.statut);
          $("#dannee").val(response.annee);
          $("#dnumero_chassis").val(response.numero_chassis);
        }
      });
    });

    // update user ajax request
    $("#editform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

    
      $("#editbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("editbtn").disabled = true;

      $.ajax({
        url: "{{ route('updateveh') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Mises ajours reussi  avec succès !", "Suppression");
            $("#edit_vehiculeModal").modal('hide');
            $("#editbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("editbtn").disabled = false;

            fetchAllvehicule();

          }

          if (response.status == 201) {
            toastr.error("Le véhicule avec cette matricule existe déjà !", "error");
            $("#editbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#edit_vehiculeModal").modal('show');
            document.getElementById("editbtn").disabled = false;
          }

          if (response.status == 202) {
            toastr.error("Erreur d'execution, verifier votre internet", "error");
            $("#edit_vehiculeModal").modal('show');
            $("#editbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("editbtn").disabled = false;
          }

          
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
            url: "{{ route('deletevl') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {

              if (response.status == 200) {
                toastr.success("Suppression  avec succès !", "Suppression");

                fetchAllvehicule();
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

    // Delete Achat location ajax request
    $(document).on('click', '.deleteachat', function(e) {
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
            url: "{{ route('deleteachat') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {

              if (response.status == 200) {
                toastr.success("Suppression  avec succès !", "Suppression");

                fetchlocation();
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


    

    fetchAllvehicule();

    function fetchAllvehicule() {
      $.ajax({
        url: "{{ route('fetchAllvl') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all_vehicule").html(reponse);
        }
      });
    }

    fetchAllUsers();

    function fetchAllUsers() {
      $.ajax({
        url: "{{ route('fetchAllcond') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all").html(reponse);
        }
      });
    }

    fetchlocation();

    function fetchlocation() {
      $.ajax({
        url: "{{ route('fetchachat') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_location").html(reponse);
        }
      });
    }

  });
</script>

@endsection