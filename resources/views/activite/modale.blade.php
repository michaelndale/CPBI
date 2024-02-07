

<div class="modal fade" id="addModale" tabindex="-1" aria-labelledby="addModale" style="display: none;" aria-hidden="true">
<div class="modal-dialog modal-xl modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Nouvelle activité </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
    </div>
    <div class="modal-body">
    <form class="row g-3 mb-6" method="POST" id="addactiviteForm">
    @method('post')
    @csrf

    <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;name&quot;,&quot;email&quot;,&quot;age&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
        <div class="table-responsive">                  
            <table class="table table-striped table-sm fs--1 mb-0">
            <tbody class="list">

            <tr>
               <td class="align-middle ps-1 name"> Source projet</td>
               <td class="align-middle email" colspan="4">
                   <input value="{{ Session::get('id') }}" type="hidden" name="projetid" id="projetid" >
                   <input value="{{ Session::get('title') }}" class="form-control" disabled  >      
               </td>
           </tr>
           <tr>
            <td>Ligne budgetaire</td>
            <td colspan="4">
            <div class="col-sm-12 col-md-12">
                <div class="form-floating">
                <select class="form-select" id="compteid" name="compteid" required >
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
                <td class="align-middle ps-3 name" style="width:25%">Description detaillee des besoins </td>
                <td class="align-middle email" colspan="6">
                    <input type="text" class="form-control" name="titre" id="titre" style="width: 100%" />
                </td>
            </tr>
           
            
            <tr>
                <td class="align-middle ps-3 name" style="width:10%">Couts estimes </td>
                <td class="align-middle email" colspan="2">
                    <input type="number" class="form-control" name="montant" id="montant" style="width: 100%" />
                </td>

                
            </tr>

            <tr>
                <td class="align-middle ps-3 name" style="width:10%">Etat de l'activité</td>
                <td class="align-middle email" colspan="2">
                    <select type="text" class="form-control" name="etat" id="etat" style="width: 100%" />
                    <option>Aucune</option>
                    <option value="Encours">Encours</option>  
                    <option value="Terminée">Terminée</option> 
                    <option value="Contrainte">Contrainte</option> 
                    <option value="Annuler">Annuler</option>  
                  </select>
                </td>

                
            </tr>
        </tbody>
        </table>
        </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" name="addactivitebtn" id="addactivitebtn" class="btn btn-primary px-5 px-sm-15 addactivitebtn"> Sauvegarder </button> 
   </div>
</div>
</form>
</div>
</div>