@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-6" style="margin:auto">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Element Feuille de temps </h4>
            <!--<div class="page-title-right">
              <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau </a>
            </div> -->
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
                    <th>Temps maximum</th>
                    <th>Temps minimum</th>
                    <th style="width:25%">
                      <center>Action</center>
                    </th>
                  </tr>
                </thead>
                <tbody id="show_all_ft">
                  <tr>
                    <td colspan="4">
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
  <br><br> <br><br> <br><br> <br><br> <br> <br> <br> <br> <br> <br> 
</div>

{{-- new department modal --}}
<div class="modal fade" id="addDealModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addtfform" autocomplete="off">
      @method('post')
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-folder-plus"></i> Nouvelle  Feuille de temps  </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
        </div>
        <div class="row g-3">
            <div class="col-sm-6 col-lg-6 col-xl-6">
                <div class="modal-body">
                <label class="text-1000 fw-bold mb-2">Temps Moyenne</label>
                <input class="form-control" name="tempsmoyennne" id="tempsmoyennne" type="number" placeholder="Entrer le temps moyenne" required />
                </div>
            </div>
          
            <div class="col-sm-6 col-lg-6 col-xl-6">
                <div class="modal-body">
                <label class="text-1000 fw-bold mb-2">Temps Maximum</label>
                <input class="form-control" name="tempstotal" id="tempstotal" type="number" placeholder="Entrer le Maximum" required />
                </div>
            </div>
        </div>


        <div class="modal-footer">
          <button type="submit" name="sendFolder" id="add_service" value="Sauvegarder" class="btn btn-primary">Sauvegarder</button>
        </div>
      </div>
    </form>
  </div>
</div>


{{-- Edit dossier modal --}}

<div class="modal fade" id="editelementsfeuilletempsModal" tabindex="-1" aria-labelledby="editelementsfeuilletempsModal" aria-hidden="true">
  <div class="modal-dialog">
    <form autocomplete="off" id="edit_ft_form">
      @method('post')
      @csrf
      <div class="modal-content">
        
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-edit"></i> Modification feuille de temps</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
        </div>


        <div class="modal-body">

        <div class="row g-3">
            <input type="hidden" name="fid" id="fid">
            <div class="col-sm-6 col-lg-6 col-xl-6">
                <div class="modal-body">
                <label class="text-1000 fw-bold mb-2">Temps Moyenne</label>
                <input type="hidden" name="tid" id="tid">
                <input class="form-control" name="etempsmoyennne" id="etempsmoyennne" type="number" placeholder="Entrer le temps moyenne" required />
                </div>
            </div>
          
            <div class="col-sm-6 col-lg-6 col-xl-6">
                <div class="modal-body">
                <label class="text-1000 fw-bold mb-2">Temps Maximum</label>
                <input class="form-control" name="etempstotal" id="etempstotal" type="number" placeholder="Entrer le Maximum" required />
                </div>
            </div>
        </div>
         
        </div>
        <div class="modal-footer">
          <button type="submit" name="editftbtn" id="editftbtn" value="Sauvegarder" class="btn btn-primary">Sauvegarder</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  $(function() {
    // Add department ajax 
    $("#addtfform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#add_ft").text('Adding...');
      $.ajax({
        url: "{{ route('storeft') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Element enregistrer avec succès!", "Enregistrement");
            fetchAllft();
            $("#add_ft").text('Sauvegarder');
            $("#addtfform")[0].reset();
            $("#addDealModal").modal('hide');
          }
        }

      });
    });

    // Edit folder ajax request
    $(document).on('click', '.editIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('showft') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#etempsmoyennne").val(response.tempsmoyennne); 
          $("#etempstotal").val(response.tempstotal);
          $("#tid").val(response.id);
        }
      });
    });

    // update function ajax request
    $("#edit_ft_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#editftbtn").text('Mises encours...');
      $.ajax({
        url: "{{ route('sefl') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Element FT modifier avec succès !", "Modification");
            fetchAllft();
            $("#editftbtn").text('Sauvegarder');
            $("#editelementsfeuilletempsModal").modal('hide');

          }

          if (response.status == 201) {
            toastr.error("Le titre du dossier existe déjà !", "Erreur");

            $("#editftbtn").text('Sauvegarder');
          }

          if (response.status == 205) {
            toastr.error("Vous n'avez pas l'accreditation de Modifier ce dossier!", "Erreur");

            $("#editftbtn").text('Sauvegarder');
          }

        }
      });
    });

 
    fetchAllft();

    function fetchAllft() {
      $.ajax({
        url: "{{ route('fetchAllft') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all_ft").html(reponse);
        }
      });
    }
  });
</script>

@endsection