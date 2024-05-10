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
            <h4 class="mb-sm-0"><i class="fa fa-users"></i> Outils gestion Parc automobile </h4>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">Type véhicule</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                    <span class="d-none d-sm-block">Type Carburant</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab">
                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                    <span class="d-none d-sm-block">Type de statut véhicule</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#settings1" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                    <span class="d-none d-sm-block">Fournisseurs</span>
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#piece" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                    <span class="d-none d-sm-block">Pieces</span>
                  </a>
                </li>
              </ul>

              <!-- Tab panes -->
              <div class="tab-content p-3 text-muted">
                <div class="tab-pane active" id="home1" role="tabpanel">
                  <div class="row">
                    <div class="col-12" style="margin:auto">
                      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h6 class="mb-sm-0"><i class="fa fa-car"></i> Type de véhicule </h6>

                        <div class="page-title-right">
                          <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addtypeModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau type de véhicule</a>

                        </div>

                      </div>
                    </div>
                  </div>

                  <table class="table table-bordered  table-sm fs--1 mb-0">
                    <thead>
                      <tr style="background-color:#82E0AA">
                        <th style="width:5%">#</th>
                        <th>Libellé</th>
                        <th style="width:25%">
                          <center>Action</center>
                        </th>
                      </tr>
                    </thead>
                    <tbody id="showAllType">
                      <tr>
                        <td colspan="3">
                          <h5 class="text-center text-secondery my-5">
                            @include('layout.partiels.load')
                        </td>
                      </tr>
                    </tbody>
                    </tbody>
                  </table>

                  <div class="modal fade" id="addtypeModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                      <form id="add_type_form" autocomplete="off">
                        @method('post')
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-car"></i> Nouveau type de véhicule</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <label class="text-1000 fw-bold mb-2">Titre</label>
                            <input class="form-control" name="titre" id="titre" type="text" placeholder="Entrer le titre" required />
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="sendType" id="sendType" value="Sauvegarder" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>


                  {{-- Edit Titre modal --}}
                  <div class="modal fade" id="editTypeModal" tabindex="-1" aria-labelledby="editTypeModal" aria-hidden="true">
                    <div class="modal-dialog">
                      <form autocomplete="off" id="edit_type_form">
                        @method('post')
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-edit"></i> Modification type  véhicule</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <label class="text-1000 fw-bold mb-2">Titre</label>
                            <input type="hidden" name="tid" id="tid">
                            <input class="form-control" name="ttitre" id="ttitre" type="text" placeholder="Entrer dossier" required />
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="edittypebtn" id="edittypebtn" value="Sauvegarder" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                </div>
                <div class="tab-pane" id="profile1" role="tabpanel">
                    <div class="row">
                    <div class="col-12" style="margin:auto">
                      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h6 class="mb-sm-0"><i class="fa fa-stopwatch"></i> Type carburant </h6>

                        <div class="page-title-right">
                          <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addcarburentModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau carburant</a>

                        </div>

                      </div>
                    </div>
                  </div>

                  <table class="table table-bordered  table-sm fs--1 mb-0">
                    <thead>
                      <tr style="background-color:#82E0AA">
                        <th style="width:5%">#</th>
                        <th>Libellé</th>
                        <th style="width:25%">
                          <center>Action</center>
                        </th>
                      </tr>
                    </thead>
                    <tbody id="showcarburent">
                      <tr>
                        <td colspan="3">
                          <h5 class="text-center text-secondery my-5">
                            @include('layout.partiels.load')
                        </td>
                      </tr>
                    </tbody>
                    </tbody>
                  </table>

                  <div class="modal fade" id="addcarburentModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                      <form id="add_carburent_form" autocomplete="off">
                        @method('post')
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-stopwatch"></i> Nouveau carburant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <label class="text-1000 fw-bold mb-2">Titre</label>
                            <input class="form-control" name="libellec" id="libellec" type="text" placeholder="Entrer le titre" required />
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="sendCar" id="sendCar" value="Sauvegarder" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>


                  {{-- Edit Titre modal --}}
                  <div class="modal fade" id="editCarModal" tabindex="-1" aria-labelledby="editCarModal" aria-hidden="true">
                    <div class="modal-dialog">
                      <form autocomplete="off" id="edit_carburent_form">
                        @method('post')
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-edit"></i> Modification carburant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <label class="text-1000 fw-bold mb-2">Titre</label>
                            <input type="hidden" name="cid" id="cid">
                            <input class="form-control" name="clibelle" id="clibelle" type="text" placeholder="Entrer dossier" required />
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="editcarbtn" id="editcarbtn" value="Sauvegarder" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>



                </div>


                <div class="tab-pane" id="messages1" role="tabpanel">
                <div class="row">
                    <div class="col-12" style="margin:auto">
                      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h6 class="mb-sm-0"><i class="fa fa-stopwatch"></i> Statut du véhicule </h6>

                        <div class="page-title-right">
                          <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addStatutModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau statut du véhicule</a>

                        </div>

                      </div>
                    </div>
                  </div>

                  <table class="table table-bordered  table-sm fs--1 mb-0">
                    <thead>
                      <tr style="background-color:#82E0AA">
                        <th style="width:5%">#</th>
                        <th>Libellé</th>
                        <th style="width:25%">
                          <center>Action</center>
                        </th>
                      </tr>
                    </thead>
                    <tbody id="showstatut">
                      <tr>
                        <td colspan="3">
                          <h5 class="text-center text-secondery my-5">
                            @include('layout.partiels.load')
                        </td>
                      </tr>
                    </tbody>
                    </tbody>
                  </table>

                  <div class="modal fade" id="addStatutModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                      <form id="add_statut_form" autocomplete="off">
                        @method('post')
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-stopwatch"></i> Nouveau statut  véhicule</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <label class="text-1000 fw-bold mb-2">Titre</label>
                            <input class="form-control" name="s_titre" id="s_titre" type="text" placeholder="Entrer le titre" required />
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="sendStatut" id="sendStatut" value="Sauvegarder" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>


                  {{-- Edit Titre modal --}}
                  <div class="modal fade" id="editStatutModal" tabindex="-1" aria-labelledby="editStatutModal" aria-hidden="true">
                    <div class="modal-dialog">
                      <form autocomplete="off" id="edit_statut_form">
                        @method('post')
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-edit"></i> Modification carburant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <label class="text-1000 fw-bold mb-2">Titre</label>
                            <input type="hidden" name="id_s" id="id_s">
                            <input class="form-control" name="titre_s" id="titre_s" type="text" placeholder="Entrer titre" required />
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="editstatutbtn" id="editstatutbtn" value="Sauvegarder" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  
                </div>


                <div class="tab-pane" id="settings1" role="tabpanel">
                <div class="col-12" style="margin:auto">
                      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h6 class="mb-sm-0"><i class="fa fa-users"></i> Fournisseurs </h6>

                        <div class="page-title-right">
                          <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addfournisseurModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau fournisseur</a>

                        </div>

                      </div>
                    </div>
                <div class="table-responsive">
                  <table class="table table-bordered table-sm fs--1 mb-0">
                    <thead>
                      <tr style="background-color:#82E0AA">
                        <th class="align-middle ps-3 name">#</th>
                        <th>Nom</th>
                        <th>Adresse</th>
                        <th>Telephone</th>
                        <th>email</th>
                        <th>type</th>
                        <th>Date</th>
                        <th><center>Action</center></th>
                      </tr>
                    </thead>
                    <tbody id="show_all_fournisseur">
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

                <div class="tab-pane" id="piece" role="tabpanel">
                <div class="col-12" style="margin:auto">
                      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h6 class="mb-sm-0"><i class="fa fa-car"></i> Pieces</h6>

                        <div class="page-title-right">
                          <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addpieceModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouvelle piece</a>

                        </div>

                      </div>
                    </div>
                <div class="table-responsive">
                  <table class="table table-bordered table-sm fs--1 mb-0">
                    <thead>
                      <tr style="background-color:#82E0AA">
                        <th class="align-middle ps-3 name">#</th>
                        <th>Nom</th>
                        <th>Numero</th>
                        <th>Fournisseur</th>
                        <th>Numero</th>
                        <th>Prix</th>
                        <th>Date prix</th>
                        <th><center>Action</center></th>
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
              </div>

            </div>
          </div>
        </div>

      </div>

    </div>
  </div> <!-- container-fluid -->
  <br><br> <br><br> <br><br> <br><br>
