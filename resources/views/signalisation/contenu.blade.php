@php
$cryptedId = Crypt::encrypt($febDetails->idf);
@endphp
        <div class="pb-3 pb-lg-4 user-chat-border">
            <div class="row">
                <div class="col-md-8 col-6">
                    <h5 class="font-size-15 mb-1 text-truncate">{{ ucfirst($febDetails->user_nom) }} {{ ucfirst($febDetails->user_prenom) }}</h5>
                    <p class="text-muted text-truncate mb-0">
                        @if($febDetails->is_connected)
                        <i class="mdi mdi-circle text-primary font-size-10 align-middle me-1"></i> 
                        Active maintenant
                         @else  
                         <i class="mdi mdi-circle text-danger font-size-10 align-middle me-1"></i> 
                         Non Active maintenant
                         @endif 
                        
                        
                        </p>
                    Projet : {{ ucfirst($febDetails->project_title) }} <br>
                    <a href="{{ route('key.viewFeb', $cryptedId ) }}" title="Aller voir le document F.E.B"><i class="mdi mdi-attachment"></i> F.E.B Numéro : {{ ucfirst($febDetails->numerofeb) }}</i> </a>
                </div>
               
            </div>
        </div>

        <div class="px-lg-3">
            <div class="pt-3">
                <form method="POST" id="addMessageForm">
                    @method('post')
                        @csrf
                <div class="row">

                   
                    <div class="col">
                        <div class="position-relative">
                            <input type="hidden" id="createfebs" name="createfebs" value="{{ $febDetails->user_id }}" class="form-control">
                        <input type="hidden" id="febids" name="febids" value="{{ $febDetails->idf }}" class="form-control" >
                            <input type="text" id="messagesignale" name="messagesignale" class="form-control chat-input" placeholder="Entrer le message...">

                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" id="btnsend" name="btnsend"  class="btn btn-primary chat-send w-md waves-effect waves-light"><span
                                class="d-none d-sm-inline-block me-2">Envoyer</span> <i
                                class="mdi mdi-send"></i></button>
                    </div>

                   


                </div>

            </form>
            </div>
        </div>

        <div class="chat-conversation py-3">
            <ul class="list-unstyled mb-0 pe-3" data-simplebar style="max-height: 580px;">
                @foreach ($DetailsSignale as $DetailsSignales)

                @if ($DetailsSignales->userid == $DetailsSignales->notisid)

                <li class="right">
                    <div class="conversation-list">
                        <div class="chat-avatar">
                            <img src="../../{{ $DetailsSignales->user_avatar }}" alt="avatar-2">
                        </div>
                        <div class="ctext-wrap">
                            <div class="conversation-name">{{ ucfirst($DetailsSignales->user_nom) }} {{ ucfirst($DetailsSignales->user_prenom) }}</div>
                            <div class="ctext-wrap-content">
                                <p class="mb-0">
                                    {{ $DetailsSignales->message }}
                                </p>
                            </div>
                            <p class="chat-time mb-0"><i class="mdi mdi-clock-outline me-1"></i> {{ \Carbon\Carbon::parse($DetailsSignales->created_at)->diffForHumans() }}</p>
                        </div>
                    </div>
                </li>
               

                @else

                <li>
                    <div class="conversation-list">
                        <div class="chat-avatar">
                            <img src="../../{{ $DetailsSignales->user_avatar }}" alt="avatar-2">
                        </div>
                        <div class="ctext-wrap">
                            <div class="conversation-name">{{ ucfirst($DetailsSignales->user_nom) }} {{ ucfirst($DetailsSignales->user_prenom) }}</div>
                            <div class="ctext-wrap-content">
                                <p class="mb-0">
                                    {{ $DetailsSignales->message }}
                                 </p>
                            </div>
                            <p class="chat-time mb-0"><i class="mdi mdi-clock-outline align-middle me-1"></i> {{ \Carbon\Carbon::parse($DetailsSignales->created_at)->diffForHumans() }}
                            </p>
                        </div>

                    </div>
                </li>


               
             
                    
                @endif
                
                    
                @endforeach
              

              

            

              
 

            </ul>
        </div>

       


        
        <script>
            $(document).ready(function() {
                // Fonction pour récupérer les détails du signalement
                function fetchSignalisationDetails(febid) {
                    $.ajax({
                        url: "{{ route('fetch-signalisation-details') }}", // Assurez-vous que cette route est bien définie dans routes/web.php
                        type: 'GET',
                        data: { febid: febid },
                        success: function(response) {
                            // Injecte la vue ou les données récupérées dans la div #showcontent
                            $('#showcontent').html(response);
                        },
                        error: function(xhr) {
                            console.log("Erreur lors de la récupération des données.");
                        }
                    });
                }
            
                // Soumission du formulaire pour envoyer les données
                $("#addMessageForm").submit(function(e) {
                    e.preventDefault();
                    const fd = new FormData(this);
            
                    $("#btnsend").html('<i class="fas fa-spinner fa-spin"></i>');
                    $("#btnsend").prop('disabled', true);
            
                    $.ajax({
                        url: "{{ route('storesignalefeb') }}", // Assurez-vous que cela correspond à votre route POST
                        method: 'POST', // Cette route devrait accepter une requête POST
                        data: fd,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 200) {
                                toastr.success("Signalisation envoyer avec succès!", "Enregistrement");
                                $("#btnsend").html('Envoyer<i class="fab fa-telegram-plane ms-1"></i>');
                                $("#addMessageForm")[0].reset(); // Réinitialiser le formulaire
                                $("#btnsend").prop('disabled', false);
                                
                                // Récupère le febid de la réponse ou d'un autre moyen
                                var febid = response.febid; // Remplace cela par le moyen approprié de récupérer l'ID
                                fetchSignalisationDetails(febid); // Appel de la fonction pour récupérer les détails
                            } else {
                                toastr.error("Une erreur s'est produite lors du traitement de votre demande.", "Erreur");
                                $("#btnsend").html('<i class="fa fa-cloud-upload-alt"></i> Envoyer');
                                $("#btnsend").prop('disabled', false);
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error("Une erreur s'est produite lors du traitement de votre demande.", "Erreur", error);
                            $("#btnsend").html('<i class="fa fa-cloud-upload-alt"></i> Envoyer');
                            $("#btnsend").prop('disabled', false);
                            toastr.error("Réponse du serveur :", xhr.responseText);
                        }
                    });
                });
            });
            </script>
            