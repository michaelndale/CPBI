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
                                                        <i class="fa fa-info-circle"></i> Demande #1
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
                                                        <i class="fa fa-info-circle"></i> Approbation #2
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

                                                                <div class="col-md-2">
                                                                    <label class="form-label">FEB Utiliser :</label>
                                                                   <br>
                                                                @php
                                                                    $affiches = []; // Tableau pour stocker les IDs déjà affichés
                                                                @endphp
                                                               
                                                               @foreach ($numerofeb as $feb)
                                                                   @if (!in_array($feb->id, $affiches)) <!-- Vérifie si l'ID est déjà affiché -->
                                                                       <a href="#" 
                                                                          data-bs-toggle="modal" 
                                                                          data-bs-target="#febinfo" 
                                                                          data-id="{{ $feb->id }}" 
                                                                          class="infofeb">
                                                                          <i class="fa fa-link"></i> FEB NUM: {{ $feb->numerofeb }}
                                                                       </a><br>
                                                                       @php
                                                                           $affiches[] = $feb->id; // Ajoute l'ID au tableau
                                                                       @endphp
                                                                   @endif
                                                               @endforeach
                                                               


                                                                

                                                                </div>

                                                                <div class="col-md-2">
                                                                 <label class="form-label">Rapport et utilisation :</label>
                                                                  <!-- <br> <a href=""><i class="fa fa-info-circle "></i> Details sur l'utilisation ! </a>   -->

                                                                  <br> <a href="" data-bs-toggle="modal" data-bs-target="#annexModalScrollable"><i class="fa fa-plus-circle"></i> Ajouter l'annex  </a>
                                                               
                                                                  <br> <a href="" data-bs-toggle="modal" data-bs-target="#RapportannexModalScrollable"><i class="fa fa-list"></i> Voir l'annex  </a>
                                                               
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
                                                                        <input name="montantUtilise"  type="number" min="0" value="{{ $data->montant_utiliser }}" class="form-control form-control-sm" />
                                        
                                                                    </div>
                                                                </div>
                                        
                                                                <div class="col-md-2">
                                                                    <div class="mb-2">
                                                                        <label class="form-label">Surplus/Manque*</label>
                                                                        <input name="surplusManque"  type="number"  min="0" class="form-control form-control-sm" readonly />
                                        
                                                                    </div>
                                                                </div>
                                        
                                        
                                                                <div class="col-md-4">
                                                                    <div class="mb-2">
                                                                        <label class="form-label">Montant retourné
                                                                            à la caisse ou au compte(Si Surplus)
                                                                        </label>
                                                                        <input name="montantRetourne"   type="number" min="0"  class="form-control form-control-sm" readonly />
                                        
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
                                                                        <label class="form-label">Borderau de versement <br>nº :
                                                                        </label>
                                                                        <input name="bordereauVersement" value="{{ $data->bordereau_versement }}" type="text" class="form-control form-control-sm" />
                                        
                                                                    </div>
                                                                </div>
                                        
                                                                <div class="col-md-2">
                                                                    <div class="mb-2">
                                                                        <label class="form-label">Du <br>(date bordereau) <br>
                                                                        </label>
                                                                        <input name="du" type="date" value="{{ $data->du_num }}" class="form-control form-control-sm" />
                                        
                                                                    </div>
                                                                </div>
                                                                <hr>
                                        
                                                                <div class="col-md-5">
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

