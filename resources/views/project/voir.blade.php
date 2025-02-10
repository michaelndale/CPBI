@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">{{ $dataProject->title }}
              <br>
              <small>
                <b><i class="fa fa-info-circle"></i> Statut du projet :</b> <span class="badge rounded-pill bg-success"> {{ $dataProject->statut }} </span> <br>
                <i class="fa fa-edit"></i> Autorisation de modification :
                @if($dataProject->autorisation==1)
                <span class="badge rounded-pill bg-primary"> Projet Ouvert </span>
                @else
                <span class="badge rounded-pill bg-danger"> Fermer </span>
                @endif
              </small>
            </h4>


            <div class="page-title-right">
              <div class="dropdown">
                @php
                $IDPJ = Session::get('id');
                $exercice_id = Session::get('exercice_id');
                $cryptedProjectId = Crypt::encrypt($IDPJ);
                $cryptedExerciceId = Crypt::encrypt($exercice_id)
               @endphp

               
                <a href="{{ route('key.viewProject',  ['project' => $cryptedProjectId, 'exercice' => $cryptedExerciceId]) }}" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" type="button" title="Actualiser"><i class="fas fa-redo-alt"></i>  </a>

                <a href="{{ route('new.exercice',  $cryptedProjectId) }}"
                class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" type="button"><i
                    class="fa fa-plus-circle"></i> Nouvel exercice</a>
                    
                <a href="{{ route('rallongebudget') }}" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" type="button" ><i class="fa fa-list"></i> Budgétisation  </a>

                 
                 
                <button class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-list"></i> Actions options <i class="mdi mdi-dots-vertical align-middle "></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                 
                 <!-- <li>
                    <a class="dropdown-item" href="{{ route('liste.revision', $cryptedProjectId) }}"><i class="fa  fa-list font-size-16 align-middle me-2 text-muted"></i>
                      Historique de la revision Budgétaire</a>
                  </li> -->



                  <li>
                    <a class="dropdown-item" href="{{ route('gestioncompte') }}"><i class="fa fa-chart-line font-size-16 align-middle me-2 text-muted"></i>
                      Ligne budgétaire</a>
                  </li>


                  <li>
                    <a class="dropdown-item" href="{{ route('key.editProject',  $cryptedProjectId ) }}"><i class="fa fa-edit font-size-16 align-middle me-2 text-muted"></i>
                      Modification du projet </a>
                  </li>

                  <li>
                    <a class="dropdown-item" href="{{ route('exercices.show',$cryptedExerciceId) }}"><i class="fa fa-edit font-size-16 align-middle me-2 text-muted"></i>
                      Modification l'exercice encours </a>
                  </li>


                  <li>
                    <a class="dropdown-item" href="{{ route('affectation' ) }}"><i class="fa fa-users font-size-16 align-middle me-2 text-muted"></i>
                     Intervenenant </a>
                  </li>

                  <li>
                    <a class="dropdown-item" href="{{ route('exercices.index') }}"><i class="fa  fa-list font-size-16 align-middle me-2 text-muted"></i>
                      Exercice Annuel Classement</a>
                  </li>
                 

                  
                  <li>
                    <a class="dropdown-item" href="{{ route('activity') }}"><i class="fa fa-running font-size-16 align-middle me-2 text-muted"></i>
                      Activitées</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="{{ route('listfeb') }}"><i class="mdi mdi-file-document-outline font-size-20 align-middle me-2 text-muted"></i>
                      F.E.B</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="{{ route('listdap') }}"><i class="mdi mdi-file-document-outline font-size-20  align-middle me-2 text-muted"></i>
                      D.A.P</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="{{ route('listdja') }}"><i class="mdi mdi-file-document-outline font-size-20  align-middle me-2 text-muted"></i>
                      D.J.A</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="{{ route('bpc') }}"><i class="mdi mdi-file-document-outline font-size-20  align-middle me-2 text-muted"></i>
                      Bon de petite caisse</a>
                  </li>
                 
                  <li>
                    <a class="dropdown-item" href="{{ route('bailleursDeFonds') }}"><i class="fa fa-users font-size-16 align-middle me-2"></i> Bailleurs des fonds</a>
                  </li>

                
                  <li>
                    <a class="dropdown-item" href="{{ route('rapportcumule') }}"><i class="fa fa-chart-pie font-size-16 align-middle me-2 text-muted"></i>
                      Rapport cummulatif</a>
                  </li>
                 

                  <li>
                    <a class="dropdown-item" href="{{ route('planoperationnel') }}"><i class="fa fa-tasks font-size-16 align-middle me-2 text-muted"></i>
                      Plan d'action</a>
                  </li>
                  
                  <li>
                    <a class="dropdown-item deleteIcon" id="{{ $dataProject->id }}" data-title="{{ $dataProject->title }}">
                      <font color="red"> <i class="fas fa-trash-alt font-size-16 align-middle me-2 "></i>
                        Supprimer projet </font>
                    </a>
                  </li>
                </ul>
              </div>
            </div>

          </div>
        </div>
      </div>
      <!-- end page title -->

      <div class="row" >
        
        <div class="col-xl-7" >
          <div class="card">
            <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">
              <h5 class="card-title mb-0"> <i class="fa fa-info-circle"></i> Information du projet </h5>
            </div>
            <div class="card-body">
              <div class="col-12 col-xl-12 col-xxl-12 pe-xl-0">
                <div class="mb-12 mb-xl-12">
                  <div class="row gx-0 gx-sm-12">
                    <div class="col-12">
                      <table class="lh-sm">
                        <tbody>
                          <tr>
                            <td class="align-top py-1 text-900 text-nowrap fw-bold">Numéro projet </td>
                            <td class="text-600 fw-semi-bold ps-3"> : {{ $dataProject->numeroprojet }}</td>
                          </tr>
                          

                          <tr>
                            <td class="align-top py-1 text-900 text-nowrap fw-bold">Numéro exercice</td>
                            <td class="text-600 fw-semi-bold ps-3"> : {{ $dataProject->numero_e }}</td>
                          </tr>

                          <tr>
                            <td class="align-top py-1 text-900 text-nowrap fw-bold">Titre exercice</td>
                            <td class="text-600 fw-semi-bold ps-3"> : {{ $dataProject->pexercice }}</td>
                          </tr>

                          <tr>
                            <td class="align-top py-1 text-900 text-nowrap fw-bold">Statut de l'exercice</td>
                            <td class="text-600 fw-semi-bold ps-3"> : 
                              @if($dataProject->status === 'Actif')
                              <span class="badge rounded-pill bg-subtle-primary text-primary font-size-11">Active</span>
                              @else
                              <span class="badge rounded-pill bg-subtle-danger text-danger font-size-11">Archiver</span>
                              @endif

                            </td>
                          </tr>

                          <tr>
                            <td class="align-top py-1 text-900 text-nowrap fw-bold">Titre du projet </td>
                            <td class="text-600 fw-semi-bold ps-3"> : {{ $dataProject->title }}</td>
                          </tr>
                          <tr>
                            <td class="align-top py-1 text-900 text-nowrap fw-bold">Budget </td>
                            <td class="text-600 fw-semi-bold ps-3"> : {{ number_format($dataProject->budgets,0, ',', ' ') }} {{ $dataProject->devise }} </td>
                          </tr>

                          <tr>
                            <td class="align-top py-1 text-900 text-nowrap fw-bold">Responsable </td>
                            <td class="text-600 fw-semi-bold ps-3"> : {{ ucfirst($responsable->nom) }} {{ ucfirst($responsable->prenom) }}</td>
                          </tr>

                          <tr>
                            <td class="align-top py-1 text-900 text-nowrap fw-bold">Début de l'exécution du projet </td>
                            <td class="text-600 fw-semi-bold ps-3">: {{ date('d.m.Y', strtotime($dataProject->estart_date))  }}</td>
                          </tr>
                          <tr>
                            <td class="align-top py-1 text-900 text-nowrap fw-bold">Fin de l'exécution du projet </td>
                            <td class="text-600 fw-semi-bold ps-3"> : {{ date('d.m.Y', strtotime($dataProject->edeadline))  }}</td>
                          </tr>
                          <tr>
                            <td class="align-top py-1 text-900 text-nowrap fw-bold">Progression du projet </td>
                            @php
                            $pourcentage = round(($sommerepartie * 100) / $dataProject->budgets, 2);
                            $restant = 100 - $pourcentage;
                            if($pourcentage < 50){ $color='primary' ; }elseif($pourcentage>=50 AND $pourcentage < 80){ $color='success' ; }elseif($pourcentage <=80 AND $pourcentage>= 100){
                                $color= 'danger';
                                }else{
                                $color= 'warning';
                                }
                                @endphp
                                <td class="text-{{ $color }} fw-semi-bold ps-3">:  <b> {{ $pourcentage }} %</b> 
                                </td>
                          </tr>


                          <tr>
                            <td class="align-top py-1 text-900 text-nowrap fw-bold">Région </td>
                            <td class="text-600 fw-semi-bold ps-3">: {{ $dataProject->region }}</td>
                          </tr>
                          <tr>
                            <td class="align-top py-1 text-900 text-nowrap fw-bold">Lieu </td>
                            <td class="text-600 fw-semi-bold ps-3">: {{ $dataProject->lieuprojet }}</td>
                          </tr>

                          <tr>
                            <td class="align-top py-1 text-900 text-nowrap fw-bold">Notre en période </td>
                            <td class="text-600 fw-semi-bold ps-3">: {{ $dataProject->eperiode }} (T)</td>
                          </tr>

                          <tr>
                            <td class="align-top py-1 text-900 text-nowrap fw-bold">Nombres des jours </td>
                            <td class="text-600 fw-semi-bold ps-3">

                              @php
                              // Date de début et de fin de l'intervalle
                              $dateDebut = \Carbon\Carbon::parse($dataProject->estart_date);
                              $dateFin = \Carbon\Carbon::parse($dataProject->edeadline);

                              // Calculer le nombre de jours entre les deux dates
                              $nombreJours = $dateFin->diffInDays($dateDebut);
                              @endphp
                              : {{ $nombreJours }} Jours de l'exécution du projet.

                            </td>
                          </tr>

                          <tr>
                            <td class="align-top py-1 text-900 text-nowrap fw-bold">Créé par </td>
                            <td class="text-600 fw-semi-bold ps-3">

                              : {{ ucfirst($dataProject->nom) }} {{ ucfirst($dataProject->prenom) }}

                            </td>
                          </tr>

                          <tr>
                            <td class="align-top py-1 text-900 text-nowrap fw-bold">Créé le </td>
                            <td class="text-600 fw-semi-bold ps-3">: {{ date('d.m.Y', strtotime($dataProject->created_at))  }}</td>
                          </tr>

                        </tbody>
                      </table>
                      <br>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">
              <h5 class="card-title mb-0"><i class="fa fa-info-circle"></i> Description du projet </h5>
            </div>
            <div class="card-body pt-0 pb-3">
              <div id="overview-chart" data-colors='["#1f58c7"]' class="apex-charts" dir="ltr"></div>
              <p class="text-800 mb-4">{{ $dataProject->description }} </p>
            </div>
          </div>

          

          <div class="card">

            <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">
                            
                <h4 class="mb-sm-0"><i class="fa fa-users"></i> Bailleurs des fonds </h4>
                    <div class="page-title-right">
                      <a href="{{ route('bailleursDeFonds') }}" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"><i class="fa fa-plus-circle"></i> Ajouter</a> 
                </div>
            </div>

          
            <div class="card-body pt-2">
                <div class="table-responsive">
                  <table class="table align-middle table-nowrap mb-1">
                    <thead>
                        <tr>
                            <th>Nom Organisation</th>
                            <th>Responsable</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bailleurs as $bailleur)
                            <tr>
                                <td>{{ $bailleur->nom }}</td>
                                <td>{{ $bailleur->contact_nom }}</td>
                                <td>{{ $bailleur->contact_email }}</td>
                                <td>{{ $bailleur->contact_telephone }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Aucun bailleur trouvé pour ce projet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                
                    
                </div>
            </div>
          </div>


        </div>
       
        <div class="col-xl-5">
          <div class="card">
            <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">
              <h5 class="card-title mb-0"><i class="fa fa-info-circle"></i> Progression d'exécution du projet</h5>
            </div>
            <div class="card-body pt-0 pb-3">
              <div id="overview-chart" data-colors='["#1f58c7"]' class="apex-charts" dir="ltr"></div>
              <div id="container" style="height: 410px"></div>
            </div>
          </div>


          <div class="card">

            <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">
                            
                <h4 class="mb-sm-0"><i class="fa fa-list"></i> Exercice annuel pour le classement du projet </h4>
                    <div class="page-title-right">
                      <a href="{{ route('new.exercice',  $cryptedProjectId) }}" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"><i class="fa fa-plus-circle"></i> Ajouter</a> 
                </div>
            </div>

          
            <div class="card-body pt-2">
                <div class="table-responsive">
                  <table class="table align-middle table-nowrap mb-1">
                    <thead>
                        <tr>
                            <th>Numéro</th>
                            <th>Budget</th>
                            <th>Statut</th>
                            <th>Date Début</th>
                            <th>Date Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($exercices as $exercice)
                        
                       
                            <tr>
                                <td>
                                  <a href="#" 
                                  class="open-modal" 
                                  data-link="{{ route('key.viewProject', ['project' => Crypt::encrypt($exercice->project_id), 'exercice' => Crypt::encrypt($exercice->id)]) }}" 
                                  data-numero="{{ $exercice->numero_e }}" 
                                  data-budget="{{ number_format($exercice->budget, 0, ',', ' ') }}"
                                  data-year="{{  date('Y', strtotime($exercice->created_at)) }}"
                                   >
                                   <b>{{ $exercice->numero_e }}/{{ date('Y', strtotime($exercice->created_at)) }}</b>
                               </a>
                                </td>
                                <td align="right">{{ number_format($exercice->budget, 0, ',', ' ') }}</td>
                                <td>
                                    @if ($exercice->status === 'Actif')
                                        <span class="badge rounded-pill bg-subtle-primary text-primary font-size-11">Active</span>
                                    @else
                                        <span class="badge rounded-pill bg-subtle-danger text-danger font-size-11">Archiver</span>
                                    @endif
                                </td>
                                <td>{{ date('d-m-Y', strtotime($exercice->estart_date)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($exercice->edeadline)) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Aucun exercice trouvé pour ce projet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <!-- Modal -->
               
              <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-body">
                      <p class="text-700 lh-lg mb-0">
                        <center>
                         
                          <font size="10" color="#c0c0c0"> <i class="fas fa-info-circle "></i></font>
                          <h5 class="modal-title" id="confirmationModalLabel">Confirmer l'action ?</h5>
                          
                          <font size="4">  Voulez-vous aller sur l'exercice <br> numéro <b><span id="modalNumero"></span>/<span id="modalYear"></span></b> 
                            du budget <b><span id="modalBudget"></span></b> 
                          </font> <br> <br>
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-times-circle"></i> Non</button>
                          <a id="confirmLink" href="#" class="btn btn-primary"><i class="fa fa-check-circle"></i> Oui</a>
                        </center>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
                
                
                
                    
                </div>
            </div>
          </div>

         
          <div class="card">
            <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between" style="padding: 0.40rem 1rem;">
                           
              <h4 class="mb-sm-0"><i class="fa fa-users"></i> Les intervenants du projet</h4>
                  <div class="page-title-right">
                    <a href="{{ route('affectation') }}" class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm"><i class="fa fa-plus-circle"></i> Ajouter</a> 
              </div>
          </div>


           


            <div class="card-body pt-2">
                <div class="table-responsive">
                  <table class="table align-middle table-nowrap mb-1">
                    <tbody>
                        @forelse ($intervennant as $intervennant)
                            <tr>
                                <td>
                                    <div class="avatar-xs">
                                        @php
                                            $avatar = $intervennant->avatar;
                                            $defaultAvatar = '../../element/profile/default.png'; // Chemin vers votre image par défaut
                                            $imagePath = public_path($avatar);
                                        @endphp
                
                                        @if(file_exists($imagePath) && $avatar)
                                            <img id="output_image" src="{{ asset($avatar) }}" alt="{{ ucfirst($intervennant->nom) }}'s avatar" style="width:100%; border-radius:100%">
                                        @else
                                            <img id="output_image" src="{{ asset($defaultAvatar) }}" alt="{{ ucfirst($intervennant->nom) }}'s avatar" style="width:100%; border-radius:100%">
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <h5 class="font-size-14 m-0">
                                        <a href="javascript: void(0);" class="text-dark">{{ ucfirst($intervennant->nom) }} {{ ucfirst($intervennant->prenom) }}</a>
                                    </h5>
                                </td>
                                <td>
                                    @if($intervennant->is_connected)
                                        <i class="mdi mdi-circle-medium font-size-18 text-success align-middle me-1"></i> Online
                                    @else
                                        <i class="mdi mdi-circle-medium font-size-18 text-danger align-middle me-1"></i> Offline
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <center>
                                        <h6 style="margin-top:1%; color:#c0c0c0">
                                            <font size="20px"><i class="fa fa-info-circle"></i></font><br>
                                            Ceci est vide !
                                        </h6>
                                    </center>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                    
                </div>
            </div>
          </div>
        

        

        </div>

       


      </div>

    </div> <!-- container-fluid -->
  </div>
  <!-- End Page-content -->

  <!--  Extra Large modal example -->

</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>


<script>
  document.addEventListener('DOMContentLoaded', function () {
      var chart = Highcharts.chart('container', {
          chart: {
              type: 'pie', // Type pie pour un graphique circulaire
              options3d: {
                  enabled: true, // Activer le mode 3D
                  alpha: 45, // Angle de vue
                  beta: 0
              }
          },
          title: {
              text: "Progression d'exécution  du projet"
          },
          accessibility: {
              point: {
                  valueSuffix: '%'
              }
          },
          plotOptions: {
              pie: {
                  innerSize: 100, // Pour un effet "doughnut"
                  depth: 45, // Profondeur pour l'effet 3D
                  dataLabels: {
                      enabled: true,
                      format: '{point.name}: {point.y:.1f}%' // Format des labels
                  }
              }
          },
          series: [{
              name: 'Budget',
              data: [
                  {
                      name: 'Utilisé',
                      y: {{ $pourcentage }},
                      color: '#FF5733' // Couleur pour le pourcentage utilisé
                  },
                  {
                      name: 'Restant',
                      y: {{ $restant }},
                      color: '#4CAF50' // Couleur pour le pourcentage restant
                  }
              ]
          }]
      });
  });
</script>






<script>
  $(function() {
    // Delete feb ajax request
    $(document).on('click', '.deleteIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let title = $(this).data('title');
      let csrf = '{{ csrf_token() }}';

      Swal.fire({
        title: 'Supprimer le projet ?',
        html: "<p class='swal-text'>Cette action entraînera la suppression du projet <b>" + title + "</b></p><p class='swal-text'><i class='fa fa-info-circle' style='color: red;'></i> Ceci implique aussi la suppression de toutes les activités, lignes de compte budgétaire, budgets, FEB, DAP, DJA, bons de petites caisses, intervenants, plans d'action et feuilles de temps liés à ce projet.</p>",
        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, Supprimer !',
        cancelButtonText: 'Annuler',
        allowOutsideClick: false,
        customClass: {
          content: 'swal-custom-content'
        },
        preConfirm: () => {
          return new Promise((resolve) => {
            $.ajax({
              url: "{{ route('projetdelete') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                if (response.status == 200) {
                  toastr.info("Suppression en cours...", "Suppression");
                  // Attendre un court délai pour que l'utilisateur voie le message
                  setTimeout(() => {
                    resolve(response); // Résoudre la promesse avec la réponse de la requête AJAX
                  }, 1500); // Temps en millisecondes avant de résoudre la promesse
                } else {
                  let errorMessage = response.message || "Erreur lors de la suppression du projet.";
                  toastr.error(errorMessage, "Erreur");
                  if (response.error) {
                    toastr.error("Erreur: " + response.error, "Erreur");
                  }
                  if (response.exception) {
                    toastr.error("Exception: " + response.exception, "Erreur");
                  }
                  resolve(response); // Résoudre même en cas d'erreur pour débloquer la modal
                }
              },
              error: function(xhr, status, error) {
                let errorMsg = xhr.responseJSON ? xhr.responseJSON.message : "Erreur de réseau. Veuillez réessayer.";
                toastr.error(errorMsg, "Erreur");
                if (xhr.responseJSON && xhr.responseJSON.exception) {
                  toastr.error("Exception: " + xhr.responseJSON.exception, "Erreur");
                }
                resolve({
                  status: 500,
                  message: errorMsg,
                  error: error,
                  exception: xhr.responseJSON ? xhr.responseJSON.exception : "Aucune exception détaillée disponible"
                }); // Résoudre en cas d'erreur réseau pour débloquer la modal
              }
            });
          });
        }
      }).then((result) => {
        if (result.isConfirmed && result.value && result.value.status == 200) {
          toastr.success("Projet supprimé avec succès !", "Suppression");
          var ur = "{{ route('closeproject') }}";
          window.location.href = ur;
        }
      });
    });




  });
</script>

<script>
 document.addEventListener('DOMContentLoaded', function () {
    // Sélectionner tous les liens avec la classe "open-modal"
    const modalLinks = document.querySelectorAll('.open-modal');

    // Ajouter un écouteur d'événement pour chaque lien
    modalLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault(); // Empêche le comportement par défaut du lien

            // Récupérer les données depuis les attributs data-*
            const numero = this.getAttribute('data-numero');
            const budget = this.getAttribute('data-budget');
            const linkHref = this.getAttribute('data-link');
            const year = this.getAttribute('data-year');

            // Mettre à jour les informations dans le modal
            document.getElementById('modalNumero').textContent = numero;
            document.getElementById('modalBudget').textContent = budget;
            document.getElementById('modalYear').textContent = year;

            // Mettre à jour le lien du bouton "Oui"
            document.getElementById('confirmLink').setAttribute('href', linkHref);

            // Ouvrir le modal
            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            modal.show();
        });
    });
});

</script>

<style>
  .swal-custom-content .swal-text {
    font-size: 14px;
    /* Ajustez la taille selon vos besoins */
  }
</style>


@endsection