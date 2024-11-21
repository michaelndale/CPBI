@extends('layout/app')
@section('page-content')
<div class="main-content">
    <div class="page-content">
        <div class="col-12" style="margin:auto">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Modification du DEMANDE ET JUSTIFICATION D'AVANCE (DJA)</h4>
                <div class="page-title-right">
                    <div class="btn-toolbar float-end" role="toolbar">

                   
                            <div class="btn-group me-2 mb-2 mb-sm-0">
                               

                                <a href="{{ route('generate-pdf-dja', $data->iddjas) }}"
                                    class="btn btn-warning waves-light waves-effect" title="Imprimer le document DJA"><i
                                        class="fa fa-print"></i> </a>


                                <a href="{{ route('voir', $data->iddjas) }}"
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

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
    
                                    <h4 class="card-title">DEMANDE ET JUSTIFICATION D'AVANCE (DJA)</h4>
                                    <p class="card-title-desc">Modification du rapport de d'utilisation de avence.</p>
    
                                    <div id="accordion" class="custom-accordion">
                                        <div class="card mb-1 shadow-none">
                                            <a href="#collapseOne" class="text-dark" data-bs-toggle="collapse"
                                                            aria-expanded="false"
                                                            aria-controls="collapseOne">
                                                <div class="card-header" id="headingOne">
                                                    <h6 class="m-0">
                                                        <i class="fa fa-info-circle"></i> Demande d'une avance #1
                                                        <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                    </h6>
                                                </div>
                                            </a>
    
                                            <div id="collapseOne" class="collapse"
                                                    aria-labelledby="headingOne" data-bs-parent="#accordion">
                                                <div class="card-body">
                                                   <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <table class="table table-striped table-sm fs--1 mb-0">
                                                                    <tr>
                                                                        <th>Présumé Bénéficiaire / Fournisseur / Prestataire à payer:</th>
                                                                        <td>{{ $numerofeb->pluck('beneficiaireNom')->join(', ') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Adresse</th>
                                                                        <td>{{ $numerofeb->pluck('adresse')->join(', ') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Téléphone 1</th>
                                                                        <td>{{ $numerofeb->pluck('telephoneone')->join(', ') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Téléphone 2</th>
                                                                        <td>{{ $numerofeb->pluck('telephonedeux')->join(', ') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Description/Motif</th>
                                                                        <td>{{ $data->description_avance }}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                            
                                                    <div class="col-xl-6">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <table class="table table-striped table-sm fs--1 mb-0">
                                                                    <tr>
                                                                        <th>Les fonds devront être reçus le</th>
                                                                        <td>{{ !empty($data->fond_recu_le) ? \Carbon\Carbon::parse($data->fond_recu_le)->format('d-m-Y') : '' }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Référence(s): FEB Nº</th>
                                                                        <td>{{ $numerofeb->pluck('numerofeb')->join(', ') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>DAP Nº</th>
                                                                        <td>{{ $data->nume_dap }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>OV/CHQ Nº</th>
                                                                        <td>{{ $data->cho }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Ligne budgétaire</th>
                                                                        <td>{{ $numerofeb->pluck('libelle_compte')->join(', ') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Montant de l'avance</th>
                                                                        <td> {{ number_format($data->montant_avance_un, 0, ',', ' ') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Devise</th>
                                                                        <td>{{ $devise }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Durée de l’avance (Jours)</th>
                                                                        <td>{{ $data->duree_avance }}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                   </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-1 shadow-none">
                                            <a href="#collapseTwo" class="text-dark collapsed" data-bs-toggle="collapse"
                                                            aria-expanded="false"
                                                            aria-controls="collapseTwo">
                                                <div class="card-header" id="headingTwo">
                                                    <h6 class="m-0">
                                                        <i class="fa fa-info-circle"></i> Demande/Approbation #2
                                                        <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                    </h6>
                                                </div>
                                            </a>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                                    data-bs-parent="#accordion">
                                                <div class="card-body">
                                                    <table class="table table-striped table-sm fs--1 mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Information</th>
                                                                <th>Nom</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Fonds demandés par -->
                                                            <tr>
                                                                <td>Fonds demandés par</td>
                                                                <td>{{ $data->fonds_demandes_nom }} {{ $data->fonds_demandes_prenom }}</td>
                                                                <td>{{ !empty($data->date_fonds_demande_par) ? \Carbon\Carbon::parse($data->date_fonds_demande_par)->format('d-m-Y') : '' }}
                                                                </td>
                                                            </tr>
                                        
                                                            <!-- Approbation par la première personne -->
                                                            <tr>
                                                                <td>Avance approuvée par (Chef Comptable, si A < 500 000 Fbu)</td>
                                                                <td>{{ $data->avance_approuver_un_nom }} {{ $data->avance_approuver_un_prenom }}</td>
                                                                <td>{{ !empty($data->date_avance_approuver_par) ? \Carbon\Carbon::parse($data->date_avance_approuver_par)->format('d-m-Y') : '' }}
                                                                </td>
                                                            </tr>
                                        
                                                            <!-- Approbation par la deuxième personne -->
                                                            <tr>
                                                                <td>Avance approuvée par (RAF, si A < 2 000 000 Fbu)</td>
                                                                <td>{{ $data->avance_approuver_par_deux_nom }} {{ $data->avance_approuver_par_deux_prenom }}</td>
                                                                <td>
                                                                    {{ !empty($data->date_avance_approuver_par_deux) ? \Carbon\Carbon::parse($data->date_avance_approuver_par_deux)->format('d-m-Y') : '' }}
                                                                </td>
                                                            </tr>
                                        
                                                            <!-- Approbation par la troisième personne -->
                                                            <tr>
                                                                <td>Avance approuvée par (SG ou SGA, si A > 2 000 000 Fbu)</td>
                                                                <td>{{ $data->avance_approuver_par_trois_nom }} {{ $data->avance_approuver_par_trois_prenom }}</td>
                                                                <td>
                                                                    {{ !empty($data->date_avance_approuver_par_trois) ? \Carbon\Carbon::parse($data->date_avance_approuver_par_trois)->format('d-m-Y') : '' }}
                                                                </td>
                                                            </tr>
                                        
                                                            <!-- Fonds déboursés par -->
                                                            <tr>
                                                                <td>Fonds déboursés par</td>
                                                                <td>
                                                                    {{ $data->fond_debourser_par == 0 ? $data->autres_nom_prenom_debourse : $data->fond_debourser_nom . ' ' . $data->fond_debourser_prenom }}
                
                                                                </td>
                                                                <td>{{ !empty($data->date_fond_debourser_par) ? \Carbon\Carbon::parse($data->date_fond_debourser_par)->format('d-m-Y') : '' }}
                                                                </td>
                                                            </tr>
                                        
                                                            <!-- Fonds reçus par -->
                                                            <tr>
                                                                <td>Fonds reçus par</td>
                                                                <td>
                                                                    {{ $data->fond_recu_par == 0 ? $data->autres_nom_prenom_fond_recu : $data->fond_recu_nom . ' ' . $data->fond_recu_prenom }}
                
                                                                </td>
                                                                <td>{{ !empty($data->date_fond_recu_par) ? \Carbon\Carbon::parse($data->date_fond_recu_par)->format('d-m-Y') : '' }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-0 shadow-none">
                                            <a href="#collapseThree" class="text-dark collapsed" data-bs-toggle="collapse"
                                                            aria-expanded="true"
                                                            aria-controls="collapseThree">
                                                <div class="card-header" id="headingThree">
                                                    <h6 class="m-0">
                                                        <i class="fa fa-info-circle"></i> Rapport d'utilisation d'avance #3
                                                        <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                    </h6>
                                                </div>
                                            </a>
                                            <div id="collapseThree" class="collapse show"
                                                    aria-labelledby="headingThree" data-bs-parent="#accordion">
                                                <div class="card-body">

                                                    <form class="needs-validation" novalidate method="POST" id="EditdjdaForm">
                                                        @method('post')
                                                        @csrf
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="mb-2">
                                                                        <label class="form-label">Date justification de l'avance</label>
                                                                        <input name="date_justification_avance" value="{{ $data->date_justification_avance }}" type="date" class="form-control form-control-sm" />
                                        
                                                                    </div>
                                                                </div>
                    
                                                                <div class="col-md-3">
                                                                    <div class="mb-2">
                                                                        <label class="form-label">Fonds payés à :</label>
                                                                        <select type="text" class="form-control form-control-sm" name="fondPayea" id="fondPayeaSelect" required>
                                                                            <!-- Option par défaut basée sur la valeur de la base de données -->
                                                                            <option value="{{ $data->pfond_paye }}">
                                                                                {{ $data->pfond_paye == 0 ? 'Autres' : $data->pfond_paye_nom . ' ' . $data->pfond_paye_prenom }}
                                                                            </option>
                                                                            <!-- Boucle pour afficher les options de personnel -->
                                                                            @foreach ($personnel as $personnels)
                                                                                <option value="{{ $personnels->userid }}">
                                                                                    {{ $personnels->nom }} {{ $personnels->prenom }}
                                                                                </option>
                                                                            @endforeach
                                                                            <!-- Option "Autres" avec sélection conditionnelle si la valeur est 0 -->
                                                                            <option value="autres" {{ $data->pfond_paye == 0 ? 'selected' : '' }}>Autres</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <!-- Champ pour le nom complet, affiché seulement si "Autres" est sélectionné ou si pfond_paye est 0 -->
                                                                    <div id="autresPayeaField" style="display: {{ $data->pfond_paye == 0 ? 'block' : 'none' }};">
                                                                        <div class="mb-2">
                                                                            <label class="form-label">Nom et Prénom:</label>
                                                                            <input type="text" class="form-control form-control-sm" name="autres_nom_prenom_paye" 
                                                                                placeholder="Entrez nom et prénom" 
                                                                                value="{{ $data->pfond_paye == 0 ? $data->autres_nom_prenom_paye : '' }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            
                                        
                                                            
                                        
                                                                <div class="col-md-8">
                                                                    <div class="mb-2">
                                                                        <label>DESCRIPTION/MOTIF:</label>
                                                                        <div>
                                                                            <textarea name="fondPayeDescription" id="fondPayeDescription" required class="form-control" rows="2">{{ $data->description_avance }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-4" >
                                                                    <div class="mb-2" id="acce">
                                                                        <label class="form-label">Plaque Immatriculation Véhicule :</label>
                                                                        <select type="text" class="form-control form-control-sm" name="plaque"  required>
                                                                            <option disabled="true" selected="true" value="{{ $data->plaque }}">
                                                                                {{ $data->plaque ? $data->plaque : 'Sélectionnez un véhicule' }}
                                                                            </option>
                                                                            @foreach ($vehicule as $vehicules)
                                                                                <option value="{{ $vehicules->matricule }}">{{ $vehicules->matricule }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                              
                                        
                                                                <div class="col-md-3">
                                                                    <div class="mb-2">
                                                                        <label class="form-label">Montant de l'Avance</label>
                                                                        <input name="montantAvancedeux" value="{{ $data->montant_avance }}" type="number"  min="0" class="form-control form-control-sm" />
                                        
                                                                    </div>
                                                                </div>
                                        
                                                                <div class="col-md-3">
                                                                    <div class="mb-2">
                                                                        <label class="form-label">Montant utilisé*</label>
                                                                        <input name="montantUtilise" value="{{ $data->montant_utiliser }}" type="number" min="0"  class="form-control form-control-sm" />
                                        
                                                                    </div>
                                                                </div>
                                        
                                                                <div class="col-md-3">
                                                                    <div class="mb-2">
                                                                        <label class="form-label">Surplus/Manque*</label>
                                                                        <input name="surplusManque"  value="{{ $data->montant_surplus }}" type="number"  min="0" class="form-control form-control-sm" />
                                        
                                                                    </div>
                                                                </div>
                                        
                                        
                                                                <div class="col-md-3">
                                                                    <div class="mb-2">
                                                                        <label class="form-label">Montant retourné
                                                                            à la caisse ou au compte(Si Surplus)
                                                                        </label>
                                                                        <input name="montantRetourne"  value="{{ $data->montant_retourne }}" type="number" min="0"  class="form-control form-control-sm" />
                                        
                                                                    </div>
                                                                </div>
                                                                <hr>
                                        
                                                                <div class="col-md-3">
                                                                    <div class="mb-2">
                                                                        <label class="form-label">Réception des fonds retournés à la caisse par: <br>Noms de la
                                                                            Caissière :
                                                                        </label>
                                                                        <select type="text" class="form-control form-control-sm" name="fond_retourne" id="acce" required>
                                                                            <option disabled="true" selected="true" value="{{ $data->fonds_retournes_caisse_par }} ">{{ $data->fonds_retournes_caisse_nom }} {{ $data->fonds_retournes_caisse_prenom }}</option>
                                                                            @foreach ($personnel as $personnels)
                                                                            <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                                            @endforeach
                                                                        </select>
                                        
                                                                    </div>
                                                                </div>
                                        
                                                                <div class="col-md-3">
                                                                    <div class="mb-2">
                                                                        <label class="form-label">ou Borderau de versement <br>nº <br>
                                                                        </label>
                                                                        <input name="bordereauVersement" value="{{ $data->bordereau_versement }}" type="text" class="form-control form-control-sm" />
                                        
                                                                    </div>
                                                                </div>
                                        
                                                                <div class="col-md-3">
                                                                    <div class="mb-2">
                                                                        <label class="form-label">Du <br> <br>
                                                                        </label>
                                                                        <input name="du" type="date" value="{{ $data->du_num }}" class="form-control form-control-sm" />
                                        
                                                                    </div>
                                                                </div>
                                                                <hr>
                                        
                                                                <div class="col-md-4">
                                                                    <div class="mb-2">
                                                                        <label class="form-label">Réception des pièces justificatives de l'utilisation de l'avance
                                                                            par:
                                                                        </label>
                                                                        <select type="text" class="form-control form-control-sm" name="reception_pieces_par" id="acce" required>
                                                                            <option disabled="true" selected="true" value="{{ $data->reception_pieces_justificatives }} ">{{ $data->reception_pieces_nom }} {{ $data->reception_pieces_prenom }}</option>
                                                                            @foreach ($personnel as $personnels)
                                                                            <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                                            @endforeach
                                                                            <option value="autres">Non prise en charge</option>
                                                                        </select>
                                        
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="mb-2">
                                                                        <label class="form-label">Date <br> 
                                                                        </label>
                                                                        <input name="date_reception_piece_justifive" type="date" value="{{ $data->date_reception_pieces_justificatives }}" class="form-control form-control-sm" />
                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                        
                                                            <br><br>
                                                            <button  id="edjitustifierbtn" name="editjustifierbtn" class="btn btn-primary editjustifierbtn" type="submit"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder Utilisation de l'avance </button>
                                                        <br><br>

                                                    </form>
                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>








                      
                       

                    
                        
                    </div> <!-- Fin de la rangée principale -->
                </div> <!-- Fin du corps de la carte -->
            </div> <!-- Fin de la carte -->
        </form>
    </div>
</div>

<script>
    // JavaScript pour afficher/masquer le champ "Nom et Prénom" selon la sélection
    document.getElementById('fondPayeaSelect').addEventListener('change', function() {
        var autresPayeaField = document.getElementById('autresPayeaField');
        autresPayeaField.style.display = this.value === 'autres' ? 'block' : 'none';
    });
</script>

<script>
    // Vérifier le champ de description à chaque changement de valeur
    document.getElementById('fondPayeDescription').addEventListener('blur', function() {
        var description = this.value.toLowerCase();

        // Vérifie si la description contient le mot "carburant"
        if (description.includes('carburant')) {
            // Si "carburant" est trouvé, afficher la plaque
            document.getElementById('acce').style.display = 'block';
        } else {
            // Sinon, masquer la plaque
            document.getElementById('acce').style.display = 'none';
        }
    });

    // Lors du chargement de la page, vérifier si la description contient "carburant"
    window.onload = function() {
        var description = document.getElementById('fondPayeDescription').value.toLowerCase();
        if (description.includes('carburant')) {
            document.getElementById('acce').style.display = 'block';
        } else {
            document.getElementById('acce').style.display = 'none';
        }
    }
</script>

<script>
    // Script pour gérer la saisie de montant utilisé et le surplus/manque
    $(document).on('input', 'input[name="montant_utiliser[]"]', function() {
        var montantAvance = $(this).closest('tr').find('input[name="montantavance[]"]').val();
        var montantUtilise = $(this).val();
        var surplusManque = parseFloat(montantAvance) - parseFloat(montantUtilise);
        $(this).closest('tr').find('input[name="surplus[]"]').val(surplusManque);
    });

    $(document).on('input', 'input[name="montant_retourne[]"]', function() {
        var surplusManque = parseFloat($(this).closest('tr').find('input[name="surplus[]"]').val());
        var montantRetourne = parseFloat($(this).val());
        var errorMessage = $(this).closest('tr').find('.error-message');
        var addjustifierbtn = $('#addjustifierbtn');

        if (montantRetourne !== surplusManque) {
            errorMessage.text("Le Montant Retourné doit être égal au Surplus/Manque.");
            $(this).addClass('is-invalid');
            addjustifierbtn.prop('disabled', true);
        } else {
            errorMessage.text("");
            $(this).removeClass('is-invalid');
            addjustifierbtn.prop('disabled', false);
        }
    });

   

    $(function() {
        // Gestion de la soumission de l'édition via Ajax
        $("#EditdjdaForm").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#addjustifierbtn").html('<i class="fas fa-spinner fa-spin"></i> En cours...').prop('disabled', true);

            $.ajax({
                url: "{{ route('declareJustificatif', $data->iddjas) }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        toastr.success("Mises à jour DJA avec succès !", "Succès");
                    } else if (response.status == 201) {
                        toastr.error("Attention: DJA existe déjà !", "Info");
                    } else if (response.status == 202 || response.status == 203) {
                        toastr.error("Erreur : " + (response.error || "vérifier votre internet"), "Erreur");
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error("Une erreur s'est produite : " + error, "Erreur");
                },
                complete: function() {
                    $("#addjustifierbtn").html('Sauvegarder').prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection
