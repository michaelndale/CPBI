     <div class="modal fade" id="verticallyCentered" tabindex="-1" aria-labelledby="verticallyCenteredModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
           <div class="modal-body">
             <p class="text-700 lh-lg mb-0">
               <center> <br>
                 <font size="4"> Vous voulez-vous vraiment quitter le projet ? </font> <br> <br>
                 <a href="{{ route('closeproject') }}" tabindex="-1" aria-labelledby="deconnecterModalLabel" aria-hidden="true" class="btn btn-primary" type="button">Oui quitter </a> &nbsp; <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"> Non , rester </button>
               </center>
             </p>
           </div>
         </div>
       </div>
     </div>

     <div class="modal fade" id="deconnecterModalLabel" tabindex="-1" aria-labelledby="deconnecterModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
           <div class="modal-body">
             <p class="text-700 lh-lg mb-0">
               <center> <br>
                 <font size="4"> Voulez-vous vraiment vous déconnecter ? </font> <br> <br>
                 <a href="{{ route('logout') }}" class="btn btn-primary" type="button">Oui </a> &nbsp; <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"> Non </button>
               </center>
             </p>
           </div>
         </div>
       </div>
     </div>
     </div>



     <div class="modal fade" id="EditPersonnelModal" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog">
         <form id="EditPersonnelForm" autocomplete="off">
           @method('post')
           @csrf
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-edit"></i> Modifier mon compte</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
             </div>
             <div class="modal-body">
               <div class="row">

                 <input id="per_id" name="per_id" type="hidden" />

                 <div class="col-sm-6 col-md-6">
                   <div class="form-floating mb-3">
                     <input class="form-control" id="per_nom" name="per_nom" type="text" required="required" placeholder="Identifiant" />
                     <label for="Identifiant">Nom</label>
                     <span id="identifiant_error" name="nom_error" class="text text-danger"> </span>
                   </div>
                 </div>
                 <div class="col-sm-6 col-md-6">
                   <div class="form-floating mb-3">
                     <input class="form-control" id="per_prenom" type="text" name="per_prenom" required="required" placeholder="Password" />
                     <label for="Password">Prénom </label>
                   </div>
                 </div>
               </div>

               <div class="row">
                 <div class="col-sm-6 col-md-6">
                   <div class="form-floating mb-3">
                     <select class="form-control" id="per_sexe" name="per_sexe" type="text" required="required" placeholder="Identifiant">
                       <option value="">Séléctionner genre</option>
                       <option value="Femme">Femme</option>
                       <option value="Homme">Homme</option>
                     </select>
                     <label for="sexe">Sexe</label>
                   </div>
                 </div>
                 <div class="col-sm-6 col-md-6">
                   <div class="form-floating mb-3">
                     <input class="form-control" id="per_phone" type="text" name="per_phone" required="required" placeholder="Téléphone" />
                     <label for="Password">Téléphone </label>
                   </div>
                 </div>
               </div>

               <div class="row">
                 <div class="col-sm-12 col-md-12">
                   <div class="form-floating mb-3">
                     <input class="form-control" id="per_email" name="per_email" type="text" required="required" placeholder="Email" />
                     <label for="email">Email</label>
                     <span id="email_error" name="email_error" class="text text-danger"> </span>
                   </div>
                 </div>
               </div>
             </div>
             <div class="modal-footer">

               <button type="submit" name="EditPersonnelbtn" id="EditPersonnelbtn" class="btn btn-primary">Sauvegarder</button>
             </div>
           </div>
         </form>
       </div>
     </div>




     <div class="modal fade" id="editMotdepasseModal" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog">
         <form id="EditNDPForm" autocomplete="off">
           @method('post')
           @csrf
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-edit"></i> Modifier mot de passe </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
             </div>
             <div class="modal-body">
               <div class="row">
                 <div class="col-sm-6 col-md-12">
                   <div class="form-floating mb-3">
                     <input id="userid" name="userid" type="hidden" value="{{ Auth::user()->id }}" />

                     <input class="form-control" id="anpwd" name="anpwd" type="password" required="required" placeholder="Ancient mot de passe" />
                     <label for="Identifiant">Anciant mot de paase</label>
                     <span id="identifiant_error" name="ancienmotdepasse_error" class="text text-danger"> </span>
                   </div>
                 </div>
                 <div class="col-sm-6 col-md-12">
                   <div class="form-floating mb-3">
                     <input class="form-control" id="npwd" name="npwd" type="password" required="required" placeholder="Nouveau mot de passe" />
                     <label for="Identifiant">Nouveau mot de paase</label>
                     <span id="identifiant_error" name="nouveaumotdepasse_error" class="text text-danger"> </span>
                   </div>
                 </div>
                 <div class="col-sm-6 col-md-12">
                   <div class="form-floating mb-3">
                     <input class="form-control" id="cpwd" name="cpwd" type="password" required="required" placeholder="Confirmation le nouveau mot de passe" />
                     <label for="Password">Confirmer le nouveau mot de passe</label>
                   </div>
                 </div>
               </div>




             </div>
             <div class="modal-footer">
               <button type="submit" name="addNDPbtn" id="addNDPbtn" class="btn btn-primary">Sauvegarder</button>
             </div>
           </div>
         </form>
       </div>
     </div>

     <div class="modal fade" id="editprofileModal" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog">
         <form id="EditprofileForm" autocomplete="off">
           @method('post')
           @csrf
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-edit"></i> Modifier profile </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
             </div>
             <div class="modal-body">
               <div class="row">
                 <div class="custom-file">
                   <input id="personneidp" name="personneidp" type="hidden" value="{{ Auth::user()->id }}" />
                   <input type="file"  class="form-control" id="customFile" name="image" accept="image/*" onchange="preview_image(event)">

                 
                 </div>
                 <br><br>


                 <div id="wrapper">
                   @php
                   $avatar = Auth::user()->avatar;
                   @endphp
                   <img src="{{  asset($avatar) }}" id="output_image" class="" style="width:50%; border-radius:10px ; margin-left:25% ">
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



     <div class="modal fade" id="editsignatureModal" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog">
         <form id="EditsignatureForm" autocomplete="off">
           @method('post')
           @csrf
           <div class="modal-content">
             <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-edit"></i> Modifier le signature </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
             </div>
             <div class="modal-body">
               <div class="row">
                 <div class="custom-file">
                   <input id="personneidp" name="personneidp" type="hidden" value="{{ Auth::user()->id }}" />
                   <input type="file"  class="form-control" id="customFile" name="signature" accept="image/*" onchange="preview_image(event)">
                 </div>
                 <br><br>


                 <div id="wrapper">
                   @php

                   $signature = Auth::user()->signature;

                   @endphp
                   <img src="{{  asset($signature) }}" id="output_image" class="" style="width:50%; border-radius:10px ; margin-left:25% ">
                 </div>
               </div>
             </div>
             <div class="modal-footer">
               <button type="submit" name="addsignaturebtn" id="addsignaturebtn" class="btn btn-primary">Sauvegarder</button>
             </div>
           </div>
         </form>
       </div>
     </div>






     <script>
       function preview_image(event) {
         var reader = new FileReader();
         reader.onload = function() {
           var output = document.getElementById('output_image');
           output.src = reader.result;
         }
         reader.readAsDataURL(event.target.files[0]);
       }


       $(function() {
         // Edit personnel ajax request
         $(document).on('click', '.editpersonnel', function(e) {
           e.preventDefault();
           let id = $(this).attr('id');
           $.ajax({
             url: "{{ route('showPersonnel') }}",
             method: 'get',
             data: {
               id: id,
               _token: '{{ csrf_token() }}'
             },
             success: function(response) {

               $("#per_id").val(response.id);
               $("#per_nom").val(response.nom);
               $("#per_prenom").val(response.prenom);
               $("#per_sexe").val(response.sexe);
               $("#per_phone").val(response.phone);
               $("#per_email").val(response.email);
             }
           });
         });

         $(document).on('click', '.voirphotopersonnel', function(e) {
           e.preventDefault();
           let id = $(this).attr('id');
           $.ajax({
             url: "{{ route('showPersonnel') }}",
             method: 'get',
             data: {
               id: id,
               _token: '{{ csrf_token() }}'
             },
             success: function(response) {

               
               $("#perphoto").val(response.avatar);
             }
           });
         });

         

         // update personnel ajax request
         $("#EditPersonnelForm").submit(function(e) {
           e.preventDefault();
           const fd = new FormData(this);
           $("#EditPersonnelbtn").text('Mise à jour...');
           $.ajax({
             url: "{{ route('updatPersonnel') }}",
             method: 'post',
             data: fd,
             cache: false,
             contentType: false,
             processData: false,
             dataType: 'json',
             success: function(response) {
               if (response.status == 200) {
                 toastr.success("Mise à jour  avec succès !", "success");
                 $("#EditPersonnelModal").modal('show');

               }

               if (response.status == 202) {
                 toastr.error("Erreur d'execution, verifier votre internet", "error");
                 $("#EditPersonnelModal").modal('show');
               }

               $("#EditPersonnelbtn").text('Sauvegarder');

             }
           });
         });

         // update password ajax request
         $("#EditNDPForm").submit(function(e) {
           e.preventDefault();
           const fd = new FormData(this);
           $("#EditNDPbtn").text('Mise à jour...');
           $.ajax({
             url: "{{ route('updatUser') }}",
             method: 'post',
             data: fd,
             cache: false,
             contentType: false,
             processData: false,
             dataType: 'json',
             success: function(response) {
               if (response.status == 200) {
                 toastr.success("Mise à jour reussi  avec succès !", "success");
                 $("#editMotdepasseModal").modal('hide');

               }

               if (response.status == 202) {
                 toastr.error("Erreur d'execution, verifier votre internet", "error");
                 $("#editMotdepasseModal").modal('show');
               }

               $("#EditNDPbtn").text('Sauvegarder');

             }
           });
         });


         // update password ajax request
         $("#EditprofileForm").submit(function(e) {
           e.preventDefault();
           const fd = new FormData(this);
           $("#Editprofilebtn").text('Mise à jour...');
           $.ajax({
             url: "{{ route('updatProfile') }}",
             method: 'post',
             data: fd,
             cache: false,
             contentType: false,
             processData: false,
             dataType: 'json',
             success: function(response) {
               if (response.status == 200) {
                 toastr.success("Mise à jour reussi  avec succès !", "success");
                 $("#editprofileModal").modal('hide');

               }

               if (response.status == 202) {
                 toastr.error("Erreur d'execution, verifier votre internet", "error");
                 $("#editprofileModal").modal('show');
               }

               $("#Editprofilebtn").text('Sauvegarder');

             }
           });
         });

         // update password ajax request
         $("#EditsignatureForm").submit(function(e) {
           e.preventDefault();
           const fd = new FormData(this);
           $("#Editsignaturebtn").text('Mise à jour...');
           $.ajax({
             url: "{{ route('updatsignature') }}",
             method: 'post',
             data: fd,
             cache: false,
             contentType: false,
             processData: false,
             dataType: 'json',
             success: function(response) {
               if (response.status == 200) {
                 toastr.success("Mise à jour reussi  avec succès !", "success");
                 $("#editsignatureModal").modal('hide');

               }

               if (response.status == 202) {
                 toastr.error("Erreur d'execution, verifier votre internet", "error");
                 $("#editsignatureModal").modal('show');
               }

               $("#Editsignaturebtn").text('Sauvegarder');

             }
           });
         });


       });
     </script>
     <!-- Right bar overlay-->
     <div class="rightbar-overlay"></div>
     <!-- JAVASCRIPT -->
     <script src="{{ asset('element/assets/libs/jquery/jquery.min.js') }}"></script>
     <script src="{{ asset('element/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
     <script src="{{ asset('element/assets/libs/metismenu/metisMenu.min.js') }}"></script>
     <script src="{{ asset('element/assets/libs/simplebar/simplebar.min.js') }}"></script>
     <script src="{{ asset('element/assets/libs/node-waves/waves.min.js') }}"></script>
     <script src="{{ asset('element/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
     <script src="{{ asset('element/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

     <script src="{{ asset('element/assets/js/app.js') }}"></script>


      <!-- Sweet Alerts js -->
      <script src="{{ asset('element/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Sweet alert init js-->
    <script src="{{ asset('element/assets/js/pages/sweet-alerts.init.js') }}"></script>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



     @if(Session::has('success'))
     <script>
       toastr.success("{{ Session::get('success') }}")
     </script>
     @elseif(Session::has('failed'))
     <script>
       toastr.error("{{ Session::get('failed') }}")
     </script>
     @elseif(Session::has('info'))
     <script>
       toastr.info("{{ Session::get('info') }}")
     </script>
     @endif

     </body>

     </html>