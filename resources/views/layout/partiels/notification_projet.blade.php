@php

$avatar = Auth::user()->avatar;

$personnelData = DB::table('personnels')
    ->where('id', Auth::user()->personnelid)
    ->first();

$febNombre = DB::table('febs')
    ->where(function ($query) {
        $query
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('acce', Auth::id())
                    ->where('acce_signe', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('comptable', Auth::id())
                    ->where('comptable_signe', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('chefcomposante', Auth::id())
                    ->where('chef_signe', 0);
            });
    })
    ->select('febs.id')
    ->get()
    ->count();

   $dapNombre = DB::table('daps')
    ->selectRaw('COUNT(*) as count')
    ->where(function ($query) {
        $query
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('demandeetablie', Auth::id())
                    ->where('demandeetablie_signe', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('verifierpar', Auth::id())
                    ->where('verifierpar_signe', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('approuverpar', Auth::id())
                    ->where('approuverpar_signe', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('responsable', Auth::id())
                    ->where('responsable_signe', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('secretaire', Auth::id())
                    ->where('secretaure_general_signe', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('chefprogramme', Auth::id())
                    ->where('chefprogramme_signe', 0);
            });
    })
    ->first();

 $dapNombre = $dapNombre->count;
    $djNombre = DB::table('djas')
   
    ->select(
       
        'djas.id as iddjas',
       
    )
    ->where(function ($query) {
        $query
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('djas.fonds_demande_par', Auth::id())
                    ->where('djas.signe_fonds_demande_par', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('djas.avance_approuver_par', Auth::id())
                    ->where('djas.signe_avance_approuver_par', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('djas.avance_approuver_par_deux', Auth::id())
                    ->where('djas.signe_avance_approuver_par_deux', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('djas.avance_approuver_par_trois', Auth::id())
                    ->where('djas.signe_avance_approuver_par_trois', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('djas.fond_debourser_par', Auth::id())
                    ->where('djas.signe_fond_debourser_par', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('djas.fond_recu_par', Auth::id())
                    ->where('djas.signe_fond_recu_par', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('djas.pfond_paye', Auth::id())
                    ->where('djas.signature_pfond_paye', 0);
            })
            ->orWhere(function ($subQuery) {
                $subQuery
                    ->where('djas.fonds_retournes_caisse_par', Auth::id())
                    ->where('djas.signe_reception_pieces_justificatives', 0);
            });
    })
    ->get()
    ->count();

$bpcNombre = DB::table('bonpetitcaisses')
         
          ->select(
              'bonpetitcaisses.id',
          )
          ->where(function ($query) {
              $query->where('bonpetitcaisses.etabli_par', Auth::id())->where('bonpetitcaisses.etabli_par_signature', 0)
                  ->orWhere('bonpetitcaisses.verifie_par', Auth::id())->where('bonpetitcaisses.verifie_par_signature', 0)
                  ->orWhere('bonpetitcaisses.approuve_par', Auth::id())->where('bonpetitcaisses.approuve_par_signature', 0);
          })
          ->get()
          ->count();

    $facNombre = DB::table('febpetitcaisses')
         
          ->select(
              'febpetitcaisses.id',
          )
          ->where(function ($query) {
              $query->where('febpetitcaisses.etabli_par', Auth::id())->where('febpetitcaisses.etabli_par_signature', 0)
                  ->orWhere('febpetitcaisses.verifie_par', Auth::id())->where('febpetitcaisses.verifie_par_signature', 0)
                  ->orWhere('febpetitcaisses.approuve_par', Auth::id())->where('febpetitcaisses.approuve_par_signature', 0);
          })
          
          ->get()
          ->count();
    
    $dacNombre = DB::table('dapbpcs')
         
         ->select(
             'dapbpcs.id',
         )
         ->where(function ($query) {
             $query->where('dapbpcs.demande_etablie', Auth::id())->where('dapbpcs.demande_etablie_signe', 0)
                 ->orWhere('dapbpcs.verifier', Auth::id())->where('dapbpcs.verifier_signe', 0)
                 ->orWhere('dapbpcs.approuver', Auth::id())->where('dapbpcs.approuver_signe', 0)
                 ->orWhere('dapbpcs.autoriser', Auth::id())->where('dapbpcs.autoriser_signe', 0)
                 ->orWhere('dapbpcs.secretaire', Auth::id())->where('dapbpcs.chefprogramme_signe', 0)
                 ->orWhere('dapbpcs.chefprogramme', Auth::id())->where('dapbpcs.secretaire_signe', 0);
         })
         
         ->get()
         ->count();

    $caisseNombre = DB::table('rappotages')
        ->where(function ($query) {
            $query
                ->orWhere(function ($subQuery) {
                    $subQuery->where('verifier_par', Auth::id())->where('verifier_signature', 0);
                })
             
                ->orWhere(function ($subQuery) {
                    $subQuery->where('approver_par', Auth::id())->where('approver_signature', 0);
                });
        })
        ->get()
        ->count();
  

    
    $documentNombre = $dapNombre + $febNombre +$djNombre + $bpcNombre + $facNombre + $dacNombre + $caisseNombre; 


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
        <a href="#" class="waves-effect"  class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">
            <i class="ri-file-edit-fill"></i><span class="badge rounded-pill bg-danger float-end">{{ $documentNombre }}</span>
            <span>Docs à signer</span>
        </a>
    </li>
@endif


@if ($total_signalisation != 0)
    <li class="nav-item">
        <a href="#" class="waves-effect" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-signalisation">
            <i class="ri-chat-voice-line"></i><span class="badge rounded-pill bg-danger float-end">{{ $total_signalisation }}</span>
            <span>Signalisation</span>
        </a>
    </li>
@endif