     
<div class="modal fade" id="verticallyCentered" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
     
      <div class="modal-body">
        <p class="text-700 lh-lg mb-0"> 
        <center> <br> <font size="4"> Vous voulez-vous vraiment quitter le projet ? </font>  <br> <br>

        <a href="{{ route('closeproject') }}" tabindex="-1" aria-labelledby="deconnecterModalLabel" aria-hidden="true"  class="btn btn-primary" type="button">Oui quitter  </a> &nbsp; <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"> Non , rester </button>
      
        </center></p>
      </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="deconnecterModalLabel" tabindex="-1" aria-labelledby="deconnecterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
     
      <div class="modal-body">
        <p class="text-700 lh-lg mb-0"> 
        <center> <br> <font size="4"> Voulez-vous vraiment vous déconnecter ? </font>  <br> <br>

        <a href="{{ route('logout') }}" class="btn btn-primary" type="button">Oui   </a> &nbsp; <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"> Non </button>
      
        </center></p>
      </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="EditMotdepasseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="addForm" autocomplete="off">
        @method('post')
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-plus"></i> Modifier mot de passe </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
          </div>
          <div class="modal-body">
          <div class="row" >
                  <div class="col-sm-6 col-md-12">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="nom"  name="nom"  type="text"required="required" placeholder="Identifiant" />
                      <label for="Identifiant">Anciant mot de paase</label>
                      <span id="identifiant_error" name="nom_error" class="text text-danger" > </span>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-12">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="nom"  name="nom"  type="text"required="required" placeholder="Identifiant" />
                      <label for="Identifiant">Nouveau mot de paase</label>
                      <span id="identifiant_error" name="nom_error" class="text text-danger" > </span>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-12">
                  <div class="form-floating mb-3">
                    <input class="form-control" id="prenom" type="text" name="prenom" required="required" placeholder="Password" />
                    <label for="Password">Confirmer le nouveau mot de passe</label>
                  </div>
                  </div>
                </div>

               

              
          </div>
          <div class="modal-footer">
            <button type="submit" name="addbtn" id="addbtn" class="btn btn-primary">Sauvegarder</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="EditPersonnelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="EditPersonnelForm" autocomplete="off">
        @method('post')
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-plus"></i> Modifier personnel</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
          </div>
          <div class="modal-body">
          <div class="row" >

               
                 

                 <input  id="per_id"  name="per_id"  type="hidden"/>

                  <div class="col-sm-6 col-md-6">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="per_nom"  name="per_nom"  type="text"required="required" placeholder="Identifiant" />
                      <label for="Identifiant">Nom</label>
                      <span id="identifiant_error" name="nom_error" class="text text-danger" > </span>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                  <div class="form-floating mb-3">
                    <input class="form-control" id="per_prenom" type="text" name="per_prenom" required="required" placeholder="Password" />
                    <label for="Password">Prénom </label>
                  </div>
                  </div>
                </div>

                <div class="row" >
                  <div class="col-sm-6 col-md-6">
                    <div class="form-floating mb-3">
                      <select class="form-control" id="per_sexe"  name="per_sexe"  type="text"required="required" placeholder="Identifiant">
                        <option value="">Séléctionner genre</option>
                        <option value="Femme">Femme</option>
                        <option value="Homme">Homme</option>
                      </select>
                      <label for="sexe">Sexe</label>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                  <div class="form-floating mb-3">
                    <input class="form-control" id="per_phone" type="text" name="per_phone" required="required" placeholder="Téléphone" />
                    <label for="Password">Téléphone </label>
                  </div>
                  </div>
                </div>

                <div class="row" >
                  <div class="col-sm-12 col-md-12">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="per_email"  name="per_email"  type="text" required="required" placeholder="Email" />
                      <label for="email">Email</label>
                      <span id="email_error" name="email_error" class="text text-danger" > </span>
                    </div>
                  </div>
                </div>
          </div>
          <div class="modal-footer">
            
            <button type="submit" name="EditPersonnelbtn" id="EditPersonnelbtn" class="btn btn-primary">Sauvegarder</button>
          </div>
        </div>
      </form>
    </div>
  </div>
 

  <script>
    $(function() {

      // Edit personnel ajax request
      $(document).on('click', '.editpersonnel', function(e) 
      {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: "{{ route('showPersonnel') }}",
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#per_id").val(response.id);
            $("#per_nom").val(response.nom);
            $("#per_prenom").val(response.prenom);
            $("#per_sexe").val(response.sexe);
            $("#per_phone").val(response.phone);
            $("#per_email").val(response.email);
          }
        });
      });

      // update personnel ajax request
      $("#EditPersonnelForm").submit(function(e) 
      {
        e.preventDefault();
        const fd = new FormData(this);
        $("#EditPersonnelbtn").text('Mise à jour...');
        $.ajax({
          url:"{{ route('updatPersonnel') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) 
          {
            if (response.status == 200) {
             $.notify("Mise à jour  avec succès !", "success");
              $("#EditPersonnelModal").modal('show');
             
            }
            
            if (response.status == 202) {
             // $.notify("Erreur d'execution, verifier votre internet", "error");
              $("#EditPersonnelModal").modal('show');
            }

            $("#EditPersonnelbtn").text('Sauvegarder');

          }
        });
      });
    });
  </script>
 <!-- Right bar overlay-->
 <div class="rightbar-overlay"></div>

<!-- JAVASCRIPT -->
<script src="{{ asset('element/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('element/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('element/assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('element/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('element/assets/libs/node-waves/waves.min.js') }}"></script>

<!-- apexcharts -->
<script src="{{ asset('element/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- Vector map-->
<script src="{{ asset('element/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('element/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

<!-- echarts js -->
<script src="{{ asset('element/assets/libs/echarts/echarts.min.js') }}"></script>

<script src="{{ asset('element/assets/js/pages/dashboard.init.js') }}"></script>

<script src="{{ asset('element/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('element/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('element/assets/js/pages/datatables.init.js') }}"></script>

<script src="{{ asset('element/assets/js/app.js') }}"></script>

</body>

</html>


