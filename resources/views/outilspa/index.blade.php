@extends('layout/app')
@section('page-content')

<style type="text/css">
  .has-error {
    border: 1px solid red;
  }
</style>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12" style="margin:auto">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="fa fa-users"></i> Outils gestion Parc automobile </h4>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">Type véhicule</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                    <span class="d-none d-sm-block">Type Carburant</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab">
                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                    <span class="d-none d-sm-block">Type de statut véhicule</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#settings1" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                    <span class="d-none d-sm-block">Fournisseurs</span>
                  </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#piece" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                    <span class="d-none d-sm-block">Pièces</span>
                  </a>
                </li>
              </ul>

              <!-- Tab panes -->
              <div class="tab-content p-3 text-muted">
                <div class="tab-pane active" id="home1" role="tabpanel">
                  <div class="row">
                    <div class="col-12" style="margin:auto">
                      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h6 class="mb-sm-0"><i class="fa fa-car"></i> Type de véhicule </h6>

                        <div class="page-title-right">
                          <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addtypeModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau type de véhicule</a>

                        </div>

                      </div>
                    </div>
                  </div>

                  <table class="table table-bordered  table-sm fs--1 mb-0">
                    <thead>
                      <tr style="background-color:#82E0AA">
                        <th style="width:5%">#</th>
                        <th>Libellé</th>
                        <th style="width:25%">
                          <center>Action</center>
                        </th>
                      </tr>
                    </thead>
                    <tbody id="showAllType">
                      <tr>
                        <td colspan="3">
                          <h5 class="text-center text-secondery my-5">
                            @include('layout.partiels.load')
                        </td>
                      </tr>
                    </tbody>
                    </tbody>
                  </table>

                  <div class="modal fade" id="addtypeModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                      <form id="add_type_form" autocomplete="off">
                        @method('post')
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-car"></i> Nouveau type de véhicule</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <label class="text-1000 fw-bold mb-2">Titre</label>
                            <input class="form-control" name="titre" id="titre" type="text" placeholder="Entrer le titre" required />
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="sendType" id="sendType" value="Sauvegarder" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>


                  {{-- Edit Titre modal --}}
                  <div class="modal fade" id="editTypeModal" tabindex="-1" aria-labelledby="editTypeModal" aria-hidden="true">
                    <div class="modal-dialog">
                      <form autocomplete="off" id="edit_type_form">
                        @method('post')
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-edit"></i> Modification type véhicule</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <label class="text-1000 fw-bold mb-2">Titre</label>
                            <input type="hidden" name="tid" id="tid">
                            <input class="form-control" name="ttitre" id="ttitre" type="text" placeholder="Entrer dossier" required />
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="edittypebtn" id="edittypebtn" value="Sauvegarder" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                </div>
                <div class="tab-pane" id="profile1" role="tabpanel">
                  <div class="row">
                    <div class="col-12" style="margin:auto">
                      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h6 class="mb-sm-0"><i class="fa fa-stopwatch"></i> Type carburant </h6>

                        <div class="page-title-right">
                          <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addcarburentModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau carburant</a>

                        </div>

                      </div>
                    </div>
                  </div>

                  <table class="table table-bordered  table-sm fs--1 mb-0">
                    <thead>
                      <tr style="background-color:#82E0AA">
                        <th style="width:5%">#</th>
                        <th>Libellé</th>
                        <th style="width:25%">
                          <center>Action</center>
                        </th>
                      </tr>
                    </thead>
                    <tbody id="showcarburent">
                      <tr>
                        <td colspan="3">
                          <h5 class="text-center text-secondery my-5">
                            @include('layout.partiels.load')
                        </td>
                      </tr>
                    </tbody>
                    </tbody>
                  </table>

                  <div class="modal fade" id="addcarburentModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                      <form id="add_carburent_form" autocomplete="off">
                        @method('post')
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-stopwatch"></i> Nouveau carburant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <label class="text-1000 fw-bold mb-2">Titre</label>
                            <input class="form-control" name="libellec" id="libellec" type="text" placeholder="Entrer le titre" required />
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="sendCar" id="sendCar" value="Sauvegarder" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>


                  {{-- Edit Titre modal --}}
                  <div class="modal fade" id="editCarModal" tabindex="-1" aria-labelledby="editCarModal" aria-hidden="true">
                    <div class="modal-dialog">
                      <form autocomplete="off" id="edit_carburent_form">
                        @method('post')
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-edit"></i> Modification carburant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <label class="text-1000 fw-bold mb-2">Titre</label>
                            <input type="hidden" name="cid" id="cid">
                            <input class="form-control" name="clibelle" id="clibelle" type="text" placeholder="Entrer dossier" required />
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="editcarbtn" id="editcarbtn" value="Sauvegarder" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>



                </div>


                <div class="tab-pane" id="messages1" role="tabpanel">
                  <div class="row">
                    <div class="col-12" style="margin:auto">
                      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h6 class="mb-sm-0"><i class="fa fa-stopwatch"></i> Statut du véhicule </h6>

                        <div class="page-title-right">
                          <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addStatutModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau statut du véhicule</a>

                        </div>

                      </div>
                    </div>
                  </div>

                  <table class="table table-bordered  table-sm fs--1 mb-0">
                    <thead>
                      <tr style="background-color:#82E0AA">
                        <th style="width:5%">#</th>
                        <th>Libellé</th>
                        <th style="width:25%">
                          <center>Action</center>
                        </th>
                      </tr>
                    </thead>
                    <tbody id="showstatut">
                      <tr>
                        <td colspan="3">
                          <h5 class="text-center text-secondery my-5">
                            @include('layout.partiels.load')
                        </td>
                      </tr>
                    </tbody>
                    </tbody>
                  </table>

                  <div class="modal fade" id="addStatutModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                      <form id="add_statut_form" autocomplete="off">
                        @method('post')
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-stopwatch"></i> Nouveau statut véhicule</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <label class="text-1000 fw-bold mb-2">Titre</label>
                            <input class="form-control" name="s_titre" id="s_titre" type="text" placeholder="Entrer le titre" required />
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="sendStatut" id="sendStatut" value="Sauvegarder" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>


                  {{-- Edit Titre modal --}}
                  <div class="modal fade" id="editStatutModal" tabindex="-1" aria-labelledby="editStatutModal" aria-hidden="true">
                    <div class="modal-dialog">
                      <form autocomplete="off" id="edit_statut_form">
                        @method('post')
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-edit"></i> Modification carburant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <label class="text-1000 fw-bold mb-2">Titre</label>
                            <input type="hidden" name="id_s" id="id_s">
                            <input class="form-control" name="titre_s" id="titre_s" type="text" placeholder="Entrer titre" required />
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="editstatutbtn" id="editstatutbtn" value="Sauvegarder" class="btn btn-primary"> <i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>


                </div>


                <div class="tab-pane" id="settings1" role="tabpanel">
                  <div class="col-12" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                      <h6 class="mb-sm-0"><i class="fa fa-users"></i> Fournisseurs </h6>

                      <div class="page-title-right">
                        <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addfournisseurModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouveau fournisseur</a>
                      </div>

                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-sm fs--1 mb-0">
                      <thead>
                        <tr style="background-color:#82E0AA">
                          <th class="align-middle ps-3 name">#</th>
                          <th>Nom</th>
                          <th>Adresse</th>
                          <th>Téléphone</th>
                          <th>Email</th>
                          <th>Type</th>
                          <th><center>Action</center> </th>
                        </tr>
                      </thead>
                      <tbody id="show_all_fournisseur">
                        <tr>
                          <td colspan="11">
                            <h5 class="text-center text-secondery my-5">
                              @include('layout.partiels.load')
                          </td>
                        </tr>
                      </tbody>
                      </tbody>
                    </table>
                  </div>

                  <div class="modal fade" id="addfournisseurModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                      <form id="addfournisseurForm" autocomplete="off">
                        @method('post')
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-plus"></i> Nouveau fournisseur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-sm-6 col-md-6">
                                <div class="form-floating mb-1">
                                  <input class="form-control" id="nomF" name="nomF" type="text" required="required" placeholder="Identifiant" />
                                  <label for="Identifiant">Nom</label>

                                </div>
                              </div>
                              <div class="col-sm-6 col-md-6">
                                <div class="form-floating mb-1">
                                  <input class="form-control" id="adresseF" type="text" name="adresseF" required="required" placeholder="Password" />
                                  <label for="Password">Adresse</label>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-6 col-md-6">
                                <div class="form-floating mb-1">
                                  <input class="form-control" id="emailF" type="text" name="emailF" required="required" placeholder="Téléphone" />
                                  <label for="Password">Email </label>
                                </div>
                              </div>
                              <div class="col-sm-6 col-md-6">
                                <div class="form-floating mb-1">
                                  <input class="form-control" id="phoneF" type="text" name="phoneF" required="required" placeholder="Téléphone" />
                                  <label for="Password">Téléphone </label>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-12 col-md-12">
                                <div class="form-floating mb-1">
                                  <input class="form-control" id="typeF" name="typeF" type="text" required="required" placeholder="Type" />
                                  <label for="email">Type Fournisseur</label>

                                </div>
                              </div>



                            </div>


                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="addFbtn" id="addFbtn" class="btn btn-primary"><i class="fas fa-check-circle"></i> Sauvegarder</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  <div class="modal fade" id="editFournisseurModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                      <form id="editfournisseurForm" autocomplete="off">
                        @method('post')
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-edit"></i> Modification fournisseur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-sm-6 col-md-6">
                                <div class="form-floating mb-1">
                                  <input class="form-control" id="idFo" name="idFo" type="hidden"  />
                                  <input class="form-control" id="nomFo" name="nomFo" type="text" required="required" placeholder="Nom" />
                                  <label for="Nom">Nom</label>
                                </div>
                              </div>
                              <div class="col-sm-6 col-md-6">
                                <div class="form-floating mb-1">
                                  <input class="form-control" id="adresseFo" type="text" name="adresseFo" required="required" placeholder="Adresse" />
                                  <label for="Adresse">Adresse</label>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-6 col-md-6">
                                <div class="form-floating mb-1">
                                  <input class="form-control" id="emailFo" type="text" name="emailFo" required="required" placeholder="Email" />
                                  <label for="Email">Email </label>
                                </div>
                              </div>
                              <div class="col-sm-6 col-md-6">
                                <div class="form-floating mb-1">
                                  <input class="form-control" id="phoneFo" type="text" name="phoneFo" required="required" placeholder="Téléphone" />
                                  <label for="Téléphone">Téléphone </label>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-12 col-md-12">
                                <div class="form-floating mb-1">
                                  <input class="form-control" id="typeFo" name="typeFo" type="text" required="required" placeholder="Type Fournisseur" />
                                  <label for="Type Fournisseur">Type Fournisseur</label>
                                </div>
                              </div>
                            </div>

                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="EditFobtn" id="EditFobtn" class="btn btn-primary"><i class="fas fa-check-circle"></i> Sauvegarder</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                </div>

                <div class="tab-pane" id="piece" role="tabpanel">
                  <div class="col-12" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                      <h6 class="mb-sm-0"><i class="fa fa-car"></i> Pièces</h6>

                      <div class="page-title-right">
                        <a href="javascript:voide();" data-bs-toggle="modal" data-bs-target="#addpieceModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouvelle pièce</a>

                      </div>

                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-bordered table-sm fs--1 mb-0">
                      <thead>
                        <tr style="background-color:#82E0AA">
                          <th class="align-middle ps-3 name">#</th>
                          <th>Nom</th>
                          <th>Numéro</th>
                          <th>Fournisseur</th>
                          <th>Prix </th>
                          <th>Date Prix</th>
                          <th>Constructeur</th>
                          <th><center>Action</center></th>
                        </tr>
                      </thead>
                      <tbody id="show_all_piece">
                        <tr>
                          <td colspan="11">
                            <h5 class="text-center text-secondery my-5">
                              @include('layout.partiels.load')
                          </td>
                        </tr>
                      </tbody>
                      </tbody>
                    </table>
                  </div>

                  <div class="modal fade" id="addpieceModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                      <form id="addpieceForm" autocomplete="off">
                        @method('post')
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-plus"></i> Nouveau pièce</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-sm-12 col-md-12">
                              <label for="Password">Fournisseurs </label>
                                  <select class="form-control selectfournisseur" id="fournisseurP" name="fournisseurP" type="text" required="required" placeholder="Identifiant" />
                                    <option> Select</option>
                                  </select>
                              </div>
                              <br>
                             
                            </div>

                            <div class="row">
                              <div class="col-sm-6 col-md-6">
                              <label for="Password">Nom </label>
                                  <input class="form-control" id="nomP" type="text" name="nomP" required="required" placeholder="Nom" />
                              </div>
                              <br>
                              <div class="col-sm-6 col-md-6">
                              <label for="Password">Numéro </label>
                                  <input class="form-control" id="numeroP" type="text" name="numeroP" required="required" placeholder="Numéro" />
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-6 col-md-6">
                              <label for="email">Prix</label>
                                  <input class="form-control" id="prixP" name="prixP" type="text" required="required" placeholder="Prix" />
                              </div>


                              <div class="col-sm-6 col-md-6">
                              <label for="email">Dape prix</label>
                                  <input class="form-control" id="dateprixP" name="dateprixP" type="date" required="required" placeholder="Date prix" />
                              </div>

                              <div class="col-sm-12 col-md-12">
                              <label for="email">Contructeur</label>
                                  <input class="form-control" id="constructeurP" name="constructeurP" type="text" required="required" placeholder="Constructeur" />
                              
                              </div>




                            </div>


                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="addPbtn" id="addPbtn" class="btn btn-primary"><i class="fas fa-check-circle"></i> Sauvegarder</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  <div class="modal fade" id="editpieceModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                      <form id="editpieceForm" autocomplete="off">
                        @method('post')
                        @csrf
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-edit"></i> Modifier pièce</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-sm-12 col-md-12">
                              <label for="Password">Fournisseurs </label>
                              <input class="form-control" id="ippi" type="hidden" name="ippi"  />
                                  <select class="form-control selectfournisseur" id="fournisseurPi" name="fournisseurPi" type="text" required="required" placeholder="Identifiant" />
                                    <option> Select</option>
                                  </select>
                              </div>
                              <br>
                             
                            </div>

                            <div class="row">
                              <div class="col-sm-6 col-md-6">
                              <label for="Password">Nom </label>
                                  <input class="form-control" id="nomPi" type="text" name="nomPi" required="required" placeholder="Nom" />
                              </div>
                              <br>
                              <div class="col-sm-6 col-md-6">
                              <label for="Password">Numéro </label>
                                  <input class="form-control" id="numeroPi" type="text" name="numeroPi" required="required" placeholder="Numéro" />
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-sm-6 col-md-6">
                              <label for="email">Prix</label>
                                  <input class="form-control" id="prixPi" name="prixPi" type="text" required="required" placeholder="Prix" />
                              </div>


                              <div class="col-sm-6 col-md-6">
                              <label for="email">Dape prix</label>
                                  <input class="form-control" id="dateprixPi" name="dateprixPi" type="date" required="required" placeholder="Date prix" />
                              </div>

                              <div class="col-sm-12 col-md-12">
                              <label for="email">Contructeur</label>
                                  <input class="form-control" id="constructeurPi" name="constructeurPi" type="text" required="required" placeholder="Constructeur" />
                              
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="editPbtn" id="editPbtn" class="btn btn-primary"><i class="fas fa-check-circle"></i> Sauvegarder</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>


                </div>
              </div>

            </div>
          </div>
        </div>

      </div>

    </div>
  </div> <!-- container-fluid -->
  <br><br> <br><br> <br><br> <br><br>
