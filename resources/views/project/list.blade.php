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

                        <!--  <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                            <li class="breadcrumb-item active">Projets</li>
                        </ol>
                    </div> -->

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">


                            <div class="row mb-2">
                                <div class="col-xl-3 col-md-12">
                                    <div class="pb-3 pb-xl-0">
                                        <form class="email-search">
                                            <div class="position-relative">
                                                <input type="text" class="form-control border" placeholder="Recherche...">
                                                <span class="bx bx-search font-size-18"></span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-md-12">
                                    <div class="text-sm-end">
                                        <a class="btn btn-primary" href="{{ route('new_project') }}"><i class="mdi mdi-plus me-1"></i> Creer Projet</a>
                                    </div>
                                </div>
                            </div>


                            <div class="table-responsive">
                                <table class="table table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 40px;">
                                                <div class="form-check font-size-16">
                                                    <input type="checkbox" class="form-check-input" id="contacusercheck">
                                                    <label class="form-check-label" for="contacusercheck"></label>
                                                </div>
                                            </th>
                                            <th>Projets ( {{ $data->count() }} )</th>
                                            <th scope="col">Responsable</th>
                                            <th scope="col">Date début</th>
                                            <th scope="col">Date fin</th>
                                            <th scope="col">Statut</th>
                                         
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($data as $datas)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" type="checkbox" id="upcomingtaskCheck03">
                                                    <label class="form-check-label" for="upcomingtaskCheck03"></label>
                                                </div>
                                            </td>
                                            <td style="width:90%">
                                                <h5 class="text-truncate font-size-14 mb-2">
                                                    @php
                                                    $cryptedId = Crypt::encrypt($datas->idpr);
                                                    @endphp
                                                    <a href="{{ route('key.viewProject', $cryptedId) }}" class="text-dark">{{ $datas->title }}</a>
                                                </h5>

                                            </td>
                                            <td>
                                            {{ ucfirst($datas->nom) }} {{ ucfirst($datas->prenom) }}
                                            </td>
                                            
                                            <td>
                                            @if($datas->autorisation==1)
                <span class="badge rounded-pill bg-primary"> Projet Ouvert </span>
                @else
                <span class="badge rounded-pill bg-danger"> Fermer </span>
                @endif
              </small>
                                            </td>

                                            <td>
                                            {{ date('d.m.Y', strtotime($datas->start_date))  }}
                                            </td>

                                            <td>
                                            {{ date('d.m.Y', strtotime($datas->start_date))  }}
                                            </td>

                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="{{ route('key.viewProject', $cryptedId) }}"><i class="fa fa-eye"></i> Voir</a>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div> <!-- container-fluid -->
    </div>


</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@if(session('modal_message'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Accès refusé',
            text: "Vous n'avez pas l'accréditation nécessaire. Contactez le chef du projet pour être affecté.",
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
    });
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
@endif



</script>



@endsection