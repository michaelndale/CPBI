<div class="modal fade" id="addfebModal" tabindex="-1" aria-labelledby="addfebModal"  aria-hidden="true" >
<div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">FICHE D’EXPRESSION DES BESOINS "FEB" </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg><!-- <span class="fas fa-times fs--1"></span> Font Awesome fontawesome.com --></button>
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
                                        <input value="{{ Session::get('id') }} " type="hidden" name="projetid" id="projetid" >
                                        <input value="{{ Session::get('title') }} " class="form-control" disabled  >     
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle ps-3 name">Activité</td>
                                    <td class="align-middle email" colspan="6">
                                        <select type="text" class="form-control" name="activityid" id="activityid" style="width: 100%">
                                        <option value="">--Aucun--</option>
                                        @forelse ($activite as $activites)
                                            <option value="{{ $activites->id }}"> {{ $activites->titre }} </option>
                                        @empty
                                        <option value="">--Aucun activite trouver--</option>
                                        @endforelse
                                    </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle ps-3 name">Numéro fiche </td>
                                    <td class="align-middle email">
                                        <input type="text" class="form-control" name="numerofeb" id="numerofeb" style="width: 100%">
                                        <small id="numerofeb_error" name="numerofeb_error" class="text text-danger" ></small>
                                    </td>
                                    <td class="align-middle ps-3 name">Période:</td>
                                    <td class="align-middle email">
                                        <input type="text" class="form-control" name="periode" id="periode" style="width: 100%">
                                    </td>

                                    <td class="align-middle ps-3 name">Date:</td>
                                    <td class="align-middle email">
                                        <input type="text" class="form-control" name="datefeb" id="datefeb" style="width: 100%">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle ps-3 name">Ligne budgétaire:    </td>
                                    <td class="align-middle email" colspan="3">
                                    <div class="col-sm-12 col-md-12">
                                        <div class="form-floating">
                                        <select class="form-select" id="ligneid" name="ligneid" required  onchange="soldeligne(this.value);">
                                            <option selected="selected" value="">Ligne budgetaire</option> 
                                            @foreach ($compte as $comptes)
                                                <option value="{{ $comptes->id }}"> {{ $comptes->numero }}. {{ $comptes->libelle }} </option>
                                                @php
                                                    $idc = $comptes->id ;
                                                    $res= DB::select("SELECT * FROM comptes  WHERE compteid= $idc");
                                                @endphp
                                                @foreach($res as $re)
                                                    <option value="{{ $re->id }}" > {{ $re->numero }}. {{ $re->libelle }}  </option>
                                                @endforeach 
                                            @endforeach
                                        </select>
                                        
                                        <label for="floatingInputGrid">Ligne budgetaire</label></div>
                                    </div>

                                      
                                    </td>
                                    <td class="align-middle ps-3 name" style="width:20%"> 
                                        <input type="text" class="form-control" value="100 0000" readonly>
                                    </td>
                                    <td class="align-middle email">
                                    Taux d’exécution: 100% 
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle ps-3 name">BC:</td>
                                    <td class="align-middle email">
                                        <input type="text" class="form-control" name="bc" id="bc" style="width: 100%">
                                    </td>

                                    <td class="align-middle ps-3 name">Facture:</td>
                                    <td class="align-middle email">
                                        <input type="text" class="form-control" name="facture" id="facture" style="width: 100%">
                                    </td>

                                    <td class="align-middle ps-3 name">O.M:</td>
                                    <td class="align-middle email">
                                        <input type="text" class="form-control" name="om" id="om" style="width: 100%">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    <hr>
                    <div class="table-repsonsive">
                        <span id="error"></span>
                            <table class="table table-striped table-sm fs--1 mb-0" id="item_table">
                                <tr>
                                    <th style="width:5%">N<sup>O</sup></th>
                                    <th>Description</th>
                                    <th style="width:20%">Montant</th>
                                    <th style="width:5% ;"><a href="javascript::;" type="button" name="add" class="btn btn-success btn-sm add"><i class="fas fa-plus"></i></></th>
                                </tr>
                            </table>
                            <table class="table table-striped table-sm fs--1 mb-0" >
                                <tr>
                                    <td><input type="text" name="" id="" class="form-control"  /></td>
                                    <td><input type="text" name="" id="" class="form-control" /></td>
                                    <td><input type="text" name="" id="" class="form-control"  /></td>
                                </tr>
                            </table>
                                <hr>
                                <table class="table table-striped table-sm fs--1 mb-0" >
                                    <tr>
                                    <tr>
                                        <td>Etablie par (AC/CE/CS) </td>
                                        <td>Vérifiée par (Comptable)</td>
                                        <td>Approuvée par (Chef de Composante/Projet/Section):</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select type="text" class="form-control" name="acce" id="acce">
                                                <option value="">--Selectionnez personnel--</option>
                                                @foreach ($personnel as $personnels)
                                                    <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                        <select type="text" class="form-control" name="comptable" id="comptable">
                                            <option value="">--Selectionnez personnel--</option>
                                            @foreach ($personnel as $personnels)
                                                <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
                                            @endforeach
                                        </select>
                                                </td>
                                        <td>
                                            <select type="text" class="form-control" name="chefcomposante" id="chefcomposante">
                                                <option value="">--Selectionnez personnel--</option>
                                                    @foreach ($personnel as $personnels)
                                                        <option value="{{ $personnels->id }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>  
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
                    <button type="submit"  class="btn btn-primary" id="addfebbtn" name="addfebbtn" >Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>
