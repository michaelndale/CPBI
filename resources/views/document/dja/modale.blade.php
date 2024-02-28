<div class="modal fade" id="scrollingLong2" tabindex="-1" aria-labelledby="scrollingLongModalLabel2" style="display: none;" aria-hidden="true" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog modal-xl  modal-fullscreen modal-dialog-scrollable">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="scrollingLongModalLabel2">DEMANDE ET JUSTIFICATION D'AVANCE (DJA)</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
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
                                        <input type="" name="" class="form-control form-control-sm">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">Adresse :
                                    <input type="" name="" class="form-control form-control-sm"> </td>
                                </tr>

                                <tr>
                                    <td>Telephone : <input type="" name="" class="form-control form-control-sm"> </td>
                                    <td>Telephone 2 : <input type="" name="" class="form-control form-control-sm"> </td>
                                </tr>

                                <tr>
                                    <td colspan="2">Description
                                        <textarea type="" name="" class="form-control form-control-sm"></textarea>
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
                                        <input type="text" name="" class="form-control form-control-sm" style="width:33%">
                                    </td>
                                </tr>

                             

                                <tr>
                                    <td>Référence (s) : FEB Nº <input type="" name="" class="form-control form-control-sm"> </td>
                                    <td>DAP Nº<input type="" name="" class="form-control form-control-sm"> </td>
                                    <td>OV/CHQ Nº <input type="" name="" class="form-control form-control-sm"> </td>
                                </tr>

                                <tr>
                                    <td colspan="3">Ligne budgetaire
                                    <input type="" name="" class="form-control form-control-sm">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Montant de l'avance<input type="" name="" class="form-control form-control-sm"> </td>
                                    <td>Devise (BIF ou USD)<input type="" name="" class="form-control form-control-sm"> </td>
                                    <td>Duree de l'avance jours<input type="" name="" class="form-control form-control-sm"> </td>
                                </tr>
                            </tbody>
                    </table>
                            
                    </div>
                    </div>
                </div>
            </div>

            <hr>
            <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;name&quot;,&quot;email&quot;,&quot;age&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
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
                                        <select type="text" class="form-control form-control-sm" name="fondapprouver" id="fondapprouver">
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
                                    <select type="text" class="form-control form-control-sm" name="sg" id="sg">
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
                                    
                                    <td  colspan=""> 
                                   <b>Fonds déboursés par: </b> <br> Nom:<br>
                                    <select type="text" class="form-control form-control-sm" name="fondboursser" id="fondboursser">
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

                
                <hr>
                <div class="row" style="padding:10px">
                <br>
                <h5><b>Rapport d'utilisation de l'avance</b>  </h5>
               
             <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">

                    <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
                            <tbody class="list">
                                <tr>
                                    <td colspan="2"><b>Fonds payes a</b>
                                        <input type="" name="" class="form-control form-control-sm">
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2">Adresse :
                                    <input type="" name="" class="form-control form-control-sm"> </td>
                                </tr>

                                <tr>
                                    <td>Telephone : <input type="" name="" class="form-control form-control-sm"> </td>
                                    <td>Telephone 2 : <input type="" name="" class="form-control form-control-sm"> </td>
                                </tr>

                                <tr>
                                    <td colspan="2">Description
                                        <textarea type="" name="" class="form-control form-control-sm"></textarea>
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
                                        <input type="text" name="" class="form-control form-control-sm" style="width:33%">
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
