@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-10" style="margin:auto">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Le details de la decaissement (N°
                                {{ $dataPetiteCaisse->numero }} ) </h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-11" style="margin:auto">
                    <div class="card">



                        <form class="row g-3 mb-6" method="POST" id="editbpcform">
                            @method('post')
                            @csrf

                            <input value="{{ $dataPetiteCaisse->bpid }}" type="hidden" name="idbp" id="idbp">


                            <div id="tableExample2">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm fs--1 mb-0">
                                        <tbody class="list">
                                            <tr>
                                                <td class="align-middle ps-3 name" colspan="5">
                                                    Composante/ Projet/Section <br>
                                                    <input value="{{ Session::get('id') }}" type="hidden" name="projetid"
                                                        id="projetid">
                                                    <input value="{{ Session::get('title') }}"
                                                        class="form-control form-control-sm" disabled>
                                                </td>
                                            </tr>

                                            </tr>
                                            <tr>
                                                <td class="align-middle ps-3 name" colspan="3">Je soussigné (nom complet)
                                                    <br>
                                                    <input type="text" class="form-control form-control-sm"
                                                        name="nom_sousigne" id="nom_sousigne"
                                                        value="{{ $dataPetiteCaisse->nom_sousigne }}" required>
                                                </td>


                                                <td class="align-middle ps-3 name"  colspan="2">


                                                
                                                    <label class="text-1000 fw-bold mb-2">Compte d'approvisionnement :</label>
                                                    <select class="form-control  form-control-sm" id="compteid" name="compteid" required>
                                                      <option  value="{{ $dataPetiteCaisse->idcaisse }}">  {{ $dataPetiteCaisse->libel }} </option>
                                                      @forelse ($compte_bpc as $compte_bpc)
                                                                              <option value="{{ $compte_bpc->id }}"> {{ $compte_bpc->code }} : {{ $compte_bpc->libelle }} </option>
                                                                          @empty
                                                                              
                                                                              <option disabled="true" selected="true" value="">Pas de compte disponible pour ce projet</option>
                                                                        
                                                                          @endforelse
                                      
                                                    </select>
                                                 

                                                </td>
                                      





                                            </tr>

                                            <tr id="enleveceselement">
                                                <td class="align-middle ps-3 name">
                                                    Titre (+ nom de l'organisation si differente de la CEPBU)<br>
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="{{ $dataPetiteCaisse->titre }}" name="titre"
                                                        id="titre">
                                                </td>
                                                <td class="align-middle ps-3 name">
                                                    Type de carte d'identité <br>
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="{{ $dataPetiteCaisse->type_identite }}" name="type_identite"
                                                        id="type_identite">
                                                </td>
                                                <td>
                                                    Numéro de la piece d'identite <br>
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="{{ $dataPetiteCaisse->numero_piece }}" name="numero_piece"
                                                        id="numero_piece">
                                                </td>
                                                <td>
                                                    Adresse <br>
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="{{ $dataPetiteCaisse->adresse }}"name="adresse"
                                                        id="adresse">
                                                </td>
                                                <td>
                                                    Téléphone/Email<br>
                                                    <input type="text" class="form-control form-control-sm"
                                                        value="{{ $dataPetiteCaisse->telephone_email }}"
                                                        name="telephone_email" id="telephone_email">
                                                </td>
                                            </tr>



                                            <tr>
                                                <td class="align-middle ps-3 name">
                                                    Numéro du fiche BPC <br>
                                                    <input type="number" name="numero" id="numero"
                                                        class="form-control form-control-sm"
                                                        value="{{ $dataPetiteCaisse->numero }}" style="width: 100%;">

                                                </td>

                                                <td class="align-middle ps-3 name">Date du dossier BPC<br>
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="date" id="date" style="width: 100%;"
                                                        value="{{ $dataPetiteCaisse->date }}" required>
                                                </td>

                                                <td colspan="4"></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <hr>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-sm fs--1 mb-0" id="tableEstimate">
                                            <thead style="background-color:#3CB371; color:white">
                                                <tr>
                                                    <th style="width:80px; color:white"><b>Num</b></th>
                                                    <th style="color:white"><b>Designation de la ligne</b></th>
                                                    <th style="color:white"><b>Montant</b></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($element_petite_caisse as $element_petite_caisses)
                                                    <tr id="R1">
                                                      

                                                                <td hidden><input style="width:100%" type="hidden" id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="1"></td>


                                                        <td style="width:40%">


                                                            <select class="form-control  form-control-sm select2-search-disable" id="referenceid" name="referenceid[]" >
                                                                <option value="{{ $element_petite_caisses->idcp }}-{{ $element_petite_caisses->comptei }}-{{ $element_petite_caisses->numer }}">{{ $element_petite_caisses->numer }}. {{ $element_petite_caisses->libele }} </option>
                                                                @foreach ($compte as $comptes)
                                                                <optgroup label="{{ $comptes->libelle }}">
                                                                  @php
                                                                  $idc = $comptes->id ;
                                                                  $res= DB::select("SELECT * FROM comptes WHERE compteid= $idc");
                                                                  @endphp
                                                                  @foreach($res as $re)
                                                                  <option value="{{ $comptes->id }}-{{ $re->id }}-{{ $re->numero }}">{{ $re->numero }}. {{ $re->libelle }} </option>
                                                                  @endforeach
                                        
                                                                </optgroup>
                                                                @endforeach
                                        
                                                              </select>
                                                        </td>

                                                        <td style="width:40%"><input style="width:100%" type="text"
                                                                id="motifs[]" name="motifs[]"
                                                                value="{{ $element_petite_caisses->motifs }}"
                                                                class="form-control form-control-sm total" min="0"
                                                                required></td>


                                                        <td style="width:15%"><input style="width:100%" type="number"
                                                                id="montant[]" name="montant[]"
                                                                value="{{ $element_petite_caisses->montant }}"
                                                                class="form-control form-control-sm total" min="0"
                                                                required></td>


                                                        <td><a href="javascript:void(0)" class="text-primary font-18"
                                                                title="Ajouter" id="addBtn"><i
                                                                    class="fa fa-plus-circle"></i></a></td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>

                                        <table class="table table-striped table-sm fs--1 mb-0">
                                            <tfoot style="background-color:#c0c0c0">
                                                <tr>
                                                    <td colspan="8">Total global </td>
                                                    <td align="right">
                                                        <input type="hidden" id="totalInput" name="total_global"
                                                            class="form-control" readonly>
                                                        <p class="total-global"></p>

                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                        <hr>

                                    </div>

                                    <div class="table-responsive">
                                        <span id="error"></span>

                                        <table class="table table-striped table-sm fs--1 mb-0">
                                            <tr>
                                                <td>Bénéficiaire</td>
                                                <td>Distributeur</td>
                                                <td>Approbation</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select type="text" class="form-control form-control-sm"
                                                        name="acce" id="acce" required>
                                                        <option value="{{ $etablienom->userid }}">{{ $etablienom->nom }}
                                                            {{ $etablienom->prenom }}</option>
                                                        @foreach ($personnel as $personnels)
                                                            <option value="{{ $personnels->userid }}">
                                                                {{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select type="text" class="form-control form-control-sm"
                                                        name="comptable" id="comptable" required>
                                                        <option value="{{ $verifie_par->userid }}">
                                                            {{ $verifie_par->nom }} {{ $verifie_par->prenom }}</option>

                                                        @foreach ($personnel as $personnels)
                                                            <option value="{{ $personnels->userid }}">
                                                                {{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select type="text" class="form-control form-control-sm"
                                                        name="chefcomposante" id="chefcomposante" required>
                                                        <option value="{{ $approuver_par->userid }}">
                                                            {{ $approuver_par->nom }} {{ $approuver_par->prenom }}
                                                        </option>

                                                        @foreach ($personnel as $personnels)
                                                            <option value="{{ $personnels->userid }}">
                                                                {{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer" style="padding:20px">
                                <button type="submit" class="btn btn-primary" id="editcomptebtn"
                                    name="editcomptebtn"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Sélectionner les éléments
            const interneOui = document.getElementById('interneOui');
            const interneNon = document.getElementById('interneNon');
            const trElement = document.getElementById('enleveceselement');

            // Fonction pour afficher/masquer les éléments
            const toggleElements = () => {
                if (interneNon.checked) {
                    trElement.style.display = 'none';
                    interneOui.checked = false;
                } else {
                    trElement.style.display = '';
                    interneNon.checked = false;
                }
            };

            // Ajouter des écouteurs d'événements aux cases à cocher
            interneOui.addEventListener('change', () => {
                if (interneOui.checked) {
                    interneNon.checked = false;
                    trElement.style.display = '';
                } else {
                    interneNon.checked = true;
                    trElement.style.display = 'none';
                }
            });

            interneNon.addEventListener('change', () => {
                if (interneNon.checked) {
                    interneOui.checked = false;
                    trElement.style.display = 'none';
                } else {
                    interneOui.checked = true;
                    trElement.style.display = '';
                }
            });

            // Initialiser l'état des éléments
            toggleElements();
        });
    </script>

    <script>
        var rowIdx = 2;

        $("#addBtn").on("click", function() {
            $("#tableEstimate tbody").append(`
          <tr id="R${rowIdx}">
              <td hidden><input style="width:100%" type="hidden" id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="${rowIdx}"></td>
              <td style="width:40%">
                  <select class="form-control form-control-sm select2-search-disable" id="referenceid${rowIdx}" name="referenceid[]" required>
                      <option value="">Ligne budgétaire</option>
                      @foreach ($compte as $comptes)
                      <optgroup label="{{ $comptes->libelle }}">
                      @php
                          $idc = $comptes->id;
                          $res = DB::select("SELECT * FROM comptes WHERE compteid= $idc");
                      @endphp
                      @foreach ($res as $re)
                      <option value="{{ $comptes->id }}-{{ $re->id }}-{{ $re->numero }}">{{ $re->numero }}. {{ $re->libelle }}</option>
                      @endforeach
                      </optgroup>
                      @endforeach
                  </select>
              </td>
              <td style="width:20%"><input style="width:100%" type="text" id="motif[]" name="motif[]" class="form-control form-control-sm" required></td>
              <td><input style="width:100%" type="number" id="montant[]" name="montant[]" class="form-control form-control-sm total" required></td>
              <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Enlever"><i class="far fa-trash-alt"></i></a></td>
          </tr>
      `);

            rowIdx++;
            calculateTotal(); // Recalculer le total après ajout d'une ligne
        });

        $("#tableEstimate tbody").on("click", ".remove", function() {
            $(this).closest("tr").remove();
            rowIdx--;

            // Recalculate row numbers after deletion
            $("#tableEstimate tbody tr").each(function(index, element) {
                $(element).find('input[id="numerodetail"]').val(index + 1);
            });

            calculateTotal(); // Recalculer le total après suppression d'une ligne
        });

        function calculateTotal() {
            var total = 0;
            $('input[name="montant[]"]').each(function() {
                total += parseFloat($(this).val()) || 0;
            });

            // Formater le total avec des espaces pour les milliers
            var formattedTotal = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");

            // Afficher le total dans l'input et dans le texte
            $('#totalInput').val(total); // Le champ input pour envoyer au contrôleur
            $('.total-global').text(formattedTotal + ' {{ Session::get('devise') }}');
        }

        $(document).on('input', 'input[name="montant[]"]', calculateTotal);

        $(document).ready(function() {
            calculateTotal(); // Calcul initial du total
        });
    </script>

    <script>
        // Update function ajax request
        $("#editbpcform").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#editcomptebtn").text('Modification...'); // Changer le texte du bouton pendant le chargement

            $("#editcomptebtn").html('<i class="fas fa-spinner fa-spin"></i>');
           document.getElementById("editcomptebtn").disabled = true;


            $.ajax({
                url: "{{ route('updatebonpet') }}", // Route pour la mise à jour
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                       
                        toastr.success(
                          "Bon de petite caisse modifié avec succès", // Message
                          "Succès !", // Titre
                          {
                              closeButton: true, // Ajoute un bouton de fermeture
                              progressBar: true, // Affiche une barre de progression
                              //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                              timeOut: 3000, // Durée d'affichage (en millisecondes)
                              extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                          }
                      );
                      
                        $("#editcomptebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        document.getElementById("editcomptebtn").disabled = false;
                        $("#editbpcform")[0].reset();
                    

                    } else if (response.status == 203) {
                        toastr.error("Bon de petite caisse non trouvé.", "Erreur");
                        $("#editcomptebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        document.getElementById("editcomptebtn").disabled = false;
                    } else {
                        toastr.error("Une erreur inattendue s'est produite." + response.error,
                        "Erreur");
                        $("#editcomptebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        document.getElementById("editcomptebtn").disabled =false;
                    }
                    $("#editcomptebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                    document.getElementById("editcomptebtn").disabled = false;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    let errorMessage;
                    if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                        errorMessage = jqXHR.responseJSON.error;
                    } else if (jqXHR.responseText) {
                        errorMessage = jqXHR.responseText;
                    } else if (textStatus) {
                        errorMessage = textStatus;
                    } else if (errorThrown) {
                        errorMessage = errorThrown;
                    } else {
                        errorMessage = "Erreur inconnue";
                    }
                    toastr.error("Erreur lors de la requête : " + errorMessage, "Erreur");
                    $("#editcomptebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                }
            });
        });
    </script>
@endsection