<div class="modal fade" id="annexModalScrollable" tabindex="-1" role="dialog" aria-labelledby="annexModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form id="addAnnexForm" autocomplete="off">
            @method('post')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="annexModalScrollableTitle">Ajouter les références des documents à attacher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="djasid" value="{{ $data->iddjas }}" />
                    <select class="form-control form-control-sm" id="annex" name="annex[]" multiple style="height: 150px" required>
                        <option disabled>-- Sélectionner les documents attachés --</option>
                        @foreach ($attache as $attaches)
                            <option value="{{ $attaches->id }}" 
                                    class="{{ in_array($attaches->id, $attachedDocIds) ? 'attached-option' : '' }}" 
                                    {{ in_array($attaches->id, $attachedDocIds) ? 'selected' : '' }}>
                                     {{ $attaches->libelle }}
                            </option>
                        @endforeach
                    </select>

                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" id="add_annex" name="add_annex" class="btn btn-primary waves-effect waves-light">
                        <i class="fa fa-cloud-upload-alt"></i> Sauvegarder
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="RapportannexModalScrollable" tabindex="-1" role="dialog" aria-labelledby="RapportannexModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
       
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="RapportannexModalScrollableTitle">Les documents en annex  attacher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($getDocument->isNotEmpty()) 
                    @foreach ($getDocument as $doc) 
                        <div class="col-md-12">
                            <input type="hidden" name="annexid[]" value="{{ $doc->iddoc }}" />
                            <input type="hidden" name="ancientdoc[]" value="{{ $doc->urldoc }}" />
                            <label class="text-1000 fw-bold mb-2">
                                {{ $doc->libelle }} ({{ $doc->abreviation }}) , 
                                @if ($doc->urldoc === NULL)
                                    <i class="fa fa-times-circle" style="color: red;" title="Aucun document disponible"></i>
                                    <span style="color: red;">Pas de document disponible</span>
                                @else
                                    <a href="#" onclick="viewDocument('{{ asset($doc->urldoc) }}'); return false;" title="{{ $doc->urldoc }}">
                                        <i class="fa fa-link"></i> Voir le document 
                                    </a>
                                @endif
                            </label>
                          
                            <div class="error-message" style="color: red; display: none;"></div>
                            <br>
                        </div>
                    @endforeach
                @else 
                    <div class="col-md-12">
                        <span>Pas de document disponible</span>
                    </div>
                @endif
                    
                </div>
               
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="documentModalLabel">Visualisation du Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="documentFrame" style="width: 100%; height: 500px;" frameborder="0"></iframe>
                <div id="noDocumentMessage" style="color: red; display: none;">Il n'existe pas de document.</div>
            </div>
        </div>
    </div>
</div>


@include('document.dja.elementsfebs')



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
    document.addEventListener('DOMContentLoaded', function () {
        // Sélectionner les éléments du formulaire
        const montantAvance = document.querySelector('input[name="montantAvancedeux"]');
        const montantUtilise = document.querySelector('input[name="montantUtilise"]');
        const surplusManque = document.querySelector('input[name="surplusManque"]');
        const montantRetourne = document.querySelector('input[name="montantRetourne"]');

        // Ajouter un écouteur d'événement sur les champs Montant de l'Avance et Montant utilisé
        montantAvance.addEventListener('input', calculer);
        montantUtilise.addEventListener('input', calculer);

        // Fonction pour effectuer les calculs
        function calculer() {
            // Récupérer les valeurs des champs
            const avance = parseFloat(montantAvance.value) || 0;
            let utilise = parseFloat(montantUtilise.value) || 0;

            // Vérifier si le Montant utilisé dépasse le Montant de l'Avance
            if (utilise > avance) {
                // Réinitialiser le Montant utilisé à la valeur du Montant de l'Avance
                montantUtilise.value = avance;
                utilise = avance; // Mettre à jour la variable utilise avec la nouvelle valeur
                showModal("Attention !", "Le montant utilisé ne peut pas dépasser le montant de l'avance.");
            }

            // Calculer le Surplus/Manque
            const result = Math.round(avance - utilise);

            // Mettre à jour le champ Surplus/Manque
            surplusManque.value = result;

            // Si le résultat est positif, mettre à jour le Montant retourné
            if (result > 0) {
                montantRetourne.value = result;
            } else {
                montantRetourne.value = '0'; // Aucun montant retourné si pas de surplus
            }
        }

        // Fonction pour afficher une modale personnalisée
        function showModal(title, message) {
            // Créer un conteneur pour la modale
            const modalContainer = document.createElement('div');
            modalContainer.style.position = 'fixed';
            modalContainer.style.top = '50%';
            modalContainer.style.left = '50%';
            modalContainer.style.transform = 'translate(-50%, -50%)';
            modalContainer.style.backgroundColor = '#fff';
            modalContainer.style.padding = '20px';
            modalContainer.style.borderRadius = '8px';
            modalContainer.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.2)';
            modalContainer.style.zIndex = '1000';

            // Générer un ID unique pour le bouton Fermer
            const uniqueId = `closeModal_${new Date().getTime()}`;

            // Contenu de la modale
            modalContainer.innerHTML = `
                <h4 style="margin-bottom: 10px;">${title}</h4>
                <p style="margin-bottom: 15px;">${message}</p>
                <button id="${uniqueId}" style="padding: 8px 16px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    <i class="fa fa-times-circle"></i> OK
                </button>
            `;

            // Ajouter la modale au body
            document.body.appendChild(modalContainer);

            // Attacher un écouteur d'événement directement au bouton créé
            document.getElementById(uniqueId).addEventListener('click', function () {
                document.body.removeChild(modalContainer); // Supprimer la modale
            });
        }

        // Appeler la fonction de calcul au chargement de la page
        calculer();
    });
</script>


