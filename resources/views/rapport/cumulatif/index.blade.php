@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="card-header p-4 border-bottom border-300 bg-soft">
      <div class="row g-3 justify-content-between align-items-end">
        <div class="col-3 col-md">
          <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="mdi mdi-search-open-page-variant-outline"></i> Rapport cumulatif </h4>
        </div>

        <div class="col-8 col-md">
          <div class="row">

          <div class="col-sm-4 col-md-5">
              
                <select class="form-select compteid" id="compteid" name="compteid"  type="text" placeholder="Entrer intitulé du compte" required>
                <option disabled="true" selected="true" value=""> -- Compte principal -- </option>
                  @forelse ($compte as $comptes)
                    <option value="{{ $comptes->id }}">{{ ucfirst($comptes->numero) }} : {{ ucfirst($comptes->libelle) }}</option>
                  @empty
                  <option disabled="true" selected="true">--Aucun compte--</option>
                  @endforelse
                </select>
                
                </div>

                <div class="col-sm-4 col-md-5">
               
                <select class="form-select scomptef" id="scomptef" name="scomptef"  type="text" placeholder="Entrer intitulé du compte" required>
                  <option disabled="true" selected="true"> -- Sous compte -- </option>
                </select>
                </div>

               <!-- <div class="col-sm-4 col-md-2">
                <button type="submit" name="savebtn" id="savebtn" class="btn btn-primary" type="button"> <i class="fa fa-search"></i> </button>
                </div>

-->
            
          </div>
        </div>


      </div>
    </div>
    <div class="card-body">
        <div class="card">
          <div class="float-end d-none d-md-inline-block">
            <div class="table-responsive Showpoll" id="Showpoll">
                <h5 class="text-center text-secondery my-5">
                <center> @include('layout.partiels.load') </center> 
                </h5>
            </div>
          </div>
        </div>

        <br><br>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    $('#dtHorizontalVerticalExample').DataTable({
      "scrollX": true,
      "scrollY": 200,
    });
    $('.dataTables_length').addClass('bs-select');
  });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {

    $(document).on('change', '.compteid', function() {
      var cat_id = $(this).val();
      var div = $(this).parent();
      var op = " ";
      $.ajax({
        type: 'get',
        url: "{{ route ('findSousCompte') }}",
        data: {
          'id': cat_id
        },
        success: function(data) {
          console.log(data);
          if (data.length == 0) {
            op += '<option value="0" selected disabled>--Ligne compte--</option>';
            op += '<option value="0" selected disabled>Aucun </option>';
            document.getElementById("scomptef").innerHTML = op
            toastr.error("Attention!!\n la ligne  n'a pas de sous ligne", "Information");
          } else {

            op += '<option value="0" selected disabled>Aucun </option>';
            op += '<option value="Tout" >Tout </option>';
            for (var i = 0; i < data.length; i++) {
              op += '<option value="' + data[i].id + '">' + data[i].numero + '.' + data[i].libelle + '</option>';
              document.getElementById("scomptef").innerHTML = op
            }
          }

        },
        error: function() {

          toastr.error("Erreur de connexion a la base de donnee ,\n verifier votre connection", "Attention");
        }
      });
    });


    $(document).on('change', '.scomptef', function() {
      var scomptef = $(this).val();
      var grancompte =  document.getElementById('compteid').value; 
      var div = $(this).parent();
      var op = " ";
      $.ajax({
        type: 'get',
        url: "{{ route ('getcumule') }}",
       
          data:{'compte':grancompte,'souscompte':scomptef},
       
        success: function(reponse) {
          $("#Showpoll").html(reponse);
          
        },
        error: function() {
          alert("Attention ! \n Erreur de connexion a la base de donnee ,\n verifier votre connection");
        }
      });
    });



  });
</script>





@endsection