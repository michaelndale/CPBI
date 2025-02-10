@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card"
                style=" margin:auto">
               

                <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">                 
                    <h4 class="mb-sm-0"><i class="fa fa-list"></i> Rapport cumulatif</h4>
                        <div class="page-title-right">
                         
                          <div class="row">

                            <div class="col-sm-6 col-md-6">
                              
                                <select class="form-select-sm  compteid" id="compteid" name="compteid"  type="text" placeholder="Entrer intitulé du compte" required>
                                 <option disabled="true" selected="true" value=""> -- Compte principal -- </option>
                                  @forelse ($compte as $comptes)
                                    <option value="{{ $comptes->id }}">{{ ucfirst($comptes->numero) }} : {{ ucfirst($comptes->libelle) }}</option>
                                  @empty
                                  <option disabled="true" selected="true">--Aucun compte--</option>
                                  @endforelse
                                </select>
                                
                            </div>

                          


                            <div class="col-sm-5 col-md-5">

                                <select class="form-select-sm scomptef" id="scomptef" name="scomptef"  type="text" placeholder="Entrer intitulé du compte" required>
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


                <div class="card-body p-0">

                    <div id="tableExample2">
                        <div class="table-responsive<div class="table-responsive Showpoll" id="Showpoll">
                            <h5 class="text-center text-secondery my-5">
                            <center> @include('layout.partiels.load') </center> 
                            </h5>
                        </div>
                            
                            <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
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