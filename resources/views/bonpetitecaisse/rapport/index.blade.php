@extends('layout/app')
@section('page-content')
<div class="main-content">
    <div class="page-content">
        <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">
            <div class="card-header p-1 border-bottom border-300 bg-soft">
                <div class="row g-3 justify-content-between align-items-end">
                    <div class="col-12 col-md">
                        <div class="row g-3">
                            <div class="col-sm-6 col-lg-12 col-xl-3">
                                <label class="text-1000 fw-bold mb-2">Compte caisse:</label>
                                <select class="form-control  form-control-sm" id="compte_bpc" name="compte_bpc" required>
                                    <option disabled="true" selected="true" value="">Sélectionner le compte</option>
                                    @forelse ($compte_bpc as $compte_bpc)
                                    <option value="{{ $compte_bpc->id }}"> {{ $compte_bpc->code }} : {{ $compte_bpc->libelle }} </option>
                                    @empty

                                    <option disabled="true" selected="true" value="">Pas de compte disponible pour ce projet</option>

                                    @endforelse

                                </select>
                            </div>
                            <div class="col-sm-6 col-lg-12 col-xl-3">
                                <label class="text-1000 fw-bold mb-2">Numéro classement :</label>
                                <select class="form-control  form-control-sm" id="numeroCompte" name="numeroCompte" required>
                                    <option disabled="true" selected="true" value="">Sélectionner le numéro</option>

                                </select>
                            </div>
                            <!--  <div class="col-sm-6 col-lg-12 col-xl-2">
                        <label class="text-1000 fw-bold mb-2">Date:</label>
                        <input type="date" name="date" id="date" class="form-control form-control-sm" require />
                    </div>

                   

                    <div class="col-sm-6 col-lg-12 col-xl-2">
                        <label class="text-1000 fw-bold mb-2">Date :</label>
                        <input type="date" name="date" id="date" class="form-control form-control-sm" require />
                    </div>

                    

                    <div class="col-sm-6 col-lg-12 col-xl-2">
                        <label class="text-1000 fw-bold mb-2"> &nbsp; </label>
                        <button class="btn btn-outline-primary btn-sm" id="searchBetweenDates" title="Rechercher" style="width:100%"><i class="fa fa-search"></i> Recherche </button>
                    </div>

