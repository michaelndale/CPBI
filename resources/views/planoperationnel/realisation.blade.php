<div class="modal fade" id="ajouterrelisation"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="ajouterrelisation" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
      <form method="POST" id="addrealisationForm">
      @method('post')
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel"> Réalisation du plan d'action </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
        </div>
        <div class="modal-body">

        <div class="row g-3">

          <div class="col-sm-6 col-lg-12 col-xl-12">
            <label class="text-1000 fw-bold mb-2">Activité</label>
                    
            <div class="row g-4">
              <div class="col">
                    <input  type="hidden" name="planid" id="planid"  >
                    <input  type="hidden" name="activiteid" id="activiteid" >
                    <textarea  class="form-control" type="text" id="activitetitre"  required style="background-color:#DCDCDC" readonly> </textarea>
                </div>     
              </div>
        

            <div class="row g-2">

            <div class="col-sm-4 col-lg-6 col-xl-6">
              <label class="text-1000 fw-bold mb-2">	Homme</label>
              <input class="form-control" id="nombrehomme" name="nombrehomme"  type="number" placeholder="Nombres des hommes"  required></input>
            </div>

            <div class="col-sm-4 col-lg-6 col-xl-6">
              <label class="text-1000 fw-bold mb-2">	Femme</label>
              <input class="form-control" id="nombrefemme" name="nombrefemme"  type="number" placeholder="Nombres des femmes"  required></input>
            </div>

            </div>

            <div class="row g-3">

                <div class="col-sm-4 col-lg-12 col-xl-6">
                <label class="text-1000 fw-bold mb-2">	Nombre de séances</label>
                <input class="form-control" id="nombreseance" name="nombreseance"  type="number" placeholder="Entrer des séances"  required></input>
                </div>

                <div class="col-sm-4 col-lg-12 col-xl-6">
                <label class="text-1000 fw-bold mb-2">	Date fin </label>
                <input class="form-control" id="dateday" name="dateday"  type="date"  required></input>
                </div>
                </div>
          </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="addrealisationbtn" id="addrealisationbtn" class="btn btn-primary" type="button">Sauvegarder</button>
        </div>
        </form>
    </div>
  </div>
</div>
