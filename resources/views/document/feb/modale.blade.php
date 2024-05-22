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
                                        <td class="align-middle ps-3 name" style="width:20%">Composante/ Projet/Section</td>
                                        <td class="align-middle email" colspan="8">
                                            <input value="{{ Session::get('id') }} " type="hidden" name="projetid" id="projetid">
                                            <input value="{{ Session::get('title') }} " class="form-control form-control-sm" disabled>
                                        </td>
                                    </tr>
                                    <tr>

                                        <td class="align-middle ps-3 name">Ligne budgétaire: </td>
                                        <td class="align-middle email" colspan="8">



                                            <select class="form-control  form-control-sm ligneid" id="referenceid" name="referenceid" required>
                                                <option value="">Sélectionner la ligne budgétaire</option>
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

                                    </tr>

                                    </tr>
                                    <tr>
                                        <td class="align-middle ps-3 name">Activités </td>
                                        <td colspan="4">
                                            <input type="text" class="form-control form-control-sm" name="descriptionf" id="descriptionf" required>
                                        </td>

                                        <td class="align-middle ps-3 name" colo>Bénéficiaire </td>
                                        <td colspan="3">


                                            <select class="form-control  form-control-sm" id="beneficiaire" name="beneficiaire" >
                                                <option disabled="true" selected="true">--Sélectionner bénéficiaire--</option>';
                                                @foreach ($beneficaire as $beneficaires)
                                                <option value="{{ $beneficaires->id }}">{{ $beneficaires->libelle }}</option>
                                                @endforeach
                                            </select>
                                        </td>



                                    </tr>
                                    <tr>
                                        <td class="align-middle ps-3 name">Numéro fiche <br>
                                            <input type="number" name="numerofeb" id="numerofeb" class="form-control form-control-sm" style="width: 100% ;">
                                            <smal id="numerofeb_error" name="numerofeb_error" class="text text-danger"> </smal>
                                            <smal id="numerofeb_info" class="text text-primary"> </smal>
                                        </td>

                                        <td class="align-middle ps-3 name">Période: <br>
                                            <select type="text" class="form-control form-control-sm" name="periode" id="periode" style="width: 100%" required>
                                                @php
                                                $periode= Session::get('periode')
                                                @endphp
                                                @for($i =1 ; $i <= $periode ; $i++ ) <option value="T{{$i}}"> T{{$i}} </option>
                                                    @endfor
                                            </select>
                                        </td>

                                        <td class="align-middle ps-3 name"> Date du dossier FEB: <br>
                                            <input type="date" class="form-control form-control-sm" name="datefeb" id="datefeb" style="width: 100%" required>
                                        </td>

                                        <td class="align-middle ps-3 name"> Date limite: <br>
                                            <input type="date" class="form-control form-control-sm" name="datelimite" id="datelimite" style="width: 100%">
                                        </td>

                                        <td class="align-middle ps-3 name" style="width:8%">
                                            <center>BC:<br>
                                                <input type="checkbox" class="form-check-input" name="bc" id="bc">
                                            </center>
                                        </td>

                                        <td class="align-middle ps-3 name" style="width:8%">
                                            <center>Facture: <br>
                                                <input type="checkbox" class="form-check-input" name="facture" id="facture">
                                            </center>
                                        </td>

                                        <td class="align-middle ps-3 name" style="width:8%">
                                            <center>O.M: <br>
                                                <input type="checkbox" class="form-check-input" name="om" id="om">
                                            </center>
                                        </td>

                                        <td class="align-middle ps-3 name" style="width:8%">
                                            <center>NEC: <br>
                                                <input type="checkbox" class="form-check-input" name="nec" id="nec">
                                            </center>
                                        </td>

                                        <td class="align-middle ps-3 name" style="width:8%">
                                            <center>FP/Devis <br>
                                                <input type="checkbox" class="form-check-input" name="fpdevis" id="fpdevis">
                                            </center>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <hr>



                            <div class="table-responsive">
                                <table class="table table-hover table-white" id="tableEstimate">
                                    <thead>
                                        <tr>
                                            <th style="width:80px">Num</th>
                                            <th>Designation de la ligne</th>
                                            <th>Description</th>
                                            <th style="width:150px">Unité</th>
                                            <th style="width:100px">Q<sup>té</sup></th>
                                            <th style="width:50px">Frequence</th>
                                            <th style="width:130px">P.U</th>
                                            <th style="width:150px">P.T</th>

                                            <th> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input style="width:100%" type="number" id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="1"></td>
                                            <td>
                                                <div id="Showpoll" class="Showpoll">
                                                    <select style="width:100%" type="text" class="form-control form-control-sm">
                                                        <option>Aucun</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td><input style="width:100%" type="text" id="libelle_description" name="libelle_description[]" class="form-control form-control-sm" required></td>
                                            <td><input style="width:100%" type="text" id="unit_cost" name="unit_cost[]" class="form-control form-control-sm unit_price" required></td>
                                            <td><input style="width:100%" type="text" id="qty" name="qty[]" class="form-control form-control-sm qty" required></td>
                                            <td><input style="width:100%" type="text" id="frenquency" name="frenquency[]" class="form-control form-control-sm frenquency" required></td>
                                            <td><input style="width:100%" type="text" id="pu" name="pu[]" class="form-control form-control-sm pu" required></td>
                                            <td><input style="width:100%" type="text" id="amount" name="amount[]" class="form-control form-control-sm total" value="0" readonly></td>

                                            <td><a href="javascript:void(0)" class="text-primary font-18" title="Add" id="addBtn"><i class="fa fa-plus-circle"></i></a></td>
                                        </tr>

                                        <tr>

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
                                        <td>Etablie par (AC/CE/CS) </td>
                                        <td>Vérifiée par (Comptable)</td>
                                        <td>Approuvée par (Chef de Composante/Projet/Section):</td>
                                    </tr>
                                    <tr>
                                        <td>



                                            <select type="text" class="form-control form-control-sm" name="acce" id="acce" required>
                                                <option value="">--Sélectionner (AC/CE/CS)--</option>
                                                @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                @endforeach
                                            </select>



                                        </td>
                                        <td>
                                            <select type="text" class="form-control form-control-sm" name="comptable" id="comptable" required>
                                                <option value="">--Sélectionner comptable--</option>
                                                @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select type="text" class="form-control form-control-sm" name="chefcomposante" id="chefcomposante" required>
                                                <option value="">--Sélectionner Chef de Composante/Projet/Section--</option>
                                                @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->userid }}"> {{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                @endforeach
                                            </select>
                                        </td>


                                    </tr>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="addfebbtn" name="addfebbtn"> <i class="fa fa-cloud-upload-alt"></i>  Sauvegarder</button>
            </div>
            </form>
        </div>
    </div>
</div>