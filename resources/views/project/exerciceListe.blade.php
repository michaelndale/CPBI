<style>
    tr a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    text-decoration: none; /* Supprimer le soulignement */
    color: inherit; /* Conserver la couleur par défaut */
}

tr a:hover {
    background-color: #f9f9f9; /* Effet survol */
}

</style>
<div class="modal fade" id="ProjetModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" style="width:800px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle"><i class="mdi mdi-content-duplicate"></i> Exercice annuel pour le classement du projet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm mb-0">
                        <thead>
                            <tr>
                                <th colspan="4" id="project-title">Titre du projet</th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>Titre</th>
                                <th>Numéro</th>
                                <th><center> Budget</center></th>
                              
                                <th>Date Début</th>
                                <th>Date Fin</th>
                                <th>Statut</th>
                                <th>Créé le</th>
                            </tr>
                        </thead>
                        <tbody id="exercice-table-body">
                            <!-- Les données dynamiques seront insérées ici -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var modalElement = new bootstrap.Modal(document.getElementById('ProjetModalScrollable'), {
    backdrop: 'static',
    keyboard: false
});

modalElement.show(); // Pour afficher le modal

</script>

<script>

// Assurez-vous que la variable Laravel est définie dans le Blade (dans le HTML)
const exerciceShowUrl = "{{ route('exercice.show', ['id' => ':id']) }}";

// Gestionnaire pour chaque lien "show-exercice"
document.querySelectorAll('.show-exercice').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();

        // Récupérer l'ID du projet à partir de l'attribut HTML
        const projectId = this.getAttribute('id');

        // Remplacer ":id" dans l'URL par l'ID du projet
        const url = exerciceShowUrl.replace(':id', projectId);

        // Effectuer une requête fetch pour récupérer les données des exercices
        fetch(url)
            .then(response => {
                // Vérifier si la réponse est correcte
                if (!response.ok) {
                    throw new Error(`Erreur HTTP : ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Insérer les données des exercices dans la table
                const tableBody = document.getElementById("exercice-table-body");
                tableBody.innerHTML = data.rows; // Mettre à jour le contenu de la table
                document.getElementById('project-title').textContent = data.project_title; // Titre du projet
            })
            .catch(error => {
                // Gérer les erreurs
                console.error("Erreur lors du chargement des exercices :", error);
                const tableBody = document.getElementById("exercice-table-body");
                tableBody.innerHTML = "<tr><td colspan='5' class='text-danger'>Impossible de charger les données.</td></tr>";
            });
    });
});


</script>



