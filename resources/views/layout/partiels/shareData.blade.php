@php

    $febNombre = DB::table('febs')
        ->where(function ($query) {
            $query
                ->orWhere(function ($subQuery) {
                    $subQuery->where('acce', Auth::id())->where('acce_signe', 0);
                })
                ->orWhere(function ($subQuery) {
                    $subQuery->where('comptable', Auth::id())->where('comptable_signe', 0);
                })
                ->orWhere(function ($subQuery) {
                    $subQuery->where('chefcomposante', Auth::id())->where('chef_signe', 0);
                });
        })
        ->get()
        ->count();

    $dapNombre = DB::table('daps')
        ->selectRaw('COUNT(*) as count')
        ->where(function ($query) {
            $query
                ->orWhere(function ($subQuery) {
                    $subQuery->where('demandeetablie', Auth::id())->where('demandeetablie_signe', 0);
                })
                ->orWhere(function ($subQuery) {
                    $subQuery->where('verifierpar', Auth::id())->where('verifierpar_signe', 0);
                })
                ->orWhere(function ($subQuery) {
                    $subQuery->where('approuverpar', Auth::id())->where('approuverpar_signe', 0);
                })
                ->orWhere(function ($subQuery) {
                    $subQuery->where('responsable', Auth::id())->where('responsable_signe', 0);
                })
                ->orWhere(function ($subQuery) {
                    $subQuery->where('secretaire', Auth::id())->where('secretaure_general_signe', 0);
                })
                ->orWhere(function ($subQuery) {
                    $subQuery->where('chefprogramme', Auth::id())->where('chefprogramme_signe', 0);
                });
        })
        ->first();

    $dapNombre = $dapNombre->count;
    $djNombre = DB::table('djas')

        ->select('djas.id as iddjas')
        ->where(function ($query) {
            $query
                ->orWhere(function ($subQuery) {
                    $subQuery->where('djas.fonds_demande_par', Auth::id())->where('djas.signe_fonds_demande_par', 0);
                })
                ->orWhere(function ($subQuery) {
                    $subQuery
                        ->where('djas.avance_approuver_par', Auth::id())
                        ->where('djas.signe_avance_approuver_par', 0);
                })
                ->orWhere(function ($subQuery) {
                    $subQuery
                        ->where('djas.avance_approuver_par_deux', Auth::id())
                        ->where('djas.signe_avance_approuver_par_deux', 0);
                })
                ->orWhere(function ($subQuery) {
                    $subQuery
                        ->where('djas.avance_approuver_par_trois', Auth::id())
                        ->where('djas.signe_avance_approuver_par_trois', 0);
                })
                ->orWhere(function ($subQuery) {
                    $subQuery->where('djas.fond_debourser_par', Auth::id())->where('djas.signe_fond_debourser_par', 0);
                })
                ->orWhere(function ($subQuery) {
                    $subQuery->where('djas.fond_recu_par', Auth::id())->where('djas.signe_fond_recu_par', 0);
                })
                ->orWhere(function ($subQuery) {
                    $subQuery->where('djas.pfond_paye', Auth::id())->where('djas.signature_pfond_paye', 0);
                })
                ->orWhere(function ($subQuery) {
                    $subQuery
                        ->where('djas.fonds_retournes_caisse_par', Auth::id())
                        ->where('djas.signe_reception_pieces_justificatives', 0);
                });
        })
        ->get()
        ->count();

    $bpcNombre = DB::table('bonpetitcaisses')

        ->select('bonpetitcaisses.id')
        ->where(function ($query) {
            $query
                ->where('bonpetitcaisses.etabli_par', Auth::id())
                ->where('bonpetitcaisses.etabli_par_signature', 0)
                ->orWhere('bonpetitcaisses.verifie_par', Auth::id())
                ->where('bonpetitcaisses.verifie_par_signature', 0)
                ->orWhere('bonpetitcaisses.approuve_par', Auth::id())
                ->where('bonpetitcaisses.approuve_par_signature', 0);
        })
        ->get()
        ->count();

    $facNombre = DB::table('febpetitcaisses')

        ->select('febpetitcaisses.id')
        ->where(function ($query) {
            $query
                ->where('febpetitcaisses.etabli_par', Auth::id())
                ->where('febpetitcaisses.etabli_par_signature', 0)
                ->orWhere('febpetitcaisses.verifie_par', Auth::id())
                ->where('febpetitcaisses.verifie_par_signature', 0)
                ->orWhere('febpetitcaisses.approuve_par', Auth::id())
                ->where('febpetitcaisses.approuve_par_signature', 0);
        })

        ->get()
        ->count();

    $dacNombre = DB::table('dapbpcs')

        ->select('dapbpcs.id')
        ->where(function ($query) {
            $query
                ->where('dapbpcs.demande_etablie', Auth::id())
                ->where('dapbpcs.demande_etablie_signe', 0)
                ->orWhere('dapbpcs.verifier', Auth::id())
                ->where('dapbpcs.verifier_signe', 0)
                ->orWhere('dapbpcs.approuver', Auth::id())
                ->where('dapbpcs.approuver_signe', 0)
                ->orWhere('dapbpcs.autoriser', Auth::id())
                ->where('dapbpcs.autoriser_signe', 0)
                ->orWhere('dapbpcs.secretaire', Auth::id())
                ->where('dapbpcs.chefprogramme_signe', 0)
                ->orWhere('dapbpcs.chefprogramme', Auth::id())
                ->where('dapbpcs.secretaire_signe', 0);
        })

        ->get()
        ->count();

        $caisseNombre = DB::table('rappotages')
        ->where(function ($query) {
            $query
                ->orWhere(function ($subQuery) {
                    $subQuery->where('verifier_par', Auth::id())->where('verifier_signature', 0);
                })
             
                ->orWhere(function ($subQuery) {
                    $subQuery->where('approver_par', Auth::id())->where('approver_signature', 0);
                });
        })
        ->get()
        ->count();

    $documentNombre = $dapNombre + $febNombre + $djNombre + $bpcNombre + $facNombre + $dacNombre + $caisseNombre;