<script>
    function validateFiles(fileInput) {
        const maxSize = 2 * 1024 * 1024; // 2MB
        const file = fileInput.files[0];
        const errorMessageDiv = fileInput.nextElementSibling;

        // Clear previous error messages
        errorMessageDiv.textContent = '';
        errorMessageDiv.style.display = 'none';

        // Check if file size exceeds limit
        if (file && file.size > maxSize) {
            errorMessageDiv.textContent = 'La taille du fichier ne doit pas dépasser 2 Mo.';
            errorMessageDiv.style.display = 'block';
            document.getElementById('addfebbtn').disabled = true;
        } else {
            // Disable the button if any other files are invalid
            const inputs = document.querySelectorAll('input[type="file"]');
            let allValid = true;

            inputs.forEach(input => {
                if (input.files.length > 0 && input.files[0].size > maxSize) {
                    allValid = false;
                }
            });

            document.getElementById('addfebbtn').disabled = !allValid;
        }
    }

    function viewDocument(url) {
        const documentFrame = document.getElementById('documentFrame');
        const noDocumentMessage = document.getElementById('noDocumentMessage');

        // Clear previous message
        noDocumentMessage.style.display = 'none';

        // AJAX request to check if the document exists
        fetch(url)
            .then(response => {
                if (response.ok) {
                    documentFrame.src = url; // Load the PDF in the iframe
                    $('#documentModal').modal('show'); // Show the modal
                } else {
                    noDocumentMessage.style.display = 'block'; // Show error message
                }
            })
            .catch(error => {
                console.error('Error checking document:', error);
                noDocumentMessage.style.display = 'block'; // Show error message
            });
    }
</script>

<script>
    $(function () {
        $("#addAnnexForm").submit(function (e) {
            e.preventDefault();
    
            // Récupère les données du formulaire
            const fd = new FormData(this);
            const submitButton = $("#add_annex");
    
            // Vérifie si des documents ont été sélectionnés
            const selectedDocuments = $("#annex").val();
            if (!selectedDocuments || selectedDocuments.length === 0) {
                toastr.error("Veuillez sélectionner au moins un document.", "Erreur");
                return;
            }
    
            // Affiche les données envoyées dans la console (pour le débogage)
            console.log("Données envoyées :", fd.getAll ? Object.fromEntries(fd.entries()) : Array.from(fd.entries()));
    
            // Désactive le bouton et affiche le spinner
            submitButton.html('<i class="fas fa-spinner fa-spin"></i>');
            submitButton.prop("disabled", true);
    
            // Envoi de la requête AJAX
            $.ajax({
                url: "{{ route('storeannexjustification') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    // Traite la réponse du serveur
                    if (response.status === 200) {
                       

                        toastr.success(
                                    "Enregistrement ajouté avec succès !", // Message
                                    "Succès !", // Titre
                                    {
                                        closeButton: true, // Ajoute un bouton de fermeture
                                        progressBar: true, // Affiche une barre de progression
                                        //positionClass: "toast-top-center", // Positionne le toast au centre du haut de la page
                                        timeOut: 3000, // Durée d'affichage (en millisecondes)
                                        extendedTimeOut: 1000, // Durée supplémentaire si l'utilisateur passe la souris sur le toast
                                    }
                                );
                                      


                        $("#addAnnexForm")[0].reset();
                        $("#annexModalScrollable").modal('hide');
                        window.location.href = response.redirect;
                    } else if (response.status === 201) {
                        toastr.error("Référence des documents existe déjà !", "Erreur");
                    } else {
                        toastr.error("Une erreur s'est produite : " + (response.error || "Aucun détail"), "Erreur");
                    }
    
                    // Réactive le bouton et réinitialise le texte
                    submitButton.html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                    submitButton.prop("disabled", false);
                },
                error: function (xhr, status, error) {
                    // Affiche les détails de l'erreur dans la console
                    console.error("Réponse du serveur :", xhr.responseText);
    
                    // Essaye de parser la réponse JSON pour extraire le message d'erreur
                    let errorMessage = "Une erreur s'est produite.";
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response && response.error) {
                            errorMessage = response.error; // Utilisez le message d'erreur personnalisé depuis le contrôleur
                        }
                    } catch (e) {
                        console.error("Impossible de parser la réponse JSON :", e);
                    }
    
                    // Affiche l'erreur dans un toast
                    toastr.error(errorMessage, "Erreur");
    
                    // Réactive le bouton et réinitialise le texte
                    submitButton.html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                    submitButton.prop("disabled", false);
                }
            });
        });
    });
    </script>



<script>
   

   

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
