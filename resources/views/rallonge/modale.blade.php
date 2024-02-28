{{-- new compte modal --}}

<div class="modal fade" id="addDealModal"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDealModal" aria-hidden="true">
<div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
    <form method="POST" id="addFOrm">
    @method('post')
    @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouveau budgétisation  </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
      </div>
      <div class="modal-body">
      <div class="row g-3">
        <div class="col-sm-6 col-lg-12 col-xl-12">
          <label class="text-1000 fw-bold mb-2">Rubrique du projet</label>
          <div class="row g-2">
            <div class="col">
              <input id="projetid" name="projetid" type="hidden" value="{{ Session::get('id') }}" />
              <input  class="form-control" type="text" placeholder="Enter code" value="{{ Session::get('title') }}" readonly disabled  style="background-color:#F5F5F5" />
            </div>     
            </div>
        </div>

          <div class="col-sm-6 col-lg-12 col-xl-12">
          
            <label class="text-1000 fw-bold mb-2">Compte principal</label>
            <select class="form-select compteid" id="compteid" name="compteid"  type="text" placeholder="Entrer intitulé du compte" required>
            <option disabled="true" selected="true" value=""> -- Sélectionner compte principal -- </option>
              @forelse ($compte as $comptes)
                <option value="{{ $comptes->id }}">{{ ucfirst($comptes->numero) }} : {{ ucfirst($comptes->libelle) }}</option>
              @empty
              <option disabled="true" selected="true">--Aucun compte--</option>
              @endforelse
              
            </select>
          </div>

          <div class="col-sm-6 col-lg-12 col-xl-8">
          
          <label class="text-1000 fw-bold mb-2">Sous compte</label>
          <select class="form-select scomptef" id="scomptef" name="scomptef"  type="text" placeholder="Entrer intitulé du compte" required>
            <option disabled="true" selected="true"> -- Sélectionner sous compte -- </option>
          </select>
        </div>

          
          <div class="col-sm-6 col-lg-12 col-xl-4">
            <label class="text-1000 fw-bold mb-2">Budget </label>
            <input class="form-control" id="budgetactuel" name="budgetactuel"  type="number" min="1" placeholder="Budget" required/>
          </div>
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="savebtn" id="savebtn" class="btn btn-primary" type="button"> Sauvegarder</button>
      </div>
      </form>
  </div>
</div>
</div>