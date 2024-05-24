@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12" style="margin:auto">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Archivage </h4>

            <div class="page-title-right">
              <a class="fs--1 fw-bold" href="javascript::;" data-bs-toggle="modal" data-bs-target="#addModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fa fa-plus-circle "></span> Ajouter classeur </a>
            </div>

          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <!-- Left sidebar -->
          <div class="email-leftbar card">

            <div class="mail-list mt-4">
              <div class="d-flex justify-content-between align-items-center">
                <p class="text-uppercase fs--2 text-600 mb-2 fw-bold"><i class="fa fa-folder-open"></i> Classeur </p>

              </div>
              <ul class="nav flex-column border-top fs--1 vertical-nav mb-4">
                @forelse ($classeur as $classeurs)
                <li class="nav-item"><a class="nav-link py-2 ps-0 pe-3 border-end border-bottom text-start outline-none recupreclasseur" aria-current="page" href="javascript::;" id="{{ $classeurs->id }}">
                    <div class="d-flex align-items-center"><span class="me-2 nav-icons uil uil-inbox"></span><span class="flex-1">{{ $classeurs->libellec }}</span><span class="nav-item-count">5</span></div>
                  </a>
                </li>
                @empty
                Pas de classeur
                @endforelse

            </div>
          </div>



          <div class=" row g-lg-6 mb-8" style="padding-left:10px ; height:430px">
            <div class=" email-leftbar card col-lg">
              <div class="px-lg-1">
                <div id="show_all_recherche" class="show_all_recherche">
                  <h5 style="margin-top:20% ;color:#c0c0c0">
                    <center>
                      <font size="5px"><i class="fa fa-search"></i> </font><br><br>
                      Sélectionner le classeur
                    </center>
                  </h5>
                </div>
              </div>
            </div>
          </div>

        
        </div>

      </div>
      </div> 
    </div>
      </div> 
      @include('archive.modale')

    </div>
     
<!-- Assurez-vous que jQuery est inclus avant ce script -->
<!-- Assurez-vous que jQuery est inclus avant ce script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    $('#classeur').change(function() {
      var classeurId = $(this).val();
      if (classeurId) {
        $.ajax({
          url: '{{ route("getEtiquettesByCl", ":classeurId") }}'.replace(':classeurId', classeurId),
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            $('#etiquette').empty(); // Clear the existing options
            $('#etiquette').append('<option value="" selected="selected">Séléctionner étiquette</option>');
            $.each(data, function(key, etiquette) {
              $('#etiquette').append('<option value="' + etiquette.id + '">' + etiquette.nom_e + '</option>');
            });
          }
        });
      } else {
        $('#etiquette').empty();
        $('#etiquette').append('<option value="" selected="selected">Séléctionner étiquette</option>');
      }
    });
  });
</script>


      
<script>

$(document).ready(function() {
    // Fonction pour gérer la soumission du formulaire d'ajout d'archive
    function handleFormSubmit(event) {
        event.preventDefault();
        
        // Vérification des champs du formulaire
        if (!validateForm()) {
            return;
        }

        // Création des données à envoyer
        var formData = new FormData(this);

        // Ouvrir le modal de chargement
        $('#loadingModal').modal('show');

        // Envoi des données via AJAX
        $.ajax({
            url: '{{ route("archives.store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
                        $('#progressBar').width(percentComplete + '%'); // Mettre à jour la barre de progression

                        // Si la progression est terminée
                        if (percentComplete === 100) {
                            // Fermer le modal de chargement après une courte attente
                            setTimeout(function() {
                                $('#loadingModal').modal('hide');
                            }, 500);
                        }
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                resetForm();
                // Fermer le modal de chargement
                $('#loadingModal').modal('hide');
                // Afficher un message de succès
                alert(response.message);
            },
            error: function(xhr, status, error) {
                console.error(error);
                $('#loadingModal').modal('hide');
                var errorMessage = 'Erreur lors de l\'envoi des données.';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage = xhr.responseJSON.error;
                }
                alert(errorMessage);
                // Fermer le modal de chargement en cas d'erreur
                $('#loadingModal').modal('hide');
            }
        });
    }

    // Fonction pour valider le formulaire 
    function validateForm() {
        var title = $('#titre').val();
        var type = $('input[name="type"]:checked').val();
        var documentFile = $('#file_archive')[0].files[0];
        var description = $('#description').val();

        if (title.trim() === '' || !type || !documentFile || description.trim() === '') {
            alert('Veuillez remplir tous les champs du formulaire.');
            return false;
        }

        // Vérification de la taille du document
        var maxFileSize = 10 * 1024 * 1024; // 10 MB
        if (documentFile.size > maxFileSize) {
            alert('La taille du document ne doit pas dépasser 10 MB.');
            return false;
        }

        // Vérification du format du fichier
        var filePath = $('#file_archive').val();
        var allowedExtensions = /(\.pdf|\.doc|\.docx|\.xls|\.xlsx)$/i;
        if (!allowedExtensions.exec(filePath)) {
            alert('Veuillez sélectionner un fichier PDF, Word ou Excel.');
            return false;
        }

        return true;
    }

    // Fonction pour réinitialiser le formulaire après soumission réussie
    function resetForm() {
        $('#archiveForm')[0].reset();
    }

    // Attacher l'événement de soumission du formulaire à la fonction handleFormSubmit
    $('#archiveForm').submit(handleFormSubmit);
});


</script>





      <script>
        $(function() {

          $('#addModal').modal({
            backdrop: 'static',
            keyboard: false
          });


          $(document).on('click', '.recupreclasseur', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
              url: "{{ route('getarchive') }}",
              method: 'get',
              data: {
                id: id,
                _token: '{{ csrf_token() }}'
              },
              success: function(response) {

                $('#show_all_recherche').html(response);
              }
            });
          });




          fetchAllportie();

          function fetchAllportie() {
            $.ajax({
              url: "{{ route('fetchAllpor') }}",
              method: 'get',
              success: function(reponse) {
                $("#show_all").html(reponse);
              }
            });
          }


        });
      </script>

      @endsection