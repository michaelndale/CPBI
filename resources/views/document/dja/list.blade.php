@extends('layout/app')
@section('page-content')
<div class="main-content">
  <br>

  <div class="content">
    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">
      <div class="card-header p-4 border-bottom border-300 bg-soft">
        <div class="row g-3 justify-content-between align-items-end">
          <div class="col-12 col-md">
            <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="mdi mdi-book-open-page-variant-outline"></i> Demande et Justification d'Avance "DJA" </h4>
          </div>
          
        </div>
      </div>
      <div class="card-body p-0">

        <div id="tableExample2" >
          <div class="table-responsive">
            <table class="table table-striped table-sm fs--1 mb-0 table-bordere" style="background-color:#c0c0c0">



              <tbody id="showSommefeb">

              </tbody>

            </table>
          
          </div>

        </div>



        <div id="tableExample2" >
          <div class="table-responsive">
            <table class="table table-striped table-sm fs--1 mb-0">
              <thead>
                <tr>
                  <th>
                    <center><b>Actions</b></center>
                  </th>
                  <th><b>N<sup>o</sup> DJA</b> </th>
                  <th><b>N<sup>o</sup> DAP</b></th>
                  <th><b>N<sup>o</sup> FEB</b></th>
                  <th><b>OV </b></th>
                  <th><b>Beneficiare</b></th>
                  <th><b>Montant avance</b></th>
                </tr>
              </thead>


              <tbody class="show_all" id="show_all">
                <tr>
                  <td colspan="9">
                    <h5 class="text-center text-secondery my-5">
                      @include('layout.partiels.load')
                  </td>
                </tr>
              </tbody>

            </table>
            <br><br><br><br>
            <br><br><br><br>
            <br>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>



@include('document.dja.modale')



<script>
  $(function() {

    // Add  ajax 
    $("#addjdaForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#addfebbtn").html('<i class="fas fa-spinner fa-spin"></i>');
        $("#loadingModal").modal('show'); // Affiche le popup de chargement
      $.ajax({
        url: "{{ route('storedja') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {

           
            

            
            fetchAlldja();
            toastr.success("DJA ajouté avec succès !", "success");
            
            //$("#adddjaForm")[0].reset();
            $("#djaModale").modal('hide');
          }
          if (response.status == 201) {
            toastr.error("Attention: DJA fonction existe déjà !", "info");
            $("#djaModale").modal('show');
          }

          if (response.status == 202) {
            toastr.error("Erreur d'execution, verifier votre internet", "error");
            $("#djaModale").modal('show');
          }

          $("#addjabtn").text('Sauvegarder');
          $("#loadingModal").modal('hide');
          setTimeout(function() {
            $("#loadingModal").modal('hide');
          }, 600); // 2000 millisecondes = 2 secondes
        }
      });
    });

    $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Êtes-vous sûr ?',
          text: "DJA est sur le point d'être DÉTRUITE ! Faut-il vraiment exécuter « la Suppression » ?  ",

          showCancelButton: true,
          confirmButtonColor: 'green',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Oui, Supprimer !',
          cancelButtonText: 'Annuller'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "{{ route('deletedja') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                toastr.success("DJA supprimer avec succès !", "Suppression");
                fetchAlldja();
              }
            });
          }
        })
      });


fetchAlldja();

function fetchAlldja() {
  $.ajax({
    url: "{{ route('fetchdja') }}",
    method: 'get',
    success: function(reponse) {
      $("#show_all").html(reponse);
    }
  });
}
  });
</script>

@endsection