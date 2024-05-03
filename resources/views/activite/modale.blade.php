<div class="modal fade" id="addModale" tabindex="-1" aria-labelledby="addModale" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nouvelle activité </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
      </div>
      <div class="modal-body">
        <form class="row g-3 mb-6" method="POST" id="addactiviteForm">
          @method('post')
          @csrf

          <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;name&quot;,&quot;email&quot;,&quot;age&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
            <div class="table-responsive">
              <table class="table table-striped table-sm fs--1 mb-0">
                <tbody class="list">

                  <tr>
                    <td class="align-middle ps-1 name"> Source projet</td>
                    <td class="align-middle email" colspan="4">
                      <input value="{{ Session::get('id') }}" type="hidden" name="projetid" id="projetid">
                      <input value="{{ Session::get('title') }}" class="form-control form-control-sm" disabled>
                    </td>
                  </tr>
                  <tr>
                    <td>Ligne budgétaire</td>
                    <td colspan="4">

                      <div class="col-lg-12">
                        <div class="mb-0">

                          <select class="form-select  select2-search-disable condictionsearch" id="compteid" name="compteid" required>
                            <option>Ligne budgétaire</option>
                            @foreach ($compte as $comptes)
                            <optgroup label="{{ $comptes->libelle }}">
                              @php
                              $idc = $comptes->id ;
                              $res= DB::select("SELECT * FROM comptes WHERE compteid= $idc");
                              @endphp
                              @foreach($res as $re)
                              <option value="{{ $comptes->id }}-{{ $re->id }}">{{ $re->numero }}. {{ $re->libelle }} </option>
                              @endforeach

                            </optgroup>
                            @endforeach

                          </select>

                          <div id="showcondition">

                          </div>

                        </div>

                      </div>
           


            </td>
            </tr>

            <tr>
              <td class="align-middle ps-3 name" style="width:25%">Description detaillee des besoins </td>
              <td class="align-middle email" colspan="6">
                <textarea type="text" class="form-control form-control-sm" name="titre" id="titre" required></textarea>
              </td>
            </tr>


            <tr>
              <td class="align-middle ps-3 name" style="width:10%">Coût estimatif</td>
              <td class="align-middle email" colspan="2">
                <input type="number" class="form-control form-control-sm" name="montant" id="montant" style="width: 100%" required />
              </td>


            </tr>

            <input value="Nouveau" type="hidden" name="etat" id="etat">

            </tbody>
            </table>
          </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="submit" name="addactivitebtn" id="addactivitebtn" class="btn btn-primary px-5 px-sm-15 addactivitebtn"><i class="fa fa-check-circle" ></i> Sauvegarder </button>
    </div>
  </div>
  </form>
</div>
</div>




<div class="modal fade" id="EditModale" tabindex="-1" aria-labelledby="EditModale" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modifier l'activité </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
      </div>
      <div class="modal-body">
        <form class="row g-3 mb-6" method="POST" id="editactiviteForm">
          @method('post')
          @csrf

          <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;name&quot;,&quot;email&quot;,&quot;age&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
            <div class="table-responsive">
              <table class="table table-striped table-sm fs--1 mb-0">
                <tbody class="list">

                  <tr>
                    <td class="align-middle ps-1 name"> Source projet</td>
                    <td class="align-middle email" colspan="4">
                      <input type="hidden" class="form-control" name="aid" id="aid" />
                      <input value="{{ Session::get('id') }}" type="hidden" name="projetide" id="projetide">
                      <input value="{{ Session::get('title') }}" class="form-control form-control-sm" style="width: 100%; background-color:#c0c0c0" readonly>
                    </td>
                  </tr>
                  <tr>
                    <td>Ligne budgetaire </td>
                    <td colspan="4">
                    <div class="col-lg-12">
                        <div class="mb-0">
                        <input type="text" class="form-control form-control-sm" id="libelle" name="libelle" style="width: 100%; background-color:#c0c0c0"  readonly/>
                        </div>

                      </div>


                    </td>
                  </tr>

                  <tr>
                    <td class="align-middle ps-3 name" style="width:25%">Description detaillee des besoins </td>
                    <td class="align-middle email" colspan="6">
                      <textarea type="text" class="form-control form-control-sm" name="titreact" id="titreact" style="width: 100%;" ></textarea>
                    </td>
                  </tr>


                  <tr>
                    <td class="align-middle ps-3 name" style="width:10%">Couts estimes </td>
                    <td class="align-middle email" colspan="2">
                      <input type="number" class="form-control form-control-sm" name="montantact" id="montantact" style="width: 100%" />
                    </td>


                  </tr>

                  <tr>
                    <td class="align-middle ps-3 name" style="width:10%">Etat de l'activité</td>
                    <td class="align-middle email" colspan="2">
                      <select type="text" class="form-control" name="etatact" id="etatact" style="width: 100%" />
                      <option>Aucune</option>
                      <option value="Nouveau">Nouveau</option>
                      <option value="Encours">Encours</option>
                      <option value="Terminée">Terminée</option>
                      <option value="Contrainte">Contrainte</option>
                      <option value="Annuler">Annuler</option>
                      </select>
                    </td>


                  </tr>

                </tbody>
              </table>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="editactivitebtn" id="editactivitebtn" class="btn btn-primary px-5 px-sm-15 editactivitebtn"> Sauvegarder </button>
      </div>
    </div>
    </form>
  </div>
</div>









<div class="modal fade TableCommenteModale" id="TableCommenteModale" tabindex="-1" aria-labelledby="TableCommenteModale" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Obsevation </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
      </div>
      <div class="modal-body">



        

        <ul class="list-unstyled chat-list" data-simplebar="init" style="max-height: 415px;">
          <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
              <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
              <div class="simplebar-offset" style="right: -20px; bottom: 0px;">
                <div class="simplebar-content-wrapper" style="height: auto; padding-right: 20px; padding-bottom: 0px; overflow: hidden scroll;">
                  <div class="simplebar-content" style="padding: 0px;" id="showAllcommente">


                   





                  </div>
                </div>
              </div>
            </div>
            <div class="simplebar-placeholder" style="width: auto; height: 591px;"></div>
          </div>
          <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
          </div>
          <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar" style="height: 301px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
          </div>
        </ul>
      </div>

    

    </div>

  </div>

</div>
</div>


<div class="modal fade" id="AddObserve" tabindex="-1" aria-labelledby="AddObserve" style="display: none;" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ajouter obsevation </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
      </div>
      <div class="modal-body">
        <form class="row g-3 mb-6" method="POST" id="AddCommenteForm">
          @method('post')
          @csrf
          <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;name&quot;,&quot;email&quot;,&quot;age&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">

            <input type="hidden" class="form-control idact" name="idact" id="idact" />
            <input value="{{ Session::get('id') }}" type="hidden" name="projetidcomment" id="projetidcommente">
            <textarea type="text" class="form-control" name="messageob" id="messageob" style="height:150px"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="Addcommentebtn" id="Addcommentebtn" class="btn btn-primary px-5 px-sm-15 Addcommentebtn"> Sauvegarder </button>
      </div>
    </div>
    </form>
  </div>
</div>