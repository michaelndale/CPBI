<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AffectationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppCOntroller;
use App\Http\Controllers\ArchivageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BpcController;
use App\Http\Controllers\CatactivityController;
use App\Http\Controllers\ClasseurController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\DapController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\DjaController;
use App\Http\Controllers\FdtController;
use App\Http\Controllers\FebController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\FonctionController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\IdentificationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ObservationactiviteController;
use App\Http\Controllers\PersonnelController;
use App\Http\Controllers\PortierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RallongebudgetController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SqrController;
use App\Http\Controllers\VehiculeController;


Route::get('/', function () { return view('go'); });
Route::get('/logout', [AuthController::class, 'logout'] )->name('logout');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'handlelogin'])->name('handlelogin');


Route::middleware('auth')->group(function (){ 

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [AppCOntroller::class, 'index'] )->name('dashboard');
        Route::get('/findClaseur',[AppCOntroller::class, 'findClaseur'] )->name('findClaseur');
        Route::get('/findAnnee',[AppCOntroller::class, 'findAnnee'] )->name('findAnnee');
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
       
    });

   


    Route::prefix('conducteur')->group(function () {
        Route::get('/', [AuthController::class, 'conducteur'])->name('conducteur');
        Route::get('/fetchAllcond', [AuthController::class, 'fetchAllcond'])->name('fetchAllcond');
       // Route::post('/storeus', [AuthController::class, 'store'])->name('storeus');
       // Route::delete('/deleteUs', [AuthController::class, 'deleteall'])->name('deleteUs');
       // Route::get('/editUs', [AuthController::class, 'edit'])->name('editUs');
       // Route::post('/updateUs', [AuthController::class, 'update'])->name('updateUs'); 
       
    });
    

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
        Route::get('/editGc', [CompteController::class, 'edit'])->name('editGc');
        Route::post('/updateGc', [CompteController::class, 'update'])->name('updateGc'); 
    });

    Route::prefix('rallongebudget')->group(function () {
        Route::get('/', [RallongebudgetController::class, 'index'])->name('rallongebudget');
        Route::post('/storerallonge', [RallongebudgetController::class, 'store'])->name('storerallonge');
        Route::get('/fetchRallonge', [RallongebudgetController::class, 'fetchAll'])->name('fetchRallonge');
       
       
    
    });

    Route::prefix('folder')->group(function () {
        Route::get('/', [FolderController::class, 'index'])->name('folder');
        Route::get('/fetchAllfl', [FolderController::class, 'fetchAll'])->name('fetchAllfl');
        Route::post('/storefl', [FolderController::class, 'store'])->name('storefl');
        Route::delete('/deletefl', [FolderController::class, 'deleteall'])->name('deletefl');
        Route::get('/editfl', [FolderController::class, 'edit'])->name('editfl');
        Route::post('/updatefl', [FolderController::class, 'update'])->name('updatefl'); 
    });

    Route::prefix('project')->group(function () {
        Route::get('/new', [ProjectController::class, 'new'])->name('new_project');
        Route::get('/', [ProjectController::class, 'list'])->name('list_project');
        Route::post('/storeProject', [ProjectController::class, 'store'])->name('storeProject');
        Route::get('/closeproject', [ProjectController::class, 'closeproject'])->name('closeproject');
        Route::get('/{key}/view/', [ProjectController::class, 'show'])->name('key.viewProject');
        
        
        
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
        Route::get('/findligne',[FebController::class, 'findligne'] )->name('findligne');
        Route::post('/updatefeb', [FebController::class, 'update'])->name('updatefeb');
        Route::delete('/deletefeb', [FebController::class, 'delete'])->name('deletefeb');
        Route::get('/{key}/view/', [FebController::class, 'show'])->name('key.viewFeb');
    });

    Route::prefix('bpc')->group(function () {
     
        Route::get('/', [BpcController::class, 'list'])->name('listbpc');
        Route::post('/storebpc', [BpcController::class, 'store'])->name('storebpc');
      
    });

    Route::prefix('dap')->group(function () {
        Route::get('/', [DapController::class, 'list'])->name('listdap');
        Route::get('/fetchdap', [DapController::class, 'fetchAll'])->name('fetchdap');
        Route::post('/storedap', [DapController::class, 'store'])->name('storedap');
    });

    Route::prefix('dja')->group(function () {
        Route::get('/', [DjaController::class, 'list'])->name('listdja');
        Route::post('/storedja', [DjaController::class, 'store'])->name('storedja');
    });

    Route::prefix('sqr')->group(function () {
        Route::get('/', [SqrController::class, 'list'])->name('listsqr');
        Route::post('/storedja', [SqrController::class, 'store'])->name('storedja');
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
        //Route::get('/editfl', [FolderController::class, 'edit'])->name('editfl');
        //Route::post('/updatefl', [FolderController::class, 'update'])->name('updatefl'); 
    });

    Route::prefix('vehicule')->group(function () {
        Route::get('/', [VehiculeController::class, 'index'])->name('vehicule');
        Route::get('/fetchAllvl', [VehiculeController::class, 'fetchAll'])->name('fetchAllvl');
        Route::post('/storevl', [VehiculeController::class, 'store'])->name('storevl');
        Route::delete('/deletevl', [VehiculeController::class, 'deleteall'])->name('deletevl');
        //Route::get('/editfl', [FolderController::class, 'edit'])->name('editfl');
        //Route::post('/updatefl', [FolderController::class, 'update'])->name('updatefl'); 
    });

    Route::prefix('archivage')->group(function () {
        Route::get('/', [ArchivageController::class, 'index'])->name('archivage');
       // Route::get('/fetchAllvl', [VehiculeController::class, 'fetchAll'])->name('fetchAllvl');
       // 
       // Route::delete('/deletevl', [VehiculeController::class, 'deleteall'])->name('deletevl');
        //Route::get('/editfl', [FolderController::class, 'edit'])->name('editfl');
        //Route::post('/updatefl', [FolderController::class, 'update'])->name('updatefl'); 

        Route::post('/storeexpediction', [ArchivageController::class, 'storeexpediction'])->name('storeexpediction');

        Route::get('/getarchive', [ArchivageController::class, 'getarchive'])->name('getarchive');
        Route::post('/storeClasseur', [ArchivageController::class, 'store'])->name('storeClasseur');
        Route::post('/fetchAllclasseur', [ArchivageController::class, 'store'])->name('fetchAllclasseur');
       
    });




    Route::prefix('activity')->group(function () {
        Route::get('/', [ActivityController::class, 'index'])->name('activity');
        Route::get('/new', [ActivityController::class, 'new'])->name('newactivity');
        Route::post('/storeact', [ActivityController::class, 'store'])->name('storeact');
        Route::get('/showactivity', [ActivityController::class, 'show'])->name('showactivity');
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
        
       
        // Route::delete('/deletePersonnel', [PersonnelController::class, 'deleteall'])->name('deletePersonnel');
    
    });

    //FIN RH


});
