@include('layout.partiels.shareData')

  
    <div class="modal fade bs-signalisation" tabindex="-1" id="bs-signalisation" role="dialog" aria-labelledby="bs-signalisation" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"> <i class="ri-chat-voice-line"></i> Signalisation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            @include('signalisation.index')
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
                <font size="4"> Vous voulez-vous vraiment quitter <br> le projet encours : "
                  @if (session()->has('id'))
                    @php
                    $titprojet = Session::get('title');
                    @endphp
                    <b>{{ $titprojet }}.  "</b>
                  @endif 
                </font> <br> <br>
                <a href="{{ route('closeproject') }}" tabindex="-1"  aria-hidden="true" class="btn btn-primary" type="button"><i class="fas fa-check-circle"></i> Oui </a> &nbsp; <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="fas fa-times-circle"></i> Non</button>
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


   @include('layout.partiels.profile_info')
  
   @include('layout.partiels.profile_theme')
   
   @include('layout.partiels.profile_pwd')

   @include('layout.partiels.profile_image')

   @include('layout.partiels.profile_signature')


    <div class="progress">
      <div id="progress" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
    // Vérifier si l'élément audio existe dans le DOM
    var audio = document.getElementById('notificationAudio');
    
    if (!audio) {
        return; // Arrêter l'exécution si l'élément n'est pas trouvé
    }

    // Tentative de lecture de l'audio
    try {
        var playPromise = audio.play();

        // Gérer les promesses si elles sont prises en charge
        if (playPromise !== undefined) {
            playPromise.catch(function () {
                // Ignorer silencieusement les erreurs de lecture
            });
        }
    } catch (error) {
        // Ignorer silencieusement les erreurs inattendues
    }
});
    </script>


    <script>
      $(document).ready(function() {
        $('#EditThemeForm').on('submit', function(e) {
          e.preventDefault();

          $.ajax({
            type: 'POST',
            url: "{{ route('update-theme') }}",
            data: $(this).serialize(),
            success: function(response) {
              if (response.success) {
                toastr.success(response.message);
                window.location.reload();
                $('#editthemeModal').modal('hide');
              } else {
                toastr.error('Une erreur est survenue.');
              }
            },
            error: function(response) {
              toastr.error('Une erreur est survenue.');
            }
          });
        });
      });
    </script>



<script>

  // VERIFICATION DE LA CONNECTION INTERNET

  
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


// VISUALISER L'IMAGE
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

 /* document.getElementById('recherche').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#footernotification tr');

    rows.forEach(row => {
      let text = row.textContent.toLowerCase();
      row.style.display = text.includes(filter) ? '' : 'none';
    });
  });  */

/*

  fetchnotification();
  function fetchnotification() {
    $.ajax({
      url: "{{ route('allnotification') }}",
      method: 'get',
      success: function(reponse) {
        $("#febnotification").html(reponse);
     
      }
    });
  }

  fetchnotificationdap();

  function fetchnotificationdap() {
    $.ajax({
      url: "{{ route('allnotificationdap') }}",
      method: 'get',
      success: function(reponse) {
      
        $("#dapnotification").html(reponse);
      }
    });
  }

  fetchnotificationdja();
  
  function fetchnotificationdja() {
    $.ajax({
      url: "{{ route('allnotificationdja') }}",
      method: 'get',
      success: function(reponse) {
      
        $("#djanotification").html(reponse);
      }
    });
  }

  fetchnotificationbpc();
  
  function fetchnotificationbpc() {
    $.ajax({
      url: "{{ route('allnotificationbpc') }}",
      method: 'get',
      success: function(reponse) {
      
        $("#bpcnotification").html(reponse);
      }
    });
  }

  fetchnotificationfac();
  
  function fetchnotificationfac() {
    $.ajax({
      url: "{{ route('allnotificationfac') }}",
      method: 'get',
      success: function(reponse) {
      
        $("#facnotification").html(reponse);
      }
    });
  }

  fetchnotificationdac();
  
  function fetchnotificationdac() {
    $.ajax({
      url: "{{ route('allnotificationdac') }}",
      method: 'get',
      success: function(reponse) {
      
        $("#dacnotification").html(reponse);
      }
    });
  }

  fetchnotificationrac();
  
  function fetchnotificationrac() {
    $.ajax({
      url: "{{ route('allnotificationrac') }}",
      method: 'get',
      success: function(reponse) {
      
        $("#racnotification").html(reponse);
      }
    });
  }
  */
  
</script>
<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
<!-- JAVASCRIPT -->
<script src="{{ asset('element/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('element/assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('element/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('element/assets/libs/node-waves/waves.min.js') }}"></script>

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



<div id="message" class="offline" style="display:none;">
  <i class="fa fa-info-circle"></i> Vous êtes hors ligne !
</div>


</body>

</html>