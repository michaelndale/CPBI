<div class="modal fade" id="addfebModal" tabindex="-1" aria-labelledby="addfebModal" aria-hidden="true">
    <div class="modal-dialog modal-xl  modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="far fa-file-alt "></i> FICHE D’EXPRESSION DES BESOINS "FEB" </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 mb-6" method="POST" id="addfebForm">
                    @method('post')
                    @csrf
                    <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;name&quot;,&quot;email&quot;,&quot;age&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm fs--1 mb-0">
                                <tbody class="list">
                                    <tr>
                                        <td class="align-middle ps-3 name" style="width:20%">Composante/ Projet/Section</td>
                                        <td class="align-middle email" colspan="6">
                                            <input value="{{ Session::get('id') }} " type="hidden" name="projetid" id="projetid">
                                            <input value="{{ Session::get('title') }} " class="form-control form-control-sm" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-middle ps-3 name">Activité</td>
                                        <td class="align-middle email" colspan="3">
                                            <select type="text" class="form-select form-control-sm" name="activityid" id="activityid" style="width: 100%">
                                                <option disabled="true" selected="true">--Aucun--</option>
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
                                                    <option>Ligne budgétaire</option>
                                                    @foreach ($compte as $comptes)
                                                    <optgroup label="{{ $comptes->libelle }}">
                                                    @php
                                                    $idc = $comptes->id ;
                                                    $res= DB::select("SELECT * FROM comptes WHERE compteid= $idc");
                                                    @endphp
                                                    @foreach($res as $re)
                                                    <option value="{{ $comptes->id }} - {{ $re->id }}"> {{ $comptes->id }}-{{ $re->id }}   {{ $re->numero }}. {{ $re->libelle }} </option>
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
                                        <input type="text" class="form-control form-control-sm"  style="width: 100% ; background-color:#c0c0c0" value="0***" readonly >
                                       
                                    </td>
                                       
                                        <td class="align-middle ps-3 name">Période: <br>
                                            <select type="text" class="form-control form-control-sm" name="periode" id="periode" style="width: 100%">
                                             @php
                                                $periode= Session::get('periode')
                                             @endphp
                                             @for($i =1 ; $i <= $periode ; $i++ )
                                                 <option value="T{{$i}}" > T{{$i}} </option>
                                             @endfor
                                            </select>

                                        </td>
                                        
                                        <td class="align-middle ps-3 name">Date: <br> 
                                        <input type="date" class="form-control form-control-sm" name="datefeb" id="datefeb" style="width: 100%" value="{{ date('') }}">
                        
                                         </td>

                                         <td class="align-middle ps-3 name">BC:<br>
                                           <input type="text" class="form-control form-control-sm" name="bc" id="bc" style="width: 100%">
                                        </td>

                                        <td class="align-middle ps-3 name">Facture: <br>
                                            <input type="text" class="form-control form-control-sm" name="facture" id="facture" style="width: 100%">
                                        </td>

                                        <td class="align-middle ps-3 name">O.M: <br>
                                            <input type="text" class="form-control form-control-sm" name="om" id="om" style="width: 100%">
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
                                            <th style="width:80px">Num</th>
                                            <th style="width:600px">Description</th>
                                            <th style="width:150px">Unité</th>
                                            <th style="width:100px">Q<sup>té</sup></th>
                                            <th style="width:50px">Frequence</th>
                                            <th style="width:150px">P.U</th>
                                            <th style="width:200px">P.T</th>

                                            <th> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input  style="width:100%" type="number" id="numerodetail" name="numerodetail[]"  class="form-control form-control-sm"  value="1"></td>
                                            <td><input  style="width:100%" type="text"   id="description"  name="description[]"   class="form-control form-control-sm"></td>
                                            <td><input  style="width:100%" type="text"   id="unit_cost"    name="unit_cost[]"     class="form-control form-control-sm unit_price" ></td>
                                            <td><input  style="width:100%" type="number" id="qty"          name="qty[]"           class="form-control form-control-sm qty"    ></td>
                                            <td><input  style="width:100%" type="number" id="frenquency"   name="frenquency[]"    class="form-control form-control-sm frenquency"   ></td>
                                            <td><input  style="width:100%" type="number" id="pu"           name="pu[]"            class="form-control form-control-sm pu"   ></td>
                                            <td><input  style="width:100%" type="text"   id="amount"       name="amount[]"        class="form-control form-control-sm total"   value="0" readonly></td>
                                           
                                            <td><a href="javascript:void(0)" class="text-primary font-18" title="Add" id="addBtn"><i class="fa fa-plus-circle"></i></a></td>
                                        </tr>

                                     <!--   <tr>

                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right">Total</td>
                                            <td>
                                                <input class="form-control text-right total" type="text" id="sum_total" name="total" value="0" readonly>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr> -->

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
                                           {{ ucfirst(Session::get('nomauth')) }} {{ ucfirst(Session::get('prenomauth')) }} 
                                        </td>
                                        <td>
                                            <select type="text" class="form-control form-control-sm" name="comptable" id="comptable">
                                                <option value="">--Sélectionnez comptable--</option>
                                                @foreach ($comptable as $comptables)
                                                <option value="{{ $comptables->id }}">{{ $comptables->nom }} {{ $comptables->prenom }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select type="text" class="form-control form-control-sm" name="chefcomposante" id="chefcomposante">
                                                <option value="">--Sélectionnez Chef de Composante/Projet/Section--</option>
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
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="addfebbtn" name="addfebbtn"><i class="fa fa-check-circle"></i> Sauvegarder</button>
            </div>
            </form>
        </div>
    </div>
</div>