</div>
</div>
<script>
  $(function() {
    // Add department ajax 
    $("#add_type_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#sendType").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("sendType").disabled = true;

      $.ajax({
        url: "{{ route('storetype') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Enregistrement reussi avec succès !", "Enregistrement");
            fetchtype();

            $("#sendType").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#add_type_form")[0].reset();
            $("#addtypeModal").modal('hide');
            document.getElementById("sendType").disabled = false;
          }

          if (response.status == 201) {
            toastr.error("Type existe déjà !", "Erreur");
            $("#sendType").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addtypeModal").modal('show');
            document.getElementById("sendType").disabled = false;
          }
        }

      });
    });

    // Ajouter carburent
    $("#add_carburent_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#sendCar").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("sendType").disabled = true;

      $.ajax({
        url: "{{ route('storecarburent') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Enregistrement reussi avec succès !", "Enregistrement");
       
            fetchcarburent();

            $("#sendCar").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#add_carburent_form")[0].reset();
            $("#addcarburentModal").modal('hide');
            document.getElementById("sendType").disabled = false;
          }

          if (response.status == 201) {
            toastr.error("Titre carburant existe déjà !", "Erreur");
            $("#sendCar").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addcarburentModal").modal('show');
            document.getElementById("sendCar").disabled = false;
          }
        }

      });
    });

     // Ajouter statut
    $("#add_statut_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#sendStatut").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("sendStatut").disabled = true;

      $.ajax({
        url: "{{ route('storestatut') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Enregistrement reussi avec succès !", "Enregistrement");
          
            fetchstatut();

            $("#sendStatut").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#add_statut_form")[0].reset();
            $("#addStatutModal").modal('hide');
            document.getElementById("sendStatut").disabled = false;
          }

          if (response.status == 201) {
            toastr.error("Statut existe déjà !", "Erreur");
            $("#sendStatut").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addStatutModal").modal('show');
            document.getElementById("sendStatut").disabled = false;
          }
        }

      });
    });
    

    // recuperation Type ajax request
    $(document).on('click', '.editType', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('edittype') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#ttitre").val(response.libelle);
          $("#tid").val(response.id);
        }
      });
    });

     // recuperation carburant ajax request
     $(document).on('click', '.editcarburent', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('editcarburent') }}",
        method: 'get', 
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#clibelle").val(response.libelle);
          $("#cid").val(response.id);
        }
      });
    });

    // recuperation statut
    $(document).on('click', '.editStatut', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('editstatut') }}",
        method: 'get', 
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#titre_s").val(response.titre);
          $("#id_s").val(response.id);
        }
      });
    });

    // update type ajax request
    $("#edit_type_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this); 

      $("#edittypebtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("edittypebtn").disabled = true;

      $.ajax({
        url: "{{ route('updatetype') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Modification reussi avec succès !", "Modification");
            fetchtype();
            fetchcarburent();

            $("#edittypebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#edit_type_form")[0].reset();
            $("#editTypeModal").modal('hide');
            document.getElementById("edittypebtn").disabled = false;
          }

          if (response.status == 201) {
            toastr.error("Type de véhicule existe déjà !", "Erreur");
            $("#edittypebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#editTypeModal").modal('show');
            document.getElementById("edittypebtn").disabled = false;
          }

          if (response.status == 203) {
            toastr.error("Erreur d'exécution: " + response.error, "Erreur");
            $("#editTypeModal").modal('show');
            $("#edittypebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("edittypebtn").disabled = false;
          }

          if (response.status == 205) {
            toastr.error("Vous n'avez pas l'accreditation de Type de véhicule!", "Erreur");
            $("#editTypeModal").modal('show');
            $("#edittypebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("edittypebtn").disabled = false;
          }

        }
      });
    });

     // update carburent ajax request
     $("#edit_carburent_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this); 

      $("#editcarbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("editcarbtn").disabled = true;

      $.ajax({
        url: "{{ route('updatecarburent') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Modification reussi avec succès !", "Modification");
            fetchtype();
            fetchcarburent();

            $("#editcarbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#edit_carburent_form")[0].reset();
            $("#editCarModal").modal('hide');
            document.getElementById("editcarbtn").disabled = false;
          }

          if (response.status == 201) {
            toastr.error("Type de véhicule existe déjà !", "Erreur");
            $("#editcarbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#editCarModal").modal('show');
            document.getElementById("editcarbtn").disabled = false;
          }

          if (response.status == 203) {
            toastr.error("Erreur d'exécution: " + response.error, "Erreur");
            $("#editCarModal").modal('show');
            $("#editcarbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("editcarbtn").disabled = false;
          }

          if (response.status == 205) {
            toastr.error("Vous n'avez pas l'accreditation de Type de véhicule!", "Erreur");
            $("#editCarModal").modal('show');
            $("#editcarbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("editcarbtn").disabled = false;
          }

        }
      });
    });

     // update statut ajax request
     $("#edit_statut_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this); 

      $("#editstatutbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("editstatutbtn").disabled = true;

      $.ajax({
        url: "{{ route('updatestatut') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Modification reussi avec succès !", "Modification");
            fetchstatut();

            $("#editstatutbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#edit_statut_form")[0].reset();
            $("#editStatutModal").modal('hide');
            document.getElementById("editstatutbtn").disabled = false;
          }

          if (response.status == 201) {
            toastr.error("Type de véhicule existe déjà !", "Erreur");
            $("#editstatutbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#editStatutModal").modal('show');
            document.getElementById("editstatutbtn").disabled = false;
          }

          if (response.status == 203) {
            toastr.error("Erreur d'exécution: " + response.error, "Erreur");
            $("#editStatutModal").modal('show');
            $("#editstatutbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("editstatutbtn").disabled = false;
          }

          if (response.status == 205) {
            toastr.error("Vous n'avez pas l'accreditation de Type de véhicule!", "Erreur");
            $("#editStatutModal").modal('show');
            $("#editstatutbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("editstatutbtn").disabled = false;
          }

        }
      });
    });

    // Delete service ajax request
    $(document).on('click', '.deleteType', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Êtes vous sûr de vouloir supprimer?',
        text: "Si vous le faite vous ne pouvez plus revenir en arrière !",

        showCancelButton: true,
        confirmButtonColor: 'Green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer!',
        cancelButtonText: 'Annuler',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('deletetype') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {


              if (response.status == 200) {
                toastr.success("Type de véhicule supprimer avec succès !", "Suppression");
                fetchtype();
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

    // delete type vehicule
    $(document).on('click', '.deleteCar', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Êtes vous sûr de vouloir supprimer?',
        text: "Si vous le faite vous ne pouvez plus revenir en arrière !",

        showCancelButton: true,
        confirmButtonColor: 'Green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer!',
        cancelButtonText: 'Annuler',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('deletecartburent') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {


              if (response.status == 200) {
                toastr.success("Suppression  avec succès !", "Suppression");
                fetchtype();
                fetchcarburent();
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

    // delete statut
    $(document).on('click', '.deleteStatut', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Êtes vous sûr de vouloir supprimer?',
        text: "Si vous le faite vous ne pouvez plus revenir en arrière !",

        showCancelButton: true,
        confirmButtonColor: 'Green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer!',
        cancelButtonText: 'Annuler',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('deletestatut') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {


              if (response.status == 200) {
                toastr.success("Suppression  avec succès !", "Suppression");
             
                fetchstatut();
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


    

    fetchtype();

    function fetchtype() {
      $.ajax({
        url: "{{ route('alltype') }}",
        method: 'get',
        success: function(reponse) {
          $("#showAllType").html(reponse);
        }
      });
    }

    fetchcarburent();

    function fetchcarburent() {
      $.ajax({
        url: "{{ route('allcarburent') }}",
        method: 'get',
        success: function(reponse) {
          $("#showcarburent").html(reponse);
        }
      });
    }

    fetchstatut();

    function fetchstatut() {
      $.ajax({
        url: "{{ route('allstatut') }}",
        method: 'get',
        success: function(reponse) {
          $("#showstatut").html(reponse);
        }
      });
    }

    fetchfournisseur();

    function  fetchfournisseur() {
      $.ajax({
        url: "{{ route('allfournisseur') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all_fournisseur").html(reponse);
        }
      });
    }

    

  });
</script>




@endsection