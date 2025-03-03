@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card">

                <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0"><i class="mdi mdi-book-open-page-variant-outline"></i> DEMANDE ET JUSTIFICATION D'AVANCE
                    (DJA)</h4>

                    <div class="page-title-right">
                        <a href="#" id="fetchDataLink"> <i class="fas fa-sync-alt"></i> Actualiser</a>
                     </a>
                
                  </div>
                </div>

        
                <div class="card-body p-0">
                    <div id="tableExample2">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm fs--1 mb-0 table-bordere"
                                style="background-color:#c0c0c0">
                                <tbody id="showSommefeb">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="tableExample2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                <thead>
                                    <tr>
                                        <th>
                                            <center><b>Actions</b></center>
                                        </th>
                                        <th>
                                            <center><b>N<sup>o</sup> DJA</b> </center>
                                        </th>
                                        <th>
                                            <center><b>N<sup>o</sup> DAP</b> </center>
                                        </th>
                                        <th>
                                            <center><b>N<sup>o</sup> FEB</b></center>
                                        </th>
                                       
                                        <th>
                                            <center><b>Avance</b></center>
                                        </th>
                                        <th><b>Fonds reçus par</b></th>
                                        <th><b>OV/Chèque </b></th>
                                        <th><b>
                                                <center>Justifiée ?</center>
                                            </b></th>
                                        <th><b>Créé le. </b></th>
                                        <th><b>Créé par </b></th>

                                    </tr>
                                </thead>


                                <tbody class="show_all" id="show_all">
                                    <tr>
                                        <td colspan="11">
                                            <h5 class="text-center text-secondery my-5">
                                                @include('layout.partiels.load')
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                            <br><br><br><br>
                            <br><br><br><br>
                            <br>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <script>
        $(document).on('input', 'input[name="montant_utiliser[]"]', function() {
            var montantAvance = $(this).closest('tr').find('input[name="montantavance[]"]').val();
            var montantUtilise = $(this).val();
            var surplusManque = parseFloat(montantAvance) - parseFloat(montantUtilise);
            $(this).closest('tr').find('input[name="surplus[]"]').val(surplusManque);
        });

        $(document).on('input', 'input[name="montant_retourne[]"]', function() {
            var surplusManque = parseFloat($(this).closest('tr').find('input[name="surplus[]"]').val());
            var montantRetourne = parseFloat($(this).val());
            var errorMessage = $(this).closest('tr').find('.error-message');
            var addjustifierbtn = $('#addjustifierbtn');

            if (montantRetourne !== surplusManque) {
                errorMessage.text("Le Montant Retourné doit être égal au Surplus/Manque.");
                $(this).addClass('is-invalid');
                addjustifierbtn.prop('disabled', true);
            } else {
                errorMessage.text("");
                $(this).removeClass('is-invalid');
                addjustifierbtn.prop('disabled', false);
            }
        });

        $(document).on('input', '.description-input', function() {
            var descriptionValue = $(this).val().toLowerCase();
            var relatedPlaqueTd = $(this).closest('tr').find('.plaque-input').parent();
            if (descriptionValue.includes('carburant')) {
                relatedPlaqueTd.show();
            } else {
                relatedPlaqueTd.hide();
            }
        });


        $(function() {

            // Add  ajax 
          

            $(document).on('click', '.deleteIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "DJA est sur le point d'être DÉTRUITE ! Faut-il vraiment exécuter « la Suppression » ?  ",

                    showCancelButton: true,
                    confirmButtonColor: 'green',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer !',
                    cancelButtonText: 'Annuller'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('deletedja') }}",
                            method: 'delete',
                            data: {
                                id: id,
                                _token: csrf
                            },
                            success: function(response) {
                                console.log(response);
                                toastr.success("DJA supprimer avec succès !",
                                    "Suppression");
                                fetchAlldja();
                            }
                        });
                    }
                })
            });


            $(document).on('click', '.voirdja', function(e) {
                e.preventDefault(); // Empêcher le comportement par défaut du lien
                var febrefs = $(this).attr('id'); // Utilisez attr() pour obtenir l'ID du lien
                $.ajax({
                    type: 'get',
                    url: "{{ route('getdjas') }}",
                    data: {
                        'id': febrefs
                    },
                    success: function(response) {
                        $("#show_justificatif").html(response);
                    },
                    error: function(xhr, status, error) {
                        var errorMessage =
                            "Attention! \n Erreur de connexion à la base de données, \n veuillez vérifier votre connexion";
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        toastr.error(errorMessage, "Erreur");
                    }
                });
            });


            $(document).on('click', '.editjst', function(e) {
                e.preventDefault(); // Empêcher le comportement par défaut du lien
                var febrefs = $(this).attr('id'); // Utilisez attr() pour obtenir l'ID du lien
                $.ajax({
                    type: 'get',
                    url: "{{ route('getdjasto') }}",
                    data: {
                        'id': febrefs
                    },
                    success: function(response) {
                        $("#edit__justificatif").html(response);
                    },
                    error: function(xhr, status, error) {
                        var errorMessage =
                            "Attention! \n Erreur de connexion à la base de données, \n veuillez vérifier votre connexion";
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        toastr.error(errorMessage, "Erreur");
                    }
                });
            });




            fetchAlldja();

            function fetchAlldja() {
                $.ajax({
                    url: "{{ route('fetchdja') }}",
                    method: 'get',
                    success: function(reponse) {
                        $("#show_all").html(reponse);
                    }
                });
            }
        });
    </script>
@endsection
