@extends('layout/app')
@section('page-content')
<style>
  .swal-custom-content .swal-text {
      font-size: 14px;
      /* Ajustez la taille selon vos besoins */
  }

  .has-error {
      border: 1px solid red;
      /* Bordure rouge pour indiquer une erreur */
      background-color: #ffe6e6;
      /* Fond rouge clair */
      color: red;
      /* Texte rouge */
  }

  .has-success {
      border: 1px solid green;
      /* Bordure verte pour indiquer le succès */
      background-color: #e6ffe6;
      /* Fond vert clair */
      color: green;
      /* Texte vert */
  }
</style>
    <div class="main-content">
        <div class="page-content">
            <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card"
                style=" margin:auto">

                <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.30rem 3rem;">
                    <h4 class="mb-sm-0"><i class="fa fa-plus-circle"></i> Nouvel Fiche Demande
                        d'Autorisation de Paiement (DAP)</h4>
                    <div class="page-title-right">
                        <a href="{{ route('nouveau.dap') }}" id="fetchDataLink"
                            class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" title=" Actualiser">
                            <i class="fas fa-sync-alt"></i>
                        </a>

                        <a href="{{ route('listdap') }}" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm">
                            <span class="fa fa-plus-circle"></span> Listes
                        </a>

                    </div>

                </div>

                <form class="row g-3 mb-6" method="POST" id="adddapForm" style="padding: 0.8%">
                  @method('post')
                  @csrf

                    <div class="card-body p-0" >
                        <div id="tableExample2">
                            <div class="table-responsive">
                                <div id="tableExample2">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm fs--1 mb-0">
                                            <tbody  >
                                                <tr>
                                                    <td style="width:300px"> Service <br>
                                                        <select type="text" name="serviceid" id="serviceid" style="width: 100%" class="form-control form-control-sm" required>
                                                            <option disabled="true" selected="true" value="">--Aucun--</option>
                                                            @forelse ($service as $services)
                                                            <option value="{{ $services->id }}"> {{ $services->title }} </option>
                                                            @empty
                                                            <option disabled="true" selected="true" value="">--Aucun service trouver--</option>
                                                            @endforelse
                                                        </select>
                                                    </td>
            
                                                    <td colspan="6">
                                                        <b>Composante/ Projet/Section </b><br>
                                                        <input value="{{ Session::get('id') }}" type="hidden" name="projetid" id="projetid" required>
                                                        <input value="{{ Session::get('title') }}" class="form-control form-control-sm" disabled>
                                                    </td>
            
            
                                                    <td class="align-middle" style="width:20% ;  background: rgba(76, 175, 80, 0.3)" rowspan="3">
                                                        <b>Numéro F.E.B: <small>(Disponible)</small> </b> <br>
                                                        <select class="form-control form-control-sm febid" style="width: 100%; height: 150px;" required multiple>
                                                          <!-- Option par défaut -->
                                                          <option disabled selected>--Aucun--</option>
                                                          
                                                          <!-- Boucle pour afficher les options dynamiques -->
                                                          @forelse ($feb as $febs)
                                                              <option value="{{ $febs->id }}">{{ $febs->numerofeb }}</option>
                                                          @empty
                                                              <!-- Option affichée en cas de liste vide -->
                                                              <option disabled>--Aucun numéro FEB trouvé--</option>
                                                          @endforelse
                                                      </select>
                                                      
                                                    </td>
            
                                     
                                            <tr>
            
                                                <td> Numéro du DAP
                                                    <input type="text" value="{{  $newNumero }}" name="numerodap" id="numerodap" style="width: 100%" class="form-control form-control-sm" required />
                                                    <smal id="numerodap_error" name="numerodap_error" class="text text-danger"> </smal>
                                                    <smal id="numerodap_info" class="text text-primary"> </smal>
                                                </td>
            
                                                <td colspan="2"> Lieu
                                                    <input type="text" name="lieu" id="lieu" style="width: 100%" class="form-control form-control-sm" required />
                                                </td>


                                                <td> Solde comptable dd(Sc):
                                                  <input type="text" min="0" class="form-control form-control-sm" name="soldecompte" value="{{ $somfeb }}" style="background-color:#c0c0c0" disabled>
                                              </td>

                                            </tr>
                                            <tr>

                                              <td> Banque :
                                                <select type="text" class="form-control form-control-sm" name="banque" id="banque">
                                                    <option disabled="true" selected="true" value="">-- Sélectionner --</option>
                                                    @foreach ($banque as $banques)
                                                        <option value="{{ $banques->libelle }}">{{ ucfirst($banques->libelle) }}</option>
                                                    @endforeach
                                                </select>
            
                                                </td>
            
                                                <td> Compte bancaire (BQ):
                                                    <input type="text" class="form-control form-control-sm" name="comptebanque" id="comptebanque" style="width: 100%" required>
                                                </td>
            
                                                
            
                                                <td> OV/Numéro cheque :
                                                    <input type="text" name="ch" id="ch" class="form-control form-control-sm">
                                                </td>
            
                                              
                                                <td> Etabli au nom de: 
                                                    <input type="text" name="paretablie" id="paretablie" class="form-control form-control-sm">
                                                </td>
            
                                              
            
            
                                            </tr>
            
                                        </table>

                                      
            <hr>
                                   
            
                                        <div id="Showpoll" class="Showpoll">
                                        
                                            <h6 style="margin-top:1% ;color:#c0c0c0">
                                                <center>
                                                    <font size="5px"><i class="fa fa-info-circle"></i> </font><br>
                                                    En attente ... <br> Veuillez Sélectionner le NUMERO FEB:
                                                </center>
                                            </h6>
                                        </div>
            
                                        <hr>
                                        



                                        <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
                                          <tr>
                                              <td colspan="5">
                                                  Ce montant est-il une avance ? &nbsp; &nbsp; &nbsp;
                                                  Oui <input type="checkbox" class="form-check-input" name="justifier" id="justifier" onchange="toggleVisibility()">
                                                  &nbsp; &nbsp; &nbsp;
                                                  Non <input type="checkbox" class="form-check-input" name="nonjustifier" id="nonjustifier" onchange="toggleVisibility()" checked>
                                              </td>
                                          </tr>
                                      </table>
                                  
                                      <table class="table table-striped table-sm fs--1 mb-0 table-bordered" id="facture-column" style="display: none; width: 100%;">
                                          <tr>
                                            
                                          </tr>
                                      </table>
                                  
                                      <div id="Showretour" style="display: none;">
                                          
                                      </div>
                                  
                                      <div id="Shownonretour" style="display: none;">
                                          
                                      </div>
                                  
            
            
            
                                        <br>
            
            
                                        <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
            
                                            <tr>
                                                <td colspan="3"><b> Vérification et Approbation de la Demande de paiement </b></td>
                                            </tr>
                                            <tr>
                                                <td> <b> Demande établie par </b> <br>
                                                    <small> Chef de Composante/Projet/Section </small>  
                                                </td>
            
                                                <td> <b> Vérifiée par :</b> <br>
                                                    <small> Chef Comptable</small>
                                                     
                                                </td>
            
                                                <td> <b> Approuvée par : </b> <br>
                                                    <small>Chef de Service</small>
                                                     
                                                </td>
            
            
                                            </tr>
                                            <tr>
            
                                                <td>
                                                    <select type="text" class="form-control form-control-sm" name="demandeetablie" id="demandeetablie" required>
                                                        <option disabled="true" selected="true" value="">-- Chef de Composante/Projet/Section --</option>
                                                        @foreach ($personnel as $personnels)
                                                        <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select type="text" class="form-control form-control-sm" name="verifier" id="verifier" required>
                                                        <option disabled="true" selected="true" value="">--Chef Comptable--</option>
                                                        @foreach ($personnel as $personnels)
                                                        <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
            
            
                                                <td>
                                                    <select type="text" class="form-control form-control-sm" name="approuver" id="approuver" required>
                                                        <option disabled="true" selected="true" value="">--Chef de Service --</option>
                                                        @foreach ($personnel as $personnels)
                                                        <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
            
                                      
            
                                            <tr>
                                                <td colspan="3"><b> Autorisaction de paiement</b></td>
            
                                            </tr>
            
                                            </tr>
            
                                            <tr>
                                               
                                                <td>
                                                    Responsable Administratif et Financier : <br>
                                                    <select type="text" class="form-control form-control-sm" name="resposablefinancier" id="resposablefinancier" required>
                                                        <option disabled="true" selected="true" value="">--Sélectionner un personnel--</option>
                                                        @foreach ($personnel as $personnels)
                                                        <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    Secrétaire Général de la CEPBU : <br>
                                                    <select type="text" class="form-control form-control-sm" name="secretairegenerale" id="secretairegenerale" required>
                                                        <option disabled="true" selected="true" value="">--Sélectionner un personnel--</option>
                                                        @foreach ($personnel as $personnels)
                                                        <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
            
            
                                                <td>
                                                    Chef des Programmes </br>
                                                    <select type="text" class="form-control form-control-sm" name="chefprogramme" id="chefprogramme" required>
                                                        <option disabled="true" selected="true" value="">--Sélectionner un personnel--</option>
                                                        @foreach ($personnel as $personnels)
                                                        <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
            
                                        </table>
            
                                    </div>
                                </div>




                            </div>
                        </div>
                    </div>

                    <div class="card-header p-4 border-bottom border-300 bg-soft">
                        <div class="row g-3 justify-content-between align-items-end">
                            <div class="col-12 col-md"></div>
                            <div class="col col-md-auto">
                              <button type="submit" class="btn btn-primary" id="adddapbtn" name="adddapbtn"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>



