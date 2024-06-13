
{{-- new vehicule modal --}}

<div class="modal fade" id="addVehiculeModal" tabindex="-1" aria-labelledby="addVehiculeModal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <form method="POST" id="addform">
      @method('post')
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel"> Nouveau véhicule </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                  <input class="form-control" id="matricule" type="text" name="matricule" required="required" placeholder="Blaque matricule" />
                  <label for="eventLabel">Plaque d'immatriculation</label>
                  <small id="matricule_error" name="matricule_error" class="text text-danger" ></small>
                </div>
                
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                  <input class="form-control" id="marque" type="text" name="marque" required="required" placeholder="Marque" />
                  <label for="eventLabel">Marque</label>
                </div>
                </div>
              </div>

              <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                  <input class="form-control" id="modele" type="text" name="modele" required="required" placeholder="Modèle" />
                  <label for="eventLabel">Modèle</label>
                </div>
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                  <input class="form-control" id="couleur" type="text" name="couleur" required="required" placeholder="Couleur" />
                  <label for="eventLabel">Couleur</label>
                </div>
                </div>
              </div>

              <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                  <input class="form-control" id="annee" type="text" name="annee" required="required" placeholder="L'année" />
                  <label for="eventLabel">Année de Fabrication</label>
                </div>
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                  <input class="form-control" id=numero_chassis" type="text" name="numero_chassis" required="required" placeholder="Le numéro de châssis" />
                  <label for="eventLabel"> Le numéro de châssis </label>
                </div>
                </div>
              </div>

              <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                  <input class="form-control" id="numserie" type="text" name="numserie" required="required" placeholder="Numéro série" />
                  <label for="eventLabel">N<sup>o</sup> Série</label>
                </div>
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                  <select class="form-select" id="type" name="type" >
                    <option value="" selected="selected">Séléctionner Type</option>
                    @foreach ($type as $types)
                      <option value="{{ $types->libelle }}">{{  ucfirst($types->libelle) }}</option>
                    @endforeach
                  </select>
                  <label for="eventLabel">Type de véhicule</label>
                </div>
                </div>
              </div>

              <div class="row" >
              <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                <select class="form-select" id="carburent" name="carburent" >
                    <option value="" selected="selected">Séléctionner carburant</option>
                    @foreach ($carburent as $carburents)
                      <option value="{{ $carburents->libelle }}">{{  ucfirst($carburents->libelle) }}</option>
                    @endforeach
                    
                  </select>
                  <label for="eventLabel"> Type de carburant</label>
                </div>
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                <select class="form-select" id="statut" name="statut" >
                    <option value="" selected="selected">Séléctionner Statut</option>
                    @foreach ($statut as $statuts)
                      <option value="{{ $statuts->titre }}">{{  ucfirst($statuts->titre) }}</option>
                    @endforeach
                  </select>
                  <label for="eventLabel">Statut du véhicule</label>
                </div>
                </div>
              </div>

        </div>
        <div class="modal-footer">
          <button type="submit" name="addbtn" id="addbtn"  class="btn btn-primary" > <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>
        </form>
    </div>
  </div>
</div>

{{-- Fin vehicule --}}
                          
{{-- Edit vehicule modal --}}


