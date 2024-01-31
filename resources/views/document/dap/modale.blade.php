<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

<a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#dapModale" ><span class="me-2" data-feather="plus-circle"></span>Nouvel fiche DAP</a></nav>

<div class="modal fade" id="dapModale" tabindex="-1" aria-labelledby="scrollingLongModalLabel2" style="display: none;" aria-hidden="true">
<div class="modal-dialog modal-xl modal-dialog-scrollable">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="scrollingLongModalLabel2">Demande et Autorisation de Paiement (DAP)</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg><!-- <span class="fas fa-times fs--1"></span> Font Awesome fontawesome.com --></button>
    </div>
    <div class="modal-body">
     
    <form class="row g-3 mb-6" method="POST" id="adddapForm">
    @method('post')
    @csrf
   
                <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;name&quot;,&quot;email&quot;,&quot;age&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm fs--1 mb-0">
                            <tbody class="list">

                            <tr>
                                    <td class="align-middle ps-3 name" style="width:20%"><b>Composante/ Projet/Section </b></td>
                                    <td class="align-middle email" colspan="6">
                                        <input value="{{ Session::get('id') }} " type="hidden" name="projetid" id="projetid" >
                                        <input value="{{ Session::get('title') }} " class="form-control" disabled  >     
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle ps-3 name"><b>Activité</b></td>
                                    <td class="align-middle email" colspan="6">
                                        <select type="text" class="form-control" name="activityid" id="activityid" style="width: 100%">
                                        <option value="">--Aucun--</option>
                                        @forelse ($activite as $activites)
                                            <option value="{{ $activites->id }}"> {{ $activites->titre }} </option>
                                        @empty
                                        <option value="">--Aucun activite trouver--</option>
                                        @endforelse
                                    </select>
                                    </td>
                                </tr>
                                <tr>
                                  <td class="align-middle ps-3 name"> <b>Numéro fiche </b></td>
                                  <td ><input type="text"  id="numerodap" name="numerodap" class="form-control"></td>
                                  <td class="align-middle ps-3 name" ><b> Service</b> </td>
                                
                                  <td class="align-middle email" colspan="6">
                                    <select type="text" class="form-control" name="serviceid" id="serviceid" style="width: 100%">
                                        <option value="">--Aucun--</option>
                                        @forelse ($service as $services)
                                            <option value="{{ $services->id }}"> {{ $services->title }} </option>
                                        @empty
                                        <option value="">--Aucun service trouver--</option>
                                        @endforelse
                                    </select>
                                    </td>
                                </tr>

                                                               <tr>
                                    <td class="align-middle ps-3 name"><b>Lieu </b>
                                    </td>
                                    <td class="align-middle email" colspan="1">
                                        <input type="text" class="form-control" name="lieu" id="lieu" style="width: 100%" />
                                    </td>

                                    <td class="align-middle ps-3 name"><b> Référence FEB nº:  </b>
                                    </td>

                                    <td class="align-middle email" style="width:30%">
                                    <select type="text" class="form-control" name="febid" id="febid" style="width: 100%">
                                        <option value="">--Aucun--</option>
                                        @forelse ($feb as $febs)
                                            <option value="{{ $febs->numerofeb }}"> {{ $febs->numerofeb }} </option>
                                        @empty
                                        <option value="">--Aucun Numero FEB trouver--</option>
                                        @endforelse
                                    </select>
                                    </td>

                                    <td class="align-middle ps-3 name"> <b>Taux d'exécution:</b></td>
                                    <td class="align-middle email" >
                                        <span> <b>100% </b> </span> 
                                    </td>
                                </tr>
                              
                                <tr>
                                <td class="align-middle ps-3 name" ><b>Etablie par : </b></td>
                                    <td class="align-middle email" colspan="2">
                                        <input type="text" class="form-control" value="{{ ucfirst(Auth::user()->nom) }}  {{ ucfirst(Auth::user()->prenom ) }}" disabled style="width: 100%">

                                        <input type="hidden" class="form-control" name="etabliepar" id="etabliepar" value="{{ ucfirst(Auth::id()) }} " disabled style="width: 100%">
                                    </td>

                                    <td class="align-middle ps-3 name"> <b>Ligne budgétaire:</b></td>
                                    <td class="align-middle email" colspan="2">

                                   
                                        <div class="col-sm-12 col-md-12">
                                        <div class="form-floating">
                                        <select class="form-select" id="ligneid" name="ligneid" required  onchange="soldeligne(this.value);">
                                            <option selected="selected" value="">Ligne budgetaire</option> 
                                            @foreach ($compte as $comptes)
                                                <option value="{{ $comptes->id }}"> {{ $comptes->numero }}. {{ $comptes->libelle }} </option>
                                                @php
                                                    $idc = $comptes->id ;
                                                    $res= DB::select("SELECT * FROM comptes  WHERE compteid= $idc");
                                                @endphp
                                                @foreach($res as $re)
                                                    <option value="{{ $re->id }}" > {{ $re->numero }}. {{ $re->libelle }}  </option>
                                                @endforeach 
                                            @endforeach
                                        </select>
                                        
                                        <label for="floatingInputGrid">Ligne budgetaire</label></div>
                                    </div>

                                   
                                   
                                    </td>
                                </tr>

                                <tr>
                                <td class="align-middle ps-3 name" ><b>Compte bancaire (BQ):</b>
                                </td>
                                    <td class="align-middle email" colspan="2">
                                        <input type="text" class="form-control" name="comptebanque" id="comptebanque" style="width: 100%">
                                    </td>

                                    <td class="align-middle ps-3 name"><b>Solde comptable BQ </b></td>
                                    <td class="align-middle email" colspan="2">
                                        <input type="text" class="form-control"  value="7 548 000 000 BIF" disabled>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                        <table class="table table-striped table-sm fs--1 mb-0">
                            <tbody class="list">
                            
                                <tr>
                                <td class="align-middle ps-3 name" ><b>OV  nº :</b>
                                </td>
                                    <td class="align-middle email" colspan="2">
                                        <input type="text" class="form-control" name="ov" id="ov" style="width: 100%">
                                    </td>

                                    <td class="align-middle ps-3 name"><b>CHQ nº  </b></td>
                                    <td class="align-middle email" colspan="2">
                                        <input type="text" class="form-control" name="ch" id="ch" style="width: 100%">
                                    </td>

                                    <td class="align-middle ps-3 name"><b>Etabli au nom de: </b></td>
                                    <td class="align-middle email" colspan="2">
                                    <select type="text" class="form-control" name="etablie_nom" id="etablie_nom">
                                                <option value="">--Selectionnez personnel--</option>
                                                @foreach ($personnel as $personnels)
                                                    <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                                @endforeach
                                            </select>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>

                        <hr>
                        <div class="table-repsonsive">
                          <span id="error"></span>
                          <table class="table table-bordered" id="item_table">
                            <tr>
                              <th style="width:5%">N<sup>O</sup></th>
                              <th>Description</th>
                              <th style="width:20%">Montant</th>
                              <th style="width:5% ;"><button type="button" name="add" class="btn btn-success btn-sm add"><i class="fas fa-plus"></i></button></th>
                            </tr>
                          </table>
                        </div>
                        <hr>
                                <table class="table table-striped table-sm fs--1 mb-0" style="padding:2px">
                                    <tr>
                                    <tr>
                                        <td colspan="4"><b> Vérification et Approbation de la Demande de paiement </b></td>
                                      
                                    </tr>
                                    <tr>
                                        <td> <b> Demande établie par </b>  </td>
                                        <td> <b> Chef de Composante/Projet/Section </b> </td>
                                        <td> <b> <center> Signature:</center> </b> </td>
                                        <td> <b> <center> Date:</center> </b> </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select type="text" class="form-control" name="demandeetablie" id="demandeetablie">
                                                <option value="">--Selectionnez personnel--</option>
                                                @foreach ($personnel as $personnels)
                                                    <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                        <select type="text" class="form-control" name="chefComposante" id="chefComposante">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select>
                                                </td>
                                        <td>
                                            <center>   
                                                <input  class="form-check-input" type="checkbox" name="signaturechef" id="signaturechefC" /> 
                                            </center>
                                        
                                        </td>
                                        <td>
                                            <input class="form-control" id="basic-form-dob" type="date" name="datechefcomposante" id="datechefcomposante" />
                                        </td>
                                        </tr>


                                        <tr>
                                        <td> <b> Vérifiée par :</b> </td>
                                        <td> <b> Chef Comptable </b> </td>
                                        <td> <b> <center> Signature:</center> </b></td>
                                        <td> <b> <center> Date:</center> </b> </td>
                                        </tr>
                                        <tr>
                                        <td>
                                            <select type="text" class="form-control" name="verifier" id="verifier">
                                                <option value="">--Selectionnez personnel--</option>
                                                @foreach ($personnel as $personnels)
                                                    <option value="{{ $personnels->id }}">{{ $personnels->prenom }} {{ $personnels->prenom }}</option>  
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                        <select type="text" class="form-control" name="chefcomptable" id="chefcomptable">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}">{{ $personnels->prenom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select>
                                                </td>
                                        <td>
                                            <center>   <input   class="form-check-input" type="checkbox" id="signaturechefcomptable" name="signaturechefcomptable" /> </center>
                                        
                                        </td>
                                        <td>
                                            <input class="form-control" id="basic-form-dob" id="datechefcomptable" name="datechefcomptable" type="date" />
                                        </td>
                                        </tr>


                                        <tr>
                                        <td> <b> Approuvée par  : </b> </td>
                                        <td> <b> Chef de Service  </b></td>
                                        <td> <b> <center> Signature:</center> </b></td>
                                        <td> <b> <center> Date:</center> </b></td>
                                        </tr>
                                         <tr>
                                        <td>
                                            <select type="text" class="form-control" name="approuver" id="approuver">
                                                <option value="">--Selectionnez personnel--</option>
                                                @foreach ($personnel as $personnels)
                                                    <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                        <select type="text" class="form-control" name="chefservice" id="chefservice">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select>
                                                </td>
                                        <td>
                                            <center>   <input  class="form-check-input" type="checkbox" name="signaturechefservice" id="signaturechefservice" /> </center>
                                        </td>
                                        <td>
                                            <input class="form-control" id="basic-form-dob" type="date"  id="datechefservice" name="datechefservice"/>
                                        </td>
                                        </tr>


                                        <tr>
                                        <td> <b> Responsable Administratif et Financier    :  </b></td>
                                        <td> <b> Secrétaire Général  de la CEPBU  </b></td>
                                        <td> <b> <center> Autorisé le</center> </b></td>
                                        <td> <b> Chef des Programmes  </b> </td>
                                        </tr>
                                         <tr>
                                        <td>
                                            <select type="text" class="form-control" name="resposablefinancier" id="resposablefinancier">
                                                <option value="">--Selectionnez personnel--</option>
                                                @foreach ($personnel as $personnels)
                                                    <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select type="text" class="form-control" name="secretairegenerale" id="secretairegenerale">
                                                <option value="">--Selectionnez personnel--</option>
                                                @foreach ($personnel as $personnels)
                                                    <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <center> <input class="form-control" id="basic-form-dob" type="date" id="datesecretairegenerale" name="datesecretairegenerale" /></center>
                                        </td>

                                        <td>
                                            <select type="text" class="form-control" name="chefprogramme" id="chefprogramme">
                                                <option value="">--Selectionnez personnel--</option>
                                                @foreach ($personnel as $personnels)
                                                    <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                                @endforeach
                                            </select>
                                        </td>
                                        </tr>


                                        <tr>
                                        <td colspan="4"><b>Observations/Instructions du SG   : </b></td>
                                        
                                        </tr>
                                         <tr>
                                        <td colspan="4">
                                            <textarea  class="form-control" name="observation"></textarea>
                                        </td>
                                        
                                        </tr>

                                    </table>
                       
                    </div>
                </div>
           
    
  </div>
    <div class="modal-footer">
      <button type="submit"  class="btn btn-primary"  id="adddapbtn" name="addapbtn"  >Sauvegarder</button>
   </div>
   </form>
  </div>
</div>
</div>
