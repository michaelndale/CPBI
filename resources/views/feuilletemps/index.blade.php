@extends('layout/app')
@section('page-content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Feuille de temps </h4>
                        <div class="page-title-right">
                            <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#myFeuilleModalLabel" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouvelle feuille de temps. </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">


                <div class="row">

                <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                               
                                <h4 class="card-title mb-3">Selection la periode </h4>

                                <select name="mois">
                                    <option value="01">Selectinner le mois</option>
                                    <option value="01">Janvier</option>
                                    <option value="02">Février</option>
                                    <option value="03">Mars</option>
                                    <option value="04">Avril</option>
                                    <option value="05">Mai</option>
                                    <option value="06">Juin</option>
                                    <option value="07">Juillet</option>
                                    <option value="08">Août</option>
                                    <option value="09">Septembre</option>
                                    <option value="10">Octobre</option>
                                    <option value="11">Novembre</option>
                                    <option value="12">Décembre</option>
                                </select>

                                      
                                <select name="annee">
                                    @php
                                        $anneeActuelle = now()->year;
                                    @endphp
                                    @for ($annee = 2023; $annee <= $anneeActuelle; $annee++)
                                        <option value="{{ $annee }}" @if ($annee == $anneeActuelle) selected @endif>{{ $annee }}</option>
                                    @endfor
                                    
                                </select>
                                <input type="button" name="save" value="Recheche"/>


                               

                            </div>
                        </div>
                    </div>


                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-end d-none d-md-inline-block">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="fw-semibold">Sort By:</span> <span class="text-muted"> Weekly <i class="mdi mdi-chevron-down ms-1"></i></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Monthly</a>
                                            <a class="dropdown-item" href="#">Yearly</a>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="card-title mb-3">Manage Orders</h4>


                                <div class="table-responsive">
                                    <table>
                                        <tr>
                                            <th>Repartition du temps</th>
                                            <th>Nombres des heures postees </th>
                                            <th>Total Heures </th>
                                            <th>Pourcentage </th>
                                        </tr>

                                        <tr>
                                            <th>Repartition du temps</th>
                                           
                                            <th>Distribution </th>
                                        </tr>
                                    </table>
                                   
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div> <!-- container-fluid -->

    </div>
    <br><br> <br><br> <br><br> <br><br>
</div>

{{-- new department modal --}}
<div class="modal fade bs-example-modal-lg" id="myFeuilleModalLabel" tabindex="-1" role="dialog" aria-labelledby="myFeuilleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel"> Nouvelle feuille de temps.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addFeuilleform" autocomplete="off">
                @method('post')
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-6 col-lg-12 col-xl-12">

                            <label class="text-1000 fw-bold mb-2"> Sélectionner le projet</label>
                            <select class="form-select compteid" id="projetid" name="projetid" type="text" placeholder="Entrer projet" required>
                                <option disabled="true" selected="true" value=""> -- Sélectionner le projet -- </option>
                                @forelse ($projet as $projets)
                                <option value="{{ $projets->id }}"> {{ ucfirst($projets->title) }}</option>
                                @empty
                                <option disabled="true" selected="true">--Aucun projet--</option>
                                @endforelse

                            </select>
                        </div>

                        <div class="col-sm-6 col-lg-12 col-xl-8">

                            <label class="text-1000 fw-bold mb-2">Date du jour de travail </label>
                            <input class="form-control" id="datejour" name="datejour" type="date" placeholder="Date " required />
                        </div>


                        <div class="col-sm-6 col-lg-12 col-xl-4">
                            <label class="text-1000 fw-bold mb-2">Nombre de temps (En terme d'Heure) </label>
                            <input class="form-control" id="nombre" name="nombre" type="number" min="1" placeholder="Nombe" required />
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal"><i class="fa fa-times-circle"></i> Fermer </button>
                    <button type="submit" id="btnsavefeuille" name="btnsavefeuille" class="btn btn-primary waves-effect waves-light"> <i class="fa fa-check-circle"></i> Save changes</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->







<script>
    $(function() {
        // Add department ajax 
        $("#addFeuilleform").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#btnsavefeuille").text('Adding...');
            $.ajax({
                url: "{{ route('storefeuille') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        toastr.success("Feuille enregistrer avec succès!", "Enregistrement");
                        fetchAlldfolder();
                        $("#btnsavefeuille").text('Sauvegarder');
                        $("#addFeuilleform")[0].reset();
                        $("#myFeuilleModalLabel").modal('hide');
                    }

                    if (response.status == 201) {
                        toastr.error("Vous enregistrer ce jour  déjà !", "Erreur");
                        $("#btnsavefeuille").text('Sauvegarder');
                        $("#myFeuilleModalLabel").modal('show');
                    }
                }

            });
        });

        // Edit folder ajax request
        $(document).on('click', '.editIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: "{{ route('editfl') }}",
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#flibelle").val(response.title);
                    $("#fid").val(response.id);
                }
            });
        });

        // update function ajax request
        $("#edit_folder_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#editfolderbtn").text('Mises encours...');
            $.ajax({
                url: "{{ route('updatefl') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        toastr.success("Dossier modifier avec succès !", "Modification");
                        fetchAlldfolder();
                        $("#editfolderbtn").text('Sauvegarder');
                        $("#editFolderModal").modal('hide');

                    }

                    if (response.status == 201) {
                        toastr.error("Le titre du dossier existe déjà !", "Erreur");

                        $("#editfolderbtn").text('Sauvegarder');
                    }

                    if (response.status == 205) {
                        toastr.error("Vous n'avez pas l'accreditation de Modifier ce dossier!", "Erreur");

                        $("#editfolderbtn").text('Sauvegarder');
                    }

                }
            });
        });

        // Delete service ajax request
        $(document).on('click', '.deleteIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
            Swal.fire({
                title: 'Êtes vous sûr de vouloir supprimer?',
                text: "Si vous le faite vous ne pouvez plus revenir en arrière !",

                showCancelButton: true,
                confirmButtonColor: 'Green',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, Supprimer!',
                cancelButtonText: 'Annuler',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('deletefl') }}",
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {


                            if (response.status == 200) {
                                toastr.success("Dossier supprimer avec succès !", "Suppression");
                                fetchAlldfolder();
                            }

                            if (response.status == 205) {
                                toastr.error("Vous n'avez pas l'accreditation de supprimer ce dossier!", "Erreur");
                            }

                            if (response.status == 202) {
                                toastr.error("Erreur d'execution !", "Erreur");
                            }
                        }
                    });
                }
            })
        });

        fetchAlldfolder();

        function fetchAlldfolder() {
            $.ajax({
                url: "{{ route('fetchAllfl') }}",
                method: 'get',
                success: function(reponse) {
                    $("#show_all_folder").html(reponse);
                }
            });
        }
    });
</script>

@endsection