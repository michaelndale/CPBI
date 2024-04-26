@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-6" style="margin:auto">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Type budget </h4>
            <div class="page-title-right">
              <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau </a>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6" style="margin:auto">
          <div class="card">
            <div class="table-responsive">
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
                <tbody id="show_all_type">
                  <tr>
                    <td colspan="3">
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
    <br><br> <br><br> <br><br> <br><br> 
  </div>
</div>

{{-- new department modal --}}
<div class="modal fade" id="addDealModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="add_type_form" autocomplete="off">
      @method('post')
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-folder-plus"></i> Nouvelle type budget </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
        </div>
        <div class="modal-body">
          <label class="text-1000 fw-bold mb-2">Titre</label>
          <input class="form-control" name="titre" id="titre" type="text" placeholder="Entrer le titre" required />
        </div>
        <div class="modal-footer">
          <button type="submit" name="sendType" id="add_type" value="Sauvegarder" class="btn btn-primary">Sauvegarder</button>
        </div>
      </div>
    </form>
  </div>
</div>


{{-- Edit dossier modal --}}

<div class="modal fade" id="edittypeModal" tabindex="-1" aria-labelledby="edittypeModal" aria-hidden="true">
  <div class="modal-dialog">
    <form autocomplete="off" id="edit_type_form">
      @method('post')
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-folder-plus"></i> Modification dossier</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
        </div>
        <div class="modal-body">
          <label class="text-1000 fw-bold mb-2">Titre</label>
          <input type="hidden" name="typeid" id="typeid">
          <input class="form-control" name="titretype" id="titretype" type="text" placeholder="Entrer dossier" required />

        </div>
        <div class="modal-footer">
          <button type="submit" name="edittypebtn" id="edittypebtn" value="Sauvegarder" class="btn btn-primary">Sauvegarder</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  $(function() {
    // Add department ajax 
    $("#add_type_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#add_type").text('Adding...');
      $.ajax({
        url: "{{ route('storetypebudget') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Type budget enregistrer avec succès!", "Enregistrement");
            fetchAlldbudget();
            $("#add_type").text('Sauvegarder');
            $("#add_type_form")[0].reset();
            $("#addDealModal").modal('hide');
          }

          if (response.status == 201) {
            toastr.error("Le type budget  existe déjà !", "Erreur");
            $("#add_type").text('Sauvegarder');
            $("#addDealModal").modal('show');
          }
        }

      });
    });

    // Edit folder ajax request
    $(document).on('click', '.editIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('edittypebudget') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#titretype").val(response.titre);
          $("#typeid").val(response.id);
        }
      });
    });

    // update function ajax request
    $("#edit_type_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#edittypebtn").text('Mises encours...');
      $.ajax({
        url: "{{ route('updatetypebudget') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Type budget modifier avec succès !", "Modification");
            fetchAlldbudget();
            $("#edittypebtn").text('Sauvegarder');
            $("#edittypeModal").modal('hide');

          }

          if (response.status == 201) {
            toastr.error("Le type budget existe déjà !", "Erreur");

            $("#edittypebtn").text('Sauvegarder');
          }

          if (response.status == 205) {
            toastr.error("Vous n'avez pas l'accreditation de Modifier ce type de projet !", "Erreur");

            $("#edittypebtn").text('Sauvegarder');
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
            url: "{{ route('deletetypebudget') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {


              if (response.status == 200) {
                toastr.success("Type budget supprimer avec succès !", "Suppression");
                fetchAlldbudget();
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

    fetchAlldbudget();

    function fetchAlldbudget() {
      $.ajax({
        url: "{{ route('fetchtypebudget') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all_type").html(reponse);
        }
      });
    }
  });
</script>

@endsection