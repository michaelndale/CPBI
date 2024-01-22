<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>


<a href="javascript:voide(0)" data-bs-toggle="modal" data-bs-target="#scrollingLong2"  data-keyboard="false" data-backdrop="static"> <span data-feather="plus-circle"></span> Nouvel fiche DJA </a></nav>



<div class="modal fade" id="scrollingLong2" tabindex="-1" aria-labelledby="scrollingLongModalLabel2" style="display: none;" aria-hidden="true" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog modal-xl modal-dialog-scrollable">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="scrollingLongModalLabel2">DEMANDE ET JUSTIFICATION D'AVANCE (DJA)</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg><!-- <span class="fas fa-times fs--1"></span> Font Awesome fontawesome.com --></button>
    </div>
    <div class="modal-body">
     
    <form class="row g-3 mb-6" method="POST" id="addProjectForm">

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
                                        <select type="text" class="form-control" name="activityid" id="activityid" style="width: 100%">
                                        <option value="">--Aucun--</option>
                                        @forelse ($dataBene as $dataBenes)
                                            <option value="{{ $dataBenes->id }}"> {{ $dataBenes->libelle }} </option>
                                        @empty
                                        <option value="">--Aucun activite trouver--</option>
                                        @endforelse
                                    </select>
                                    </td>

                                    <td class="align-middle ps-3 name">Numero DJA <br/>
                                        <input value="" class="form-control"  > 
                                    </td>


                                    <td class="align-middle ps-3 name"> Les fonds devront être reçus le  <br>
                                        <input value="" class="form-control" type="date" > 
                                    </td>
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name"  colspan="2">Référence (s) : FEB Nº <br>
                                        <select type="text" class="form-control" name="activityid" id="activityid" >
                                        <option value="">--Aucun--</option>
                                        @forelse ($dataBene as $dataBenes)
                                            <option value="{{ $dataBenes->id }}"> {{ $dataBenes->libelle }} </option>
                                        @empty
                                        <option value="">--Aucun activite trouver--</option>
                                        @endforelse
                                    </select>
                                    </td>

                                    <td class="align-middle ps-3 name">DAP Nº
                                        <input value="" class="form-control"  > 
                                    </td>


                                    <td class="align-middle ps-3 name">OV/CHQ Nº
                                        <input value="" class="form-control" type="type" > 
                                    </td>

                                    <td class="align-middle ps-3 name">Ligne budgétaire
                                        <input value="" class="form-control" type="type" > 
                                    </td>
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name"  colspan="3">Montant de l'avance<br>
                                        <select type="text" class="form-control" name="activityid" id="activityid" >
                                        <option value="">--Aucun--</option>
                                        @forelse ($dataBene as $dataBenes)
                                            <option value="{{ $dataBenes->id }}"> {{ $dataBenes->libelle }} </option>
                                        @empty
                                        <option value="">--Aucun activite trouver--</option>
                                        @endforelse
                                    </select>
                                    </td>

                                    <td class="align-middle ps-3 name"> Dévise (BIF ou USD):
                                        <input value="" class="form-control"  > 
                                    </td>


                                    <td class="align-middle ps-3 name"> Durée de l’avance:  
                                        <input value="" class="form-control" type="type" > 
                                    </td>

                                    
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name"  colspan="8"> DESCRIPTION/MOTIF:

                                        <textarea value="" class="form-control" type="type" > </textarea>
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
                                    <input value="" class="form-control" type="type" > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br> Signature<br>
                                    <input value="" class="form-check-input" type="checkbox" > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                      
                                   
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br>Date<br>
                                    <input value="" class="form-control" type="date" > 
                                    </td>
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name"> 
                                    Avance Approuvée par (2 personnes au moins) : <br> Nom:<br>
                                    <input value="" class="form-control" type="type" > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br> Signature<br>
                                    <input value="" class="form-check-input" type="checkbox" > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br> Chef Comptable (Si A< 500 000 Fbu)
                                    <input value="" class="form-control" type="type" > 
                                   
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br>Date<br>
                                    <input value="" class="form-control" type="date" > 
                                    </td>
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name"> 
                                     Nom:<br>
                                    <input value="" class="form-control" type="type" > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    Signature<br>
                                    <input value="" class="form-check-input" type="checkbox" > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    C RAF (Si A < 1000 000 Fbu)
                                    <input value="" class="form-control" type="type" > 
                                   
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    Date<br>
                                    <input value="" class="form-control" type="date" > 
                                    </td>
                                </tr>


                                <tr>
                                    <td class="align-middle ps-3 name"> 
                                     Nom:<br>
                                    <input value="" class="form-control" type="type" > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    Signature<br>
                                    <input value="" class="form-check-input" type="checkbox" > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    SG ou SGA (Si  A>1000 000 Fbu)
                                    <input value="" class="form-control" type="type" > 
                                   
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    Date<br>
                                    <input value="" class="form-control" type="date" > 
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle ps-3 name"> 
                                    Fonds déboursés par: <br> Nom:<br>
                                    <input value="" class="form-control" type="type" > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br> Signature<br>
                                    <input value="" class="form-check-input" type="checkbox" > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br>Date<br>
                                    <input value="" class="form-control" type="date" > 
                                    </td>
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name"> 
                                    Fonds reçus par: <br> Nom:<br>
                                    <input value="" class="form-control" type="type" > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br> Signature<br>
                                    <input value="" class="form-check-input" type="checkbox" > 
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    
                                    </td>

                                    <td class="align-middle ps-3 name"> 
                                    <br>Date<br>
                                    <input value="" class="form-control" type="date" > 
                                    </td>
                                </tr>

                                
                                </tbody>
                        </table>
                      
                       




                       
                    </div>
                </div>
            </form>
    
  </div>
    <div class="modal-footer"><button class="btn btn-primary" type="button" style="background-color:#228B22; color:white">Enregistrer</button>
   </div>
  </div>
</div>
</div>
