<?php

use App\Http\Controllers\AchatLocationController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AffectationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppCOntroller;
use App\Http\Controllers\ApreviationController;
use App\Http\Controllers\ArchivageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BailleursDeFondsController;
use App\Http\Controllers\BanqueController;
use App\Http\Controllers\BeneficaireController;
use App\Http\Controllers\BonpetitcaisseController;
use App\Http\Controllers\BpcController;
use App\Http\Controllers\CarburantController;
use App\Http\Controllers\CarnetbordController;
use App\Http\Controllers\CasutilisationController;
use App\Http\Controllers\CatactivityController;
use App\Http\Controllers\CategoriebeneficiaireController;
use App\Http\Controllers\ClasseurController;
use App\Http\Controllers\CommuniqueController;
use App\Http\Controllers\CompteBanqueController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\ComptepetitecaisseController;
use App\Http\Controllers\DapbpcController;
use App\Http\Controllers\DapController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\DeviseController;
use App\Http\Controllers\DjaController;
use App\Http\Controllers\ElementsfeuilletempsController;
use App\Http\Controllers\EntretienProgrammerController;
use App\Http\Controllers\EntretientController;
use App\Http\Controllers\EtiquetteController;
use App\Http\Controllers\ExerciceController;
use App\Http\Controllers\FdtController;
use App\Http\Controllers\FebController;
use App\Http\Controllers\FebpetitcaisseController;
use App\Http\Controllers\FeuilletempsController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\FonctionController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\IdentificationController;
use App\Http\Controllers\IovController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ObservationactiviteController;
use App\Http\Controllers\OptiondescriptionController;
use App\Http\Controllers\OutilsController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\PieceController;
use App\Http\Controllers\PlanoperationnelController;
use App\Http\Controllers\PleincarburantController;
use App\Http\Controllers\PortierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RallongebudgetController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\RapportcummuleController;
use App\Http\Controllers\ResponsabiliteController;
use App\Http\Controllers\SecuriteController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SignalefebController;
use App\Http\Controllers\SqrController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\StatutvehiculeController;
use App\Http\Controllers\TachesController;
use App\Http\Controllers\TauxRealisationController;
use App\Http\Controllers\TypeprojetController;
use App\Http\Controllers\VehiculeController;
use App\Models\Dapbpc;
use App\Models\Febpetitcaisse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () { return view('go'); })->name('go');

Route::get('service/auth', [AuthController::class, 'form'])->name('login');

Route::post('/service/login', [AuthController::class, 'handlelogin'])->name('handlelogin');

