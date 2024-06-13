<div class="modal fade" id="composemodal" tabindex="-1" role="dialog" aria-labelledby="composemodalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="composemodalTitle">Signalé DAP (N°  {{ $datadap->numerodp  }}  )</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="addMessageForm">
                @method('post')
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 col-lg-12 col-xl-10">
                            <input type="hidden" id="createdaps" name="createdaps" value="{{ $etablienom->usersid }}" class="form-control">
                            <input type="hidden" id="dapids" name="dapids" value="{{ $datadap->id }}" class="form-control" >
                            <input type="text" id="messagesignale" name="messagesignale" class="form-control" placeholder="Entrer le message ..." required>
                        </div>
                        <div class="col-sm-6 col-lg-12 col-xl-2">
                            <button type="submit" id="btnsend" name="btnsend" class="btn btn-primary">Envoyer<i class="fab fa-telegram-plane ms-1"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="chat-conversation py-3" style="max-height: 350px; overflow-y: auto; margin-left:20px">
                <ul class="list-unstyled mb-0 pe-3" data-simplebar id="show_all_signale_dap" >
                </ul>
            </div>
        </div>
    </div>
</div>


<script>

$(function() {
    var dapid; // Déclaration de la variable dapid

    // Événement de clic sur le bouton de signalement FEB
    $("button[data-bs-target='#composemodal']").click(function() {
        dapid = $(this).data('dapid');
        if (dapid) {
            fetchAllsignaledap(dapid);
        } else {
            console.error("DAP non défini");
        }
    });

    // Soumission du formulaire de signalement FEB
    $("#addMessageForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);

        $("#btnsend").html('<i class="fas fa-spinner fa-spin"></i>');
        $("#btnsend").prop('disabled', true);

        $.ajax({
            url: "{{ route('storesignaledap') }}",
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 200) {
                    toastr.success("DAP signalé avec succès!", "Enregistrement");
                    $("#btnsend").html('Envoyer<i class="fab fa-telegram-plane ms-1"></i>');
                    $("#addMessageForm")[0].reset(); // Réinitialiser le formulaire
                    $("#composemodal").modal('show');
                    $("#btnsend").prop('disabled', false);
                    if (dapid) {
                        fetchAllsignaledap(dapid); // Appel de la fonction avec dapid
                    }
                } else if (response.status == 201) {
                    toastr.error("Le type budget existe déjà !", "Erreur");
                    $("#btnsend").html('<i class="fa fa-cloud-upload-alt"></i> Envoyer');
                    $("#btnsend").prop('disabled', false);
                } else {
                    toastr.error("Une erreur s'est produite lors du traitement de votre demande.", "Erreur");
                    $("#btnsend").html('<i class="fa fa-cloud-upload-alt"></i> Envoyer');
                    $("#btnsend").prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                toastr.error("Une erreur s'est produite lors du traitement de votre demande.", "Erreur", error);
                $("#btnsend").html('<i class="fa fa-cloud-upload-alt"></i> Envoyer');
                $("#btnsend").prop('disabled', false);
                toastr.error("Réponse du serveur :", xhr.responseText);
            }
        });
    });

    // Fonction pour récupérer les signalements FEB
    function fetchAllsignaledap(dapid) {
        $.ajax({
            url: "{{ route('fetchAllsignaledap', ['dapid' => '']) }}/" + dapid,
            method: 'get',
            success: function(reponse) {
                $("#show_all_signale_dap").html(reponse);
            },
            error: function(xhr, status, error) {
                toastr.error("Erreur lors de la récupération des signalements DAP:", error);
            }
        });
    }
});


</script>