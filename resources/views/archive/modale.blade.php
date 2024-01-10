

<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      <form method="POST" id="addform">
      @method('post')
      @csrf
        <div class="modal-header">  
          <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouveau classement </h5><button class="btn p-1" chauffeur="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg></button>
        </div>
        <div class="modal-body">

        <div class="col-sm-6 col-md-12">

        <div class="row" >

      <div class="col-sm-3 col-md-12">
        <div class="form-floating mb-3">
          <select class="form-select" id="classeur" name="classeur" >
            <option value="" selected="selected">Séléctionner classeur</option>
            @foreach ($classeur as $classeurs)
              <option value="{{ $classeurs->id }}">{{ ucfirst($classeurs->libellec) }} </option>
            @endforeach
          </select>
          <label for="eventLabel">Classeur</label>
        </div>
        </div>
        </div>

        <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <input class="form-control" id="numerogenerale" type="text" name="numerogenerale" required="required" placeholder="Heure sortie" />
                  <label for="eventLabel">N<sup>o</sup> generale</label>
                </div>
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <input class="form-control" id="numerolettre" type="text" name="numerolettre" required="required" placeholder="Heure retour" />
                  <label for="eventLabel">N<sup>o</sup>  Lettre</label>
                </div>
                </div>
              </div>

       
               


                <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <input class="form-control" id="datelettre" type="date" name="datelettre" required="required" placeholder="Date du jour" />
                  <label for="eventLabel">Date de la lettre</label>
                </div>
                </div>
            

              
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <input class="form-control" id="dateexpiration" type="date" name="dateexpiration" required="required" placeholder="Utineraire" />
                  <label for="eventLabel">Date expediction</label>
                </div>
                </div>
                </div>
            
                <div class="row" >
              <div class="col-sm-6 col-md-12">
              <div class="form-floating mb-3">
                  <input class="form-control" id="destinateur" type="text" name="destinateur" required="required" placeholder="Object" />
                  <label for="eventLabel">Nom destinateur</label>
                </div>

                </div>              

                </div>   


              <div class="row" >
             
                <div class="col-sm-3 col-md-12">
                <div class="form-floating mb-1">
                  <textarea class="form-control" id="note" type="text" name="note"  style="height:60px"> </textarea>
                  <label for="eventLabel">Resume</label>
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
                          
