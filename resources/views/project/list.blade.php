@extends('layout/app')
@section('page-content')

<style>
    /* Dans votre fichier CSS */
    .swal2-small {
        font-size: 14px;
        /* Taille de police générale */
    }

    .swal2-title-small {
        font-size: 18px;
        /* Taille de police du titre */
    }

    .swal2-content-small {
        font-size: 16px;
        /* Taille de police du contenu */
    }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Projets ( {{ $data->count() }} )</h4>
                        <div class="page-title-right">
                            <div class="col-xl-12">
                                <div class="text-sm-end">
                                    <a class="btn btn-outline-primary rounded-pill me-1 mb-1 btn-sm" href="{{ route('new_project') }}" >
                                        <i class="fa fa-plus-circle"></i> Créer un nouveau projet </a>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    
                            <!-- Champ de recherche -->
                         
            
                            <table class="table table-bordered  table-sm fs--1 mb-0" >
                                <thead>
                                    <tr>
                                        <th><b>PROJETS ({{ $data->count() }})</b></th>
                                        <th><b>RESPONSABLE DU PROJET</b></th>
                                        <th><center><b>ACCÈS</b></center></th>
                                        <th><center><b>STATUT</b></center></th>
                                        <th><b>DATE DÉBUT</b></th>
                                        <th><b>DATE FIN</b></th>
                                    </tr>
                                </thead> 
                            
                                <tbody>
                                    @php
                                        // Grouper les projets par folderTitle
                                        $groupedProjects = $data->groupBy('folderTitle');
                                    @endphp
                            
                                    @foreach ($groupedProjects as $folder => $projects)
                                        <!-- Affichage du dossier en tant qu'en-tête -->
                                        <tr class="bg-light">
                                            <td colspan="6"><strong>{{ $folder }}</strong></td>
                                        </tr>
                            
                                        @foreach ($projects as $datas)
                                            @php
                                                $accessCount = DB::table('affectations')
                                                    ->where('memberid', Auth::id())
                                                    ->select('nom', 'prenom')
                                                    ->where('projectid', $datas->idpr)
                                                    ->count();
                                            @endphp
                            
                                            <tr>
                                                <td>
                                                    @if($accessCount == 1)
                                                        <a href="{{ route('exercice.show', $datas->idpr) }}" 
                                                            id="{{ $datas->idpr }}" 
                                                            class="text-dark show-exercice" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#ProjetModalScrollable" title=" {{ $datas->title }}">
                                                            {{ $datas->title }}
                                                        </a>
                                                    @else
                                                    <a href="javascript:void(0)" 
                                                    title="{{ $datas->title }}"
                                                    data-bs-target="#ProjetTitle" 
                                                    class="text-dark" 
                                                    onclick="showAccessDeniedAlert('{{ $datas->title }}')">
                                                    {{ $datas->title }}
                                                </a>
                                                    @endif
                                                </td>
                                                <td style="width:250px"><i class="ri-user-3-fill"></i> {{ ucfirst($datas->nom) }} {{ ucfirst($datas->prenom) }}</td>
                                                <td align="center">
                                                    @if($accessCount == 1)
                                                        <font size="2px" color="green"><i class="mdi mdi-check-decagram"></i></font>
                                                    @else
                                                        <font size="2px" color="red"><i class="mdi mdi-close-circle"></i></font>
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    @if($accessCount == 1)
                                                        <span class="badge rounded-pill bg-primary">Ouvert</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-danger">Fermer</span>
                                                    @endif
                                                </td>
                                                <td style="width:100px">{{ date('d-m-Y', strtotime($datas->start_date)) }}</td>
                                                <td style="width:100px">{{ date('d-m-Y', strtotime($datas->deadline)) }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                            
            
                            <!-- Pagination Links -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $data->links('vendor.pagination.bootstrap-4') }}
                            </div>
                     
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
</div>



@include('project.exerciceListe')



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function showAccessDeniedAlert(projectTitle) {
        Swal.fire({
            title: 'Accès refusé',
            text: "Vous n'avez pas les droits nécessaires pour accéder au projet << " + projectTitle + " >>. Veuillez contacter le responsable du projet.",
            icon: 'error',
            confirmButtonColor: '#28a745', // Couleur verte pour le bouton
            confirmButtonText: 'OK',
            allowOutsideClick: false, // Empêche la fermeture en cliquant à l'extérieur
            customClass: {
                popup: 'swal2-small', // Classe CSS pour la boîte de dialogue
                title: 'swal2-title-small', // Classe CSS pour le titre
                content: 'swal2-content-small' // Classe CSS pour le contenu
            }
        });
    }
</script>
@endsection