@extends('layout/app')
@section('page-content')

<div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">



        
        <div class="row" >
          <div class="col-xl-9" style="margin:auto">
          <h4 class="mb-4"><i class="fa fa-folder-open "></i> Declaration projet </h4>

            <form class="row g-3 mb-6" method="POST" id="addProjectForm" >
              
                @method('post')
                @csrf

              <div class="col-sm-2 col-md-12">
                <div class="form-floating"><input class="form-control" name="title" id="title" type="text" placeholder="Titre du Projet" /><label for="floatingInputGrid">Titre du Projet</label></div>
              </div>

              <div class="col-sm-2 col-md-4">
                <div class="form-floating"><input class="form-control" name="numeroProjet" id="numeroProjet" type="text" placeholder="Numero du projet" /><label for="floatingInputGrid">Numéro du projet</label></div>
              </div>

              
              <div class="col-sm-2 col-md-4">
                <div class="form-floating"><input class="form-control" name="region" id="region" type="text" placeholder="Pays / Region" /><label for="floatingInputGrid">Pays / Region </label></div>
              </div>

              <div class="col-sm-2 col-md-4">
                <div class="form-floating">
                  <select class="form-select" id="leader" name="leader" required>
                    <option selected="selected" value="">Reponsable du projet </option>
                    @foreach ($dataMember as $dataMembers)
                    <option value="{{ $dataMembers->id }}">{{ $dataMembers->nom }} {{ $dataMembers->nom }}</option>
                    @endforeach
                   
                  </select><label for="floatingSelectAdmin">Reponsable du projet</label></div>
              </div>

              <div class="col-sm-2 col-md-4">
                <div class="form-floating"><input class="form-control" name="lieuProjet" id="lieuProjet" type="text" placeholder="Lieu et date projet " /><label for="floatingInputGrid">Lieu et date projet </label></div>
              </div>

              <div class="col-sm-2 col-md-4">
                <div class="form-floating">
                
                <select class="form-select" id="devise" name="devise" required>
                    <option selected="selected" value="">Devise</option>
                    @foreach ($devise as $devises)
                    <option value="{{ $devises->libelle }}">{{ $devises->libelle }} </option>
                    @endforeach
                   
                  </select>
                
                <label for="floatingInputGrid">Devise de comptabilité </label></div>
              </div>

             

              <div class="col-sm-2 col-md-4">
                <div class="form-floating">
                  <select class="form-select" id="numeroDossier" name="numeroDossier">
                    <option selected="selected">Sélectionner fichier </option>
                      @foreach ($dataFolder as $dataFolders)
                      <option value="{{ $dataFolders->id }}">{{ $dataFolders->title }} </option>
                      @endforeach
                  </select><label for="floatingSelectAdmin">Dossier </label></div>
              </div>
             
              <div class="col-sm-6 col-md-4">
                <div class="form-floating"><input class="form-control" id="budget"  name="budget" type="number" placeholder="Budget" /><label for="floatingInputBudget">Budget</label></div>
              </div>

              <div class="col-sm-6 col-md-4">
                <div class="flatpickr-input-container">
                  <div class="form-floating"><input class="form-control datetimepicker" id="startdate" name="startdate" type="date" placeholder="end date" data-options='{"disableMobile":true}' /><label class="ps-6" for="floatingInputStartDate">Date du commencement</label><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="flatpickr-input-container">
                  <div class="form-floating"><input class="form-control datetimepicker" id="deadline" name="deadline" type="date" placeholder="deadline" data-options='{"disableMobile":true}' /><label class="ps-6" for="floatingInputDeadline">Date de la fin</label><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
                </div>
              </div>
            
              <div class="col-12 gy-2">
                <div class="form-floating"><textarea class="form-control" id="description" name="description" placeholder="Description du projet" style="height: 100px"></textarea><label for="floatingProjectOverview">Description du projet</label></div>
              </div>
              <div class="col-12 gy-3">
                <div class="row g-3 justify-content-end">

                  <div class="col-auto"><button name="addProjectbtn" id="addProjectbtn" class="btn btn-primary px-5 px-sm-15"> Sauvegarder </button></div>
                </div>
              </div>
            </form>
          </div>
         

        </div>
        <br>
        </div>
        </div>
        </div>

<script>
    $(function() {
      // Add PROJECT ajax 
      $("#addProjectForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#addProjectbtn").text('Ajouter...');
        $.ajax({
          url: "{{ route('storeProject') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
          

            if (response.status == 200) 
              {
                toastr.success("Creation projet avec succès !", "success");
             
              $("#addProjectForm")[0].reset();
              $("#addProjectbtn").text('Enregistrer');

              var key = response.lastid;

              var url = key+'/view';
             

              window.location.href =  url;
           
            }
            if (response.status == 201) {
              toastr.info("Attention vous ne pouvez pas enregitrer le project deux fois !", "error");
            
            }

            if (response.status == 202) {
              toastr.error("Erreur d'execution, verifier votre internet", "error");
            
            }


          }

          
        });
      });

   
    });
  </script>


  @endsection