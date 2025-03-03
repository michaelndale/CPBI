<!-- resources/views/responsabilites/liste.blade.php -->

<table class="table table-striped table-sm fs--1 mb-0">
    <thead>
        <tr>
            <th><b>#</b></th>
            <th><b>Titre</b></th>
            <th><b>Créé par</b></th>
            <th><b>Créé le</b></th>
            <th><b>Actions</b></th>
        </tr>
    </thead>
    <tbody >
        @forelse ($responsabilites as $index => $responsabilite)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td><a href="{{ route('tache.index', $responsabilite->id ) }}">{{ ucfirst($responsabilite->titre)  }}</a></td>
           
            <td>{{ ucfirst($responsabilite->user_prenom) }} {{ $responsabilite->user_nom }}</td>
            <td>{{ $responsabilite->created_at->format('d-m-Y') }}</td>
            <td>

                <td align="center">
                    <div class="btn-group me-2 mb-2 mb-sm-0">
                                 <a data-bs-toggle="dropdown" aria-expanded="false">
                                     <i class="mdi mdi-dots-vertical ms-2"></i> Options
                                 </a>
     
                           <div class="dropdown-menu">
                           <a  href="{{  route('tache.index', $responsabilite->id ) }}" id="' . htmlspecialchars($rs->id) . '" href="#" class="dropdown-item mx-1 "  title="Voir les responsabilite"><i class="fa fa-list"></i> Voir les taches</a>
                         
                             <a  href="#" data-id="{{ $responsabilite->id }}" data-titre="{{ $responsabilite->titre }}" href="#" class="dropdown-item mx-1 deleteIcon" data-bs-toggle="modal" data-bs-target="#edit_functionModal" title="Modifier"><i class="far fa-trash-alt"></i> Supprimer</a>
                           </div>
                     </div>
                   </td>



            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" align="center">
                <center>
                    <h6 style="margin-top:1%; color:#c0c0c0">
                        <font size="50px"><i class="fas fa-info-circle"></i></font>
                        <br><br>Aucune responsabilité trouvée.
                    </h6>
                </center>
                
                </td>
        </tr>
    @endforelse
    </tbody>
</table>

