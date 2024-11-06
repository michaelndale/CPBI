@php
    $avatar = Auth::user()->avatar;
    $defaultAvatar = '../../element/profile/default.png'; // Chemin vers votre image par défaut
    $imagePath = public_path($avatar);
    $personnelData = DB::table('personnels')
        ->where('id', Auth::user()->personnelid)
        ->first();

    $feb_liste = DB::table('febs')
    ->orderBy('id', 'DESC')
    ->join('projects', 'febs.projetid', '=', 'projects.id')
    ->join('affectations', 'febs.projetid', '=', 'affectations.projectid')
    ->join('users', 'febs.userid', '=', 'users.id')
    ->join('personnels', 'users.personnelid', '=', 'personnels.id')
    ->select('febs.*',  'personnels.prenom as user_prenom',  'personnels.nom as user_nom', 'users.avatar as user_avatar' , 'users.is_connected' , 'projects.title as project_title')
    ->where('febs.signale', '=', 1)
    ->distinct() // Ajoute distinct pour éviter la duplication
    ->get('febs.id'); // Compter uniquement les enregistrements uniques de 'febs'

    $dap_liste = DB::table('daps')
    ->join('projects', 'daps.projetiddap', '=', 'projects.id')
    ->join('affectations', 'daps.projetiddap', '=', 'affectations.projectid')
    ->where('daps.signaledap', '=', 1)
    ->distinct() // Ajoute distinct pour éviter la duplication
    ->count('daps.id'); // Compter uniquement les enregistrements uniques de 'DAPs'

@endphp

<div class="d-lg-flex mb-4">
    <div class="chat-leftsidebar me-4">
        <div class="card mb-0">
            <div class="card-body pt-0">
                <div class="py-3 border-bottom">
                    <div class="d-flex">
                        <div class="align-self-center me-3">
                            @if (file_exists($imagePath))
                                <img src="../../{{ $avatar }}" alt="{{ ucfirst(Auth::user()->identifiant) }}"
                                    class="avatar-xs rounded-circle" alt="avatar-2">
                            @else
                                <img src="{{ $defaultAvatar }}" alt="{{ ucfirst(Auth::user()->identifiant) }}"
                                    class="avatar-xs rounded-circle" alt="avatar-2">
                            @endif
                        </div>
                        <div class="flex-1">
                            <h5 class="font-size-15 mb-1"> {{ ucfirst($personnelData->prenom) }} {{ ucfirst($personnelData->prenom) }}</h5>
                            <p class="text-muted mb-0"><i class="mdi mdi-circle text-primary font-size-10 align-middle me-1"></i> Active</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content py-4">
            <ul class="list-unstyled chat-list"  id="liste-feb-signalisation" data-simplebar style="max-height: 415px;">
               
                @foreach ($feb_liste as $feb_listes)
                <li class="active">
                    <a href="#" class="mt-0 feb-item" data-febid="{{ $feb_listes->id }}">
                        <div class="d-flex">
                            <div class="user-img  @if($feb_listes->is_connected) online  @else  away  @endif align-self-center me-3">
                                <img src="../../{{ $feb_listes->user_avatar }}" class="rounded-circle avatar-xs" alt="avatar-2">
                               
                             
                                 <span class="user-status"></span>
                               
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <h5 class="text-truncate font-size-14 mb-1"> {{    ucfirst($feb_listes->user_prenom)  }} {{    ucfirst($feb_listes->user_nom) }}</h5>
                                <p class="text-truncate mb-0">Numero FEB:{{ $feb_listes->numerofeb  }}</p>
                                <small>{{ $feb_listes->project_title  }}</small>
                            </div>
                            <div class="font-size-11"> {{ \Carbon\Carbon::parse($feb_listes->created_at)->diffForHumans() }}

                            </div>
                        </div>
                    </a>
                </li>   
                @endforeach
            </ul>
        </div>
    </div>

    <div class="w-100 user-chat mt-4 mt-sm-0 showcontent"  id="showcontent" >
       



    </div>
</div>
<!-- end row -->

<style>
   #showcontent {
    max-height: 600px; /* Limite la hauteur */
    width: 60%; /* Ajuste la largeur pour ne pas occuper tout l'écran */
    overflow-y: auto; /* Ajoute une barre de défilement si nécessaire */
   /* background-color: #f8f9fa; /* Couleur de fond légère */
    padding: 15px; /* Espace intérieur */
    border-radius: 8px; /* Coins arrondis */
    margin-left: auto; /* Pour centrer le contenu à droite */
    margin-right: auto; /* Pour éviter le dépassement */
}

</style>

<script>
    $(document).ready(function() {
        $('.feb-item').on('click', function(e) {
            e.preventDefault();
    
            // Récupère l'attribut data-febid
            var febid = $(this).data('febid');
    
            // Requête AJAX pour récupérer les données associées au febid
            $.ajax({
                url: "{{ route('fetch-signalisation-details') }}", // Assurez-vous que cette route est bien définie dans routes/web.php
                type: 'GET', // Assurez-vous que la méthode est bien GET
                data: { febid: febid },
                success: function(response) {
                    // Injecte la vue ou les données récupérées dans la div #contenu
                    $('#showcontent').html(response);
                },
                error: function(xhr) {
                    console.log("Erreur lors de la récupération des données.");
                }
            });
        });
    
      
    });
    </script>
    
    
