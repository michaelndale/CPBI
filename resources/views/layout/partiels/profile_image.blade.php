<div class="modal fade" id="editprofileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" id="EditprofileForm" enctype='multipart/form-data'>
        @method('post')
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-edit"></i> Modifier image profile </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="custom-file">

                <div class="progress">
                  <div id="progress" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <br>
                <input id="profileuserid" name="profileuserid" type="hidden" value="{{ Auth::user()->id }}" />
                <input type="file" class="form-control" id="file" name="file" accept="image/jpeg, image/png" onchange="preview_image(event)">
                <br> 
              </div>
              <br><br>
              <div id="wrapper">
                @php
                    $avatar = Auth::user()->avatar; // Chemin relatif vers l'image de l'utilisateur
                    $defaultAvatar = asset('element/profile/default.png'); // Chemin vers l'image par défaut (utilise asset() pour les chemins publics)
                    
                    // Vérifier si l'image existe dans le dossier public
                    $imagePath = public_path($avatar);
                    $imageExists = file_exists($imagePath) && !empty($avatar); // Assurez-vous que $avatar n'est pas vide
                @endphp
            
                @if ($imageExists)
                    <!-- Afficher l'image de l'utilisateur -->
                    <img 
                        id="output_image" 
                        src="{{ asset($avatar) }}" 
                        alt="{{ ucfirst(Auth::user()->identifiant) }}" 
                        style="width:50%; border-radius:10px; margin-left:25%"
                    >
                @else
                    <!-- Afficher l'image par défaut -->
                    <img 
                        id="output_image" 
                        src="{{ $defaultAvatar }}" 
                        alt="{{ ucfirst(Auth::user()->identifiant) }}" 
                        style="width:50%; border-radius:10px; margin-left:25%"
                    >
                @endif
            </div>

            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="addprofilebtn" id="addprofilebtn" class="btn btn-primary">Sauvegarder</button>
          </div>
        </div>
      </form>
    </div>
  </div>