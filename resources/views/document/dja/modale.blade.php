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
    <div class="modal-dialog modal-fullscreen modal-dialog-centered  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus-circle"></i> ajouter l'utilisation de l'Avance</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 mb-6" method="POST" id="addjdaForm">
                    @method('post')
                    @csrf

                    <table class="table table-striped table-sm fs--1 mb-0 table-bordered" style="width:100%;">
                                <tbody class="list">
                                    <tr>
                                        <td class="align-middle ps-3 name" style="width:15%">Composante/ Projet/Section</td>
                                        <td class="align-middle email" colspan="15">
                                            <input value="{{ Session::get('id') }} " type="hidden" name="projetid" id="projetid">
                                            <input value="{{ Session::get('title') }} " class="form-control form-control-sm" disabled>
                                        </td>
                                    </tr>
                                </tbody>
                    </table>

                    <div class="show_justificatif" id="show_justificatif">

                        
                    </div>
            </div>
            <div class="modal-footer">
                <button  id="addjustifierbtn" name="addjustifierbtn" class="btn btn-primary addjustifierbtn" type="submit"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editdjaModale" tabindex="-1" aria-labelledby="djaModale" style="display: none;" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modification Dja justification de l'utilisation de l'avance</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 mb-6" method="POST" id="editjdaForm">
                    @method('post')
                    @csrf
                    <table class="table table-striped table-sm fs--1 mb-0">
                                <tbody class="list">
                                    <tr>
                                        <td class="align-middle ps-3 name" style="width:15%">Composante/ Projet/Section</td>
                                        <td class="align-middle email" colspan="15">
                                            <input value="{{ Session::get('id') }} " type="hidden" name="projetid" id="projetid">
                                            <input value="{{ Session::get('title') }} " class="form-control form-control-sm" disabled>
                                        </td>
                                    </tr>
                                </tbody>
                    </table>


                    <div class="edit__justificatif" id="edit__justificatif">

                        
                    </div>
            </div>
            <div class="modal-footer">
                <button  id="edjitustifierbtn" name="editjustifierbtn" class="btn btn-primary editjustifierbtn" type="submit"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
            </div>
            </form>
        </div>
    </div>
</div>


