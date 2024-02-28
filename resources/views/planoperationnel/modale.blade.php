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
                                        <td class="align-middle ps-3 name" style="width:20%">Categorie</td>
                                        <td class="align-middle email" colspan="6">
                                           
                                            <input class="form-control form-control-sm"  id="categorie" name="categorie" required>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <hr>

                            <div class="table-responsive">
                                <table class="table table-striped table-sm fs--1 mb-0 table-bordered" id="tableEstimate">
                                    <thead>
                                    <tr>
                                        <th colspan="4"></th>
                                        <th colspan="3"> <center>Prevision </center></th>
                                        <th colspan="3"><center>Realisation</center></th>
                                    </tr>
                                    
                                    <tr>
                                        <th style="width:50px">Num</th>
                                        <th style="width:300px">Activite</th>
                                        <th style="width:150px">Lieu</th>
                                        <th style="width:100px">Categorie des beneficiaires</th>
                                        <th style="width:50px">Nombre des beneficiaires</th>
                                        <th style="width:150px">Nombre de seances</th>
                                        <th style="width:150px">Reste a la date du jour</th>
                                        <th style="width:50px">Nombre des beneficiaires</th>
                                        <th style="width:150px">Nombre de seances</th>
                                        <th style="width:150px">Resten a la date du jour</th>

                                        <th> </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input  style="width:100%" type="number" id="numero" name="numero[]"  class="form-control form-control-sm"  value="1"></td>
                                            <td><textarea  style="width:100%" type="text" id="activite"         name="activite[]"     class="form-control form-control-sm" required></textarea></td>
                                            <td><input  style="width:100%" type="text"    id="lieu"             name="lieu[]"     class="form-control form-control-sm" required></td>
                                            <td><input  style="width:100%" type="text"  id="categoriebenpre"  name="categoriebenpre[]"           class="form-control form-control-sm"    ></td>
                                            <td><input  style="width:100%" type="number"  id="nombrebenpre"     name="nombrebenpre[]"    class="form-control form-control-sm"   ></td>
                                            <td><input  style="width:100%" type="number"  id="nombreseancepre"  name="nombreseancepre[]"            class="form-control form-control-sm"   ></td>
                                            <td><input  style="width:100%" type="number"    id="restejourpre"     name="restejourpre[]"        class="form-control form-control-sm" ></td>
                                            <td><input  style="width:100%" type="number"    id="nombrebenrev"     name="nombrebenrev[]"        class="form-control form-control-sm" ></td>
                                            <td><input  style="width:100%" type="number"    id="nombreseanrev"    name="nombreseanrev[]"        class="form-control form-control-sm" ></td>
                                            <td><input  style="width:100%" type="number"    id="restejourrev"           name="restejourrev[]"        class="form-control form-control-sm" ></td>
                                            <td><a href="javascript:void(0)" class="text-primary font-18" title="Add" id="addBtn"><i class="fa fa-plus-circle"></i></a></td>
                                        </tr>

                                   
                                     

                                    </tbody>
                                </table>
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

</div>