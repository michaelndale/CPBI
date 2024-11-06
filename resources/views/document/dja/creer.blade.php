@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-12" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> MOdification du DEMANDE ET JUSTIFICATION D'AVANCE (DJA)  </h4>
                        <div class="page-title-right">
                            <div class="btn-toolbar float-end" role="toolbar">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
           
                <form class="needs-validation" novalidate method="POST" id="EditdjdaForm">
                    @method('post')
                    @csrf
              
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-2">
                                                            <label class="form-label">Présumé
                                                                Bénéficiaire/Fournisseur/Prestataire à payer:</label>
                                                             
                                                              
                                                            <input  type="text"  class="form-control form-control-sm" readonly style="background-color:#c0c0c0"/>
                                                        
                                                        </div>
                                                    </div>
                                                    

                                                  
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end card -->
                                    </div> <!-- end col -->

                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Les fonds devront être reçus
                                                                le</label>
                                                            <input name="fond_recu_le" type="date"
                                                                class="form-control form-control-sm"  />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Référence (s) : FEB Nº</label>
                                                            
                                                            <input  type="text" name=""  class="form-control form-control-sm" readonly style="background-color:#c0c0c0"/>
                                                        

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">DAP Nº</label>
                                                            <input  type="text"
                                                                class="form-control form-control-sm" readonly style="background-color:#c0c0c0"/>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">OV/CHQ Nº</label>
                                                            
                                                            <input name="ovcheque" type="text"
                                                                class="form-control form-control-sm"  readonly style="background-color:#c0c0c0"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Ligne budgétaire: </label>
                                                          
                                                            <input name="ligne_budgetaire" type="text"
                                                                class="form-control form-control-sm"  readonly style="background-color:#c0c0c0"/>

                                                        </div>
                                                    </div>


                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Montant de l'avance :</label>
                                                            <input name="montant_avance_un" type="text" 
                                                                class="form-control form-control-sm" />

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Dévise </label>
                                                            <input name="devise" type="text"
                                                                class="form-control form-control-sm"  readonly style="background-color:#c0c0c0"/>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Durée de l’avance:(Jours) </label>
                                                            <input name="dure_avance" type="text" class="form-control form-control-sm"   value="{{ $data->duree_avance }}" />
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- end card -->
                                    </div> <!-- end col -->

                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Fonds demandes par : </label>
                                                            <select type="text" class="form-control form-control-sm" name="fond_demander_par" id="acce" required>
                                                                <option disabled="true" selected="true" value="{{ $data->fonds_demandes_userid }} ">{{ $data->fonds_demandes_nom }} {{ $data->fonds_demandes_prenom }}</option>
                                                                @foreach ($personnel as $personnels)
                                                                <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <center>Signature pose apres creation </br></br>
                                                                <i class="fa fa-times-circle" ></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Date</label>
                                                            <input type="date" name="date_fond_demande_par" value="{{ $data->date_fonds_demande_par }}"
                                                                class="form-control form-control-sm" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Avance Approuvée par (2 personnes au
                                                                moins) :  </label>
                                                                <select type="text" class="form-control form-control-sm" name="avance_approuver_par_un" id="acce" required>
                                                                    <option selected="true" value="{{ $data->avance_approuver_un_userid }}"> {{ $data->avance_approuver_un_nom }} {{ $data->avance_approuver_un_prenom }}</option>
                                                                    @foreach ($personnel as $personnels)
                                                                    <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                                    @endforeach
                                                                </select>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <center>Signature pose apres creation </br></br>
                                                                <i class="fa fa-times-circle" ></i>
                                                           

                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Date</label>
                                                            <input  name="date_signature_avance_approuver_un" value="{{ $data->date_avance_approuver_par }}" type="date" class="form-control form-control-sm" />

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Nom</label>
                                                            <select type="text" class="form-control form-control-sm" name="avance_approuver_par_deux" id="acce" required>
                                                                <option disabled="true" selected="true" value="{{ $data->signe_avance_approuver_par_deux}} ">{{ $data->avance_approuver_par_deux_nom }} {{ $data->avance_approuver_par_deux_prenom }}</option>
                                                                @foreach ($personnel as $personnels)
                                                                <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <center>Signature pose apres creation </br></br>
                                                                <i class="fa fa-times-circle" ></i>
                                                           

                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Date</label>
                                                            <input name="date_signature_avance_approuver_deux" value="{{ $data->date_avance_approuver_par_deux }}" 
                                                                type="date" class="form-control form-control-sm" />

                                                        </div>
                                                    </div>


                                                </div>
                                                <hr>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Fonds déboursés par: </label>
                                                            <select type="text" class="form-control form-control-sm" name="fond_debourse_par" id="acce" required>
                                                                <option disabled="true" selected="true" value="{{ $data->signe_fond_debourser_par }} ">{{ $data->fond_debourser_nom }} {{ $data->fond_debourser_prenom }}</option>
                                                                @foreach ($personnel as $personnels)
                                                                <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <center>Signature pose apres creation </br></br>
                                                            <i class="fa fa-times-circle" ></i>
                                                        </center>
                                                           

                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Date</label>
                                                            <input name="date_signe_fond_debourses" type="date_fond_debourse_par" value="{{ $data->date_fond_debourser_par }}" 
                                                                class="form-control form-control-sm" />

                                                        </div>
                                                    </div>
                                                </div>


            </form>
        </div>
    </div>
    <!-- end card -->
    </div> <!-- end col -->

    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">

               
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">PFonds payés à :</label>
                                <input name="fondPayea" value="{{ $data->pfond_paye }}" type="text" class="form-control form-control-sm" />

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">Adresse</label>
                                <input name="fondPayeAdresse" value="" type="text" class="form-control form-control-sm" />

                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">Téléphone1:</label>
                                <input name="fondPayePhoneUn" value="{{ $data->telephone_un }}" type="text" class="form-control form-control-sm" />


                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">Téléphone2: </label>
                                <input name="fondPayePhone_deux"  value="{{ $data->telephone_deux }}" type="text" class="form-control form-control-sm" />

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-2">
                                <label>DESCRIPTION/MOTIF:</label>
                                <div>
                                    <textarea name="fondPayeDescription" required class="form-control" rows="2">{{ $data->description_avance }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">Montant de l'Avance</label>
                                <input name="montantAvancedeux" value="{{ $data->montant_avance }}" type="text" class="form-control form-control-sm" />

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">Montant utilisé*</label>
                                <input name="montantUtilise" value="{{ $data->montant_utiliser }}" type="text" class="form-control form-control-sm" />

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">Surplus/Manque*</label>
                                <input name="surplusManque"  value="{{ $data->montant_surplus }}" type="text" class="form-control form-control-sm" />

                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">Montant retourné
                                    à la caisse ou au compte(Si Surplus)
                                </label>
                                <input name="montantRetourne"  value="{{ $data->montant_retourne }}" type="text" class="form-control form-control-sm" />

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">Réception des fonds retournés à la caisse par: <br>Noms de la
                                    Caissière :
                                </label>
                                <select type="text" class="form-control form-control-sm" name="fond_retourne" id="acce" required>
                                    <option disabled="true" selected="true" value="{{ $data->fonds_retournes_caisse_par }} ">{{ $data->fonds_retournes_caisse_nom }} {{ $data->fonds_retournes_caisse_prenom }}</option>
                                    @foreach ($personnel as $personnels)
                                    <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">ou Borderau de versement <br>nº <br>
                                </label>
                                <input name="bordereauVersement" value="{{ $data->bordereau_versement }}" type="text" class="form-control form-control-sm" />

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">Du <br>nº <br>
                                </label>
                                <input name="du" type="text" value="{{ $data->du_num }}" class="form-control form-control-sm" />

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class="form-label">Réception des pièces justificatives de l'utilisation de l'avance
                                    par:
                                </label>
                                <select type="text" class="form-control form-control-sm" name="reception_pieces_par" id="acce" required>
                                    <option disabled="true" selected="true" value="{{ $data->reception_pieces_justificatives }} ">{{ $data->reception_pieces_nom }} {{ $data->reception_pieces_prenom }}</option>
                                    @foreach ($personnel as $personnels)
                                    <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>

                    <br><br>
                    <button  id="edjitustifierbtn" name="editjustifierbtn" class="btn btn-primary editjustifierbtn" type="submit"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
<br><br>

                </form>
            </div>
        </div>
        <!-- end card -->
    </div> <!-- end col -->

    </div>
    </div>
    </div>
    <!-- end card -->
    </div> <!-- end col -->
    </div>
    </form>
    </div>
    </div>

    <script>
        $(document).on('input', 'input[name="montant_utiliser[]"]', function() {
          var montantAvance = $(this).closest('tr').find('input[name="montantavance[]"]').val();
          var montantUtilise = $(this).val();
          var surplusManque = parseFloat(montantAvance) - parseFloat(montantUtilise);
          $(this).closest('tr').find('input[name="surplus[]"]').val(surplusManque);
        });
      
        $(document).on('input', 'input[name="montant_retourne[]"]', function() {
          var surplusManque = parseFloat($(this).closest('tr').find('input[name="surplus[]"]').val());
          var montantRetourne = parseFloat($(this).val());
          var errorMessage = $(this).closest('tr').find('.error-message');
          var addjustifierbtn = $('#addjustifierbtn');
      
          if (montantRetourne !== surplusManque) {
            errorMessage.text("Le Montant Retourné doit être égal au Surplus/Manque.");
            $(this).addClass('is-invalid');
            addjustifierbtn.prop('disabled', true);
          } else {
            errorMessage.text("");
            $(this).removeClass('is-invalid');
            addjustifierbtn.prop('disabled', false);
          }
        });
      
        $(document).on('input', '.description-input', function() {
          var descriptionValue = $(this).val().toLowerCase();
          var relatedPlaqueTd = $(this).closest('tr').find('.plaque-input').parent();
          if (descriptionValue.includes('carburant')) {
            relatedPlaqueTd.show();
          } else {
            relatedPlaqueTd.hide();
          }
        });
      
      
        $(function() {
   
       // Edit  ajax 
       $("#EditdjdaForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
      
        $("#addjustifierbtn").html('<i class="fas fa-spinner fa-spin"></i> En cours...');
        $("#addjustifierbtn").prop('disabled', true); // Désactiver le bouton de soumission
      
        $.ajax({
          url: "{{ route('updatejustification', $data->iddjas) }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
          if (response.status == 200) {
           
              toastr.success("Mises ajour DJA  avec succès !", "success");
            
          } else if (response.status == 201) {
              toastr.error("Attention: DJA  existe déjà !", "info");
              
              document.getElementById("addjustifierbtn").disabled = false; // Réactive le bouton
          } else if (response.status == 202) {
              toastr.error("Erreur d'execution, verifier votre internet", "error");
              
      
              document.getElementById("addjustifierbtn").disabled = false; // Réactive le bouton
          } else if (response.status == 203) {
              toastr.error("Erreur d'exécution : " + response.error, "error");
              
              document.getElementById("addjustifierbtn").disabled = false; // Réactive le bouton
          }
      
          $("#addjustifierbtn").html('Sauvegarder'); // Réinitialise le texte du bouton
          document.getElementById("djaModale").disabled = false; // Réactive le bouton
          
          setTimeout(function() {
              
          }, 600); // 600 millisecondes = 0.6 secondes
      }
      ,
          error: function(xhr, status, error) {
            toastr.error("Une erreur s'est produite : " + error, "Erreur");
          },
          complete: function() {
            $("#addjustifierbtn").html('Sauvegarder'); // Réinitialiser le texte du bouton
            $("#addjustifierbtn").prop('disabled', false); // Réactiver le bouton de soumission
          }
        });
      });
      
    
      
        });
      </script>
@endsection
