@extends('layout/app')
@section('page-content')

<div class="content" >
        
        <div class="row" >
          <div class="col-xl-9" style="margin:auto">
          <h4 class="mb-4"><i class="fa fa-folder-open "></i> Declaration projet </h4>

            <form class="row g-3 mb-6" method="POST" id="addProjectForm" >
              
                @method('post')
                @csrf

              <div class="col-sm-6 col-md-8">
                <div class="form-floating"><input class="form-control" name="title" id="title" type="text" placeholder="Titre du Projet" /><label for="floatingInputGrid">Titre du Projet</label></div>
              </div>

              <div class="col-sm-6 col-md-4">
                <div class="form-floating"><input class="form-control" name="numeroProjet" id="numeroProjet" type="text" placeholder="Numero du projet" /><label for="floatingInputGrid">Numero du projet</label></div>
              </div>

              <div class="col-sm-5 col-md-12">
                <div class="form-floating">
                <select class="form-select" id="leader" name="leader" required>
                    <option selected="selected" value="">Ligne budgetaire</option>
                    @foreach ($compte as $comptes)
                    <option value="{{ $comptes->id }}"> {{ $comptes->numero }} {{ $comptes->libelle }} </option>

                     @php
                       $idc = $comptes->id ;
                        $res= DB::select("SELECT * FROM comptes  WHERE compteid= $idc AND souscompteid=NULL ");
                        
                     @endphp
                    @foreach($res as $res)
                         echo'<option value="{{ $res->id }} " > {{ $res->id }}  </option>
                    @endforeach
                     
                    
                    @endforeach
                   
                  </select>
                  
                  <label for="floatingInputGrid">Ligne budgetaire</label></div>
              </div>

              <div class="col-sm-6 col-md-4">
                <div class="form-floating"><input class="form-control" name="region" id="region" type="text" placeholder="Pays / Region" /><label for="floatingInputGrid">Pays / Region </label></div>
              </div>

              <div class="col-sm-6 col-md-4">
                <div class="form-floating"><select class="form-select" id="leader" name="leader" required>
                    <option selected="selected" value="">Reponsable du projet </option>
                    @foreach ($dataMember as $dataMembers)
                    <option value="{{ $dataMembers->id }}">{{ $dataMembers->name }} {{ $dataMembers->lastname }}</option>
                    @endforeach
                   
                  </select><label for="floatingSelectAdmin">Reponsable du projet</label></div>
              </div>

              <div class="col-sm-6 col-md-4">
                <div class="form-floating"><input class="form-control" name="lieuProjet" id="lieuProjet" type="text" placeholder="Lieu et date projet " /><label for="floatingInputGrid">Lieu et date projet </label></div>
              </div>

              <div class="col-sm-6 col-md-4">
                <div class="form-floating"><input class="form-control" name="devise" id="devise" type="text" placeholder="Devise de comptabilite " /><label for="floatingInputGrid">Devise de comptabilite </label></div>
              </div>

              <div class="col-sm-6 col-md-4">
                <div class="form-floating"><input class="form-control" name="numeroRapport" id="numeroRapport" type="text" placeholder="Devise de comptabilite " /><label for="floatingInputGrid">Rapport financier N<sup>o</sup></label></div>
              </div>

              <div class="col-sm-6 col-md-4">
                <div class="form-floating">
                  <select class="form-select" id="numeroDossier" name="numeroDossier">
                    <option selected="selected">Select folder </option>
                      @foreach ($dataFolder as $dataFolders)
                      <option value="{{ $dataFolders->id }}">{{ $dataFolders->flibelle }} </option>
                      @endforeach
                  </select><label for="floatingSelectAdmin">Folder  </label></div>
              </div>

           

            
             

              <div class="col-sm-6 col-md-4">
                <div class="form-floating"><input class="form-control" id="budget"  name="budget" type="text" placeholder="Budget" /><label for="floatingInputBudget">Budget</label></div>
              </div>

              <div class="col-sm-6 col-md-4">
                <div class="flatpickr-input-container">
                  <div class="form-floating"><input class="form-control datetimepicker" id="startdate" name="startdate" type="text" placeholder="end date" data-options='{"disableMobile":true}' /><label class="ps-6" for="floatingInputStartDate">Start date</label><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4">
                <div class="flatpickr-input-container">
                  <div class="form-floating"><input class="form-control datetimepicker" id="deadline" name="deadline" type="text" placeholder="deadline" data-options='{"disableMobile":true}' /><label class="ps-6" for="floatingInputDeadline">Deadline</label><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
                </div>
              </div>
            
              <div class="col-12 gy-6">
                <div class="form-floating"><textarea class="form-control" id="description" name="description" placeholder="Leave a comment here" style="height: 100px"></textarea><label for="floatingProjectOverview">project overview</label></div>
              </div>

              <!--
              <div class="col-md-6 gy-6">
                <div class="form-floating"><select class="form-select" id="floatingSelectClient">
                    <option selected="selected">Select client</option>
                    <option value="1">Client One</option>
                    <option value="2">Client Two</option>
                    <option value="3">Client Three</option>
                  </select><label for="floatingSelectClient">client</label></div>
              </div>
             
              <div class="col-12 gy-6"><select class="form-select" id="organizerMultiple" data-choices="data-choices" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}'>
                  <option value="">Add tags</option>
                  <option>Stupidity</option>
                  <option>Jerry</option>
                  <option>Not_the_mouse</option>
                  <option>Rick</option>
                  <option>Biology</option>
                  <option>Neurology</option>
                  <option>Brainlessness</option>
                </select></div>


-->
              <div class="col-12 gy-6">
                <div class="row g-3 justify-content-end">
                  <div class="col-auto"><button type="reset" class="btn btn-danger px-5">Cancel</button></div>
                  <div class="col-auto"><button name="addProjectbtn" id="addProjectbtn" class="btn btn-primary px-5 px-sm-15">Create Project</button></div>
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
        $("#addProjectbtn").text('Adding...');
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
              $.notify("You have Successfully add a project !", "success");
            }
            $("#addProjectbtn").text('Add Project');
            $("#addProjectForm")[0].reset();
          }
        });
      });

   
    });
  </script>


  @endsection