-->



                            <div class="col-sm-6 col-lg-12 col-xl-3">
                                <br>
                                <form method="POST" action="{{ route('generate.print.raport') }}">
                                    @csrf
                                    <button class="btn btn-primary btn-sm" id="printResults" style="margin: 10px;">
                                        <i class="fa fa-print"></i> Imprimer les résultats
                                    </button>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div id="tableExample2">
                    <div class="table-responsive" id="table-container" style="overflow-y: auto;">


                        <div id="results">
                            <!-- Les résultats seront affichés ici -->
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div>
<script>
    $(document).ready(function() {
        $('#compte_bpc').change(function() {
            var compteId = $(this).val();
            if (compteId) {
                var url = "{{ url('/Rappport/get-nums') }}/" + compteId;
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#numeroCompte').empty();
                        $('#numeroCompte').append('<option disabled="true" selected="true" value="">Sélectionner le numéro</option>');
                        $.each(data, function(key, value) {
                            $('#numeroCompte').append('<option value="' + value + '">' + value + '</option>');
                        });
                        // toastr.success('Les numéros ont été récupérés avec succès.');
                    },
                    error: function(xhr, status, error) {
                        var errorMessage =  xhr.responseJSON.message || error;
                        $('#results').html('<div class="card-body"><div class=""><div class="alert alert-warning alert-dismissible fade show" role="alert"> <i class="mdi mdi-alert-outline me-2"></i>Erreur lors de la récupération des données , Aucun classement trouvé pour les critères spécifiés a votre recherche <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div></div> </div>');
                        toastr.error('Infos : ' + errorMessage);

                    }
                });
            } else {
                $('#numeroCompte').empty();
                $('#numeroCompte').append('<option disabled="true" selected="true" value="">Sélectionner le numéro</option>');
            }
        });

        function fetchResults() {
            var compteId = $('#compte_bpc').val();
            var numeroId = $('#numeroCompte').val();

            if (compteId && numeroId) {
                $.ajax({
                    url: "{{ url('Rappport/filter-data') }}",
                    type: 'GET',
                    data: {
                        compte_bpc: compteId,
                        numeroCompte: numeroId
                    },
                    success: function(response) {
                        $('#results').html(response);
                        toastr.success('Données récupérées avec succès.');
                    },
                    error: function(xhr) {
                        $('#results').html('<div class="card-body"><div class=""><div class="alert alert-warning alert-dismissible fade show" role="alert"> <i class="mdi mdi-alert-outline me-2"></i>Erreur lors de la récupération des données , Aucun classement trouvé pour les critères spécifiés a votre recherche <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> </div></div> </div>');
                        toastr.error('Erreur lors de la récupération des données : ' + xhr.responseText);
                    }
                });
            } else {
                $('#results').empty();
            }
        }

        $('#compte_bpc, #numeroCompte').on('change', function() {
            fetchResults();
        });

   /*     $('#printResults').click(function(e) {
            e.preventDefault(); // Empêche la soumission du formulaire par défaut

            var compteId = $('#compte_bpc').val();
            var numeroId = $('#numeroCompte').val();


            if (validateInputs(compteId, numeroId)) {

                    // Désactive le bouton et affiche l'icône de chargement
            $("#printResults").html('<i class="fas fa-spinner fa-spin"></i>');
            document.getElementById("printResults").disabled = true;

            if (compteId && numeroId) {
                $.ajax({
                    url: "{{ route('generate.print.raport') }}",
                    type: 'POST',
                    xhrFields: {
                        responseType: 'blob' // Important pour recevoir un fichier binaire (PDF)
                    },
                    data: {
                        _token: '{{ csrf_token() }}', // Inclure le token CSRF
                        compte_bpc: compteId,
                        numeroCompte: numeroId
                    },
                    success: function(response) {
                        // Créer un URL temporaire pour le fichier PDF
                        var blob = new Blob([response], {
                            type: 'application/pdf'
                        });
                        var url = window.URL.createObjectURL(blob);

                        // Ouvrir le PDF dans une nouvelle fenêtre
                        var printWindow = window.open(url, '_blank');
                        printWindow.focus();

                        // Réinitialiser le bouton après l'affichage du PDF
                        $("#printResults").html('<i class="fa fa-print"></i> Imprimer les résultats');
                        document.getElementById("printResults").disabled = false;
                    },
                    error: function(xhr, status, error) {
                        // Affiche le message d'erreur générique
                        toastr.error('Erreur : nous avons rencontré une erreur:' + error);

                        // Affiche des détails supplémentaires dans la console pour le débogage
                        console.error('Détails de l\'erreur :', {
                            status: status,
                            error: error,
                            responseText: xhr.responseText
                        });

                        // Met à jour l'interface utilisateur
                        $("#printResults").html('<i class="fa fa-print"></i> Imprimer les résultats');
                        document.getElementById("printResults").disabled = false;
                    }
                });
            } else {
                toastr.error('Veuillez sélectionner un compte et un numéro avant d\'imprimer.');
                $("#printResults").html('<i class="fa fa-print"></i> Imprimer les résultats');
                document.getElementById("printResults").disabled = false;
            }
                


            } else {
                toastr.error('Veuillez entrer des informations valides.');
            }



            function validateInputs(compteId, numeroId) {
                const comptePattern = /^[0-9]+$/; // Exemple d'une règle simple pour le compte
                return comptePattern.test(compteId) && numeroId.length > 0;
            }

        
        });

*/

$('#printResults').click(function(e) {
    e.preventDefault();  // Empêche la soumission du formulaire par défaut

    var compteId = $('#compte_bpc').val();
    var numeroId = $('#numeroCompte').val();

    if (compteId && numeroId) {
        $.ajax({
            url: "{{ route('generate.print.raport') }}",
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Inclure le token CSRF
                compte_bpc: compteId,
                numeroCompte: numeroId
            },
            success: function(response) {
                // Ouvrir le document imprimable dans une nouvelle fenêtre
                var printWindow = window.open('', '', 'width=800,height=600');
                printWindow.document.write(response); // Insérer la réponse du serveur (HTML) dans la nouvelle fenêtre
                printWindow.document.close(); // Fermer l'écriture dans le document
                printWindow.focus(); // Mettre la fenêtre en avant
                printWindow.print(); // Lancer l'impression
            },
            error: function(xhr, status, error) {
                console.log('Erreur : ', error);
            }
        });
    } else {
        toastr.error('Veuillez sélectionner un compte et un numéro avant d\'imprimer.');
    }
});



    });
</script>




@endsection