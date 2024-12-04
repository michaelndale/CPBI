@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0"><i class="fa fa-users"></i> Listes des Bénéficiaires </h4>
                                <div class="page-title-right">
                                  <a href="javascript:voide();" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" data-bs-toggle="modal"
                                  data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false"
                                  data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Créer bénéficiaire
                                  </a>

                                  <a href="javascript:voide();" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#myCategorieBeneficiaireModalLabel" aria-haspopup="true"
                                        aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-list"></i>
                                        Catégorie des bénéficiaires 
                                  </a>
      
                                </div>
                           
                        </div>
                        <div class="card-body pt-0 pb-3">
                            <div id="overview-chart" data-colors='["#1f58c7"]' class="apex-charts" dir="ltr"></div>
                            <div class="table-responsive">

                                <table class="table table-striped table-sm fs--1 mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width:4%">#</th>
                                            <th> <b>Catégorie </b></th>
                                            <th> <b>Institution ou Nom & prenom</b> </th>
                                            <th> <b>Adresse</b> </th>
                                            <th> <b>Téléphone(1)</b></th>
                                            <th> <b>Téléphone(2)</b></th>
                                            <th style="width:30%"> <b>Description</b></th>
                                            <th><center><b>Actions</b></center> </th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_all_ben">
                                        <tr>
                                            <td colspan="8">
                                                <h5 class="text-center text-secondery my-5">
                                                    @include('layout.partiels.load')
                                            </td>
                                        </tr>
                                    </tbody>
                                    </tbody>
                                </table>


                                <br>
                                <br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addDealModal" tabindex="-1" role="dialog" aria-labelledby="addDealModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <form id="add_benefe_form" autocomplete="off">
                  @method('post')
                  @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDealModalTitle"><i class="fa fa-plus-circle"></i> Nouveau Bénéficiaire
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="row">

                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2">Catégorie</label>
                            <select class="form-control allselectcatgorie" name="cid" id="cid"
                                type="text" placeholder="Entrer categorie" required>
                                <option> Séléctionner catégorie</option>
                            </select>

                        </div>


                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2"> Nom & prénom ou Institution</label>
                            <input class="form-control" name="nom" id="nom" type="text"
                                placeholder="Entrer le nom & prénom ou institution" required />
                        </div>

                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2"> Adresse</label>
                            <input class="form-control" name="adresse" id="adresse" type="text"
                                placeholder="Entrer l'adresse" />
                        </div>

                        <div class="col-sm-6 col-md-6">

                            <label class="text-1000 fw-bold mb-2">Téléphone(1)</label>
                            <input class="form-control" name="telephoneun" id="telephoneun" type="text"
                                placeholder="Entrer le Telephone " />
                        </div>

                        <div class="col-sm-6 col-md-6">

                            <label class="text-1000 fw-bold mb-2">Téléphone(2)</label>
                            <input class="form-control" name="telephonedeux" id="telephonedeux" type="text"
                                placeholder="Entrer le Telephone" />
                        </div>

                        <div class="col-sm-12 col-md-12">

                            <label class="text-1000 fw-bold mb-2">Description</label>
                            <textarea class="form-control" name="description" id="description" type="text"
                                placeholder="Entrer la description"></textarea>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" name="add_benefe" id="add_benefe" 
                            class="btn btn-primary waves-effect waves-light"> <i class="fa fa-cloud-upload-alt"></i>
                            Sauvegarder</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="editbeneModal" tabindex="-1" role="dialog" aria-labelledby="editbeneModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <form autocomplete="off" id="edit_bene_form">
                @method('post')
                @csrf
                  <div class="modal-header">
                      <h5 class="modal-title" id="addDealModalTitle"><i class="fa fa-edit"></i> Modification  Bénéficiaire
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">

                    <div class="row">

                      <input type="hidden" name="bid" id="bid">

                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2">Catégorie</label>
                            <select class="form-control" name="cids" id="cids" type="text"
                                placeholder="Entrer categorie" required>
                                <option> Séléctionner catégorie</option>
                                @foreach ($caregorie as $caregories)
                                    <option value="{{ $caregories->id }}">{{ $caregories->titre }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2">Nom & prenom ou Institution</label>
                            <input class="form-control" name="bnom" id="bnom" type="text"
                                placeholder="Entrer Nom & prenom ou Institution" required />
                        </div>

                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2"> Adresse</label>
                            <input class="form-control" name="badresse" id="badresse" type="text"
                                placeholder="Entrer le Adresse" />
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <br>
                            <label class="text-1000 fw-bold mb-2">Téléphone(1)</label>
                            <input class="form-control" name="btelephoneun" id="btelephoneun" type="text"
                                placeholder="Entrer le Telephone " />
                        </div>

                        <div class="col-sm-6 col-md-6">
                            <br>
                            <label class="text-1000 fw-bold mb-2">Téléphone(2)</label>
                            <input class="form-control" name="btelephonedeux" id="btelephonedeux" type="text"
                                placeholder="Entrer le Telephone" />
                        </div>

                        <div class="col-sm-12 col-md-12">
                            <br>
                            <label class="text-1000 fw-bold mb-2">Description</label>
                            <textarea class="form-control" name="bdescription" id="bdescription" type="text"
                                placeholder="Entrer la description"></textarea>
                        </div>


                    </div>
                   
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                      <button type="submit" name="editbenebtn" id="editbenebtn" 
                          class="btn btn-primary waves-effect waves-light"> <i class="fa fa-cloud-upload-alt"></i>
                          Sauvegarder</button>
                  </div>
              </form>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" class="modal fade bs-example-modal-lg" id="myCategorieBeneficiaireModalLabel" tabindex="-1" role="dialog" aria-labelledby="editdeviseTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
              <form id="edit_folder_form" autocomplete="off">
                  @method('post')
                  @csrf
                  <div class="modal-header">
                      <h5 class="modal-title" id="addDealModalTitle"><i class="fa fa-list"></i> Catégorie des bénéficiaires </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div id="tableExample2">
                      <div class="table-responsive">

                          <a href="javascript:voide();"  class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" data-bs-toggle="modal" data-bs-target="#addcategorieModal"
                              aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                              <i class="fa fa-plus-circle"></i> Créer </a>
                          <br> <br>

                          <table class="table table-striped table-sm fs--1 mb-0">
                              <thead>
                                  <tr>
                                      <th class="sort border-top "><b>ID </b></center>
                                      </th>
                                      <th class="sort border-top" data-sort="date"><b>Description</b></th>
                                      <th class="sort border-top" data-sort="date"><b>Date creation</b></th>
                                      <th class="sort border-top" data-sort="date"><b>Actions</b></th>
                                  </tr>
                              </thead>


                              <tbody id="show_all_categorie">
                              </tbody>
                          </table>
                      </div>
                  </div>
                    
                  </div>
                  
              </form>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="addcategorieModal" tabindex="-1" role="dialog" aria-labelledby="addcategorieModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <form id="addcategorieform" autocomplete="off">
                @method('post')
                @csrf
                  <div class="modal-header">
                      <h5 class="modal-title" id="addDealModalTitle"><i class="fa fa-plus-circle"></i> Nouvelle catégorie 
                      </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row">

                      <div class="col-sm-12 col-md-12">
                        <label class="text-1000 fw-bold mb-2">Description </label>
                        <input class="form-control" name="titre" id="titre" type="text"
                            placeholder="Entrer description" required />
                      </div>

                  </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                      <button type="submit" name="addcategorie" id="addcategorie" class="btn btn-primary waves-effect waves-light"> <i class="fa fa-cloud-upload-alt"></i>
                          Sauvegarder</button>
                  </div>
              </form>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="editcatModal" tabindex="-1" role="dialog" aria-labelledby="editcatModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <form id="add_benefe_form" autocomplete="off">
                @method('post')
                @csrf
                  <div class="modal-header">
                      <h5 class="modal-title" id="editcatModalTitle"><i class="fa fa-edit"></i> Modification Catégorie des bénéficiaires </h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row">

                      <label class="text-1000 fw-bold mb-2">Titre</label>
                      <input type="hidden" name="catid" id="catid">
                      <input class="form-control" name="ctitre" id="ctitre" type="text"
                          placeholder="Entrer titre" required />

                     
                  </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                      <button type="submit"  name="editcategoeriebtn" id="editcategoeriebtn" 
                          class="btn btn-primary waves-effect waves-light"> <i class="fa fa-cloud-upload-alt"></i>
                          Sauvegarder</button>
                  </div>
              </form>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div>


  <script>
      $(function() {
          Allselectcategorie();

          // Add devise ajax 
          $("#add_benefe_form").submit(function(e) {
              e.preventDefault();
              const fd = new FormData(this);

              $("#add_benefe").html('<i class="fas fa-spinner fa-spin"></i>');
              document.getElementById("add_benefe").disabled = true;

              $.ajax({
                  url: "{{ route('storebeneficiaire') }}",
                  method: 'post',
                  data: fd,
                  cache: false,
                  contentType: false,
                  processData: false,
                  dataType: 'json',
                  success: function(response) {
                      if (response.status == 200) {
                          toastr.success("Bénéficiaire enregistrer avec succès !",
                              "Enregistrement");
                          fetchAllbene();

                          $("#add_benefe").html(
                              '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                          $("#add_benefe_form")[0].reset();
                          $("#addDealModal").modal('hide');
                          document.getElementById("add_benefe").disabled = false;

                      }

                      if (response.status == 201) {
                          toastr.error("Le Bénéficiaire existe déjà !", "Erreur");
                          $("#add_benefe").html(
                              '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                          $("#addDealModal").modal('show');
                          document.getElementById("add_benefe").disabled = false;
                      }
                  }

              });
          });

          $("#addcategorieform").submit(function(e) {
              e.preventDefault();
              const fd = new FormData(this);

              $("#addcategorie").html('<i class="fas fa-spinner fa-spin"></i>');
              document.getElementById("addcategorie").disabled = true;

              $.ajax({
                  url: "{{ route('storecategoriebeneficiaire') }}",
                  method: 'post',
                  data: fd,
                  cache: false,
                  contentType: false,
                  processData: false,
                  dataType: 'json',
                  success: function(response) {
                      if (response.status == 200) {
                          toastr.success("Catégorie enregistrer avec succès !",
                              "Enregistrement");
                          allcategoriebeneficiaire();
                          Allselectcategorie();

                          $("#addcategorie").html(
                              '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                          $("#addcategorieform")[0].reset();
                          $("#addcategorieModal").modal('hide');
                          document.getElementById("addcategorie").disabled = false;
                      }

                      if (response.status == 201) {
                          toastr.error("Le catégorie existe déjà !", "Erreur");
                          $("#addcategorie").html(
                              '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                          $("#addcategorieform")[0].reset();
                          $("#addcategorieModal").modal('show');
                          document.getElementById("addcategorie").disabled = false;
                      }
                  }

              });
          });


          // Edit folder ajax request
          $(document).on('click', '.editIcon', function(e) {
              e.preventDefault();
              let id = $(this).attr('id');
              $.ajax({
                  url: "{{ route('editbeneficiaire') }}",
                  method: 'get',
                  data: {
                      id: id,
                      _token: '{{ csrf_token() }}'
                  },
                  success: function(response) {
                      $("#bnom").val(response.libelle);
                      $("#badresse").val(response.adresse);
                      $("#btelephoneun").val(response.telephoneone);
                      $("#btelephonedeux").val(response.telephonedeux);
                      $("#bdescription").val(response.description);
                      $("#bid").val(response.idb);
                      $("#cids").val(response.idc);


                  }
              });
          });

          $(document).on('click', '.editCategorie', function(e) {
              e.preventDefault();
              let id = $(this).attr('id');
              $.ajax({
                  url: "{{ route('editcategorie') }}",
                  method: 'get',
                  data: {
                      id: id,
                      _token: '{{ csrf_token() }}'
                  },
                  success: function(response) {
                      $("#ctitre").val(response.titre);
                      $("#catid").val(response.id);

                  }
              });
          });



          // update function ajax request
          $("#edit_bene_form").submit(function(e) {
              e.preventDefault();
              const fd = new FormData(this);

              $("#editbenebtn").html('<i class="fas fa-spinner fa-spin"></i>');
              document.getElementById("editbenebtn").disabled = true;

              $.ajax({
                  url: "{{ route('updatebeneficiaire') }}",
                  method: 'post',
                  data: fd,
                  cache: false,
                  contentType: false,
                  processData: false,
                  dataType: 'json',
                  success: function(response) {
                      if (response.status == 200) {

                          toastr.success("Bénéficiaire modifier avec succès !",
                              "Modification");
                          fetchAllbene();

                          $("#editbenebtn").html(
                              '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                          $("#edit_bene_form")[0].reset();
                          $("#editbeneModal").modal('hide');
                          document.getElementById("editbenebtn").disabled = false;

                      }

                      if (response.status == 201) {
                          toastr.error("Le Bénéficiaire existe déjà !", "Erreur");
                          $("#editbenebtn").html(
                              '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                          $("#editbeneModal").modal('show');
                          document.getElementById("editbenebtn").disabled = false;
                      }

                      if (response.status == 205) {
                          toastr.error(
                              "Vous n'avez pas l'accreditation de Modifier ce bénéficiaire !",
                              "Erreur");
                          $("#editbenebtn").html(
                              '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                          $("#editbeneModal").modal('show');
                          document.getElementById("editbenebtn").disabled = false;
                      }

                  }
              });
          });


          // update categorie ajax request
          $("#editcategorieform").submit(function(e) {
              e.preventDefault();
              const fd = new FormData(this);

              $("#editcategoeriebtn").html('<i class="fas fa-spinner fa-spin"></i>');
              document.getElementById("editcategoeriebtn").disabled = true;

              $.ajax({
                  url: "{{ route('updatecategorie') }}",
                  method: 'post',
                  data: fd,
                  cache: false,
                  contentType: false,
                  processData: false,
                  dataType: 'json',
                  success: function(response) {
                      if (response.status == 200) {

                          toastr.success("Catégorie modifier avec succès !", "Modification");
                          allcategoriebeneficiaire();
                          fetchAllbene();

                          $("#editcategoeriebtn").html(
                              '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                          $("#editcategorieform")[0].reset();
                          $("#editcatModal").modal('hide');
                          document.getElementById("editcategoeriebtn").disabled = false;

                      }

                      if (response.status == 201) {
                          toastr.error("Le Catégorie existe déjà !", "Erreur");
                          $("#editcategoeriebtn").html(
                              '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                          $("#editcatModal").modal('show');
                          document.getElementById("editcategoeriebtn").disabled = false;
                      }

                      if (response.status == 205) {
                          toastr.error(
                              "Vous n'avez pas l'accreditation de Modifier ce bénéficiaire !",
                              "Erreur");
                          $("#editcategoeriebtn").html(
                              '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                          $("#editcatModal").modal('show');
                          document.getElementById("editcategoeriebtn").disabled = false;
                      }

                  }
              });
          });

          // Delete beneficiaire ajax request
          $(document).on('click', '.deleteIcon', function(e) {
              e.preventDefault();
              let id = $(this).attr('id');
              let csrf = '{{ csrf_token() }}';
              Swal.fire({
                  title: 'Êtes vous sûr de vouloir supprimer définitivement ?',
                  text: "Si vous le faite vous ne pouvez plus revenir en arrière !",

                  showCancelButton: true,
                  confirmButtonColor: 'Green',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Oui, Supprimer!',
                  cancelButtonText: 'Annuler',
              }).then((result) => {
                  if (result.isConfirmed) {
                      $.ajax({
                          url: "{{ route('deletebeneficiaire') }}",
                          method: 'delete',
                          data: {
                              id: id,
                              _token: csrf
                          },
                          success: function(response) {

                              if (response.status == 200) {
                                  toastr.success(
                                      "Bénéficiaire supprimer avec succès !",
                                      "Suppression");
                                  fetchAllbene();
                              }

                              if (response.status == 205) {
                                  toastr.error(
                                      "Vous n'avez pas l'accreditation de supprimer ce bénéficiaire !",
                                      "Erreur");
                              }

                              if (response.status == 202) {
                                  toastr.error("Erreur d'execution !", "Erreur");
                              }
                          }
                      });
                  }
              })
          });

          // Delete categorie ajax request
          $(document).on('click', '.deletecategorie', function(e) {
              e.preventDefault();
              let id = $(this).attr('id');
              let csrf = '{{ csrf_token() }}';
              Swal.fire({
                  title: 'Êtes vous sûr de vouloir supprimer définitivement ?',
                  text: "Si vous le faite vous ne pouvez plus revenir en arrière !",

                  showCancelButton: true,
                  confirmButtonColor: 'Green',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Oui, Supprimer!',
                  cancelButtonText: 'Annuler',
              }).then((result) => {
                  if (result.isConfirmed) {
                      $.ajax({
                          url: "{{ route('deletecategorie') }}",
                          method: 'delete',
                          data: {
                              id: id,
                              _token: csrf
                          },
                          success: function(response) {

                              if (response.status == 200) {
                                  toastr.success("Catégorie supprimer avec succès !",
                                      "Suppression");
                                  Allselectcategorie();
                                  allcategoriebeneficiaire();
                              }

                              if (response.status == 205) {
                                  toastr.error(
                                      "Vous n'avez pas l'accreditation de supprimer ce catégorie !",
                                      "Erreur");
                              }

                              if (response.status == 202) {
                                  toastr.error("Erreur d'execution !", "Erreur");
                              }
                          }
                      });
                  }
              })
          });

          fetchAllbene();

          function fetchAllbene() {
              $.ajax({
                  url: "{{ route('allbeneficiaire') }}",
                  method: 'get',
                  success: function(reponse) {
                      $("#show_all_ben").html(reponse);
                  }
              });
          }


          allcategoriebeneficiaire();

          function allcategoriebeneficiaire() {
              $.ajax({
                  url: "{{ route('categoriebeneficiaire') }}",
                  method: 'get',
                  success: function(reponse) {
                      $("#show_all_categorie").html(reponse);
                  }
              });
          }

          Allselectcategorie();

          function Allselectcategorie() {
              $.ajax({
                  url: "{{ route('selectcategorie') }}",
                  method: 'get',
                  success: function(reponse) {
                      $(".allselectcatgorie").html(reponse);
                  }
              });
          }
      });
  </script>

  

@endsection