

<div class="modal fade" id="HistoriqueModalScrollable" tabindex="-1" role="dialog" aria-labelledby="HistoriqueModalScrollableTitle" aria-hidden="true">
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
$(document).ready(function() {
    $('.showeHistorique').on('click', function(event) {
        event.preventDefault();
        var hid = $(this).data('id'); // Récupère l'ID à envoyer

        // Afficher un message de chargement
        $('#showHistoriqueContent').html('<h5 class="text-center text-secondary my-5">Chargement en cours...</h5>');

        // Envoyer une requête GET avec AJAX
        $.ajax({
            url: '{{ route("historiqueliste") }}', // URL de la route
            method: 'GET', // Méthode GET
            data: { id: hid }, // Envoyer l'ID comme paramètre
            success: function(response) {
                // Injecte le contenu reçu dans le modal
                $('#showHistoriqueContent').html(response);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $('#showHistoriqueContent').html('<p>Erreur lors de la récupération des données.</p>');
            }
        });
    });
});

</script>
