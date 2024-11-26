
    @php

    // DOCUMENT GENERALE
    $feb_counts = DB::table('febs')
        ->selectRaw(
            "
            SUM(CASE WHEN acce = ? AND acce_signe = 0 THEN 1 ELSE 0 END) AS acce_count,
            SUM(CASE WHEN comptable = ? AND comptable_signe = 0 THEN 1 ELSE 0 END) AS comptable_count,
            SUM(CASE WHEN chefcomposante = ? AND chef_signe = 0 THEN 1 ELSE 0 END) AS chefcomposante_count
        ",
            [Auth::id(), Auth::id(), Auth::id()],
        )
        ->first();
    
    // Calcul du total
    $feb = $feb_counts->acce_count + $feb_counts->comptable_count + $feb_counts->chefcomposante_count;
    
    $dap_counts = DB::table('daps')
        ->selectRaw(
            "
            SUM(CASE WHEN demandeetablie = ? AND demandeetablie_signe = 0 THEN 1 ELSE 0 END) AS demandeetablie_count,
            SUM(CASE WHEN verifierpar = ? AND verifierpar_signe = 0 THEN 1 ELSE 0 END) AS verifierpar_count,
            SUM(CASE WHEN approuverpar = ? AND approuverpar_signe = 0 THEN 1 ELSE 0 END) AS approuverpar_count,
            SUM(CASE WHEN responsable = ? AND responsable_signe = 0 THEN 1 ELSE 0 END) AS responsable_count,
            SUM(CASE WHEN secretaire = ? AND secretaure_general_signe = 0 THEN 1 ELSE 0 END) AS secretaire_count,
            SUM(CASE WHEN chefprogramme = ? AND chefprogramme_signe = 0 THEN 1 ELSE 0 END) AS chefprogramme_count
        ",
            [Auth::id(), Auth::id(), Auth::id(), Auth::id(), Auth::id(), Auth::id()],
        )
        ->first();
    
    // Calcul total
    $dap =
        $dap_counts->demandeetablie_count +
        $dap_counts->verifierpar_count +
        $dap_counts->approuverpar_count +
        $dap_counts->responsable_count +
        $dap_counts->secretaire_count +
        $dap_counts->chefprogramme_count;
    
    $FEB_PTC_counts = DB::table('febpetitcaisses')
        ->selectRaw(
            "
            SUM(CASE WHEN etabli_par = ? AND etabli_par_signature = 0 THEN 1 ELSE 0 END) AS etabli_count,
            SUM(CASE WHEN verifie_par = ? AND verifie_par_signature = 0 THEN 1 ELSE 0 END) AS verifie_count,
            SUM(CASE WHEN approuve_par = ? AND approuve_par_signature = 0 THEN 1 ELSE 0 END) AS approuve_count
        ",
            [Auth::id(), Auth::id(), Auth::id()],
        )
        ->first();
    
    // Calcul total
    $FEB_PTC = $FEB_PTC_counts->etabli_count + $FEB_PTC_counts->verifie_count + $FEB_PTC_counts->approuve_count;
    
    $DAP_PTC_counts = DB::table('dapbpcs')
        ->selectRaw(
            "
            SUM(CASE WHEN demande_etablie = ? AND demande_etablie_signe = 0 THEN 1 ELSE 0 END) AS demande_etablie_count,
            SUM(CASE WHEN verifier = ? AND verifier_signe = 0 THEN 1 ELSE 0 END) AS verifier_count,
            SUM(CASE WHEN approuver = ? AND approuver_signe = 0 THEN 1 ELSE 0 END) AS approuver_count,
            SUM(CASE WHEN autoriser = ? AND autoriser_signe = 0 THEN 1 ELSE 0 END) AS autoriser_count,
            SUM(CASE WHEN secretaire = ? AND secretaire_signe = 0 THEN 1 ELSE 0 END) AS secretaire_count,
            SUM(CASE WHEN chefprogramme = ? AND chefprogramme_signe = 0 THEN 1 ELSE 0 END) AS chefprogramme_count
        ",
            [Auth::id(), Auth::id(), Auth::id(), Auth::id(), Auth::id(), Auth::id()],
        )
        ->first();
    
    // Calcul total
    $DAP_PTC =
        $DAP_PTC_counts->demande_etablie_count +
        $DAP_PTC_counts->verifier_count +
        $DAP_PTC_counts->approuver_count +
        $DAP_PTC_counts->autoriser_count +
        $DAP_PTC_counts->secretaire_count +
        $DAP_PTC_counts->chefprogramme_count;
    
    $BON_PTC_counts = DB::table('bonpetitcaisses')
        ->selectRaw(
            "
            SUM(CASE WHEN etabli_par = ? AND etabli_par_signature = 0 THEN 1 ELSE 0 END) AS etabli_par_count,
            SUM(CASE WHEN verifie_par = ? AND verifie_par_signature = 0 THEN 1 ELSE 0 END) AS verifie_par_count,
            SUM(CASE WHEN approuve_par = ? AND approuve_par_signature = 0 THEN 1 ELSE 0 END) AS approuve_par_count
        ",
            [Auth::id(), Auth::id(), Auth::id()],
        )
        ->first();
    
    // Calcul total
    $BON_PTC =
        $BON_PTC_counts->etabli_par_count +
        $BON_PTC_counts->verifie_par_count +
        $BON_PTC_counts->approuve_par_count;
    
    $CAISSE_PTC_counts = DB::table('rappotages')
        ->selectRaw(
            "
            SUM(CASE WHEN verifier_par = ? AND verifier_signature = 0 THEN 1 ELSE 0 END) AS verifier_count,
            SUM(CASE WHEN approver_par = ? AND approver_signature = 0 THEN 1 ELSE 0 END) AS approver_count
        ",
            [Auth::id(), Auth::id()],
        )
        ->first();
    
    // Calcul total
    $CAISSE_PTC = $CAISSE_PTC_counts->verifier_count + $CAISSE_PTC_counts->approver_count;
    
    $documentNombre = $feb + $dap + $FEB_PTC + $DAP_PTC + $BON_PTC + $CAISSE_PTC;
    
    if (session()->has('id')) {
        $ProjetIdEncours = Session::get('id');
        $classement = DB::table('rappotages')->where('cloture', 0)->where('projetid', $ProjetIdEncours)->first();
    }
    
    $feb_signale = DB::table('febs')
        ->join('projects', 'febs.projetid', '=', 'projects.id')
        ->join('affectations', 'febs.projetid', '=', 'affectations.projectid')
        ->where('febs.signale', '=', 1)
        ->distinct() // Ajoute distinct pour éviter la duplication
        ->count('febs.id'); // Compter uniquement les enregistrements uniques de 'febs'
    
    $dap_signale = DB::table('daps')
        ->join('projects', 'daps.projetiddap', '=', 'projects.id')
        ->join('affectations', 'daps.projetiddap', '=', 'affectations.projectid')
        ->where('daps.signaledap', '=', 1)
        ->distinct() // Ajoute distinct pour éviter la duplication
        ->count('daps.id'); // Compter uniquement les enregistrements uniques de 'DAPs'
    
            $total_signalisation = $feb_signale + $dap_signale;
    
        @endphp

@if ($documentNombre != 0)
<audio autoplay>
    <source src="{{ asset('notification/son.mp3') }}" type="audio/mpeg">
    Votre navigateur ne supporte pas l'élément audio.
</audio>
<li class="nav-item">
    <a href="#" class="waves-effect"
        class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
        data-bs-target=".bs-example-modal-lg">
        <i class="ri-file-edit-fill "></i><span
            class="badge rounded-pill bg-danger float-end">{{ $documentNombre }}</span>
        <span>Documents</span>
    </a>
</li>
@endif


@if ($total_signalisation != 0)
<li class="nav-item">
    <a href="#" class="waves-effect"
        class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
        data-bs-target=".bs-signalisation">
        <i class="ri-chat-voice-line"></i><span
            class="badge rounded-pill bg-danger float-end">{{ $total_signalisation }}</span>
        <span>Signalisation</span>
    </a>
</li>
@endif