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

<div class="modal fade" id="djaModale" tabindex="-1" aria-labelledby="djaModale" style="display: none;" aria-hidden="true" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog modal-xl  modal-fullscreen modal-dialog-scrollable">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" >DEMANDE DE JUSTIFICATION D'AVANCE (DJA)</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
    </div>
    <div class="modal-body">
     
    <form class="row g-3 mb-6" method="POST" id="addjdaForm">
        @method('post')
        @csrf
    
            <div class="row" style="padding:2px">
                <h5> Demande d'une avance</h5>
               
             <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">

                    <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
                            <tbody class="list">
                                <tr>
                                    <td colspan="2"><b>Présumé Bénéficiaire/Fournisseur/Prestataire à payer:</b>
                                        <input type="text" name="benef" id="benef" class="form-control form-control-sm">
                            
                                    <input value="{{ Session::get('id') }}" type="hidden" name="projetid" id="projetid" required>

                                    <input value="1" name="numerodja" id="numerodja" type="hidden"  />
                                    
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">Adresse :
                                    <input type="text" name="adresse"  id ="adresse" class="form-control form-control-sm"> </td>
                                </tr>

                                <tr>
                                    <td>Telephone : <input type="text" name="tel" id="tel" class="form-control form-control-sm"> </td>
                                    <td>Telephone 2 : <input type="text" name="tel2" id="tel2" class="form-control form-control-sm"> </td>
                                </tr>

                                <tr>
                                    <td colspan="2">Description
                                        <textarea type="" name="description" id="description" class="form-control form-control-sm"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                    </table>
                    </div>
                    </div>
                </div>
                <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">

                    <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
                            <tbody class="list">
                                <tr>
                                    <td colspan="3"> <b>Les fonds devront être reçus le :</b>
                                        <input type="date" name="daterecufond" id= "daterecufond" class="form-control form-control-sm" style="width:33%">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Référence (s) : FEB Nº <input type="text" name="numfeb"  id="numfeb" class="form-control form-control-sm"> </td>
                                    <td>DAP Nº<input type="text" name="dapnumero" id="dapnumero" class="form-control form-control-sm"> </td>
                                    <td>OV/CHQ Nº <input type="text" name="ov" id="ov" class="form-control form-control-sm"> </td>
                                </tr>

                                <tr>
                                    <td colspan="3">Ligne budgetaire
                                    <input type="number" name="lignebudget" id="lignebudget" class="form-control form-control-sm">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Montant de l'avance<input type="number" name="montantavence" id="montantavence" class="form-control form-control-sm"> </td>
                                    <td>Devise (BIF ou USD)<input type="text" name="devise" id="devise" class="form-control form-control-sm"> </td>
                                    <td>Duree de l'avance jours<input type="number" name="dureavence" id="dureavence" class="form-control form-control-sm"> </td>
                                </tr>
                            </tbody>
                    </table>
                            
                    </div>
                    </div>
                </div>
            </div>

            <div id="tableExample2" >
                    <div class="table-responsive">
                       
                        <table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:80%; margin:auto ">
                        <tbody class="list">
                                <tr>
                                    <td class="align-middle ps-3 name" colspan="3"> <b>Demande/Approbation</b>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name"> 
                                        Fonds demandés par: <br> Nom:<br>
                                        <select type="text" class="form-control form-control-sm" name="fonddemandepar" id="fonddemandepar">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}"> {{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select>
                                    </td>

                                


                                  
                                </tr>

                                <tr>
                                    <td colspan="3"> 
                                    <b>Avance Approuvée par (2 personnes au moins) : </b>
                                    </td>
                                </tr>
                                <tr>

                                    <td class="align-middle ps-3 name"> 
                                   
                                     Nom: <br> Chef Comptable (Si A< 500 000 Fbu)
                                    <select type="text" class="form-control form-control-sm" name="chefcomptable" id="chefcomptable">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select>
                                   
                                    </td>

                                  
                               
                                    <td class="align-middle ps-3 name"> 
                                     Nom:<br>
                                   
                                     RAF (Si A < 1000 000 Fbu)  
                                     <select type="text" class="form-control form-control-sm" name="raf" id="raf">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select> 
                                   
                                    </td>

                                  
                               
                                    <td class="align-middle ps-3 name"> 
                                     Nom:<br>
                                    
                                    SG ou SGA (Si  A>1000 000 Fbu)
                                    <select type="text" class="form-control form-control-sm" name="sga" id="sga">
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
                        
                        <table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:80%; margin:auto ">
                            
                        <tbody>
                                <tr>
                                    
                                    <td  colspan="3"> 
                                        <b>Fonds déboursés par: </b> <br> Nom:<br>
                                    <select type="text" class="form-control form-control-sm" name="fonddebourser" id="fonddebourser">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select>
                                    </td>

                                   

                                  
                                  
                              
                                    <td class="align-middle ps-3 name"> 
                                    <b>Fonds reçus par: </b> <br> Nom:<br>
                                    <select type="text" class="form-control form-control-sm" name="fondresu" id="fondresu">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select>
                                    </td>

                                  
                                   

                                 
                                </tr>

                                
                                </tbody>
                        </table>
                    
                    </div>
                </div>
                <div class="row" style="padding:10px">
                <h5><b>Rapport d'utilisation de l'avance</b>  </h5>
             <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">

                    <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
                            <tbody class="list">
                                <tr>
                                    <td colspan="3"><b>Fonds payes a</b>
                                        <input type="" id="fondpaye" name="fondpaye" class="form-control form-control-sm">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3">Adresse :
                                    <input type="" name="utiadresse" id="utiadresse" class="form-control form-control-sm"> </td>
                                </tr>

                                <tr>
                                    <td colspan="2">Telephone : <input type="" name="utitelephone" id="utitelephone" class="form-control form-control-sm"> </td>
                                    <td>Telephone 2 : <input type="" name="utitelephone2" id="utitelephone2" class="form-control form-control-sm"> </td>
                                </tr>
                                <tr>
                                    <td colspan="3">Description
                                        <textarea type="" name="description" id="description" class="form-control form-control-sm"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                    </table>   
                    </div>
                    </div>
                </div>
              
                <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">

                    <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
                            <tbody class="list">
                                <tr>
                                    <td colspan="3"> <b>Date utilisation de l'avance :</b>
                                        <input type="text" name="dateutilisateur" id="dateutilisateur" class="form-control form-control-sm" style="width:33%">
                                    </td>
                                </tr>
                            </tbody>
                    </table>
                    </div>
                    </div>
                </div>
            </div> 
  </div>
    <div class="modal-footer">
        <button id="adddjabtn" name="adddjabtn" class="btn btn-primary" type="submit" >Enregistrer</button>
   </div>
   </form>
  </div>
</div>
</div>
