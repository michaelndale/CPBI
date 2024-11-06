<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <span style="color:#3CB371">
                    <i class="fas fa-spinner fa-spin"></i> Chargement en cours...
                </span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addfebModal" tabindex="-1" aria-labelledby="addfebModal" aria-hidden="true">
    <div class="modal-dialog modal-xl  modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="far fa-file-alt "></i> FICHE D’EXPRESSION DES BESOINS "FEB" </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 mb-6" method="POST" id="addfebForm">
                    @method('post')
                    @csrf
                    <div id="tableExample2">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm fs--1 mb-0">
                                <tbody class="list">
                                    <tr>
                                        <td class="align-middle ps-3 name" style="width:15%">Composante/ Projet/Section</td>
                                        <td class="align-middle email" colspan="15" style="width:55%"> 
                                            <input value="{{ Session::get('id') }} " type="hidden" name="projetid" id="projetid">
                                            <input value="{{ Session::get('title') }} " class="form-control form-control-sm" disabled>
                                        </td>
                                        <td rowspan="2" style="width:40%">

                                            Référence des documents à attacher

                                            <select class="form-control form-control-sm" id="annex" name="annex[]" multiple>
                                                <option disabled selected value="">-- Sélectionner les documents attachés --</option>
                                                @foreach ($attache as $attaches)
                                                    <option value="{{ $attaches->id }}">{{ $attaches->libelle }}</option>
                                                @endforeach    
                                            </select>
                                            

                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td class="align-middle ps-3 name">Ligne budgétaire: <span class="text-danger">*</span></td>
                                        <td class="align-middle email" colspan="15">
                                            <select class="form-control  form-control-sm ligneid" id="referenceid" name="referenceid" required>
                                                <option disabled="true" selected="true" value="">Sélectionner la ligne budgétaire</option>
                                                @foreach ($compte as $comptes)
                                                <optgroup label="{{ $comptes->libelle }}">
                                                    @php
                                                    $idc = $comptes->id ;
                                                    $res= DB::select("SELECT * FROM comptes WHERE compteid= $idc");
                                                    @endphp
                                                    @foreach($res as $re)
                                                    <option value="{{ $comptes->id }} - {{ $re->id }}"> {{ $re->numero }}. {{ $re->libelle }} </option>
                                                    @endforeach
                                                </optgroup>
                                                @endforeach
                                            </select>
                                            <div id="showcondition">
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="align-middle ps-3 name">Activités <span class="text-danger">*</span></td>
                                        <td colspan="8">
                                            <input type="text" class="form-control form-control-sm" name="descriptionf" id="descriptionf" required>
                                        </td>
                                        <td class="align-middle ps-3 name">Bénéficiaire </td>
                                        <td colspan="8">
                                            <select class="form-control  form-control-sm" id="beneficiaire" name="beneficiaire">
                                                <option disabled="true" selected="true" value="">--Sélectionner bénéficiaire--</option>';
                                                @foreach ($beneficaire as $beneficaires)
                                                <option value="{{ $beneficaires->id }}">{{ $beneficaires->libelle }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle ps-3 name" colspan="1" ></td>
                                        <td class="align-middle ps-3 name" colspan="3">
                                            Numéro du fiche FEB<span class="text-danger">*</span> <br>
                                            <input type="number" name="numerofeb" id="numerofeb" class="form-control form-control-sm" style="width: 100% ;">
                                            <smal id="numerofeb_error" name="numerofeb_error" class="text text-danger"> </smal>
                                            <smal id="numerofeb_info" class="text text-primary"> </smal>
                                        </td>
                                        <td class="align-middle ps-3 name">Période:<span class="text-danger">*</span><br>
                                            <select type="text" class="form-control form-control-sm" name="periode" id="periode" style="width: 100%" required>
                                                @php
                                                $periode= Session::get('periode')
                                                @endphp
                                                @for($i =1 ; $i <= $periode ; $i++ ) <option value="T{{$i}}"> T{{$i}} </option>
                                                    @endfor
                                            </select>
                                        </td>
                                        <td class="align-middle ps-3 name"> Date du dossier FEB:<span class="text-danger">*</span><br>
                                            <input type="date" class="form-control form-control-sm" name="datefeb" id="datefeb" style="width: 100%" required>
                                        </td>
                                        <td class="align-middle ps-3 name"> Date limite:<span class="text-danger">*</span><br>
                                            <input type="date" class="form-control form-control-sm" name="datelimite" id="datelimite" style="width: 100%">
                                        </td>
                                        
                                      
                                    
                                      
                                    </tr>
                                  <!--  <tr>
                                        <td class="align-middle ps-3 name" colspan="1"></td>
                                        <td class="align-middle ps-3 name" style="width:4%">
                                            <center><label title="Bon de commande">B.C</label><br>
                                                <input type="checkbox" class="form-check-input" name="bc" id="bc">
                                            </center>
                                        </td>
                                        <td class="align-middle ps-3 name" style="width:5%">
                                            <center><label>Facture </label> <br>
                                                <input type="checkbox" class="form-check-input" name="facture" id="facture">
                                            </center>
                                        </td>

                                        <td class="align-middle ps-3 name" style="width:4%">
                                            <center><label title="Ordre de mission">O.M </label><br>
                                                <input type="checkbox" class="form-check-input" name="om" id="om">
                                            </center>
                                        </td>

                                        <td class="align-middle ps-3 name" style="width:4%">
                                            <center><label title="Procès-verbal d'analyse">P.V.A</label><br>
                                                <input type="checkbox" class="form-check-input" name="nec" id="nec">
                                            </center>
                                        </td>

                                        <td class="align-middle ps-3 name" style="width:4%">
                                            <center><label title="Facture Proformat">F.P</label><br>
                                                <input type="checkbox" class="form-check-input" name="fp" id="fp">
                                            </center>
                                        </td>
                                        <td class="align-middle ps-3 name" style="width:4%">
                                            <center><label>Devis/Liste</label> <br>
                                                <input type="checkbox" class="form-check-input" name="fpdevis" id="fpdevis">
                                            </center>
                                        </td>
                                        <td class="align-middle ps-3 name" style="width:4%">
                                            <center><label title="Rapport de mission">R.M</label> <br>
                                                <input type="checkbox" class="form-check-input" name="rm" id="rm">
                                            </center>
                                        </td>
                                        <td class="align-middle ps-3 name" style="width:4%">
                                            <center><label title="Terme de référence">T.D.R</label> <br>
                                                <input type="checkbox" class="form-check-input" name="tdr" id="tdr">
                                            </center>
                                        </td>
                                        <td class="align-middle ps-3 name" style="width:4%">
                                            <center><label title="Bordereau de versement">B.V</label> <br>
                                                <input type="checkbox" class="form-check-input" name="bv" id="bv">
                                            </center>
                                        </td>
                                        <td class="align-middle ps-3 name" style="width:4%">
                                            <center><label title="Reçu">Reçu</label> <br>
                                                <input type="checkbox" class="form-check-input" name="recu" id="recu">
                                            </center>
                                        </td>
                                        <td class="align-middle ps-3 name" style="width:4%">
                                            <center><label title="Accussé de reception">A.R</label> <br>
                                                <input type="checkbox" class="form-check-input" name="ar" id="ar">
                                            </center>
                                        </td>

                                        <td class="align-middle ps-3 name" style="width:4%">
                                            <center><label title="Bordereau d'expédition">B.E</label> <br>
                                                <input type="checkbox" class="form-check-input" name="br" id="br">
                                            </center>
                                        </td>
                                        <td class="align-middle ps-3 name" style="width:4%">
                                            <center><label title="Appel à la participation à la construction du CFK">A.P.C</label> <br>
                                                <input type="checkbox" class="form-check-input" name="apc" id="apc">
                                            </center>
                                        </td>
                                        <td class="align-middle ps-3 name" style="width:4%">
                                            <center><label title="Rapport d'activités">R.A</label> <br>
                                                <input type="checkbox" class="form-check-input" name="ra" id="ra">
                                            </center>
                                        </td>
                                        <td class="align-middle ps-3 name" style="width:4%">
                                            <center><label title="Autres document">Autres</label> <br>
                                                <input type="checkbox" class="form-check-input" name="autres" id="autres">
                                            </center>
                                        </td>
                                    </tr>  -->
                                </tbody>
                            </table>
                           
                            <div class="table-responsive">
                                <table class="table table-striped table-sm fs--1 mb-0" id="tableEstimate">
                                    <thead style="background-color:#3CB371; color:white">
                                        <tr>
                                            <th style="width:80px; color:white"><b>Num<span class="text-danger">*</span></b></th>
                                            <th style="  color:white"><b> Designation des activités de la ligne<span class="text-danger">*</span> </b></th>
                                            <th style=" color:white"> <b> Description<span class="text-danger">*</span></b></th>
                                            <th style="width:150px;  color:white"><b>Unité<span class="text-danger">*</span></b></th>
                                            <th style="width:100px ;  color:white"><b>Q<sup>té <span class="text-danger">*</span></b></sup></th>
                                            <th style="width:52px; color:white"><b>Frequence<span class="text-danger">*</span></b></th>
                                            <th style="width:130px;  color:white"><b>P.U<span class="text-danger">*</span> </b></th>
                                            <th style="width:150px;  color:white"><b>P.T<span class="text-danger">*</span></b></th>

                                            <th> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input style="width:100%" type="number" id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="1"></td>
                                            <td>
                                                <div id="Showpoll" class="Showpoll">
                                                    <select style="width:100%" type="text" class="form-control form-control-sm">
                                                        <option disabled="true" selected="true">Aucun</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td><input style="width:100%" type="text" id="libelle_description" name="libelle_description[]" class="form-control form-control-sm" required></td>
                                            <td><input style="width:100%" type="text" id="unit_cost" name="unit_cost[]" class="form-control form-control-sm unit_price" required></td>
                                            <td><input style="width:100%" type="text" id="qty" name="qty[]" class="form-control form-control-sm qty" required></td>
                                            <td><input style="width:100%" type="number" id="frenquency" min="1" name="frenquency[]" class="form-control form-control-sm frenquency" required></td>
                                            <td><input style="width:100%" type="number" id="pu" name="pu[]" min="0" class="form-control form-control-sm pu" required></td>
                                            <td><input style="width:100%" type="number" min="0" id="amount" name="amount[]" class="form-control form-control-sm total" value="0" readonly></td>

                                            <td><a href="javascript:void(0)" class="text-primary font-18" title="Add" id="addBtn"><i class="fa fa-plus-circle"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-striped table-sm fs--1 mb-0">
                                    <tfoot style="background-color:#c0c0c0">
                                        <tr>
                                            <td colspan="8">Total global </td>
                                            <td align="right"><span class="total-global">0.00 {{ Session::get('devise') }} </span></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <hr>
                            </div>
                            <div class="table-repsonsive">
                                <span id="error"></span>
                                <table class="table table-striped table-sm fs--1 mb-0">
                                    <tr>
                                    <tr>
                                        <td>Etablie par (AC/CE/CS) <span class="text-danger">*</span> </td>
                                        <td>Vérifiée par (Comptable) <span class="text-danger">*</span></td>
                                        <td>Approuvée par (Chef de Composante/Projet/Section): <span class="text-danger">*</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select type="text" class="form-control form-control-sm" name="acce" id="acce" required>
                                                <option disabled="true" selected="true" value="">--Sélectionner (AC/CE/CS)--</option>
                                                @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select type="text" class="form-control form-control-sm" name="comptable" id="comptable" required>
                                                <option disabled="true" selected="true" value="">--Sélectionner comptable--</option>
                                                @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select type="text" class="form-control form-control-sm" name="chefcomposante" id="chefcomposante" required>
                                                <option disabled="true" selected="true" value="">--Sélectionner Chef de Composante/Projet/Section--</option>
                                                @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->userid }}"> {{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="addfebbtn" name="addfebbtn"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
            </div>
            </form>
        </div>
    </div>
</div>