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
                            <tr >
                                <th colspan="8" id="project-title">Titre du projet</th>
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
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="loader" style="display: none; text-align: center; padding: 10px;">
    <i class="fas fa-spinner fa-spin fa-2x text-primary"></i>
</div>


<script>
    var modalElement = new bootstrap.Modal(document.getElementById('ProjetModalScrollable'), {
    backdrop: 'static',
    keyboard: false
});

modalElement.show(); // Pour afficher le modal

</script>

<script>
    const exerciceShowUrl = "{{ route('exercice.show', ['id' => ':id']) }}";
    
    document.querySelectorAll('.show-exercice').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
    
            const projectId = this.getAttribute('id');
            const url = exerciceShowUrl.replace(':id', projectId);
    
            const tableBody = document.getElementById("exercice-table-body");
            const projectTitle = document.getElementById('project-title');
            const loader = document.getElementById("loader"); // Spinner de chargement
    
            // Afficher le spinner et vider la table
            loader.style.display = "block";
            tableBody.innerHTML = "";
            projectTitle.textContent = "Chargement encours...";
    
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Erreur HTTP : ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    tableBody.innerHTML = data.rows; // Mettre à jour la table
                    projectTitle.textContent = data.project_title; // Mettre à jour le titre du projet
                })
                .catch(error => {
                    console.error("Erreur lors du chargement des exercices :", error);
                    tableBody.innerHTML = "<tr><td colspan='8' class='text-danger'><center>Impossible de charger les données.</center></td></tr>";
                    projectTitle.textContent = "Erreur de chargement";
                })
                .finally(() => {
                    loader.style.display = "none"; // Cacher le spinner après chargement
                });
        });
    });
    </script>
    


