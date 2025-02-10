<div class="modal fade" id="editMotdepasseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="EditNDPForm" autocomplete="off">
        @method('post')
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-edit"></i> Modifier mot de passe </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-6 col-md-12">
                <div class="form-floating mb-3">
                  <input id="userid" name="userid" type="hidden" value="{{ Auth::user()->id }}" />

                  <input class="form-control" id="anpwd" name="anpwd" type="password" required="required" placeholder="Ancient mot de passe" />
                  <label for="Identifiant">Anciant mot de paase</label>
                  <span id="identifiant_error" name="ancienmotdepasse_error" class="text text-danger"> </span>
                </div>
              </div>
              <div class="col-sm-6 col-md-12">
                <div class="form-floating mb-3">
                  <input class="form-control" id="npwd" name="npwd" type="password" required="required" placeholder="Nouveau mot de passe" />
                  <label for="Identifiant">Nouveau mot de paase</label>
                  <span id="identifiant_error" name="nouveaumotdepasse_error" class="text text-danger"> </span>
                </div>
              </div>
              <div class="col-sm-6 col-md-12">
                <div class="form-floating mb-3">
                  <input class="form-control" id="cpwd" name="cpwd" type="password" required="required" placeholder="Confirmation le nouveau mot de passe" />
                  <label for="Password">Confirmer le nouveau mot de passe</label>
                </div>
              </div>
            </div>




          </div>
          <div class="modal-footer">
            <button type="submit" name="addNDPbtn" id="addNDPbtn" class="btn btn-primary">Sauvegarder</button>
          </div>
        </div>
      </form>
    </div>
  </div>