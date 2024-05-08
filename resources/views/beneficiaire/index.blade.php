@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12" style="margin:auto">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="fa fa-users"></i> Bénéficiaire </h4>
            <div class="page-title-right">
              <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#myCategorieBeneficiaireModalLabel" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-list"></i> Catégorie des bénéficiaires </a>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau bénéficiaire </a>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12" style="margin:auto">
          <div class="card">
            <div class="table-responsive">
              <table class="table table-bordered  table-sm fs--1 mb-0">
                <thead>
                  <tr style="background-color:#82E0AA">
                    <th style="width:4%">#</th>
                    <th> Catégorie </th>
                    <th> Institution ou Nom & prenom </th>
                    <th> Adresse </th>
                    <th> Téléphone(1)</th>
                    <th> Téléphone(2)</th>
                    <th style="width:30%"> Description</th>
                    <th style="width:10%">
                      <center>Action</center>
                    </th>
                  </tr>
                </thead>
                <tbody id="show_all_ben">
                  <tr>
                    <td colspan="7">
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
    <br><br> <br><br> <br><br> <br><br> <br><br> <br> <br><br> <br>
  </div>
</div>

{{-- new department modal --}}
<div class="modal fade" id="addDealModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="add_benefe_form" autocomplete="off">
      @method('post')
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-folder-plus"></i> Nouveau Bénéficiaire </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="row">

            <div class="col-sm-12 col-md-12">
              <label class="text-1000 fw-bold mb-2">Catégorie</label>
              <select class="form-control allselectcatgorie" name="cid" id="cid" type="text" placeholder="Entrer categorie" required>
                <option> Séléctionner catégorie</option>
              </select>
             
            </div>


            <div class="col-sm-12 col-md-12">
              <label class="text-1000 fw-bold mb-2"> Nom & prénom ou Institution</label>
              <input class="form-control" name="nom" id="nom" type="text" placeholder="Entrer le nom & prénom ou institution" required />
            </div>
          
            <div class="col-sm-12 col-md-12">
              <label class="text-1000 fw-bold mb-2"> Adresse</label>
              <input class="form-control" name="adresse" id="adresse" type="text" placeholder="Entrer l'adresse" />
            </div>

            <div class="col-sm-6 col-md-6">
             
              <label class="text-1000 fw-bold mb-2">Téléphone(1)</label>
              <input class="form-control" name="telephoneun" id="telephoneun" type="text" placeholder="Entrer le Telephone "/>
            </div>

            <div class="col-sm-6 col-md-6">
             
              <label class="text-1000 fw-bold mb-2">Téléphone(2)</label>
              <input class="form-control" name="telephonedeux" id="telephonedeux" type="text" placeholder="Entrer le Telephone" />
            </div>

            <div class="col-sm-12 col-md-12">
             
              <label class="text-1000 fw-bold mb-2">Description</label>
              <textarea class="form-control" name="description" id="description" type="text" placeholder="Entrer la description" ></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add_benefe" id="add_benefe" value="Sauvegarder" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i>  Sauvegarder</button>
        </div>
      </div>
    </form>
  </div>
</div>


{{-- Edit beneficiare modal --}}

<div class="modal fade" id="editbeneModal" tabindex="-1" aria-labelledby="editbeneModal" aria-hidden="true">
  <div class="modal-dialog">
    <form autocomplete="off" id="edit_bene_form">
      @method('post')
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-folder-plus"></i> Modification Bénéficiaire</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
        </div>
        <div class="modal-body">

          <input type="hidden" name="bid" id="bid">

          <div class="row">


          <div class="col-sm-12 col-md-12">
              <label class="text-1000 fw-bold mb-2">Catégorie</label>
              <select class="form-control" name="cids" id="cids" type="text" placeholder="Entrer categorie" required>
                <option >  Séléctionner catégorie</option>
                @foreach ($caregorie as $caregories)
                  <option value="{{ $caregories->id }}">{{ $caregories->titre }}</option>
                  
                @endforeach
              </select>
             
            </div>

            <div class="col-sm-12 col-md-12">
              <label class="text-1000 fw-bold mb-2">Nom & prenom ou Institution</label>
              <input class="form-control" name="bnom" id="bnom" type="text" placeholder="Entrer Nom & prenom ou Institution" required />
            </div>

            <div class="col-sm-12 col-md-12">
              <label class="text-1000 fw-bold mb-2"> Adresse</label>
              <input class="form-control" name="badresse" id="badresse" type="text" placeholder="Entrer le Adresse"  />
            </div>

            <div class="col-sm-6 col-md-6">
              <br>
              <label class="text-1000 fw-bold mb-2">Téléphone(1)</label>
              <input class="form-control" name="btelephoneun" id="btelephoneun" type="text" placeholder="Entrer le Telephone "  />
            </div>

            <div class="col-sm-6 col-md-6">
              <br>
              <label class="text-1000 fw-bold mb-2">Téléphone(2)</label>
              <input class="form-control" name="btelephonedeux" id="btelephonedeux" type="text" placeholder="Entrer le Telephone" />
            </div>

            <div class="col-sm-12 col-md-12">
              <br>
              <label class="text-1000 fw-bold mb-2">Description</label>
              <textarea class="form-control" name="bdescription" id="bdescription" type="text" placeholder="Entrer la description" ></textarea>
            </div>


          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="editbenebtn" id="editbenebtn" value="Sauvegarder" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i>  Sauvegarder</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!--- beneficiaire liste -->

