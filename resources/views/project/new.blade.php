@extends('layout/app')
@section('page-content')

<div class="content" >
        
        <div class="row" >
          <div class="col-xl-9" style="margin:auto">
          <h4 class="mb-4"><i class="fa fa-folder-open "></i> Declaration projet </h4>

            <form class="row g-3 mb-6" method="POST" id="addProjectForm" >
              
                @method('post')
                @csrf

              <div class="col-sm-2 col-md-9">
                <div class="form-floating"><input class="form-control" name="title" id="title" type="text" placeholder="Titre du Projet" /><label for="floatingInputGrid">Titre du Projet</label></div>
              </div>

              <div class="col-sm-2 col-md-3">
                <div class="form-floating"><input class="form-control" name="numeroProjet" id="numeroProjet" type="text" placeholder="Numero du projet" /><label for="floatingInputGrid">Numero du projet</label></div>
              </div>

              <div class="col-sm-2 col-md-12">
                <div class="form-floating">
                <select class="form-select" id="ligne" name="ligne" required>
                    <option selected="selected" value="">Ligne budgetaire</option>
                    @foreach ($compte as $comptes)
                        <option value="{{ $comptes->id }}"> {{ $comptes->numero }}. {{ $comptes->libelle }} </option>
                          @php
                            $idc = $comptes->id ;
                              $res= DB::select("SELECT * FROM comptes  WHERE compteid= $idc");
                          @endphp
                          @foreach($res as $re)
                            <option value="{{ $re->id }}" > {{ $re->numero }}. {{ $re->libelle }}  </option>
                          @endforeach 
                    @endforeach
                  </select>
                  
                  <label for="floatingInputGrid">Ligne budgetaire</label></div>
              </div>

              <div class="col-sm-2 col-md-4">
                <div class="form-floating"><input class="form-control" name="region" id="region" type="text" placeholder="Pays / Region" /><label for="floatingInputGrid">Pays / Region </label></div>
              </div>

              <div class="col-sm-2 col-md-4">
                <div class="form-floating">
                  <select class="form-select" id="leader" name="leader" required>
                    <option selected="selected" value="">Reponsable du projet </option>
                    @foreach ($dataMember as $dataMembers)
                    <option value="{{ $dataMembers->id }}">{{ $dataMembers->name }} {{ $dataMembers->lastname }}</option>
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
                
                <label for="floatingInputGrid">Devise de comptabilite </label></div>
              </div>

              <div class="col-sm-2 col-md-4">
                <div class="form-floating"><input class="form-control" name="numeroRapport" id="numeroRapport" type="text" placeholder="Devise de comptabilite " /><label for="floatingInputGrid">Rapport financier N<sup>o</sup></label></div>
              </div>

              <div class="col-sm-2 col-md-4">
                <div class="form-floating">
                  <select class="form-select" id="numeroDossier" name="numeroDossier">
                    <option selected="selected">Selectionner fichier </option>
                      @foreach ($dataFolder as $dataFolders)
                      <option value="{{ $dataFolders->id }}">{{ $dataFolders->title }} </option>
                      @endforeach
                  </select><label for="floatingSelectAdmin">Dossier </label></div>
              </div>
             
              <div class="col-sm-6 col-md-4">
                <div class="form-floating"><input class="form-control" id="budget"  name="budget" type="text" placeholder="Budget" /><label for="floatingInputBudget">Budget</label></div>
              </div>

              <div class="col-sm-6 col-md-4">
                <div class="flatpickr-input-container">
                  <div class="form-floating"><input class="form-control datetimepicker" id="startdate" name="startdate" type="text" placeholder="end date" data-options='{"disableMobile":true}' /><label class="ps-6" for="floatingInputStartDate">Date du commencement</label><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="flatpickr-input-container">
                  <div class="form-floating"><input class="form-control datetimepicker" id="deadline" name="deadline" type="text" placeholder="deadline" data-options='{"disableMobile":true}' /><label class="ps-6" for="floatingInputDeadline">Date de la fin</label><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
                </div>
              </div>
            
              <div class="col-12 gy-2">
                <div class="form-floating"><textarea class="form-control" id="description" name="description" placeholder="Leave a comment here" style="height: 100px"></textarea><label for="floatingProjectOverview">project overview</label></div>
              </div>
              <div class="col-12 gy-3">
                <div class="row g-3 justify-content-end">
                  <div class="col-auto"><button type="reset" class="btn btn-danger px-5"> <i class="fa fa-times-circle"></i> Anuller</button></div>
                  <div class="col-auto"><button name="addProjectbtn" id="addProjectbtn" class="btn btn-primary px-5 px-sm-15"> <i class="fa fa-checked-circle"></i>  Enregitrer </button></div>
                </div>
              </div>
            </form>
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
          

            if (response.status == 200) {
              $.notify("Creation projet avec succès !", "success");
             
              $("#addProjectForm")[0].reset();
              $("#addProjectbtn").text('Enregistrer');
           
            }
            if (response.status == 201) {
              $.notify("Attention vous ne pouvez pas enregitrer le project deux fois !", "error");
            
            }

            if (response.status == 202) {
              $.notify("Erreur d'execution, verifier votre internet", "error");
            
            }


          }

          
        });
      });

   
    });
  </script>


  @endsection