<div class="modal fade" id="EditPersonnelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="EditPersonnelForm" autocomplete="off">
        @method('post')
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-edit"></i> Modifier mon compte</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
          </div>
          <div class="modal-body">
            <div class="row">

              <input id="per_id" name="per_id" type="hidden" />

              <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <input class="form-control" id="per_nom" name="per_nom" type="text" required="required" placeholder="Identifiant" />
                  <label for="Identifiant">Nom</label>
                  <span id="identifiant_error" name="nom_error" class="text text-danger"> </span>
                </div>
              </div>
              <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <input class="form-control" id="per_prenom" type="text" name="per_prenom" required="required" placeholder="Password" />
                  <label for="Password">Prénom </label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <select class="form-control" id="per_sexe" name="per_sexe" type="text" required="required" placeholder="Identifiant">
                    <option value="">Séléctionner genre</option>
                    <option value="Femme">Femme</option>
                    <option value="Homme">Homme</option>
                  </select>
                  <label for="sexe">Sexe</label>
                </div>
              </div>
              <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-3">
                  <input class="form-control" id="per_phone" type="text" name="per_phone" required="required" placeholder="Téléphone" />
                  <label for="Password">Téléphone </label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12 col-md-12">
                <div class="form-floating mb-3">
                  <input class="form-control" id="per_email" name="per_email" type="text" required="required" placeholder="Email" />
                  <label for="email">Email</label>
                  <span id="email_error" name="email_error" class="text text-danger"> </span>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">

            <button type="submit" name="EditPersonnelbtn" id="EditPersonnelbtn" class="btn btn-primary">Sauvegarder</button>
          </div>
        </div>
      </form>
    </div>
  </div>