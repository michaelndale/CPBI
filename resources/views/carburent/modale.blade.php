{{-- new carburent modal --}}

<div class="modal fade" id="addCarburentModal" tabindex="-1" aria-labelledby="addCarburentModal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="addform">
        @method('post')
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel"> Nouveau carburent </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="row">

            <div class="col-sm-6 col-md-6">
              <div class="form-floating mb-1">
                <select class="form-select" id="vehicule" name="vehicule">
                  <option value="" selected="selected">Séléctionner véhicule</option>
                  @foreach ($vehicule as $vehicules)
                  <option value="{{ $vehicules->matricule }}">{{ $vehicules->matricule }}</option>
                  @endforeach

                </select>
                <label for="eventLabel">Véhicule</label>
              </div>
            </div>

            <div class="col-sm-6 col-md-6">
              <div class="form-floating mb-1">
                <select class="form-select" id="carburent" name="carburent">
                  <option value="" selected="selected">Séléctionner carburent</option>
                  @foreach ($carburent as $carburents)
                  <option value="{{ $carburents->libelle }}">{{ ucfirst($carburents->libelle) }}</option>
                  @endforeach

                </select>
                <label for="eventLabel">Carburent</label>
              </div>
            </div>
          </div>

          <div class="row">

          <div class="col-sm-6 col-md-6">
              <div class="form-floating mb-1">
                <select class="form-select" id="fournisseur" name="fournisseur"">
                  <option value="" selected="selected">Séléctionner fournisseur</option>
                  @foreach ($fournisseur as $fournisseurs)
                  <option value="{{ $fournisseurs->id }}">{{ $fournisseurs->nom }}</option>
                  @endforeach

                </select>
                <label for="eventLabel">Fournisseurs</label>
              </div>
            </div>

            <div class="col-sm-6 col-md-6">
              <div class="form-floating mb-1">
                <input class="form-control" id="quantite" type="number" name="quantite" required="required" placeholder="Quantité" />
                <label for="eventLabel">Quantité littres</label>
              </div>
            </div>

           
          </div>

          <div class="row">
            <div class="col-sm-6 col-md-6">
              <div class="form-floating mb-1">
                <input class="form-control" id="cout" type="number" name="cout" required="required" placeholder="Coût" />
                <label for="eventLabel">Coût</label>
              </div>

            </div>

            <div class="col-sm-6 col-md-6">
              <div class="form-floating mb-1">
                <input class="form-control" id="kilodebut" type="number" name="kilodebut" required="required" placeholder="Kilomètrage debut" />
                <label for="eventLabel">Kilomètrage debut</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6 col-md-6">
              <div class="form-floating mb-1">
                <input class="form-control" id="kilofin" type="text" name="kilofin" required="required" placeholder="Kilomètrage fin" />
                <label for="eventLabel">Kilomètrage fin</label>
              </div>
            </div>

            <div class="col-sm-6 col-md-6">
              <div class="form-floating mb-1">
                <input class="form-control" id="date" type="date" name="date" required="required" />
                <label for="eventLabel">Date operation</label>
              </div>
            </div>

            <div class="col-sm-12 col-md-12">
              <div class="form-floating mb-1">
                <textarea class="form-control" id="note" type="text" name="note" required="required" placeholder="Description" > </textarea>
                <label for="eventLabel">Description</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="addbtn" id="addbtn" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>

      </form>
    </div>
  </div>
</div>
{{-- Fin carburent --}}