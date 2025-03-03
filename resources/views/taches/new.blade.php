
{{-- new banque modal --}}
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalTitle"><i class="fa fa-plus-circle"></i> Nouvelle responsabilite</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="addform">
              @method('post')
              @csrf
            <div class="modal-body">
                <input type="hidden" name="responsabilite_id" id="responsabilite_id" value={{ $responsabilite->id }}>
                <input class="form-control" id="titre" name="titre" type="text" placeholder="Entrer la responsabilite" required /> <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                <button type="submit" name="addsave" id="addsave"  class="btn btn-primary waves-effect waves-light"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
            </div>
            </form>
  
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


  
  