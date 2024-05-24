<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="archiveForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="verticallyCenteredModalLabel">Nouveau</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-sm-6 col-md-12">
                        <div class="row">
                            <div class="col-sm-3 col-md-12">
                                <div class="form-floating mb-1">
                                    <select class="form-select" id="classeur" name="classeur">
                                        <option value="" selected="selected">Séléctionner classeur</option>
                                        @foreach ($classeur as $classeurs)
                                            <option value="{{ $classeurs->id }}">{{ ucfirst($classeurs->libellec) }}</option>
                                        @endforeach
                                    </select>
                                    <label for="classeur">Classeur</label>
                                </div>
                            </div>
                            <br>
                            <div class="col-sm-3 col-md-12">
                                <div class="form-floating mb-1">
                                    <select class="form-select" id="etiquette" name="etiquette">
                                        <option value="" selected="selected">Séléctionner étiquette</option>
                                    </select>
                                    <label for="etiquette">Étiquette</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-12">
                            <div class="form-floating mb-1">
                                <input class="form-control" id="titre" type="text" name="titre" required="required" placeholder="Titre" />
                                <label for="titre">Titre</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-12">
                            <div class="form-floating mb-1">
                                <input class="form-control" id="file_archive" type="file" name="file_archive" required="required" autocomplete="off" />
                                <label for="file">Choisir le document</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-12">
                            <div class="form-floating mb-1">
                                <textarea class="form-control" id="description" name="description" style="height:60px"></textarea>
                                <label for="description">Résumé</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-md-12">
                            <div class="form-floating mb-1">
                                <br>
                                Comment voulez-vous garder le fichier ?&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="type_public" name="type" value="public" class="form-check-input"> Public&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="type_private" name="type" value="private" class="form-check-input"> Privé
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="addbtn" id="addbtn" class="btn btn-primary">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loadingModalLabel">Téléchargement en cours...</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="progress">
                    <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-success" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-status bg-success"></div>
          <div class="modal-body text-center py-4">
            <!-- Download SVG icon from http://tabler-icons.io/i/circle-check -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-green icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" /></svg>
            <h3>Payment succedeed</h3>
            <div class="text-secondary">Votre document a été soumis avec succès. Votre document a été archivé.</div>
          </div>
          <div class="modal-footer">
            <div class="w-100">
              <div class="row">
                
                <div class="col">
                  <center>
                  <a href="#" id="jesuisok" class="btn btn-success w-50" data-bs-dismiss="modal">
                    Ok
                  </a>
                  </center> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>
