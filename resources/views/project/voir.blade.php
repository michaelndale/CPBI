@extends('layout/app')
@section('page-content')

<div class="main-content">
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ $dataProject->title }} 
                    <br>
                    <small>
                    <b><i class="fa fa-info-circle"></i> Statut du projet :</b> <span class="badge rounded-pill bg-success" >  {{ $dataProject->statut }} </span>  <br>
                      <b><i class="fa fa-edit"></i> Autorisation de modification :</b>  
                      @if($dataProject->autorisation==1)
                        <span class="badge rounded-pill bg-primary" > Projet Ouvert </span>
                        @else
                        <span class="badge rounded-pill bg-danger" > Fermer </span>
                      @endif

                    </small>
                   

                    </h4>


                    <div class="page-title-right">
                    <div class="dropdown">
              @php 
                  $IDPJ= Session::get('id');
                  $cryptedId = Crypt::encrypt($IDPJ);
              @endphp
              <a href="{{ route('key.viewProject', $cryptedId ) }}"  class="btn btn-primary" title="Actualiser"><i class="fas fa-redo-alt"></i> </a>
                <button class="btn btn-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                   <i class="fa fa-random"></i> Actions <i class="mdi mdi-dots-vertical align-middle font-size-16"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('key.editProject',  $cryptedId ) }}"><i class="fas fa-edit font-size-16 align-middle me-2 text-muted"></i>
                      Modifier le projet</a>
                  </li>

                 <!-- <li>
                    <button class="dropdown-item" href="{{ route('listfeb') }}"><i class=" fas fa-times-circle  font-size-16 align-middle me-2 text-muted"></i>
                      Bloquer la modification</button>
                  </li>

                  <li>
                    <button class="dropdown-item" href="{{ route('listfeb') }}"><i class=" mdi mdi-check-circle font-size-16 align-middle me-2 text-muted"></i> Autoriser la modification</button>
                  </li> -->
                 
                  <li>
                    <a class="dropdown-item" href="{{ route('gestioncompte') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                    Ligne budgetaire</a>
                  </li>
                 
                  <li>
                    <a class="dropdown-item" href="{{ route('rallongebudget') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                      Budget</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="{{ route('activity') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                      Activites</a>
                  </li>

                  <li>
                    <a class="dropdown-item" href="{{ route('listfeb') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                      FEB</a>
                  </li>
                  
                  <li>
                    <a class="dropdown-item" href="{{ route('listdap') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                      DAP</a>
                  </li>
                  
                  <li>
                    <a class="dropdown-item" href="{{ route('listdja') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                      DJA</a>
                  </li>
                
                  <li>
                    <a class="dropdown-item" href="{{ route('affectation') }}"><i class="fa fa-users font-size-16 align-middle me-2"></i>  Ajouter les intervenants</a>
                  </li>
                
                  <li>
                    <a class="dropdown-item" href="{{ route('rapportcumule') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                      Rapport cummulatif</a>
                  </li>

                  <li>
                    <a class="dropdown-item" href="{{ route('planoperationnel') }}"><i class="mdi mdi-pencil-outline font-size-16 align-middle me-2 text-muted"></i>
                      Plan d'action</a>
                  </li>

                  <li>
                     <a class="dropdown-item deleteIcon" id="{{ $dataProject->id }}" href="#"> <font color="red"> <i class="fas fa-trash-alt font-size-16 align-middle me-2 "></i>
                     Supprimer projet</font></a> 
                  </li>

                
                 
                </ul>
              </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

      <div class="row">

       
       
          
            <div class="col-xl-7">
                <div class="card">
                <div class="card-header">
                        <h5 class="card-title mb-0"> <i class="fa fa-info-circle"></i> Information sur le projet  </h5>
                    </div>
                    <div class="card-body">
                    
                    <table class="lh-sm mb-12 mb-sm-0 mb-xl-12">
                      <tbody>
                        <tr>
                          <td class="align-top py-1">
                            <div class="d-flex">
                              <h5 class="text-900 mb-0 text-nowrap"><i class="fa fa-user-circle"></i> Responsable  </h5>
                            </div>
                          </td>
                          <td class="ps-1 py-1"><a class="fw-semi-bold d-block lh-sm" href="#!">: {{ ucfirst($responsable->nom) }} {{ ucfirst($responsable->prenom) }}</a></td>
                        </tr>
                        <tr>
                          <td class="align-top py-1">
                            <div class="d-flex">
                              <h5 class="text-900 mb-0 text-nowrap"> <span class="fas fa-money-check-alt"></span> Budget  </h5>
                            </div>
                          </td>
                          <td class="fw-bold ps-1 py-1 text-1000"> : {{ number_format($dataProject->budget,0, ',', ' ') }} {{ $dataProject->devise }}</td>
                        </tr>
                      </tbody>
                    </table>

              <div class="col-12 col-xl-12 col-xxl-12 pe-xl-0">
              <div class="mb-12 mb-xl-12">
                <div class="row gx-0 gx-sm-12">
                  
                  <div class="col-12">
                    <table class="lh-sm">
                      <tbody>

                      <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Responsable </td>
                          <td class="text-600 fw-semi-bold ps-3"> : {{ $dataProject->numeroprojet }}</td>
                        </tr>

                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Numéro projet </td>
                          <td class="text-600 fw-semi-bold ps-3"> : {{ $dataProject->numeroprojet }}</td>
                        </tr>

                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Début de l'exécution du projet  </td>
                          <td class="text-600 fw-semi-bold ps-3">: {{ date('d.m.Y', strtotime($dataProject->start_date))  }}</td>
                        </tr>


                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Fin de l'exécution du projet </td>
                          <td class="text-600 fw-semi-bold ps-3"> : {{ date('d.m.Y', strtotime($dataProject->deadline))  }}</td>
                        </tr>
                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Progression du projet </td>
                            @php
                             $pourcentage = round(($sommerepartie*100)/$dataProject->budget , 2) ;
                             if($pourcentage < 50){
                                $color= 'primary';
                             }elseif($pourcentage >=50 AND $pourcentage < 80){
                                $color= 'success';
                             }elseif($pourcentage <= 80 AND $pourcentage >= 100){
                                $color= 'danger';
                             }else{
                              $color= 'warning';
                             }
                           @endphp 
                           <td class="text-{{ $color }} fw-semi-bold ps-3">: {{ $pourcentage }} %
                            </td> 
                        </tr>
                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Date de création projet </td>
                          <td class="text-600 fw-semi-bold ps-3">: {{ date('d.m.Y', strtotime($dataProject->created_at))  }}</td>
                        </tr>
                      
                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Région  </td>
                          <td class="text-600 fw-semi-bold ps-3">: {{ $dataProject->region }}</td>
                        </tr>
                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Lieu </td>
                          <td class="text-600 fw-semi-bold ps-3">: {{ $dataProject->lieuprojet }}</td>
                        </tr>

                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Notre en période </td>
                          <td class="text-600 fw-semi-bold ps-3">: {{ $dataProject->periode }} (T)</td>
                        </tr>

                        <tr>
                          <td class="align-top py-1 text-900 text-nowrap fw-bold">Nombres des jours </td>
                          <td class="text-600 fw-semi-bold ps-3">

                          @php
                              // Date de début et de fin de l'intervalle
                              $dateDebut = \Carbon\Carbon::parse($dataProject->start_date);
                              $dateFin = \Carbon\Carbon::parse($dataProject->deadline);

                              // Calculer le nombre de jours entre les deux dates
                              $nombreJours = $dateFin->diffInDays($dateDebut);
                          @endphp

                          <p>: {{ $nombreJours }} jours de l'exécution du projet.</p>


                          </td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>

                        
                       

                    </div>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fa fa-edit"></i> Description</h5>
                    </div>
                    <div class="card-body pt-0 pb-3">
                        <div id="overview-chart" data-colors='["#1f58c7"]' class="apex-charts" dir="ltr"></div>
                        <p class="text-800 mb-4">{{ $dataProject->description }} </p>

                     
                    </div>
                </div>

                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0"><i class="fa fa-users"></i> Les intervenants du projet</h5>
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

                                                              @if(file_exists($imagePath))
                                                                
                                                              <span class="avatar-title rounded-circle bg-primary text-white font-size-14">
                                                              {{ ucfirst(substr($intervennant->nom, 0, 1)) }}
                                                                    </span>
                                                              @else
                                                                  <img id="output_image" src="{{ $defaultAvatar }}" alt="{{ ucfirst(Auth::user()->identifiant) }}"  style="width:100%; border-radius:100% ">
                                                              @endif



                                                            </div>
                                                        </td>
                                                        <td><h5 class="font-size-14 m-0"><a href="javascript: void(0);" class="text-dark">{{ ucfirst($intervennant->nom) }} {{ ucfirst($intervennant->prenom) }}</a></h5></td>
                                                       
                                                        <td>
                                                            <i class="mdi mdi-circle-medium font-size-18 text-success align-middle me-1"></i> {{ ucfirst($intervennant->role) }}
                                                        </td>
                                                    </tr>
                                                  
                                                @empty

                                                <tr>
                                                  <td colspan="3">
                                                    <center>
                                                      <h6 style="margin-top:1% ;color:#c0c0c0"> 
                                                        <center><font size="20px"><i class="fa fa-info-circle"  ></i> </font><br>
                                                        Ceci est vide  !</center> 
                                                    </h6>
                                                    </center>
                                                  </td>
                                                </tr>
                                                  
                                                @endforelse

                                              
                                                    
                                                </tbody>
                                            </table>
                                            <a href="{{ route('affectation') }}"><i class="fa fa-plus-circle"></i> Ajouter </a>
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







  <script>
// Fonction pour calculer le total
    $(function() {
      // Delete feb ajax request

      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Êtes-vous sûr ?',
          text: "PROJET est sur le point d'être DÉTRUITE ! Faut-il vraiment exécuter « la Suppression » ?  ",

          showCancelButton: true,
          confirmButtonColor: 'green',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Oui, Supprimer !',
          cancelButtonText: 'Annuller'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "{{ route('projetdelete') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {


              if (response.status == 200) {
                toastr.success("Project supprimer avec succès !", "Suppression");
               

                var ur ="{{ route('closeproject') }}";

                window.location.href = ur;
                
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de supprimer ce project!", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
              }
            });
          }
        })
      });

    

     

    });
  </script>


    @endsection

