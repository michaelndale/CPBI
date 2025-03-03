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
        @forelse ($taches as $index => $tache)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ ucfirst($tache->titre)  }}</td>
           
            <td>{{ ucfirst($tache->user_prenom) }} {{ $tache->user_nom }}</td>
            <td>{{ $tache->created_at->format('d-m-Y') }}</td>
            <td>
                <div class="text-center">
                    <a href="#" class="editIcon" data-id="{{ $tache->id }}"><i class="far fa-edit"></i></a>
                    <a href="#" class="deleteIcon" data-titre="{{ $tache->titre }}" data-id="{{ $tache->id }}"><i class="far fa-trash-alt"></i></a>
                </div>
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

