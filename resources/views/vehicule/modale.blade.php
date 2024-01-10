<a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addVehiculeModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau véhicule</a>

{{-- new vehicule modal --}}

<div class="modal fade" id="addVehiculeModal" tabindex="-1" aria-labelledby="addVehiculeModal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <form method="POST" id="addform">
      @method('post')
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouveau véhicule </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg></button>
        </div>
        <div class="modal-body">

        <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-5">
                  <input class="form-control" id="matricule" type="text" name="matricule" required="required" placeholder="Blaque matricule" />
                  <label for="eventLabel">Matricule</label>
                  <small id="matricule_error" name="matricule_error" class="text text-danger" ></small>
                </div>
                
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-5">
                  <input class="form-control" id="marque" type="text" name="marque" required="required" placeholder="Marque" />
                  <label for="eventLabel">Marque</label>
                </div>
                </div>
              </div>

              <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-5">
                  <input class="form-control" id="modele" type="text" name="modele" required="required" placeholder="Modèle" />
                  <label for="eventLabel">Modèle</label>
                </div>
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-5">
                  <input class="form-control" id="couleur" type="text" name="couleur" required="required" placeholder="Couleur" />
                  <label for="eventLabel">Couleur</label>
                </div>
                </div>
              </div>

              <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-5">
                  <input class="form-control" id="numserie" type="text" name="numserie" required="required" placeholder="Numéro série" />
                  <label for="eventLabel">N<sup>o</sup> Série</label>
                </div>
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-5">
                  <select class="form-select" id="type" name="type" >
                    <option value="" selected="selected">Séléctionner Type</option>
                    @foreach ($type as $types)
                      <option value="{{ $types->libelle }}">{{  ucfirst($types->libelle) }}</option>
                    @endforeach
                  </select>
                  <label for="eventLabel">Type</label>
                </div>
                </div>
              </div>

              <div class="row" >
              <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-5">
                <select class="form-select" id="carburent" name="carburent" >
                    <option value="" selected="selected">Séléctionner carburant</option>
                    @foreach ($carburent as $carburents)
                      <option value="{{ $carburents->libelle }}">{{  ucfirst($carburents->libelle) }}</option>
                    @endforeach
                    
                  </select>
                  <label for="eventLabel">Carburent</label>
                </div>
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-5">
                <select class="form-select" id="statut" name="statut" >
                    <option value="" selected="selected">Séléctionner Statut</option>
                    @foreach ($statut as $statuts)
                      <option value="{{ $statuts->libelle }}">{{  ucfirst($statuts->libelle) }}</option>
                    @endforeach
                  </select>
                  <label for="eventLabel">Statut</label>
                </div>
                </div>
              </div>

        </div>
        <div class="modal-footer">
          <button type="submit" name="addbtn" id="addbtn"  class="btn btn-primary" >Enregistrer</button>
        </div>
        </form>
    </div>
  </div>
</div>

{{-- Fin vehicule --}}
                          


{{-- Edit fonction modal --}}



{{-- fin Edit fonction modal --}}