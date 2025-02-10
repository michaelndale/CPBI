@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-7" style="margin:auto">
                    <div class="card">
                        <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">
                                <h4 class="mb-sm-0"><i class="fa fa-folder"></i> Pays</h4>
                                <div class="page-title-right">
                                    <a href="javascript:voide();"
                                        class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addModal" aria-haspopup="true" aria-expanded="false"
                                        data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Créer </a>
                                    </a>
                                </div>
                          
                        </div>
                        <div class="card-body pt-0 pb-3">
                            <div id="overview-chart" data-colors='["#1f58c7"]' class="apex-charts" dir="ltr"></div>
                            <div class="table-responsive">

                                <table class="table table-striped table-sm fs--1 mb-0">
                                    <thead>
                                        <thead>
                                            <tr>
                                                <th><b>Nom</b></th>
                                                <th><b>Code</b></th>
                                                <th><b>Code telephone</b></th>
                                                <th><b>Statut</b></th>
                                                <th><b>Actions</b></th>
                                            </tr>
                                        </thead>
                                    <tbody id="countriesTableBody">
                                        <!-- Country rows will be dynamically added here by JavaScript -->
                                    </tbody>


                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="addpaysform" autocomplete="off">
                    @method('post')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDealModalTitle"> <i class="fa fa-plus-circle"></i> Nouveau Pays</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <label class="text-1000 fw-bold mb-2">Pays</label>
                                <input class="form-control" name="name" id="name" type="text"
                                    placeholder="Entrer le nom du pays" required />
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <br>
                                <label class="text-1000 fw-bold mb-2">Code du pays</label>
                                <input class="form-control" name="currenty_code" id="currenty_code" type="text"
                                    placeholder="Entrer le devise" required />
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <br>
                                <label class="text-1000 fw-bold mb-2">Code du telephone</label>
                                <input class="form-control" name="phone_code" id="phone_code" type="text"
                                    placeholder="Entrer le code" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" name="saveData" id="saveData"
                            class="btn btn-primary waves-effect waves-light"> <i class="fa fa-cloud-upload-alt"></i>
                            Sauvegarder</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="addpaysform" autocomplete="off">
                    @method('post')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDealModalTitle"><i class="fa fa-edit"></i> Modifier Pays</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <label class="text-1000 fw-bold mb-2">Pays</label>
                                <input class="form-control" name="b_name" id="name" type="text"
                                    placeholder="Entrer le nom du pays" required />
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <br>
                                <label class="text-1000 fw-bold mb-2">Code du pays</label>
                                <input class="form-control" name="b_currenty_code" id="currenty_code" type="text"
                                    placeholder="Entrer le devise" required />
                            </div>

                            <div class="col-sm-6 col-md-6">
                                <br>
                                <label class="text-1000 fw-bold mb-2">Code du telephone</label>
                                <input class="form-control" name="b_phone_code" id="phone_code" type="text"
                                    placeholder="Entrer le code" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect"
                            data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" name="saveData" id="saveData"
                            class="btn btn-primary waves-effect waves-light"> <i class="fa fa-cloud-upload-alt"></i>
                            Sauvegarder</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <script>
        $(document).ready(function() {
            // Load countries when the page loads



            fetchCountries();
            // Function to fetch and display countries
            function fetchCountries() {
                // Show a loading message in the table body
                $('#countriesTableBody').html('<tr><td colspan="5" class="text-center">Loading data...</td></tr>');

                $.ajax({
                    url: "{{ route('liste.pays') }}",
                    method: 'GET',
                    success: function(response) {
                        if (response.code === 200 && response.status === 'success') {
                            // Clear the table body before adding new rows
                            $('#countriesTableBody').empty();

                            // Populate table with country data
                            response.data.forEach(function(country) {
                                $('#countriesTableBody').append(`
                                  <tr>
                                      <td>${country.name}</td>
                                      <td>${country.currenty_code}</td>
                                      <td>${country.phone_code}</td>
                                      <td>${country.status ? 'Active' : 'Inactive'}</td>
                                      <td>
                                       
                                           <div class="btn-group me-2 mb-2 mb-sm-0">
                                                <a  data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical ms-2"></i>
                                                </a>
                                                <div class="dropdown-menu">
                                                <a class="dropdown-item text-primary mx-1 editIcon " id="${country.id}"  href="javascript::;" data-bs-toggle="modal" data-bs-target="#editModal" title="Modifier"><i class="far fa-edit"></i> Modifier</a>
                                                <a class="dropdown-item text-danger mx-1  deleteBtn" name="deleteBtn"   id="${country.id}"  href="javascript::;"><i class="far fa-trash-alt"></i> Supprimer</a>
                                                </div>
                                            </div>
                                      </td>
                                  </tr>
                              `);
                            });
                        } else {
                            // Display an error message if no data is found
                            $('#countriesTableBody').html(
                                '<tr><td colspan="5" class="text-center">No countries found.</td></tr>'
                            );
                        }
                    },
                    error: function(xhr) {
                        // Clear the loading message and show an error message
                        $('#countriesTableBody').html(
                            '<tr><td colspan="5" class="text-center text-danger">Failed to load data.</td></tr>'
                        );
                        let errorMessage = 'An error occurred while fetching the countries.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        alert(errorMessage); // Display the error message
                    }
                });
            }

            // JavaScript to handle form submission
            $('#addpaysform').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Collect form data
                let formData = {
                    name: $('#name').val(),
                    currenty_code: $('#currenty_code').val(),
                    phone_code: $('#phone_code').val(),

                    _token: $('input[name="_token"]').val()
                };

                // Send data to the server via AJAX
                $.ajax({
                    url: "{{ route('store.pays') }}", // Laravel route for storing country
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.code === 201 && response.status === 'success') {
                            toastr.success(response.message);
                            $('#addModal').modal('hide'); // Hide the modal after saving
                            $('#addpaysform')[0].reset(); // Reset the form
                            fetchCountries(); // Refresh country list
                        } else {
                            toastr.error('Failed to add country');
                        }
                    },
                    error: function(xhr) {
                        // Display validation errors or other server-side errors
                        let errors = xhr.responseJSON?.errors || {
                            general: 'An error occurred.'
                        };
                        let errorMessage = errors.general || Object.values(errors).join('\n');
                        toastr.error(errorMessage);
                    }
                });
            });

            // Open modal to add a new country (triggered by a button)
            $('#saveCountryBtn').click(function() {
                const countryData = {
                    name: $('#name').val(),
                    currency_code: $('#currency_code').val(),
                    phone_code: $('#phone_code').val(),
                    status: $('#status').val(),
                };

                $.ajax({
                    url: '/api/countries',
                    method: 'POST',
                    data: countryData,
                    success: function(response) {
                        $('#countryModal').modal('hide');
                        fetchCountries(); // Reload countries
                    }
                });
            });

            // Edit and delete functionality
            $(document).on('click', '.editBtn', function() {
                const id = $(this).data('id');
                // Populate and show modal for editing
                // Additional code for editing goes here
            });

            $(document).on('click', '.deleteBtn', function(e) {
                e.preventDefault();

                // Récupérer l'ID de l'élément à supprimer et le token CSRF
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';

                // Affichage de la boîte de confirmation
                Swal.fire({
                    title: 'Êtes-vous sûr de vouloir supprimer ?',
                    text: "Si vous le faites, vous ne pourrez plus revenir en arrière !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'green',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer !',
                    cancelButtonText: 'Annuler',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Indicateur de chargement pendant la suppression
                        Swal.fire({
                            title: 'Suppression en cours...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            },
                        });

                        // Requête AJAX pour suppression
                        $.ajax({
                            url: "{{ route('delete.pays') }}", // Route définie dans Laravel
                            method: 'DELETE', // Méthode HTTP DELETE
                            data: {
                                id: id,
                                _token: csrf,
                            },
                            success: function(response) {
                                Swal.close(); // Fermer le loader

                                // Vérifier le statut de la réponse et afficher un message
                                if (response.status === 200) {
                                    toastr.success("Pays supprimé avec succès !",
                                        "Suppression");
                                        fetchCountries();
                                } else if (response.status === 205) {
                                    toastr.error(
                                        "Vous n'avez pas l'autorisation de supprimer ce pays !",
                                        "Erreur");
                                } else if (response.status === 202) {
                                    toastr.error(
                                        "Une erreur s'est produite lors de l'exécution.",
                                        "Erreur");
                                } else {
                                    toastr.error("Réponse inattendue du serveur.",
                                        "Erreur");
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.close(); // Fermer le loader

                                // Gestion des erreurs serveur ou réseau
                                toastr.error(
                                    "Une erreur s'est produite. Veuillez réessayer.",
                                    "Erreur");
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
