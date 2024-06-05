@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
        <div class="col-12" style="margin:auto">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Banque </h4>
            <div class="page-title-right">
              <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addModal" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-plus-circle"></i> Nouvelle banque</a>
            </div>
          </div>
        </div>
      </div>
      <!-- end page title -->

      <div class="row">
        <div class="col-lg-12" style="margin:auto">
          <div class="card">
            <div class="table-responsive">
              <table class="table table-striped table-sm fs--1 mb-0">
                <thead>
                  <tr style="background-color:#82E0AA">
                    <th style="width:10%">#</th>
                    <th>Nom affiché</th>
                    <th>Créé par</th>
                    <th>Créé le</th>
                    <th>Action</th>
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
    </div> <!-- container-fluid -->
  </div>
  <!-- End Page-content -->
</div>



{{-- new banque modal --}}

<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal"" style=" display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="addform">
        @method('post')
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouvelle Banque </h5>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label class="text-1000 fw-bold mb-2">Nom </label>
          <input class="form-control" id="libelle" name="libelle" type="text" placeholder="Entrer nom" required /> <br>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add" id="add" class="btn btn-primary" type="button"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Fin profile --}}



{{-- Edit banque modal --}}

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="editform">
        @method('post')
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Modification banque </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
              <path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path>
            </svg></button>
        </div>
        <div class="modal-body">
          <label class="text-1000 fw-bold mb-2">Libellé </label>
          <input type="hidden" name="bid" id="bid">
          <input class="form-control" name="blibelle" id="blibelle" type="text" placeholder="Entrer function" name="blibelle" required />
        </div>
        <div class="modal-footer">
          <button type="submit" id="editbtn" class="btn btn-primary" type="button">Modifier</button>
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