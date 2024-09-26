<div class="modal fade" id="addModale" tabindex="-1" aria-labelledby="addModale" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvelle communication </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 mb-6" method="POST" id="addForm">
                    @method('post')
                    @csrf

                    <div class="col-sm-12 col-lg-12 col-xl-9">
                        <label class="text-1000 fw-bold mb-2">Titre :</label>
                        <input type="text" name="titre" id="titre" class="form-control" />
                    </div>

                    <div class="col-sm-12 col-lg-12 col-xl-3">
                        <label class="text-1000 fw-bold mb-2">Date limite de publication:</label>
                        <input type="date" name="datelimite" id="datelimite" class="form-control" />
                    </div>
                   

                    <div class="col-sm-12 col-lg-12 col-xl-12">
                        Description
                        <textarea type="text" name="description" id="description" class="form-control" style="height:250px"></textarea>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="submit" name="addbtn" id="addbtn" class="btn btn-primary px-5 px-sm-15"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder </button>
            </div>

        </div>
        </form>
    </div>
</div>