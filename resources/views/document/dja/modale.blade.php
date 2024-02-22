

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
         <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;name&quot;,&quot;email&quot;,&quot;age&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm fs--1 mb-0">
                            <tbody class="list">
                                <tr>
                                    <td class="align-middle ps-3 name" colspan="8"> Présumé Bénéficiaire/Fournisseur/Prestataire à payer:  <br> 
                                  
                                        <input value="{{ Session::get('id') }}" type="hidden" name="projetid" id="projetid" >
                                        <input value="{{ Session::get('title') }}" class="form-control" disabled  >     
                                    </td>

                                    
                               
                               
                                </tr>
                                <tr>
                                    <td class="align-middle ps-3 name" colspan="3">Béneficiaire <br>
                                        <input type="text" class="form-control" name="beneficiaire" id="beneficiaire" style="width: 100%" />
                                       
                                    </td>

                                    <td class="align-middle ps-3 name">Numero DJA <br/>
                                        <input class="form-control" id="numerodja" name="numerodja"  /> 
                                    </td>


                                    <td class="align-middle ps-3 name"> Les fonds devront être reçus le  <br>
                                        <input class="form-control" type="date" id="datefondrecu" name="datefondrecu" > 
                                    </td>
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name"  colspan="2">Référence (s) : FEB Nº <br>
                                        <input type="text" class="form-control" name="reffeb" id="reffeb" /> 
                                        
                                    </td>

                                    <td class="align-middle ps-3 name">DAP Nº
                                        <input  class="form-control" id="dapnum" name="dapnum" > 
                                    </td>


                                    <td class="align-middle ps-3 name">OV/CHQ Nº
                                        <input  class="form-control" type="type" id="ovch" name="ovch"> 
                                    </td>

                                    <td class="align-middle ps-3 name">Ligne budgétaire
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
                                    <td class="align-middle ps-3 name"  colspan="3">Montant de l'avance<br>
                                        <input  type="text" class="form-control" id="montant_avance" name="montant_avance" />
                                       
                                    </td>

                                    <td class="align-middle ps-3 name"> Dévise (BIF ou USD):
                                        <input class="form-control" id="devise" name="devise"  > 
                                    </td>


                                    <td class="align-middle ps-3 name"> Durée de l’avance:  
                                        <input  class="form-control" type="type" id="dure_avance" name="dure_avance"  > 
                                    </td>

                                    
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name"  colspan="8"> DESCRIPTION/MOTIF:

                                        <textarea  class="form-control" type="type" id="description" name="description" > </textarea>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <table class="table table-striped table-sm fs--1 mb-0">
                        <tbody class="list">
                                <tr>
                                    <td class="align-middle ps-3 name" colspan="4"> Demande/Approbation
                                    </td>
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name"> 
                                        Fonds demandés par: <br> Nom:<br>
                                        <select type="text" class="form-control" name="fondapprouver" id="fondapprouver">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}"> {{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br> Signature<br>
                                    <input  class="form-check-input" type="checkbox" id="sign_fond" name="sign_fond"  > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                      
                                   
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br>Date<br>
                                    <input value="" class="form-control" type="date" id="date_fond" name="date_fond" > 
                                    </td>
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name"> 
                                    Avance Approuvée par (2 personnes au moins) : <br> Nom:<br>
                                    <select type="text" class="form-control" name="avance_approuver" id="avance_approuver">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br> Signature<br>
                                    <input  class="form-check-input" type="checkbox" id="sign_avance" name="sign_avance" > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br> Chef Comptable (Si A< 500 000 Fbu)
                                    <select type="text" class="form-control" name="chefcomptable" id="chefcomptable">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select>
                                   
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br>Date<br>
                                    <input  class="form-control" type="date"  id="date_chefcomptable" name="date_chefcomptable"> 
                                    </td>
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name"> 
                                     Nom:<br>
                                     <select type="text" class="form-control" name="avence_approuver_deuxieme" id="avence_approuver_deuxieme">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    Signature<br>
                                    <input class="form-check-input" type="checkbox" id="signe_deuxieme" name="signe_deuxieme"  > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                     RAF (Si A < 1000 000 Fbu)  
                                     <select type="text" class="form-control" name="raf" id="raf">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select> 
                                   
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    Date<br>
                                    <input value="" class="form-control" type="date"  id="date_raf" name="date_raf"> 
                                    </td>
                                </tr>


                                <tr>
                                    <td class="align-middle ps-3 name"> 
                                     Nom:<br>
                                     <select type="text" class="form-control" name="avence_approuver_troisieme" id="avence_approuver_troisieme">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    Signature<br>
                                    <input value="" class="form-check-input" type="checkbox" id="sign_avence_apr_troisieme" > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    SG ou SGA (Si  A>1000 000 Fbu)
                                    <select type="text" class="form-control" name="sg" id="sg">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select>
                                   
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    Date<br>
                                    <input value="" class="form-control" type="date" id="datesg" name="datesg"> 
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle ps-3 name"> 
                                    Fonds déboursés par: <br> Nom:<br>
                                    <select type="text" class="form-control" name="fondboursser" id="fondboursser">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br> Signature<br>
                                    <input class="form-check-input" type="checkbox" name="sign_fonddeboursse" id="sign_fonddeboursse"> 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br>Date<br>
                                    <input value="" class="form-control" type="date"  name="date_fonddeboursse" id="date_fonddeboursse"> 
                                    </td>
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name"> 
                                    Fonds reçus par: <br> Nom:<br>
                                    <select type="text" class="form-control" name="fondresu" id="fondresu">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select>
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br> Signature<br>
                                    <input class="form-check-input" type="checkbox" name="signature_fondresu" id="signature_fondresu" > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br>Date<br>
                                    <input  class="form-control" type="date" name="date_fondrecu" id="date_fondrecu"> 
                                    </td>
                                </tr>

                                
                                </tbody>
                        </table>
                    
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