</div>
</div>
<script>
  $(function() {

    // Add department ajax 
    $("#add_type_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#sendType").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("sendType").disabled = true;

      $.ajax({
        url: "{{ route('storetype') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Enregistrement reussi avec succès !", "Enregistrement");
            fetchtype();

            $("#sendType").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#add_type_form")[0].reset();
            $("#addtypeModal").modal('hide');
            document.getElementById("sendType").disabled = false;
          }

          if (response.status == 201) {
            toastr.error("Type existe déjà !", "Erreur");
            $("#sendType").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addtypeModal").modal('show');
            document.getElementById("sendType").disabled = false;
          }
        }

      });
    });

    // Ajouter carburent
    $("#add_carburent_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#sendCar").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("sendType").disabled = true;

      $.ajax({
        url: "{{ route('storecarburent') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Enregistrement reussi avec succès !", "Enregistrement");

            fetchcarburent();

            $("#sendCar").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#add_carburent_form")[0].reset();
            $("#addcarburentModal").modal('hide');
            document.getElementById("sendType").disabled = false;
          }

          if (response.status == 201) {
            toastr.error("Titre carburant existe déjà !", "Erreur");
            $("#sendCar").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addcarburentModal").modal('show');
            document.getElementById("sendCar").disabled = false;
          }
        }

      });
    });

    // Ajouter statut
    $("#add_statut_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#sendStatut").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("sendStatut").disabled = true;

      $.ajax({
        url: "{{ route('storestatut') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Enregistrement reussi avec succès !", "Enregistrement");

            fetchstatut();

            $("#sendStatut").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#add_statut_form")[0].reset();
            $("#addStatutModal").modal('hide');
            document.getElementById("sendStatut").disabled = false;
          }

          if (response.status == 201) {
            toastr.error("Statut existe déjà !", "Erreur");
            $("#sendStatut").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addStatutModal").modal('show');
            document.getElementById("sendStatut").disabled = false;
          }
        }

      });
    });

    // Ajouter statut
    $("#addfournisseurForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#addFbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("addFbtn").disabled = true;

      $.ajax({
        url: "{{ route('storefournisseur') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Enregistrement reussi avec succès !", "Enregistrement");

            fetchfournisseur();
            selectfournisseur();

            $("#addFbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#add_statut_form")[0].reset();
            $("#addfournisseurModal").modal('hide');
            document.getElementById("addFbtn").disabled = false;
          }

          if (response.status == 202) {
            toastr.error("Fournisseur existe déjà !", "Erreur");
            $("#addFbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addfournisseurModal").modal('show');
            document.getElementById("addFbtn").disabled = false;
          }
        }

      });
    });

     // Ajouter piece
     $("#addpieceForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#addPbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("addPbtn").disabled = true;

      $.ajax({
        url: "{{ route('storepiece') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Enregistrement reussi avec succès !", "Enregistrement");
            fetchpiece();
            $("#addPbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addpieceForm")[0].reset();
            $("#addpieceModal").modal('hide');
            document.getElementById("addPbtn").disabled = false;
          }

          if (response.status == 202) {
            toastr.error("Pièce existe déjà !", "Erreur");
            $("#addPbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#addpieceModal").modal('show');
            document.getElementById("addPbtn").disabled = false;
          }
        }

      });
    });

    // Recuperation Type ajax request
    $(document).on('click', '.editType', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('edittype') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#ttitre").val(response.libelle);
          $("#tid").val(response.id);
        }
      });
    });

    // Recuperation carburant ajax request
    $(document).on('click', '.editcarburent', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('editcarburent') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#clibelle").val(response.libelle);
          $("#cid").val(response.id);
        }
      });
    });

    // Recuperation statut
    $(document).on('click', '.editStatut', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('editstatut') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#titre_s").val(response.titre);
          $("#id_s").val(response.id);
        }
      });
    });

    // recuperation statut
    $(document).on('click', '.editfournisseur', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('editfournisseur') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#nomFo").val(response.nom);
          $("#adresseFo").val(response.adresse);
          $("#emailFo").val(response.email);
          $("#phoneFo").val(response.phone);
          $("#typeFo").val(response.type);
          $("#idFo").val(response.id);
        }
      });
    });

    // recuperation statut
    $(document).on('click', '.editpiece', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('editpiece') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#nomPi").val(response.nom);
          $("#numeroPi").val(response.numero);
          $("#prixPi").val(response.prix);
          $("#dateprixPi").val(response.dateprix);
          $("#constructeurPi").val(response.constructeur);
          $("#ippi").val(response.id);
        }
      });
    });


    // Update type ajax request
    $("#edit_type_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#edittypebtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("edittypebtn").disabled = true;

      $.ajax({
        url: "{{ route('updatetype') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Modification reussi avec succès !", "Modification");
            fetchtype();
            fetchcarburent();

            $("#edittypebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#edit_type_form")[0].reset();
            $("#editTypeModal").modal('hide');
            document.getElementById("edittypebtn").disabled = false;
          }

          if (response.status == 201) {
            toastr.error("Type de véhicule existe déjà !", "Erreur");
            $("#edittypebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#editTypeModal").modal('show');
            document.getElementById("edittypebtn").disabled = false;
          }

          if (response.status == 203) {
            toastr.error("Erreur d'exécution: " + response.error, "Erreur");
            $("#editTypeModal").modal('show');
            $("#edittypebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("edittypebtn").disabled = false;
          }

          if (response.status == 205) {
            toastr.error("Vous n'avez pas l'accreditation de Type de véhicule!", "Erreur");
            $("#editTypeModal").modal('show');
            $("#edittypebtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("edittypebtn").disabled = false;
          }

        }
      });
    });

    // Update carburent ajax request
    $("#edit_carburent_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#editcarbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("editcarbtn").disabled = true;

      $.ajax({
        url: "{{ route('updatecarburent') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Modification reussi avec succès !", "Modification");
            fetchtype();
            fetchcarburent();

            $("#editcarbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#edit_carburent_form")[0].reset();
            $("#editCarModal").modal('hide');
            document.getElementById("editcarbtn").disabled = false;
          }

          if (response.status == 201) {
            toastr.error("Type de véhicule existe déjà !", "Erreur");
            $("#editcarbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#editCarModal").modal('show');
            document.getElementById("editcarbtn").disabled = false;
          }

          if (response.status == 203) {
            toastr.error("Erreur d'exécution: " + response.error, "Erreur");
            $("#editCarModal").modal('show');
            $("#editcarbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("editcarbtn").disabled = false;
          }

          if (response.status == 205) {
            toastr.error("Vous n'avez pas l'accreditation de Type de véhicule!", "Erreur");
            $("#editCarModal").modal('show');
            $("#editcarbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("editcarbtn").disabled = false;
          }

        }
      });
    });

    // Update statut ajax request
    $("#edit_statut_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#editstatutbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("editstatutbtn").disabled = true;

      $.ajax({
        url: "{{ route('updatestatut') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Modification reussi avec succès !", "Modification");
            fetchstatut();

            $("#editstatutbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#edit_statut_form")[0].reset();
            $("#editStatutModal").modal('hide');
            document.getElementById("editstatutbtn").disabled = false;
          }

          if (response.status == 201) {
            toastr.error("Type de véhicule existe déjà !", "Erreur");
            $("#editstatutbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#editStatutModal").modal('show');
            document.getElementById("editstatutbtn").disabled = false;
          }

          if (response.status == 203) {
            toastr.error("Erreur d'exécution: " + response.error, "Erreur");
            $("#editStatutModal").modal('show');
            $("#editstatutbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("editstatutbtn").disabled = false;
          }

          if (response.status == 205) {
            toastr.error("Vous n'avez pas l'accreditation de Type de véhicule!", "Erreur");
            $("#editStatutModal").modal('show');
            $("#editstatutbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("editstatutbtn").disabled = false;
          }

        }
      });
    });

    // Update fournisseur ajax request
    $("#editfournisseurForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#EditFobtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("EditFobtn").disabled = true;

      $.ajax({
        url: "{{ route('updatefournisseur') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Modification reussi avec succès !", "Modification");
            fetchfournisseur();

            $("#EditFobtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#editfournisseurForm")[0].reset();
            $("#editFournisseurModal").modal('hide');
            document.getElementById("EditFobtn").disabled = false;
          }

          if (response.status == 201) {
            toastr.error("Type de véhicule existe déjà !", "Erreur");
            $("#editstatutbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#editFournisseurModal").modal('show');
            document.getElementById("EditFobtn").disabled = false;
          }

          if (response.status == 203) {
            toastr.error("Erreur d'exécution: " + response.error, "Erreur");
            $("#editFournisseurModal").modal('show');
            $("#EditFobtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("EditFobtn").disabled = false;
          }

          if (response.status == 205) {
            toastr.error("Vous n'avez pas l'accreditation de Type de véhicule!", "Erreur");
            $("#editFournisseurModal").modal('show');
            $("#EditFobtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("EditFobtn").disabled = false;
          }

        }
      });
    });

    // Update fournisseur ajax request
    $("#editpieceForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      $("#editPbtn").html('<i class="fas fa-spinner fa-spin"></i>');
      document.getElementById("editPbtn").disabled = true;
      $.ajax({
        url: "{{ route('updatepieceedit') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Modification reussi avec succès !", "Modification");
            fetchpiece();

            $("#editPbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#editpieceForm")[0].reset();
            $("#editpieceModal").modal('hide');
            document.getElementById("editPbtn").disabled = false;
          }

          if (response.status == 201) {
            toastr.error("Type de véhicule existe déjà !", "Erreur");
            $("#editPbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            $("#editpieceModal").modal('show');
            document.getElementById("editPbtn").disabled = false;
          }

          if (response.status == 203) {
            toastr.error("Erreur d'exécution: " + response.error, "Erreur");
            $("#editpieceModal").modal('show');
            $("#editPbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("editPbtn").disabled = false;
          }

          if (response.status == 205) {
            toastr.error("Vous n'avez pas l'accreditation de Type de pièce!", "Erreur");
            $("#editpieceModal").modal('show');
            $("#editPbtn").html('<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
            document.getElementById("editPbtn").disabled = false;
          }

        }
      });
    });


    // Delete service ajax request
    $(document).on('click', '.deleteType', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Êtes vous sûr de vouloir supprimer?',
        text: "Si vous le faite vous ne pouvez plus revenir en arrière !",

        showCancelButton: true,
        confirmButtonColor: 'Green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer!',
        cancelButtonText: 'Annuler',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('deletetype') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {


              if (response.status == 200) {
                toastr.success("Type de véhicule supprimer avec succès !", "Suppression");
                fetchtype();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de supprimer ce type de véhicule!", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
            }
          });
        }
      })
    });

    // Delete type vehicule
    $(document).on('click', '.deleteCar', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Êtes vous sûr de vouloir supprimer?',
        text: "Si vous le faite vous ne pouvez plus revenir en arrière !",

        showCancelButton: true,
        confirmButtonColor: 'Green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer!',
        cancelButtonText: 'Annuler',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('deletecartburent') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {


              if (response.status == 200) {
                toastr.success("Suppression  avec succès !", "Suppression");
                fetchtype();
                fetchcarburent();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de supprimer ce type de véhicule!", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
            }
          });
        }
      })
    });

    // Delete statut
    $(document).on('click', '.deleteStatut', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Êtes vous sûr de vouloir supprimer?',
        text: "Si vous le faite vous ne pouvez plus revenir en arrière !",

        showCancelButton: true,
        confirmButtonColor: 'Green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer!',
        cancelButtonText: 'Annuler',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('deletestatut') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {


              if (response.status == 200) {
                toastr.success("Suppression  avec succès !", "Suppression");

                fetchstatut();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de supprimer ce type de véhicule!", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
            }
          });
        }
      })
    });

    // Delete Fournisseur
    $(document).on('click', '.deleteFournisseur', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Êtes vous sûr de vouloir supprimer?',
        text: "Si vous le faite vous ne pouvez plus revenir en arrière !",

        showCancelButton: true,
        confirmButtonColor: 'Green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer!',
        cancelButtonText: 'Annuler',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('deletefournisseur') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {


              if (response.status == 200) {
                toastr.success("Suppression  avec succès !", "Suppression");

                fetchfournisseur();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de supprimer ce type de Fournisseur!", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
            }
          });
        }
      })
    });

    // Delete Piece
    $(document).on('click', '.deletePiece', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Êtes vous sûr de vouloir supprimer?',
        text: "Si vous le faite vous ne pouvez plus revenir en arrière !",

        showCancelButton: true,
        confirmButtonColor: 'Green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer!',
        cancelButtonText: 'Annuler',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('deletepiece') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {


              if (response.status == 200) {
                toastr.success("Suppression  avec succès !", "Suppression");

                fetchpiece();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de supprimer ce type de Pièce!", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
            }
          });
        }
      })
    });



    fetchtype();

    function fetchtype() {
      $.ajax({
        url: "{{ route('alltype') }}",
        method: 'get',
        success: function(reponse) {
          $("#showAllType").html(reponse);
        }
      });
    }

    fetchcarburent();

    function fetchcarburent() {
      $.ajax({
        url: "{{ route('allcarburent') }}",
        method: 'get',
        success: function(reponse) {
          $("#showcarburent").html(reponse);
        }
      });
    }

    fetchstatut();

    function fetchstatut() {
      $.ajax({
        url: "{{ route('allstatut') }}",
        method: 'get',
        success: function(reponse) {
          $("#showstatut").html(reponse);
        }
      });
    }

    fetchfournisseur();

    function fetchfournisseur() {
      $.ajax({
        url: "{{ route('allfournisseur') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all_fournisseur").html(reponse);
        }
      });
    }

    selectfournisseur();

    function selectfournisseur() {
      $.ajax({
        url: "{{ route('selectfournisseur') }}",
        method: 'get',
        success: function(reponse) {
          $(".selectfournisseur").html(reponse);
        }
      });
    }

    fetchpiece();

    function fetchpiece() {
      $.ajax({
        url: "{{ route('allpiece') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all_piece").html(reponse);
        }
      });
    }



  });
</script>




@endsection