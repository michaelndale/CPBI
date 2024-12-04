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
                            <table id="datatable" class="table table-bordered dt-responsive nowrap   fs--1 mb-0" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th><b>Projets  ( {{ $data->count() }} )</b> </th>
                                    <th><b>Responsable du projet</b></th>
                                    <th><center><b>Accès</b </center></th>
                                    <th><center><b>Statut</b></center></th>
                                    <th><b>Date début</b></th>
                                    <th><b>Date fin</b></th>
                                </thead>

                                <tbody>
                                    @foreach ($data as $datas)
                                    <tr>
                                        <td style="width: 100px;">
                                            @php
                                                $cryptedId = Crypt::encrypt($datas->idpr);
                                            @endphp
                                            <a href="{{ route('key.viewProject', $cryptedId) }}" class="text-dark">{{ $datas->title }}</a>
                                        </td>
                                        <td>
                                            {{ ucfirst($datas->nom) }} {{ ucfirst($datas->prenom) }}
                                        </td>


                                        <td align="center">
                                           
                                            @php
                                            $accessCount = DB::table('affectations')
                                                            ->where('memberid', Auth::id())
                                                            ->where('projectid', $datas->idpr)
                                                            ->count();
                                        @endphp

                                       
                                        
                                        @if($accessCount == 1)
                                            <font size="2px" color="green">
                                                <i class="mdi mdi-check-decagram"></i>
                                            </font>
                                        @else
                                            <font size="2px" color="red">
                                                <i class="mdi mdi-close-circle"></i>
                                            </font>
                                        @endif
                                        
                                        
                                        </td>


                                        <td align="center">
                                         

                                                @if($datas->autorisation==1)
                                                <span class="badge rounded-pill bg-primary"> &nbsp;&nbsp; Ouvert &nbsp;&nbsp; </span>
                                        @else
                                                <span class="badge rounded-pill bg-danger"> Fermer </span>
                                        @endif
                                        </small>
                                           
                                           
                                        </td>





                                        <td>
                                            {{ date('d-m-Y', strtotime($datas->start_date))  }}
                                        </td>

                                        <td>
                                            {{ date('d-m-Y', strtotime($datas->deadline))  }}
                                        </td>

                                        <!--  <td>
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="{{ route('key.viewProject', $cryptedId) }}"><i class="fa fa-eye"></i> Voir</a>
                                                    </div>
                                                </div>
                                            </td> 
                                        -->

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->


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