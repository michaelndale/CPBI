{{-- new vehicule modal --}}

<div class="modal fade" id="entretientModal" tabindex="-1" role="dialog" aria-labelledby="entretientModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="entretientModalTitle"> Enregistrement des entretiens</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3 mb-6" method="POST" id="addEntretienForm">
          @method('post')
          @csrf
          <div class="row">
            <div class="col-sm-12 col-lg-12 col-xl-3">
              <label class="text-1000 fw-bold mb-2" title="Identifiant unique du véhicule."> Vécule</label>
              <select class="form-select" id="vehiculeid" name="vehiculeid" type="text" required>
                <option disabled="true" selected="true" value=""> -- Sélectionner le véhicule -- </option>
                @forelse ($vehicule as $vehicules)
                <option value="{{$vehicules->matricule }}"> {{ ucfirst($vehicules->matricule) }}</option>
                @empty
                <option disabled="true" selected="true">--Aucun Vécule--</option>
                @endforelse
              </select>
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-3">
              <label class="text-1000 fw-bold mb-2" title="Nature de l'entretien (révision, réparation, changement de pièces, etc.).">Type d'entretien </label>
              <input class="form-control" id="type_entretien" name="type_entretien" type="text" placeholder="Type d'entretien " required />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-2">
              <label class="text-1000 fw-bold mb-2"  title=" Kilométrage du véhicule au moment de l'entretien.">Kilométrage </label>
              <input class="form-control" id="kilometrage"  name="kilometrage" type="number" placeholder="Kilométrage " required />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-2">
              <label class="text-1000 fw-bold mb-2" title="Nom e du garage ou de l'atelier qui a effectué l'entretien.">Garage / Fournisseur </label>
              <select class="form-select" id="fournisseur" name="fournisseur" type="text" required>
                <option disabled="true" selected="true" value="">Garaga/fournisseur</option>
                @forelse ($founisseurs as $founisseur)
                <option value="{{$founisseur->id }}"> {{ ucfirst($founisseur->nom) }}</option>
                @empty
                <option disabled="true" selected="true">--Aucun--</option>
                @endforelse
              </select>
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-2">
              <label class="text-1000 fw-bold mb-2" title="Date à laquelle l'entretien a eu lieu.">Date de l'entretien </label>
              <input class="form-control" id="datejour" name="datejour" type="date" required />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-12">
              <label class="text-1000 fw-bold mb-2" title="Description détaillée des travaux réalisés.">Description des travaux effectués</label>
              <textarea class="form-control " id="description" name="description" type="text" required></textarea>
            </div>
            <BR>
            <hr>
            <div class="table-responsive">
              <table class="table table-striped table-sm fs--1 mb-0" id="tableEstimate">
                <thead style="background-color:#3CB371; color:white">
                  <tr>
                    <th style="width:80px; color:white"><b>Num<span class="text-danger">*</span></b></th>
                    <th style=" color:white"> <b> Description (Articles ou pieces)<span class="text-danger">*</span></b></th>
                    <th style="width:150px;  color:white"><b>Unité<span class="text-danger">*</span></b></th>
                    <th style="width:100px ;  color:white"><b>Q<sup>té <span class="text-danger">*</span></b></sup></th>
                    <th style="width:130px;  color:white"><b>P.U<span class="text-danger">*</span> </b></th>
                    <th style="width:150px;  color:white"><b>P.T<span class="text-danger">*</span></b></th>

                    <th> </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><input style="width:100%" type="number" id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="1"></td>
                    <td><input style="width:100%" type="text" id="libelle" name="libelle[]" class="form-control form-control-sm" required></td>
                    <td><input style="width:100%" type="text" id="unit_cost" name="unit_cost[]" class="form-control form-control-sm unit_price" required></td>
                    <td><input style="width:100%" type="text" id="qty" name="qty[]" class="form-control form-control-sm qty" required></td>
                    <td><input style="width:100%" type="number" id="pu" name="pu[]" min="0" class="form-control form-control-sm pu" required></td>
                    <td><input style="width:100%" type="number" min="0" id="amount" name="amount[]" class="form-control form-control-sm total" value="0" readonly></td>

                    <td><a href="javascript:void(0)" class="text-primary font-18" title="Add" id="addBtn"><i class="fa fa-plus-circle"></i></a></td>
                  </tr>
                  <tr>
                </tbody>
              </table>

              <table class="table table-striped table-sm fs--1 mb-0">
                <tfoot style="background-color:#c0c0c0">
                  <tr>
                    <td colspan="6">Coût total de l'entretien</td>
                    <td align="right"><span class="total-global">0.00 {{ Session::get('devise') }} </span></td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>

              <input type="hidden" id="couttotal" name="couttotal" value="0.00">
            </div>

            <hr>
            <h6> Programmer le prochain entretien </h6>

            <div class="col-sm-12 col-lg-12 col-xl-5">
              <label class="text-1000 fw-bold mb-2" title="Nature du prochain entretien.">Type d'entretien prévu </label>
              <input class="form-control" id="type_entretient_prochaine" name="type_entretient_prochaine" type="text" placeholder="Type d'entretien" />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-2">
              <label class="text-1000 fw-bold mb-2" title="Date prévue pour le prochain entretien.">Date prévue </label>
              <input class="form-control" id="date_entretient_prochaine" name="date_entretient_prochaine" type="date" />
            </div>

            <div class="col-sm-12 col-lg-12 col-xl-5">
              <label class="text-1000 fw-bold mb-2" title="DEcription du prochain entretien.">Dentretien prévu </label>
              <input class="form-control" id="description_entretient_prochaine" name="description_entretient_prochaine" type="text" placeholder="Description" />
            </div>

          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="addentretientbtn" name="addentretientbtn"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
      </div>
      </form>
    </div>
  </div>
</div>


{{-- Fin vehicule --}}