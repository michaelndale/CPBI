{{-- new vehicule modal --}}

<div class="modal fade" id="addprogrammeModal" tabindex="-1" aria-labelledby="addAchatModal" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="addprogrammeform">
        @method('post')
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel"> Enregistrement programme entrertien </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6 col-md-12">
              <label for="eventLabel">Vécule</label>
              <select class="form-control form-control-sm" id="vehiculeid" name="vehiculeid" required="required" placeholder="Kilomètrage" />
                <option disabled="true" selected="true" value=""> -- Sélectionner le véhicule -- </option>
                @forelse ($vehicule as $vehicules)
                <option value="{{$vehicules->matricule }}"> {{ ucfirst($vehicules->matricule) }}</option>
                @empty
                <option disabled="true" selected="true">--Aucun Vécule--</option>
              @endforelse
              </select>
            </div>


            <div class="col-sm-6 col-md-6">
              <br>
              <label for="eventLabel">Type d'entretien prévu</label>
                <input class="form-control form-control-sm" id="type_entretient_prochaine" type="text" name="type_entretient_prochaine" placeholder="Type d'entretien prévu" />
            </div>

            <div class="col-sm-6 col-md-6">
              <br>
              <label for="eventLabel">Date prévue</label>
                <input class="form-control form-control-sm" id="date_entretient_prochaine" type="Date" name="date_entretient_prochaine" />
            </div>

          </div>

          <div class="row">

            <div class="col-sm-12 col-md-12">
              <br>
              <label for="eventLabel">Description</label>
              <textarea class="form-control form-control-sm" id="description_entretient_prochaine" type="text" name="description_entretient_prochaine"></textarea>
            </div>

          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" name="addProgrammebtn" id="addProgrammebtn" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Fin vehicule --}}



{{-- Edit fonction modal --}}



{{-- fin Edit fonction modal --}}