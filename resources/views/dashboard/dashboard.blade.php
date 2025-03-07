@extends('layout/app')
@section('page-content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Tableau de bord des projets <BR>
                                <!-- COMMUNAUTÉ DES EGLISES DE PENTECÔTE AU
                                BURUNDI “CEPBU” --> </h4>
                            <div class="page-title-right ">
                                <e class="form-control ps-6 "> @include('dashboard.time')</e>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">

                    @forelse ($communique as $communiques)
                        <div class="col-lg-12">
                            <div class="card border border-danger">
                                <div class="card-header bg-transparent border-danger">
                                    <h5 class="my-0 text-danger"><i
                                            class="mdi mdi-block-helper me-3"></i>{{ $communiques->titre }}</h5>
                                </div>
                                <div class="card-body">

                                    <p class="card-text">
                                        {{ $communiques->description }}

                                        <br> <br>

                                        <i class="fa fa-user"></i> {{ ucfirst($communiques->user_nom) }}
                                        {{ ucfirst($communiques->user_prenom) }},
                                        {{ date('d-m-Y H:i:s', strtotime($communiques->created_at)) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    @empty
                    @endforelse

                    <div class="col-xl-12">
                        <div class="row">
                            <!-- end row -->
                            @if (session()->has('id'))
                                @php
                                    $idprojet_session = session()->get('id'); // Récupère la valeur de 'id' dans la session

                                @endphp

                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap pb-2 gap-2">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-truncate mb-2">LIGNE BUDGÉTAIRES</p>
                                                    <h4 class="mt-2 mb-0">

                                                        {{ $TOTAL_LIGNE_BUDGET->where('projetid', $idprojet_session)->count() }}

                                                        @php
                                                            $allPourcetageligneInProject = round(
                                                                ($TOTAL_LIGNE_BUDGET
                                                                    ->where('projetid', $idprojet_session)
                                                                    ->count() /
                                                                    $TOTAL_LIGNE_BUDGET->count()) *
                                                                    100,
                                                            );
                                                        @endphp

                                                        <span
                                                            class="badge {{ $allPourcetageligneInProject >= 50 ? 'bg-subtle-primary text-primary' : 'bg-subtle-danger text-danger' }} font-size-10 ms-1">
                                                            <i
                                                                class="mdi {{ $allPourcetageligneInProject >= 50 ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                                            {{ $allPourcetageligneInProject }}%
                                                        </span>

                                                    </h4>
                                                </div>
                                                <div class=9 "text-primary">
                                                    <div id="chart-mini2" class="apex-chart"></div>
                                                </div>
                                            </div>
                                            <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate"><span
                                                    class="text-muted fw-normal"> <b> {{ $TOTAL_LIGNE_BUDGET->count() }}</b>
                                                    ~ Lignes budgétaires</span></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap pb-2 gap-2">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-truncate mb-2">ACTIVITÉS</p>
                                                    <h4 class="mt-2 mb-0">
                                                        {{ $activite->where('projectid', $idprojet_session)->count() }}

                                                        @php
                                                            $allPourcetageActiviteInProject = round(
                                                                ($activite
                                                                    ->where('projectid', $idprojet_session)
                                                                    ->count() /
                                                                    $activite->count()) *
                                                                    100,
                                                            );
                                                        @endphp

                                                        <span
                                                            class="badge {{ $allPourcetageActiviteInProject >= 50 ? 'bg-subtle-primary text-primary' : 'bg-subtle-danger text-danger' }} font-size-10 ms-1">
                                                            <i
                                                                class="mdi {{ $allPourcetageActiviteInProject >= 50 ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                                            {{ $allPourcetageActiviteInProject }}%
                                                        </span>


                                                    </h4>
                                                </div>
                                                <div class="text-primary">
                                                    <div id="chart-mini3" class="apex-chart"></div>
                                                </div>
                                            </div>
                                            <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate"><span
                                                    class="text-muted fw-normal"> <b>{{ $activite->count() }} </b> ~ Toutes
                                                    les activités </span></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap pb-2 gap-2">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-truncate mb-2" title="Fiche d'Expression des Besoins">
                                                        F.E.B</p>
                                                    <h4 class="mt-2 mb-0">
                                                        {{ $TOTAL_FEB->where('projetid', $idprojet_session)->count() }}

                                                        @php
                                                            $allPourcetageFebInProject = round(
                                                                ($TOTAL_FEB
                                                                    ->where('projetid', $idprojet_session)
                                                                    ->count() /
                                                                    $TOTAL_FEB->count()) *
                                                                    100,
                                                            );
                                                        @endphp

                                                        <span
                                                            class="badge {{ $allPourcetageFebInProject >= 50 ? 'bg-subtle-primary text-primary' : 'bg-subtle-danger text-danger' }} font-size-10 ms-1">
                                                            <i
                                                                class="mdi {{ $allPourcetageFebInProject >= 50 ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                                            {{ $allPourcetageFebInProject }}%
                                                        </span>

                                                    </h4>
                                                </div>
                                                <div class="text-primary">
                                                    <div id="chart-mini4" class="apex-chart"></div>
                                                </div>
                                            </div>
                                            <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate"><span
                                                    class="text-muted fw-normal"><b> {{ $TOTAL_FEB->count() }}</b> ~ Tous
                                                    les F.E.B </span></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap pb-2 gap-2">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-truncate mb-2">D.A.P</p>
                                                    <h4 class="mt-2 mb-0">
                                                        {{ $TOTAL_DAP->where('projetiddap', $idprojet_session)->count() }}

                                                        @php
                                                            $allPourcetageDapInProject = round(
                                                                ($TOTAL_DAP
                                                                    ->where('projetiddap', $idprojet_session)
                                                                    ->count() /
                                                                    $TOTAL_DAP->count()) *
                                                                    100,
                                                            );
                                                        @endphp

                                                        <span
                                                            class="badge {{ $allPourcetageDapInProject >= 50 ? 'bg-subtle-primary text-primary' : 'bg-subtle-danger text-danger' }} font-size-10 ms-1">
                                                            <i
                                                                class="mdi {{ $allPourcetageDapInProject >= 50 ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                                            {{ $allPourcetageDapInProject }}%
                                                        </span>
                                                    </h4>
                                                </div>
                                                <div class="text-primary">
                                                    <div id="chart-mini4" class="apex-chart"></div>
                                                </div>
                                            </div>
                                            <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate"><span
                                                    class="text-muted fw-normal"> <b>{{ $TOTAL_DAP->count() }}</b> ~ Tous
                                                    les D.A.P</span></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap pb-2 gap-2">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-truncate mb-2">PETITE CAISSE</p>
                                                    <h4 class="mt-2 mb-0">
                                                        {{ $TOTAL_DAPPS->where('projetid', $idprojet_session)->count() }}
                                                            @php
                                                                $totalDappsCount = $TOTAL_DAPPS->count();
                                                                $allPourcetagePetitCaisseInProject = $totalDappsCount > 0
                                                                    ? round(
                                                                        ($TOTAL_DAPPS->where('projetid', $idprojet_session)->count() / $totalDappsCount) * 100
                                                                    )
                                                                    : 0;
                                                            @endphp


                                                        <span
                                                            class="badge {{ $allPourcetagePetitCaisseInProject >= 50 ? 'bg-subtle-primary text-primary' : 'bg-subtle-danger text-danger' }} font-size-10 ms-1">
                                                            <i
                                                                class="mdi {{ $allPourcetagePetitCaisseInProject >= 50 ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                                            {{ $allPourcetagePetitCaisseInProject }}%
                                                        </span>

                                                    </h4>
                                                </div>
                                                <div class="text-primary">
                                                    <div id="chart-mini4" class="apex-chart"></div>
                                                </div>
                                            </div>
                                            <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate"><span
                                                    class="text-muted fw-normal"> <b>{{ $TOTAL_DAPPS->count() }}</b> ~
                                                    Confondues </span></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-wrap pb-2 gap-2">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-truncate mb-2">INTERVENANTS</p>
                                                    <h4 class="mt-2 mb-0">
                                                        {{ $INTERVENANT->where('projectid', $idprojet_session)->count() }}

                                                        @php
                                                            $allIntervenant = $INTERVENANT->count();
                                                            $allPourcetageIntervenantInProject = round(
                                                                ($INTERVENANT
                                                                    ->where('projectid', $idprojet_session)
                                                                    ->count() /
                                                                    $allIntervenant) *
                                                                    100,
                                                            );
                                                        @endphp

                                                        <span
                                                            class="badge {{ $allPourcetageIntervenantInProject >= 50 ? 'bg-subtle-primary text-primary' : 'bg-subtle-danger text-danger' }} font-size-10 ms-1">
                                                            <i
                                                                class="mdi {{ $allPourcetageIntervenantInProject >= 50 ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                                            {{ $allPourcetageIntervenantInProject }}%
                                                        </span>


                                                    </h4>
                                                </div>
                                                <div class="text-primary">
                                                    <div id="chart-mini4" class="apex-chart"></div>
                                                </div>
                                            </div>
                                            <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate"><span
                                                    class="text-muted fw-normal"> <b>{{ $allIntervenant }} </b> ~
                                                    Confondues </span></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">

                                    <div class="col" style="border:1px solid #c0c0c0; background-color:white">

                                        <a class="dropdown-icon-item" href="{{ route('gestioncompte') }}">
                                            <font size="5px" color="green">
                                                <i class="fa fa-chart-line"></i>
                                            </font>
                                            <span>Ligne budgétaire</span>
                                        </a>
                                    </div>

                                </div>

                                <div class="col-md-2">
                                    <div class="col" style="border:1px solid #c0c0c0; background-color:white">
                                        <a class="dropdown-icon-item" href="{{ route('rallongebudget') }}">
                                            <font size="5px" color="green">
                                                <i class="fa fa-chart-bar"></i>
                                            </font>
                                            <span>Budget</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="col" style="border:1px solid #c0c0c0; background-color:white">
                                        <a class="dropdown-icon-item" href="{{ route('activity') }}">
                                            <font size="5px" color="green">
                                                <i class="fa fa-running"></i>
                                            </font>
                                            <span>Activités</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="col" style="border:1px solid #c0c0c0; background-color:white">
                                        <a class="dropdown-icon-item" href="{{ route('listfeb') }}">
                                            <font size="5px" color="green">
                                                <i class="mdi mdi-file-document-outline font-size-30"></i>
                                            </font>
                                            <span>F.E.B</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="col" style="border:1px solid #c0c0c0; background-color:white">
                                        <a class="dropdown-icon-item" href="{{ route('listdap') }}">
                                            <font size="5px" color="green">
                                                <i class="mdi mdi-file-document-outline font-size-30"></i>
                                            </font>
                                            <span>D.A.P</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="col" style="border:1px solid #c0c0c0; background-color:white">
                                        <a class="dropdown-icon-item" href="{{ route('bpc') }}">
                                            <font size="5px" color="green">
                                                <i class="mdi mdi-file-document-outline font-size-30"></i>
                                            </font>
                                            <span>PETITE CAISSE</span>
                                        </a>
                                    </div>
                                </div>
                        </div>

                        <br>


                      
                    @else
                        <div class="col-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap pb-2 gap-2">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-truncate mb-2">PROJETS</p>
                                            <h4 class="mt-2 mb-0">{{ $project->count() }} 
                                                <span class="badge bg-subtle-primary text-primary font-size-10 ms-1"><i
                                                        class="mdi mdi-arrow-up"></i> 100%</sup></span> </h4> 
                                        </div>
                                        <div class="text-primary">
                                            <div id="chart-mini1" class="apex-chart"></div>
                                        </div>
                                    </div>
                                    <p class="mb-0 font-size-14 fw-bold mt-2 "> <span class="text-muted fw-normal"> ~ Tous les projets</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap pb-2 gap-2">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-truncate mb-2">LIGNE BUDGÉTAIRES</p>
                                            <h4 class="mt-2 mb-0">{{ $TOTAL_LIGNE_BUDGET->count() }} 
                                                <span class="badge bg-subtle-primary text-primary font-size-10 ms-1"><i
                                                class="mdi mdi-arrow-up"></i> 100%</sup>
                                               </span>
                                            </h4>
                                        </div>
                                        <div class="text-primary">
                                            <div id="chart-mini2" class="apex-chart"></div>
                                        </div>
                                    </div>
                                    <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate"><span
                                            class="text-muted fw-normal"> ~ Lignes budgétaires</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap pb-2 gap-2">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-truncate mb-2">ACTIVITÉS</p>
                                            <h4 class="mt-2 mb-0">{{ $activite->count() }}  <span class="badge bg-subtle-primary text-primary font-size-10 ms-1"><i
                                                class="mdi mdi-arrow-up"></i> 100%</sup>
                                               </span>
                                            </h4>
                                        </div>
                                        <div class="text-primary">
                                            <div id="chart-mini3" class="apex-chart"></div>
                                        </div>
                                    </div>
                                    <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate"><span
                                            class="text-muted fw-normal"> ~ Toutes les activités </span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap pb-2 gap-2">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-truncate mb-2">F.E.B</p>
                                            <h4 class="mt-2 mb-0">{{ $TOTAL_FEB->count() }} 
                                                <span class="badge bg-subtle-primary text-primary font-size-10 ms-1"><i
                                                    class="mdi mdi-arrow-up"></i> 100%</sup>
                                                   </span>
                                            </h4>
                                        </div>
                                        <div class="text-primary">
                                            <div id="chart-mini4" class="apex-chart"></div>
                                        </div>
                                    </div>
                                    <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate"><span
                                            class="text-muted fw-normal"> ~ Tous les F.E.B </span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap pb-2 gap-2">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-truncate mb-2">D.A.P</p>
                                            <h4 class="mt-2 mb-0">{{ $TOTAL_DAP->count() }}  <span class="badge bg-subtle-primary text-primary font-size-10 ms-1"><i
                                                class="mdi mdi-arrow-up"></i> 100%</sup>
                                               </span></h4>
                                        </div>
                                        <div class="text-primary">
                                            <div id="chart-mini4" class="apex-chart"></div>
                                        </div>
                                    </div>
                                    <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate"><span
                                            class="text-muted fw-normal"> ~ Tous les D.A.P</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap pb-2 gap-2">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-truncate mb-2">PETITE CAISSE</p>
                                            <h4 class="mt-2 mb-0">{{ $TOTAL_DAPPS->count() }} <span class="badge bg-subtle-primary text-primary font-size-10 ms-1"><i
                                                class="mdi mdi-arrow-up"></i> 100%</sup>
                                               </span></h4>
                                        </div>
                                        <div class="text-primary">
                                            <div id="chart-mini4" class="apex-chart"></div>
                                        </div>
                                    </div>
                                    <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate"><span
                                            class="text-muted fw-normal"> ~ Confondues </span></p>
                                </div>
                            </div>
                        </div>
                        @endif


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Graphique des FEBs par mois de l'année en cours</h4>

                                        <div id="column_chart" class="apex-charts" dir="ltr">
                                            <div style="width: 95%; margin: auto;">
                                                <canvas id="comparisonChart"></canvas>

                                            </div>
                                        </div>


                                    </div>
                                </div><!--end card-->
                            </div><!--end col-->


                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Graphique des Bons de Petite Caisse par mois de l'année en cours</h4>
                                        <div id="column_chart_datalabel" class="apex-charts" dir="ltr">
                                            <div style="width: 95%; margin: auto;">
                                                <canvas id="febChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end card-->
                            </div><!--end col-->
                        </div><!-- end row -->


                      

                    </div>


                </div>
                <!-- end row -->



            </div> <!-- container-fluid -->
        </div>
       
    </div>
    @if (session('modal_message'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Accès refusé',
                    text: "Vous n'avez pas l'accréditation nécessaire. Contactez le chef du projet pour être affecté.",
                    icon: 'error',
                    confirmButtonColor: '#28a745', // Couleur verte pour le bouton
                    confirmButtonText: 'OK',
                    allowOutsideClick: false, // Empêche la fermeture en cliquant à l'extérieur
                    customClass: {
                        popup: 'swal2-small', // Classe CSS pour la boîte de dialogue
                        title: 'swal2-title-small', // Classe CSS pour le titre
                        content: 'swal2-content-small' // Classe CSS pour le contenu
                    }
                });
            });
        </script>
        <style>
            /* Dans votre fichier CSS */
            .swal2-small {
                font-size: 14px;
                /* Taille de police générale */
            }

            .swal2-title-small {
                font-size: 18px;
                /* Taille de police du titre */
            }

            .swal2-content-small {
                font-size: 16px;
                /* Taille de police du contenu */
            }
        </style>
    @endif
    <script>
        $(document).ready(function() {
            // Sélectionnez votre modal et utilisez la méthode modal('show') pour l'ouvrir
            $('#monNotification').modal('show');
        });
    </script>
 

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        // Script pour le premier graphique (FEB par mois)
        const totals = @json($totals); // Les totaux par mois
        const maxValue = @json($maxValue); // La valeur max
        const minValue = @json($minValue); // La valeur min
    
        // Couleurs personnalisées : rouge pour le minimum, vert pour le maximum, autre couleur pour les autres
        const backgroundColors = totals.map(value => {
            if (value === maxValue) {
                return 'rgba(75, 192, 192, 0.2)'; // Vert clair pour le mois max
            } else if (value === minValue) {
                return 'rgba(255, 99, 132, 0.2)'; // Rouge clair pour le mois min
            } else {
                return 'rgba(153, 102, 255, 0.2)'; // Couleur par défaut (violet)
            }
        });
    
        const borderColors = totals.map(value => {
            if (value === maxValue) {
                return 'rgba(75, 192, 192, 1)'; // Vert foncé pour le mois max
            } else if (value === minValue) {
                return 'rgba(255, 99, 132, 1)'; // Rouge foncé pour le mois min
            } else {
                return 'rgba(153, 102, 255, 1)'; // Couleur par défaut (violet foncé)
            }
        });
    
        const febCtx = document.getElementById('febChart').getContext('2d');
        const febChart = new Chart(febCtx, {
            type: 'bar',
            data: {
                labels: @json($months), // Les mois de l'année en français
                datasets: [{
                    label: 'Nombre de FEBs par mois',
                    data: totals,
                    backgroundColor: backgroundColors, // Couleurs en fonction des valeurs
                    borderColor: borderColors, // Couleur des bordures
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    
    <script>
        // Script pour le graphique de comparaison (FEB vs DAPS)
        const months = @json($months); // Les mois de l'année en français
        const totalsFebs = @json($totalsFebs); // Totaux pour FEBs
        const totalsDaps = @json($totalsDaps); // Totaux pour DAPS
    
        const comparisonCtx = document.getElementById('comparisonChart').getContext('2d');
        const comparisonChart = new Chart(comparisonCtx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                        label: 'Nombre de FEB par mois',
                        data: totalsFebs,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Nombre de DAPS par mois',
                        data: totalsDaps,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    

    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on('change', '.classcategory', function() {
                var cat_id = $(this).val();
                var op = '<option value="0" selected disabled>--Année--</option>';

                $.ajax({
                    type: 'get',
                    url: "{{ route('findClaseur') }}",
                    data: {
                        'id': cat_id
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.length == 0) {
                            op += '<option value="0" disabled>Aucun</option>';
                            toastr.error("Attention!!\n Le dossier n'a pas de projet",
                                "Information");
                        } else {
                            for (var i = 0; i < data.length; i++) {
                                op += '<option value="' + data[i].annee + '">' + data[i].annee +
                                    '</option>';
                            }
                        }
                        $("#annee").html(op);
                    },
                    error: function() {
                        toastr.error(
                            "Erreur de connexion à la base de données,\n Vérifiez votre connexion",
                            "Attention");
                    }
                });
            });

            $(document).on('change', '.annee', function() {
                var ann_id = $(this).val();
                var classcategory = $('#classcategory').val();

                $.ajax({
                    type: 'get',
                    url: "{{ route('findAnnee') }}",
                    data: {
                        'id': ann_id,
                        'docid': classcategory
                    },
                    dataType: 'json',
                    success: function(data) {
                        $("#show_all_projet").html(data);
                    },
                    error: function() {
                        toastr.error("Erreur lors de la récupération des données du projet.",
                            "Attention");
                    }
                });
            });
        });
    </script>

@endsection
