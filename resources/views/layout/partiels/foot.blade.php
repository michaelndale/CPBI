

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myLargeModalLabel"><i class="fa fa-folder-open"></i>Tâches à faire en attente </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" >


      <div id="tableExample2" >
              <div class="table-responsive">
                <table class="table table-striped table-sm fs--1 mb-0" >
                  <thead>
                    <tr>
                      <th class="sort border-top "><b>ID </b></center></th>
                      <th class="sort border-top" data-sort="Document"><b>Document</b></th>
                      <th class="sort border-top" data-sort="febnum"><b>N<sup>o</sup> Doc </b></th>
                      <th class="sort border-top" data-sort="Date Doc"><b>Date Doc</b></th>
                      <th class="sort border-top" data-sort="Créé le"><b>Créé le</b></th>
                      <th class="sort border-top" data-sort="Date limite"><b>Date limite</b></th>
                      <th class="sort border-top" data-sort="Créé par"><b>Créé par</b></th>
                      
                    </tr>
                  </thead>


                  <tbody id="footernotification" >
                  </tbody>
                </table>
              </div>
      </div>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade" id="verticallyCentered" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <p class="text-700 lh-lg mb-0">
          <center>
            <font size="7" color="#c0c0c0"> <i class="fas fa-info-circle "></i></font>
            <br>
            <font size="4"> Vous voulez-vous vraiment quitter <br> le projet encours ? </font> <br> <br>
            <a href="{{ route('closeproject') }}" tabindex="-1" aria-labelledby="deconnecterModalLabel" aria-hidden="true" class="btn btn-primary" type="button"><i class="fas fa-check-circle"></i> Oui </a> &nbsp; <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Non</button>
          </center>
        </p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deconnecterModalLabel" tabindex="-1" aria-labelledby="deconnecterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <p class="text-700 lh-lg mb-0">
          <center>
            <font size="7" color="#c0c0c0"> <i class="fas fa-info-circle "></i></font> <br>
            <font size="4">Voulez-vous vraiment vous déconnecter <br> de l'application ? </font> <br> <br>
            <a href="{{ route('logout') }}" class="btn btn-primary" type="button"> <i class="fas fa-check-circle"></i> Oui </a> &nbsp; <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"> <i class="fa fa-times-circle"></i> Non </button>
          </center>
        </p>
      </div>
    </div>
  </div>
</div>
</div>



<div class="modal fade" id="EditPersonnelModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="EditPersonnelForm" autocomplete="off">
      @method('post')
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-edit"></i> Modifier mon compte</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
        </div>
        <div class="modal-body">
          <div class="row">

            <input id="per_id" name="per_id" type="hidden" />

            <div class="col-sm-6 col-md-6">
              <div class="form-floating mb-3">
                <input class="form-control" id="per_nom" name="per_nom" type="text" required="required" placeholder="Identifiant" />
                <label for="Identifiant">Nom</label>
                <span id="identifiant_error" name="nom_error" class="text text-danger"> </span>
              </div>
            </div>
            <div class="col-sm-6 col-md-6">
              <div class="form-floating mb-3">
                <input class="form-control" id="per_prenom" type="text" name="per_prenom" required="required" placeholder="Password" />
                <label for="Password">Prénom </label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6 col-md-6">
              <div class="form-floating mb-3">
                <select class="form-control" id="per_sexe" name="per_sexe" type="text" required="required" placeholder="Identifiant">
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

          <div class="row">
            <div class="col-sm-12 col-md-12">
              <div class="form-floating mb-3">
                <input class="form-control" id="per_email" name="per_email" type="text" required="required" placeholder="Email" />
                <label for="email">Email</label>
                <span id="email_error" name="email_error" class="text text-danger"> </span>
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




