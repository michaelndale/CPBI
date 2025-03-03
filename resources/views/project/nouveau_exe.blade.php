@extends('layout/app')
@section('page-content')
 
    <form action="{{ route('store.exe') }}" method="POST">
        @method('post')
        @csrf
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-9" style="margin:auto">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            


                            <div class="card">

                                <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"
                                    style="padding: 0.3rem 1rem;">

                                    <h4 class="mb-sm-0"><i class="mdi mdi-plus-circle"></i> Nouvelle Exercice annulle
                                        projet </h4>
                                    <div class="page-title-right">

                                        <a href="javascript:void(0);"
                                            class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" title="Actualiser"
                                            onclick="window.location.reload();">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>

                                       <!-- <a href="javascript:void(0);"
                                            class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#revisionModal">
                                            <span class="fa fa-edit"></span> Revision budgetaire
                                        </a>  -->
                                    </div>

                                </div>

                                <div class="card-body">
                                    <div class="col-12 col-xl-12 col-xxl-12 pe-xl-0">
                                        <div class="mb-12 mb-xl-12">
                                            <div class="row gx-0 gx-sm-12">
                                                <div class="col-12">

                                                    <div class="row gx-0 gx-sm-12 gy-12 mb-12">
                                                        <label><b><i class="fa fa-info-circle"></i> Dénomination du projet:
                                                            </b></label>
                                                        <input name="pid" type="hidden" value="{{ Session::get('id') }}" />
                                                        <input name="ptitre" class="form-control form-control-sm" value="{{ $dataProject->title }}"  readonly style="background-color:aliceblue" />
                                                    
                                                    </div>

                                                    <div class="row gx-0 gx-sm-12 gy-12 mb-12">
                                                       
                                                        <label><b><i class="fa fa-info-circle"></i> Titre: </b></label>
                                                        <input type="text" name="pexercice" class="form-control form-control-sm"  maxlength="50"   required />
                                                    </div>

                                                    <div class="row">


                                                        <div class="row gx-4 gy-4 mb-4">
                                                            
                                                            <!-- Colonne 1 -->
                                                            <div class="col-12 col-md-3">
                                                                <label for="budget" class="form-label">Budget :</label>
                                                                <input 
                                                                    type="text" 
                                                                    name="montant" 
                                                                    id="budget"  
                                                                    min="1" 
                                                                    class="form-control form-control-sm" 
                                                                    required 
                                                                    oninput="formatAndValidateNumber(this)"
                                                                >
                                                                <div id="error-message" class="text-danger mt-1" style="display: none;">
                                                                    Caractères invalides détectés. Veuillez entrer uniquement des chiffres et des espaces.
                                                                </div>
                                                            </div>
                                                            
                                                          
                                                            <div class="col-12 col-md-3">
                                                                <label for="datedebut" class="form-label">Début du projet :</label>
                                                                <input type="date" name="datedebut" id="datedebut" class="form-control form-control-sm" required>
                                                            </div>

                                                            <div class="col-12 col-md-3">
                                                                <label for="datefin" class="form-label">Fin du projet  :</label>
                                                                <input type="date" name="datefin" id="datefin"  class="form-control form-control-sm" required>
                                                                <div id="errorDatemessage" class="text-danger mt-1" style="display: none;">
                                                                    La date de fin doit être supérieure à la date de début.
                                                                </div>
                                                             
                                                          
                                                            </div>
                                                            <!-- Colonne 2 -->
                                                            <div class="col-12 col-md-3">
                                                                <label for="numero" class="form-label">Période  :</label>
                                                                <input type="number" name="periode" id="periode" class="form-control form-control-sm" required>
                                                            </div>

                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-header p-4 border-bottom border-300 bg-soft">
                                    <div class="row g-3 justify-content-between align-items-end">
                                        <div class="col-12 col-md" style="padding: 0.3rem 3rem;">

                                        </div>
                                        <div class="col col-md-auto">
                                            <button type="submit" class="btn btn-primary" id="addfebbtn"
                                                name="save"> <i class="fa fa-cloud-upload-alt"></i>
                                                Sauvegarder</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </form>

 

<script>
    document.getElementById('datefin').addEventListener('change', function() {
        const datedebut = new Date(document.getElementById('datedebut').value);
        const datefin = new Date(this.value);

        // Vérifier si les deux dates sont valides
        if (datedebut && datefin && datefin < datedebut) {
            // Afficher le message d'erreur si la date de fin est antérieure à la date de début
            document.getElementById('errorDatemessage').style.display = 'block';
        } else {
            // Cacher le message d'erreur si tout est correct
            document.getElementById('errorDatemessage').style.display = 'none';
        }
    });
</script>

<script>
    function formatAndValidateNumber(input) {
        const errorMessage = document.getElementById('error-message');

        // Étape 1 : Conserver uniquement les chiffres et les espaces
        let cleanedValue = input.value.replace(/[^0-9\s]/g, '');

        // Étape 2 : Supprimer tous les espaces pour reformater correctement
        let numericValue = cleanedValue.replace(/\s+/g, '');

        // Étape 3 : Ajouter automatiquement des espaces après chaque groupe de 3 chiffres
        let formattedValue = numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');

        // Étape 4 : Vérifier si des caractères invalides ont été entrés
        if (input.value !== cleanedValue && input.value !== '') {
            // Afficher le message d'erreur seulement si des caractères invalides sont présents
            errorMessage.style.display = 'block';
        } else {
            // Cacher le message d'erreur si tout est correct
            errorMessage.style.display = 'none';
        }

        // Étape 5 : Mettre à jour la valeur de l'input avec la valeur formatée
        input.value = formattedValue;
    }
</script>


    
  

   
@endsection