<script>
  function adjustTableHeight() {
    var windowHeight = window.innerHeight;
    var tableContainer = document.getElementById('table-container');

    // Ajustez la hauteur du conteneur du tableau en fonction de la hauteur de l'écran, moins une marge (par exemple, 200px)
    tableContainer.style.height = (windowHeight - 200) + 'px';
  }

  // Appelez la fonction lorsque la page est chargée
  window.onload = adjustTableHeight;

  // Appelez la fonction lorsque la fenêtre est redimensionnée
  window.onresize = adjustTableHeight;
</script>

<script>
  $(document).ready(function () {
    function verifierNumeroDAP() {
        var numerodap = $('#numerodap').val();

        // Vérification si le champ est vide
        if (numerodap.trim() === '') {
            $('#numerodap_error').text('Veuillez renseigner le champ numéro DAP.');
            $('#numerodap').removeClass('has-success has-error'); // Supprime toutes les classes de succès ou d'erreur
            $('#numerodap_info').text('');
            return; // Sortir de la fonction si le champ est vide
        }

        // Envoi de la requête AJAX au serveur
        $.ajax({
            url: '{{ route("check.dap") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // CSRF token pour Laravel
                numerodap: numerodap
            },
            success: function (response) {
                if (response.exists) {
                    $("#numerodap_error").html('<i class="fa fa-times-circle"></i> Numéro DAP existe déjà');
                    $('#numerodap').removeClass('has-success'); // Supprime la classe de succès
                    $('#numerodap').addClass('has-error');
                    $('#numerodap_info').text('');
                } else {
                    $("#numerodap_info").html('<i class="fa fa-check-circle"></i> Numéro Disponible');
                    $('#numerodap').removeClass('has-error'); // Supprime la classe d'erreur
                    $('#numerodap').addClass('has-success');
                    $('#numerodap_error').text('');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Vérification au chargement de la page
    verifierNumeroDAP();

    // Vérification lorsque le champ perd le focus
    $('#numerodap').blur(function () {
        verifierNumeroDAP();
    });
});

</script>


<script>
 
  window.onload = function () {
    toggleVisibility();
};

  
  function toggleVisibility() {
            // Récupérer les cases à cocher
            const yesCheckbox = document.getElementById('justifier');
            const noCheckbox = document.getElementById('nonjustifier');

            // Récupérer les éléments à afficher/masquer
            const factureTable = document.getElementById('facture-column');
            const showRetour = document.getElementById('Showretour');
            const showNonRetour = document.getElementById('Shownonretour');

            // Gérer les affichages selon le choix
            if (yesCheckbox.checked) {
                factureTable.style.display = 'table'; // Afficher la table
                showRetour.style.display = 'block'; // Afficher le contenu lié à "Oui"
                showNonRetour.style.display = 'none'; // Masquer le contenu lié à "Non"
                noCheckbox.checked = false; // Désactiver l'autre case
            } else if (noCheckbox.checked) {
                factureTable.style.display = 'none'; // Masquer la table
                showRetour.style.display = 'none'; // Masquer le contenu lié à "Oui"
                showNonRetour.style.display = 'block'; // Afficher le contenu lié à "Non"
                yesCheckbox.checked = false; // Désactiver l'autre case
            } else {
                // Par défaut, tout reste masqué
                factureTable.style.display = 'none';
                showRetour.style.display = 'none';
                showNonRetour.style.display = 'none';
            }
        }


  function toggleInputs() {
    var checkboxes = document.querySelectorAll('.seleckbox');
    var inputs = document.querySelectorAll('.dapref');
    for (var i = 0; i < inputs.length; i++) {
      inputs[i].readOnly = !checkboxes[0].checked;
    }
  }


  $(document).ready(function() {
    $(document).on('change', '.febid', function() {
      var febrefs = $(this).val(); // Utilisez val() pour obtenir toutes les valeurs sélectionnées
      var div = $(this).parent();
      var op = " ";
      $.ajax({
        type: 'get',
        url: "{{ route ('getfeb') }}",
        data: {
          'ids': febrefs // Utilisez 'ids' au lieu de 'id' pour envoyer toutes les valeurs sélectionnées
        },
        success: function(reponse) {
          $("#Showpoll").html(reponse);
        },
        error: function() {
          alert("Attention! \n Erreur de connexion à la base de données, \n veuillez vérifier votre connexion");
        }
      });
    });
  });


  $(document).ready(function() {
    $(document).on('change', '.febid', function() {
      var febrefs = $(this).val(); // Utilisez val() pour obtenir toutes les valeurs sélectionnées
      var div = $(this).parent();
      var op = " ";
      $.ajax({
        type: 'get',
        url: "{{ route ('getfebretour') }}",
        data: {
          'ids': febrefs // Utilisez 'ids' au lieu de 'id' pour envoyer toutes les valeurs sélectionnées
        },
        success: function(reponse) {
          $("#Showretour").html(reponse);
        },
        error: function() {
          alert("Attention! \n Erreur de connexion à la base de données, \n veuillez vérifier votre connexion");
        }
      });
    });
  });




  $(function() {

    $("#adddapForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#adddapbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("adddapbtn").disabled = true; // Désactiver le bouton
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
          $("#loadingModal").modal('hide'); // Cacher le popup de chargement

          if (response.status == 200) {
          
            toastr.success(
                          "DAP ajouté avec succès", // Message
                          "Succès !", // Titre
                          {
                              closeButton: true, // Ajoute un bouton de fermeture
                              progressBar: true, // Affiche une barre de progression
                              //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                              timeOut: 3000, // Durée d'affichage (en millisecondes)
                              extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                          }
                      );


           // window.location.href = "{{ route('listdap') }}";
             window.location.href = response.redirect;
          } else if (response.status == 201) {
            toastr.error("Attention: DAP fonction existe déjà !", "Info");
            $("#dapModale").modal('show');
          } else if (response.status == 202) {
            toastr.error("Erreur d'exécution, vérifiez votre connexion Internet", "Erreur");
            $("#dapModale").modal('show');
          } else if (response.status == 203) {
            toastr.error("Erreur d'exécution: " + response.error, "Erreur");
            $("#dapModale").modal('show');
          }

          $("#adddapbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
          document.getElementById("adddapbtn").disabled = false; // Réactiver le bouton
        },
        error: function(xhr, status, error) {
          $("#loadingModal").modal('hide'); // Cacher le popup de chargement
          toastr.error("Erreur d'exécution: " + error, "Erreur");
          $("#dapModale").modal('show');
          $("#adddapbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
          document.getElementById("adddapbtn").disabled = false; // Réactiver le bouton
        }
      });
    });


    // Delete feb ajax request


 


  });
</script>

<script>
  document.getElementById('beneficiaire').addEventListener('change', function () {
      const nomPrenomContainer = document.getElementById('nomPrenomContainer');
      if (this.value === 'autres') {
          nomPrenomContainer.style.display = 'block';  // Affiche le conteneur avec le texte et l'input
      } else {
          nomPrenomContainer.style.display = 'none';  // Cache le conteneur pour toutes les autres options
      }
  });
</script>


@endsection