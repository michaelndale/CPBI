<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <span style="color:#3CB371">
                    <i class="fas fa-spinner fa-spin"></i> Chargement en cours...
                </span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addfebModal" tabindex="-1" aria-labelledby="addfebModal" aria-hidden="true">
    <div class="modal-dialog modal-xl  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="far fa-file-alt "></i> BON PETITE CAISSE > FICHE D’EXPRESSION DES BESOINS "FEB" </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 mb-6" method="POST" id="addfebForm">
                    @method('post')
                    @csrf
                    <div id="tableExample2">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm fs--1 mb-0">
                                <tbody class="list">
                                    <tr>
                                        <td class="align-middle ps-3 name" style="width:20%">Composante/ Projet/Section</td>
                                        <td class="align-middle email" colspan="3">
                                            <input value="{{ Session::get('id') }} " type="hidden" name="projetid" id="projetid">
                                            <input value="{{ Session::get('title') }} " class="form-control form-control-sm" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle ps-3 name">Compte petite caisse: <span class="text-danger">*</span></td>
                                        <td class="align-middle email">
                                            <select class="form-control  form-control-sm" id="compteid" name="compteid" required>
                                                <option disabled="true" selected="true" value="">--Sélectionner Compte--</option>
                                                @foreach ($compte as $comptes)
                                                <option value="{{ $comptes->id }}"> {{ $comptes->code }} : {{ ucfirst($comptes->libelle) }} </option>
                                                @endforeach
                                            </select>

                                        </td>

                                        <td class="align-middle ps-3 name">Description de la demande<span class="text-danger">*</span></td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" name="description" id="description" required>
                                        </td>
                                    </tr>


                                    <tr>

                                        <td class="align-middle ps-3 name">
                                            Numéro du fiche FEB<span class="text-danger">*</span> <br>
                                            <input type="number" name="numerofeb" id="numerofeb" class="form-control form-control-sm" style="width: 100% ;">
                                            <smal id="numerofeb_error" name="numerofeb_error" class="text text-danger"> </smal>
                                            <smal id="numerofeb_info" class="text text-primary"> </smal>
                                        </td>

                                        <td class="align-middle ps-3 name">
                                            Montant demande FEB<span class="text-danger">*</span> <br>
                                            <input type="number" name="montantfeb" id="montantfeb" class="form-control form-control-sm" style="width: 100% ;">

                                        </td>

                                        <td class="align-middle ps-3 name"> Date du dossier FEB:<span class="text-danger">*</span><br>
                                            <input type="date" class="form-control form-control-sm" name="datefeb" id="datefeb" style="width: 100%" required>
                                        </td>
                                        <td class="align-middle ps-3 name"> Date limite:<span class="text-danger">*</span><br>
                                            <input type="date" class="form-control form-control-sm" name="datelimite" id="datelimite" style="width: 100%">
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                            <hr>

                            <div class="table-repsonsive">
                                <span id="error"></span>
                                <table class="table table-striped table-sm fs--1 mb-0">
                                    <tr>
                                    <tr>
                                        <td>Etablie par (AC/CE/CS) <span class="text-danger">*</span> </td>
                                        <td>Vérifiée par (Comptable) <span class="text-danger">*</span></td>
                                        <td>Approuvée par (Chef de Composante/Projet/Section): <span class="text-danger">*</span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select type="text" class="form-control form-control-sm" name="acce" id="acce" required>
                                                <option disabled="true" selected="true" value="">--Sélectionner (AC/CE/CS)--</option>
                                                @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select type="text" class="form-control form-control-sm" name="comptable" id="comptable" required>
                                                <option disabled="true" selected="true" value="">--Sélectionner comptable--</option>
                                                @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select type="text" class="form-control form-control-sm" name="chefcomposante" id="chefcomposante" required>
                                                <option disabled="true" selected="true" value="">--Sélectionner Chef de Composante/Projet/Section--</option>
                                                @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->userid }}"> {{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="addfebbtn" name="addfebbtn"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
            </div>
            </form>
        </div>
    </div>
</div>