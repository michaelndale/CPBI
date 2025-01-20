@extends('layout/app')
@section('page-content')
<div class="main-content">
    <div class="page-content">
        <div class="col-12" style="margin:auto">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Modification du DEMANDE ET JUSTIFICATION D'AVANCE (DJA)</h4>

                @if (session()->has('id'))
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
                @endif
            </div>
        </div>

        

      
        

        <form  method="POST" action="{{ route('updateSignatureDja', $data->iddjas)}}">
            @method('post')
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
            
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
            

                    

                        <h6><i class="fa fa-info-circle"></i> Demande d'une avance</h6>
                                    <hr>
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

                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h6><i class="fa fa-info-circle"></i> Demande/Approbation</h6>
                                    <hr>
                        
                                    <table class="table table-striped table-sm fs--1 mb-0">
                                        <thead>
                                            <tr>
                                                <th>Information</th>
                                                <th>Nom</th>
                                                <th>Signature</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Fonds demandés par -->
                                            <tr>
                                                <td>Fonds demandés par</td>
                                                <td>{{ $data->fonds_demandes_nom }} {{ $data->fonds_demandes_prenom }}</td>
                                                <td> <input class="form-check-input" type="checkbox" name="signe_fonds_demande_par" style="border:1px solid red" 
                                                     {{ $data->signe_fonds_demande_par == '1' ? 'checked' : '' }}  {{ Auth::user()->id == $data->fonds_demande_par ? '' : 'disabled' }}   > </td>
                                                <td>
                                                    <input type="date" value="{{ $data->date_fonds_demande_par }}" name="date_fonds_demande_par"  style="width:50%; border:none; border-bottom: 2px dotted #000;"  {{ Auth::user()->id == $data->fonds_demande_par ? '' : 'disabled' }} />
                                                </td>
                                            </tr>
                        
                                            <!-- Approbation par la première personne -->
                                            <tr>
                                                <td>Avance approuvée par (Chef Comptable, si A < 500 000 Fbu)</td>
                                                <td>{{ $data->avance_approuver_un_nom }} {{ $data->avance_approuver_un_prenom }}</td>
                                                 <td> <input class="form-check-input" type="checkbox" name="signe_avance_approuver_par" style="border:1px solid red"
                                                    {{ $data->signe_avance_approuver_par == '1' ? 'checked' : '' }} {{ Auth::user()->id == $data->avance_approuver_par ? '' : 'disabled' }} > </td>
                                                <td>
                                                    <input type="date" value="{{ $data->date_avance_approuver_par }}" name="date_avance_approuver_par" style="width:50%; border:none; border-bottom: 2px dotted #000;" {{ Auth::user()->id == $data->avance_approuver_par ? '' : 'disabled' }}  />
                                                </td>
                                            </tr>
                        
                                            <!-- Approbation par la deuxième personne -->
                                            <tr>
                                                <td>Avance approuvée par (RAF, si A < 2 000 000 Fbu)</td>
                                                <td>{{ $data->avance_approuver_par_deux_nom }} {{ $data->avance_approuver_par_deux_prenom }}</td>
                                                 <td> <input class="form-check-input" type="checkbox" name="signe_avance_approuver_par_deux" style="border:1px solid red"
                                                    {{ $data->signe_avance_approuver_par_deux == '1' ? 'checked' : '' }} {{ Auth::user()->id == $data->avance_approuver_par_deux ? '' : 'disabled' }} > </td>
                                                <td>
                                                 
                                                    <input type="date" value="{{ $data->date_avance_approuver_par_deux }}" name="date_avance_approuver_par_deux"  style="width:50%; border:none; border-bottom: 2px dotted #000;"  {{ Auth::user()->id == $data->avance_approuver_par_deux ? '' : 'disabled' }}  />
                                                </td>
                                            </tr>
                        
                                            <!-- Approbation par la troisième personne -->
                                            <tr>
                                                <td>Avance approuvée par (SG ou SGA, si A > 2 000 000 Fbu)</td>
                                                <td>{{ $data->avance_approuver_par_trois_nom }} {{ $data->avance_approuver_par_trois_prenom }}</td>

                                                 <td> 
                                                    <input class="form-check-input" type="checkbox" name="signe_avance_approuver_par_trois" style="border:1px solid red"
                                                    {{ $data->signe_avance_approuver_par_trois == '1' ? 'checked' : '' }} {{ Auth::user()->id == $data->avance_approuver_par_trois ? '' : 'disabled' }}  > 
                                                </td>

                                                <td>
                                                 
                                                    <input type="date" value="{{ $data->date_avance_approuver_par_trois }}" name="date_avance_approuver_par_trois"  style="width:50%; border:none; border-bottom: 2px dotted #000;"  {{ Auth::user()->id == $data->avance_approuver_par_trois ? '' : 'disabled' }}  />
                                                </td>
                                            </tr>
                        
                                            <!-- Fonds déboursés par -->
                                            <tr>
                                                <td>Fonds déboursés par</td>
                                                <td> {{ $data->fond_debourser_par == 0 ? $data->autres_nom_prenom_debourse : $data->fond_debourser_nom . ' ' . $data->fond_debourser_prenom }}</td>
                                                <td> <input class="form-check-input" type="checkbox" name="signe_fond_debourser_par" style="border:1px solid red"
                                                    {{ $data->signe_fond_debourser_par == '1' ? 'checked' : '' }} {{ Auth::user()->id == $data->fond_debourser_par ? '' : 'disabled' }}  > </td>
                                                <td>
                                                    <input type="date" value="{{ $data->date_fond_debourser_par }}" name="date_fond_debourser_par"  style="width:50%; border:none; border-bottom: 2px dotted #000;" {{ Auth::user()->id == $data->fond_debourser_par ? '' : 'disabled' }}  />
                                                </td>
                                            </tr>
                        
                                            <!-- Fonds reçus par -->
                                            <tr>
                                                <td>Fonds reçus par</td>
                                                <td>  {{ $data->fond_recu_par == 0 ? $data->autres_nom_prenom_fond_recu : $data->fond_recu_nom . ' ' . $data->fond_recu_prenom }}</td>
                                                 <td> <input class="form-check-input" type="checkbox" name="signe_fond_recu_par" style="border:1px solid red"
                                                    {{ $data->signe_fond_recu_par == '1' ? 'checked' : '' }}  {{ Auth::user()->id == $data->fond_recu_par ? '' : 'disabled' }}> </td>
                                                <td>
                                                    <input type="date" value="{{ $data->date_fond_recu_par }}" name="date" id="date_fond_recu_par"  style="width:50%; border:none; border-bottom: 2px dotted #000;"  {{ Auth::user()->id == $data->fond_recu_par ? '' : 'disabled' }} />
                                                   
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h6><i class="fa fa-info-circle"></i> Rapport d'utilisation d'avance </h6>
                                    <hr>
                                    <table class="table table-striped table-sm fs--1 mb-0">
                                        <tbody>
                                            <tr>
                                                <th> </th>
                                                <td></td>
                                                <td align="center"> Signature</td>
                                                <td>Date</td>
                                            </tr>
                                            <tr>
                                                <th>Fonds payés à</th>
                                                <td>
                                               
                                                    {{ $data->pfond_paye == 0 ? $data->autres_nom_prenom_paye : $data->pfond_paye_nom. ' ' . $data->pfond_paye_prenom }}

                                                </td>
                                                 <td align="center"> <input class="form-check-input" type="checkbox" name="signature_pfond_paye" style="border:1px solid red"
                                                    {{ $data->signature_pfond_paye == '1' ? 'checked' : '' }}   {{ Auth::user()->id == $data->pfond_paye ? '' : 'disabled' }}> </td>
                                                    <td>
                                                        <input type="date" value="{{ $data->date_pfond_paye }}" name="date_pfond_paye"  style="width:50%; border:none; border-bottom: 2px dotted #000;" {{ Auth::user()->id == $data->pfond_paye ? '' : 'disabled' }} />
                                                    </td>
                                            </tr>
                                            <tr>
                                                <th>Description/Motif</th>
                                                <td>{{ $data->description_avance }}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>Montant de l'Avance</th>
                                                <td>  {{ number_format($data->montant_avance , 0, ',', ' ') }} </td>
                                                <th> </th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>Montant utilisé</th>
                                                <td> {{ number_format($data->montant_utiliser , 0, ',', ' ') }}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>Surplus/Manque</th>
                                                <td> {{ number_format($data->montant_surplus, 0, ',', ' ') }} </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>Montant retourné à la caisse ou au compte (Si Surplus)</th>
                                                <td> {{ number_format($data->montant_retourne, 0, ',', ' ') }}</td>
                                                <th></th>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>Réception des fonds retournés à la caisse par</th>
                                                <td>{{ $data->fonds_retournes_caisse_nom }} {{ $data->fonds_retournes_caisse_prenom }}</td>
                                                 <td align="center"> <input class="form-check-input" type="checkbox" name="signe_fonds_retournes_caisse_par" style="border:1px solid red"
                                                    {{ $data->signe_fonds_retournes_caisse_par == '1' ? 'checked' : '' }} {{ Auth::user()->id == $data->fonds_retournes_caisse_par ? '' : 'disabled' }} > </td>
                                                    <td>
                                                        <input type="date" value="{{ $data->date_fonds_retournes_caisse_par }}" name="date_fonds_retournes_caisse_par"  style="width:50%; border:none; border-bottom: 2px dotted #000;" {{ Auth::user()->id == $data->fonds_retournes_caisse_par ? '' : 'disabled' }} />
                                                    </td>
                                            </tr>
                                            <tr>
                                                <th>Borderau de versement nº</th>
                                                <td>{{ $data->bordereau_versement }}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Du</td>
                                                <td>{{ \Carbon\Carbon::parse($data->du_num)->format('d-m-y') }}</td>
                                                <td> </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <th>Réception des pièces justificatives de l'utilisation de l'avance par</th>
                                                <td>{{ $data->reception_pieces_nom }} {{ $data->reception_pieces_prenom }}</td>
                                                <td align="center"> <input class="form-check-input" type="checkbox" name="signe_reception_pieces_justificatives" style="border:1px solid red"
                                                    {{ $data->signe_reception_pieces_justificatives == '1' ? 'checked' : '' }}  {{ Auth::user()->id == $data->reception_pieces_justificatives ? '' : 'disabled' }}> </td>
                                                <td>
                                                    <input type="date" value="{{ $data->date_reception_pieces_justificatives }}" name="date_reception_pieces_justificatives"  style="width:50%; border:none; border-bottom: 2px dotted #000;"  {{ Auth::user()->id == $data->reception_pieces_justificatives ? '' : 'disabled' }} />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button  name="save" class="btn btn-primary" type="submit" >Enregistrer la signature</button>
                           </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>

@endsection