@endphp

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-list"></i> Tâches à faire en attente , Résultat
                    ({{ $documentNombre }}). </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="tableExample2">
                    <div class="table-responsive">
                        <!--
                          <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                <input type="text" name="recherche" id="recherche" class="form-control" placeholder="Recherche par numéro(F.E.B, D.A.P), date , Initiateur">
                            </div> 
                        -->

                        <div id="accordion" class="custom-accordion">

                            <div class="card mb-1 shadow-none">
                                <a href="#collapseOne" class="text-dark" data-bs-toggle="collapse" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    <div class="card-header" id="headingOne">
                                        <h6 class="m-0">
                                            
                                            <b>FEB  ({{ $febNombre  }})</b> 
                                            <small>Résultat{{ $febNombre > 1 ? 's' : '' }}</small>
                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                            <br>
                                            Fiche d'Expression des Besoins
                                        </h6>
                                    </div>
                                </a>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-bs-parent="#accordion">
                                    <div class="card-body">

                                        <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="sort border-top"><b>#</b></th>

                                                    <th class="sort border-top" data-sort="febnum">
                                                        <b>
                                                            <center>N<sup>o</sup> DOC</center>
                                                        </b>
                                                    </th>
                                                    <th class="sort border-top" data-sort="montant"><b>
                                                            <center>Montant</center>
                                                        </b></th>
                                                    <th class="sort border-top" data-sort="Date Doc"><b>Date FEB</b>
                                                    </th>
                                                    <th class="sort border-top" data-sort="Créé le"><b>Créé le</b></th>
                                                    <th class="sort border-top" data-sort="Date limite"><b>Date
                                                            Limite</b></th>
                                                    <th class="sort border-top" data-sort="Créé par"><b>Créé par</b>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="febnotification">
                                                <tr>
                                                    <td colspan="8">
                                                        <h5 class="text-center text-secondery my-5">
                                                            @include('layout.partiels.load')
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-1 shadow-none">
                                <a href="#collapseTwo" class="text-dark collapsed" data-bs-toggle="collapse"
                                    aria-expanded="false" aria-controls="collapseTwo">
                                    <div class="card-header" id="headingTwo">
                                        <h6 class="m-0">
                                          

                                            <b>DAP  ({{ $dapNombre  }})</b> 
                                            <small>Résultat{{ $dapNombre  > 1 ? 's' : '' }}</small>
                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                            <br>
                                            Demande d'Autorisation de Paiement
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="sort border-top"><b>#</b></th>
                                                    <th class="sort border-top" data-sort="febnum">
                                                        <b>
                                                            <center>N<sup>o</sup> DOC</center>
                                                        </b>
                                                    </th>


                                                    <th class="sort border-top" data-sort="montant"><b>
                                                            <center>Montant</center>
                                                        </b></th>
                                                    <th class="sort border-top" data-sort="Date Doc"><b>Date</b></th>
                                                    <th class="sort border-top" data-sort="Créé le"><b>Créé le</b></th>
                                                    <th class="sort border-top" data-sort="Date limite"><b>Date
                                                            Limite</b></th>
                                                    <th class="sort border-top" data-sort="Créé par"><b>Créé par</b>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="dapnotification">
                                                <tr>
                                                    <td colspan="8">
                                                        <h5 class="text-center text-secondery my-5">
                                                            @include('layout.partiels.load')
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-0 shadow-none">
                                <a href="#collapseThree" class="text-dark collapsed" data-bs-toggle="collapse"
                                    aria-expanded="false" aria-controls="collapseThree">
                                    <div class="card-header" id="headingThree">
                                        <h6 class="m-0">
                                          

                                            <b>DJA  ({{ $djNombre }})</b> 
                                            <small>Résultat{{ $djNombre > 1 ? 's' : '' }}</small>

                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                            <br>
                                            Demande et Justification d'Avance
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="sort border-top"><b>#</b></th>
                                                    <th class="sort border-top" data-sort="febnum">
                                                        <b>
                                                            <center>N<sup>o</sup> DOC</center>
                                                        </b>
                                                    </th>
                                                    <th class="sort border-top" data-sort="montant"><b>
                                                            <center>Avance</center>
                                                        </b></th>
                                                    <th class="sort border-top" data-sort="Justificatif"><b>
                                                            <center>Justifiéé</center>
                                                        </b></th>
                                                    <th class="sort border-top" data-sort="Date Doc"><b>Durée</b></th>
                                                    <th class="sort border-top" data-sort="Créé le"><b>Créé le</b>
                                                    </th>
                                                    <th class="sort border-top" data-sort="Date limite"><b>Date
                                                            Limite</b></th>
                                                    <th class="sort border-top" data-sort="Créé par"><b>Créé par</b>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="djanotification">
                                                <tr>
                                                    <td colspan="8">
                                                        <h5 class="text-center text-secondery my-5">
                                                            @include('layout.partiels.load')
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-0 shadow-none">
                                <a href="#collapseFour" class="text-dark collapsed" data-bs-toggle="collapse"
                                    aria-expanded="false" aria-controls="collapseFour">
                                    <div class="card-header" id="headingThree">
                                        <h6 class="m-0">
                                           
                                          <b>BPC ({{ $bpcNombre }})</b> 
                                          <small>Résultat{{ $bpcNombre > 1 ? 's' : '' }}</small>


                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i> <br>
                                            Bon de Petite Caisse
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseFour" class="collapse" aria-labelledby="headingThree"
                                    data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="sort border-top"><b>#</b></th>
                                                    <th class="sort border-top" data-sort="febnum">
                                                        <b>
                                                            <center>N<sup>o</sup> DOC</center>
                                                        </b>
                                                    </th>
                                                    <th class="sort border-top" data-sort="montant"><b>
                                                            <center>Montant</center>
                                                        </b></th>
                                                    <th class="sort border-top" data-sort="Date Doc"><b>Date</b></th>
                                                    <th class="sort border-top" data-sort="Titre"><b>Titre</b></th>
                                                    <th class="sort border-top" data-sort="Créé le"><b>Créé le</b>
                                                    </th>

                                                    <th class="sort border-top" data-sort="Créé par"><b>Créé par</b>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="bpcnotification">
                                                <tr>
                                                    <td colspan="8">
                                                        <h5 class="text-center text-secondery my-5">
                                                            @include('layout.partiels.load')
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-0 shadow-none">
                                <a href="#collapseFive" class="text-dark collapsed" data-bs-toggle="collapse"
                                    aria-expanded="false" aria-controls="collapseFive">
                                    <div class="card-header" id="headingFive">
                                        <h6 class="m-0">
                                          <b>FAC ({{ $facNombre }})</b> 
                                          <small>Résultat{{ $facNombre > 1 ? 's' : '' }}</small>
                                          <i class="mdi mdi-minus float-end accor-plus-icon"></i> <br>
                                            Fiche d'Alimentation Caisse
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseFive" class="collapse" aria-labelledby="headingThree"
                                    data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="sort border-top"><b>#</b></th>
                                                    <th class="sort border-top" data-sort="febnum">
                                                        <b>
                                                            <center>N<sup>o</sup> DOC</center>
                                                        </b>
                                                    </th>
                                                    <th class="sort border-top" data-sort="montant"><b>
                                                            <center>Montant</center>
                                                        </b></th>
                                                    <th class="sort border-top" data-sort="Date Doc"><b>Date</b></th>
                                                    <th class="sort border-top" data-sort="Titre"><b>Titre</b></th>
                                                    <th class="sort border-top" data-sort="Créé le"><b>Créé le</b>
                                                    </th>

                                                    <th class="sort border-top" data-sort="Créé par"><b>Créé par</b>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="facnotification">
                                                <tr>
                                                    <td colspan="8">
                                                        <h5 class="text-center text-secondery my-5">
                                                            @include('layout.partiels.load')
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-0 shadow-none">
                                <a href="#collapseSix" class="text-dark collapsed" data-bs-toggle="collapse"
                                    aria-expanded="false" aria-controls="collapseSix">
                                    <div class="card-header" id="headingSix">
                                        <h6 class="m-0">
                                          <b>DAC ({{ $dacNombre }})</b> 
                                          <small>Résultat{{ $dacNombre > 1 ? 's' : '' }}</small>
                                          
                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i> <br>
                                            Demande d'Autorisation d'Alimentation de la Caisse
                                        </h6>
                                    </div>
                                </a>
                                <div id="collapseSix" class="collapse" aria-labelledby="headingSix"
                                    data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="sort border-top"><b>#</b></th>
                                                    <th class="sort border-top" data-sort="febnum">
                                                        <b>
                                                            <center>N<sup>o</sup> DOC</center>
                                                        </b>
                                                    </th>
                                                    <th class="sort border-top" data-sort="montant"><b>
                                                            <center>Montant</center>
                                                        </b></th>
                                                    <th class="sort border-top" data-sort="Date Doc"><b>Date</b></th>

                                                    <th class="sort border-top" data-sort="Créé le"><b>Créé le</b>
                                                    </th>

                                                    <th class="sort border-top" data-sort="Créé par"><b>Créé par</b>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="dacnotification">
                                                <tr>
                                                    <td colspan="8">
                                                        <h5 class="text-center text-secondery my-5">
                                                            @include('layout.partiels.load')
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                               
                            </div>

                            <div class="card mb-0 shadow-none">
                              <a href="#collapseSeven" class="text-dark collapsed" data-bs-toggle="collapse"
                                  aria-expanded="false" aria-controls="collapseSeven">
                                  <div class="card-header" id="headingSeven">
                                      <h6 class="m-0">

                                         <b>RAC ({{ $caisseNombre }})</b> 
                                        <small>Résultat{{ $caisseNombre > 1 ? 's' : '' }}</small>


                                          <i class="mdi mdi-minus float-end accor-plus-icon"></i> <br>
                                          Rapport de la Pétite  Caisse
                                      </h6>
                                  </div>
                              </a>
                              <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven"
                                  data-bs-parent="#accordion">
                                  <div class="card-body">
                                      <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                          <thead>
                                              <tr>
                                                  <th class="sort border-top"><b>#</b></th>
                                                  <th class="sort border-top" data-sort="febnum">
                                                      <b>
                                                          <center>N<sup>o</sup> DOC</center>
                                                      </b>
                                                  </th>
                                                  <th class="sort border-top" data-sort="montant"><b>
                                                          <center>Dernier Solde</center>
                                                      </b></th>
                                                  <th class="sort border-top" data-sort="Date Doc"><b>Date</b></th>

                                                  <th class="sort border-top" data-sort="Créé le"><b>Créé le</b>
                                                  </th>

                                                  <th class="sort border-top" data-sort="Créé par"><b>Créé par</b>
                                                  </th>
                                              </tr>
                                          </thead>
                                          <tbody id="racnotification">
                                              <tr>
                                                  <td colspan="8">
                                                      <h5 class="text-center text-secondery my-5">
                                                          @include('layout.partiels.load')
                                                  </td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                             
                             
                            </div>
                  
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
