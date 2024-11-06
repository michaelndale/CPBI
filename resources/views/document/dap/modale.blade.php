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

<div class="modal fade" id="dapModale" tabindex="-1" aria-labelledby="dapModale" aria-hidden="true">
    <div class="modal-dialog modal-xl  modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="far fa-file-alt "></i> Demande d'Autorisation de Paiement (DAP) </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form class="row g-3 mb-6" method="POST" id="adddapForm">
                    @method('post')
                    @csrf

                    <div id="tableExample2">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm fs--1 mb-0">
                                <tbody  >
                                    <tr>
                                        <td style="width:300px"> Service <br>
                                            <select type="text" name="serviceid" id="serviceid" style="width: 100%" class="form-control form-control-sm" required>
                                                <option disabled="true" selected="true" value="">--Aucun--</option>
                                                @forelse ($service as $services)
                                                <option value="{{ $services->id }}"> {{ $services->title }} </option>
                                                @empty
                                                <option disabled="true" selected="true" value="">--Aucun service trouver--</option>
                                                @endforelse
                                            </select>
                                        </td>

                                        <td colspan="6">
                                            <b>Composante/ Projet/Section </b><br>
                                            <input value="{{ Session::get('id') }}" type="hidden" name="projetid" id="projetid" required>
                                            <input value="{{ Session::get('title') }}" class="form-control form-control-sm" disabled>
                                        </td>


                                        <td class="align-middle" style="width:20% ;  background: rgba(76, 175, 80, 0.3)" rowspan="2">
                                            <b>NUMERO FEB: </b> <br>
                                            <select type="text" class="form-control form-control-sm febid" style="width: 100%" required multiple>
                                                <option disabled="true" selected="true">--Aucun--</option>
                                                @forelse ($feb as $febs)
                                                <option value="{{ $febs->id }}"> {{ $febs->numerofeb }}</option>
                                                @empty
                                                <option  disabled="true" selected="true">--Aucun numéro FEB trouvé--</option>
                                                @endforelse
                                            </select>
                                        </td>

                         
                                <tr>

                                    <td> Numéro du DAP
                                        <input type="text" name="numerodap" id="numerodap" style="width: 100%" class="form-control form-control-sm" required />
                                        <smal id="numerodap_error" name="numerodap_error" class="text text-danger"> </smal>
                                        <smal id="numerodap_info" class="text text-primary"> </smal>
                                    </td>

                                    <td> Lieu
                                        <input type="text" name="lieu" id="lieu" style="width: 100%" class="form-control form-control-sm" required />
                                    </td>

                                    <td> Compte bancaire (BQ):
                                        <input type="text" class="form-control form-control-sm" name="comptebanque" id="comptebanque" style="width: 100%" required>
                                    </td>

                                    <td> Solde comptable dd(Sc):
                                        <input type="text" min="0" class="form-control form-control-sm" name="soldecompte" value="{{ $somfeb }}" style="background-color:#c0c0c0" disabled>
                                    </td>

                                    <td> OV/Numéro cheque :
                                        <input type="text" name="ch" id="ch" class="form-control form-control-sm">
                                    </td>

                                  
                                    <td> Etabli au nom de: 
                                        <input type="text" name="paretablie" id="paretablie" class="form-control form-control-sm">
                                    </td>

                                    <td> Banque :
                                    <select type="text" class="form-control form-control-sm" name="banque" id="banque">
                                        <option disabled="true" selected="true" value="">-- Sélectionner --</option>
                                        @foreach ($banque as $banques)
                                            <option value="{{ $banques->libelle }}">{{ ucfirst($banques->libelle) }}</option>
                                        @endforeach
                                    </select>

                                    </td>


                                </tr>

                            </table>

                       

                            <div id="Showpoll" class="Showpoll">
                                <h6 style="margin-top:1% ;color:#c0c0c0">
                                    <center>
                                        <font size="5px"><i class="fa fa-search"></i> </font><br>
                                        En attente ... <br> Veuillez Sélectionner le NUMERO FEB:
                                    </center>
                                </h6>
                            </div>

                            <hr>
                            <table class="table table-striped table-sm fs--1 mb-0 table-bordered">

                                <tr>
                                    <td colspan="5">Ce montant est-il une avance ? &nbsp; &nbsp; &nbsp; Oui <input type="checkbox" class="form-check-input" name="justifier" id="justifier"> &nbsp; &nbsp; &nbsp; Non <input type="checkbox" class="form-check-input" name="nonjustifier" id="nonjustifier"></td>

                                </tr>
                            </table>
                            <table class="table table-striped table-sm fs--1 mb-0 table-bordered" id="facture-column" style="display: none; width:100%">
                                 <tr> 
                                  
                                </tr> 
                            </table>

                            <div id="Showretour" style="display: none;">

                            </div>

                            <div id="Shownonretour" style="display: none;">
                                <input type="text" class="form-control form-control-sm" name="">
                            </div>



                            <br>


                            <table class="table table-striped table-sm fs--1 mb-0 table-bordered">

                                <tr>
                                    <td colspan="3"><b> Vérification et Approbation de la Demande de paiement </b></td>
                                </tr>
                                <tr>
                                    <td> <b> Demande établie par </b> <br>
                                        <small> Chef de Composante/Projet/Section </small>  
                                    </td>

                                    <td> <b> Vérifiée par :</b> <br>
                                        <small> Chef Comptable</small>
                                         
                                    </td>

                                    <td> <b> Approuvée par : </b> <br>
                                        <small>Chef de Service</small>
                                         
                                    </td>


                                </tr>
                                <tr>

                                    <td>
                                        <select type="text" class="form-control form-control-sm" name="demandeetablie" id="demandeetablie" required>
                                            <option disabled="true" selected="true" value="">-- Chef de Composante/Projet/Section --</option>
                                            @foreach ($personnel as $personnels)
                                            <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select type="text" class="form-control form-control-sm" name="verifier" id="verifier" required>
                                            <option disabled="true" selected="true" value="">--Chef Comptable--</option>
                                            @foreach ($personnel as $personnels)
                                            <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </td>


                                    <td>
                                        <select type="text" class="form-control form-control-sm" name="approuver" id="approuver" required>
                                            <option disabled="true" selected="true" value="">--Chef de Service --</option>
                                            @foreach ($personnel as $personnels)
                                            <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>

                          

                                <tr>
                                    <td colspan="3"><b> Autorisaction de paiement</b></td>

                                </tr>

                                </tr>

                                <tr>
                                   
                                    <td>
                                        Responsable Administratif et Financier : <br>
                                        <select type="text" class="form-control form-control-sm" name="resposablefinancier" id="resposablefinancier" required>
                                            <option disabled="true" selected="true" value="">--Sélectionner un personnel--</option>
                                            @foreach ($personnel as $personnels)
                                            <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        Secrétaire Général de la CEPBU : <br>
                                        <select type="text" class="form-control form-control-sm" name="secretairegenerale" id="secretairegenerale" required>
                                            <option disabled="true" selected="true" value="">--Sélectionner un personnel--</option>
                                            @foreach ($personnel as $personnels)
                                            <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </td>


                                    <td>
                                        Chef des Programmes </br>
                                        <select type="text" class="form-control form-control-sm" name="chefprogramme" id="chefprogramme" required>
                                            <option disabled="true" selected="true" value="">--Sélectionner un personnel--</option>
                                            @foreach ($personnel as $personnels)
                                            <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>

                            </table>

                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="adddapbtn" name="adddapbtn"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                    </div>
                </form>
        </div>
    </div>
</div>