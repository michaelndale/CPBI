<div class="modal fade" id="HistoriqueModalScrollable" tabindex="-1" role="dialog"
    aria-labelledby="HistoriqueModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="HistoriqueModalScrollableTitle">
                    <i class="fa fa-info-circle"></i> Historique de ligne budgétaire
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="showHistoriqueContent">
                <h5 class="text-center text-secondary my-5">
                    <center>@include('layout.partiels.load')</center>
                </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>


<script>

$(document).on('click', '.showeHistorique', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');

        $.ajax({
            url: "{{ route('historiqueliste') }}",
            method: 'get',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                toastr.success('Chargement des donnees encours...');

            },
            error: function(xhr) {
                toastr.error('Erreur lors de la récupération des données.');
                console.error('Erreur:', xhr);
            },
            statusCode: {
                404: function() {
                    toastr.error('Ressource non trouvée (404).');
                },
                500: function() {
                    toastr.error('Erreur interne du serveur (500).');
                }
            }
        });
    });  
    
</script>
