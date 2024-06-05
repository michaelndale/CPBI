

<!-- Modal d'information sur le FEB -->
<div class="modal fade" id="febinfo" tabindex="-1" aria-labelledby="febinfo" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="far fa-file-alt"></i> Détails sur l'utilisation des fonds demandés : </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" class="showContent" id="showContent">
                <h5 class="text-center text-secondary my-5">
                    <center>@include('layout.partiels.load')</center>
                </h5>         
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

$(document).ready(function() {

    $('#febinfo').modal({
        backdrop: 'static',
        keyboard: false
      });

    $('.infofeb').on('click', function(event) {
        event.preventDefault();
        var febId = $(this).data('id');

        // Affichage du modal de chargement
      

        // Effectuer une requête AJAX pour obtenir les données du FEB
        $.ajax({
            url: '{{ route("get-feb-details") }}',
            method: 'POST',
            data: {
                id: febId,
                _token: '{{ csrf_token() }}' // Ajoutez le jeton CSRF ici
            },
            success: function(response) {
                // Masquer le modal de chargement
             
                // Mettre à jour le contenu du modal avec les données récupérées
                $('#showContent').html(response);
                // Afficher le modal avec les détails du FEB
                $('#febinfo').modal('show');
            },
            error: function(xhr) {
                // Masquer le modal de chargement
           
                // Gérer les erreurs ici
                console.error(xhr.responseText);
                $('#showContent').html('<p>Erreur lors de la récupération des données.</p>');
                // Afficher le modal avec le message d'erreur
                $('#febinfo').modal('show');
            }
        });
    });

  
});
</script>



