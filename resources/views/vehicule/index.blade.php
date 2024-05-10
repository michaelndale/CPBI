@extends('layout/app')
@section('page-content')

<style type="text/css">
  .has-error {
    border: 1px solid red;
  }
</style>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
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
                    <h6><i class="fa fa-car"></i> Gestions des vehicules </h6>
                    <div class="page-title-right">
                      <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addVehiculeModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau véhicule</a>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered table-sm fs--1 mb-0">
                    <thead>
                      <tr style="background-color:#82E0AA">
                        <th class="align-middle ps-3 name">#</th>
                        <th>Blaque</th>
                        <th>Marque</th>
                        <th>Modèle</th>
                        <th>N<sup>o</sup> Série</th>
                        <th>Couleur</th>
                        <th>Type</th>
                        <th>Carburent</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>
                          <center>Action</center>
                        </th>
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
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane" id="profile1" role="tabpanel">
              <div class="table-responsive">
              <table class="table table-bordered  table-sm fs--1 mb-0">
                <thead>
                 
                  <tr style="background-color:#82E0AA">
                  <th> Nom & prenom </th>
              <th>Telephone</th>
              <th >Fonction</th>
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
              </div>
               
              </div>
              <div class="tab-pane" id="messages1" role="tabpanel">
                <p class="mb-0">
                  Etsy mixtape wayfarers, ethical wes anderson tofu before they
                  sold out mcsweeney's organic lomo retro fanny pack lo-fi
                  farm-to-table readymade. Messenger bag gentrify pitchfork
                  tattooed craft beer, iphone skateboard locavore carles etsy
                  salvia banksy hoodie helvetica. DIY synth PBR banksy irony.
                  Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh
                  mi whatever gluten-free carles.
                </p>
              </div>
              <div class="tab-pane" id="settings1" role="tabpanel">
                <p class="mb-0">
                  Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                  art party before they sold out master cleanse gluten-free squid
                  scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                  art party locavore wolf cliche high life echo park Austin. Cred
                  vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                  farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral,
                  mustache readymade keffiyeh craft.
                </p>
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

<script>
  $(function() {

    $('#addVehiculeModal').modal({
      backdrop: 'static',
      keyboard: false
    });


    // Add user ajax 
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

    // Edit user ajax request
    $(document).on('click', '.editIcon', function(e) {
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
            fetchAllvehicule();

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

  });
</script>

@endsection