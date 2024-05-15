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

<div class="modal fade" id="djaModale" tabindex="-1" aria-labelledby="djaModale" style="display: none;" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rapport d'utilisation de l'avance</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 mb-6" method="POST" id="addjdaForm">
                    @method('post')
                    @csrf



                    <div class="show_justificatif" id="show_justificatif">

                        <input type="number" value="1" id="iddap" name="iddap">
                        <input type="number" value="1" id="iddjas" name="iddjas">


                        <div class="table-responsive">
                            <table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td class="align-middle ps-3 name"> <b>Numéro du FEB</b> <input type="number" name="numerofeb[]" id="numerofeb[]" style="width: 100%; border:1px solid #c0c0c0" /> </td>
                                        <td class="align-middle ps-3 name"> <b>Montant de l'Avance</b> <input type="number" name="montantavance[]" id="montantavance[]" style="width: 100%; border:1px solid #c0c0c0" /></td>
                                        <td class="align-middle ps-3 name"> <b>Montant utiliser</b> <input type="number" name="montantutiliser[]" id="montantutiliser[]" style="width: 100%; border:1px solid #c0c0c0" /></td>
                                        <td class="align-middle ps-3 name"> <b>Surplus/Manque</b> <input type="number" name="surplus[]" id="surplus[]" style="width: 100%; border:1px solid #c0c0c0" /></td>
                                        <td class="align-middle ps-3 name"> <b>Montant Retourne</b> <input type="number" name="montantretour[]" id="montantretour[]" style="width: 100%; border:1px solid #c0c0c0" /></td>
                                        <td class="align-middle ps-3 name"> <b>Bordereau versement</b> <input type="number" name="bordereau[]" id="bordereau[]" style="width: 100%; border:1px solid #c0c0c0" /></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>

                    <table>
                        <tr>

                            <td class="align-middle ps-3 name" colspan="7"> <b>Reception des pieces justificatives de l'utilisation de l'avance par: </b>
                                <select type="text" class="form-control form-control-sm" name="receptionpar" id="receptionpar" style="width:40%">
                                    <option value="">--Selectionnez personnel--</option>
                                    @foreach ($personnel as $personnels)
                                    <option value="{{ $personnels->id }}"> {{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    </table>
            </div>
            <div class="modal-footer">
                <button  id="addjustifierbtn" name="addjustifierbtn" class="btn btn-primary addjustifierbtn" type="submit">Enregistrer</button>
            </div>
            </form>
        </div>
    </div>
</div>