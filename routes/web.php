<?php

use App\Http\Controllers\AchatLocationController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AffectationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppCOntroller;
use App\Http\Controllers\ApreviationController;
use App\Http\Controllers\ArchivageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BanqueController;
use App\Http\Controllers\BeneficaireController;
use App\Http\Controllers\BonpetitcaisseController;
use App\Http\Controllers\BpcController;
use App\Http\Controllers\CarburantController;
use App\Http\Controllers\CarnetbordController;
use App\Http\Controllers\CatactivityController;
use App\Http\Controllers\CategoriebeneficiaireController;
use App\Http\Controllers\ClasseurController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\DapController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\DeviseController;
use App\Http\Controllers\DjaController;
use App\Http\Controllers\ElementsfeuilletempsController;
use App\Http\Controllers\EntretienProgrammerController;
use App\Http\Controllers\EntretientController;
use App\Http\Controllers\EtiquetteController;
use App\Http\Controllers\FdtController;
use App\Http\Controllers\FebController;
use App\Http\Controllers\FeuilletempsController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\FonctionController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\IdentificationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ObservationactiviteController;
use App\Http\Controllers\OptiondescriptionController;
use App\Http\Controllers\OutilsController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\PieceController;
use App\Http\Controllers\PlanoperationnelController;
use App\Http\Controllers\PleincarburantController;
use App\Http\Controllers\PortierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RallongebudgetController;
use App\Http\Controllers\RapportcummuleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SignalefebController;
use App\Http\Controllers\SqrController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\StatutvehiculeController;
use App\Http\Controllers\TypeprojetController;
use App\Http\Controllers\VehiculeController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('go');
});
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'handlelogin'])->name('handlelogin');
Route::get('/out', function () { return view('auth.out'); });
Route::get('/maintenance', function () { return view('auth.maintenance'); });

