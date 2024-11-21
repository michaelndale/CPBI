@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12" style="margin:auto">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Listes des Pays</h4>
                            <div class="page-title-right">
                                <a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addModal"
                                    aria-haspopup="true" aria-expanded="false"> <i class="fa fa-plus-circle"></i> Nouvelle
                                    banque</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-8" style="margin:auto">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm fs--1 mb-0">
                                    <thead>
                                        <thead>
                                            <tr>

                                                <th>Nom</th>
                                                <th>Code</th>
                                                <th>Code telephone</th>
                                                <th>Statut</th>
                                                <th>Actions</th>
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
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>



    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addpaysform" autocomplete="off">
                @method('post')
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-folder-plus"></i> Nouveau Pays</h5>
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
                        <button type="submit" name="saveData" id="daveData" value="Sauvegarder" class="btn btn-primary">
                            <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    {{-- Edit banque modal --}}

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="editform">
                    @method('post')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="verticallyCenteredModalLabel">Modification banque </h5><button
                            class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg
                                class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas"
                                data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                data-fa-i2svg="">
                                <path fill="currentColor"
                                    d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z">
                                </path>
                            </svg></button>
                    </div>
                    <div class="modal-body">
                        <label class="text-1000 fw-bold mb-2">Abriation </label>
                        <input type="hidden" name="bid" id="bid">
                        <input class="form-control" name="blibelle" id="blibelle" type="text"
                            placeholder="Entrer function" name="blibelle" required />
                    </div>

                    <div class="modal-body">
                        <label class="text-1000 fw-bold mb-2">Nom affiché </label>
                        <input type="hidden" name="bid" id="bid">
                        <input class="form-control" name="blibelle" id="blibelle" type="text"
                            placeholder="Entrer function" name="blibelle" required />
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="editbtn" class="btn btn-primary" type="button">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
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
                                          <button class="btn btn-warning btn-sm editBtn" data-id="${country.id}"><i class="fa fa-edit"></i></button>
                                          <button class="btn btn-danger btn-sm deleteBtn" data-id="${country.id}"><i class="fa fa-edit"></i></button>
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
                e.preventDefault(); // Empêche le comportement par défaut du bouton
                let id = $(this).attr('id'); // Récupère l'ID du dossier
                let csrf = '{{ csrf_token() }}'; // Récupère le token CSRF pour la sécurité

                // Affiche une boîte de dialogue de confirmation avec SweetAlert
                Swal.fire({
                    title: 'Êtes-vous sûr de vouloir supprimer ?',
                    text: "Si vous le faites, vous ne pourrez plus revenir en arrière !",
                    showCancelButton: true,
                    confirmButtonColor: 'Green',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer !',
                    cancelButtonText: 'Annuler',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Envoie la requête AJAX si l'utilisateur confirme la suppression
                        $.ajax({
                            url: "{{ route('delete.pays') }}", // Route pour supprimer le dossier
                            method: 'DELETE',
                            data: {
                                id: id, // Envoie l'ID du dossier à supprimer
                                _token: csrf // Envoie le token CSRF pour la sécurité
                            },
                            success: function(response) {
                                // Vérification du code de statut retourné et affichage des notifications
                                if (response.status === 200) {
                                    toastr.success("Pays supprimé avec succès !",
                                        "Suppression");
                                        fetchCountries();
                                }
                            },
                            error: function(xhr, status, error) {
                                // Gère les erreurs en fonction du code de statut retourné
                                if (xhr.status === 404) {
                                    toastr.error("Le pays n'a pas été trouvé.",
                                        "Erreur");
                                } else if (xhr.status === 500) {
                                    toastr.error(
                                        "Une erreur interne est survenue. Veuillez réessayer plus tard.",
                                        "Erreur serveur");
                                } else {
                                    toastr.error(
                                        "Une erreur est survenue. Veuillez réessayer.",
                                        "Erreur");
                                }
                            }
                        });
                    }
                });
            });

           
        });
    </script>
@endsection
