<?php

namespace App\Http\Controllers;

use App\Models\Feb;
use App\Models\signalefeb;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SignalefebController extends Controller
{
    
    
    public function fetchAllsignalefeb($febid)
{
    $signale = Signalefeb::where('febid', $febid)
        ->orderBy('id', 'ASC')
        ->join('users', 'signalefebs.userid', '=', 'users.id')
        ->join('personnels', 'users.personnelid', '=', 'personnels.id')
        ->select('signalefebs.*', 'personnels.nom as user_nom', 'personnels.prenom as user_prenom', 'users.avatar as avatar')
        ->get();

    $output = '';

    if ($signale->count() > 0) {
        foreach ($signale as $rs) {
            if ($rs->userid == $rs->notisid) {
                $output .= '
                    <li class="right" >
                        <div class="conversation-list">
                            <div class="chat-avatar">
                                <img src="' . asset($rs->avatar) . '" alt="avatar">
                            </div>
                            <div class="ctext-wrap">
                                <div class="conversation-name">' . ucfirst($rs->user_nom) . ' ' . ucfirst($rs->user_prenom) . '</div>
                                <div class="ctext-wrap-content">
                                    <p class="mb-0">' . ucfirst($rs->message) . '</p>
                                </div>
                                <p class="chat-time mb-0"><i class="mdi mdi-clock-outline align-middle me-1"></i> ' .date(' H:i:s d-m-Y', strtotime($rs->created_at)) . '</p>
                            </div>
                        </div>
                    </li>';
            } else {
                $output .= '
                    <li data-simplebar>
                        <div class="conversation-list">
                            <div class="chat-avatar">
                                <img src="' . asset($rs->avatar) . '" alt="avatar">
                            </div>
                            <div class="ctext-wrap">
                                <div class="conversation-name">' . ucfirst($rs->user_nom) . ' ' . ucfirst($rs->user_prenom) . '</div>
                                <div class="ctext-wrap-content">
                                    <p class="mb-0">' . ucfirst($rs->message) . '</p>
                                </div>
                                <p class="chat-time mb-0"><i class="mdi mdi-clock-outline me-1"></i> ' .date(' H:i:s d-m-Y', strtotime($rs->created_at)) . '</p>
                            </div>
                        </div>
                    </li>';
            }
        }
    } else {
        $output = '<li>No data available</li>';
    }

    return $output;
}

    
  
    // insert a new signale ajax request
    public function storeSignaleFeb(Request $request)
    {
        DB::beginTransaction(); // Démarre la transaction

        try {
            $signale = new signalefeb();
            $signale->userid = Auth()->user()->id;
            $signale->notisid = $request->createfebs;
            $signale->febid = $request->febids;
            $signale->message = $request->messagesignale;
            $do = $signale->save();
    
            if($do){
                $checkfeb = Feb::find($request->febids);
                $checkfeb->signale = 1;
                $checkfeb->update();
    
                DB::commit(); // Valide la transaction si tout réussit
    
                return response()->json([
                    'status' => 200,
                    'febid' => $request->febids,
                ]);
            }
        } catch (Exception $e) {
            DB::rollback(); // Annule la transaction en cas d'erreur
            return response()->json([
                'status' => 202,
                'error' => $e->getMessage(), // Retourne l'erreur spécifique
            ]);
        }
    }
  
    // edit an signale ajax request
    public function edit(Request $request)
    {
      $id = $request->id;
      $fon = signalefeb::find($id);
      return response()->json($fon);
    }
  
    // update an signale ajax request
    public function update(Request $request)
    {
      try {
          $checkfeb = signalefeb::find($request->ids);
          $checkfeb->message = $request->message;
            $checkfeb->update();
            return response()->json([
              'status' => 200,
            ]);
      } catch (Exception $e) {
        return response()->json([
          'status' => 202,
        ]);
      }
    }
  
    // supresseion
    public function deleteone(Request $request)
    {
      try {
          $id = $request->id;
          signalefeb::destroy($id);
          return response()->json([
            'status' => 200,
          ]);
        
      } catch (Exception $e) {
        return response()->json([
          'status' => 202,
        ]);
      }
    }

    public function deleteall(Request $request)
    {
      try {
          $id = $request->febid;
          signalefeb::destroy($id);
          return response()->json([
            'status' => 200,
          ]);
        
      } catch (Exception $e) {
        return response()->json([
          'status' => 202,
        ]);
      }
    }
}
