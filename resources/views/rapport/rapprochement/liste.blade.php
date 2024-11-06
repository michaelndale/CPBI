@foreach($rapports as $rapport)
    <tr>
        <td align="center">
            <div class="btn-group me-2 mb-2 mb-sm-0">
                <a  data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-dots-vertical ms-2"></i> Options
                </a>
                <div class="dropdown-menu">
                    <!-- Lien avec l'ID du rapport pour voir les détails -->
                    <a href="{{ route('rapporRapprochement', ['id' => $rapport->id]) }}" class="dropdown-item mx-1">
                        <i class="fas fa-eye"></i> Voir le rapport
                    </a>
                    
                    <a class="dropdown-item text-white mx-1 deleteIcon" data-id="{{ $rapport->id }}" data-numero="{{ $rapport->numero }}" href="#" style="background-color:red">
                        <i class="far fa-trash-alt"></i> Supprimer
                    </a>
                </div>
            </div>
        </td>
        <td>{{ date('d-m-Y', strtotime( $rapport->created_at)) }}</td>
        <td align="center">{{ $rapport->numero }}</td>
        <td>{{  date('d-m-Y', strtotime( $rapport->datede))  }} Au {{   date('d-m-Y', strtotime( $rapport->dateau )) }}</td>
        <td>{{ ucfirst($rapport->estab_nom)  }} {{ ucfirst($rapport->estab_prenom)  }}</td>
        <td>{{ ucfirst($rapport->verifier_nom)  }} {{ ucfirst($rapport->verifier_prenom)  }}</td>
        <td>{{ ucfirst($rapport->creator_nom)  }} {{ ucfirst($rapport->creator_prenom)  }}</td>
    </tr>
@endforeach