<!-- Modal principal -->
<div class="modal fade bs-example-modal-lg" id="myCategorieBeneficiaireModalLabel" tabindex="-1" role="dialog" aria-labelledby="myCategorieBeneficiaireModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myLargeModalLabel"><i class="fa fa-list"></i> Catégorie des bénéficiaires</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <div id="tableExample2">
          <div class="table-responsive">

            <a href="javascript:voide();"  data-bs-toggle="modal" data-bs-target="#addcategorieModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouvelle catégorie  </a>
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
    </div>
  </div>
</div>

<!-- Modal nouveau -->
<div class="modal fade" id="addcategorieModal" tabindex="-1" aria-labelledby="addcategorieModal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouvelle catégorie </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" id="addcategorieform">
        <div class="modal-body">
         
            @method('post')
            @csrf
           
            <div class="modal-body">
              <label class="text-1000 fw-bold mb-2">Description </label>
              <input class="form-control" name="titre" id="titre" type="text" placeholder="Entrer description" required />
            </div>
          
         
        </div>
        <div class="modal-footer">
          <button type="submit" name="addcategorie" id="addcategorie" class="btn btn-primary" type="button"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>
      </form>
    </div>
  </div>
</div>


{{-- Edit categorie --}}

<div class="modal fade" id="editcatModal" tabindex="-1" aria-labelledby="editcatModal" aria-hidden="true">
  <div class="modal-dialog">
    <form autocomplete="off" id="editcategorieform">
      @method('post')
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-folder-plus"></i> Modification Catégorie des bénéficiaires</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label class="text-1000 fw-bold mb-2">Titre</label>
          <input type="hidden" name="catid" id="catid">
          <input class="form-control" name="ctitre" id="ctitre" type="text" placeholder="Entrer titre" required />

        </div>
        <div class="modal-footer">
          <button type="submit" name="editcategoeriebtn" id="editcategoeriebtn" value="Sauvegarder" class="btn btn-primary">  <i class="fa fa-cloud-upload-alt"></i>  Sauvegarder</button>
        </div>
      </div>
    </form>
  </div>
</div>



<!-- Fin -->

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
            toastr.success("Bénéficiaire enregistrer avec succès !", "Enregistrement");
            fetchAllbene();

            $("#add_benefe").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#add_benefe_form")[0].reset();
            $("#addDealModal").modal('hide');
            document.getElementById("add_benefe").disabled = false;

          }

          if (response.status == 201) {
            toastr.error("Le Bénéficiaire existe déjà !", "Erreur");
            $("#add_benefe").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
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
              toastr.success("Catégorie enregistrer avec succès !", "Enregistrement");
              allcategoriebeneficiaire();
              Allselectcategorie();

              $("#addcategorie").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
              $("#addcategorieform")[0].reset();
              $("#addcategorieModal").modal('hide');
              document.getElementById("addcategorie").disabled = false;
          }

          if (response.status == 201) {
            toastr.error("Le catégorie existe déjà !", "Erreur");
              $("#addcategorie").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
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

            toastr.success("Bénéficiaire modifier avec succès !", "Modification");
            fetchAllbene();

            $("#editbenebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#edit_bene_form")[0].reset();
            $("#editbeneModal").modal('hide');
            document.getElementById("editbenebtn").disabled = false;

          }

          if (response.status == 201) {
            toastr.error("Le Bénéficiaire existe déjà !", "Erreur");
            $("#editbenebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#editbeneModal").modal('show');
            document.getElementById("editbenebtn").disabled = false;
          }

          if (response.status == 205) {
            toastr.error("Vous n'avez pas l'accreditation de Modifier ce bénéficiaire !", "Erreur");
            $("#editbenebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
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

            $("#editcategoeriebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#editcategorieform")[0].reset();
            $("#editcatModal").modal('hide');
            document.getElementById("editcategoeriebtn").disabled = false;

          }

          if (response.status == 201) {
            toastr.error("Le Catégorie existe déjà !", "Erreur");
            $("#editcategoeriebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#editcatModal").modal('show');
            document.getElementById("editcategoeriebtn").disabled = false;
          }

          if (response.status == 205) {
            toastr.error("Vous n'avez pas l'accreditation de Modifier ce bénéficiaire !", "Erreur");
            $("#editcategoeriebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
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
                toastr.success("Bénéficiaire supprimer avec succès !", "Suppression");
                fetchAllbene();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de supprimer ce bénéficiaire !", "Erreur");
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
                toastr.success("Catégorie supprimer avec succès !", "Suppression");
                Allselectcategorie();
                allcategoriebeneficiaire();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de supprimer ce catégorie !", "Erreur");
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