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
                                        <span class="d-none d-sm-block">Carburent</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">Statut</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#settings1" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                        <span class="d-none d-sm-block">Settings</span>
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="home1" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12" style="margin:auto">
                                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                                <h6 class="mb-sm-0"><i class="fa fa-car"></i> Type vehicule </h6>

                                                <div class="page-title-right">
                                                    <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addtypeModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau type vehicule</a>

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
                                        <tbody id="show_all_folder">
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
                                                        <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-car"></i> Nouveau type vehicule</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label class="text-1000 fw-bold mb-2">Titre</label>
                                                        <input class="form-control" name="title" id="title" type="text" placeholder="Entrer le titre" required />
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="sendType" id="sendType" value="Sauvegarder" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="profile1" role="tabpanel">
                                    <p class="mb-0">
                                        Food truck fixie locavore, accusamus mcsweeney's marfa nulla
                                        single-origin coffee squid. Exercitation +1 labore velit, blog
                                        sartorial PBR leggings next level wes anderson artisan four loko
                                        farm-to-table craft beer twee. Qui photo booth letterpress,
                                        commodo enim craft beer mlkshk aliquip jean shorts ullamco ad
                                        vinyl cillum PBR. Homo nostrud organic, assumenda labore
                                        aesthetic magna delectus.
                                    </p>
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
              toastr.success("Type vehicule enregistrer avec succès!", "Enregistrement");
              fetchAlldfolder();
            
              $("#sendType").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
              $("#add_type_form")[0].reset();
              $("#addDealModal").modal('hide');
              document.getElementById("sendType").disabled = false;
          }

          if (response.status == 201) {
              toastr.error("Le titre du dossier existe déjà !", "Erreur");
              $("#add_folder").text('Sauvegarder');
              $("#addDealModal").modal('show');
              document.getElementById("sendType").disabled = false;
          }
        }

        

      });
    });

    // Edit folder ajax request
    $(document).on('click', '.editIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('editfl') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#flibelle").val(response.title);
          $("#fid").val(response.id);
        }
      });
    });

    // update function ajax request
    $("#edit_folder_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
    
      $("#editfolderbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("editfolderbtn").disabled = true;

      $.ajax({
        url: "{{ route('updatefl') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
              toastr.success("Dossier modifier avec succès !", "Modification");
              fetchAlldfolder();
           
              $("#editfolderbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
              $("#edit_folder_form")[0].reset();
              $("#editFolderModal").modal('hide');
              document.getElementById("editfolderbtn").disabled = false;
          }

          if (response.status == 201) {
              toastr.error("Le titre du dossier existe déjà !", "Erreur");
              $("#editfolderbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
              document.getElementById("editfolderbtn").disabled = false;
          }

          if (response.status == 205) {
            toastr.error("Vous n'avez pas l'accreditation de Modifier ce dossier!", "Erreur");

            $("#editfolderbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("editfolderbtn").disabled = false;
          }

        }
      });
    });

    // Delete service ajax request
    $(document).on('click', '.deleteIcon', function(e) {
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
            url: "{{ route('deletefl') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {


              if (response.status == 200) {
                toastr.success("Dossier supprimer avec succès !", "Suppression");
                fetchAlldfolder();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de supprimer ce dossier!", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
            }
          });
        }
      })
    });

    fetchAlldfolder();

    function fetchAlldfolder() {
      $.ajax({
        url: "{{ route('fetchAllfl') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all_folder").html(reponse);
        }
      });
    }
  });
</script>




@endsection