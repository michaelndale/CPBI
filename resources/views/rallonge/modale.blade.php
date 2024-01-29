{{-- new compte modal --}}

<div class="modal fade" id="addDealModal"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDealModal" aria-hidden="true">
<div class="modal-dialog modal-xl  modal-dialog-centered">
    <div class="modal-content">
    <form method="POST" id="addFOrm">
    @method('post')
    @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouveau rallonge budgétaire </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg></button>
      </div>
      <div class="modal-body">
      <div class="row g-3">
        <div class="col-sm-6 col-lg-12 col-xl-12">
          <label class="text-1000 fw-bold mb-2">Rubrique du projet</label>
          <div class="row g-2">
            <div class="col">
              <input id="projetid" name="projetid" type="hidden" value="{{ Session::get('id') }}" />
              <input  class="form-control" type="text" placeholder="Enter code" value="{{ Session::get('title') }}" readonly disabled />
            </div>     
            </div>
        </div>

          <div class="col-sm-6 col-lg-12 col-xl-6">
            <label class="text-1000 fw-bold mb-2">Intitulé du compte</label>
            <select class="form-select" id="compteid" name="compteid"  type="text" placeholder="Enter intitulé du compte" >
              <option>--Selectionner compte--</option>
              @forelse ($compte as $comptes)
              <option value="{{ $comptes->id }}">{{ ucfirst($comptes->numero) }} : {{ ucfirst($comptes->libelle) }}</option>
              @empty
              <option>--Aucun compte--</option>
              @endforelse
              
            </select>
          </div>

          
          <div class="col-sm-6 col-lg-12 col-xl-3">
            <label class="text-1000 fw-bold mb-2">Budget </label>
            <input class="form-control" id="budgetactuel" name="budgetactuel"  type="number" placeholder="Budget" />
          </div>
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit"name="savebtn" id="savebtn" class="btn btn-primary" type="button">Sauvegarder</button>
      </div>
      </form>
  </div>
</div>
</div>