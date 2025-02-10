@php

// RECUPERATION POUR RECUPERATION DES 

$febsNombreNostis = DB::table('febs')
    ->join('exercice_projets', 'febs.execiceid', '=', 'exercice_projets.id')
    ->join('projects', 'febs.projetid', '=', 'projects.id') // Jointure sur projects
    ->join('comptes', 'febs.sous_ligne_bugdetaire', '=', 'comptes.id') // Jointure sur comptes
    ->join('users', 'febs.userid', '=', 'users.id') // Jointure sur users
    ->join('personnels', 'users.personnelid', '=', 'personnels.id') // Jointure sur personnels
    ->where(function ($query) {
        $query
            ->orWhere(function ($subQuery) {
                $subQuery->where('acce', Auth::id())->where('acce_signe', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery->where('comptable', Auth::id())->where('comptable_signe', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery->where('chefcomposante', Auth::id())->where('chef_signe', 0);
            });
    })
    ->selectRaw('
        febs.*,
        febs.id as idfeb,
        personnels.prenom as user_prenom,
        comptes.numero as code,
        projects.id AS projet_id,
        projects.title AS projet_title,
        projects.numeroprojet AS projet_numero,
        personnels.nom AS user_nom,
        personnels.prenom AS user_prenom,
        projects.annee AS projet_annee,
        exercice_projets.status AS status, -- Ajout du champ status
        SUM(CASE WHEN exercice_projets.status = "Actif" THEN 1 ELSE 0 END) OVER () AS total_actifs,
        SUM(CASE WHEN exercice_projets.status = "Inactif" THEN 1 ELSE 0 END) OVER () AS total_inactifs
    ')
    ->orderBy('projects.title') // Ordonner par titre du projet
    ->orderBy('febs.numerofeb') // Puis ordonner par numéro FEB
    ->get();

// Accédez aux statistiques via les premiers éléments
$totalActifsFeb = $febsNombreNostis[0]->total_actifs ?? 0;
$totalInactifsFEb = $febsNombreNostis[0]->total_inactifs ?? 0;

// Filtrage des enregistrements actifs
$Actif = 'Actif';
$febsActifs = $febsNombreNostis->filter(function ($item) use ($Actif) {
    return $item->status === $Actif; // Maintenant, $item->status existe
})->values(); // Convertir en collection indexée

// Filtrage des enregistrements inactifs
$Inactif = 'Inactif';
$febsInactifs = $febsNombreNostis->filter(function ($item) use ($Inactif) {
    return $item->status === $Inactif; // Maintenant, $item->status existe
})->values(); // Convertir en collection indexée

// Maintenant, vous avez :
// - $totalActifsFeb : Nombre d'enregistrements actifs
// - $totalInactifsFEb : Nombre d'enregistrements inactifs
// - $febsNombres : Total des enregistrements
// - $febsNombreNostis : Tableau complet des enregistrements ordonnés par titre de projet et numéro FEB

// -------------------------------  fin

// Récupération de tous les enregistrements DAP (avec statistiques agrégées)
$dapNombreNostis = DB::table('daps')
    ->join('exercice_projets', 'daps.exerciceids', '=', 'exercice_projets.id')
    ->join('projects', 'daps.projetiddap', '=', 'projects.id') // Jointure sur projects
    ->join('users', 'daps.userid', '=', 'users.id') // Jointure sur users
    ->join('personnels', 'users.personnelid', '=', 'personnels.id') // Jointure sur personnels
    ->where(function ($query) {
        $query
            ->orWhere(function ($subQuery) {
                $subQuery->where('demandeetablie', Auth::id())->where('demandeetablie_signe', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery->where('verifierpar', Auth::id())->where('verifierpar_signe', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery->where('approuverpar', Auth::id())->where('approuverpar_signe', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery->where('responsable', Auth::id())->where('responsable_signe', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery->where('secretaire', Auth::id())->where('secretaure_general_signe', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery->where('chefprogramme', Auth::id())->where('chefprogramme_signe', 0);
            });
    })
    ->selectRaw('
        SUM(CASE WHEN exercice_projets.status = "Actif" THEN 1 ELSE 0 END) OVER () AS total_actifs,
        SUM(CASE WHEN exercice_projets.status = "Inactif" THEN 1 ELSE 0 END) OVER () AS total_inactifs,
        daps.*,
        projects.id AS projet_id,
        projects.title AS projet_title,
        projects.numeroprojet AS projet_numero,
        personnels.nom AS user_nom,
        personnels.prenom AS user_prenom,
        projects.annee AS projet_annee,
        exercice_projets.status AS status, -- Ajout du champ status
        daps.id as iddaps
    ')
    ->orderBy('projects.title') // Ordonner par titre du projet
    ->orderBy('daps.numerodp') // Puis ordonner par numéro DAP
    ->get();

// Accédez aux statistiques via les premiers éléments
$totalActifsDap = $dapNombreNostis[0]->total_actifs ?? 0;
$totalInactifsDap = $dapNombreNostis[0]->total_inactifs ?? 0;



// Filtrage des enregistrements actifs
$ActifDap = 'Actif';
$dapsActifs = $dapNombreNostis->filter(function ($itemDap) use ($ActifDap) {
    return $itemDap->status === $ActifDap; // Maintenant, $item->status existe
})->values(); // Convertir en collection indexée

// Filtrage des enregistrements inactifs
$InactifDap = 'Inactif';
$dapsInactifs = $dapNombreNostis->filter(function ($itemDap) use ($InactifDap) {
    return $itemDap->status === $InactifDap; // Maintenant, $item->status existe
})->values(); // Convertir en collection indexée


// Maintenant, vous avez :
// - $totalActifsDap : Nombre d'enregistrements actifs
// - $totalInactifsDap : Nombre d'enregistrements inactifs
// - $dapNombres : Total des enregistrements
// - $dapNombreNostis : Tableau complet des enregistrements avec les données jointes


// Récupération des statistiques agrégées (actifs et inactifs) pour les DJA
$djaNombreNostis = DB::table('djas')
    ->join('exercice_projets', 'djas.exerciceids', '=', 'exercice_projets.id')
    ->join('projects', 'djas.projetiddja', '=', 'projects.id') // Jointure sur projects
    ->join('users', 'djas.userid', '=', 'users.id') // Jointure sur users
    ->join('personnels', 'users.personnelid', '=', 'personnels.id') // Jointure sur personnels
    ->where(function ($query) {
        $query
            ->orWhere(function ($subQuery) {
                $subQuery->where('djas.fonds_demande_par', Auth::id())->where('djas.signe_fonds_demande_par', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery->where('djas.avance_approuver_par', Auth::id())->where('djas.signe_avance_approuver_par', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery->where('djas.avance_approuver_par_deux', Auth::id())->where('djas.signe_avance_approuver_par_deux', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery->where('djas.avance_approuver_par_trois', Auth::id())->where('djas.signe_avance_approuver_par_trois', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery->where('djas.fond_debourser_par', Auth::id())->where('djas.signe_fond_debourser_par', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery->where('djas.fond_recu_par', Auth::id())->where('djas.signe_fond_recu_par', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery->where('djas.pfond_paye', Auth::id())->where('djas.signature_pfond_paye', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery->where('djas.fonds_retournes_caisse_par', Auth::id())->where('djas.signe_reception_pieces_justificatives', 0);
            });
    })
    ->selectRaw('
        SUM(CASE WHEN exercice_projets.status = "Actif" THEN 1 ELSE 0 END) OVER () AS total_actifs,
        SUM(CASE WHEN exercice_projets.status = "Inactif" THEN 1 ELSE 0 END) OVER () AS total_inactifs,
        djas.*,
        projects.id AS projet_id,
        projects.title AS projet_title,
        projects.numeroprojet AS projet_numero,
        personnels.nom AS user_nom,
        personnels.prenom AS user_prenom,
        projects.annee AS projet_annee,
        exercice_projets.status AS status, -- Ajout du champ status
        djas.id AS iddja
    ')
    ->orderBy('projects.title') // Ordonner par titre du projet
    ->orderBy('djas.numerodjas') // Puis ordonner par numéro DJA
    ->get();

// Accédez aux statistiques via les premiers éléments
$totalActifsDja = $djaNombreNostis[0]->total_actifs ?? 0;
$totalInactifsDja = $djaNombreNostis[0]->total_inactifs ?? 0;


// Filtrage des enregistrements actifs
$ActifDja = 'Actif';
$djasActifs = $djaNombreNostis->filter(function ($itemdja) use ($ActifDja) {
    return $itemdja->status === $ActifDja; // Maintenant, $item->status existe
})->values(); // Convertir en collection indexée

// Filtrage des enregistrements inactifs
$InactifDja = 'Inactif';
$djasInactifs = $djaNombreNostis->filter(function ($itemdja) use ($InactifDja) {
    return $itemdja->status === $InactifDja; // Maintenant, $item->status existe
})->values(); // Convertir en collection indexée

// Maintenant, vous avez :
// - $totalActifsDja : Nombre d'enregistrements actifs
// - $totalInactifsDja : Nombre d'enregistrements inactifs
// - $djaNombres : Total des enregistrements
// - $djaNombreNostis : Tableau complet des enregistrements ordonnés par titre de projet et numéro DJA





// Récupération des statistiques agrégées (actifs et inactifs) pour les BPC
$bpcNombreNostis = DB::table('bonpetitcaisses')
    ->join('exercice_projets', 'bonpetitcaisses.exercice_id', '=', 'exercice_projets.id')
    ->join('projects', 'bonpetitcaisses.projetid', '=', 'projects.id') // Jointure sur projects
    ->join('users', 'bonpetitcaisses.userid', '=', 'users.id') // Jointure sur users
    ->join('personnels', 'users.personnelid', '=', 'personnels.id') // Jointure sur personnels
    ->where(function ($query) {
        $query
            ->where('bonpetitcaisses.etabli_par', Auth::id())
            ->where('bonpetitcaisses.etabli_par_signature', 0)
            ->orWhere('bonpetitcaisses.verifie_par', Auth::id())
            ->where('bonpetitcaisses.verifie_par_signature', 0)
            ->orWhere('bonpetitcaisses.approuve_par', Auth::id())
            ->where('bonpetitcaisses.approuve_par_signature', 0);
    })
    ->selectRaw('
        SUM(CASE WHEN exercice_projets.status = "Actif" THEN 1 ELSE 0 END) OVER () AS total_actifs,
        SUM(CASE WHEN exercice_projets.status = "Inactif" THEN 1 ELSE 0 END) OVER () AS total_inactifs,
        bonpetitcaisses.*,
        bonpetitcaisses.id AS idbpc,
        personnels.prenom AS user_prenom,
        projects.id AS projet_id,
        projects.title AS projet_title,
        projects.numeroprojet AS projet_numero,
        personnels.nom AS user_nom,
        personnels.prenom AS user_prenom,
        projects.annee AS projet_annee,
        exercice_projets.status AS status, -- Ajout du champ status
        bonpetitcaisses.numero AS numero
    ')
    ->orderBy('projects.title') // Trier par titre du projet
    ->orderBy('bonpetitcaisses.numero') // Trier par numéro dans un projet
    ->get();

// Accédez aux statistiques via les premiers éléments
$totalActifsBpc = $bpcNombreNostis[0]->total_actifs ?? 0;
$totalInactifsBpc = $bpcNombreNostis[0]->total_inactifs ?? 0;


// Filtrage des enregistrements actifs
$Actif = 'Actif';
$bpcsActifs = $bpcNombreNostis->filter(function ($item) use ($Actif) {
    return $item->status === $Actif; // Maintenant, $item->status existe
})->values(); // Convertir en collection indexée

// Filtrage des enregistrements inactifs
$Inactif = 'Inactif';
$bpcsInactifs = $bpcNombreNostis->filter(function ($item) use ($Inactif) {
    return $item->status === $Inactif; // Maintenant, $item->status existe
})->values(); // Convertir en collection indexée

// Maintenant, vous avez :
// - $totalActifsBpc : Nombre d'enregistrements actifs
// - $totalInactifsBpc : Nombre d'enregistrements inactifs
// - $bpcNombres : Total des enregistrements
// - $bpcNombreNostis : Tableau complet des enregistrements ordonnés par titre de projet et numéro BPC

   

// Récupération des statistiques agrégées (actifs et inactifs) pour les FEB Petit Caisses
$facNombreNostis = DB::table('febpetitcaisses')
    ->join('exercice_projets', 'febpetitcaisses.exercice_id', '=', 'exercice_projets.id')
    ->join('projects', 'febpetitcaisses.projet_id', '=', 'projects.id') // Jointure sur projects
    ->join('comptes', 'febpetitcaisses.compte_id', '=', 'comptes.id') // Jointure sur comptes
    ->join('users', 'febpetitcaisses.user_id', '=', 'users.id') // Jointure sur users
    ->join('personnels', 'users.personnelid', '=', 'personnels.id') // Jointure sur personnels
    ->where(function ($query) {
        $query
            ->where('febpetitcaisses.etabli_par', Auth::id())
            ->where('febpetitcaisses.etabli_par_signature', 0)
            ->orWhere('febpetitcaisses.verifie_par', Auth::id())
            ->where('febpetitcaisses.verifie_par_signature', 0)
            ->orWhere('febpetitcaisses.approuve_par', Auth::id())
            ->where('febpetitcaisses.approuve_par_signature', 0);
    })
    ->selectRaw('
        SUM(CASE WHEN exercice_projets.status = "Actif" THEN 1 ELSE 0 END) OVER () AS total_actifs,
        SUM(CASE WHEN exercice_projets.status = "Inactif" THEN 1 ELSE 0 END) OVER () AS total_inactifs,
        febpetitcaisses.*,
        febpetitcaisses.id AS idfac,
        personnels.prenom AS user_prenom,
        comptes.numero AS code,
        projects.id AS projet_id,
        projects.title AS projet_title,
        projects.numeroprojet AS projet_numero,
        personnels.nom AS user_nom,
        personnels.prenom AS user_prenom,
        projects.annee AS projet_annee,
        exercice_projets.status AS status, -- Ajout du champ status
        febpetitcaisses.numero AS numero
    ')
    ->orderBy('projects.title') // Ordonner par titre du projet
    ->orderBy('febpetitcaisses.numero') // Puis ordonner par numéro FEB Petit Caisse
    ->get();

// Accédez aux statistiques via les premiers éléments
$totalActifsFac = $facNombreNostis[0]->total_actifs ?? 0;
$totalInactifsFac = $facNombreNostis[0]->total_inactifs ?? 0;




// Filtrage des enregistrements actifs
$Actif = 'Actif';
$facsActifs = $facNombreNostis->filter(function ($item) use ($Actif) {
    return $item->status === $Actif; // Maintenant, $item->status existe
})->values(); // Convertir en collection indexée

// Filtrage des enregistrements inactifs
$Inactif = 'Inactif';
$facsInactifs = $facNombreNostis->filter(function ($item) use ($Inactif) {
    return $item->status === $Inactif; // Maintenant, $item->status existe
})->values(); // Convertir en collection indexée

// Maintenant, vous avez :
// - $totalActifsFac : Nombre d'enregistrements actifs
// - $totalInactifsFac : Nombre d'enregistrements inactifs
// - $facNombres : Total des enregistrements
// - $bpcpcNombreNostis : Tableau complet des enregistrements ordonnés par titre de projet et numéro FEB Petit Caisse



   // Récupération des statistiques agrégées (actifs et inactifs) pour les DAPBPC
$dapbpcNombreNostis = DB::table('dapbpcs')
    ->join('exercice_projets', 'dapbpcs.exercice_id', '=', 'exercice_projets.id')
    ->join('projects', 'dapbpcs.projetid', '=', 'projects.id') // Jointure sur projects
    ->join('users', 'dapbpcs.userid', '=', 'users.id') // Jointure sur users
    ->join('personnels', 'users.personnelid', '=', 'personnels.id') // Jointure sur personnels
    ->where(function ($query) {
        $query
            ->where('dapbpcs.demande_etablie', Auth::id())
            ->where('dapbpcs.demande_etablie_signe', 0)
            ->orWhere('dapbpcs.verifier', Auth::id())
            ->where('dapbpcs.verifier_signe', 0)
            ->orWhere('dapbpcs.approuver', Auth::id())
            ->where('dapbpcs.approuver_signe', 0)
            ->orWhere('dapbpcs.autoriser', Auth::id())
            ->where('dapbpcs.autoriser_signe', 0)
            ->orWhere('dapbpcs.secretaire', Auth::id())
            ->where('dapbpcs.chefprogramme_signe', 0)
            ->orWhere('dapbpcs.chefprogramme', Auth::id())
            ->where('dapbpcs.secretaire_signe', 0);
    })
    ->selectRaw('
        SUM(CASE WHEN exercice_projets.status = "Actif" THEN 1 ELSE 0 END) OVER () AS total_actifs,
        SUM(CASE WHEN exercice_projets.status = "Inactif" THEN 1 ELSE 0 END) OVER () AS total_inactifs,
        dapbpcs.*,
        projects.id AS projet_id,
        projects.title AS projet_title,
        projects.numeroprojet AS projet_numero,
        personnels.nom AS user_nom,
        personnels.prenom AS user_prenom,
        projects.annee AS projet_annee,
        dapbpcs.id AS idddaps,
        exercice_projets.status AS status, -- Ajout du champ status
        dapbpcs.numerodap AS numerodap
    ')
    ->orderBy('projects.title') // Ordonner par titre du projet
    ->orderBy('dapbpcs.numerodap') // Puis ordonner par numéro DAPBPC
    ->get();

// Accédez aux statistiques via les premiers éléments
$totalActifsDac = $dapbpcNombreNostis[0]->total_actifs ?? 0;
$totalInactifsDac = $dapbpcNombreNostis[0]->total_inactifs ?? 0;

// Filtrage des enregistrements actifs
$Actif = 'Actif';
$dacActifs = $dapbpcNombreNostis->filter(function ($item) use ($Actif) {
    return $item->status === $Actif; // Maintenant, $item->status existe
})->values(); // Convertir en collection indexée

// Filtrage des enregistrements inactifs
$Inactif = 'Inactif';
$dacInactifs = $dapbpcNombreNostis->filter(function ($item) use ($Inactif) {
    return $item->status === $Inactif; // Maintenant, $item->status existe
})->values(); // Convertir en collection indexée

// Maintenant, vous avez :
// - $totalActifsDac : Nombre d'enregistrements actifs
// - $totalInactifsDac : Nombre d'enregistrements inactifs
// - $dacNombres : Total des enregistrements
// - $dapbpcNombreNostis : Tableau complet des enregistrements ordonnés par titre de projet et numéro DAPBPC

// Récupération des statistiques agrégées (actifs et inactifs) pour les Rappotages
$rappotageNombreNostis = DB::table('rappotages')
    ->join('exercice_projets', 'rappotages.exercice_id', '=', 'exercice_projets.id') // Jointure sur exercice_projets
    ->join('projects', 'rappotages.projetid', '=', 'projects.id') // Jointure sur projects
    ->join('users', 'rappotages.userid', '=', 'users.id') // Jointure sur users
    ->join('personnels', 'users.personnelid', '=', 'personnels.id') // Jointure sur personnels
    ->where(function ($query) {
        $query
            ->orWhere(function ($subQuery) {
                $subQuery->where('verifier_par', Auth::id())->where('verifier_signature', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery->where('approver_par', Auth::id())->where('approver_signature', 0);
            });
    })
    ->selectRaw('
        SUM(CASE WHEN exercice_projets.status = "Actif" THEN 1 ELSE 0 END) OVER () AS total_actifs,
        SUM(CASE WHEN exercice_projets.status = "Inactif" THEN 1 ELSE 0 END) OVER () AS total_inactifs,
        rappotages.*,
        projects.id AS projet_id,
        projects.title AS projet_title,
        projects.numeroprojet AS projet_numero,
        personnels.nom AS user_nom,
        personnels.prenom AS user_prenom,
        projects.annee AS projet_annee,
        rappotages.id AS idrac,
        exercice_projets.status AS status, -- Ajout du champ status
        rappotages.numero_groupe AS numero_groupe
    ')
    ->orderBy('projects.title') // Ordonner par titre du projet
    ->orderBy('rappotages.numero_groupe') // Puis ordonner par numéro de groupe
    ->get();

// Accédez aux statistiques via les premiers éléments
$totalActifsCaisse = $rappotageNombreNostis[0]->total_actifs ?? 0;
$totalInactifsCaisse = $rappotageNombreNostis[0]->total_inactifs ?? 0;


// Filtrage des enregistrements actifs
$Actif = 'Actif';
$caissesActives = $rappotageNombreNostis->filter(function ($item) use ($Actif) {
    return $item->status === $Actif; // Maintenant, $item->status existe
})->values(); // Convertir en collection indexée

// Filtrage des enregistrements inactifs
$Inactif = 'Inactif';
$caissesInactives = $rappotageNombreNostis->filter(function ($item) use ($Inactif) {
    return $item->status === $Inactif; // Maintenant, $item->status existe
})->values(); // Convertir en collection indexée

// Maintenant, vous avez :
// - $totalActifsCaisse : Nombre d'enregistrements actifs
// - $totalInactifsCaisse : Nombre d'enregistrements inactifs
// - $caisseNombres : Total des enregistrements
// - $rappotageNombreNostis : Tableau complet des enregistrements ordonnés par titre de projet et numéro de groupe

    $documentNombre = $totalActifsDap + $totalActifsFeb  + $totalActifsDja + $totalActifsBpc + $totalActifsFac + $totalActifsDac + $totalActifsCaisse;
    $documentNombreInactif = $totalInactifsFEb + $totalInactifsDap + $totalInactifsDja +  $totalInactifsBpc + $totalInactifsFac  +  $totalInactifsDac + $totalInactifsCaisse ;;
    $totalNotis = $documentNombre + $documentNombreInactif;
@endphp

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-list"></i> Tâches à faire en attente  ({{ $totalNotis }}  <small>Résultat{{ $totalNotis > 1 ? 's' : '' }}</small>) 
                   
                                                                  
                 </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">



               
                    <div class="card">
                        <div class="card-body">

                         

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block"> <i class="fa fa-list"></i>  Document des exercices des projets en cours ({{ $documentNombre }})</span> 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block"><i class="fa fa-list"></i> Document des exercices des projets archiver ({{$documentNombreInactif}}) </span> 
                                    </a>
                                </li>
                              <!-- <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                        <span class="d-none d-sm-block">Messages</span>   
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#settings1" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                        <span class="d-none d-sm-block">Settings</span>    
                                    </a>
                                </li> -->
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="home1" role="tabpanel">

                                        <!-- Nofification de l'annee encours -->
                                        <div id="tableExample2">
                                            <div class="table-responsive">
                                                <!--
                                                <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                                        <input type="text" name="recherche" id="recherche" class="form-control" placeholder="Recherche par numéro(F.E.B, D.A.P), date , Initiateur">
                                                    </div> 
                                                -->

                                                <h5><i class="fa fa-info-circle"> Documents à signer des exercices du projet en cours  ({{ $documentNombre }})</i> </h5>

                                                <div id="accordion" class="custom-accordion">

                                                    <div class="card mb-1">
                                                        <a href="#collapseOne" class="text-dark" data-bs-toggle="collapse" aria-expanded="true"
                                                            aria-controls="collapseOne">
                                                            <div class="card-header" id="headingOne">
                                                                <h6 class="m-0">
                                                                    
                                                                    <b>FEB  ({{ $totalActifsFeb  }})</b> 
                                                                    <small>Résultat{{ $totalActifsFeb > 1 ? 's' : '' }}</small>
                                                                    <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                                    <br>
                                                                    Fiche d'Expression des Besoins
                                                                </h6>
                                                            </div>
                                                        </a>

                                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                                            data-bs-parent="#accordion">
                                                            <div class="card-body">

                                                                
                                                                <!-- Début du tableau -->
                                                                <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="sort border-top"><b>#</b></th>
                                                                            <th class="sort border-top" data-sort="febnum">
                                                                                <b><center>N<sup>o</sup> DOC</center></b>
                                                                            </th>
                                                                            <th class="sort border-top" data-sort="montant"><b><center>Montant</center></b></th>
                                                                            <th class="sort border-top" data-sort="Date Doc"><b>Date FEB</b></th>
                                                                            <th class="sort border-top" data-sort="Créé le"><b>Créé le</b></th>
                                                                            <th class="sort border-top" data-sort="Date limite"><b>Date Limite</b></th>
                                                                            <th class="sort border-top" data-sort="Créé par"><b>Créé par</b></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if ($febsActifs->isNotEmpty())

                                                                        <?php
                                                                        // Initialisation des variables
                                                                        $groupedByProject = $febsActifs->groupBy('projet_title');
                                                                        $numooOrder = 1;
                                                            
                                                                        foreach ($groupedByProject as $projectTitleFeb => $febsAct) {
                                                                            // Afficher le titre du projet
                                                                            echo '<tr style="background-color:#addfad">
                                                                                      <td colspan="7"><b>' . ucfirst($projectTitleFeb) . '</b></td>
                                                                                  </tr>';
                                                            
                                                                            // Afficher les notifications pour chaque projet
                                                                            foreach ($febsAct as $febsActif) {
                                                                                // Calculer le montant total des DAP pour chaque ligne
                                                                                $sumMontant = DB::table('elementfebs')
                                                                                    ->join('febs', 'elementfebs.febid', '=', 'febs.id')
                                                                                    ->where('febid', $febsActif->idfeb)
                                                                                    ->sum('montant');
                                                            
                                                                                // Chiffrer l'ID de la notification
                                                                                $cryptedIDoc = Crypt::encrypt($febsActif->idfeb);
                                                            
                                                                                // Générer la ligne du tableau
                                                                                echo '<tr>
                                                                                          <td>' . $numooOrder . '</td>
                                                                                          <td align="right">
                                                                                              <a href="' . route('key.viewFeb', $cryptedIDoc) . '">
                                                                                                  <b>' . $febsActif->numerofeb . '/' . $febsActif->projet_annee . ' <i class="fas fa-external-link-alt"></i></b>
                                                                                              </a>
                                                                                          </td>
                                                                                          <td align="right"><b>' . number_format($sumMontant, 0, ',', ' ') . '</b></td>
                                                                                          <td>' . date('d-m-Y', strtotime($febsActif->datefeb)) . '</td>
                                                                                          <td>' . date('d-m-Y', strtotime($febsActif->created_at)) . '</td>
                                                                                          <td>' . date('d-m-Y', strtotime($febsActif->datelimite)) . '</td>
                                                                                          <td>' . ucfirst($febsActif->user_nom) . ' ' . ucfirst($febsActif->user_prenom) . '</td>
                                                                                      </tr>';
                                                                                
                                                                                // Incrémenter le compteur
                                                                                $numooOrder++;
                                                                            }
                                                                        }
                                                                        ?>
                                                                         @else
                                                                              <!-- Message si aucun document n'est trouvé -->
                                                                              <tr>
                                                                                <td colspan="7" style="background-color: rgba(255, 0, 0, 0.1);">
                                                                                    <center>
                                                                                        <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                                                                                    </center>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card mb-1 shadow-none">
                                                        <a href="#collapseTwo" class="text-dark collapsed" data-bs-toggle="collapse"
                                                            aria-expanded="false" aria-controls="collapseTwo">
                                                            <div class="card-header" id="headingTwo">
                                                                <h6 class="m-0">
                                                                

                                                                    <b>DAP  ({{ $totalActifsDap  }})</b> 
                                                                    <small>Résultat{{ $totalActifsDap  > 1 ? 's' : '' }}</small>
                                                                    <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                                    <br>
                                                                    Demande d'Autorisation de Paiement
                                                                </h6>
                                                            </div>
                                                        </a>
                                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                                            data-bs-parent="#accordion">
                                                            <div class="card-body">
                                                               
                                                                    <!-- Début du tableau -->
                                                                    <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="sort border-top"><b>#</b></th>
                                                                                <th class="sort border-top" data-sort="febnum">
                                                                                    <b><center>N<sup>o</sup> DOC</center></b>
                                                                                </th>
                                                                                <th class="sort border-top" data-sort="montant"><b><center>Montant</center></b></th>
                                                                                <th class="sort border-top" data-sort="Date Doc"><b>Date</b></th>
                                                                                <th class="sort border-top" data-sort="Créé le"><b>Créé le</b></th>
                                                                                <th class="sort border-top" data-sort="Date limite"><b>Date Limite</b></th>
                                                                                <th class="sort border-top" data-sort="Créé par"><b>Créé par</b></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="dapnotification">
                                                                            @if ($dapsActifs->isNotEmpty())
                                                                            <?php
                                                                            // Regrouper les éléments par projet
                                                                            $groupedByProject = $dapsActifs->groupBy('projet_title');
                                                                            $numooOrder = 1; // Compteur pour le numéro d'ordre

                                                                            foreach ($groupedByProject as $projectTitle => $dapsAct) {
                                                                                // Afficher le titre du projet
                                                                                echo '<tr style="background-color:#addfad">
                                                                                        <td colspan="7"><b>' . ucfirst($projectTitle) . '</b></td>
                                                                                    </tr>';

                                                                                // Afficher les notifications pour chaque projet
                                                                                foreach ($dapsAct as $dap) {
                                                                                    // Calculer le montant total des DAP pour chaque ligne
                                                                                   

                                                                                     // Récupérer les IDs des FEB associés au DAP
                                                                                        $febIds = DB::table('elementdaps')
                                                                                            ->where('dapid', $dap->iddaps)
                                                                                            ->pluck('referencefeb');

                                                                                        // Calculer le montant total en fonction des FEB associés
                                                                                        $totalDapAmount = DB::table('elementfebs')
                                                                                            ->whereIn('febid', $febIds)
                                                                                            ->sum('montant');



                                                                                    $cryptedIDoc = Crypt::encrypt($dap->iddaps);

                                                                                    // Générer la ligne du tableau
                                                                                    echo '<tr>
                                                                                            <td>' . $numooOrder . '</td>
                                                                                            <td align="right">
                                                                                                <a href="' . route('viewdap', $cryptedIDoc) . '">
                                                                                                    <b>' . $dap->numerodp . '/' . $dap->projet_annee . ' <i class="fas fa-external-link-alt"></i></b>
                                                                                                </a>
                                                                                            </td>
                                                                                            <td align="right"><b>' . number_format($totalDapAmount, 0, ',', ' ') . '</b></td>
                                                                                            <td>' . (strtotime($dap->dateautorisation) !== false && $dap->dateautorisation != '' ? date('d-m-Y', strtotime($dap->dateautorisation)) : '-') . '</td>
                                                                                            <td>' . (strtotime($dap->created_at) !== false && $dap->created_at != '' ? date('d-m-Y', strtotime($dap->created_at)) : '-') . '</td>
                                                                                            <td>' . (strtotime($dap->updated_at) !== false && $dap->updated_at != '' ? date('d-m-Y', strtotime($dap->updated_at)) : '-') . '</td>
                                                                                            <td>' . ucfirst($dap->user_nom) . ' ' . ucfirst($dap->user_prenom) . '</td>
                                                                                        </tr>';

                                                                                        
                                                                                    
                                                                                    // Incrémenter le compteur
                                                                                    $numooOrder++;
                                                                                }
                                                                            }
                                                                            ?>
                                                                             @else
                                                                              <!-- Message si aucun document n'est trouvé -->
                                                                              <tr>
                                                                                <td colspan="7" style="background-color: rgba(255, 0, 0, 0.1);">
                                                                                    <center>
                                                                                        <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                                                                                    </center>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                        </tbody>
                                                                    </table>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card mb-0 shadow-none">
                                                        <a href="#collapseThree" class="text-dark collapsed" data-bs-toggle="collapse"
                                                            aria-expanded="false" aria-controls="collapseThree">
                                                            <div class="card-header" id="headingThree">
                                                                <h6 class="m-0">
                                                                

                                                                    <b>DJA  ({{ $totalActifsDja  }})</b> 
                                                                    <small>Résultat{{ $totalActifsDja  > 1 ? 's' : '' }}</small>

                                                                    <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                                    <br>
                                                                    Demande et Justification d'Avance
                                                                </h6>
                                                            </div>
                                                        </a>
                                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                                            data-bs-parent="#accordion">
                                                            <div class="card-body">
                                                             
                                                                    <!-- Début du tableau -->
                                                                    <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="sort border-top"><b>#</b></th>
                                                                                <th class="sort border-top" data-sort="febnum">
                                                                                    <b>
                                                                                        <center>N<sup>o</sup> DOC</center>
                                                                                    </b>
                                                                                </th>
                                                                                <th class="sort border-top" data-sort="montant"><b>
                                                                                        <center>Avance</center>
                                                                                    </b></th>
                                                                                <th class="sort border-top" data-sort="Justificatif"><b>
                                                                                        <center>Justifiéé</center>
                                                                                    </b></th>
                                                                                <th class="sort border-top" data-sort="Date Doc"><b>Durée</b></th>
                                                                                <th class="sort border-top" data-sort="Créé le"><b>Créé le</b>
                                                                                </th>
                                                                                <th class="sort border-top" data-sort="Date limite"><b>Date
                                                                                        Limite</b></th>
                                                                                <th class="sort border-top" data-sort="Créé par"><b>Créé par</b>
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="dapnotification">
                                                                            @if ($djasActifs->isNotEmpty())
                                                                                @php
                                                                                    // Regrouper les éléments par projet
                                                                                    $groupedByProject = $djasActifs->groupBy('projet_title');
                                                                                    $numooOrder = 1; // Compteur pour le numéro d'ordre
                                                                                @endphp
                                                                        
                                                                                @foreach ($groupedByProject as $projectTitle => $djasAct)
                                                                                    <!-- Afficher le titre du projet -->
                                                                                    <tr style="background-color: #addfad">
                                                                                        <td colspan="8"><b>{{ ucfirst($projectTitle) }}</b></td>
                                                                                    </tr>
                                                                        
                                                                                    <!-- Afficher les détails pour chaque document dans le projet -->
                                                                                    @foreach ($djasAct as $dja)
                                                                                        @php
                                                                                            // Calculer le montant total des DAP pour chaque ligne
                                                                                            $totalDjaAmount = $dja->montant_avance_un ?? 0;
                                                                        
                                                                                            // Chiffrement de l'ID du document
                                                                                            $cryptedIDoc = Crypt::encrypt($dja->iddja);
                                                                        
                                                                                            // Gestion de l'état "justifie"
                                                                                           
                                                                                        @endphp
                                                                        
                                                                                        <tr>
                                                                                            <td>{{ $numooOrder }}</td>
                                                                                            <td align="right">
                                                                                                <a href="{{ route('voirDja', $dja->iddja) }}">
                                                                                                    <b>{{ $dja->numerodjas }}/{{ $dja->projet_annee }} <i class="fas fa-external-link-alt"></i></b>
                                                                                                </a>
                                                                                            </td>
                                                                                            <td align="right"><b>{{ number_format($totalDjaAmount, 0, ',', ' ') }}</b></td>
                                                                                            <td align="center">
                                                                                                @if ( $justifieStatus = $dja->justifie == 1 )

                                                                                                <input type="checkbox" class="form-check-input" checked disabled>

                                                                                                @else
                                                                                                <input type="checkbox" disabled>   
                                                                                                @endif
                                                                                                
                                                                                               </td> <!-- Affichage de la case à cocher pour "justifie" -->
                                                                                            <td>{{ $dja->duree_avance ?? '-' }} Jours</td>
                                                                                            <td>{{ date('d-m-Y', strtotime($dja->created_at ?? '')) }}</td>
                                                                                            <td>{{ date('d-m-Y', strtotime($dja->updated_at ?? '')) }}</td>
                                                                                            <td>
                                                                                                {{ ucfirst($dja->user_nom ?? '') }}
                                                                                                {{ ucfirst($dja->user_prenom ?? '') }}
                                                                                            </td>
                                                                                        </tr>
                                                                        
                                                                                        @php
                                                                                            // Incrémenter le compteur
                                                                                            $numooOrder++;
                                                                                        @endphp
                                                                                    @endforeach
                                                                                @endforeach
                                                                            @else
                                                                                <!-- Message si aucun document n'est trouvé -->
                                                                                <tr>
                                                                                    <td colspan="8" style="background-color: rgba(255, 0, 0, 0.1);">
                                                                                        <center>
                                                                                            <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                                                                                        </center>
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        </tbody>
                                                                    </table>
                                                                



                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="card mb-0 shadow-none">
                                                        <a href="#collapseFour" class="text-dark collapsed" data-bs-toggle="collapse"
                                                            aria-expanded="false" aria-controls="collapseFour">
                                                            <div class="card-header" id="headingThree">
                                                                <h6 class="m-0">
                                                                
                                                                <b>BPC ({{ $totalActifsBpc }})</b> 
                                                                <small>Résultat{{ $totalActifsBpc > 1 ? 's' : '' }}</small>
        
        
                                                                    <i class="mdi mdi-minus float-end accor-plus-icon"></i> <br>
                                                                    Bon de Petite Caisse
                                                                </h6>
                                                            </div>
                                                        </a>
                                                        <div id="collapseFour" class="collapse" aria-labelledby="headingThree"
                                                            data-bs-parent="#accordion">
                                                            <div class="card-body">
                                                                <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="sort border-top"><b>#</b></th>
                                                                            <th class="sort border-top" data-sort="febnum">
                                                                                <b>
                                                                                    <center>N<sup>o</sup> DOC</center>
                                                                                </b>
                                                                            </th>
                                                                            <th class="sort border-top" data-sort="montant">
                                                                                <b>
                                                                                    <center>Montant</center>
                                                                                </b>
                                                                            </th>
                                                                            <th class="sort border-top" data-sort="Date Doc"><b>Date</b></th>
                                                                            <th class="sort border-top" data-sort="Titre"><b>Titre</b></th>
                                                                            <th class="sort border-top" data-sort="Créé le"><b>Créé le</b></th>
                                                                            <th class="sort border-top" data-sort="Créé par"><b>Créé par</b></th>
                                                                        </tr>
                                                                    </thead>
        
        
                                                                    <tbody id="dapnotification">
                                                                    @if ($bpcsActifs->isNotEmpty())
                                                                    @php
                                                                        // Regrouper les éléments par projet
                                                                        $groupedByProject = $bpcsActifs->groupBy('projet_title');
                                                                        $numooOrder = 1; // Compteur pour le numéro d'ordre
                                                                    @endphp
                                                                    
                                                                    @foreach ($groupedByProject as $projectTitle => $bpcsActifGroup)
                                                                        <!-- Afficher le titre du projet -->
                                                                        <tr style="background-color: #addfad">
                                                                            <td colspan="8"><b>{{ ucfirst($projectTitle) }}</b></td>
                                                                        </tr>
                                                                    
                                                                        <!-- Afficher les détails pour chaque document dans le projet -->
                                                                        @foreach ($bpcsActifGroup as $bpcsActifs)
                                                                            @php
                                                                                // Chiffrement de l'ID du document
                                                                                $cryptedIDocAcDja = Crypt::encrypt($bpcsActifs->idbpc);
                                                                            @endphp
                                                                    
                                                                            <tr>
                                                                                <td>{{ $numooOrder }}</td>
                                                                                <td>
                                                                                    <a href="{{ route('viewbpc', $cryptedIDocAcDja) }}">
                                                                                        <b>{{ $bpcsActifs->numero }}/{{ $bpcsActifs->projet_annee }} <i class="fas fa-external-link-alt"></i></b>
                                                                                    </a>
                                                                                </td>
                                                                                <td align="right"><b>{{ number_format($$bpcsActifs->total_montant ?? 0, 0, ',', ' ') }}</b></td>
                                                                                <td>{{  date('d-m-Y', strtotime($bpcsActif->date)) }} </td>
                                                                                <td>{{ $bpcsActifs->titre }} </td>
                                                                                <td>{{ date('d-m-Y', strtotime($bpcsActifs->created_at)) }}</td>
                                                                                <td>{{ date('d-m-Y', strtotime($bpcsActifs->updated_at)) }}</td>
                                                                                <td>
                                                                                    {{ ucfirst($bpcsActifs->user_nom ?? '') }}
                                                                                    {{ ucfirst($bpcsActifs->user_prenom ?? '') }}
                                                                                </td>
                                                                            </tr>
                                                                    
                                                                            @php
                                                                                // Incrémenter le compteur
                                                                                $numooOrder++;
                                                                            @endphp
                                                                        @endforeach
                                                                    @endforeach

                                                                    @else
                                                                    <!-- Message si aucun document n'est trouvé -->
                                                                    <tr>
                                                                        <td colspan="8" style="background-color: rgba(255, 0, 0, 0.1);">
                                                                            <center>
                                                                                <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                                                                            </center>
                                                                        </td>
                                                                    </tr>
                                                                @endif
        
                                                                    </tbody>
        
        
        
        
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card mb-0 shadow-none">
                                                        <a href="#collapseFive" class="text-dark collapsed" data-bs-toggle="collapse"
                                                            aria-expanded="false" aria-controls="collapseFive">
                                                            <div class="card-header" id="headingFive">
                                                                <h6 class="m-0">
                                                                <b>FAC ({{ $totalActifsFac }})</b> 
                                                                <small>Résultat{{ $totalActifsFac > 1 ? 's' : '' }}</small>
                                                                <i class="mdi mdi-minus float-end accor-plus-icon"></i> <br>
                                                                    Fiche d'Alimentation Caisse
                                                                </h6>
                                                            </div>
                                                        </a>
                                                        <div id="collapseFive" class="collapse" aria-labelledby="headingThree"
                                                            data-bs-parent="#accordion">
                                                            <div class="card-body">
                                                               <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="sort border-top"><b>#</b></th>
                                                                            <th class="sort border-top" data-sort="febnum">
                                                                                <b>
                                                                                    <center>N<sup>o</sup> DOC</center>
                                                                                </b>
                                                                            </th>
                                                                            <th class="sort border-top" data-sort="montant"><b>
                                                                                    <center>Montant</center>
                                                                                </b></th>
                                                                            <th class="sort border-top" data-sort="Date Doc"><b>Date</b></th>
                                                                            <th class="sort border-top" data-sort="Titre"><b>Titre</b></th>
                                                                            <th class="sort border-top" data-sort="Créé le"><b>Créé le</b>
                                                                            </th>
                                                                            <th class="sort border-top" data-sort="Créé par"><b>Créé par</b>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if ($facsActifs->isNotEmpty())
                                                                            @php
                                                                                // Regrouper les éléments par projet
                                                                                $groupedByProject = $facsActifs->groupBy('projet_title');
                                                                                $numooOrder = 1; // Initialisation du compteur
                                                                            @endphp

                                                                            @foreach ($groupedByProject as $projectTitle => $facsAct)
                                                                                <!-- Afficher le titre du projet -->
                                                                                <tr style="background-color:#addfad">
                                                                                    <td colspan="7"><b>{{ ucfirst($projectTitle) }}</b></td>
                                                                                </tr>

                                                                                <!-- Afficher les notifications pour chaque projet -->
                                                                                @foreach ($facsAct as $facsActif)
                                                                                    @php
                                                                                        // Chiffrement de l'ID du document
                                                                                        $cryptedIDocFac = Crypt::encrypt($facsActif->idfac);
                                                                                    @endphp

                                                                                    <tr>
                                                                                        <td>{{ $numooOrder }}</td>
                                                                                        <td align="right">
                                                                                            <a href="{{ route('viewfebpc', $cryptedIDocFac) }}">
                                                                                                <b>{{ $facsActif->numero }}/{{ $facsActif->projet_annee }} <i class="fas fa-external-link-alt"></i></b>
                                                                                            </a>
                                                                                        </td>
                                                                                        <td align="right"><b>{{ number_format($facsActif->montant, 0, ',', ' ') }}</b></td>
                                                                                        <td>{{ date('d-m-Y', strtotime($facsActif->date_dossier)) }}</td>
                                                                                        <td>{{ date('d-m-Y', strtotime($facsActif->date_limite)) }}</td>
                                                                                        <td>{{ date('d-m-Y', strtotime($facsActif->created_at)) }}</td>
                                                                                        <td>{{ ucfirst($feb->user_nom) }} {{ ucfirst($facsActif->user_prenom) }}</td>
                                                                                    </tr>
                                                                                    @php
                                                                                        $numooOrder++; // Incrémenter le compteur
                                                                                    @endphp
                                                                                @endforeach
                                                                            @endforeach
                                                                        @else
                                                                            <!-- Message si aucun document n'est trouvé -->
                                                                            <tr>
                                                                                <td colspan="7" style="background-color: rgba(255, 0, 0, 0.1);">
                                                                                    <center>
                                                                                        <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                                                                                    </center>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card mb-0 shadow-none">
                                                        <a href="#collapseSix" class="text-dark collapsed" data-bs-toggle="collapse"
                                                            aria-expanded="false" aria-controls="collapseSix">
                                                            <div class="card-header" id="headingSix">
                                                                <h6 class="m-0">
                                                                <b>DAC ({{ $totalActifsDac }})</b> 
                                                                <small>Résultat{{ $totalActifsDac > 1 ? 's' : '' }}</small>
                                                                
                                                                    <i class="mdi mdi-minus float-end accor-plus-icon"></i> <br>
                                                                    Demande d'Autorisation d'Alimentation de la Caisse
                                                                </h6>
                                                            </div>
                                                        </a>
                                                        <div id="collapseSix" class="collapse" aria-labelledby="headingSix"
                                                            data-bs-parent="#accordion">
                                                            <div class="card-body">
                                                                <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="sort border-top"><b>#</b></th>
                                                                            <th class="sort border-top" data-sort="febnum">
                                                                                <b>
                                                                                    <center>N<sup>o</sup> DOC</center>
                                                                                </b>
                                                                            </th>
                                                                            <th class="sort border-top" data-sort="montant"><b>
                                                                                    <center>Montant</center>
                                                                                </b></th>
                                                                            <th class="sort border-top" data-sort="Date Doc"><b>Date</b></th>
                                                                            <th class="sort border-top" data-sort="Créé le"><b>Créé le</b>
                                                                            </th>
                                                                            <th class="sort border-top" data-sort="Créé par"><b>Créé par</b>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="dacnotification">
                                                                        @if ($dacActifs->isNotEmpty())
                                                                            @php
                                                                                // Regrouper les éléments par projet
                                                                                $groupedByProject = $dacActifs->groupBy('projet_title');
                                                                                $numooOrder = 1; // Initialisation du compteur
                                                                            @endphp
                                                                    
                                                                            @foreach ($groupedByProject as $projectTitle => $dacs)
                                                                                <!-- Afficher le titre du projet -->
                                                                                <tr style="background-color:#addfad">
                                                                                    <td colspan="6"><b>{{ ucfirst($projectTitle) }}</b></td>
                                                                                </tr>
                                                                    
                                                                                <!-- Afficher les notifications pour chaque projet -->
                                                                                @foreach ($dacs as $dacActif)
                                                                                    @php
                                                                                        // Chiffrement de l'ID du document
                                                                                        $cryptedIDocDac = Crypt::encrypt($dacActif->idddaps);
                                                                                    @endphp
                                                                    
                                                                                    <tr>
                                                                                        <td>{{ $numooOrder }}</td>
                                                                                        <td align="right">
                                                                                            <a href="{{ route('viewdappc', $cryptedIDocDac) }}">
                                                                                                <b>{{ $dacActif->numerodap }}/{{ $dacActif->projet_annee }} <i class="fas fa-external-link-alt"></i></b>
                                                                                            </a>
                                                                                        </td>
                                                                                        <td align="right">{{ number_format($dacActif->montant ?? 0, 0, ',', ' ') }}</td>
                                                                                        <td>{{ date('d-m-Y', strtotime($dacActif->demande_etablie ?? '')) }}</td>
                                                                                        <td>{{ date('d-m-Y', strtotime($dacActif->created_at ?? '')) }}</td>
                                                                                        <td>
                                                                                            {{ ucfirst($dacActif->user_nom ?? '') }} 
                                                                                            {{ ucfirst($dacActif->user_prenom ?? '') }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    @php
                                                                                        $numooOrder++; // Incrémenter le compteur
                                                                                    @endphp
                                                                                @endforeach
                                                                            @endforeach
                                                                        @else
                                                                            <!-- Message si aucun document n'est trouvé -->
                                                                            <tr>
                                                                                <td colspan="6" style="background-color: rgba(255, 0, 0, 0.1);">
                                                                                    <center>
                                                                                        <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                                                                                    </center>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    
                                                    </div>

                                                    <div class="card mb-0 shadow-none">
                                                        <a href="#collapseSeven" class="text-dark collapsed" data-bs-toggle="collapse"
                                                            aria-expanded="false" aria-controls="collapseSeven">
                                                            <div class="card-header" id="headingSeven">
                                                                <h6 class="m-0">

                                                                    <b>RAC ({{ $totalActifsCaisse }})</b> 
                                                                    <small>Résultat{{ $totalActifsCaisse > 1 ? 's' : '' }}</small>


                                                                    <i class="mdi mdi-minus float-end accor-plus-icon"></i> <br>
                                                                    Rapport de la Pétite  Caisse
                                                                </h6>
                                                            </div>
                                                        </a>
                                                        <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven"
                                                            data-bs-parent="#accordion">
                                                            <div class="card-body">
                                                                <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="sort border-top"><b>#</b></th>
                                                                            <th class="sort border-top" data-sort="febnum">
                                                                                <b>
                                                                                    <center>N<sup>o</sup> DOC</center>
                                                                                </b>
                                                                            </th>
                                                                            <th class="sort border-top" data-sort="montant"><b>
                                                                                    <center>Dernier Solde</center>
                                                                                </b></th>
                                                                            <th class="sort border-top" data-sort="Date Doc"><b>Date</b></th>

                                                                            <th class="sort border-top" data-sort="Créé le"><b>Créé le</b>
                                                                            </th>

                                                                            <th class="sort border-top" data-sort="Créé par"><b>Créé par</b>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="racnotification">
                                                                        @if ($caissesActives->isNotEmpty())
                                                                            @php
                                                                                // Regrouper les éléments par projet
                                                                                $groupedByProject = $caissesActives->groupBy('projet_title');
                                                                                $numooOrder = 1; // Initialisation du compteur
                                                                            @endphp
                                                                    
                                                                            @foreach ($groupedByProject as $projectTitle => $racs)
                                                                                <!-- Afficher le titre du projet -->
                                                                                <tr style="background-color:#addfad">
                                                                                    <td colspan="6"><b>{{ ucfirst($projectTitle) }}</b></td>
                                                                                </tr>
                                                                    
                                                                                <!-- Afficher les notifications pour chaque projet -->
                                                                                @foreach ($racs as $rac)
                                                                                    @php
                                                                                        // Chiffrement de l'ID du document
                                                                                        $cryptedIDoc = Crypt::encrypt($rac->idrac);
                                                                                    @endphp
                                                                    
                                                                                    <tr>
                                                                                        <td>{{ $numooOrder }}</td>
                                                                                        <td align="right">
                                                                                            <a href="{{ route('Rapport.cloture.caisse') }}">
                                                                                                <b>{{ $rac->numero_groupe }} <i class="fas fa-external-link-alt"></i></b>
                                                                                            </a>
                                                                                        </td>
                                                                                        <td align="right">{{ number_format($rac->dernier_solde ?? 0, 0, ',', ' ') }}</td>
                                                                                        <td>{{ isset($rac->created_at) ? date('d-m-Y', strtotime($rac->created_at)) : '' }}</td>
                                                                                        <td>{{ isset($rac->updated_at) ? date('d-m-Y', strtotime($rac->updated_at)) : '' }}</td>
                                                                                        <td>
                                                                                            {{ ucfirst($rac->user_nom ?? '') }} 
                                                                                            {{ ucfirst($rac->user_prenom ?? '') }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    @php
                                                                                        $numooOrder++; // Incrémenter le compteur
                                                                                    @endphp
                                                                                @endforeach
                                                                            @endforeach
                                                                        @else
                                                                            <!-- Message si aucun document n'est trouvé -->
                                                                            <tr>
                                                                                <td colspan="6" style="background-color: rgba(255, 0, 0, 0.1);">
                                                                                    <center>
                                                                                        <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                                                                                    </center>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                        
                                                </div>
                                            </div>
                                        </div>
                                    
                                </div>
                                <div class="tab-pane" id="profile1" role="tabpanel">
                                   <!-- Nofification de l'annee encours -->
                                   <div id="tableExample2">
                                    <div class="table-responsive">
                                        <!--
                                        <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                                <input type="text" name="recherche" id="recherche" class="form-control" placeholder="Recherche par numéro(F.E.B, D.A.P), date , Initiateur">
                                            </div> 
                                        -->

                                        <h5><i class="fa fa-info-circle">  Documents à signer des exercices des projets archiver  ({{$documentNombreInactif}}) </i></h5>

                                        <div id="accordion" class="custom-accordion">

                                            <div class="card mb-1 ">
                                                <a href="#collapseOneOld" class="text-dark" data-bs-toggle="collapse" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                    <div class="card-header" id="headingOne">
                                                        <h6 class="m-0">
                                                            
                                                            <b>FEB  ({{ $totalInactifsFEb  }})</b> 
                                                            <small>Résultat{{ $totalInactifsFEb > 1 ? 's' : '' }}</small>
                                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                            <br>
                                                            Fiche d'Expression des Besoins
                                                        </h6>
                                                    </div>
                                                </a>

                                                <div id="collapseOneOld" class="collapse" aria-labelledby="headingOne"
                                                    data-bs-parent="#accordion">
                                                    <div class="card-body">

                                                   
                                                        <!-- Début du tableau -->
                                                        <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="sort border-top"><b>#</b></th>
                                                                    <th class="sort border-top" data-sort="febnum">
                                                                        <b><center>N<sup>o</sup> DOC</center></b>
                                                                    </th>
                                                                    <th class="sort border-top" data-sort="montant"><b><center>Montant</center></b></th>
                                                                    <th class="sort border-top" data-sort="Date Doc"><b>Date FEB</b></th>
                                                                    <th class="sort border-top" data-sort="Créé le"><b>Créé le</b></th>
                                                                    <th class="sort border-top" data-sort="Date limite"><b>Date Limite</b></th>
                                                                    <th class="sort border-top" data-sort="Créé par"><b>Créé par</b></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($febsActifs->isNotEmpty())
                                                                <?php
                                                                // Initialisation des variables
                                                                $groupedByProjectInactif = $febsInactifs->groupBy('projet_title');
                                                                $numooOrder = 1;
                                                    
                                                                foreach ($groupedByProjectInactif as $projectTitleFebInactif => $febsInact) {
                                                                    // Afficher le titre du projet
                                                                    echo '<tr style="background-color:#addfad">
                                                                              <td colspan="7"><b>' . ucfirst($projectTitleFeb) . '</b></td>
                                                                          </tr>';
                                                    
                                                                    // Afficher les notifications pour chaque projet
                                                                    foreach ($febsInact as $febsInactif) {
                                                                        // Calculer le montant total des DAP pour chaque ligne
                                                                        $sumMontantInactif = DB::table('elementfebs')
                                                                            ->join('febs', 'elementfebs.febid', '=', 'febs.id')
                                                                            ->where('febid', $febsInactif->idfeb)
                                                                            ->sum('montant');
                                                    
                                                                        // Chiffrer l'ID de la notification
                                                                        $cryptedIDocInactif = Crypt::encrypt($febsInactif->idfeb);
                                                    
                                                                        // Générer la ligne du tableau
                                                                        echo '<tr>
                                                                                  <td>' . $numooOrder . '</td>
                                                                                  <td align="right">
                                                                                      <a href="' . route('key.viewFeb', $cryptedIDocInactif) . '">
                                                                                          <b>' . $febsInactif->numerofeb . '/' . $febsInactif->projet_annee . ' <i class="fas fa-external-link-alt"></i></b>
                                                                                      </a>
                                                                                  </td>
                                                                                  <td align="right"><b>' . number_format($sumMontantInactif, 0, ',', ' ') . '</b></td>
                                                                                  <td>' . date('d-m-Y', strtotime($febsInactif->datefeb)) . '</td>
                                                                                  <td>' . date('d-m-Y', strtotime($febsInactif->created_at)) . '</td>
                                                                                  <td>' . date('d-m-Y', strtotime($febsInactif->datelimite)) . '</td>
                                                                                  <td>' . ucfirst($febsInactif->user_nom) . ' ' . ucfirst($febsInactif->user_prenom) . '</td>
                                                                              </tr>';
                                                                        
                                                                        // Incrémenter le compteur
                                                                        $numooOrder++;
                                                                    }
                                                                }
                                                                ?>
                                                                 @else
                                                                 <!-- Message si aucun document n'est trouvé -->
                                                                 <tr>
                                                                     <td colspan="7" style="background-color: rgba(255, 0, 0, 0.1);">
                                                                         <center>
                                                                             <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                                                                         </center>
                                                                     </td>
                                                                 </tr>
                                                             @endif
                                                            </tbody>
                                                        </table>
                                                       
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-1 shadow-none">
                                                <a href="#collapseTwoOld" class="text-dark collapsed" data-bs-toggle="collapse"
                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                    <div class="card-header" id="headingTwo">
                                                        <h6 class="m-0">
                                                        

                                                            <b>DAP  ({{ $totalInactifsDap  }})</b> 
                                                            <small>Résultat{{ $totalInactifsDap  > 1 ? 's' : '' }}</small>
                                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                            <br>
                                                            Demande d'Autorisation de Paiement
                                                        </h6>
                                                    </div>
                                                </a>
                                                <div id="collapseTwoOld" class="collapse" aria-labelledby="headingTwo"
                                                    data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                       
                                                            <!-- Début du tableau -->
                                                            <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="sort border-top"><b>#</b></th>
                                                                        <th class="sort border-top" data-sort="febnum">
                                                                            <b><center>N<sup>o</sup> DOC</center></b>
                                                                        </th>
                                                                        <th class="sort border-top" data-sort="montant"><b><center>Montant</center></b></th>
                                                                        <th class="sort border-top" data-sort="Date Doc"><b>Date</b></th>
                                                                        <th class="sort border-top" data-sort="Créé le"><b>Créé le</b></th>
                                                                        <th class="sort border-top" data-sort="Date limite"><b>Date Limite</b></th>
                                                                        <th class="sort border-top" data-sort="Créé par"><b>Créé par</b></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="dapnotification">
                                                                    @if ($dapsInactifs->isNotEmpty())
                                                                        @php
                                                                        // Regrouper les éléments par projet
                                                                        $groupedByProjectInactif = $dapsInactifs->groupBy('projet_title');
                                                                        $numooOrder = 1; // Compteur pour le numéro d'ordre
                                                                        @endphp
                                                                
                                                                        @foreach ($groupedByProjectInactif as $projectTitleInactif => $dapsInact)
                                                                            <!-- Afficher le titre du projet -->
                                                                            <tr style="background-color: #addfad;">
                                                                                <td colspan="7"><b>{{ ucfirst($projectTitleInactif) }}</b></td>
                                                                            </tr>
                                                                
                                                                            <!-- Afficher les notifications pour chaque projet -->
                                                                            @foreach ($dapsInact as $dapsInactif)
                                                                                @php
                                                                                // Récupérer les IDs des FEB associés au DAP
                                                                                $febIdsInactif = DB::table('elementdaps')
                                                                                    ->where('dapid', $dapsInactif->iddaps)
                                                                                    ->pluck('referencefeb');
                                                                
                                                                                // Calculer le montant total en fonction des FEB associés
                                                                                $totalDapAmountInactif = DB::table('elementfebs')
                                                                                    ->whereIn('febid', $febIdsInactif)
                                                                                    ->sum('montant');
                                                                
                                                                                // Chiffrer l'ID du document
                                                                                $cryptedIDocInactifDac = Crypt::encrypt($dapsInactif->iddaps);
                                                                                @endphp
                                                                
                                                                                <!-- Générer la ligne du tableau -->
                                                                                <tr>
                                                                                    <td>{{ $numooOrder }}</td>
                                                                                    <td align="right">
                                                                                        <a href="{{ route('viewdap', $cryptedIDocInactifDac) }}">
                                                                                            <b>{{ $dapsInactif->numerodp }}/{{ $dapsInactif->projet_annee }} <i class="fas fa-external-link-alt"></i></b>
                                                                                        </a>
                                                                                    </td>
                                                                                    <td align="right"><b>{{ number_format($totalDapAmountInactif, 0, ',', ' ') }}</b></td>
                                                                                    <td>{{ $dapsInactif->dateautorisation ? date('d-m-Y', strtotime($dapsInactif->dateautorisation)) : '-' }}</td>
                                                                                    <td>{{ $dapsInactif->created_at ? date('d-m-Y', strtotime($dapsInactif->created_at)) : '-' }}</td>
                                                                                    <td>{{ $dapsInactif->updated_at ? date('d-m-Y', strtotime($dapsInactif->updated_at)) : '-' }}</td>
                                                                                    <td>{{ ucfirst($dapsInactif->user_nom) }} {{ ucfirst($dapsInactif->user_prenom) }}</td>
                                                                                </tr>
                                                                
                                                                                @php
                                                                                // Incrémenter le compteur
                                                                                $numooOrder++;
                                                                                @endphp
                                                                            @endforeach
                                                                        @endforeach
                                                                    @else
                                                                        <!-- Message si aucun document n'est trouvé -->
                                                                        <tr>
                                                                            <td colspan="7" style="background-color: rgba(255, 0, 0, 0.1); text-align: center;">
                                                                                <h6 style="color: red;"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                       
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-0 shadow-none">
                                                <a href="#collapseThreeOld" class="text-dark collapsed" data-bs-toggle="collapse"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    <div class="card-header" id="headingThree">
                                                        <h6 class="m-0">
                                                        

                                                            <b>DJA  ({{ $totalInactifsDja  }})</b> 
                                                            <small>Résultat{{ $totalInactifsDja  > 1 ? 's' : '' }}</small>

                                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                                            <br>
                                                            Demande et Justification d'Avance
                                                        </h6>
                                                    </div>
                                                </a>
                                                <div id="collapseThreeOld" class="collapse" aria-labelledby="headingThree"
                                                    data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                       
                                                            <!-- Début du tableau -->
                                                            <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="sort border-top"><b>#</b></th>
                                                                        <th class="sort border-top" data-sort="febnum">
                                                                            <b>
                                                                                <center>N<sup>o</sup> DOC</center>
                                                                            </b>
                                                                        </th>
                                                                        <th class="sort border-top" data-sort="montant"><b>
                                                                                <center>Avance</center>
                                                                            </b></th>
                                                                        <th class="sort border-top" data-sort="Justificatif"><b>
                                                                                <center>Justifiéé</center>
                                                                            </b></th>
                                                                        <th class="sort border-top" data-sort="Date Doc"><b>Durée</b></th>
                                                                        <th class="sort border-top" data-sort="Créé le"><b>Créé le</b>
                                                                        </th>
                                                                        <th class="sort border-top" data-sort="Date limite"><b>Date
                                                                                Limite</b></th>
                                                                        <th class="sort border-top" data-sort="Créé par"><b>Créé par</b>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="dapnotification">
                                                                    @if ($djasInactifs->isNotEmpty())
                                                                    @php
                                                                        // Regrouper les éléments par projet
                                                                        $groupedByProject = $djasInactifs->groupBy('projet_title');
                                                                        $numooOrder = 1; // Compteur pour le numéro d'ordre
                                                                    @endphp
                                                                
                                                                    @foreach ($groupedByProject as $projectTitle => $djasInact)
                                                                        <!-- Afficher le titre du projet -->
                                                                        <tr style="background-color: #addfad">
                                                                            <td colspan="8"><b>{{ ucfirst($projectTitle) }}</b></td>
                                                                        </tr>
                                                                
                                                                        <!-- Afficher les détails pour chaque document dans le projet -->
                                                                        @foreach ($djasInact as $djasInactif)
                                                                            @php
                                                                                // Calculer le montant total des DAP pour chaque ligne
                                                                                $totalDjaAmountIn = $djasInactif->montant_avance_un ?? 0;
                                                                
                                                                                // Chiffrement de l'ID du document
                                                                                $cryptedIDocInDja = Crypt::encrypt($djasInactif->iddja);
                                                                
                                                                                // Gestion de l'état "justifie"
                                                                               
                                                                            @endphp
                                                                
                                                                            <tr>
                                                                                <td>{{ $numooOrder }}</td>
                                                                                <td align="right">
                                                                                    <a href="{{ route('voirDja', $djasInactif->iddja) }}">
                                                                                        <b>{{ $djasInactif->numerodjas }}/{{ $djasInactif->projet_annee }} <i class="fas fa-external-link-alt"></i></b>
                                                                                    </a>
                                                                                </td>
                                                                                <td align="right"><b>{{ number_format($totalDjaAmountIn, 0, ',', ' ') }}</b></td>
                                                                                <td align="center">

                                                                                    @if ($justifieStatus = $djasInactif->justifie == 1)
                                                                                    <input type="checkbox" class="form-check-input" checked disabled>
                                                                                    @else
                                                                                    <input type="checkbox" disabled>
                                                                                  
                                                                                    @endif
                                                                                    
                                                                                
                                                                                </td> <!-- Affichage de la case à cocher pour "justifie" -->
                                                                                <td>{{ $djasInactif->duree_avance ?? '-' }} Jours</td>
                                                                                <td>{{ date('d-m-Y', strtotime($dja->created_at ?? '')) }}</td>
                                                                                <td>{{ date('d-m-Y', strtotime($dja->updated_at ?? '')) }}</td>
                                                                               
                                                                                <td>
                                                                                    {{ ucfirst($djasInactif->user_nom ?? '') }}
                                                                                    {{ ucfirst($djasInactif->user_prenom ?? '') }}
                                                                                </td>
                                                                            </tr>
                                                                
                                                                            @php
                                                                                // Incrémenter le compteur
                                                                                $numooOrder++;
                                                                            @endphp
                                                                        @endforeach
                                                                    @endforeach
                                                                    @else
                                                                 <!-- Message si aucun document n'est trouvé -->
                                                                 <tr>
                                                                     <td colspan="6" style="background-color: rgba(255, 0, 0, 0.1);">
                                                                         <center>
                                                                             <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                                                                         </center>
                                                                     </td>
                                                                 </tr>
                                                             @endif
                                                                </tbody>
                                                            </table>
                                                      



                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-0 shadow-none">
                                                <a href="#collapseFourOld" class="text-dark collapsed" data-bs-toggle="collapse"
                                                    aria-expanded="false" aria-controls="collapseFour">
                                                    <div class="card-header" id="headingThree">
                                                        <h6 class="m-0">
                                                        
                                                        <b>BPC ({{ $totalInactifsBpc }})</b> 
                                                        <small>Résultat{{ $totalInactifsBpc > 1 ? 's' : '' }}</small>


                                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i> <br>
                                                            Bon de Petite Caisse
                                                        </h6>
                                                    </div>
                                                </a>
                                                <div id="collapseFourOld" class="collapse" aria-labelledby="headingThree"
                                                    data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="sort border-top"><b>#</b></th>
                                                                    <th class="sort border-top" data-sort="febnum">
                                                                        <b>
                                                                            <center>N<sup>o</sup> DOC</center>
                                                                        </b>
                                                                    </th>
                                                                    <th class="sort border-top" data-sort="montant">
                                                                        <b>
                                                                            <center>Montant</center>
                                                                        </b>
                                                                    </th>
                                                                    <th class="sort border-top" data-sort="Date Doc"><b>Date</b></th>
                                                                   
                                                                    <th class="sort border-top" data-sort="Créé le"><b>Créé le</b></th>
                                                                    <th class="sort border-top" data-sort="Créé par"><b>Créé par</b></th>
                                                                </tr>
                                                            </thead>


                                                            <tbody id="dapnotification">
                                                                @if ($djasInactifs->isNotEmpty())
                                                            @php
                                                                // Regrouper les éléments par projet
                                                                $groupedByProject = $bpcsInactifs->groupBy('projet_title');
                                                                $numooOrder = 1; // Compteur pour le numéro d'ordre
                                                            @endphp
                                                            
                                                            @foreach ($groupedByProject as $projectTitle => $bpcsInactifGroup)
                                                                <!-- Afficher le titre du projet -->
                                                                <tr style="background-color: #addfad">
                                                                    <td colspan="8"><b>{{ ucfirst($projectTitle) }}</b></td>
                                                                </tr>
                                                            
                                                                <!-- Afficher les détails pour chaque document dans le projet -->
                                                                @foreach ($bpcsInactifGroup as $bpcsInactifs)
                                                                    @php
                                                                        // Chiffrement de l'ID du document
                                                                        $cryptedIDocInDja = Crypt::encrypt($bpcsInactifs->idbpc);
                                                                    @endphp
                                                            
                                                                    <tr>
                                                                        <td>{{ $numooOrder }}</td>
                                                                        <td>
                                                                            <a href="{{ route('viewbpc', $cryptedIDocInDja) }}">
                                                                                <b>{{ $bpcsInactifs->numero }}/{{ $bpcsInactifs->projet_annee }} <i class="fas fa-external-link-alt"></i></b>
                                                                            </a>
                                                                        </td>
                                                                        <td align="right"><b>{{ number_format($bpcsInactifs->total_montant ?? 0, 0, ',', ' ') }}</b></td>
                                                                        <td>{{  date('d-m-Y', strtotime($bpcsInactifs->date)) }} </td>
                                                                   
                                                                        <td>{{ date('d-m-Y', strtotime($bpcsInactifs->created_at)) }}</td>
                                                                       
                                                                        <td>
                                                                            {{ ucfirst($bpcsInactifs->user_nom ?? '') }}
                                                                            {{ ucfirst($bpcsInactifs->user_prenom ?? '') }}
                                                                        </td>
                                                                    </tr>
                                                            
                                                                    @php
                                                                        // Incrémenter le compteur
                                                                        $numooOrder++;
                                                                    @endphp
                                                                @endforeach
                                                            @endforeach

                                                            @else
                                                            <!-- Message si aucun document n'est trouvé -->
                                                            <tr>
                                                                <td colspan="6" style="background-color: rgba(255, 0, 0, 0.1);">
                                                                    <center>
                                                                        <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                        @endif

                                                            </tbody>




                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-0 shadow-none">
                                                <a href="#collapseFiveOld" class="text-dark collapsed" data-bs-toggle="collapse"
                                                    aria-expanded="false" aria-controls="collapseFive">
                                                    <div class="card-header" id="headingFive">
                                                        <h6 class="m-0">
                                                        <b>FAC ({{ $totalInactifsFac }})</b> 
                                                        <small>Résultat{{ $totalInactifsFac > 1 ? 's' : '' }}</small>
                                                        <i class="mdi mdi-minus float-end accor-plus-icon"></i> <br>
                                                            Fiche d'Alimentation Caisse
                                                        </h6>
                                                    </div>
                                                </a>
                                                <div id="collapseFiveOld" class="collapse" aria-labelledby="headingThree"
                                                    data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                       <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="sort border-top"><b>#</b></th>
                                                                    <th class="sort border-top" data-sort="febnum">
                                                                        <b>
                                                                            <center>N<sup>o</sup> DOC</center>
                                                                        </b>
                                                                    </th>
                                                                    <th class="sort border-top" data-sort="montant"><b>
                                                                            <center>Montant</center>
                                                                        </b></th>
                                                                    <th class="sort border-top" data-sort="Date Doc"><b>Date</b></th>
                                                                    <th class="sort border-top" data-sort="Titre"><b>Titre</b></th>
                                                                    <th class="sort border-top" data-sort="Créé le"><b>Créé le</b>
                                                                    </th>
                                                                    <th class="sort border-top" data-sort="Créé par"><b>Créé par</b>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($facsInactifs->isNotEmpty())
                                                                    @php
                                                                        // Regrouper les éléments par projet
                                                                        $groupedByProject = $facsInactifs->groupBy('projet_title');
                                                                        $numooOrder = 1; // Initialisation du compteur
                                                                    @endphp

                                                                    @foreach ($groupedByProject as $projectTitle => $facsInact)
                                                                        <!-- Afficher le titre du projet -->
                                                                        <tr style="background-color:#addfad">
                                                                            <td colspan="7"><b>{{ ucfirst($projectTitle) }}</b></td>
                                                                        </tr>

                                                                        <!-- Afficher les notifications pour chaque projet -->
                                                                        @foreach ($facsInact as $facsInactif)
                                                                            @php
                                                                                // Chiffrement de l'ID du document
                                                                                $cryptedIDocFac = Crypt::encrypt($facsInactif->idfac);
                                                                            @endphp

                                                                            <tr>
                                                                                <td>{{ $numooOrder }}</td>
                                                                                <td align="right">
                                                                                    <a href="{{ route('viewfebpc', $cryptedIDocFac) }}">
                                                                                        <b>{{ $facsInactif->numero }}/{{ $facsInactif->projet_annee }} <i class="fas fa-external-link-alt"></i></b>
                                                                                    </a>
                                                                                </td>
                                                                                <td align="right"><b>{{ number_format($facsInactif->montant, 0, ',', ' ') }}</b></td>
                                                                                <td>{{ date('d-m-Y', strtotime($facsInactif->date_dossier)) }}</td>
                                                                                <td>{{ date('d-m-Y', strtotime($facsInactif->date_limite)) }}</td>
                                                                                <td>{{ date('d-m-Y', strtotime($facsInactif->created_at)) }}</td>
                                                                                <td>{{ ucfirst($facsInactif->user_nom) }} {{ ucfirst($facsInactif->user_prenom) }}</td>
                                                                            </tr>
                                                                            @php
                                                                                $numooOrder++; // Incrémenter le compteur
                                                                            @endphp
                                                                        @endforeach
                                                                    @endforeach
                                                                @else
                                                                    <!-- Message si aucun document n'est trouvé -->
                                                                    <tr>
                                                                        <td colspan="7" style="background-color: rgba(255, 0, 0, 0.1);">
                                                                            <center>
                                                                                <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                                                                            </center>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-0 shadow-none">
                                                <a href="#collapseSixOld" class="text-dark collapsed" data-bs-toggle="collapse"
                                                    aria-expanded="false" aria-controls="collapseSix">
                                                    <div class="card-header" id="headingSix">
                                                        <h6 class="m-0">
                                                        <b>DAC ({{ $totalInactifsDac }})</b> 
                                                        <small>Résultat{{ $totalInactifsDac > 1 ? 's' : '' }}</small>
                                                        
                                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i> <br>
                                                            Demande d'Autorisation d'Alimentation de la Caisse
                                                        </h6>
                                                    </div>
                                                </a>
                                                <div id="collapseSixOld" class="collapse" aria-labelledby="headingSix"
                                                    data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="sort border-top"><b>#</b></th>
                                                                    <th class="sort border-top" data-sort="febnum">
                                                                        <b>
                                                                            <center>N<sup>o</sup> DOC</center>
                                                                        </b>
                                                                    </th>
                                                                    <th class="sort border-top" data-sort="montant"><b>
                                                                            <center>Montant</center>
                                                                        </b></th>
                                                                    <th class="sort border-top" data-sort="Date Doc"><b>Date</b></th>
                                                                    <th class="sort border-top" data-sort="Créé le"><b>Créé le</b>
                                                                    </th>
                                                                    <th class="sort border-top" data-sort="Créé par"><b>Créé par</b>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dacnotification">
                                                                @if ($dacInactifs->isNotEmpty())
                                                                    @php
                                                                        // Regrouper les éléments par projet
                                                                        $groupedByProject = $dacInactifs->groupBy('projet_title');
                                                                        $numooOrder = 1; // Initialisation du compteur
                                                                    @endphp
                                                            
                                                                    @foreach ($groupedByProject as $projectTitle => $dacInactif)
                                                                        <!-- Afficher le titre du projet -->
                                                                        <tr style="background-color:#addfad">
                                                                            <td colspan="6"><b>{{ ucfirst($projectTitle) }}</b></td>
                                                                        </tr>
                                                            
                                                                        <!-- Afficher les notifications pour chaque projet -->
                                                                        @foreach ($dacInactif as $dacInact)
                                                                            @php
                                                                                // Chiffrement de l'ID du document
                                                                                $cryptedIDocDac = Crypt::encrypt($dacInact->idddaps);
                                                                            @endphp
                                                            
                                                                            <tr>
                                                                                <td>{{ $numooOrder }}</td>
                                                                                <td align="right">
                                                                                    <a href="{{ route('viewdappc', $cryptedIDocDac) }}">
                                                                                        <b>{{ $dacInact->numerodap }}/{{ $dacInact->projet_annee }} <i class="fas fa-external-link-alt"></i></b>
                                                                                    </a>
                                                                                </td>
                                                                                <td align="right">{{ number_format($dacInact->montant ?? 0, 0, ',', ' ') }}</td>
                                                                                <td>{{ date('d-m-Y', strtotime($dacInact->demande_etablie ?? '')) }}</td>
                                                                                <td>{{ date('d-m-Y', strtotime($dacInact->created_at ?? '')) }}</td>
                                                                                <td>
                                                                                    {{ ucfirst($dacInact->user_nom ?? '') }} 
                                                                                    {{ ucfirst($dacInact->user_prenom ?? '') }}
                                                                                </td>
                                                                            </tr>
                                                                            @php
                                                                                $numooOrder++; // Incrémenter le compteur
                                                                            @endphp
                                                                        @endforeach
                                                                    @endforeach
                                                                @else
                                                                    <!-- Message si aucun document n'est trouvé -->
                                                                    <tr>
                                                                        <td colspan="6" style="background-color: rgba(255, 0, 0, 0.1);">
                                                                            <center>
                                                                                <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                                                                            </center>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            
                                            </div>

                                            <div class="card mb-0 shadow-none">
                                                <a href="#collapseSevenOld" class="text-dark collapsed" data-bs-toggle="collapse"
                                                    aria-expanded="false" aria-controls="collapseSeven">
                                                    <div class="card-header" id="headingSeven">
                                                        <h6 class="m-0">

                                                            <b>RAC ({{ $totalInactifsCaisse }})</b> 
                                                            <small>Résultat{{ $totalInactifsCaisse > 1 ? 's' : '' }}</small>


                                                            <i class="mdi mdi-minus float-end accor-plus-icon"></i> <br>
                                                            Rapport de la Pétite  Caisse
                                                        </h6>
                                                    </div>
                                                </a>
                                                <div id="collapseSevenOld" class="collapse" aria-labelledby="headingSeven"
                                                    data-bs-parent="#accordion">
                                                    <div class="card-body">
                                                        <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="sort border-top"><b>#</b></th>
                                                                    <th class="sort border-top" data-sort="febnum">
                                                                        <b>
                                                                            <center>N<sup>o</sup> DOC</center>
                                                                        </b>
                                                                    </th>
                                                                    <th class="sort border-top" data-sort="montant"><b>
                                                                            <center>Dernier Solde</center>
                                                                        </b></th>
                                                                    <th class="sort border-top" data-sort="Date Doc"><b>Date</b></th>

                                                                    <th class="sort border-top" data-sort="Créé le"><b>Créé le</b>
                                                                    </th>

                                                                    <th class="sort border-top" data-sort="Créé par"><b>Créé par</b>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="racnotification">
                                                                @if ($caissesInactives->isNotEmpty())
                                                                    @php
                                                                        // Regrouper les éléments par projet
                                                                        $groupedByProject = $caissesInactives->groupBy('projet_title');
                                                                        $numooOrder = 1; // Initialisation du compteur
                                                                    @endphp
                                                            
                                                                    @foreach ($groupedByProject as $projectTitle => $caissesInactive)
                                                                        <!-- Afficher le titre du projet -->
                                                                        <tr style="background-color:#addfad">
                                                                            <td colspan="6"><b>{{ ucfirst($projectTitle) }}</b></td>
                                                                        </tr>
                                                            
                                                                        <!-- Afficher les notifications pour chaque projet -->
                                                                        @foreach ($caissesInactive as $caissesInact)
                                                                            @php
                                                                                // Chiffrement de l'ID du document
                                                                                $cryptedIDoc = Crypt::encrypt($caissesInact->idrac);
                                                                            @endphp
                                                            
                                                                            <tr>
                                                                                <td>{{ $numooOrder }}</td>
                                                                                <td align="right">
                                                                                    <a href="{{ route('Rapport.cloture.caisse') }}">
                                                                                        <b>{{ $caissesInact->numero_groupe }} <i class="fas fa-external-link-alt"></i></b>
                                                                                    </a>
                                                                                </td>
                                                                                <td align="right">{{ number_format($rac->dernier_solde ?? 0, 0, ',', ' ') }}</td>
                                                                                <td>{{ isset($caissesInact->created_at) ? date('d-m-Y', strtotime($caissesInact->created_at)) : '' }}</td>
                                                                                <td>{{ isset($caissesInact->updated_at) ? date('d-m-Y', strtotime($caissesInact->updated_at)) : '' }}</td>
                                                                                <td>
                                                                                    {{ ucfirst($caissesInact->user_nom ?? '') }} 
                                                                                    {{ ucfirst($caissesInact->user_prenom ?? '') }}
                                                                                </td>
                                                                            </tr>
                                                                            @php
                                                                                $numooOrder++; // Incrémenter le compteur
                                                                            @endphp
                                                                        @endforeach
                                                                    @endforeach
                                                                @else
                                                                    <!-- Message si aucun document n'est trouvé -->
                                                                    <tr>
                                                                        <td colspan="6" style="background-color: rgba(255, 0, 0, 0.1);">
                                                                            <center>
                                                                                <h6 style="color:red"><i class="fa fa-info-circle"></i> Aucun document trouvé</h6>
                                                                            </center>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                
                                        </div>
                                    </div>
                                </div>
                                </div>
                              <!--  <div class="tab-pane" id="messages1" role="tabpanel">
                                    <p class="mb-0">
                                        Etsy mixtape wayfarers, ethical wes anderson tofu before they
                                        sold out mcsweeney's organic lomo retro fanny pack lo-fi
                                        farm-to-table readymade. Messenger bag gentrify pitchfork
                                        tattooed craft beer, iphone skateboard locavore carles etsy
                                        salvia banksy hoodie helvetica. DIY synth PBR banksy irony.
                                        Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh
                                        mi whatever gluten-free carles.
                                    </p>
                                </div>
                                <div class="tab-pane" id="settings1" role="tabpanel">
                                    <p class="mb-0">
                                        Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                        art party before they sold out master cleanse gluten-free squid
                                        scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                        art party locavore wolf cliche high life echo park Austin. Cred
                                        vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                        farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral,
                                        mustache readymade keffiyeh craft.
                                    </p>
                                </div>  -->
                            </div>

                        </div>
                    </div>
              

        





            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
