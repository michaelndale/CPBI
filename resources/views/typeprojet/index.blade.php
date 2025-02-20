@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-7" style="margin:auto">
                    <div class="card">
                        <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">
                                <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Type budget </h4>
                                <div class="page-title-right">
                                    <a href="javascript:voide();" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true"
                                        aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Créer</a>
                                </div>
                          
                        </div>
                        <div class="card-body pt-0 pb-3">
                            <div id="overview-chart" data-colors='["#1f58c7"]' class="apex-charts" dir="ltr"></div>
                            <div class="table-responsive">

                                <table class="table table-striped table-sm fs--1 mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width:5%"><center>#</center></th>
                                            <th><b>Libellé</b></th>
                                            <th><b>Créé le</b></th>
                                            <th style="width:25%">
                                                <center><b>Actions</b></center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_all_type">
                                        <tr>
                                            <td colspan="4">
                                                <h5 class="text-center text-secondery my-5">
                                                    @include('layout.partiels.load')
                                            </td>
                                        </tr>
                                    </tbody>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- new banque modal --}}
    <div class="modal fade" id="addDealModal" tabindex="-1" role="dialog" aria-labelledby="addDealModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDealModalTitle"><i class="fa fa-plus-circle"></i> Nouvelle type budget
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="add_type_form" autocomplete="off">
                    @method('post')
                    @csrf
                    <div class="modal-body">
                        <label class="text-1000 fw-bold mb-2">Titre</label>
                        <input class="form-control" name="titre" id="titre" type="text"
                            placeholder="Entrer le titre" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" name="sendType" id="add_type" value="Sauvegarder" class="btn btn-primary">
                            <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                    </div>
                </form>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{-- Edit dossier modal --}}

    <div class="modal fade" id="edittypeModal" tabindex="-1" aria-labelledby="edittypeModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDealModalTitle"><i class="fa fa-plus-circle"></i> Nouvelle type budget
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit_type_form" autocomplete="off">
                    @method('post')
                    @csrf
                    <div class="modal-body">
                        <label class="text-1000 fw-bold mb-2">Titre</label>
                        <input type="hidden" name="typeid" id="typeid">
                        <input class="form-control" name="titretype" id="titretype" type="text"
                            placeholder="Entrer dossier" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" name="edittypebtn" id="edittypebtn" value="Sauvegarder"
                            class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                    </div>
                </form>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
        $(function() {
            // Add department ajax 
            $("#add_type_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#add_type").text('Adding...');

                $("#add_type").html('<i class="fas fa-spinner fa-spin"></i>');
                document.getElementById("add_type").disabled = true;

                $.ajax({
                    url: "{{ route('storetypebudget') }}",
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            toastr.success("Type budget enregistrer avec succès!",
                                "Enregistrement");
                            fetchAlldbudget();

                            $("#add_type").html(
                                '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            $("#add_type_form")[0].reset();
                            $("#addDealModal").modal('hide');
                            document.getElementById("add_type").disabled = false;

                        }

                        if (response.status == 201) {

                            toastr.error("Le type budget  existe déjà !", "Erreur");
                            $("#add_type").html(
                                '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            $("#addDealModal").modal('show');
                            document.getElementById("add_type").disabled = false;
                        }
                    }

                });
            });

            // Edit folder ajax request
            $(document).on('click', '.editIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                $.ajax({
                    url: "{{ route('edittypebudget') }}",
                    method: 'get',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $("#titretype").val(response.titre);
                        $("#typeid").val(response.id);
                    }
                });
            });

            // update function ajax request
            $("#edit_type_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);

                $("#edittypebtn").html('<i class="fas fa-spinner fa-spin"></i>');
                document.getElementById("edittypebtn").disabled = true;

                $.ajax({
                    url: "{{ route('updatetypebudget') }}",
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            toastr.success("Type budget modifier avec succès !",
                            "Modification");
                            fetchAlldbudget();

                            $("#edittypebtn").html(
                                '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            $("#edittypeModal").modal('show');
                            document.getElementById("edittypebtn").disabled = false;

                        }

                        if (response.status == 201) {
                            toastr.error("Le type budget existe déjà !", "Erreur");

                            $("#edittypebtn").html(
                                '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            $("#edittypeModal").modal('show');
                            document.getElementById("edittypebtn").disabled = false;
                        }

                        if (response.status == 205) {
                            toastr.error(
                                "Vous n'avez pas l'accreditation de Modifier ce type de projet !",
                                "Erreur");

                            $("#edittypebtn").text('Sauvegarder');
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
                            url: "{{ route('deletetypebudget') }}",
                            method: 'delete',
                            data: {
                                id: id,
                                _token: csrf
                            },
                            success: function(response) {


                                if (response.status == 200) {
                                    toastr.success(
                                        "Type budget supprimer avec succès !",
                                        "Suppression");
                                    fetchAlldbudget();
                                }

                                if (response.status == 205) {
                                    toastr.error(
                                        "Vous n'avez pas l'accreditation de supprimer ce dossier!",
                                        "Erreur");
                                }

                                if (response.status == 202) {
                                    toastr.error("Erreur d'execution !", "Erreur");
                                }
                            }
                        });
                    }
                })
            });

            fetchAlldbudget();

            function fetchAlldbudget() {
                $.ajax({
                    url: "{{ route('fetchtypebudget') }}",
                    method: 'get',
                    success: function(reponse) {
                        $("#show_all_type").html(reponse);
                    }
                });
            }
        });
    </script>
@endsection