<div class="modal fade" id="edit_vehiculeModal" tabindex="-1" aria-labelledby="addVehiculeModal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <form method="POST" id="editform">
      @method('post')
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel"><i class="fa fa-edit"></i> Modification du  véhicule </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                  <input type="hidden" id="idv" type="text" name="idv" />
                  <input class="form-control" id="matriculev" type="text" name="matriculev" required="required" placeholder="Blaque matricule" />
                  <label for="eventLabel">Matricule</label>
                  <small id="matricule_error" name="matricule_error" class="text text-danger" ></small>
                </div>
                
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                  <input class="form-control" id="marquev" type="text" name="marquev" required="required" placeholder="Marque" />
                  <label for="eventLabel">Marque</label>
                </div>
                </div>
              </div>

              <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                  <input class="form-control" id="modelev" type="text" name="modelev" required="required" placeholder="Modèle" />
                  <label for="eventLabel">Modèle</label>
                </div>
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                  <input class="form-control" id="couleurv" type="text" name="couleurv" required="required" placeholder="Couleur" />
                  <label for="eventLabel">Couleur</label>
                </div>
                </div>
              </div>


              <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                  <input class="form-control" id="cannee" type="text" name="cannee" required="required" placeholder="L'année" />
                  <label for="eventLabel">Année de Fabrication</label>
                </div>
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                  <input class="form-control" id="cnumero_chassis" type="text" name="cnumero_chassis" required="required" placeholder="Le numéro de châssis" />
                  <label for="eventLabel"> Le numéro de châssis </label>
                </div>
                </div>
              </div>

              <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                  <input class="form-control" id="numseriev" type="text" name="numseriev" required="required" placeholder="Numéro série" />
                  <label for="eventLabel">N<sup>o</sup> Série</label>
                </div>
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                  <select class="form-select" id="typev" name="typev" >
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
                <div class="form-floating mb-1">
                <select class="form-select" id="carburentv" name="carburentv" >
                    <option value="" selected="selected">Séléctionner carburant</option>
                    @foreach ($carburent as $carburents)
                      <option value="{{ $carburents->libelle }}">{{  ucfirst($carburents->libelle) }}</option>
                    @endforeach
                    
                  </select>
                  <label for="eventLabel">Carburent</label>
                </div>
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-1">
                <select class="form-select" id="statutv" name="statutv" >
                    <option value="" selected="selected">Séléctionner Statut</option>
                    @foreach ($statut as $statuts)
                      <option value="{{ $statuts->titre }}">{{  ucfirst($statuts->titre) }}</option>
                    @endforeach
                  </select>
                  <label for="eventLabel">Statut</label>
                </div>
                </div>
              </div>

        </div>
        <div class="modal-footer">
          <button  name="editbtn" id="editbtn"  class="btn btn-primary" > <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>
        </form>
    </div>
  </div>
</div>


<div class="modal fade" id="voir_vehiculeModal" tabindex="-1" aria-labelledby="voir_vehiculeModal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Détails du véhicule </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        <div class="row" >
                <div class="col-sm-6 col-md-6">
                  <label for="eventLabel">Numéro de plaque d'immatriculation</label> <br>
                  <input id="dmatricule" name="dmatricule" style="border:none"/>
                </div>

                <div class="col-sm-6 col-md-6">
                  <label for="eventLabel">Marque</label> <br>
                  <input id="dmarque" style="border:none"/>
                </div>
              </div>
              <br>

              <div class="row" >
                <div class="col-sm-6 col-md-6">
                  <label for="eventLabel">Modèle:</label> <br>
                  <input id="dmodele"  style="border:none"/>
                </div>

                <div class="col-sm-6 col-md-6">
                  <label for="eventLabel">Couleur:</label> <br>
                  <input id="dcouleur" style="border:none"/>
                </div>
                </div>
                <br>
            

              <div class="row" >

              <div class="col-sm-6 col-md-6">
                  <label for="eventLabel">Année de Fabrication:</label> <br>
                  <input id="dannee"  style="border:none"/>
              </div>

              <div class="col-sm-6 col-md-6">
                  <label for="eventLabel">Le numéro de châssis: </label> <br>
                  <input id="dnumero_chassis"  style="border:none"/>
              </div>

            
              </div>
              <br>

              <div class="row" >
                <div class="col-sm-6 col-md-6">
                <label for="eventLabel">N<sup>o</sup> Série:</label> <br>
                  <input id="dnumserie" style="border:none"/>
                </div>

                <div class="col-sm-6 col-md-6">
                <label for="eventLabel"> Type: </label> <br>
                  <input id="dtype" style="border:none"/>
                </div>
              </div>
              <br>

              <div class="row" >
              <div class="col-sm-6 col-md-6">
                   <label for="eventLabel"> Type de carburant: </label> <br>
                  <input id="dcarburent" style="border:none"/>
                </div>

                <div class="col-sm-6 col-md-6">
                <label for="eventLabel"> Statut: </label> <br>
                  <input id="dstatut" style="border:none"/>
                </div>
              </div>

        </div>
       
    </div>
  </div>
</div>



{{-- fin Edit vehicule modal --}}