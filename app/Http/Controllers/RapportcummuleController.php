<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RapportcummuleController extends Controller
{
    public function index()
    {
        $ID = session()->get('id');
        $title  = 'Rapport cumulatif';
        $compte = Compte::where('compteid', '=', 0)
            ->where('projetid', $ID)
            ->get();
        return view(
            'rapport.cumulatif.index',
            [
                'title' => $title,
                'compte' => $compte
            ]
        );
    }

    public function findcumule(Request $request)
    {

        $IDP = session()->get('id');
        $budget = session()->get('budget');
        $devise = session()->get('devise');
        $periode =session()->get('periode');

        $output = '';
        if (!empty($request->compte)) {
          

            if ($request->souscompte == 'Tout') { 
                
                $data = DB::table('comptes')
                ->where('compteid', $request->compte)
                ->get();
            
                $showData = Project::find($IDP);
          
                $sommerepartie= DB::table('rallongebudgets')
                ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
                ->Where('rallongebudgets.projetid', $IDP)
                ->SUM('budgetactuel');
             
           
          
                 // TOTAL Budget 
                $somme_budget= DB::table('rallongebudgets')
                          ->join('comptes', 'rallongebudgets.compteid', '=', 'comptes.id')
                          ->Where('rallongebudgets.projetid', $IDP)
                          ->SUM('budgetactuel');
                // Fin Budget 
          
          
                $output = '';
            
                  $nombre = 1;
                  $pourcatagesum=0;
          
                  $pglobale = round(($somme_budget*100)/$showData->budget);
          
                  if($sommerepartie == $showData->budget){
                    $message='<center><span class="badge rounded-pill bg-primary font-size-11">Terminer</span></center>';
                  }else{
                    $message='<center><span class="badge rounded-pill bg-success font-size-11">Encours</span></center>';
                  }
          
                  $output .='
          
                  <table class="table table-bordered  table-sm fs--1 mb-0">
                  <tr scope="col" >
                    <td scope="col" style="padding:5px"><b>Rubrique du projet</b></td>
                    <td scope="col" style="padding:5px"><b>Pays / region</b></td>
                    <td scope="col" style="padding:5px"><b>N<sup>o</sup> Projet</b></td>
                    <td scope="col" style="padding:5px"><b><center>Budget</center></b></td>
                    <td scope="col" style="padding:5px"><b><center>%</center></b></td>
                    <td scope="col" style="padding:5px"><b><center>Statut</center></b></td>
                  </tr>
                  <tr>
                    <td style="padding:5px; width:50%">'.$showData->title.'</td>
                    <td style="padding:5px">'.$showData->region.' </td>
                    <td style="padding:5px">'.$showData->numeroprojet.' </td>
                    <td style="padding:5px" align="right">'.number_format($showData->budget ,0, ',', ' ').' '.$showData->devise.'   </td>
                    <td><center>'.$pglobale.' %</center></td>
                    <td> '.$message.'</td>
                  </tr>
          
                  <tr>
                    <td colspan="3" >Montant total repartie </td>
                    <td style="padding:5px" align="right">'.number_format($somme_budget,0, ',', ' ').' '.$showData->devise.'  </td>
                   
                    <td colspan="2" style="background-color:#c0c0c0"></td>
                  </tr>
                </table>
                <br>
          
               
                  ';
          
                  $output .= '
                  <table class="table table-bordered mb-0"
                  width="100%">
                  <thead>
                    <tr >
                      <th ><b>#</b></th>
                      <th ><b>Code</b></th>
                      <th ><b>Ligne budgétaire</b></th>
                      <th ><center><b>Budget</b></center></th>
                    </tr>
                  </thead>
                  <tbody>';
          
                 
               
                  foreach ($data as $datas) {
                   // echo var_dump($datas);
           
                    // TOTAL BUDBET
                    $somme_budget_ligne= DB::table('rallongebudgets')
                    ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
                    ->Where('rallongebudgets.projetid', $IDP)
                    ->where('rallongebudgets.compteid', $request->compte)
                    ->SUM('rallongebudgets.budgetactuel');
          
          
                    if($somme_budget_ligne !=0){
                   
                    $output .= 
                    '<tr style="background-color:#F5F5F5">
                      <td><b>'.$nombre.'</b></td>
                      <td><b>' . ucfirst($datas->numero) . '</b></td>
                      <td><b>' . ucfirst($datas->libelle) . '</b></td>
                      <td align="right"><b>'. number_format($somme_budget_ligne,0, ',', ' ').' '.$devise.'</b></td>
                      
                      ';
        
                   
                    // recuperation element de la ligne
                    $sous_compte = DB::table('rallongebudgets')
                    ->join('comptes', 'rallongebudgets.souscompte', '=', 'comptes.id')
                    ->Where('rallongebudgets.projetid', $IDP)
                    ->where('rallongebudgets.compteid', $request->compte)
                    
                    ->get();
          
                  if ($sous_compte->count() > 0) {
                    $ndale = 1;
                    foreach ($sous_compte as $sc) {
                      $ids = $sc->id;

                      $act = DB::table('activities')
                      ->orderby('id','ASC')
                      ->Where('projectid', $IDP)
                      ->Where('compteidr', $sc->souscompte)
                      ->get();
        
                      $output .= '
                            <tr>
                              <td class="align-left" style="background-color:#F5F5F5; width:3%" ></td>
                              <td style="width:5%">' . ucfirst($sc->numero) . '</td>
                              <td>' . ucfirst($sc->libelle) . '</td>
                              <td align="right" style="width:20%">' . number_format($sc->budgetactuel,0, ',', ' ').' '.$devise.'</td>
                              ';
                              if($act->count() > 0){ 
                                $output .= '
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2">
                                        ';
                                 
                                       
                                        $output .= '
                                        Activite
                                        <table class="table table-bordered mb-0 table-sm">
                                        <tr>
                                            <th>Titre</th>
                                            <th>Montant</th>
                                        </tr>

                                        
                                        ';
                                        foreach ($act  as $key => $acts) {   
                                            $output .= '
                                                <tr>
                                                    <td>'.$acts->titre.'</td>
                                                    <td>'.number_format($acts->montantbudget,0, ',', ' ').'</td>
                                                </tr>
                                              ' ; 
                                        }
                                        $output .= '</table>';
                                        $output .=  '
                                    </td>
                                   
                                </tr>
                              ';
                                }
          
                           
                    }
                  }
                  }
                    $nombre++;
                  
                }
                    $output .=' 
                    </tbody>
                    </table>' ; 
                  
                  
            
            
            } else {
                echo "vous sur all";
            }


            echo $output;
        } else {
            echo
            '
            <center>
              <h6 style="margin-top:1% ;color:#c0c0c0"> 
              <center><font size="50px"><i class="far fa-trash-alt"  ></i> </font><br><br>
              Ceci est vice !</center> </h6>
            </center>
                    
            ';

            echo $request->compte;
        }
    }
}