Route::middleware('auth')->group(function () {

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [AppCOntroller::class, 'index'])->name('dashboard');
        Route::get('/findClaseur', [AppCOntroller::class, 'findClaseur'])->name('findClaseur');
        Route::get('/findAnnee', [AppCOntroller::class, 'findAnnee'])->name('findAnnee');
    });

    Route::prefix('rapportcumule')->group(function () {
        Route::get('/', [RapportcummuleController::class, 'index'])->name('rapportcumule');
        Route::get('/getcumule', [RapportcummuleController::class, 'findcumule'])->name('getcumule');
    });

    Route::prefix('indentification')->group(function () {
        Route::get('/', [IdentificationController::class, 'index'])->name('info');
        Route::post('storeIdentification', [IdentificationController::class, 'store'])->name('storeIdentification');
        Route::post('EditIdentification', [IdentificationController::class, 'edit'])->name('EditIdentification');
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

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile');
        Route::get('/fetchallP', [ProfileController::class, 'fetchAll'])->name('fetchAllP');
        Route::post('/storeP', [ProfileController::class, 'store'])->name('storeP');
        Route::delete('/deleteP', [ProfileController::class, 'deleteall'])->name('deleteP');
        Route::get('/editP', [ProfileController::class, 'edit'])->name('editP');
        Route::post('/updateP', [ProfileController::class, 'update'])->name('updateP');
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

    Route::prefix('termes')->group(function () {
        Route::get('/', [ApreviationController::class, 'index'])->name('termes');
        Route::get('/fetchAllabre', [ApreviationController::class, 'fetchAll'])->name('fetchAllabre');
        Route::post('/storeabr', [ApreviationController::class, 'store'])->name('storeabr');
        Route::delete('/deleteabr', [ApreviationController::class, 'delete'])->name('deleteabr');
        Route::get('/ediagr', [ApreviationController::class, 'edit'])->name('ediabr');
        Route::post('/updateabr', [ApreviationController::class, 'update'])->name('updateabr');
    });

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
    });

 
      
      

   

    Route::get('parc', [AppCOntroller::class, 'parc'])->name('parc');


    Route::prefix('gestioncompte')->group(function () {
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
        Route::get('/editGc', [CompteController::class, 'edit'])->name('editGc');
        Route::post('/updateGc', [CompteController::class, 'update'])->name('updateGc');
        Route::post('/updatecompte', [CompteController::class, 'updatecompte'])->name('updatecompte');
        Route::post('/updateGrandcompte', [CompteController::class, 'updateGrandcompte'])->name('updateGrandcompte');
        
    });

    Route::prefix('rallongebudget')->group(function () {
        Route::get('/', [RallongebudgetController::class, 'index'])->name('rallongebudget');
        Route::post('/storerallonge', [RallongebudgetController::class, 'store'])->name('storerallonge');
        Route::get('/fetchRallonge', [RallongebudgetController::class, 'fetchAll'])->name('fetchRallonge');
        Route::get('/findSousCompte', [RallongebudgetController::class, 'findSousCompte'])->name('findSousCompte');
        
        Route::get('/showrallonge', [RallongebudgetController::class, 'showrallonge'])->name('showrallonge');
        Route::post('/updaterallonge', [RallongebudgetController::class, 'updatlignebudget'])->name('updaterallonge');
        Route::delete('/deleteligne', [RallongebudgetController::class, 'deleteall'])->name('deleteligne');
    });

    Route::prefix('folder')->group(function () {
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
        Route::get('/{key}/view/', [ProjectController::class, 'show'])->name('key.viewProject');
        Route::get('/{key}/edit/', [ProjectController::class, 'editshow'])->name('key.editProject');
        Route::put('/updatprojet/{cle}', [ProjectController::class, 'updateprojet'])->name('updatprojet');
        Route::delete('/deleteprojet', [ProjectController::class, 'deleteprojet'])->name('projetdelete');
    });

    Route::prefix('affectation')->group(function () {
        Route::get('/', [AffectationController::class, 'index'])->name('affectation');
        Route::post('/storeAffectation', [AffectationController::class, 'storeAffectation'])->name('storeAffectation');
    });

    Route::prefix('feb')->group(function () {
        Route::get('/', [FebController::class, 'list'])->name('listfeb');
        Route::post('/storefeb', [FebController::class, 'store'])->name('storefeb');
        Route::get('/fetchAllfeb', [FebController::class, 'fetchAll'])->name('fetchAllfeb');
        Route::get('/Sommefeb', [FebController::class, 'Sommefeb'])->name('Sommefeb');
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
   

    Route::get('/getactivite', [FebController::class, 'getactivite'])->name('getactivite');
    Route::get('/fetctnotifiaction', [FebController::class, 'notificationdoc'])->name('allnotification');


    Route::get('/condictionsearch', [RallongebudgetController::class, 'condictionsearch'])->name('condictionsearch');

    // categorie

    Route::prefix('bpc')->group(function () {

        Route::get('/', [BpcController::class, 'list'])->name('listbpc');
        Route::post('/storebpc', [BpcController::class, 'store'])->name('storebpc');
    });

    Route::prefix('dap')->group(function () {
        Route::get('/', [DapController::class, 'list'])->name('listdap');
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
    });

    Route::prefix('dja')->group(function () {
        Route::get('/', [DjaController::class, 'list'])->name('listdja');
        Route::post('/storejustification', [DjaController::class, 'saveDjas'])->name('storejustification');
        Route::post('/updatejustification', [DjaController::class, 'UpDjas'])->name('updatejustification');

        Route::get('/fetchdja', [DjaController::class, 'fetchAll'])->name('fetchdja');
        Route::delete('/deletedja', [DjaController::class, 'delete'])->name('deletedja');
        Route::get('/{id}/view/', [DjaController::class, 'show'])->name('viewdja');
        Route::get('{id}/edit/', [DjaController::class, 'edit'])->name('showdja');
        Route::put('/updatalldja/{id}', [DjaController::class, 'Updatestore'])->name('updatdja');
        Route::get('{id}/generate-pdf-dja', [DjaController::class, 'generatePDFdja'])->name('generate-pdf-dja');
    });

    Route::prefix('sqr')->group(function () {
        Route::get('/', [SqrController::class, 'list'])->name('listsqr');
        Route::post('/storesqr', [SqrController::class, 'store'])->name('storesqr');
    });

    Route::prefix('bonpetitcaisse')->group(function () {
        Route::get('/', [BonpetitcaisseController::class, 'index'])->name('bpc');
        Route::get('/liste_bpc', [BonpetitcaisseController::class, 'list'])->name('liste_bpc');
        Route::post('/storebpc', [BonpetitcaisseController::class, 'store'])->name('storebpc');
    });

    Route::prefix('ftd')->group(function () {
        Route::get('/', [FdtController::class, 'list'])->name('listftd');
        Route::post('/storeftd', [FdtController::class, 'store'])->name('storeftd');
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

    Route::prefix('activity')->group(function () {
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

    Route::prefix('plandeconnecte')->group(function () {
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

  /*  Route::get('/test-update-last-activity', function() {
        if (Auth::check()) {
            $user = Auth::user();
            $user->last_activity = Carbon::now();
            $user->save();
            return 'Last activity updated';
        }
        return 'Not authenticated';
    }); */

    //FIN RH

    // web.php (routes file)
Route::get('/error-page', function () {
    return view('error-page');
})->name('errorPage');


});
