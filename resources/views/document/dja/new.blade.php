@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-12" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> MOdification du DEMANDE ET JUSTIFICATION
                            D'AVANCE (DJA) N<sup>o</sup> : {{ $data->numerudja }} </h4>
                        <div class="page-title-right">
                            <div class="btn-toolbar float-end" role="toolbar">

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <form class="needs-validation" novalidate method="POST" id="EditdjdaForm">
                @method('post')
                @csrf

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-2">
                                                            <label class="form-label">Présumé
                                                                Bénéficiaire/Fournisseur/Prestataire à payer:</label>
                                                            @php
                                                                // Join the 'numerofeb' values with commas
                                                                $benefNom = $numerofeb
                                                                    ->pluck('beneficiaireNom')
                                                                    ->join(', ');
                                                            @endphp
                                                            <input type="text" value="{{ $benefNom }}"
                                                                class="form-control form-control-sm" readonly
                                                                style="background-color:#c0c0c0" />

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mb-2">
                                                            <label class="form-label">Adresse</label>
                                                            @php
                                                                $adresse_benef = collect($numerofeb)
                                                                    ->pluck('adresse')
                                                                    ->join(', ');
                                                            @endphp

                                                            <input type="text" value="{{ $adresse_benef }}"
                                                                class="form-control form-control-sm" rreadonly
                                                                style="background-color:#c0c0c0" />
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="mb-2">
                                                            <label class="form-label">Téléphone1:</label>
                                                            @php
                                                                // Join the 'numerofeb' values with commas
                                                                $benefPhone_un = $numerofeb
                                                                    ->pluck('telephoneone')
                                                                    ->join(', ');
                                                            @endphp
                                                            <input type="text" value="{{ $benefPhone_un }}"
                                                                class="form-control form-control-sm" readonly
                                                                style="background-color:#c0c0c0" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-2">
                                                            <label class="form-label">Téléphone2: </label>
                                                            @php
                                                                // Join the 'numerofeb' values with commas
                                                                $benefPhone_deux = $numerofeb
                                                                    ->pluck('telephonedeux')
                                                                    ->join(', ');
                                                            @endphp
                                                            <input type="text" value="{{ $benefPhone_deux }}"
                                                                class="form-control form-control-sm" readonly
                                                                style="background-color:#c0c0c0" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="mb-2">
                                                            <label>DESCRIPTION/MOTIF:</label>
                                                            @php
                                                                // Join the 'numerofeb' values with commas
                                                                $benefPhone_decription = $numerofeb
                                                                    ->pluck('description')
                                                                    ->join(', ');
                                                            @endphp
                                                            <div>
                                                                <textarea class="form-control" rows="2" readonly style="background-color:#c0c0c0">{{ $benefPhone_decription }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end card -->
                                    </div> <!-- end col -->

                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Les fonds devront être reçus
                                                                le</label>
                                                            <input name="fond_recu_le" type="date"
                                                                class="form-control form-control-sm"
                                                                value="{{ $data->fond_recu_le }}" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Référence (s) : FEB Nº</label>
                                                            @php
                                                                // Join the 'numerofeb' values with commas
                                                                $referenceFeb = $numerofeb
                                                                    ->pluck('numerofeb')
                                                                    ->join(', ');
                                                            @endphp
                                                            <input type="text" name="" value="{{ $referenceFeb }}"
                                                                class="form-control form-control-sm" readonly
                                                                style="background-color:#c0c0c0" />


                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">DAP Nº</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                value="{{ $data->nume_dap }}" readonly
                                                                style="background-color:#c0c0c0" />

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">OV/CHQ Nº</label>

                                                            <input name="ovcheque" type="text"
                                                                class="form-control form-control-sm"
                                                                value="{{ $data->cho }}" readonly
                                                                style="background-color:#c0c0c0" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Ligne budgétaire: </label>
                                                            @php
                                                                // Join the 'numerofeb' values with commas
                                                                $ligneB = $numerofeb
                                                                    ->pluck('libelle_compte')
                                                                    ->join(', ');
                                                            @endphp
                                                            <input name="ligne_budgetaire" type="text"
                                                                class="form-control form-control-sm"
                                                                value="{{ $ligneB }}" readonly
                                                                style="background-color:#c0c0c0" />

                                                        </div>
                                                    </div>


                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Montant de l'avance :</label>
                                                            <input name="montant_avance_un" type="number"
                                                                value="{{ $data->montant_avance_un }}"
                                                                class="form-control form-control-sm" />

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Dévise </label>
                                                            <input name="devise" type="text"
                                                                class="form-control form-control-sm"
                                                                value="{{ $devise }}" readonly
                                                                style="background-color:#c0c0c0" />

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Durée de l’avance:(Jours) </label>
                                                            <input name="dure_avance" type="number"
                                                                class="form-control form-control-sm"
                                                                value="{{ $data->duree_avance }}" />
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- end card -->
                                    </div> <!-- end col -->

                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Fonds demandes par : </label>
                                                            <select type="text" class="form-control form-control-sm"
                                                                name="fond_demander_par" id="acce" required>
                                                                <option
                                                                    value="{{ $data->fonds_demandes_userid }} ">
                                                                    {{ $data->fonds_demandes_nom }}
                                                                    {{ $data->fonds_demandes_prenom }}</option>
                                                                @foreach ($personnel as $personnels)
                                                                    <option value="{{ $personnels->userid }}">
                                                                        {{ $personnels->nom }} {{ $personnels->prenom }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-1">
                                                       
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Date</label>
                                                            <input type="date" name="date_fond_demande_par"
                                                                value="{{ $data->date_fonds_demande_par }}"
                                                                class="form-control form-control-sm" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <!-- Approval by the first person -->
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Avance Approuvée par (2 personnes au moins) :</label>
                                                            <select type="text" class="form-control form-control-sm" name="avance_approuver_par_un" id="acce" required>
                                                                <option value="{{ $data->avance_approuver_un_userid }}">
                                                                    {{ $data->avance_approuver_un_nom }} {{ $data->avance_approuver_un_prenom }}
                                                                </option>
                                                                @foreach ($personnel as $personnels)
                                                                    <option value="{{ $personnels->userid }}">
                                                                        {{ $personnels->nom }} {{ $personnels->prenom }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                
                                                  <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label class="form-label">Date</label>
                                                            <input name="date_signature_avance_approuver_un" 
                                                                   value="{{ $data->date_avance_approuver_par }}" 
                                                                   type="date" 
                                                                   class="form-control form-control-sm" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3"></div>
                                                
                                                    <!-- Approval by the second person -->
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Nom</label>
                                                            <select type="text" class="form-control form-control-sm" name="avance_approuver_par_deux" id="acce" required>
                                                                <option value="{{ $data->avance_approuver_par_deux }}">
                                                                    {{ $data->avance_approuver_par_deux_nom }} {{ $data->avance_approuver_par_deux_prenom }}
                                                                </option>
                                                                @foreach ($personnel as $personnels)
                                                                    <option value="{{ $personnels->userid }}">
                                                                        {{ $personnels->nom }} {{ $personnels->prenom }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                
                                                  <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label class="form-label">Date</label>
                                                            <input name="date_signature_avance_approuver_deux" 
                                                                   value="{{ $data->date_avance_approuver_par_deux }}" 
                                                                   type="date" 
                                                                   class="form-control form-control-sm" />
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <hr>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Fonds déboursés par: </label>
                                                            <select type="text" class="form-control form-control-sm" name="fond_debourse_par" required>
                                                                <option value="{{ $data->fond_debourser_par }}">

                                                                  {{ $data->fond_debourser_nom }} {{ $data->fond_debourser_prenom }}

                                                                </option>
                                                                @foreach ($personnel as $personnels)
                                                                    <option value="{{ $personnels->userid }}">
                                                                        {{ $personnels->nom }} {{ $personnels->prenom }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-1">
                                                        
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Date</label>
                                                            <input name="date_signe_fond_debourses"
                                                                type="date"
                                                                value="{{ $data->date_fond_debourser_par }}"
                                                                class="form-control form-control-sm" 
                                                                />

                                                        </div>
                                                    </div>
                                                </div>


            </form>
        </div>
    </div>
    <!-- end card -->
    </div> <!-- end col -->

    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">


                <div class="row">
                  


                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="form-label">Fonds demandes par : </label>
                            <select type="text" class="form-control form-control-sm"
                            name="fondPayea"  id="acce" required>
                                <option  value="{{ $data->pfond_paye }}">  {{ $data->pfond_paye_nom }} {{ $data->pfond_paye_prenom }}
                               </option>
                                @foreach ($personnel as $personnels)
                                    <option value="{{ $personnels->userid }}">
                                        {{ $personnels->nom }} {{ $personnels->prenom }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                  
                    <!-- DESCRIPTION/MOTIF Field -->
                    <div class="col-md-5">
                        <div class="mb-2">
                            <label>DESCRIPTION/MOTIF:</label>
                            <div>
                                <textarea name="fondPayeDescription" id="descriptionMotif" required class="form-control" rows="2">{{ $data->description_avance }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Plaque vehicule Field (Initially Hidden) -->
                    <div class="col-md-3" id="plaqueVehiculeDiv" style="display: none;">
                        <div class="mb-2">
                            <label class="form-label">Plaque vehicule utilisat</label>
                            <select type="text" class="form-control form-control-sm" name="plaque" id="acce" required>
                                <option value="{{ $data->plaque }}">{{ $data->plaque }}</option>
                                @foreach ($vehicule as $vehicules)
                                    <option value="{{ $vehicules->matricule }}">
                                        {{ $vehicules->matricule }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>

                    <div class="col-md-3">
                        <div class="mb-2">
                            <label class="form-label">Montant de l'Avance</label>
                            <input name="montantAvancedeux" value="{{ $data->montant_avance }}" type="text"
                                class="form-control form-control-sm" />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-2">
                            <label class="form-label">Montant utilisé*</label>
                            <input name="montantUtilise" value="{{ $data->montant_utiliser }}" type="text"
                                class="form-control form-control-sm" />

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-2">
                            <label class="form-label">Surplus/Manque*</label>
                            <input name="surplusManque" value="{{ $data->montant_surplus }}" type="text"
                                class="form-control form-control-sm" />

                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="mb-2">
                            <label class="form-label">Montant retourné
                                à la caisse ou au compte(Si Surplus)
                            </label>
                            <input name="montantRetourne" value="{{ $data->montant_retourne }}" type="text"
                                class="form-control form-control-sm" />

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-2">
                            <label class="form-label">Réception des fonds retournés à la caisse par: <br>Noms de la
                                Caissière :
                            </label>
                            <select type="text" class="form-control form-control-sm" name="fond_retourne"
                                id="acce" required>
                                <option disabled="true" selected="true"
                                    value="{{ $data->fonds_retournes_caisse_par }} ">
                                    {{ $data->fonds_retournes_caisse_nom }} {{ $data->fonds_retournes_caisse_prenom }}
                                </option>
                                @foreach ($personnel as $personnels)
                                    <option value="{{ $personnels->userid }}">{{ $personnels->nom }}
                                        {{ $personnels->prenom }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-2">
                            <label class="form-label">ou Borderau de versement <br>nº <br>
                            </label>
                            <input name="bordereauVersement" value="{{ $data->bordereau_versement }}" type="text"
                                class="form-control form-control-sm" />

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-2">
                            <label class="form-label">Du <br>nº <br>
                            </label>
                            <input name="du" type="date" value="{{ $data->du_num }}"
                                class="form-control form-control-sm" />

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label">Réception des pièces justificatives de l'utilisation de l'avance
                                par:
                            </label>
                            <select type="text" class="form-control form-control-sm" name="reception_pieces_par"
                                id="acce" required>
                                <option disabled="true" selected="true"
                                    value="{{ $data->reception_pieces_justificatives }} ">
                                    {{ $data->reception_pieces_nom }} {{ $data->reception_pieces_prenom }}</option>
                                @foreach ($personnel as $personnels)
                                    <option value="{{ $personnels->userid }}">{{ $personnels->nom }}
                                        {{ $personnels->prenom }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>

                <br><br>
                <button id="edjitustifierbtn" name="editjustifierbtn" class="btn btn-primary editjustifierbtn"
                    type="submit"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                <br><br>

                </form>
            </div>
        </div>
        <!-- end card -->
    </div> <!-- end col -->

    </div>
    </div>
    </div>
    <!-- end card -->
    </div> <!-- end col -->
    </div>
    </form>
    </div>
    </div>

    <script>
        // Function to check and toggle visibility of 'Plaque vehicule'
        function togglePlaqueVehicule() {
            const description = document.getElementById('descriptionMotif').value.toLowerCase();
            const plaqueVehiculeDiv = document.getElementById('plaqueVehiculeDiv');
    
            // Show 'Plaque vehicule' div if 'carburant' is found, hide otherwise
            plaqueVehiculeDiv.style.display = description.includes('carburant') ? 'block' : 'none';
        }
    
        // Run the function on input
        document.getElementById('descriptionMotif').addEventListener('input', togglePlaqueVehicule);
    
        // Run the function when the page loads
        window.addEventListener('load', togglePlaqueVehicule);
    </script>
    

    <script>
       


        $(function() {

            // Edit  ajax 
    $("#EditdjdaForm").submit(function(e) {
    e.preventDefault();
    const fd = new FormData(this);

    $("#edjitustifierbtn").html('<i class="fas fa-spinner fa-spin"></i> En cours...');
    $("#edjitustifierbtn").prop('disabled', true); // Désactiver le bouton de soumission

    $.ajax({
        url: "{{ route('updatejustification', $data->iddjas) }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            $("#edjitustifierbtn").html('<i class="fa fa-cloud-upload-alt"></i>  Sauvegarder'); // Réinitialise le texte du bouton

            if (response.status === 200) {
                toastr.success("Mise à jour DJA avec succès !", "Succès");
            } else if (response.status === 201) {
                toastr.warning("Attention : DJA existe déjà !", "Info");
            } else if (response.status === 202) {
                toastr.error("Erreur d'exécution, vérifiez votre connexion internet", "Erreur");
            } else if (response.status === 203) {
                toastr.error("Erreur d'exécution : " + response.error, "Erreur");
            } else {
                toastr.error("Une erreur inattendue s'est produite.", "Erreur");
            }
        },
        error: function(xhr, status, error) {
            toastr.error("Une erreur s'est produite : " + xhr.responseText, "Erreur");
        },
        complete: function() {
            $("#edjitustifierbtn").html('Sauvegarder'); // Réinitialiser le texte du bouton
            $("#edjitustifierbtn").prop('disabled', false); // Réactiver le bouton de soumission
        }
    });
});




        });
    </script>
@endsection
