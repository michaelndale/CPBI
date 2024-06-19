@extends('layout/app')
@section('page-content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Emploi du temps </h4>
                        <div class="page-title-right">
                            <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#myFeuilleModalLabel" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouvelle feuille de temps. </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                      

                            <div class="table-responsive">
                                <table class="table table-bordered  table-centered align-middle table-nowrap table-sm fs--1  mb-0">
                                    <thead>
                                        <tr style="background-color:#82E0AA">
                                            <th>#</th>
                                            <th>Date du jour</th>
                                            <th>Projet</th>
                                            <th>Description / Activités réalisées</th>
                                            <th>Durée en minutes</th> <!-- Correction de "minnutes" à "minutes" -->
                                            <th>Comment l'activité a-t-elle été réalisée ?</th>
                                            <th>Indicateurs Objectivement vérifiables (IOV)</th> <!-- Correction de "verifiable" à "vérifiables" -->
                                            <th>Résultats obtenus (Quantitatifs)</th> <!-- Correction de "Resultats" à "Résultats" -->
                                            <th>Heure d'arrivee</th>
                                            <th>Heure de retart</th>
                                            <th>Heure de depart</th>
                                            <th>Observation plan redressement</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="showfeuille">
                                    <tr>
                                                    <td colspan="10"><h5 class="text-center text-secondery my-5">
                                                        @include('layout.partiels.load')
                                                      </td>
                                                    </tr>
                                    </tbody>
                                </table>
                          


                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div> <!-- container-fluid -->

</div>
<br><br> <br><br> <br><br> <br><br>
</div>

<div class="modal fade" id="myFeuilleModalLabel" tabindex="-1" role="dialog" aria-labelledby="myFeuilleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">

            <form id="addFeuilleform" autocomplete="off">
                @method('post')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle"> Nouvelle feuille de temps.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-6 col-lg-12 col-xl-12">
                            <label class="text-1000 fw-bold mb-2"> Programme, Projet ou Unité</label>
                            <select class="form-select" id="projetid" name="projetid" type="text" placeholder="Entrer projet" required>
                                <option disabled="true" selected="true" value=""> -- Sélectionner l'option -- </option>
                                @forelse ($projet as $projets)
                                <option value="{{ $projets->id }}"> {{ ucfirst($projets->title) }}</option>
                                @empty
                                <option disabled="true" selected="true">--Aucun projet--</option>
                                @endforelse

                            </select>
                        </div>

                        <div class="col-sm-6 col-lg-12 col-xl-12">
                            <label class="text-1000 fw-bold mb-2"> Description/Activités réalisées</label>
                            <textarea class="form-control " id="description" name="description" type="text" required></textarea>
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Réalisation(x) </label>
                            <select class="form-control" id="realisation" name="realisation" type="text" min="1" placeholder="Réalisation" required />
                            <option>Séléctionner l'option</option>
                            <option value="E">Entièrement </option>
                            <option value="P">Partiellement </option>
                            </select>
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Date du jour de travail </label>
                            <input class="form-control" id="datejour" name="datejour" type="date" placeholder="Date " required />
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Durée en minutes</label>
                            <input class="form-control" id="nombre" name="nombre" type="text" min="1" placeholder="Durée" required />
                        </div>

                      
                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Heure d'arrivee</label>
                            <input class="form-control" id="heurearrive" name="heurearrive" type="time"   required />
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Heure depart</label>
                            <input class="form-control" id="heuredepart" name="heuredepart" type="time" />
                        </div>


                        <div class="col-sm-4 col-lg-12 col-xl-9">
                            <label class="text-1000 fw-bold mb-2">Indicateurs Objectivement</label>
                            <input class="form-control" id="iov" name="iov" type="text" min="1" placeholder="Indicateurs" required />
                        </div>


                     
                     



                        <div class="col-sm-6 col-lg-12 col-xl-12">
                            <label class="text-1000 fw-bold mb-2"> Observation plan de redressement</label>
                            <textarea class="form-control " id="observation" name="observation" type="text" required></textarea>
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
</div>

<div class="modal fade" id="EditFeuilleModalLabel" tabindex="-1" role="dialog" aria-labelledby="EditFeuilleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">

            <form id="editFeuilleform" autocomplete="off">
                @method('post')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle"> <i class="fa fa-edit"></i> Modifier l'empploi temps.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-6 col-lg-12 col-xl-12">
                            <label class="text-1000 fw-bold mb-2"> Programme, Projet ou Unité</label>
                            <input class="form-control" id="idf" name="idf" type="hidden" />
                            <select class="form-select" id="eprojetid" name="eprojetid" type="text" placeholder="Entrer projet" required>
                                <option disabled="true" selected="true" value=""> -- Sélectionner l'option -- </option>
                                @forelse ($projet as $projets)
                                <option value="{{ $projets->id }}"> {{ ucfirst($projets->title) }}</option>
                                @empty
                                <option disabled="true" selected="true">--Aucun projet--</option>
                                @endforelse

                            </select>
                        </div>

                        <div class="col-sm-6 col-lg-12 col-xl-12">
                            <label class="text-1000 fw-bold mb-2"> Description/Activités réalisées</label>
                            <textarea class="form-control " id="edescription" name="edescription" type="text" required></textarea>



                        </div>


                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Réalisation(x) </label>
                            <select class="form-control" id="erealisation" name="erealisation" type="number" min="1" placeholder="Réalisation" required />
                            <option>Séléctionner l'option</option>
                            <option value="E">Entièrement </option>
                            <option value="P">Partiellement </option>
                            </select>
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Date du jour de travail </label>
                            <input class="form-control" id="edatejour" name="edatejour" type="date" placeholder="Date " required />
                        </div>


                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Durée en minutes</label>
                            <input class="form-control" id="enombre" name="enombre" type="number" min="1" placeholder="Durée" required />
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Heure d'arrivee</label>
                            <input class="form-control" id="eheurearrive" name="eheurearrive" type="time"   required />
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Heure depart</label>
                            <input class="form-control" id="eheuredepart" name="eheuredepart" type="time" />
                        </div>

                    



                        <div class="col-sm-4 col-lg-12 col-xl-9">
                            <label class="text-1000 fw-bold mb-2">Indicateurs Objectivement Vérifiable (IOV)</label>
                            <input class="form-control" id="eiov" name="eiov" type="text" placeholder="Indicateurs" required />
                        </div>


                       



                        <div class="col-sm-6 col-lg-12 col-xl-12">
                            <label class="text-1000 fw-bold mb-2"> Observation plan de redressement</label>
                            <textarea class="form-control " id="eobservation" name="eobservation" type="text" required></textarea>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal"><i class="fa fa-times-circle"></i> Fermer </button>
                    <button type="submit" id="btneditfeuille" name="btneditfeuille" class="btn btn-primary waves-effect waves-light"> <i class="fa fa-check-circle"></i> Sauvegarder le modification</button>
                </div>

            </form>


        </div>
    </div>
</div>
</div>






<script>
    $(function() {
        // Add department ajax 
        $("#addFeuilleform").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#btnsavefeuille").html('<i class="fas fa-spinner fa-spin"></i>');
            document.getElementById("btnsavefeuille").disabled = true;
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
                        toastr.success("Enregistrement avec succès!", "Enregistrement");
                        fetchAllft();
                        $("#btnsavefeuille").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        $("#addFeuilleform")[0].reset();
                        $("#myFeuilleModalLabel").modal('hide');
                        document.getElementById("btnsavefeuille").disabled = false;
                    }

                    if (response.status == 201) {
                        $("#btnsavefeuille").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        $("#myFeuilleModalLabel").modal('show');
                        document.getElementById("btnsavefeuille").disabled = false;
                    }
                }

            });
        });

        // Edit  ajax request
        $(document).on('click', '.editIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: "{{ route('showft') }}",
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#eprojetid").val(response.projetid);
                    $("#edescription").val(response.description);
                    $("#edatejour").val(response.datepresence);
                    $("#enombre").val(response.nombre);
                    $("#erealisation").val(response.realisation);
                    $("#eiov").val(response.iov);
                    $("#eheurearrive").val(response.heurearrive);
                    $("#eheuredepart").val(response.heuredepart);
                    $("#eobservation").val(response.observation);
                    $("#idf").val(response.id);
                }
            });
        });

        // update function ajax request
        $("#editFeuilleform").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);

            $("#btneditfeuille").html('<i class="fas fa-spinner fa-spin"></i>');
            document.getElementById("btneditfeuille").disabled = true;

            $.ajax({
                url: "{{ route('updatefeuille') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        toastr.success("Emploi du temps modifier avec succès !", "Modification");
                        fetchAllft();
                        $("#btneditfeuille").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        $("#EditFeuilleModalLabel").modal('hide');
                        document.getElementById("btneditfeuille").disabled = false;

                    }

                    if (response.status == 201) {
                        $("#EditFeuilleModalLabel").modal('show');
                        toastr.error("Le titre du dossier existe déjà !", "Erreur");
                        document.getElementById("btneditfeuille").disabled = false;
                        $("#btneditfeuille").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                    }

                    if (response.status == 205) {
                        $("#EditFeuilleModalLabel").modal('show');
                        toastr.error("Vous n'avez pas l'accreditation de Modifier!", "Erreur");
                        document.getElementById("btneditfeuille").disabled = false;
                        $("#btneditfeuille").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
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
                        url: "{{ route('deleteftemps') }}",
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {


                            if (response.status == 200) {
                                toastr.success("Emploi du temps supprimer avec succès !", "Suppression");
                                fetchAllft();
                            }

                            if (response.status == 205) {
                                toastr.error("Vous n'avez pas l'accreditation de supprimer emploi du temps!", "Erreur");
                            }

                            if (response.status == 202) {
                                toastr.error("Erreur d'execution !", "Erreur");
                            }
                        }
                    });
                }
            })
        });

        fetchAllft();

        function fetchAllft() {
            $.ajax({
                url: "{{ route('fetchAllfeuille') }}",
                method: 'get',
                success: function(reponse) {
                    $("#showfeuille").html(reponse);
                }
            });
        }
    });
</script>

@endsection