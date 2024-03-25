<div class="modal fade" id="addplanModal" tabindex="-1" aria-labelledby="addplanModal" aria-hidden="true">
    <div class="modal-dialog modal-xl  modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="far fa-file-alt "></i> Fiche plan d'action </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 mb-6" method="POST" id="addplanForm">
                    @method('post')
                    @csrf
                    <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;name&quot;,&quot;email&quot;,&quot;age&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm fs--1 mb-0">
                                <tbody class="list">
                                    <tr>
                                        <td class="align-middle ps-3 name" style="width:10%">Catégorie</td>
                                        <td class="align-middle email"  style="width:75%"> <input class="form-control form-control-sm"  id="categorie" name="categorie" required></td>
                                       
                                        <td class="align-middle ps-3 name" style="width:5%">Période</td>
                                        <td class="align-middle email" style="width:15%"> <input class="form-control form-control-sm"  id="periode" name="periode" type="number" required></td>
                                    </tr>
                                </tbody>
                            </table>

                          

                            <div class="table-responsive">
                                <table class="table table-striped table-sm fs--1 mb-0 table-bordered" id="tableEstimate">
                                    <thead>
                                    <tr>
                                       
                                        <th colspan="12"> <center>Prévision </center></th>
                                    </tr>
                                    
                                    <tr>
                                        <th style="width:50px">Num</th>
                                        <th style="width:300px">Activité</th>
                                        <th style="width:150px">Lieu</th>
                                        <th style="width:180px"> <center> Catégorie des bénéficiaires </center> </th>
                                        <th style="width:50px" colspan="3"><center> Bénéficiaires</center></th>
                                        <th style="width:150px">Nombre des séances</th>
                                        <th style="width:150px" colspan="2">Date fin</th>

                                  
                                     
                                    </tr>
                                    <tr>
                                       
                                        <th colspan="4" style="background-color:#D3D3D3"></th>
                                        <th>Homme</th>
                                        <th>Femme</th>
                                        <th>Total</th>
                                        <th colspan="3" style="background-color:#D3D3D3" ></th>
                                      
                                      
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input  style="width:100%" type="number" id="numero" name="numero[]"  class="form-control form-control-sm"  value="1"></td>
                                            <td><textarea  style="width:100%" type="text" id="activite"         name="activite[]"     class="form-control form-control-sm" required></textarea></td>
                                            <td><input  style="width:100%" type="text"    id="lieu"             name="lieu[]"     class="form-control form-control-sm" required></td>
                                            <td><input  style="width:100%" type="text"  id="categoriebenpre"  name="categoriebenpre[]"           class="form-control form-control-sm"    ></td>
                                            <td><input  style="width:100%" type="number"  min="1"  id="nombrebenpre"     name="nombrebenpre[]"    class="form-control form-control-sm"   ></td>
                                            <td><input  style="width:100%" type="number"  min="1" id="hommebenprev"  name="hommebenprev[]"            class="form-control form-control-sm"   ></td>
                                            <td><input  style="width:100%" type="number"  min="1"    id="femmebenprev"     name="femmebenprev[]"        class="form-control form-control-sm" ></td>
                                            <td><input  style="width:100%" type="number"  min="1"  id="nombreseancepre"     name="nombreseancepre[]"        class="form-control form-control-sm" ></td>
                                            <td><input  style="width:100%" type="date"    id="datefin"     name="datefin[]"        class="form-control form-control-sm" ></td>
                                            <td><a href="javascript:void(0)" class="text-primary font-18" title="Add" id="addBtn"><i class="fa fa-plus-circle"></i></a></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            
                    </div>
            </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="addplanbbtn" name="addplanbtn"><i class="fa fa-check-circle"></i> Sauvegarder</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>

