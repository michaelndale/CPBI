
{{-- new vehicule modal --}}

<div class="modal fade" id="addAchatModal" tabindex="-1" aria-labelledby="addAchatModal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <form method="POST" id="addaform">
      @method('post')
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel"> Nouveau Achats / Location </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        <div class="row" >
                <div class="col-sm-6 col-md-6">
                  <input type="radio" class="form-check-input" value="location" type="text" name="choix"  />
                  <label for="eventLabel">Location</label>
                </div>

                <div class="col-sm-6 col-md-6">
                  <input type="radio" class="form-check-input" value="Achat" type="text" name="choix"  />
                  <label for="eventLabel">Achat</label>
                </div>
              </div>

              <div class="row" >
                <div class="col-sm-6 col-md-6">
                <label for="eventLabel">Kilomètrage</label>
                  <input class="form-control form-control-sm" id="kilometrage" type="number" name="kilometrage" required="required" placeholder="Kilomètrage" />
                </div>

                <div class="col-sm-6 col-md-6">
                <label for="eventLabel">Expiration</label>
                  <input class="form-control form-control-sm" id="expiration" type="text" name="expiration"  placeholder="Expiration" />
                </div>
              </div>

              <div class="row" >
                <div class="col-sm-6 col-md-6">
                <label for="eventLabel">Prix de vente</label>
                  <input class="form-control form-control-sm" id="prixvente" type="text" name="prixvente"  placeholder="Prix de vente" />
                </div>

                <div class="col-sm-6 col-md-6">
                <label for="eventLabel">Date</label>
                  <input class="form-control form-control-sm" id="date" type="Date" name="date" />
                </div>

               
              </div>

              <div class="row" >
              <div class="col-sm-6 col-md-6">
              <label for="eventLabel">Fournisseur</label>
                <select class="form-control  form-control-sm" id="fournisseur" name="fournisseur" >
                    <option value="" selected="selected">Séléctionner Fournisseur</option>
                    @foreach ($founisseurs as $founisseur)
                      <option value="{{ $founisseur->nom }}">{{  $founisseur->nom }}</option>
                    @endforeach
                    
                  </select>
                 
            
                </div>

                <div class="col-sm-6 col-md-6">
                <label for="eventLabel">Vehicule</label>
                <select class="form-control  form-control-sm" id="vehicule" name="vehicule" >
                    <option value="" selected="selected">Vehicule</option>
                    @foreach ($vehicules as $vehicule)
                      <option value="{{ $vehicule->matricule }}">{{  $vehicule->matricule }}</option>
                    @endforeach
                  </select>
                  
                </div>

                <div class="col-sm-12 col-md-12">
                <label for="eventLabel">Note</label>
                  <textarea class="form-control form-control-sm" id="note" type="text" name="note" ></textarea>
                </div>
               
              </div>

        </div>
        <div class="modal-footer">
          <button type="submit" name="addabtn" id="addabtn"  class="btn btn-primary" > <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>
        </form>
    </div>
  </div>
</div>

{{-- Fin vehicule --}}
                          


{{-- Edit fonction modal --}}



{{-- fin Edit fonction modal --}}