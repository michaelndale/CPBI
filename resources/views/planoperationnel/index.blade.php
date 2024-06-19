@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="card-header p-4 border-bottom border-300 bg-soft">
      <div class="row g-3 justify-content-between align-items-end">
        <div class="col-12 col-md">
          <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="mdi mdi-book-open-page-variant-outline"></i> Plan d'action <a href=""><i class="ri-refresh-line"></i></a> </h4>
        </div>
        <div class="col col-md-auto">
          <a href="javascript::;" chauffeur="button" data-bs-toggle="modal" data-bs-target="#addplanModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau plan d'action </a>
        </div>
      </div>
    </div>
    <div class="card-body">
        <div class="card">
          <div class="float-end d-none d-md-inline-block">
            <div class="table-responsive show_all" id="show_all">
                <h5 class="text-center text-secondery my-5">
                <center> @include('layout.partiels.load') </center> 
                </h5>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

@include('planoperationnel.modale')
@include('planoperationnel.realisation')
<br><br>

<script>
  var rowIdx = 1;
  $("#addBtn").on("click", function() {
    // Adding a row inside the tbody.
    $("#tableEstimate tbody").append(` 
                <tr id="R${++rowIdx}">
                    <td><input style="width:100%" type="number"   id="numero" name="numero[]"                  class="form-control form-control-sm" value="${rowIdx}" ></td>
                    <td><textarea  style="width:100%" type="text" id="activite"         name="activite[]"     class="form-control form-control-sm" required></textarea></td>
                    <td><input  style="width:100%" type="text"    id="lieu"             name="lieu[]"     class="form-control form-control-sm" required></td>
                    <td><input  style="width:100%" type="text"  id="categoriebenpre"  name="categoriebenpre[]"           class="form-control form-control-sm"    ></td>
                    <td><input  style="width:100%" type="number"  id="nombrebenpre"     name="nombrebenpre[]"    class="form-control form-control-sm"   ></td>
                    <td><input  style="width:100%" type="number"  id="hommebenprev"  name="hommebenprev[]"            class="form-control form-control-sm"   ></td>
                    <td><input  style="width:100%" type="number"    id="femmebenprev"     name="femmebenprev[]"        class="form-control form-control-sm" ></td>
                    <td><input  style="width:100%" type="number"    id="nombreseancepre"     name="nombreseancepre[]"        class="form-control form-control-sm" ></td>
                    <td><input  style="width:100%" type="date"    id="datefin"     name="datefin[]"        class="form-control form-control-sm" ></td>
                    <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Enlever"><i class="far fa-trash-alt"></i></a></td>
                    </tr>`);
  });
  $("#tableEstimate tbody").on("click", ".remove", function() {
    // Getting all the rows next to the row
    // containing the clicked button
    var child = $(this).closest("tr").nextAll();
    // Iterating across all the rows
    // obtained to change the index
    child.each(function() {
      // Getting <tr> id.
      var id = $(this).attr("id");

      // Getting the <p> inside the .row-index class.
      var idx = $(this).children(".row-index").children("p");

      // Gets the row number from <tr> id.
      var dig = parseInt(id.substring(1));

      // Modifying row index.
      idx.html(`${dig - 1}`);

      // Modifying row id.
      $(this).attr("id", `R${dig - 1}`);
    });

    // Removing the current row.
    $(this).closest("tr").remove();

    // Decreasing total number of rows by 1.
    rowIdx--;
  });



 

  $(function() {
    
    $("#addplanForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#addplanbbtn").text('Ajouter...');
      $.ajax({
        url: "{{ route('storeplan') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {

            fetchAllplan();

            $("#addplanbbtn").text('Sauvegarder');
          

            $("#addplanForm")[0].reset();
            $("#addplanModal").modal('hide');
            toastr.success("Plan d\'action ajouté avec succès !", "Enregistrement");
          }
          if (response.status == 201) {
            toastr.error("Attention: Le categorie du plan existe déjà !", "Attention");
            $("#addplanModal").modal('show');
           
          }

          if (response.status == 202) {
            toastr.error("Erreur d'execution, verifier votre internet", "Attention");
            $("#addfebModal").modal('show');
          }

          $("#addplanbtn").text('Sauvegarder');
        }
      });
    });


    $("#addrealisationForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#addrealisationbtn").text('Ajouter...');
      $.ajax({
        url: "{{ route('storerealisation') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            fetchAllplan();
            $("#addrealisationbtn").text('Sauvegarder');
            $("#addrealisationForm")[0].reset();
            $("#ajouterrelisation").modal('hide');
            toastr.success("Réalisaction ajouté avec succès !", "Enregistrement");
          }
          if (response.status == 202) {
            toastr.error("Erreur d'execution, verifier votre internet", "Attention");
            $("#addrealisationModal").modal('show');
          }
          $("#addrealisationbtn").text('Sauvegarder');
        }
      });
    });

    // Delete feb ajax request

    $(document).on('click', '.deletePlan', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Plan d\'action est sur le point d'être DÉTRUITE ! Faut-il vraiment exécuter « la Suppression » ?  ",

        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer !',
        cancelButtonText: 'Annuller'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('deletePlan') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {
              console.log(response);
              toastr.success("Plan d'action supprimer avec succès !", "Suppression");
              fetchAllplan();
            }
          });
        }
      })
    });

     // recuperation fonction ajax request
     $(document).on('click', '.ajouterplan', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: "{{ route('showplanelement') }}", 
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#planid").val(response.plano);
            $("#activiteid").val(response.id);
            $("#activitetitre").val(response.activite);
          }
        });
      });


    fetchAllplan();

    function fetchAllplan() {
      $.ajax({
        url: "{{ route('fetchAllplan') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all").html(reponse);
        }
      });
    }

  });
</script>


@endsection