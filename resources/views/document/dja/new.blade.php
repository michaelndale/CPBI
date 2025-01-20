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

                           
                                    <div class="btn-group me-2 mb-2 mb-sm-0">
                                       

                                        <a href="{{ route('generate-pdf-dja', $data->iddjas) }}"
                                            class="btn btn-warning waves-light waves-effect" title="Imprimer le document DJA"><i
                                                class="fa fa-print"></i> </a>


                                        <a href="{{ route('voirDja', $data->iddjas) }}"
                                            class="btn btn-primary waves-light waves-effect" title="Voir le DJA"><i class="fa fa-eye"></i></a>

                                        <a href="{{ route('nouveau', $data->iddjas) }}"
                                                class="btn btn-primary waves-light waves-effect" title="Demande / Approbation"><i
                                                    class="fa fa-edit"></i> </a>
        

                                        <a href="{{ route('nouveau.utilisation', $data->iddjas) }}"
                                            class="btn btn-primary waves-light waves-effect" title="Utilisation de l'avance"><i
                                                class="fas fa-edit"></i> </a>

                                      
                                        <a href="{{ route('listdja') }}" class="btn btn-primary waves-light waves-effect"
                                            title="Liste de DJA"><i class="fa fa-list"></i></a>
                                    </div>
                               


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
                                    <div class="col-md-12">
                                        <h5><i class="fa fa-info-circle"></i> Demande d'une avance</h5>
                                        <hr>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-2">
                                                            <label class="form-label">Présumé
                                                                Bénéficiaire / Fournisseur / Prestataire à payer:</label>
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
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Adresse</label>
                                                            @php
                                                                $adresse_benef = collect($numerofeb)
                                                                    ->pluck('adresse')
                                                                    ->join(', ');
                                                            @endphp

                                                            <input type="text"  value="{{ $adresse_benef }}"
                                                                class="form-control form-control-sm" readonly
                                                                style="background-color:#c0c0c0" />
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4">
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
                                                    <div class="col-md-4">
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

                                                            <div>
                                                                <textarea class="form-control" name="djaDescription" rows="2">{{ $data->description_avance }}</textarea>
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
                                                    <div class="col-md-6">
                                                        <div class="mb-2">
                                                            <label class="form-label">Les fonds devront être reçus
                                                                le</label>
                                                            <input name="fond_recu_le" type="date"
                                                                class="form-control form-control-sm"
                                                                value="{{ $data->fond_recu_le }}" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Référence(s):FEB Nº</label>
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

                                                    <div class="col-md-3">
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


                                                    <div class="col-md-5">
                                                        <div class="mb-2">
                                                            <label class="form-label">Montant de l'avance :</label>
                                                            <input name="montant_avance_un" type="number"
                                                                value="{{ $data->montant_avance_un }}"
                                                                class="form-control form-control-sm" />

                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Dévise </label>
                                                            <input name="devise" type="text"
                                                                class="form-control form-control-sm"
                                                                value="{{ $devise }}" readonly
                                                                style="background-color:#c0c0c0" />

                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
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
                                                    <div class="col-md-12">
                                                        <h5><i class="fa fa-info-circle"></i> Approbation</h5>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Fonds demandés par : </label>
                                                            <select type="text" class="form-control form-control-sm"
                                                                name="fond_demander_par" required>
                                                                <option value="{{ $data->fonds_demandes_userid }} ">
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
                                                            <label class="form-label">Avance Approuvée par (2 personnes au
                                                                moins) :</label> <br> <br>
                                                            <label> Nom (Chef Comptable (Si A < 500 000 Fbu)) </label>
                                                                    <select type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="avance_approuver_par_un" id="acce"
                                                                        required>
                                                                        <option
                                                                            value="{{ $data->avance_approuver_un_userid }}">
                                                                            {{ $data->avance_approuver_un_nom }}
                                                                            {{ $data->avance_approuver_un_prenom }}
                                                                        </option>
                                                                        @foreach ($personnel as $personnels)
                                                                            <option value="{{ $personnels->userid }}">
                                                                                {{ $personnels->nom }}
                                                                                {{ $personnels->prenom }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1"></div>

                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <br><br>
                                                            <label class="form-label">Date</label>
                                                            <label><br></label>
                                                            <input name="date_signature_avance_approuver_un"
                                                                value="{{ $data->date_avance_approuver_par }}"
                                                                type="date" class="form-control form-control-sm" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3"></div>

                                                    <!-- Approval by the second person -->
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <br>
                                                            <label class="form-label">Nom</label>
                                                            <label> RAF(Si A < 2000 000 Fbu) </label>
                                                                    <select type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="avance_approuver_par_deux" id="acce"
                                                                        required>
                                                                        <option
                                                                            value="{{ $data->avance_approuver_par_deux }}">
                                                                            {{ $data->avance_approuver_par_deux_nom }}
                                                                            {{ $data->avance_approuver_par_deux_prenom }}
                                                                        </option>
                                                                        @foreach ($personnel as $personnels)
                                                                            <option value="{{ $personnels->userid }}">
                                                                                {{ $personnels->nom }}
                                                                                {{ $personnels->prenom }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <br>
                                                            <label class="form-label">Date</label>

                                                            <input name="date_signature_avance_approuver_deux"
                                                                value="{{ $data->date_avance_approuver_par_deux }}"
                                                                type="date" class="form-control form-control-sm" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3"></div>



                                                    <!-- Approval by the second person -->
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <br>
                                                            <label class="form-label">Nom</label>
                                                            <label> SG ou SGA (Si A > 2000 000 Fbu) </label>
                                                                    <select type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="avance_approuver_par_trois" id="acce"
                                                                        required>
                                                                        <option
                                                                            value="{{ $data->avance_approuver_par_trois }}">
                                                                            {{ $data->avance_approuver_par_trois_nom }}
                                                                            {{ $data->avance_approuver_par_trois_prenom }}
                                                                        </option>
                                                                        @foreach ($personnel as $personnels)
                                                                            <option value="{{ $personnels->userid }}">
                                                                                {{ $personnels->nom }}
                                                                                {{ $personnels->prenom }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <br>
                                                            <label class="form-label">Date </label>

                                                            <input name="date_avance_approuver_par_trois"
                                                                value="{{ $data->date_avance_approuver_par_trois }}"
                                                                type="date" class="form-control form-control-sm" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>



                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Fonds déboursés par: </label>
                                                            <select type="text" class="form-control form-control-sm" name="fond_debourse_par" id="fondDebourseParSelect" required>
                                                                <option value="{{ $data->fond_debourser_par }}">
                                                                    {{ $data->fond_debourser_par == 0 ? 'autres' : $data->fond_debourser_nom . ' ' . $data->fond_debourser_prenom }}
                                                                </option>
                                                                @foreach ($personnel as $personnels)
                                                                    <option value="{{ $personnels->userid }}">
                                                                        {{ $personnels->nom }} {{ $personnels->prenom }}
                                                                    </option>
                                                                @endforeach
                                                                <option value="autres" {{ $data->fond_debourser_par == 0 ? 'selected' : '' }}>autres</option>
                                                            </select>
                                                        </div>
                                                        <!-- Single input field for full name, displayed only if "autres" is selected or if fond_debourser_par is 0 -->
                                                        <div id="autresDebourseField" style="display: {{ $data->fond_debourser_par == 0 ? 'block' : 'none' }};">
                                                            <div class="mb-2">
                                                                <label class="form-label">Nom et Prénom:</label>
                                                                <input type="text" class="form-control form-control-sm" name="autres_nom_prenom_debourse" 
                                                                       placeholder="Entrez nom et prénom" 
                                                                       value="{{ $data->fond_debourser_par == 0 ? $data->autres_nom_prenom_debourse : '' }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1">

                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Date</label>
                                                            <input name="date_signe_fond_debourses" type="date"
                                                                value="{{ $data->date_fond_debourser_par }}"
                                                                class="form-control form-control-sm" />

                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Fonds reçus par: </label>
                                                            <select type="text" class="form-control form-control-sm" name="fond_recu_par" id="fondRecuParSelect" required>
                                                                <!-- Option par défaut basé sur la valeur de la base de données -->
                                                                <option value="{{ $data->fond_recu_par }}">
                                                                    {{ $data->fond_recu_par == 0 ? 'autres' : $data->fond_recu_nom . ' ' . $data->fond_recu_prenom }}
                                                                </option>
                                                                <!-- Boucle pour afficher les options de personnel -->
                                                                @foreach ($personnel as $personnels)
                                                                    <option value="{{ $personnels->userid }}">
                                                                        {{ $personnels->nom }} {{ $personnels->prenom }}
                                                                    </option>
                                                                @endforeach
                                                                <!-- Option "autres" avec sélection conditionnelle si la valeur est 0 -->
                                                                <option value="autres" {{ $data->fond_recu_par == 0 ? 'selected' : '' }}>autres</option>
                                                            </select>
                                                        </div>
                                                        <!-- Champ unique pour le nom complet, affiché seulement si "autres" est sélectionné ou si fond_recu_par est 0 -->
                                                        <div id="autresField" style="display: {{ $data->fond_recu_par == 0 ? 'block' : 'none' }};">
                                                            <div class="mb-2">
                                                                <label class="form-label">Nom et Prénom:</label>
                                                                <input type="text" class="form-control form-control-sm" name="autres_nom_prenom_fonds_recu" 
                                                                       placeholder="Entrez nom et prénom" 
                                                                       value="{{ $data->fond_recu_par == 0 ? $data->autres_nom_prenom_fond_recu : '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                  

                                                    <div class="col-md-1">

                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Date</label>
                                                            <input name="date_fond_recu" type="date"
                                                                value="{{ $data->date_fond_recu_par }}"
                                                                class="form-control form-control-sm" />

                                                        </div>
                                                    </div>
                                                </div>


            </form>


            <br>
            <button id="edjitustifierbtn" name="editjustifierbtn" class="btn btn-primary editjustifierbtn"
                type="submit"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder la modification de Demande d'une avance</button>
            <br><br>

            <br><a href="{{ route('nouveau.utilisation', $data->iddjas) }}" class="btn btn-info editjustifierbtn"> <i class="fa fa-edit"></i>  Aller sur le rapport d'utilisation de l'avance du dja encours</a> 

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
        // JavaScript to toggle visibility of the additional field based on selection
        document.getElementById('fondDebourseParSelect').addEventListener('change', function() {
            var autresDebourseField = document.getElementById('autresDebourseField');
            autresDebourseField.style.display = this.value === 'autres' ? 'block' : 'none';
        });
    </script>
    

    <script>
        // JavaScript pour afficher/masquer le champ supplémentaire en fonction de la sélection
        document.getElementById('fondRecuParSelect').addEventListener('change', function() {
            var autresField = document.getElementById('autresField');
            autresField.style.display = this.value === 'autres' ? 'block' : 'none';
        });
    </script>

   

    <script>
        $(function() {

            // Edit  ajax 
            $("#EditdjdaForm").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);

                $("#edjitustifierbtn").html('<i class="fas fa-spinner fa-spin"></i> Modification en cours...');
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
                        $("#edjitustifierbtn").html(
                            '<i class="fa fa-cloud-upload-alt"></i>  Sauvegarder la modification de Demande d\'une avance'
                            ); // Réinitialise le texte du bouton

                        if (response.status === 200) {
                            toastr.success("Mise à jour DJA avec succès !", "Succès");
                        } else if (response.status === 201) {
                            toastr.warning("Attention : DJA existe déjà !", "Info");
                        } else if (response.status === 202) {
                            toastr.error(
                                "Erreur d'exécution, vérifiez votre connexion internet",
                                "Erreur");
                        } else if (response.status === 203) {
                            toastr.error("Erreur d'exécution : " + response.error, "Erreur");
                        } else {
                            toastr.error("Une erreur inattendue s'est produite.", "Erreur");
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error("Une erreur s'est produite : " + xhr.responseText,
                            "Erreur");
                    },
                    complete: function() {
                        $("#edjitustifierbtn").html(
                        'Sauvegarder la modification de Demande d\'une avance'); // Réinitialiser le texte du bouton
                        $("#edjitustifierbtn").prop('disabled',
                        false); // Réactiver le bouton de soumission
                    }
                });
            });

        });
    </script>
@endsection
