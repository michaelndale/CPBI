{{-- new element modal --}}
<div class="modal fade" id="addDealModal" tabindex="-1" role="dialog" aria-labelledby="addDealModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <form id="addform" autocomplete="off">
                @method('post')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle"> Nouvelle carnet de bord.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4 col-lg-12 col-xl-4">
                            <label class="text-1000 fw-bold mb-2">Service </label>
                            <select class="form-control" id="service" name="service"  required />
                              <option disabled="true" selected="true">Séléctionner la service</option>
                              @foreach ($service as $services)
                                <option value="{{ $services->id }}">{{ $services->title }}</option>
                              @endforeach
                            </select>
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-4">
                            <label class="text-1000 fw-bold mb-2">Véhicule </label>
                            <select class="form-control" id="vehicule" name="vehicule"  required />
                              <option disabled="true" selected="true">Séléctionner le véhicule</option>
                              @foreach ($vehicule as $vehicules)
                                <option value="{{ $vehicules->matricule }}">{{ $vehicules->matricule }}</option>
                              @endforeach
                            </select>
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-4">
                            <label class="text-1000 fw-bold mb-2">Chef de mission </label>
                            <select class="form-control" id="chefmission" name="chefmission" required />
                              <option disabled="true" selected="true">Séléctionner le chef de mission</option>
                              @foreach ($personnel as $personnels)
                                <option value="{{ $personnels->userid }}">{{ ucfirst($personnels->nom) }} {{ ucfirst($personnels->prenom) }}</option>
                              @endforeach
                            </select>
                        </div>

                        <div class="col-sm-6 col-lg-12 col-xl-8">
                            <label class="text-1000 fw-bold mb-2"> Programme, Projet ou Unité</label>
                            <select class="form-select" id="projetid" name="projetid"  placeholder="Entrer projet" required>
                                <option disabled="true" selected="true" value=""> -- Sélectionner l'option -- </option>
                                @forelse ($projet as $projets)
                                <option value="{{ $projets->id }}"> {{ ucfirst($projets->title) }}</option>
                                @empty
                                <option disabled="true" selected="true">--Aucun projet--</option>
                                @endforelse

                            </select>
                        </div>
                        
                        <div class="col-sm-4 col-lg-12 col-xl-4">
                            <label class="text-1000 fw-bold mb-2">Ituneraire </label>
                            <input class="form-control" id="ituneraire" name="ituneraire" type="text" placeholder="Ituneraire" required />
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-9">
                            <label class="text-1000 fw-bold mb-2">Object de la mission</label>
                            <input class="form-control" id="object" name="object" type="text"  placeholder="Object de la mission" required />
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Date jour</label>
                            <input class="form-control" id="datejour" name="datejour" type="date" required />
                        </div>


                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2"> Kilometrage parcourus</label>
                            <input class="form-control" id="kilometrage" name="kilometrage" type="text" placeholder="kilometrage" required />
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Carburant littre</label>
                            <input class="form-control" id="carburant" name="carburant" type="text" placeholder="Carburant littre" required />
                        </div>
                      
                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Index de depart</label>
                            <input class="form-control" id="indexdepart" name="indexdepart" type="text"  placeholder="Index de depart" required />
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Index de retour</label>
                            <input class="form-control" id="indexretour" name="indexretour" type="text"  placeholder="Index de retour" required />
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal"><i class="fa fa-times-circle"></i> Fermer </button>
                    <button type="submit" id="btnsave" name="btnsave" class="btn btn-primary waves-effect waves-light"> <i class="fa fa-check-circle"></i> Save changes</button>
                </div>

            </form>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
{{-- Fin vehicule --}}


{{-- edit element modal --}}
<div class="modal fade" id="EditDealModal" tabindex="-1" role="dialog" aria-labelledby="EditDealModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <form id="Editform" autocomplete="off">
                @method('post')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle"> Modification du carnet de bord.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4 col-lg-12 col-xl-4">
                        <input class="form-control" id="idc" name="idc" type="hidden"  required />
                            <label class="text-1000 fw-bold mb-2">Service </label>
                            <select class="form-control" id="cservice" name="cservice"  required />
                              <option disabled="true" selected="true">Séléctionner la service</option>
                              @foreach ($service as $services)
                                <option value="{{ $services->id }}">{{ $services->title }}</option>
                              @endforeach
                            </select>
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-4">
                            <label class="text-1000 fw-bold mb-2">Véhicule </label>
                            <select class="form-control" id="cvehicule" name="cvehicule"  required />
                              <option disabled="true" selected="true">Séléctionner le véhicule</option>
                              @foreach ($vehicule as $vehicules)
                                <option value="{{ $vehicules->matricule }}">{{ $vehicules->matricule }}</option>
                              @endforeach
                            </select>
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-4">
                            <label class="text-1000 fw-bold mb-2">Chef de mission </label>
                            <select class="form-control" id="cchefmission" name="cchefmission" required />
                              <option disabled="true" selected="true">Séléctionner le chef de mission</option>
                              @foreach ($personnel as $personnels)
                                <option value="{{ $personnels->userid }}">{{ ucfirst($personnels->nom) }} {{ ucfirst($personnels->prenom) }}</option>
                              @endforeach
                            </select>
                        </div>

                        <div class="col-sm-6 col-lg-12 col-xl-8">
                            <label class="text-1000 fw-bold mb-2"> Programme, Projet ou Unité</label>
                            <select class="form-select" id="cprojetid" name="cprojetid"  placeholder="Entrer projet" required>
                                <option disabled="true" selected="true" value=""> -- Sélectionner l'option -- </option>
                                @forelse ($projet as $projets)
                                <option value="{{ $projets->id }}"> {{ ucfirst($projets->title) }}</option>
                                @empty
                                <option disabled="true" selected="true">--Aucun projet--</option>
                                @endforelse

                            </select>
                        </div>
                        
                        <div class="col-sm-4 col-lg-12 col-xl-4">
                            <label class="text-1000 fw-bold mb-2">Ituneraire </label>
                            <input class="form-control" id="cituneraire" name="cituneraire" type="text" placeholder="Ituneraire" required />
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-9">
                            <label class="text-1000 fw-bold mb-2">Object de la mission</label>
                            <input class="form-control" id="cobject" name="cobject" type="text"  placeholder="Object de la mission" required />
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Date jour</label>
                            <input class="form-control" id="cdatejour" name="cdatejour" type="date" required />
                        </div>


                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2"> Kilometrage parcourus</label>
                            <input class="form-control" id="ckilometrage" name="ckilometrage" type="text" placeholder="kilometrage" required />
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Carburant littre</label>
                            <input class="form-control" id="ccarburant" name="ccarburant" type="text" placeholder="Carburant littre" required />
                        </div>
                      
                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Index de depart</label>
                            <input class="form-control" id="cindexdepart" name="cindexdepart" type="text"  placeholder="Index de depart" required />
                        </div>

                        <div class="col-sm-4 col-lg-12 col-xl-3">
                            <label class="text-1000 fw-bold mb-2">Index de retour</label>
                            <input class="form-control" id="cindexretour" name="cindexretour" type="text"  placeholder="Index de retour" required />
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal"><i class="fa fa-times-circle"></i> Fermer </button>
                    <button type="submit" id="cbtnsave" name="cbtnsave" class="btn btn-primary waves-effect waves-light"> <i class="fa fa-check-circle"></i> Save changes</button>
                </div>

            </form>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
{{-- Fin vehicule --}}