<div class="modal fade" id="editthemeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="EditThemeForm" autocomplete="off">
        @method('post')
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              <i class="fa fa-user-edit"></i> Preference Menu
            </h5>
            <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close">
              <span class="fas fa-times fs--1"></span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="form-check form-check-inline">
                <input id="useridtheme" name="useridtheme" type="hidden" value="{{ Auth::user()->id }}" />

                <input class="form-check-input" type="radio" name="menuoption" id="verticalMenuOption" value="0" @if(Auth::user()->menu === 0) checked @endif >
                <label class="form-check-label" for="verticalMenu">Menu vertical</label>
                <br>

                <input class="form-check-input" type="radio" name="menuoption" id="horizontalMenuOption" value="1" @if(Auth::user()->menu === 1) checked @endif >
                <label class="form-check-label" for="horizontalMenu">Menu horizontal</label>

              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="addThemebtn" id="addThemebtn" class="btn btn-primary">Sauvegarder</button>
          </div>
        </div>
      </form>
    </div>
  </div>