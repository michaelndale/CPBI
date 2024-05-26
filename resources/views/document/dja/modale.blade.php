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
                <h5 class="modal-title">Ajouter l'utilisation de l'avance</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 mb-6" method="POST" id="addjdaForm">
                    @method('post')
                    @csrf
                    <div class="show_justificatif" id="show_justificatif">

                        <input type="number" value="1" id="iddap" name="iddap">
                        <input type="number" value="1" id="iddjas" name="iddjas">


                        <div class="table-responsive">
                          
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button  id="addjustifierbtn" name="addjustifierbtn" class="btn btn-primary addjustifierbtn" type="submit"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
            </div>
            </form>
        </div>
    </div>
</div>