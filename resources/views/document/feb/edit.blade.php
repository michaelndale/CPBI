@extends('layout/app')
@section('page-content')
<div class="main-content">
    <br>
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="invoice-title">
                    
               
                <div class="row">
                  
                    <div class="col-sm-12">

                    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="far fa-edit "></i> MODIFICATION DE FICHE D’EXPRESSION DES BESOINS "FEB" </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 mb-6" method="POST" action="{{ route('updateall', $dataFe->id) }}">
                    @method('PUT')
                    @csrf
                    <div id="tableExample2" >
                        <div class="table-responsive">
                            <table class="table table-striped table-sm fs--1 mb-0">
                                <tbody class="list">
                                    <tr>
                                        <td class="align-middle ps-3 name" style="width:20%">Composante/ Projet/Section</td>
                                        <td class="align-middle email" colspan="6">
                                            <input value="{{ $dataFe->id }}" type="hidden" name="febid" id="febid">
                                            <input value="{{ Session::get('title') }} " class="form-control form-control-sm" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle ps-3 name">Activité</td>
                                        <td class="align-middle email" colspan="3">
                                            <select type="text" class="form-select form-control-sm" name="activityid" id="activityid" style="width: 100%">
                                                @foreach ($dataActivite as $dataActivite)
                                                   <option  value="{{ $dataActivite->id }}">  {{ $dataActivite->titre }}</option> 
                                                @endforeach
                                                
                                                @forelse ($activite as $activites)
                                                <option value="{{ $activites->id }}"> {{ $activites->titre }} </option>
                                                @empty
                                                
                                                @endforelse
                                            </select>
                                        </td>

                                        <td class="align-middle ps-3 name">Ligne budgétaire: </td>
                                        <td class="align-middle email" colspan="3">
                                          
                                        <div class="col-lg-12">
                                                <div class="mb-0">

                                                <select class="form-select  select2-search-disable" id="referenceid" name="referenceid" required>
                                                    <option value="{{ $dataLigne->ligne_bugdetaire }}" >  {{ $dataLigne->ligne_bugdetaire }}{{ $dataLigne->numero }} {{ $dataLigne->libelle }}</option>
                                                    @foreach ($compte as $comptes)
                                                    <optgroup label="{{ $comptes->libelle }}">
                                                    @php
                                                    $idc = $comptes->id ;
                                                    $res= DB::select("SELECT * FROM comptes WHERE compteid= $idc");
                                                    @endphp
                                                    @foreach($res as $re)
                                                    <option value="{{ $re->id }}">   {{ $re->numero }} {{ $re->libelle }} </option>
                                                    @endforeach

                                                    </optgroup>
                                                    @endforeach

                                                </select>

                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle ps-3 name">Numéro fiche <br>
                                        <input type="text" name="numerofeb" id="numerofeb" class="form-control form-control-sm" value="{{ $dataFe->numerofeb }}" >
                                       
                                    </td>
                                       
                                        <td class="align-middle ps-3 name">Période: <br>
                                            <select type="text" class="form-control form-control-sm" name="periode" id="periode" value="{{ $dataFe->periode }}"  style="width: 100%">
                                             <option value="{{ $dataFe->periode }}" >{{ $dataFe->periode }} </option>
                                            @php
                                                $periode= Session::get('periode')
                                             @endphp
                                             @for($i =1 ; $i <= $periode ; $i++ )
                                                 <option value="T{{$i}}" > T{{$i}} </option>
                                             @endfor
                                            </select>

                                        </td>
                                        
                                        <td class="align-middle ps-3 name">Date: <br> 
                                        <input type="date" class="form-control form-control-sm" name="datefeb" id="datefeb" style="width: 100%" value="{{ $dataFe->datefeb }}">
                        
                                         </td>

                                         <td class="align-middle ps-3 name">BC: <br>
                                           <input type="checkbox"  name="bc" id="bc" 
                                           @if ($dataFe->bc==1)
                                                 checked value="{{ $dataFe->bc }}"
                                           @else
                                                value="{{ $dataFe->bc }}" 
                                           @endif
                                            />
                                        </td>

                                        <td class="align-middle ps-3 name">Facture: <br>
                                            <input type="checkbox"  name="facture" id="facture"
                                           @if($dataFe->facture==1)
                                                 checked value="{{ $dataFe->facture }}"
                                           @else
                                                value="{{ $dataFe->facture }}" 
                                           @endif 
                                            
                                            />
                                        </td>

                                        <td class="align-middle ps-3 name">O.M: <br>
                                            <input type="checkbox"  name="om" id="om"
                                            @if($dataFe->om==1)
                                                checked value="{{ $dataFe->om }}"
                                           @else
                                                value="{{ $dataFe->om }}" 
                                           @endif 
                                            
                                            />
                                        </td>

                                        <td class="align-middle ps-3 name">NEC: <br>
                                            <input type="checkbox"  name="nec" id="nec"
                                            @if($dataFe->nec==1)
                                                checked value="{{ $dataFe->nec }}"
                                           @else
                                                value="{{ $dataFe->nec }}" 
                                           @endif 
                                            
                                            />
                                        </td>

                                        <td class="align-middle ps-3 name">FP/Devis <br>
                                            <input type="checkbox"  name="fpdevis" id="fpdevis"
                                            @if($dataFe->fpdevis==1)
                                                checked value="{{ $dataFe->fpdevis }}"
                                           @else
                                                value="{{ $dataFe->fpdevis }}" 
                                           @endif 
                                            
                                            />
                                        </td>
                                       
                                    </tr>
                                   
                                    <tr>
                                       
                                    </tr>
                                </tbody>
                            </table>

                            <hr>



                            <div class="table-responsive">
                                <table class="table table-hover table-white" id="tableEstimate">
                                    <thead>
                                        <tr>
                                            <th style="width:80px">ID</th>
                                            <th style="width:600px">Description</th>
                                            <th style="width:150px">Unité</th>
                                            <th style="width:100px">Q<sup>té</sup></th>
                                            <th style="width:50px">Frequence</th>
                                            <th style="width:150px">P.U</th>
                                            <th style="width:200px">P.T</th>
                                            <!--<th><a href="javascript:void(0)" class="text-primary font-18" title="Add" id="addBtn"><i class="fa fa-plus-circle"></i></a></th> -->
                                        
                                            <th> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $ndale=1;
                                        @endphp
                                        @forelse ($datElement as $datElements)
                                        <tr>
                                            <td>
                                                <input  style="width:100%" type="number" id="numerodetail" name="numerodetail[]"  class="form-control form-control-sm"  value="{{  $ndale }}">
                                                <input  style="width:100%" type="hidden" id="idfd" name="idfd[]"  class="form-control form-control-sm"  value="{{  $datElements->id }}">
                                            </td>
                                            <td><input  style="width:100%" type="text"   id="description"  name="description[]"   class="form-control form-control-sm" value="{{ $datElements->libellee }}"></td>
                                            <td><input  style="width:100%" type="text"   id="unit_cost"    name="unit_cost[]"     class="form-control form-control-sm unit_price" value="{{ $datElements->unite }}" ></td>
                                            <td><input  style="width:100%" type="number" id="qty"          name="qty[]"           class="form-control form-control-sm qty"   value="{{ $datElements->quantite }}" ></td>
                                            <td><input  style="width:100%" type="number" id="frenquency"   name="frenquency[]"    class="form-control form-control-sm frenquency"  value="{{ $datElements->frequence }}"  ></td>
                                            <td><input  style="width:100%" type="number" id="pu"           name="pu[]"            class="form-control form-control-sm pu"  value="{{ $datElements->pu }}" ></td>
                                            <td><input  style="width:100%" type="text"   id="amount"       name="amount[]"        class="form-control form-control-sm total"   value="{{ $datElements->quantite*$datElements->frequence*$datElements->pu }}" " readonly></td>
                                           
                                            
                                        </tr>
 @php
     $ndale++;
 @endphp
                                        @empty
                                            Aucune element trouver
                                        @endforelse

                                       
                                    

                                        <input class="form-control text-right" type="hidden" id="tax_1" name="tax_1" value="0" readonly>

                                        <input class="form-control text-right discount" type="hidden" id="discount" name="discount" value="10">

                                        <input class="form-control text-right" type="hidden" id="grand_total" name="grand_total" value="$ 0.00" readonly>

                                    </tbody>
                                </table>
                            </div>

                            <div class="table-repsonsive">
                                <span id="error"></span>
                             
                                <table class="table table-striped table-sm fs--1 mb-0" >
                                    <tr>
                                    <tr>
                                        <td>Etablie par (AC/CE/CS) </td>
                                        <td>Vérifiée par (Comptable)</td>
                                        <td>Approuvée par (Chef de Composante/Projet/Section):</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="hidden" class="form-control form-control-sm" name="acce" id="acce" value="{{ Auth::id() }}" />
                                           {{ ucfirst($etablienom->nom) }} {{ ucfirst($etablienom->prenom) }} 
                                        </td>
                                        <td>
                                            <select type="text" class="form-control form-control-sm" name="comptable" id="comptable">
                                                <option value="{{ $comptable_nom->id }}">{{ $comptable_nom->nom }} - {{ $comptable_nom->prenom }}</option>
                                                @foreach ($comptable as $comptables)
                                                <option value="{{ $comptables->id }}">{{ $comptables->nom }} {{ $comptables->prenom }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select type="text" class="form-control form-control-sm" name="chefcomposante" id="chefcomposante">
                                                <option value="{{ $checcomposant_nom->id }}">{{ $checcomposant_nom->nom }} {{ $checcomposant_nom->prenom }}</option>
                                                @foreach ($chefcompable as $chefcompables)
                                                <option value="{{ $chefcompables->id }}">{{ $chefcompables->nom }} {{ $chefcompables->prenom }}</option>
                                                @endforeach
                                            </select>
                                        </td>


                                    </tr>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
            <br> <br>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="addfebbtn" name="addfebbtn"><i class="fa fa-check-circle"></i> Confirmer la modification  </button>
            </div>
            </form>
        </div>
                      
                    </div>
                  
                </div>
              
            </div>
        </div>
        <br>
      
    </div>
</div>
<br> <br> <br>
@endsection