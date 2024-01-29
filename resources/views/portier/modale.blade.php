<a href="javascript::;" chauffeur="button" data-bs-toggle="modal" data-bs-target="#addModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouvel sortie/entrer</a>

{{-- new vehicule modal --}}

<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <form method="POST" id="addform">
      @method('post')
      @csrf
        <div class="modal-header">  
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouveau Sortie/Entrer véhicule </h5><button class="btn p-1" chauffeur="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg></button>
        </div>
        <div class="modal-body">

        <div class="col-sm-6 col-md-12">
                <div class="form-floating mb-3">
                  <input class="form-control" id="object" type="text" name="object" required="required" placeholder="Object" />
                  <label for="eventLabel">Object</label>
                </div>
                </div>


                <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <input class="form-control" id="datejour" type="date" name="datejour" required="required" placeholder="Date du jour" />
                  <label for="eventLabel">Date du jour</label>
                </div>
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <input class="form-control" id="utineraire" type="text" name="utineraire" required="required" placeholder="Utineraire" />
                  <label for="eventLabel">Utineraire</label>
                </div>
                </div>
              </div>

              <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <input class="form-control" id="heuresortie" type="text" name="heuresortie" required="required" placeholder="Heure sortie" />
                  <label for="eventLabel">Heure sortie</label>
                </div>
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <input class="form-control" id="heureretour" type="text" name="heureretour" required="required" placeholder="Heure retour" />
                  <label for="eventLabel">Heure retour</label>
                </div>
                </div>
              </div>

        <div class="row" >

        <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <select class="form-select" id="chauffeur" name="chauffeur" >
                    <option value="" selected="selected">Séléctionner chauffeur</option>
                    @foreach ($chauffeur as $chauffeurs)
                      <option value="{{ ucfirst($chauffeurs->nom) }} {{ ucfirst($chauffeurs->prenom) }}">{{ ucfirst($chauffeurs->nom) }} {{ ucfirst($chauffeurs->nom) }}</option>
                    @endforeach
                  </select>
                  <label for="eventLabel">chauffeur</label>
                </div>
                </div>



                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                <select class="form-select" id="blaque" name="blaque" >
                    <option value="" >Séléctionner vehicule</option>
                    @foreach ($vehicule as $vehicules)
                      <option value="{{ $vehicules->matricule }}">{{ $vehicules->matricule  }}</option>
                    @endforeach
                  </select>
           
                  <label for="eventLabel">Matricule</label>
                
                </div>
                
                </div>

               
              </div>

            
              <div class="row" >
              <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <select class="form-select" id="chefmission" name="chefmission" >
                    <option value="" selected="selected"> Séléctionner Chef </option>
                    @foreach ($chefmission as $chefmissions)
                      <option value="{{ ucfirst($chefmissions->nom) }} {{ ucfirst($chefmissions->prenom) }}">{{ ucfirst($chefmissions->nom) }} {{ ucfirst($chefmissions->prenom) }}</option>
                    @endforeach
                  </select>
                  <label for="eventLabel">Chef de mission</label>
                </div>
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <input class="form-control" id="signature" type="text" name="signature" required="required"  />
                  <label for="eventLabel">Signature</label>
                </div>
                </div>
                
              </div>

              <div class="row" >
             
                <div class="col-sm-3 col-md-12">
                <div class="form-floating mb-1">
                  <textarea class="form-control" id="note" type="text" name="note"  style="height:60px"> </textarea>
                  <label for="eventLabel">Note</label>
                </div>
                </div>
                
              </div>

        </div>
        <div class="modal-footer">
          <button chauffeur="submit" name="addbtn" id="addbtn"  class="btn btn-primary" >Enregistrer</button>
        </div>
        </form>
    </div>
  </div>
</div>

{{-- Fin vehicule --}}
                          


{{-- Edit fonction modal --}}



{{-- fin Edit fonction modal --}}