Route::get('service/out', function () { return view('auth.out'); })->name('out');
Route::get('service/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('service/oublier', [AuthController::class, 'forgot'])->name('mot_pass_oublie');

Route::post('service/forgot/verification', [AuthController::class, 'handforgot'])->name('verification.email.user');

Route::post('service/verify-code', [AuthController::class, 'verifyCode'])->name('verify.code');

Route::get('service/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');

Route::post('service/update-password', [AuthController::class, 'updatePassword'])->name('update.password');

Route::get('service/nouveaucode', [AuthController::class, 'code'])->name('new.code');

Route::get('service/maintenance', function () {  return view('auth.maintenance'); });


Route::middleware('auth')->group(function () {

    Route::prefix('start')->group(function () {
        Route::get('/', [AppCOntroller::class, 'start'])->name('start');
        Route::get('/page-de-paiement', [AppCOntroller::class, 'start'])->name('page-de-paiement');
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [AppCOntroller::class, 'index'])->name('dashboard');
        Route::get('/findClaseur', [AppCOntroller::class, 'findClaseur'])->name('findClaseur');
        Route::get('/findAnnee', [AppCOntroller::class, 'findAnnee'])->name('findAnnee');
        Route::get('/feb-chart', [AppCOntroller::class, 'febData']);
        
    });
    Route::get('/fetch-feb-details', [AppCOntroller::class, 'fetchFebDetails'])->name('fetch-signalisation-details');

    Route::get('/rh', [AppCOntroller::class, 'rh'])->name('rh');
    Route::get('/archivages', [AppCOntroller::class, 'archivage'])->name('archivages');
    Route::get('/parcAuto', [AppCOntroller::class, 'parcAuto'])->name('parcAuto');

    Route::prefix('rapportcumule')->group(function () {
        Route::get('/', [RapportcummuleController::class, 'index'])->name('rapportcumule');
        Route::get('/getcumule', [RapportcummuleController::class, 'findcumule'])->name('getcumule');
      
    });

    Route::prefix('indentification')->group(function () {
        Route::get('/', [IdentificationController::class, 'index'])->name('info');
        Route::post('storeIdentification', [IdentificationController::class, 'store'])->name('storeIdentification');
        Route::post('EditIdentification', [IdentificationController::class, 'edit'])->name('EditIdentification');
    });

   

    Route::prefix('classeur')->group(function () {
        Route::get('/', [ClasseurController::class, 'index'])->name('classeur');
        Route::get('/fetchallCs', [ClasseurController::class, 'fetchAll'])->name('fetchAllCs');
        Route::post('/storeCs', [ClasseurController::class, 'store'])->name('storeCs');
        Route::delete('/deleteCs', [ClasseurController::class, 'deleteall'])->name('deleteCs');
        Route::get('/editCs', [ClasseurController::class, 'edit'])->name('editCs');
        Route::post('/updateCs', [ClasseurController::class, 'update'])->name('updateCs');
    });

    Route::prefix('banque')->group(function () {
        Route::get('/', [BanqueController::class, 'index'])->name('banque');
        Route::get('/fetchAllBanque', [BanqueController::class, 'fetchAll'])->name('fetchAllBanque');
        Route::post('/storebanque', [BanqueController::class, 'store'])->name('storebanque');
        Route::delete('/deletebanque', [BanqueController::class, 'delete'])->name('deletebanque');
        Route::get('/edibanque', [BanqueController::class, 'edit'])->name('edibanque');
        Route::post('/updatebanque', [BanqueController::class, 'update'])->name('updatebanque');
    });

    Route::prefix('iov')->group(function () {
        Route::get('/', [IovController::class, 'index'])->name('iov.index');
        Route::get('/liste', [IovController::class, 'liste'])->name('iov.liste');
        Route::post('/store', [IovController::class, 'store'])->name('iov.store');
        Route::delete('/delete', [IovController::class, 'delete'])->name('iov.delete');
        Route::get('/edit', [IovController::class, 'edit'])->name('iov.edit');
        Route::post('/update', [IovController::class, 'update'])->name('iov.update');
    });

    Route::prefix('tr')->group(function () {
        Route::get('/', [TauxRealisationController::class, 'index'])->name('tr.index');
        Route::get('/liste', [TauxRealisationController::class, 'liste'])->name('tr.liste');
        Route::post('/store', [TauxRealisationController::class, 'store'])->name('tr.store');
        Route::delete('/delete', [TauxRealisationController::class, 'delete'])->name('tr.delete');
        Route::get('/edit', [TauxRealisationController::class, 'edit'])->name('tr.edit');
        Route::post('/update', [TauxRealisationController::class, 'update'])->name('tr.update');
    });

    Route::prefix('termes')->group(function () {
        Route::get('/', [ApreviationController::class, 'index'])->name('termes');
        Route::get('/fetchAllabre', [ApreviationController::class, 'fetchAll'])->name('fetchAllabre');
        Route::post('/storeabr', [ApreviationController::class, 'store'])->name('storeabr');
        Route::delete('/deleteabr', [ApreviationController::class, 'delete'])->name('deleteabr');
        Route::get('/ediagr', [ApreviationController::class, 'edit'])->name('ediabr');
        Route::post('/updateabr', [ApreviationController::class, 'update'])->name('updateabr');
    });

  

    // Parc automobile

    Route::prefix('conducteur')->group(function () {
        Route::get('/', [AuthController::class, 'conducteur'])->name('conducteur');
        Route::get('/fetchAllcond', [AuthController::class, 'fetchAllcond'])->name('fetchAllcond');
        // Route::post('/storeus', [AuthController::class, 'store'])->name('storeus');
        // Route::delete('/deleteUs', [AuthController::class, 'deleteall'])->name('deleteUs');
        // Route::get('/editUs', [AuthController::class, 'edit'])->name('editUs');
        // Route::post('/updateUs', [AuthController::class, 'update'])->name('updateUs'); 
    });

    Route::prefix('carburents')->group(function () {
        Route::get('/', [PleincarburantController::class, 'index'])->name('carburents');
        Route::get('/allcarburents', [PleincarburantController::class, 'allcarburents'])->name('allcarburents');
        Route::delete('/deletePlain', [PleincarburantController::class, 'deletePlain'])->name('deletePlain');
        Route::post('/storeplein', [PleincarburantController::class, 'store'])->name('storeplein');
    });


    Route::get('parc', [AppCOntroller::class, 'parc'])->name('parc');

    Route::prefix('projet/lignebudgetaire')->group(function () 
    {
        Route::get('/', [CompteController::class, 'index'])->name('gestioncompte');
        Route::get('/fetchAllGc', [CompteController::class, 'fetchAll'])->name('fetchAllGc');
        Route::get('/Selectcompte', [CompteController::class, 'selectcompte'])->name('Selectcompte');
        Route::get('/SelectSousCompte', [CompteController::class, 'sousselectcompte'])->name('SelectSousCompte');
        Route::post('/storeGc', [CompteController::class, 'store'])->name('storeGc');
        Route::post('/storeSc', [CompteController::class, 'storesc'])->name('storeSc');
        Route::post('/storeSSc', [CompteController::class, 'storesSc'])->name('storeSSc');
        Route::delete('/deleteGc', [CompteController::class, 'deleteall'])->name('deleteGc');

        Route::get('/ShowCompte', [CompteController::class, 'addsc'])->name('ShowCompte');
        Route::get('/ShowCompteGrand', [CompteController::class, 'addscr'])->name('ShowCompteGrand');
        Route::get('/editGc', [CompteController::class, 'edit'])->name('editGc');
        Route::post('/updateGc', [CompteController::class, 'update'])->name('updateGc');
        Route::post('/updatecompte', [CompteController::class, 'updatecompte'])->name('updatecompte');
        Route::post('/updateGrandcompte', [CompteController::class, 'updateGrandcompte'])->name('updateGrandcompte');
          
    });

    Route::prefix('projet/budgetisation')->group(function () {
        Route::get('/', [RallongebudgetController::class, 'index'])->name('rallongebudget');
        Route::post('/storerallonge', [RallongebudgetController::class, 'store'])->name('storerallonge');
        Route::get('/fetchRallonge', [RallongebudgetController::class, 'fetchAll'])->name('fetchRallonge');
        Route::get('/findSousCompte', [RallongebudgetController::class, 'findSousCompte'])->name('findSousCompte');

        Route::get('/showrallonge', [RallongebudgetController::class, 'showrallonge'])->name('showrallonge');
        Route::get('/historiquelist', [RallongebudgetController::class, 'showhistorique'])->name('historiqueliste');



        Route::post('/updaterallonge', [RallongebudgetController::class, 'updatlignebudget'])->name('updaterallonge');
        Route::delete('/deleteligne', [RallongebudgetController::class, 'deleteall'])->name('deleteligne');
    });
    Route::get('/telecharger-rapport-budget', [RallongebudgetController::class, 'telecharger_rapport_budget'])->name('telecharger-rapport-budget');

    Route::prefix('dossier')->group(function () {
        Route::get('/', [FolderController::class, 'index'])->name('folder');
        Route::get('/fetchAllfl', [FolderController::class, 'fetchAll'])->name('fetchAllfl');
        Route::post('/storefl', [FolderController::class, 'store'])->name('storefl');
        Route::delete('/deletefl', [FolderController::class, 'deleteall'])->name('deletefl');
        Route::get('/editfl', [FolderController::class, 'edit'])->name('editfl');
        Route::post('/updatefl', [FolderController::class, 'update'])->name('updatefl');
    });

    Route::prefix('typebudget')->group(function () {
        Route::get('/', [TypeprojetController::class, 'index'])->name('typebudget');
        Route::get('/fetchtypebudget', [TypeprojetController::class, 'fetchAll'])->name('fetchtypebudget');
        Route::post('/storetypebudget', [TypeprojetController::class, 'store'])->name('storetypebudget');
        Route::delete('/deletetypebudget', [TypeprojetController::class, 'deleteall'])->name('deletetypebudget');
        Route::get('/edittypebudget', [TypeprojetController::class, 'edit'])->name('edittypebudget');
        Route::post('/updatetypebudget', [TypeprojetController::class, 'update'])->name('updatetypebudget');
    });

    Route::prefix('devise')->group(function () {
        Route::get('/', [DeviseController::class, 'index'])->name('devise');
        Route::get('/alldevise', [DeviseController::class, 'fetchAll'])->name('alldevise');
        Route::post('/storedevise', [DeviseController::class, 'store'])->name('storedevise');
        Route::delete('/deletedevise', [DeviseController::class, 'deleteall'])->name('deletedevise');
        Route::get('/editdevise', [DeviseController::class, 'edit'])->name('editdevise');
        Route::post('/updatedevise', [DeviseController::class, 'update'])->name('updatedevise');
    });

    Route::prefix('pays')->group(function () {
        Route::get('/', [PaysController::class, 'index'])->name('pays');
        Route::get('/liste', [PaysController::class, 'liste'])->name('liste.pays');
        Route::post('/store', [PaysController::class, 'store'])->name('store.pays');
        Route::delete('/delete', [PaysController::class, 'delete'])->name('delete.pays');
        Route::get('/edit', [PaysController::class, 'edit'])->name('edit.pays');
        Route::post('/update', [PaysController::class, 'update'])->name('update.pays');
    });


    Route::prefix('beneficiaire')->group(function () {
        Route::get('/', [BeneficaireController::class, 'index'])->name('beneficiaire');
        Route::get('/allbeneficiaire', [BeneficaireController::class, 'fetchAll'])->name('allbeneficiaire');
        Route::post('/storebeneficiaire', [BeneficaireController::class, 'store'])->name('storebeneficiaire');
        Route::delete('/deletebeneficiaire', [BeneficaireController::class, 'deleteall'])->name('deletebeneficiaire');
        Route::get('/editbeneficiaire', [BeneficaireController::class, 'edit'])->name('editbeneficiaire');
        Route::post('/updatebeneficiaire', [BeneficaireController::class, 'update'])->name('updatebeneficiaire');

        Route::get('/categoriebeneficiaire', [CategoriebeneficiaireController::class, 'allcategoriebeneficiaire'])->name('categoriebeneficiaire');
        Route::post('/storecategoriebeneficiaire', [CategoriebeneficiaireController::class, 'storecategorie'])->name('storecategoriebeneficiaire');
        Route::get('/selectcategorie', [CategoriebeneficiaireController::class, 'selectcategorie'])->name('selectcategorie');

        Route::get('/editcategorie', [CategoriebeneficiaireController::class, 'edit'])->name('editcategorie');
        Route::post('/updatecategorie', [CategoriebeneficiaireController::class, 'updatecate'])->name('updatecategorie');

        Route::delete('/deletecategorie', [CategoriebeneficiaireController::class, 'deletecategorie'])->name('deletecategorie');
    });

    Route::prefix('project')->group(function () {
        Route::get('/new', [ProjectController::class, 'new'])->name('new_project');
        Route::get('/', [ProjectController::class, 'list'])->name('list_project');
        Route::post('/storeProject', [ProjectController::class, 'store'])->name('storeProject');
        Route::get('/closeproject', [ProjectController::class, 'closeproject'])->name('closeproject');
        Route::get('{project}/exercice/{exercice}', [ProjectController::class, 'show'])->name('key.viewProject');
        Route::get('/{key}/edit/', [ProjectController::class, 'editshow'])->name('key.editProject');
        Route::put('/updatprojet/{cle}', [ProjectController::class, 'updateprojet'])->name('updatprojet');
        Route::delete('/deleteprojet', [ProjectController::class, 'deleteprojet'])->name('projetdelete');
        Route::post('/check_project_access', [ProjectController::class, 'checkProjectAccess'])->name('check_project_access');

        Route::post('/store_revision_Project', [ProjectController::class, 'store_revision'])->name('revision.store');
        Route::get('/revision/{projet}/', [ProjectController::class, 'showrevision'])->name('liste.revision');

        Route::get('/exercice/{id}', [ProjectController::class, 'showexercice'])->name('exercice.show');
        Route::get('/{key}/newexercice/', [ProjectController::class, 'newexercice'])->name('new.exercice');  
        Route::post('/store.exe', [ProjectController::class, 'storeexe'])->name('store.exe');
        

    });

    Route::prefix('project/exercices')->group(function() {
        Route::get('/', [ExerciceController::class, 'index'])->name('exercices.index');

        Route::get('/{exerciceId}', [ExerciceController::class, 'show'])->name('exercices.show');
     
        Route::put('/update', [ExerciceController::class, 'Updateexe'])->name('exercice.update');
    
    });

    Route::prefix('project/securite')->group(function() {
        Route::get('/', [SecuriteController::class, 'index'])->name('securite.index');
        Route::put('/update', [SecuriteController::class, 'Update'])->name('securite.update'); 
        Route::post('/savesecure', [SecuriteController::class, 'store'])->name('secure.store');
       
    });
    

    Route::prefix('projet/intervenant')->group(function () {
        Route::get('/', [AffectationController::class, 'index'])->name('affectation');
        Route::post('/storeAffectation', [AffectationController::class, 'storeAffectation'])->name('storeAffectation');
    });

    Route::prefix('projet/bailleur-fonds')->group(function () {
        Route::get('/', [BailleursDeFondsController::class, 'index'])->name('bailleursDeFonds');
        Route::post('/store', [BailleursDeFondsController::class, 'store'])->name('bailleurs.store');
        Route::post('/storeacces', [BailleursDeFondsController::class, 'storeAcces'])->name('acces.bailleurs.store');
        Route::get('/liste', [BailleursDeFondsController::class, 'liste'])->name('liste.bailleursDeFonds');
    });

    Route::prefix('projet/feb')->group(function () {
        Route::get('/', [FebController::class, 'list'])->name('listfeb');
        Route::get('nouvel', [FebController::class, 'create'])->name('nouveau.feb');
        Route::post('/storefeb', [FebController::class, 'store'])->name('storefeb');
   
        Route::get('/fetchAllfeb', [FebController::class, 'fetchAll'])->name('fetchAllfeb');
        Route::get('/Sommefeb', [FebController::class, 'Sommefeb'])->name('Sommefeb');
        Route::get('/search-feb', [FebController::class, 'searchFeb'])->name('searchFeb');

        Route::get('/findligne', [FebController::class, 'findligne'])->name('findligne');
        Route::post('/updatefeb', [FebController::class, 'update'])->name('updatefeb');
        Route::delete('/deletefeb', [FebController::class, 'delete'])->name('deletefeb');
        Route::delete('/desactiverlesignalefeb', [FebController::class, 'desacctiveSignale'])->name('desactiverlesignalefeb');
        Route::get('/{key}/view/', [FebController::class, 'show'])->name('key.viewFeb');
        Route::get('{id}/edit/', [FebController::class, 'showonefeb'])->name('showfeb');
        Route::put('/updatallfeb/{cle}', [FebController::class, 'Updatestore'])->name('updateallfeb');

        Route::get('/{id}/showannex/', [FebController::class, 'showannex'])->name('showannex');
        Route::put('/updat_annex/{cle}', [FebController::class, 'updat_annex'])->name('updat_annex');

        Route::get('{id}/generate-pdf-feb', [FebController::class, 'generatePDFfeb'])->name('generate-pdf-feb');

        Route::delete('deleteelementsfeb', [FebController::class, 'deleteelementsfeb'])->name('deleteelementsfeb');
        Route::post('/check-feb', [FebController::class, 'checkfeb'])->name('check.feb');
        Route::get('/generate-word-feb/{id}', [FebController::class, 'generateWordFeb'])->name('generate.word.feb');

        Route::get('/feb/fetchAllsignalefeb/{febid?}', [SignalefebController::class, 'fetchAllsignalefeb'])->name('fetchAllsignalefeb');
        Route::post('/storesignalefeb', [SignalefebController::class, 'storeSignaleFeb'])->name('storesignalefeb');

        Route::post('/storeAnnexe', [FebController::class, 'updatannex'])->name('storeAnnexe');
        Route::delete('/supprimerlesignalefeb', [SignalefebController::class, 'deleteSignale'])->name('supprimerlesignalefeb');

 
    });

    Route::get('/getfeb', [FebController::class, 'findfebelement'])->name('getfeb');
    Route::get('/getfebretour', [FebController::class, 'findfebelementretour'])->name('getfebretour');
    Route::get('/getdjas', [DjaController::class, 'getdjas'])->name('getdjas');
    Route::get('/getdjasto', [DjaController::class, 'getdjasto'])->name('getdjasto');

    Route::get('/findfebpc', [DapbpcController::class, 'findfebpc'])->name('findfebpc');

    Route::get('/getactivite', [FebController::class, 'getactivite'])->name('getactivite');
    Route::get('/fetctnotifiaction', [FebController::class, 'notificationFeb'])->name('allnotification');
    Route::get('/fetctnotifiactiondap', [FebController::class, 'notificationdap'])->name('allnotificationdap');
    Route::get('/fetctnotifiactiondja', [FebController::class, 'notificationDja'])->name('allnotificationdja');
    Route::get('/fetctnotifiactionbpc', [FebController::class, 'notificationBpc'])->name('allnotificationbpc');
    Route::get('/fetctnotifiactionfac', [FebController::class, 'notificationfac'])->name('allnotificationfac');
    Route::get('/fetctnotifiactiondac', [FebController::class, 'notificationdac'])->name('allnotificationdac');
    Route::get('/fetctnotifiactionrac', [FebController::class, 'notificationrac'])->name('allnotificationrac');

    Route::get('/condictionsearch', [RallongebudgetController::class, 'condictionsearch'])->name('condictionsearch');

    // categorie

    Route::prefix('bpc')->group(function () {

        Route::get('/', [BpcController::class, 'list'])->name('listbpc');
     
    });

    Route::prefix('dap')->group(function () {
        Route::get('/', [DapController::class, 'list'])->name('listdap');

        Route::get('/nouveau', [DapController::class, 'creer'])->name('nouveau.dap');
        Route::get('/fetchdap', [DapController::class, 'fetchAll'])->name('fetchdap');
      
        Route::post('/storedap', [DapController::class, 'store'])->name('storedap');
        Route::delete('/deletedap', [DapController::class, 'delete'])->name('deletedap');
        Route::get('/{id}/view/', [DapController::class, 'show'])->name('viewdap');
        Route::get('{id}/edit/', [DapController::class, 'edit'])->name('showdap');
        Route::put('/updatalldap', [DapController::class, 'updatestore'])->name('updatdap');
        Route::post('/updatesignaturedap', [DapController::class, 'updatesignature'])->name('updatesignaturedap');
        Route::post('/updateautorisactiondap', [DapController::class, 'updateautorisactiondap'])->name('updateautorisactiondap');
        Route::post('/update_autorisation_dap', [DapController::class, 'update_autorisation_dap'])->name('update_autorisation_dap');
        Route::get('{id}/generate-pdf-dap', [DapController::class, 'generatePDFdap'])->name('generate-pdf-dap');
        Route::get('/{key}/verification/', [DapController::class, 'show'])->name('key.verificationdap');
        Route::post('/check-dap', [DapController::class, 'checkDap'])->name('check.dap');
        Route::get('/getFuelTypes', [DapController::class, 'getFuelType'])->name('getFuelTypes');
        Route::post('/get-feb-details', [DapController::class, 'getFebDetails'])->name('get-feb-details');


        Route::get('/dap/fetchAllsignaledap/{dapid?}', [DapController::class, 'fetchAllsignaledap'])->name('fetchAllsignaledap');
        Route::post('/storesignaledap', [DapController::class, 'storeSignaleDap'])->name('storesignaledap');
        Route::delete('/desactiverlesignaledap', [DapController::class, 'desacctiveSignale'])->name('desactiverlesignaledap');
        Route::delete('/supprimerlesignaledap', [DapController::class, 'deleteSignale'])->name('supprimerlesignaledap');
        Route::delete('/deleteelementsdap', [DapController::class, 'deleteElement'])->name('deleteelementsdap');
    });

    Route::prefix('dja')->group(function () {
        Route::get('/', [DjaController::class, 'list'])->name('listdja');
        Route::get('/{id}/nouveau/', [DjaController::class, 'nouveau'])->name('nouveau');
        Route::get('/{id}/nouveauutilisation/', [DjaController::class, 'nouveauutilisation'])->name('nouveau.utilisation');
        
        Route::get('/{id}/voir', [DjaController::class, 'voir'])->name('voirDja');

        Route::get('/{id}/misesajour/', [DjaController::class, 'misesajour'])->name('misesajour');
        Route::post('/storejustification', [DjaController::class, 'saveDjas'])->name('storejustification');
        Route::post('/storeannex', [DjaController::class, 'saveDjasannex'])->name('storeannexjustification');
        Route::post('/updatejustification/{id}', [DjaController::class, 'UpDjas'])->name('updatejustification');
        Route::post('/declareJustificatif/{id}', [DjaController::class, 'UpdJustificatif'])->name('declareJustificatif');
        Route::post('/updateSignatureDja/{id}', [DjaController::class, 'UpdateSignatureDja'])->name('updateSignatureDja');

        Route::get('/fetchdja', [DjaController::class, 'fetchAll'])->name('fetchdja');
        Route::delete('/deletedja', [DjaController::class, 'delete'])->name('deletedja');
        Route::get('/{id}/view/', [DjaController::class, 'show'])->name('viewdja');
        Route::get('{id}/edit/', [DjaController::class, 'edit'])->name('showdja');
        Route::put('/updatalldja/{id}', [DjaController::class, 'Updatestore'])->name('updatdja');
        Route::get('{id}/generate-pdf-dja', [DjaController::class, 'generatePDFdja'])->name('generate-pdf-dja');


        // CAS DE RAPPORT D'UTILISATION

        Route::post('/storeutilisateur', [CasutilisationController::class, 'store'])->name('store.utilisation');
        Route::get('/{id}/showannex/', [DjaController::class, 'showannex'])->name('annex.show.dja');
        Route::put('/updat_annex_djas/{cle}', [DjaController::class, 'updat_annex'])->name('updat_annex_dja');
       
    });
    Route::get('/check-unverified-funds', [DjaController::class, 'checkUnverifiedFunds']);


    Route::prefix('sqr')->group(function () {
        Route::get('/', [SqrController::class, 'list'])->name('listsqr');
        Route::post('/storesqr', [SqrController::class, 'store'])->name('storesqr');
    });

    Route::prefix('bonpetitcaisse')->group(function () {
        Route::get('/', [BonpetitcaisseController::class, 'index'])->name('bpc');
        Route::get('/liste_bpc', [BonpetitcaisseController::class, 'list'])->name('liste_bpc');
        Route::post('/storebpc', [BonpetitcaisseController::class, 'store'])->name('storebpc');
        Route::post('/updatebonpet', [BonpetitcaisseController::class, 'update'])->name('updatebonpet');
        
        Route::get('/{key}/viewbpc/', [BonpetitcaisseController::class, 'show'])->name('viewbpc');
        Route::get('/{key}/voir/', [BonpetitcaisseController::class, 'voir'])->name('voir.bpc');
        Route::post('/update_signature_bpc', [BonpetitcaisseController::class, 'updateSignature'])->name('update_signature_bpc');
    });

    Route::prefix('Rappport')->group(function () { 
        Route::get('caisse', [RapportController::class, 'caisse'])->name('Rapport.caisse');
        Route::get('cloturecaisse', [RapportController::class, 'cloturecaisse'])->name('Rapport.cloture.caisse');
        Route::post('/update_signature_cloture', [RapportController::class, 'updateSignatureCloture'])->name('update_signature_cloture');
        Route::get('/get-nums/{compteId}', [RapportController::class, 'getNumeros'])->name('get.nums');
        Route::get('/filter-data', [RapportController::class, 'filterData'])->name('filterData');
        Route::get('rapprochement', [RapportController::class, 'rapprochement'])->name('rapprochement');
        Route::get('rapartitiooncouts', [RapportController::class, 'rapartitiooncouts'])->name('rapartitiooncouts');
        Route::post('/storeRapprochement', [RapportController::class, 'storeRecherche'])->name('storeRapprochement');  
        Route::get('getlisteRapportage', [RapportController::class, 'getRapprochement'])->name('getlisteRapportage');
        Route::get('{id}/Rapprochement', [RapportController::class, 'rapporRapprochement'])->name('rapporRapprochement');
        Route::delete('/deleterapprochement', [RapportController::class, 'destroy'])->name('deleterapprochement');
        
    });

    Route::post('/clotureCaisse', [RapportController::class, 'store'])->name('clotureCaisse');
   
    Route::post('/generate-printable-rapport', [RapportController::class, 'generatePrintableFile'])->name('generate.print.raport');

    Route::prefix('compte/petitcaisse')->group(function () {
        Route::get('/', [ComptepetitecaisseController::class, 'index'])->name('cpc');
        Route::get('/liste_cpc', [ComptepetitecaisseController::class, 'fetchAll'])->name('liste_cpc');
        Route::post('/storecpc', [ComptepetitecaisseController::class, 'store'])->name('storecpc');
        Route::delete('/deletecpc', [ComptepetitecaisseController::class, 'delete'])->name('deletecpc');
        Route::get('/historiqueCaisse', [ComptepetitecaisseController::class, 'fetchHistoriqueCaisse'])->name('historiqueCaisse');
        Route::get('/historiqueCaisse/print/{id}', [ComptepetitecaisseController::class, 'printHistoriqueCaisse'])->name('historiqueCaisse.print');
        Route::get('/editCompte', [ComptepetitecaisseController::class, 'edit'])->name('editCompte');
        Route::post('/updateCompte', [ComptepetitecaisseController::class, 'update'])->name('updateCompte');   
    });

    Route::prefix('feb/petitcaisse')->group(function () {
        Route::get('/', [FebpetitcaisseController::class, 'index'])->name('febpc');
        Route::get('/liste_febpc', [FebpetitcaisseController::class, 'fetchAll'])->name('liste_febpc');
        Route::get('/{id}/viewfebpc', [FebpetitcaisseController::class, 'show'])->name('viewfebpc');
        Route::post('/updatesignaturefebpetit', [FebpetitcaisseController::class, 'updatesignaturefebpetit'])->name('updatesignaturefebpetit');
        Route::get('/{id}/editfebpc', [FebpetitcaisseController::class, 'edit'])->name('editfebpc');
        Route::put('/updatefebpetit/{cle}', [FebpetitcaisseController::class, 'Updatestore'])->name('updatefebpetit');
        Route::post('/check-febpc', [FebpetitcaisseController::class, 'checkfeb'])->name('check.febpc');
        Route::post('/storefebpc', [FebpetitcaisseController::class, 'store'])->name('storefebpc');
        Route::delete('/deletefebpc', [FebpetitcaisseController::class, 'delete'])->name('deletefebpc');
        Route::get('{id}/generate-pdf', [FebpetitcaisseController::class, 'generatePDFfebpc'])->name('generate-pdf');
    });

    Route::prefix('dappc')->group(function () {
        Route::get('/', [DapbpcController::class, 'index'])->name('dappc');
        Route::get('/fetchdappc', [DapbpcController::class, 'fetchAll'])->name('fetchdappc');
        Route::post('/storedappc', [DapbpcController::class, 'store'])->name('storedappc');
        Route::delete('/deletedappc', [DapbpcController::class, 'delete'])->name('deletedappc');
        Route::get('/{id}/view/', [DapbpcController::class, 'show'])->name('viewdappc');
        Route::get('{id}/edit/', [DapbpcController::class, 'edit'])->name('showdappc');
        Route::post('/check-dappc', [DapbpcController::class, 'checkDap'])->name('check.dappc');
        Route::post('/updatesignaturedappc', [DapbpcController::class, 'updatesignature'])->name('updatesignaturedappc');
       
        
        Route::put('/updatalldap', [DapController::class, 'updatestore'])->name('updatdap');
       
        Route::post('/updateautorisactiondap', [DapController::class, 'updateautorisactiondap'])->name('updateautorisactiondap');
        Route::post('/update_autorisation_dap', [DapController::class, 'update_autorisation_dap'])->name('update_autorisation_dap');
        Route::get('{id}/generate-pdf-dap', [DapController::class, 'generatePDFdap'])->name('generate-pdf-dap');
        Route::get('/{key}/verification/', [DapController::class, 'show'])->name('key.verificationdap');
       
        Route::get('/getFuelTypes', [DapController::class, 'getFuelType'])->name('getFuelTypes');
        Route::post('/get-feb-details', [DapController::class, 'getFebDetails'])->name('get-feb-details');
        Route::post('/dja-get-feb-details', [DapController::class, 'DjagetFebDetails'])->name('dja-get-feb-details');

        Route::get('/dap/fetchAllsignaledap/{dapid?}', [DapController::class, 'fetchAllsignaledap'])->name('fetchAllsignaledap');
        Route::post('/storesignaledap', [DapController::class, 'storeSignaleDap'])->name('storesignaledap');
        Route::delete('/desactiverlesignaledap', [DapController::class, 'desacctiveSignale'])->name('desactiverlesignaledap');
        Route::delete('/supprimerlesignaledap', [DapController::class, 'deleteSignale'])->name('supprimerlesignaledap');
        Route::delete('/deleteelementsdap', [DapController::class, 'deleteElement'])->name('deleteelementsdap');
        Route::get('/dap-list/liste-dap/{date}', [DapController::class, 'printDapList'])->name('dap.list.print');
       

    });

    Route::prefix('ftd')->group(function () {
        Route::get('/', [FdtController::class, 'list'])->name('listftd');
        Route::post('/storeftd', [FdtController::class, 'store'])->name('storeftd');
    });

    Route::prefix('communique')->group(function () {
        Route::get('/', [CommuniqueController::class, 'index'])->name('communique');
        Route::get('/listeCom', [CommuniqueController::class, 'liste'])->name('listeCom');
        Route::post('/storeCom', [CommuniqueController::class, 'store'])->name('storeCom');
        Route::delete('/deleteCom', [CommuniqueController::class, 'destroy'])->name('deleteCom');
    });

    Route::prefix('portier')->group(function () {
        Route::get('/', [PortierController::class, 'index'])->name('portier');
        Route::get('/fetchAllpor', [PortierController::class, 'fetchAll'])->name('fetchAllpor');
        Route::post('/storepor', [PortierController::class, 'store'])->name('storepor');
        Route::delete('/deletepor', [FolderController::class, 'deleteall'])->name('deletepor');
    });

    Route::prefix('vehicule')->group(function () {
        Route::get('/', [VehiculeController::class, 'index'])->name('vehicule');
        Route::get('/fetchAllvl', [VehiculeController::class, 'fetchAll'])->name('fetchAllvl');
        Route::post('/storevl', [VehiculeController::class, 'store'])->name('storevl');
        Route::delete('/deletevl', [VehiculeController::class, 'deleteall'])->name('deletevl');
        Route::get('/editveh', [VehiculeController::class, 'edit'])->name('editveh');
        Route::post('/updateveh', [VehiculeController::class, 'update'])->name('updateveh');

        // Achat location
        Route::get('/fetchachat', [AchatLocationController::class, 'fetchachat'])->name('fetchachat');
        Route::post('/storeachat', [AchatLocationController::class, 'storeachat'])->name('storeachat');
        Route::delete('/deleteachat', [AchatLocationController::class, 'deleteachat'])->name('deleteachat');

        Route::get('/showvehicule', [VehiculeController::class, 'edit'])->name('showvehicule');
    });

    Route::prefix('entretient')->group(function () {
        Route::get('/', [EntretientController::class, 'index'])->name('entretient');
        Route::get('/show_entretien', [EntretientController::class, 'fetchAll'])->name('allentretien');
        Route::post('/storeEntretien', [EntretientController::class, 'store'])->name('storeEntretien');

        Route::get('/show_programme', [EntretienProgrammerController::class, 'fetchallp'])->name('allprogramme');
        Route::post('/storeProgramme', [EntretienProgrammerController::class, 'storeProgramme'])->name('storeProgramme');
        Route::delete('/deleteEntretien', [EntretientController::class, 'deleteEntretient'])->name('deleteEntretien');

        Route::delete('/deleteProgramme', [EntretienProgrammerController::class, 'deleteProgramme'])->name('deleteProgramme');
    });


    Route::prefix('carnet_bord')->group(function () {
        Route::get('/', [CarnetbordController::class, 'index'])->name('carnet_bord');
        Route::get('/show_carnet', [CarnetbordController::class, 'fetchAll'])->name('all_carnet');
        Route::post('/storeCarnet', [CarnetbordController::class, 'store'])->name('storeCarnet');
        Route::delete('/deleteCarnet', [CarnetbordController::class, 'delete'])->name('delete_carnet');
        Route::get('/showCarnet', [CarnetbordController::class, 'showCarnet'])->name('showCarnet');
        Route::post('/updateCarnet', [CarnetbordController::class, 'updateCarnet'])->name('updateCarnet');
        Route::get('/rapportcarnetbord', [CarnetbordController::class, 'rapportcarnet'])->name('rapport_carnet_bord');
    });

    Route::prefix('outilspa')->group(function () {
        Route::get('/', [OutilsController::class, 'index'])->name('outilspa');
        Route::get('/alltype', [OutilsController::class, 'alltype'])->name('alltype');
        Route::post('/storetype', [OutilsController::class, 'storetype'])->name('storetype');
        Route::get('/edittype', [OutilsController::class, 'edittype'])->name('edittype');
        Route::post('/updatetype', [OutilsController::class, 'updatetype'])->name('updatetype');
        Route::delete('/deletetype', [OutilsController::class, 'deletetype'])->name('deletetype');

        Route::get('/allcarburent', [CarburantController::class, 'allcaburent'])->name('allcarburent');
        Route::post('/storecarburent', [CarburantController::class, 'storecarburent'])->name('storecarburent');
        Route::get('/editcarburent', [CarburantController::class, 'editcarburent'])->name('editcarburent');
        Route::post('/updatecarburent', [CarburantController::class, 'updatecarburent'])->name('updatecarburent');
        Route::delete('/deletecartburent', [CarburantController::class, 'deletecarburent'])->name('deletecartburent');

        // Statut
        Route::get('/allstatut', [StatutvehiculeController::class, 'allstatut'])->name('allstatut');
        Route::post('/storestatut', [StatutvehiculeController::class, 'storestatut'])->name('storestatut');
        Route::get('/editstatutvehicule', [StatutvehiculeController::class, 'editstatut'])->name('editstatut');
        Route::post('/updatestatutvehicule', [StatutvehiculeController::class, 'updatestatut'])->name('updatestatut');
        Route::delete('/deletestatut', [StatutvehiculeController::class, 'deletestatut'])->name('deletestatut');


        // Fournissseur
        Route::get('/allfournisseur', [FournisseurController::class, 'fetchfournisseur'])->name('allfournisseur');
        Route::post('/storefournisseur', [FournisseurController::class, 'storefournisseur'])->name('storefournisseur');
        Route::get('/selectfournisseur', [FournisseurController::class, 'Selectfournisseur'])->name('selectfournisseur');
        Route::delete('/deletefournisseur', [FournisseurController::class, 'deletefournisseur'])->name('deletefournisseur');
        Route::get('/editfournisseur', [FournisseurController::class, 'editfournisseur'])->name('editfournisseur');
        Route::post('/updatefournisseur', [FournisseurController::class, 'updatefournisseur'])->name('updatefournisseur');

        //

        Route::get('/allpiece', [PieceController::class, 'allpiece'])->name('allpiece');
        Route::post('/storepiece', [PieceController::class, 'storepiece'])->name('storepiece');
        Route::delete('/deletepiece', [PieceController::class, 'deletepiece'])->name('deletepiece');
        Route::get('/editpiece', [PieceController::class, 'editpiece'])->name('editpiece');
        Route::post('/updatepieceedit', [PieceController::class, 'updatepiece'])->name('updatepieceedit');
    });



    Route::prefix('archivage')->group(function () {
        Route::get('/', [ArchivageController::class, 'index'])->name('archivage');
        Route::post('archives', [ArchivageController::class, 'store'])->name('archives.store');
        Route::get('/getarchive', [ArchivageController::class, 'getarchive'])->name('getarchive');
        Route::post('/storeClasseur', [ArchivageController::class, 'store'])->name('storeClasseur');
        Route::post('/fetchAllclasseur', [ArchivageController::class, 'store'])->name('fetchAllclasseur');
        Route::get('/getEtiquettes/{classeurId}', [EtiquetteController::class, 'getEtiquettesByClasseur'])->name('getEtiquettesByCl');
    });

    Route::prefix('etiquette')->group(function () {
        Route::get('/', [EtiquetteController::class, 'index'])->name('etiquette');
        Route::post('/storeetiquette', [EtiquetteController::class, 'store'])->name('storeetiquette');
        Route::get('/fetchalletiquette', [EtiquetteController::class, 'fetchAll'])->name('fetchalletiquette');
    });

    Route::prefix('projet/activites')->group(function () {
        Route::get('/', [ActivityController::class, 'index'])->name('activity');
        Route::get('/new', [ActivityController::class, 'new'])->name('newactivity');
        Route::post('/storeact', [ActivityController::class, 'store'])->name('storeact');
        Route::post('/storeobeserve', [ActivityController::class, 'storeobeserve'])->name('storeobeserve');
        Route::get('/showactivity', [ActivityController::class, 'show'])->name('showactivity');
        Route::get('/showactivityobserve', [ActivityController::class, 'showactivityobserve'])->name('showactivityobserve');
        Route::delete('/deleteact', [ActivityController::class, 'deleteall'])->name('deleteact');
        Route::get('/fetchActivite', [ActivityController::class, 'fetchAll'])->name('fetchActivite');
        Route::post('/updateActivite', [ActivityController::class, 'update'])->name('updateActivite');
        Route::get('/showcommente', [ObservationactiviteController::class, 'fetchAllcommente'])->name('showcommente');
    });

    Route::prefix('catactivity')->group(function () {
        Route::get('/', [CatactivityController::class, 'cat'])->name('catActivity');
        Route::get('/fetchAllAc', [CatactivityController::class, 'fetchAll'])->name('fetchAllAc');
        Route::post('/storeACt', [CatactivityController::class, 'store'])->name('storeACt');
        Route::delete('/deleteCa', [CatactivityController::class, 'deleteall'])->name('deleteCa');
    });

    Route::prefix('history')->group(function () {
        Route::get('/', [HistoriqueController::class, 'index'])->name('history');
        Route::get('/fetchAllhis', [HistoriqueController::class, 'fetchAll'])->name('fetchAllhis');
    });

    Route::prefix('notification')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notis');
        Route::get('/fetchAllnotis', [NotificationController::class, 'fetchAll'])->name('fetchAllnotis');
    });


    //DEBUT RH

    Route::prefix('department')->group(function () {
        Route::get('/', [DepartementController::class, 'index'])->name('department');
        Route::get('/fetchAllDep', [DepartementController::class, 'fetchAll'])->name('fetchAllDep');
        Route::post('/storeDp', [DepartementController::class, 'store'])->name('storeDp');
        Route::delete('/deleteDp', [DepartementController::class, 'deleteall'])->name('deleteDp');
        Route::get('/editDp', [DepartementController::class, 'edit'])->name('editDp');
        Route::post('/updateDp', [DepartementController::class, 'update'])->name('updateDp');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [AuthController::class, 'index'])->name('user');
        Route::get('/fetchAllUs', [AuthController::class, 'fetchAll'])->name('fetchAllUs');
        Route::post('/storeus', [AuthController::class, 'store'])->name('storeus');
        Route::delete('/deleteUs', [AuthController::class, 'deleteall'])->name('deleteUs');
        Route::get('/editUs', [AuthController::class, 'edit'])->name('editUs');
        Route::post('/updateUs', [AuthController::class, 'update'])->name('updateUs');
        Route::get('changepassword/{id}', [AuthController::class, 'restauration'])->name('changepassword');
        Route::put('updatePasswordone/{id}', [AuthController::class, 'updatePasswordone'])->name('updatePasswordone');
        Route::get('shomesignature/{id}', [AuthController::class, 'shomesignature'])->name('shomesignature');
        Route::post('/updatsignatureuser', [AuthController::class, 'updatsignatureuser'])->name('updatsignatureuser');
        Route::post('/verifier-identifiant', [AuthController::class, 'verifierIdentifiant'])->name('verifier.identifiant');
        Route::post('/update-theme', [AuthController::class, 'updateThme'])->name('update-theme');

        //  Route::put('signature/{id}', [AuthController::class, 'updateSignature'])->name('signatureUs');
    });

    Route::prefix('service')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('service');
        Route::get('/fetchAllSer', [ServiceController::class, 'fetchAll'])->name('fetchAllSer');
        Route::post('/storeSer', [ServiceController::class, 'store'])->name('storeSer');
        Route::delete('/deleteSer', [ServiceController::class, 'deleteall'])->name('deleteSer');
        Route::get('/editSer', [ServiceController::class, 'edit'])->name('editSer');
        Route::post('/updateSer', [ServiceController::class, 'update'])->name('updateSer');
    });

    Route::prefix('fonction')->group(function () {
        Route::get('/', [FonctionController::class, 'index'])->name('fonction');
        Route::get('/fetchall', [FonctionController::class, 'fetchAll'])->name('fetchAll');
        Route::post('/store', [FonctionController::class, 'store'])->name('store');
        Route::delete('/deleteFon', [FonctionController::class, 'deleteall'])->name('deleteFon');
        Route::get('/editF', [FonctionController::class, 'edit'])->name('editF');
        Route::post('/updateFon', [FonctionController::class, 'update'])->name('updateFon');
    });

    Route::prefix('responsabilite')->group(function () {
        // Afficher les responsabilités associées à une fonction spécifique via son ID
        Route::get('/{id}/show/', [ResponsabiliteController::class, 'index'])->name('responsabilite.index');
        Route::get('/liste/{id}', [ResponsabiliteController::class, 'liste'])->name('responsabilite.liste');
        Route::post('/store', [ResponsabiliteController::class, 'store'])->name('store.responsabilite');
        Route::delete('/delete', [ResponsabiliteController::class, 'destroy'])->name('responsabilite.delete');
        
    });

    Route::prefix('taches')->group(function () {
        // Afficher les responsabilités associées à une fonction spécifique via son ID
        Route::get('/{id}/show/', [TachesController::class, 'index'])->name('tache.index');
        Route::get('/liste/{id}', [TachesController::class, 'liste'])->name('tache.liste');
        Route::post('/store', [TachesController::class, 'store'])->name('tache.store');
        Route::delete('/delete', [TachesController::class, 'destroy'])->name('tache.delete');
        
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile');
        Route::get('/fetchallP', [ProfileController::class, 'fetchAll'])->name('fetchAllP');
        Route::post('/storeP', [ProfileController::class, 'store'])->name('storeP');
        Route::delete('/deleteP', [ProfileController::class, 'deleteall'])->name('deleteP');
        Route::get('/editP', [ProfileController::class, 'edit'])->name('editP');
        Route::post('/updateP', [ProfileController::class, 'update'])->name('updateP');
    });

    
    Route::prefix('personnel')->group(function () {
        Route::get('/', [PersonnelController::class, 'index'])->name('personnel');
        Route::get('/fetchpersonnel', [PersonnelController::class, 'fetchAll'])->name('fetchpersonnel');
        Route::post('/storepersonnel', [PersonnelController::class, 'store'])->name('storepersonnel');
        Route::get('/showPersonnel', [PersonnelController::class, 'edit'])->name('showPersonnel');
        Route::post('/updatPersonnel', [PersonnelController::class, 'update'])->name('updatPersonnel');
        Route::post('/updatUser', [PersonnelController::class, 'updatpassword'])->name('updatUser');
        Route::post('/updatProfile', [PersonnelController::class, 'updatprofile'])->name('updatProfile');
        Route::post('/updatsignature', [PersonnelController::class, 'updatsignature'])->name('updatsignature');
    });

    Route::prefix('projet/plandeconnecte')->group(function () {
        Route::get('/', [PlanoperationnelController::class, 'index'])->name('planoperationnel');
        Route::get('/fetchAllplan', [PlanoperationnelController::class, 'fetchAll'])->name('fetchAllplan');
        Route::post('/storeplan', [PlanoperationnelController::class, 'save'])->name('storeplan');
        Route::post('/storerealisation', [PlanoperationnelController::class, 'saverealisation'])->name('storerealisation');
        Route::get('/showplanelement', [PlanoperationnelController::class, 'showplanElement'])->name('showplanelement');
        Route::delete('/deletePlan', [PlanoperationnelController::class, 'deletePlan'])->name('deletePlan');
    });

    Route::prefix('feuilletemps')->group(function () {
        Route::get('/', [FeuilletempsController::class, 'index'])->name('feuilletemps');
        Route::post('/storefeuille', [FeuilletempsController::class, 'store'])->name('storefeuille');
        Route::get('/fetchAllfeuille', [FeuilletempsController::class, 'monfeuille'])->name('fetchAllfeuille');

        Route::post('/updatefeuille', [FeuilletempsController::class, 'updatefeuille'])->name('updatefeuille');
        Route::get('/showft', [FeuilletempsController::class, 'editf'])->name('showft');
        Route::delete('/deleteftemps', [FeuilletempsController::class, 'deleteftemps'])->name('deleteftemps');
    });

    Route::get('/active-users', [AuthController::class, 'activeUsers'])->name('active-users');

    //FIN RH

    // web.php (routes file)
    Route::get('/error-page', function () {
        return view('error-page');
    })->name('errorPage');


    Route::prefix('compte/banque')->group(function () {
        Route::get('', [CompteBanqueController::class, 'index'])->name('compte.banque');
        Route::post('/store', [CompteBanqueController::class, 'store'])->name('store.compte.banque');
       
    });
    /// ROUTE DE AUTRE APPLICATION

    Route::get('/get-csrf-token', function () {
        return response()->json(['csrf_token' => csrf_token()]);
    })->name('get.csrf.token');
});
