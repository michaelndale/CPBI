<div class="modal fade" id="annexModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"> Ajouter le piece justificatif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            @if ($dataFe->bc==1 || $dataFe->facture==1 || $dataFe->om==1 || $dataFe->nec==1 || $dataFe->fpdevis==1 || $dataFe->rm==1 || $dataFe->tdr==1 || $dataFe->bv==1 || $dataFe->recu==1 || $dataFe->ar==1 || $dataFe->be==1 || $dataFe->apc==1 )
            <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                        <i class="mdi mdi-alert-circle-outline me-2"></i>
                        
                        Pour continuer le processus d'ajout du document en annexe. <BR>Assurez-vous d'avoir le  document à votre disposition.
                        <BR>Vous pouvez le prendre en photo ou le scanner et l'envoyer en format (IMAGE, PDF, WORD, EXCEL, POWERPOINT).

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <form id="annexeForm" autocomplete="off" method="POST" >
                    @method('post')
                    @csrf 
                    <div class="row">
                    <input type="hidden" id="projetid" name="projetid" value="{{ Session::get('id') }}" />
                           <input type="hidden" id="febid"    name="febid"    value="{{ $dataFe->id  }}" />

                    @if ($dataFe->bc==1)
                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2">Bon de commande (BC)</label>
                           
                            <input class="form-control" name="boncommande" id="boncommande" type="file" />
                        </div>
                    @endif

                    @if ($dataFe->facture==1)
                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2">Facture</label>
                            <input class="form-control" name="facture" id="facture" type="file" />
                        </div>
                    @endif

                    @if ($dataFe->om==1)
                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2">Ordre de Mission</label>
                            <input class="form-control" name="ordreM" id="ordreM" type="file" />
                        </div>
                    @endif

                    @if ($dataFe->nec==1)
                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2">P.V.A</label>
                            <input class="form-control" name="url_pva" id="url_pva" type="file" />
                        </div>
                    @endif
                        
                    @if ($dataFe->fpdevis==1)
                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2">Facture proformat/Devis/Liste</label>
                            <input class="form-control" name="factureP" id="factureP" type="file" />
                        </div>
                    @endif

                    @if ($dataFe->rm==1)
                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2">Rapport de Mission</label>
                            <input class="form-control" name="rapportM" id="rapportM" type="file" />
                        </div>
                    @endif

                    @if ($dataFe->tdr==1)
                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2">Terme de reference</label>
                            <input class="form-control" name="termeR" id="termeR" type="file" />
                        </div>
                    @endif

                    @if ($dataFe->bv==1)
                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2">Bordereau de versement</label>
                            <input class="form-control" name="bordereauV" id="bordereauV" type="file" />
                        </div>
                    @endif

                    @if ($dataFe->recu==1)
                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2">Reçu</label>
                            <input class="form-control" name="recu" id="recu" type="file" />
                        </div>
                    @endif

                    @if ($dataFe->ar==1)
                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2">Accuse reception</label>
                            <input class="form-control" name="auccuseR" id="auccuseR" type="file" />
                        </div>
                    @endif


                    @if ($dataFe->be==1)
                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2">Bordereau d'expediction</label>
                            <input class="form-control" name="bordereauE" id="bordereauE" type="file" />
                        </div>
                    @endif

                    @if ($dataFe->apc==1)
                        <div class="col-sm-12 col-md-12">
                            <label class="text-1000 fw-bold mb-2">Appel a la participation a la construction au CFK</label>
                            <input class="form-control" name="appelP" id="appelP" type="file" />
                        </div>
                    
                    @endif
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal"> <i class="fa fa-times-circle"></i> Annuller</button>
                <button type="submit" class="btn btn-primary" id="addannexbtn" name="addannexbtn"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
            </div>
            </form>
            @else

<div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
    <i class="mdi mdi-alert-circle-outline me-2"></i>
    Aucun document n'a été précisé comme étant joint à cette FEB lors de sa création. <br>
    Sinon, veuillez <a href="{{ route('showfeb', $cryptedId ) }}"><i class="fa fa-edit"></i> modifier la FEB </a>
    pour continuer le processus d'ajout du document en annexe. <BR>Assurez-vous de cocher la case correspondant au document que vous avez à votre disposition.
    <BR><BR>Vous pouvez le prendre en photo ou le scanner et l'envoyer en format (IMAGE, PDF, WORD, EXCEL, POWERPOINT).

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

@endif
        </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
 $(function() {

$("#annexeForm").submit(function(e) {
e.preventDefault();
const fd = new FormData(this);
$("#addannexbtn").html('<i class="fas fa-spinner fa-spin"></i>');
document.getElementById("addannexbtn").disabled = true; // Désactiver le bouton
$("#loadingModal").modal('show'); // Affiche le popup de chargement

$.ajax({
    url: "{{ route('storeAnnexe') }}",
    method: 'post',
    data: fd,
    cache: false,
    contentType: false,
    processData: false,
    dataType: 'json',
    success: function(response) {
     
        if (response.status == 200) {
            $("#annexeForm")[0].reset();
            $("#annexModal").modal('hide');
            toastr.success("Annexe ajouté avec succès !", "Succès");
         
        } else if (response.status == 201) {
            toastr.error("Attention: Annexe existe déjà !", "Info");
            $("#annexModal").modal('show');
        } else if (response.status == 202) {
            toastr.error("Erreur d'exécution, vérifiez votre connexion Internet", "Erreur");
            $("#annexModal").modal('show');
        } else if (response.status == 203) {
            toastr.error("Erreur d'exécution: " + response.error, "Erreur");
            $("#annexModal").modal('show');
        }

        $("#addannexbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
        document.getElementById("addannexbtn").disabled = false; // Réactiver le bouton
    },
    error: function(xhr, status, error) {
        toastr.error("Erreur d'exécution: " + error, "Erreur");
        $("#annexModal").modal('show');
        $("#addannexbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
        document.getElementById("addannexbtn").disabled = false; // Réactiver le bouton
    }
});
});
 })
  </script>
