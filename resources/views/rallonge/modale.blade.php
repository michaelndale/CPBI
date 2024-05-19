{{-- new compte modal --}}

<div class="modal fade" id="addDealModal"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDealModal" aria-hidden="true">
<div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
    <form method="POST" id="addFOrm">
    @method('post')
    @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouveau budgétisation  </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        
      </div>
      <div class="modal-body">
      <div class="row g-3">
      <!--  <div class="col-sm-6 col-lg-12 col-xl-12">
          <label class="text-1000 fw-bold mb-2">Rubrique du projet</label>
          <div class="row g-2">
            <div class="col">
              
              <input  class="form-control" type="text" placeholder="Enter code" value="{{ Session::get('title') }}" readonly disabled  style="background-color:#F5F5F5" />
            </div>     
            </div>
        </div>  -->

        <input id="projetid" name="projetid" type="hidden" value="{{ Session::get('id') }}" />

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
          <hr>

          <div class="col-sm-6 col-lg-12 col-xl-12">
            <center>
              <label class="text-1000 fw-bold mb-2">Type du budgét : &nbsp; &nbsp; &nbsp; </label>
              @foreach ($typebudget as $index => $typebudgets)
                  <input id="budgetactuel{{ $index }}" name="typeprojet" type="radio" value="{{ $typebudgets->id }}" @if($index == 0) checked @endif required/> {{ $typebudgets->titre }} &nbsp; &nbsp; 
              @endforeach
              </center>
          
            
            </div>
            <hr>

          <div id="cacheMoi">

            <div class="col-sm-12 col-lg-12 col-xl-12">

            <div class="form-check form-switch mb-3" dir="ltr">
              <input type="checkbox" class="form-check-input" name="customSwitch1" id="customSwitch1" onchange="toggleUrldocInput(this)" style="color: red;">
              <label class="form-check-label" for="customSwitch1"  style="color: red;">Condition d'utilisation de la ligne  <i class="fa fa-info-circle"></i></label>
            </div>

              <input class="form-control" id="urldoc" name="urldoc" type="url" placeholder="Lien du document" style="display: none; color:red" />



            </div>

           

          </div>
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="savebtn" id="savebtn" class="btn btn-primary" type="button"> <i class="fa fa-cloud-upload-alt"></i>  Sauvegarder</button>
      </div>
      </form>
  </div>
</div>
</div>

<!-- Revision budgetaire -->
<div class="modal fade" id="revisionModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="revisionModal" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" id="editrevisionform">
        @method('post')
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="verticallyCenteredModalLabel"><i class="fa fa-edit"></i> Revision de la ligne budgétaire </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="row g-3">

            <div class="col-sm-12 col-lg-12 col-xl-12">
              Description
              <textarea type="text" name="r_libelle" id="r_libelle" class="form-control" style="height:100px"></textarea>
              
            </div>
            
            <div class="col-sm-6 col-lg-12 col-xl-6">
              Code
              <input type="text" name="r_code" id="r_code" class="form-control" />
            </div>

            <div class="col-sm-6 col-lg-12 col-xl-6">
              Budget
              <input type="number"   name="r_budgetactuel" id="r_budgetactuel" class="form-control" />
              <input type="hidden" name="ancienmontantligne" id="ancienmontantligne" class="form-control" />
              <input type="hidden" name="r_souscompte" id="r_souscompte" class="form-control" />
              <input type="hidden" name="r_idligne" id="r_idligne" class="form-control" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="revisionbtn" id="revisionbtn" class="btn btn-primary" type="button"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- fin -->






<!-- modif -->
<div class="modal fade" id="EditDealModal"  data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditDealModal" aria-hidden="true">
<div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
    <form method="POST" id="EditForm">
    @method('post')
    @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="verticallyCenteredModalLabel"> <i class="fa fa-edit"></i> Modifier la ligne budgetaire  </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="row g-3">

          <div class="col-sm-6 col-lg-12 col-xl-12">
          
          <label class="text-1000 fw-bold mb-2">Sous compte</label>
          <input type="text"  name="idligne" id="idligne" class="idligne" />
          <textarea class="form-control"  id="titreligne" name="titreligne" type="text" placeholder="Entrer intitulé du compte" required></textarea>
        </div>

          
          <div class="col-sm-6 col-lg-12 col-xl-12">
            <label class="text-1000 fw-bold mb-2">Budget </label>
            <input class="form-control"  id="montantligne" name="montantligne"  type="number"  placeholder="Budget" required/>
          </div>
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="deleterallo" id="deleterallo" class="btn btn-danger" type="button"> <i class="fa fa-times-circle"></i> Supprimer </button>
        <button type="submit" name="editRbtn" id="editRbtn" class="btn btn-primary" type="button"> <i class="fa fa-checked"></i>  Sauvegarder le mis ajours</button>
      </div>
      </form>
  </div>
</div>
</div>