<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title> DJA NUMERO: {{ $data->nume_dap }} </title>
    <link href="{{ asset('element/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <style>
        /* Configuration pour impression au format A4 en orientation portrait */
  
    /* Configuration pour impression au format A4 en orientation portrait */
    @media print {
        @page {
            size: A4 portrait; /* A4 portrait */
            margin: 9mm; /* Définir une marge pour éviter le débordement */
        }

        body {
            font-family: Arial, sans-serif; /* Assurer une police claire */
            font-size: 9px; /* Taille de police standard */
            margin: 0;
            padding: 0;
            line-height: 1.4;
            background-color: white
        }

        table {
            width: 100%; /* Utiliser toute la largeur disponible */
            border-collapse: collapse; /* Assurer que les bordures sont bien collées */
            margin-bottom: 2px; /* Espacement entre les tableaux */
        }

        th, td {
            border-bottom: 1px solid #c0c0c0; /* Ajouter des bordures pour plus de lisibilité */
            padding: 3px; /* Ajouter du padding pour une meilleure lisibilité */
            text-align: left; /* Alignement du texte à gauche */
        }

        .card-body {
            padding: 2px !important; /* S'assurer que le padding est approprié pour l'impression */
        }

        /* Pour garder les deux tableaux alignés */
        .row {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .col-xl-5 {
            width: 48%; /* Prendre 48% de la largeur pour que les deux tableaux tiennent côte à côte */
            margin-bottom: 5px;
        }
    }
</style>


</head>
<body>
    <table>
        <thead>
            <tr>
                <td style="border: none; text-align: center; vertical-align: middle;" colspan="12">
                    <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <img src="{{ asset('element/logo/logo.png') }}" alt="logo" height="60" />
                        <h4 style="margin: 0;">{{ $dateinfo->entete }}</h4>
                    </div>
                    <p style="margin: 0;">{{ $dateinfo->sousentete }} </p>
                    <hr style="width:100%">

                </td>
            </tr>
        </thead>
    </table>


 
        <div class="card-body">
            <div class="row">
                <h6><center> DEMANDE ET JUSTIFICATICATION D'AVANCE (DJA) N<sup>o</sup> {{ $data->nume_dap }}  </center></h6>

                <font size="2px"> Demande d'une avance</font>
                <hr>
                <div class="col-xl-5">
                 
                        
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

                <div class="col-xl-5">
                 
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

                <div class="col-xl-12">
               
                            <font size="2px"><i class="fa fa-info-circle"></i> Demande/Approbation</font>
                            <hr>
                           

                            <table style="width:100%">

                                <tbody>
                                    <!-- Fonds demandés par -->
                                    <tr>
                                        <td>Fonds demandés par <br>
                                            {{ $data->fonds_demandes_nom }} {{ $data->fonds_demandes_prenom }}</td>
                                      
                                        <td>
                                            <center>

                                                @if ($data->signe_fonds_demande_par == 1)
                                                    <img src="{{ asset($data->fonds_demandes_signature) }}"
                                                        width="60px" />
                                                @endif
                                            </center>
                                        </td>
                                        <td>

                                            @if($data->date_fonds_demande_par)
                                            {{ \Carbon\Carbon::parse($data->date_fonds_demande_par)->format('d-m-Y') }}
                                        @else
                                            
                                        @endif

                                          
                                        </td>
                                    </tr>

                                    <!-- Approbation par la première personne -->
                                    <tr>
                                        <td>
                                            Avance approuvée par (Chef Comptable, si A < 500 000 Fbu) <br>
                                                {{ $data->avance_approuver_un_nom }}
                                                {{ $data->avance_approuver_un_prenom }}
                                        </td>


                                        <td>
                                            <center>
                                                @if ($data->signe_avance_approuver_par == 1)
                                                    <img src="{{ asset($data->avance_approuver_signature) }}"
                                                        width="60px" />
                                                @endif
                                            </center>
                                        </td>

                                        <td>
                                            @if($data->date_avance_approuver_par)
                                            {{ \Carbon\Carbon::parse($data->date_avance_approuver_par)->format('d-m-Y') }}
                                        @else
                                          
                                        @endif
                                        </td>
                                    </tr>

                                    <!-- Approbation par la deuxième personne -->
                                    <tr>
                                        <td>Avance approuvée par (RAF, si A < 2 000 000 Fbu) <br>
                                                {{ $data->avance_approuver_par_deux_nom }}
                                                {{ $data->avance_approuver_par_deux_prenom }}</td>

                                        <td>
                                            <center>
                                                @if ($data->signe_avance_approuver_par_deux == 1)
                                                    <img src="{{ asset($data->avance_approuver_par_deux_signature) }}"
                                                        width="60px" />
                                                @endif
                                            </center>

                                        </td>
                                        <td>
                                            @if($data->date_avance_approuver_par_deux)
                                            {{ \Carbon\Carbon::parse($data->date_avance_approuver_par_deux)->format('d-m-Y') }}
                                        @else
                                           
                                        @endif
                                        </td>
                                    </tr>

                                    <!-- Approbation par la troisième personne -->
                                    <tr>
                                        <td>Avance approuvée par (SG ou SGA, si A > 2 000 000 Fbu) <br>
                                            {{ $data->avance_approuver_par_trois_nom }}
                                            {{ $data->avance_approuver_par_trois_prenom }}</td>


                                        <td>

                                            <center>
                                                @if ($data->signe_avance_approuver_par_trois == 1)
                                                    <img src="{{ asset($data->avance_approuver_par_trois_signature) }}"
                                                        width="60px" />
                                                @endif
                                            </center>



                                        </td>

                                        <td>

                                            @if($data->date_avance_approuver_par_trois)
                                            {{ \Carbon\Carbon::parse($data->date_avance_approuver_par_trois)->format('d-m-Y') }}
                                        @else
                                           
                                        @endif
                                        </td>
                                    </tr>

                                    <!-- Fonds déboursés par -->
                                    <tr>
                                        <td>Fonds déboursés par <br>
                                         

                                            {{ $data->fond_debourser_par == 0 ? $data->autres_nom_prenom_debourse : $data->fond_debourser_nom . ' ' . $data->fond_debourser_prenom }}
                                        </td>

                                        <td>

                                            <center>
                                                @if ($data->signe_fond_debourser_par == 1)
                                                    <img src="{{ asset($data->fond_debourser_signature) }}"
                                                        width="60px" />
                                                @endif
                                            </center>

                                            
                                         
                                        </td>
                                        <td>
                                            @if($data->date_fond_debourser_par)
                                                {{ \Carbon\Carbon::parse($data->date_fond_debourser_par)->format('d-m-Y') }}
                                            @else
                                               
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Fonds reçus par -->
                                    <tr>
                                        <td>Fonds reçus par <br> 
                                            {{ $data->fond_recu_par == 0 ? $data->autres_nom_prenom_fond_recu : $data->fond_recu_nom . ' ' . $data->fond_recu_prenom }}</td>

                                        <td> 


                                            <center>
                                                @if ($data->signe_fond_recu_par  == 1)
                                                    <img src="{{ asset($data->fond_recu_signature) }}"
                                                        width="60px" />
                                                @endif
                                            </center>
                                            
                                         </td>
                                         
                                        <td>
                                            @if($data->date_fond_recu_par)
                                            {{ \Carbon\Carbon::parse($data->date_fond_recu_par)->format('d-m-Y') }}
                                        @else
                                           
                                        @endif

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                     
                </div>


                <div class="col-xl-12">
                 <br>
                            <font size="2px"><i class="fa fa-info-circle"></i> Rapport d'utilisation d'avance </font>
                           
                            <table>
                                <tbody>
                                    <tr>
                                        <th> </th>
                                        <th></th>
                                        <th><center> Signature </center></th>
                                        <th>Date</th>
                                    </tr>
                                    <tr>
                                        <th>Fonds payés à <br>
                                            
                                            {{ $data->pfond_paye == 0 ?  $data->autres_nom_prenom_paye : $data->pfond_paye_nom . ' ' . $data->pfond_paye_prenom }}

                                         
                                        
                                        </th>
                                        <td></td>
                                        <td align="center"> 

                                            <center>
                                                @if ($data->signature_pfond_paye == 1)
                                                    <img src="{{ asset($data->pfond_paye_signature) }}"
                                                        width="60px" />
                                                @endif
                                            </center>
                                            
                                          </td>
                                        <td>
                                            @if($data->date_pfond_paye)
                                                        {{ \Carbon\Carbon::parse($data->date_pfond_paye)->format('d-m-Y') }}
                                                    @else
                                                    
                                                    @endif
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
                                        <td> {{ number_format($data->montant_avance, 0, ',', ' ') }}</td>
                                        <th> </th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Montant utilisé</th>
                                        <td> {{ number_format($data->montant_utiliser, 0, ',', ' ') }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Surplus/Manque</th>
                                        <td> {{ number_format($data->montant_surplus, 0, ',', ' ') }}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Montant retourné à la caisse ou au compte (Si Surplus)</th>
                                        <td>{{ $data->montant_retourne }}</td>
                                        <th></th>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Réception des fonds retournés à la caisse par <br>
                                            {{ $data->fonds_retournes_caisse_nom }}
                                            {{ $data->fonds_retournes_caisse_prenom }}</th>
                                        <td></td>
                                        <td align="center"> 

                                            <center>
                                                @if ($data->signe_fonds_retournes_caisse_par == 1)
                                                    <img src="{{ asset($data->fonds_retournes_caisse_signature) }}"
                                                        width="60px" />
                                                @endif
                                            </center>
                                            
                                         
                                        </td>
                                        <td>
                                            @if($data->date_fonds_retournes_caisse_par)
                                            {{ \Carbon\Carbon::parse($data->date_fonds_retournes_caisse_par)->format('d-m-Y') }}
                                        @else
                                         
                                        @endif
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
                                        <td>
                                            @if($data->du_num)
                                            {{ \Carbon\Carbon::parse($data->du_num)->format('d-m-y') }}
                                        @else
                                         
                                        @endif
                                        
                                            </td>
                                        <td> </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Réception des pièces justificatives de l'utilisation de l'avance par <br>
                                            {{ $data->reception_pieces_nom }} {{ $data->reception_pieces_prenom }}</th>
                                        <td>
                                        </td>
                                        <td align="center">

                                            <center>
                                                @if ($data->signe_reception_pieces_justificatives == 1)
                                                    <img src="{{ asset($data->reception_pieces_signature) }}"
                                                        width="60px" />
                                                @endif
                                            </center>
                                            
                                         
                                        </td>
                                        <td>
                                            @if($data->date_reception_pieces_justificatives)
                                                {{ \Carbon\Carbon::parse($data->date_reception_pieces_justificatives)->format('d-m-Y') }}
                                            @else
                                              
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br> 
                            <hr>
                                            <p align="center">
                                                {{ $dateinfo->piedpage }}
                                            </p>
                                         


                       
                </div>

            </div>
        </div>

   
    <script>
        // Appel direct de la boîte d'impression au chargement de la page
        window.onload = function() {
            window.print();
        }
    </script>
</body>
