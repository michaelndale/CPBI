@extends('layout/app')
@section('page-content')

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
                        <div class="card-body">
            
                            <!-- Champ de recherche -->
                            <div class="mb-3 row align-items-center">
                                <div class="col-md-10">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un projet..." onkeyup="searchProjects()">
                                </div>
                                <div class="col-md-2">
                                    <div class="dropdown">
                                        <button 
                                        class="btn btn-outline-primary rounded-pill   w-100 d-flex justify-content-between align-items-center"
                                       
                                          type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span>
                                                <i class="fa fa-list"></i> Filtre
                                            </span>
                                            <i class="fa fa-chevron-down"></i> <!-- Icône de flèche vers le bas -->
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                            <li><a class="dropdown-item" href="#" onclick="filterProjects('all')">Tout</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="filterProjects('En attente')">En attente</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="filterProjects('Activé')">Activé</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="filterProjects('Bloqué')">Bloqué</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="filterProjects('Archive')">Archivé</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
            
                            <table class="table table-bordered fs--1 mb-0"  style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th><b>Projets ({{ $data->count() }})</b></th>
                                        <th><b>Responsable du projet</b></th>
                                        <th><center><b>Accès</b></center></th>
                                        <th><center><b>Statut</b></center></th>
                                        <th><b>Date Début</b></th>
                                        <th><b>Date Fin</b></th>
                                    </tr>
                                </thead> 
            
                                <tbody>
                                    @foreach ($data as $datas)
                                        @php
                                            $accessCount = DB::table('affectations')
                                                ->where('memberid', Auth::id())
                                                ->where('projectid', $datas->idpr)
                                                ->count();
                                            $cryptedId = Crypt::encrypt($datas->idpr);
                                  
                                        @endphp
            
                                        <tr>
                                            <td>
                                                @if($accessCount == 1)
                                                <a href="{{ route('exercice.show', $datas->idpr) }}" 
                                                    id="{{ $datas->idpr }}" 
                                                    class="text-dark show-exercice" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#ProjetModalScrollable">
                                                     {{ $datas->title }}
                                                 </a>
                                                 
                                                @else
                                                    <a href="javascript:void(0)" class="text-dark" onclick="showAccessDeniedAlert()">{{ $datas->title }}</a>
                                                @endif
                                            </td>
                                            <td><i class="ri-user-3-fill"></i> {{ ucfirst($datas->nom) }} {{ ucfirst($datas->prenom) }}</td>
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
                                            <td>{{ date('d-m-Y', strtotime($datas->start_date)) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($datas->deadline)) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
            
                            <!-- Pagination Links -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $data->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    function searchProjects() {
        var query = $('#searchInput').val();
        var filter = $('#filterDropdown').text().trim().split(' ')[1]; // Obtenir la partie pertinente du texte

        $.ajax({
            url: '{{ route("list_project") }}', // Remplacez par la route appropriée
            method: 'GET',
            data: { search: query, filter: filter },
            success: function(data) {
                $('#projectTableBody').html(data.table);
                $('.pagination').html(data.pagination);
            },
            error: function(xhr, status, error) {
                console.error("Une erreur s'est produite : " + error);
            }
        });
    }

    function filterProjects(status) {
        $('#filterDropdown').html('<span><i class="fa fa-list"></i> ' + status + '</span><i class="fa fa-chevron-down"></i>'); // Mettre à jour le texte du dropdown
        searchProjects(); // Appeler la fonction de recherche avec le filtre
    }
</script>

<script>
    function showAccessDeniedAlert() {
        Swal.fire({
            title: 'Accès refusé',
            text: "Vous n'avez pas les droits nécessaires pour accéder à ce projet. Veuillez contacter le responsable du projet.",
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

@include('project.exerciceListe')
@endsection