@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
        <div class="col-12" style="margin:auto">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Categorie d'etiquette </h4>
            <div class="page-title-right">
              <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addModal" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-plus-circle"></i> Nouveau etiquette</a>
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
                    <th>Classe</th>
                    <th>Categorie etiquette</th>
                    <th>Info-bulle</th>
                    <th>Créé par</th>
                    <th>Créé le</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="show_all">
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
  </div>
  <!-- End Page-content -->
</div>

{{-- new profile modal --}}

<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal"" style=" display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="addform">
        @method('post')
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Creer categorie d'etiquette </h5>

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        <label class="text-1000 fw-bold mb-2">Parent</label>
          <select class="form-control" name="parent" type="text" placeholder="Entrer libellé"   >
                <option disabled="true" selected="true">--Aucun--</option>
              @foreach ($classeur as $classeurs)
                <option value="{{ $classeurs->id }}">{{ ucfirst($classeurs->libellec) }}</option>
              @endforeach
          </select> 
          <br>
          

          <label class="text-1000 fw-bold mb-2">Categorie d'etiquette</label>
          <input class="form-control" id="nom" name="nom" type="text" placeholder="Entrer categorie" required /> <br>

          <label class="text-1000 fw-bold mb-2">Info-bull</label>
          <input class="form-control" id="info_bull" name="info_bull" type="text" placeholder="Info-bull" required /> <br>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add" id="add" class="btn btn-primary" type="button"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Fin profile --}}


{{-- Edit profile modal --}}

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="editform">
        @method('post')
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Modification classeur </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
              <path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path>
            </svg></button>
        </div>
        <div class="modal-body">

          <label class="text-1000 fw-bold mb-2">Libellé </label>
          <input type="hidden" name="cs_id" id="cs_id">
          <input class="form-control" name="cs_title" id="cs_title" type="text" placeholder="Entrer function" name="nom_fonction" required />

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
        url: "{{ route('storeetiquette') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            if (response.status == 200) {
                toastr.success(response.message, "Enregistrement");
                fetchAlletiquette();
                $("#addform")[0].reset();
                $("#addModal").modal('hide');
            } else if (response.status == 201) {
                toastr.error(response.message, "Info");
                $("#addModal").modal('hide');
            } else if (response.status == 202) {
                toastr.error(response.message, "Erreur");
                $("#addModal").modal('show');
            } else {
                toastr.error("Une erreur inconnue est survenue.", "Erreur");
                $("#addModal").modal('show');
            }
            $("#add").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("add").disabled = false;
        },
        error: function(xhr, status, error) {
            // Afficher le message d'erreur retourné par le backend
            var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "Une erreur s'est produite. Veuillez réessayer.";
            toastr.error(errorMessage, "Erreur");
            $("#add").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("add").disabled = false;
        }
    });
});


    // Edit profil ajax request
    $(document).on('click', '.editIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('editCs') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#cs_title").val(response.libellec);
          $("#cs_id").val(response.id);
        }
      });
    });

    // update profil ajax request
    $("#editform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#editbtn").text('Mise à jour...');
      $.ajax({
        url: "{{ route('updateCs') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            $.notify("Mise à jour  avec succès !", "success");
            fetchAlletiquette();
            $("#editform")[0].reset();
            $("#editModal").modal('hide');
          }
          if (response.status == 201) {
            $.notify("Attention: Libellé classeur existe déjà !", "info");
            $("#editModal").modal('hide');
          }

          if (response.status == 202) {
            $.notify("Erreur d'execution, verifier votre internet", "error");
            $("#editModal").modal('show');
          }

          $("#editbtn").text('Modifier');

        }
      });
    });

    // Delete classeur ajax request

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
        confirmButtonText: 'Oui, Supprimer !'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('deleteCs') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {
              console.log(response);
              $.notify("Classeur supprimer avec succès !", "success");
              fetchAlletiquette();
            }
          });
        }
      })
    });


    fetchAlletiquette();

    function fetchAlletiquette() {
      $.ajax({
        url: "{{ route('fetchalletiquette') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all").html(reponse);
        }
      });
    }
  });
</script>

@endsection