<div class="modal fade" id="editMotdepasseModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="EditNDPForm" autocomplete="off">
      @method('post')
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-edit"></i> Modifier mot de passe </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6 col-md-12">
              <div class="form-floating mb-3">
                <input id="userid" name="userid" type="hidden" value="{{ Auth::user()->id }}" />

                <input class="form-control" id="anpwd" name="anpwd" type="password" required="required" placeholder="Ancient mot de passe" />
                <label for="Identifiant">Anciant mot de paase</label>
                <span id="identifiant_error" name="ancienmotdepasse_error" class="text text-danger"> </span>
              </div>
            </div>
            <div class="col-sm-6 col-md-12">
              <div class="form-floating mb-3">
                <input class="form-control" id="npwd" name="npwd" type="password" required="required" placeholder="Nouveau mot de passe" />
                <label for="Identifiant">Nouveau mot de paase</label>
                <span id="identifiant_error" name="nouveaumotdepasse_error" class="text text-danger"> </span>
              </div>
            </div>
            <div class="col-sm-6 col-md-12">
              <div class="form-floating mb-3">
                <input class="form-control" id="cpwd" name="cpwd" type="password" required="required" placeholder="Confirmation le nouveau mot de passe" />
                <label for="Password">Confirmer le nouveau mot de passe</label>
              </div>
            </div>
          </div>




        </div>
        <div class="modal-footer">
          <button type="submit" name="addNDPbtn" id="addNDPbtn" class="btn btn-primary">Sauvegarder</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="editprofileModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="EditprofileForm" enctype='multipart/form-data'>
      @method('post')
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-edit"></i> Modifier image profile </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="custom-file">
              <input id="profileuserid" name="profileuserid" type="hidden" value="{{ Auth::user()->id }}" />
              <input type="file" class="form-control" id="file" name="file" accept="image/jpeg, image/png" onchange="preview_image(event)">

            </div>
            <br><br>
            <div id="wrapper">
              @php
              $avatar = Auth::user()->avatar;
              $defaultAvatar = '../../element/profile/default.png'; // Chemin vers votre image par défaut
              $imagePath = public_path($avatar);
              @endphp

              @if(file_exists($imagePath))
              <img id="output_image" src="../../{{ $avatar }}" alt="{{ ucfirst(Auth::user()->identifiant) }}" style="width:50%; border-radius:10px ; margin-left:25% ">
              @else
              <img id="output_image" src="{{ $defaultAvatar }}" alt="{{ ucfirst(Auth::user()->identifiant) }}" style="width:50%; border-radius:10px ; margin-left:25% ">
              @endif




            </div>

          </div>




        </div>
        <div class="modal-footer">
          <button type="submit" name="addprofilebtn" id="addprofilebtn" class="btn btn-primary">Sauvegarder</button>
        </div>
      </div>
    </form>
  </div>
</div>



<div class="modal fade" id="editsignatureModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="EditsignatureForm" autocomplete="off" enctype='multipart/form-data'>
      @method('post')
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-edit"></i> Modifier le signature </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="custom-file">
              <input id="personneidp" name="personneidp" type="hidden" value="{{ Auth::user()->id }}" />
              <input type="file" class="form-control" id="customFile" name="signature" accept="image/*" onchange="preview_image(event)">
            </div>
            <br><br>
            <div id="wrapper">
              @php
              $signature = Auth::user()->signature;
              @endphp
              <img src="{{  asset($signature) }}" id="output_image" class="" style="width:50%; border-radius:10px ; margin-left:25% ">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="addsignaturebtn" id="addsignaturebtn" class="btn btn-primary">Sauvegarder</button>
        </div>
      </div>
    </form>
  </div>
</div>


<div class="progress">
  <div id="progress" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
</div>





