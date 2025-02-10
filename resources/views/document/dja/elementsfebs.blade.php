<form method="POST" id="addfebForm">
    @method('post')
    @csrf

    
<div class="modal fade" id="febinfo" tabindex="-1" aria-labelledby="febinfo" aria-hidden="true">
  
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">

            <input type="hidden" value="{{ $data->iddjas }}" name="djaid">
           
            <div class="modal-header">
                <h5 class="modal-title"><i class="far fa-file-alt"></i> Détails sur l'utilisation des fonds demandés : </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" class="showContent" id="showContent">
                <h5 class="text-center text-secondary my-5">
                    <center>@include('layout.partiels.load')</center>
                </h5>         
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal"><i class="fa fa-times-circle"></i> Annuller</button>
                <button type="submit" class="btn btn-primary" id="addfebbtn" name="addfebbtn" > <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
            </div>

       
        </div>
  
    </div>
</div>
</form>
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
            url: '{{ route("dja-get-feb-details") }}',
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


$("#addfebForm").submit(function(e) {
                    e.preventDefault();
                    const fd = new FormData(this);

                    $("#addfebbtn").html('<i class="fas fa-spinner fa-spin"></i>');
                    document.getElementById("addfebbtn").disabled = true;

                    $.ajax({
                        url: "{{ route('store.utilisation') }}",
                        method: 'post',
                        data: fd,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 200 ) {

                               

                                document.getElementById("addfebbtn").disabled = false;
                                toastr.success("Rapport  ajouté avec succès !", "Enregistrement");

                                $("#addfebbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');

                                // Rediriger ou actualiser la page après 2 secondes (2000 ms)
                                    setTimeout(function () {
                                        // Option 1 : Actualiser la page actuelle
                                        window.location.reload();

                                        // Option 2 : Rediriger vers une autre page (décommentez cette ligne si nécessaire)
                                        // window.location.href = response.redirect || '/votre-url-cible';
                                    }, 1000); // Délai de 2 secondes avant l'action
                                                            

                           //  window.location.href = response.redirect;
                             

                            } else if (response.status == 201) {
                                toastr.error("Attention: FEB numéro existe déjà , vous ne pouvez envoyez le feb deux fois !", "Attention");
                                document.getElementById("addfebbtn").disabled = false;
                                $("#addfebbtn").html('<i class="fa fa-cloud-upload-alt"></i>  Sauvegarder');

                            } else if (response.status == 202) {

                                toastr.error("Erreur d'exécution: " + response.error, "Erreur");
                                document.getElementById("addfebbtn").disabled = false;
                                $("#addfebbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');

                            } else if (response.status == 203) {
                                // Affiche la modale d'erreur avec le message d'avertissement
                                $('#errorMessage').text("Tu ne peux pas exécuter cette opération car tu as dépassé le montant autorisé." );
                                $('#erreurMessage').modal('show'); // Affiche la modale

                                document.getElementById("addfebbtn").disabled = false;
                                $("#addfebbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');

                            } else if (response.status == 204) {
                                toastr.error(response.message, "Attention");

                                document.getElementById("addfebbtn").disabled = false;
                                $("#addfebbtn").html( '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            }

                            $("#addfebbtn").text('Sauvegarder');
                            setTimeout(function() {

                            }, 600); // 600 millisecondes = 0.6 secondes
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            toastr.error("Erreur de communication avec le serveur.", "Erreur");
                            document.getElementById("addfebbtn").disabled = false;
                            $("#addfebbtn").html( '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');

                        }
                    });
                });

  
});



</script>






