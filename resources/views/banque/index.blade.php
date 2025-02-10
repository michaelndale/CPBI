@extends('layout/app')
@section('page-content')

<div class="main-content">
  <div class="page-content">
      <div class="row">
          <div class="col-xl-7" style="margin:auto">
              <div class="card">
                <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">
                     
                          <h4 class="mb-sm-0"><i class="fa fa-university"></i> Listes des banques</h4>
                          <div class="page-title-right">
                            <button type="button" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"  data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa fa-plus-circle"></i> Créer</button>
                          </div>
                     
                  </div>
                  <div class="card-body pt-0 pb-3">
                      <div id="overview-chart" data-colors='["#1f58c7"]' class="apex-charts" dir="ltr"></div>
                      <div class="table-responsive">
                        <table class="table table-striped table-sm fs--1 mb-0">
                          <thead>
                            <tr>
                              <th><b>#</b></th>
                              <th><b>Nom affiché</b></th>
                              <th><b>Créé par</b></th>
                              <th><b>Créé le</b></th>
                              <th><b>Actions</b></th>
                            </tr>
                          </thead>
                          <tbody id="show_all">
                            <tr>
                              <td colspan="5">
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

{{-- new banque modal --}}
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="addModalTitle"><i class="fa fa-plus-circle"></i> Nouvelle Banque</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" id="addform">
            @method('post')
            @csrf
          <div class="modal-body">
              <input class="form-control" id="libelle" name="libelle" type="text" placeholder="Entrer nom" required /> <br>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
              <button type="submit" name="add" id="add"  class="btn btn-primary waves-effect waves-light"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
          </div>
          </form>

      </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


{{-- Edit banque modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form method="POST" id="editform">
            @method('post')
            @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="verticallyCenteredModalLabel"><i class="fa fa-edit"></i> Modification banque </h5>
              
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </button>
            </div>
            <div class="modal-body">
              <label class="text-1000 fw-bold mb-2">Libellé </label>
              <input type="hidden" name="bid" id="bid">
              <input class="form-control" name="blibelle" id="blibelle" type="text" placeholder="Entrer function" name="blibelle" required />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
              <button type="submit" id="editbtn" class="btn btn-primary" type="button"><i class="fa fa-cloud-upload-alt"></i> Modifier</button>
            </div>
          </form>
        </div>
      </div>
    </div>


<script>
  $(function() {
    // Add profil ajax 
    $("#addform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#add").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("add").disabled = true;


      $.ajax({
        url: "{{ route('storebanque') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {

          if (response.status == 200) {
            toastr.success("banque enregistrer avec succès!", "Enregistrement");
            fetchAllbanque();
            $("#addform")[0].reset();
            $("#addModal").modal('hide');
            document.getElementById("add").disabled = false;
            $("#add").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
          }
          if (response.status == 201) {
            toastr.error("Attention: Libellé banque existe déjà !", "info");
            $("#addModal").modal('hide');
            $("#add").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');

            document.getElementById("add").disabled = false;
          }

          if (response.status == 202) {
            toastr.error("Le banque  existe déjà !", "Erreur");
            $("#addModal").modal('show');
            $("#add").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("add").disabled = false;
          }

        }
      });
    });

    // Edit profil ajax request
    $(document).on('click', '.editIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('edibanque') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#blibelle").val(response.libelle);
          $("#bid").val(response.id);
        }
      });
    });

    $("#editform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
    
      $("#editbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("editbtn").disabled = true;

      $.ajax({
        url: "{{ route('updatebanque') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
              toastr.success("Banque modifier avec succès !", "Modification");
              fetchAllbanque();
           
              $("#editbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
              $("#editform")[0].reset();
              $("#editModal").modal('hide');
              document.getElementById("editbtn").disabled = false;
          }

          if (response.status == 201) {
              toastr.error("Le titre du dossier existe déjà !", "Erreur");
              $("#editbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
              document.getElementById("editbtn").disabled = false;
          }

          if (response.status == 205) {
            toastr.error("Vous n'avez pas l'accreditation de Modifier cette banque!", "Erreur");

            $("#editbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("editbtn").disabled = false;
          }

        }
      });
    });

  

    // Delete classeur ajax request'

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
            url: "{{ route('deletebanque') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {


              if (response.status == 200) {
                toastr.success("Banque supprimer avec succès !", "Suppression");
                   fetchAllbanque();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de supprimer ce banque!", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
            }
          });
        }
      })
    });

   

    fetchAllbanque();

    function fetchAllbanque() {
      $.ajax({
        url: "{{ route('fetchAllBanque') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all").html(reponse);
        }
      });
    }
  });
</script>



@endsection