<script>
  window.addEventListener('load', function() {
    var messageDiv = document.getElementById('message');

    function checkInternetConnection() {
      var online = navigator.onLine;
      if (!online) {
        messageDiv.style.display = 'block';
      } else {
        messageDiv.style.display = 'none';
      }
    }

    // Vérifie la connexion Internet au chargement de la page
    checkInternetConnection();

    // Vérifie la connexion Internet à chaque changement de statut de la connexion
    window.addEventListener('online', checkInternetConnection);
    window.addEventListener('offline', checkInternetConnection);
  });



  function preview_image(event) {
    var reader = new FileReader();
    reader.onload = function() {
      var output = document.getElementById('output_image');
      output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
  }


  $(function() {
    // Edit personnel ajax request
    $(document).on('click', '.editpersonnel', function(e) {
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

          $("#per_id").val(response.idp);
          $("#per_nom").val(response.nom);
          $("#per_prenom").val(response.prenom);
          $("#per_sexe").val(response.sexe);
          $("#per_phone").val(response.phone);
          $("#per_email").val(response.email);
        }
      });
    });

    $(document).on('click', '.voirphotopersonnel', function(e) {
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


          $("#perphoto").val(response.avatar);
        }
      });
    });



    // update personnel ajax request
    $("#EditPersonnelForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#EditPersonnelbtn").text('Mise à jour...');
      $.ajax({
        url: "{{ route('updatPersonnel') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Mise à jour  avec succès !", "success");
            $("#EditPersonnelModal").modal('show');

          }

          if (response.status == 202) {
            toastr.error("Erreur d'execution, verifier votre internet", "error");
            $("#EditPersonnelModal").modal('show');
          }

          $("#EditPersonnelbtn").text('Sauvegarder');

        }
      });
    });

    // update password ajax request
    $("#EditNDPForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#EditNDPbtn").text('Mise à jour...');
      $.ajax({
        url: "{{ route('updatUser') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Mise à jour reussi  avec succès !", "success");
            $("#editMotdepasseModal").modal('hide');

          }

          if (response.status == 202) {
            toastr.error("Erreur d'execution, verifier votre internet", "error");
            $("#editMotdepasseModal").modal('show');
          }

          $("#EditNDPbtn").text('Sauvegarder');

        }
      });
    });

    $("#EditprofileForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#Editprofilebtn").text('Mise à jour...');

      $.ajax({
        url: "{{ route('updatProfile') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
              var percentComplete = (evt.loaded / evt.total) * 100;
              $('#progress').css('width', percentComplete + '%');

              // Si le téléchargement est terminé à 100%
              if (percentComplete === 100) {
                // Fermer le modal
                $("#editprofileModal").modal('hide');
              }
            }
          }, false);
          return xhr;
        },
        success: function(response) {
          if (response.status == 200) {
            toastr.success(response.message, "Success");
            //$("#editprofileModal").modal('hide'); // Vous pouvez également le fermer ici si nécessaire
            var ur = "{{ route('dashboard') }}";

            window.location.href = ur;
          } else if (response.status == 206) {
            toastr.error(response.message, "Error");
          } else if (response.status == 202) {
            toastr.error(response.message, "Error");
          }
          $("#Editprofilebtn").text('Sauvegarder');
        }
      });
    });



    // update password ajax request
    $("#EditsignatureForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#Editsignaturebtn").text('Mise à jour...');
      $.ajax({
        url: "{{ route('updatsignature') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Mise à jour reussi  avec succès !", "success");
            $("#editsignatureModal").modal('hide');

            var ur = "{{ route('dashboard') }}";

            window.location.href = ur;

          }

          if (response.status == 202) {
            toastr.error("Erreur d'execution, verifier votre internet", "error");
            $("#editsignatureModal").modal('show');
          }

          $("#Editsignaturebtn").text('Sauvegarder');

        }
      });
    });


  });

  fetchnotification();

  function fetchnotification() {
      $.ajax({
        url: "{{ route('allnotification') }}",
        method: 'get',
        success: function(reponse) {
          $("#allnotification").html(reponse);
          $("#footernotification").html(reponse);
        }
      });
    }

</script>
<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
<!-- JAVASCRIPT -->
<script src="{{ asset('element/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('element/assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('element/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('element/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('element/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('element/assets/js/app.js') }}"></script>

<!-- Sweet Alerts js -->
<script src="{{ asset('element/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Sweet alert init js-->
<script src="{{ asset('element/assets/js/pages/sweet-alerts.init.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



@if(Session::has('success'))
<script>
  toastr.success("{{ Session::get('success') }}")
</script>
@elseif(Session::has('failed'))
<script>
  toastr.error("{{ Session::get('failed') }}")
</script>
@elseif(Session::has('info'))
<script>
  toastr.info("{{ Session::get('info') }}")
</script>
@endif


<script>
    var offlineMessage = document.getElementById("message");
    var isConnected = false;
    var connectionAttempts = 0;
    var maxConnectionAttempts = 5; // Maximum de tentatives de connexion

    // Fonction pour vérifier l'état de la connexion
    function checkConnection() {
        // Ici, vous devrez implémenter votre logique pour vérifier l'état de la connexion
        // Par exemple, vous pouvez utiliser AJAX pour envoyer une requête à un serveur et vérifier la réponse.
        // Pour cet exemple, nous supposerons que la connexion est rétablie aléatoirement.
        isConnected = Math.random() < 0.5; // 50% de chance de connexion réussie

        if (isConnected) {
            // Si la connexion est rétablie, masquer le message
            offlineMessage.style.display = "none";
            connectionAttempts = 0; // Réinitialiser le compteur de tentatives
        } else {
            // Si la connexion n'est pas rétablie, afficher le message
            offlineMessage.style.display = "block";
            connectionAttempts++;
            if (connectionAttempts >= maxConnectionAttempts) {
                // Si le nombre maximal de tentatives est atteint, arrêter la vérification de la connexion
                clearInterval(connectionCheckInterval);
            }
        }
    }

    // Vérifier périodiquement l'état de la connexion
    var connectionCheckInterval = setInterval(checkConnection, 5000); // Vérifier toutes les 5 secondes
</script>


<div id="message" class="offline"><i class="fa fa-info-circle"></i> Vous êtes hors ligne ! </div>


</body>

</html>