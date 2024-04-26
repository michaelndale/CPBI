@extends('layout/app')
@section('page-content')
<div class="main-content">
  <br>
  <div class="content">
    <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">
      <div class="card-header p-4 border-bottom border-300 bg-soft">
        <div class="row g-3 justify-content-between align-items-end">
          <div class="col-12 col-md">
            <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="mdi mdi-book-open-page-variant-outline"></i> Demande et d'Autorisation de Paiement "DAP" </h4>
          </div>
          <div class="col col-md-auto">

            <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#dapModale"><span class="me-2" data-feather="plus-circle"></span> <i class="fa fa-plus-circle"></i> Nouvel fiche DAP</a></nav>
          </div>
        </div>
      </div>
      <div class="card-body p-0">

        <div id="tableExample2" >
          <div class="table-responsive">
            <table class="table table-striped table-sm fs--1 mb-0" style="background-color:#c0c0c0">

              <tbody id="showSommefeb">

              </tbody>

            </table>
           
          </div>

        </div>



        <div id="tableExample2">
          <div class="table-responsive">
            <table class="table table-striped table-sm fs--1 mb-0">
              <thead>
                <tr>
                  <th class="sort border-top ">
                    <center><b>Actions</b></center>
                  </th>

                  <th class="sort border-top "> <center><b>N<sup>o</sup>  DAP </b></center> </th>
                  <th class="sort border-top "> <center> <b>N<sup>o</sup>  FEB </b></center> </th>
                  <th class="sort border-top "> <b>Lieu </b></th>
                  <th class="sort border-top "><center> <b>OV  </b></center></th>
                  <th class="sort border-top "> <center><b>CHO </b></center></th>
                  <th class="sort border-top "> <b>Compte bancaire </b></th>

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

@include('document.dap.modale')

<BR><BR>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {

    $(document).on('change', '.febid', function() {
      var febref = $(this).val();
      var div = $(this).parent();
      var op = " ";
      $.ajax({
        type: 'get',
        url: "{{ route ('getfeb') }}",
        data: {
          'id': febref
        },
        success: function(reponse) {
          $("#Showpoll").html(reponse);
        },
        error: function() {
          alert("Attention! \n Erreur de connexion a la base de donnee ,\n verifier votre connection");
        }
      });
    });
  });
</script>

<script>

  $(function() {

    $("#adddapForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#addfebbtn").html('<i class="fas fa-spinner fa-spin"></i>');
        $("#loadingModal").modal('show'); // Affiche le popup de chargement
      $.ajax({
        url: "{{ route('storedap') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {

            fetchAlldap();

            $("#adddapForm")[0].reset();
            $("#dapModale").modal('hide');

            toastr.success("DAP ajouté avec succès !", "success");


          }
          if (response.status == 201) {
            toastr.error("Attention: DAP fonction existe déjà !", "info");
            $("#dapModale").modal('show');
          }

          if (response.status == 202) {
            toastr.error("Erreur d'execution, verifier votre internet", "error");
            $("#dapModale").modal('show');
          }

          $("#addfebbtn").text('Sauvegarder');
            $("#loadingModal").modal('hide'); 
            setTimeout(function() {
                $("#loadingModal").modal('hide');
            }, 600); // 2000 millisecondes = 2 secondes
        }
      });
    });

    // Delete feb ajax request

    $(document).on('click', '.deleteIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "DAP est sur le point d'être DÉTRUITE ! Faut-il vraiment exécuter « la Suppression » ?  ",

        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer !',
        cancelButtonText: 'Annuller'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('deletedap') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {
              

              if (response.status == 200) {
                toastr.success("DAP supprimer avec succès !", "Suppression");
                fetchAlldap();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de supprimer ce DAP !", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
              fetchAlldap();

            }
          });
        }
      })
    });

    fetchAlldap();
    function fetchAlldap() {
      $.ajax({
        url: "{{ route('fetchdap') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all").html(reponse);
        }
      });
    }

  });
</script>

@endsection