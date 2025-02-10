@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">

            <div class="row">
                <div class="col-xl-8" style="margin:auto">

                    <div class="card">
                        <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"
                            style="padding: 0.40rem 1rem;">

                            <strong>
                                <h5 class="card-title mb-0"> <i class="mdi mdi-lock-open-check"></i> Sécurité et autorisation sur les modifications sur
                                     les projets </h5>
                            </strong> <b>Code encours:    {{ $lastExercice && $lastExercice->code ? str_pad($lastExercice->code, 3, '0', STR_PAD_LEFT) : '---' }}  </b>
                        </div>

                        <form method="POST" id=saveSecureForm" name="saveSecureForm">
                            @csrf
                            @method('POST')

                            <div class="card-body">
                                <div class="col-12 col-xl-12 col-xxl-12 pe-xl-0">
                                    <div class="mb-12 mb-xl-12">
                                        <div class="row gx-0 gx-sm-12">
                                            <div class="col-12">


                                                <div class="row">

                                                    <div class="col-sm-6 col-md-2">
                                                        <div class="position-relative">
                                                            <input type="number" id="codeInput" name="codeInput" class="form-control" placeholder="Nouvel Code ..." style="background-color: aliceblue;" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-8">
                                                        <!-- Bouton Générer -->
                                                        <a href="javascript::()" id="fetchDataLink"
                                                            class="btn btn-outline-primary rounded-pill btn-sm"
                                                            title="Générer un nouveau code">
                                                            <i class="fas fa-sync-alt"></i>
                                                        </a>
                                                        <br><br>
                                                    </div>

                                                    <div class="col-sm-6 col-md-2">
                                                        <!-- Bouton Générer -->
                                                        <button type="button" name="saveButton" id="saveButton"
                                                            class="btn btn-primary">
                                                            <i class="fa fa-cloud-upload-alt"></i> Sauvegarder
                                                        </button>
                                                        <br><br>
                                                    </div>


                                                    <div class="col-sm-6 col-md-12">
                                                    <input class="form-check-input"
                                                    type="checkbox" id="select_all" /> Sélectionner tout
                                                    <br><br>
                                                    </div>

                                                    @foreach ($project as $index => $projects)
                                                        <div class="col-md-12">

                                                            <div class="card mb-3">
                                                                <!-- En-tête avec titre et informations -->
                                                                <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between "
                                                                    style="padding: 0.40rem 1rem;">
                                                                    <strong>Project {{ $index + 1 }} :
                                                                        {{ $projects->title }} </strong>
                                                                </div>

                                                                @php
                                                                    $projectId = $projects->id;

                                                                    $exercices = DB::table('exercice_projets')
                                                                        ->where('project_id', $projectId)
                                                                        ->orderBy('id', 'desc')
                                                                        ->get();

                                                                @endphp



                                                                <table class="table table-bordered table-sm mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>
                                                                                <center># </center>
                                                                            </th>
                                                                            <th>Numéro</th>
                                                                            <th>Budget</th>
                                                                            <th>Statut</th>
                                                                            <th>Date Début</th>
                                                                            <th>Date Fin</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                        @forelse ($exercices as $exercice)
                                                                            @php
                                                                                $ProjetId = $exercice->project_id;
                                                                                $ExerciceId = $exercice->id;

                                                                                $security = DB::table('securites')
                                                                                    ->where('project_id', $ProjetId)
                                                                                    ->where('exercice_id', $ExerciceId)
                                                                                    ->first();
                                                                            @endphp
                                                                            <tr>
                                                                                <td class="text-center">
                                                                                    <input type="hidden" id="project_id"
                                                                                        name="project_id[]"
                                                                                        value="{{ $exercice->project_id }}">

                                                                                    <input type="hidden" id="exercice_id"
                                                                                        name="exercice_id[]"
                                                                                        value="{{ $exercice->id }}">
                                                                                        

                                                                                        <input class="form-check-input item-checkbox"
                                                                                        type="checkbox"
                                                                                        id="status_exe"
                                                                                        name="status_exe[]"
                                                                                        @if (isset($security) && $security->statut == 1) checked @endif
                                                                                        value="{{ isset($security) && $security->statut === 1 ? 1 : 0 }}" />
                                                                                     

                                                                                      
                                                                                </td>
                                                                                <td>
                                                                                    <a href="{{ route('key.viewProject', ['project' => Crypt::encrypt($exercice->project_id), 'exercice' => Crypt::encrypt($exercice->id)]) }}">
                                                                                        <b>{{ $exercice->numero_e }}/{{ date('Y', strtotime($exercice->created_at)) }}</b>
                                                                                    </a>
                                                                                </td>
                                                                                <td align="right">
                                                                                    {{ number_format($exercice->budget, 0, ',', ' ') }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($exercice->status === 'Actif')
                                                                                        <span
                                                                                            class="badge rounded-pill bg-subtle-primary text-primary font-size-11">Active</span>
                                                                                    @else
                                                                                        <span
                                                                                            class="badge rounded-pill bg-subtle-danger text-danger font-size-11">Archiver</span>
                                                                                    @endif
                                                                                </td>
                                                                                <td>{{ date('d-m-Y', strtotime($exercice->estart_date)) }}
                                                                                </td>
                                                                                <td>{{ date('d-m-Y', strtotime($exercice->edeadline)) }}
                                                                                </td>
                                                                            </tr>
                                                                        @empty
                                                                            <tr>
                                                                                <td colspan="6"
                                                                                    class="text-center text-muted">Aucun
                                                                                    exercice trouvé pour ce projet.</td>
                                                                            </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                            </div>


                                        </div>

                                    </div>

                                </div>

                            </div>

                          

                        </form>

                    </div>

                </div>

            </div>

        </div>
    </div>


<script>
    // Sélectionnez la case principale
    const selectAllCheckbox = document.getElementById('select_all');

    // Sélectionnez toutes les autres cases à cocher
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');

    // Ajoutez un écouteur d'événement sur la case principale
    selectAllCheckbox.addEventListener('change', function () {
        // Cochez/décochez toutes les autres cases selon l'état de la case principale
        itemCheckboxes.forEach(function (checkbox) {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });
</script>


    <script>
       document.getElementById("fetchDataLink").addEventListener("click", function () {
        // Générer un nombre aléatoire à 6 chiffres
        let randomCode = Math.floor(100000 + Math.random() * 900000);

        // Récupérer l'élément input
        const codeInput = document.getElementById("codeInput");

        // Afficher le code généré dans l'input
        codeInput.value = randomCode;

        // Changer la couleur de la bordure et du texte en vert
        codeInput.style.borderColor = "green"; // Changement de la bordure en vert
        codeInput.style.color = "green";       // Changement de la couleur du texte en vert
    });
    </script>

    <script>
       document.addEventListener('DOMContentLoaded', function () {
            const saveButton = document.querySelector('#saveButton');
            if (!saveButton) {
                toastr.error("Le bouton #saveButton n'a pas été trouvé !");
                return;
            }

            saveButton.addEventListener('click', function (event) {
                event.preventDefault();

                $("#saveButton").html('<i class="fas fa-spinner fa-spin"></i>');
                document.getElementById("saveButton").disabled = true;


                // Récupérer les données du formulaire
                const projectIds = document.querySelectorAll('input[name="project_id[]"]');
                const exerciceIds = document.querySelectorAll('input[name="exercice_id[]"]');
                const statusCheckboxes = document.querySelectorAll('input[name="status_exe[]"]');

                if (projectIds.length === 0 || exerciceIds.length === 0 || statusCheckboxes.length === 0) {
                    toastr.error("Les données du formulaire sont manquantes !");
                    return;
                }

                const formData = [];
                for (let i = 0; i < projectIds.length; i++) {
                    formData.push({
                        project_id: parseInt(projectIds[i].value),
                        exercice_id: parseInt(exerciceIds[i].value),
                        status_exe: statusCheckboxes[i].checked ? 1 : 0,
                    });
                }

                console.log("Données collectées :", formData);

                // Récupérer le champ "code"
                const codeInput = document.querySelector('input[name="codeInput"]');
                const code = codeInput ? codeInput.value.trim() : '';

                // Vérifier si le champ "code" est vide
                if (!code) {
                    // Afficher un message d'erreur en rouge
                    toastr.error("Veuillez entrer un code valide !");
                    $("#saveButton").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                    document.getElementById("saveButton").disabled = false;
                    
                    // Changer la bordure de l'input en rouge
                    codeInput.style.borderColor = 'red';
                    codeInput.style.color = 'red'; // Optionnel : changer aussi la couleur du texte

                    // Empêcher l'envoi du formulaire
                    return;
                } else {
                    // Réinitialiser la bordure si le champ est valide
                    codeInput.style.borderColor = ''; // Retour à la bordure par défaut
                    codeInput.style.color = ''; // Retour à la couleur du texte par défaut
                }

                // Préparer les données à envoyer
                const data = {
                    code: code,
                    project_id: formData.map(item => item.project_id),
                    exercice_id: formData.map(item => item.exercice_id),
                    status_exe: formData.map(item => item.status_exe),
                };

                console.log("Données finales :", data);

                // Envoyer les données via AJAX
                fetch(`{{ route('secure.store') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(result => {
                    console.log("Réponse du serveur :", result);
                    if (result.success) {
                        $("#saveButton").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        document.getElementById("saveButton").disabled = false;
                        toastr.success(result.message);
                    } else {
                        $("#saveButton").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        document.getElementById("saveButton").disabled = false;
                        toastr.error('Une erreur s\'est produite : ' + result.message);
                    }
                })
                .catch(error => {
                    $("#saveButton").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                    document.getElementById("saveButton").disabled = false;
                    toastr.error('Erreur lors de l\'envoi des données :', error);
                });
            });
        });
    </script>
@endsection
