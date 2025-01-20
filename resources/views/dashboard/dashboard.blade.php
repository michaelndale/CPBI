@extends('layout/app')
@section('page-content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @php
        $documentacce = DB::table('febs')->Where('acce', Auth::id())->Where('acce_signe', 0)->get()->count();

        $documentcompte = DB::table('febs')
            ->Where('comptable', Auth::id())
            ->Where('comptable_signe', 0)
            ->get()
            ->count();

        $documentchefcomposent = DB::table('febs')
            ->Where('chefcomposante', Auth::id())
            ->Where('chef_signe', 0)
            ->get()
            ->count();

        $dap_demandeetablie = DB::table('daps')
            ->Where('demandeetablie', Auth::id())
            ->Where('demandeetablie_signe', 0)
            ->get()
            ->count();

        $dap_verifier = DB::table('daps')
            ->Where('verifierpar', Auth::id())
            ->Where('verifierpar_signe', 0)
            ->get()
            ->count();

        $dap_approuverpar = DB::table('daps')
            ->Where('approuverpar', Auth::id())
            ->Where('approuverpar_signe', 0)
            ->get()
            ->count();

        $dap_responsable = DB::table('daps')
            ->Where('responsable', Auth::id())
            ->Where('responsable_signe', 0)
            ->get()
            ->count();

        $dap_secretaire = DB::table('daps')
            ->Where('secretaire', Auth::id())
            ->Where('secretaure_general_signe', 0)
            ->get()
            ->count();

        $dap_chefprogramme = DB::table('daps')
            ->Where('chefprogramme', Auth::id())
            ->Where('chefprogramme_signe', 0)
            ->get()
            ->count();

        $dap_nombre =
            $dap_demandeetablie +
            $dap_verifier +
            $dap_approuverpar +
            $dap_responsable +
            $dap_secretaire +
            $dap_chefprogramme;
        $fab_nombre = $documentacce + $documentcompte + $documentchefcomposent;

        $documentNombre = $dap_nombre + $fab_nombre;

    @endphp

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
                            <div class="page-title-right">
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
                                        <h4 class="card-title mb-4">Graphique des FEBs par moi</h4>

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
                                        <h4 class="card-title mb-4">Graphique des Bon Petite Caisses par moi</h4>
                                        <div id="column_chart_datalabel" class="apex-charts" dir="ltr">
                                            <div style="width: 95%; margin: auto;">
                                                <canvas id="febChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end card-->
                            </div><!--end col-->
                        </div><!-- end row -->


                        <!-- end row -->

                        @if (!session()->has('id'))
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="card">
                                        <div class="card-body">


                                            <h4 class="card-title"><i class="fa fa-search"></i> Recherche du projet</h4>
                                            <div class="mt-4">


                                                <div class="mt-4 text-center">
                                                    <select class="form-select classcategory" id="classcategory">
                                                        <option disabled="true" selected="true"> -- Dossier -- </option>
                                                        @foreach ($folder as $folders)
                                                            <option value="{{ $folders->id }}">
                                                                {{ ucfirst($folders->title) }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mt-4 text-center">

                                                    <select class="form-select annee" id="annee">
                                                        <option value="0" disabled="true" selected="true"> -- Année
                                                            -- </option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-9">
                                    <div class="card">
                                        <div class="card-body">

                                            <h4 class="card-title mb-3"><i class="fa fa-info-circle"></i> Bref résumé de
                                                tous les projets de la recherche</h4>


                                            <div class="table-responsive">
                                                <table class="table table-centered align-middle table-nowrap mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th> Numéro </th>
                                                            <th>Titre du projet</th>
                                                            <th>Date début</th>
                                                            <th>Date fin</th>
                                                            <th>Statut</th>
                                                            <th>Année</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="show_all_projet tableviewsclass" id="show_all_projet">
                                                        <tr>
                                                            <td colspan="6">
                                                                <h6 style="margin-top:1% ;color:#c0c0c0">
                                                                    <center>
                                                                        <font size="5px"><i class="fa fa-search"></i>
                                                                        </font><br><br>
                                                                        Sélectionner le dossier et l'année
                                                                    </center>
                                                                </h6>
                                                            </td>

                                                        </tr>



                                                    </tbody>
                                                </table>
                                                <br>
                                                <a href="{{ route('new_project') }}"
                                                class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" type="button"><i
                                                    class=" mdi mdi-plus-circle-multiple"></i> Créer un projet </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- end row -->

                    </div>


                </div>
                <!-- end row -->



            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @if ($documentNombre != 0)
            <div tabindex="-1" role="dialog"
                aria-labelledby="monNotificationLabel" aria-hidden="true">
               
            <input type="hidden" name="recherche" id="recherche" class="form-control"
                placeholder="Recherche par numéro(F.E.B, D.A.P), date , Initiateur">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <!--<div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel"><i class="fa fa-list"></i> Tâches à faire en
                                attente</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button> !-->
                        </div>
                       <!--  <div class="modal-body">

                            <div id="tableExample2">
                                <div class="table-responsive">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i
                                                class="fas fa-search"></i></span>
                                        <input type="text" name="recherche" id="recherche" class="form-control"
                                            placeholder="Recherche par numéro(F.E.B, D.A.P), date , Initiateur">
                                    </div>

                                    <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                        <thead>
                                            <tr>
                                                <th class="sort border-top "><b> # </b></center>
                                                </th>
                                                <th class="sort border-top" data-sort="Document"><b>Document</b></th>
                                                <th class="sort border-top" data-sort="febnum"><b>
                                                        <center>N<sup>o</sup> DOC</center>
                                                    </b></th>
                                                <th class="sort border-top" data-sort="montant"><b>
                                                        <center>Montant</center>
                                                    </b></th>
                                                <th class="sort border-top" data-sort="Date Doc"><b>Date Doc</b></th>
                                                <th class="sort border-top" data-sort="Créé le"><b>Créé le</b></th>
                                                <th class="sort border-top" data-sort="Date limite"><b>Date Limite</b>
                                                </th>
                                                <th class="sort border-top" data-sort="Créé par"><b>Créé par</b></th>
                                            </tr>
                                        </thead>


                                        <tbody id="footernotification">
                                            <tr>
                                                <td colspan="8">
                                                    <h5 class="text-center text-secondery my-5">
                                                        @include('layout.partiels.load')
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div> /.modal-dialog -->
            </div>
        @endif
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
