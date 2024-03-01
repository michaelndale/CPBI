@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-10" style="margin:auto">
          <h4 class="mb-4"><i class="fa fa-folder-open "></i> Declaration projet </h4>
          <form class="row g-3 mb-6" method="POST" id="addProjectForm">
            @method('post')
            @csrf

            <div class="col-sm-2 col-md-12">
              <div class="form-floating"><input class="form-control" name="title" id="title" type="text" placeholder="Titre du Projet" required /><label for="floatingInputGrid">Titre du Projet</label></div>
            </div>

            <div class="col-sm-2 col-md-4">
              <div class="form-floating"><input class="form-control" name="numeroProjet" id="numeroProjet" type="text" placeholder="Numero du projet" required /><label for="floatingInputGrid">Numéro du projet</label></div>
            </div>


            <div class="col-sm-2 col-md-4">
              <div class="form-floating"><input class="form-control" name="region" id="region" type="text" placeholder="Pays / Region" required /><label for="floatingInputGrid">Pays / Region </label></div>
            </div>

            <div class="col-sm-2 col-md-4">
              <div class="form-floating">
                <select class="form-select" id="leader" name="leader" required>
                <option disabled="true" selected="true" value="">Reponsable du projet </option>
                  @foreach ($dataMember as $dataMembers)
                  <option value="{{ $dataMembers->id }}">{{ ucfirst($dataMembers->nom) }} {{ ucfirst($dataMembers->prenom) }}</option>
                  @endforeach

                </select><label for="floatingSelectAdmin">Reponsable du projet</label>
              </div>
            </div>

            <div class="col-sm-2 col-md-4">
              <div class="form-floating"><input class="form-control" name="lieuProjet" id="lieuProjet" type="text" placeholder="Lieu et date projet " required /><label for="floatingInputGrid">Lieu (province)</label></div>
            </div>

            <div class="col-sm-2 col-md-2">
              <div class="form-floating">

                <select class="form-select" id="devise" name="devise" required>
                <option disabled="true" selected="true" value="">Devise</option>
                  @foreach ($devise as $devises)
                  <option value="{{ $devises->libelle }}">{{ $devises->libelle }} </option>
                  @endforeach

                </select>

                <label for="floatingInputGrid">Devise </label>
              </div>
            </div>

            <div class="col-sm-2 col-md-2">
              <div class="form-floating">
              <input class="form-control" name="periode" id="priode" type="number" min="2" placeholder="Periode" required />
                <label for="floatingInputGrid">Periode</label>
              </div>
            </div>



            <div class="col-sm-2 col-md-4">
              <div class="form-floating">
                <select class="form-select" id="numeroDossier" name="numeroDossier" required>
                <option disabled="true" selected="true" value="">Sélectionner fichier </option>
                  @foreach ($dataFolder as $dataFolders)
                  <option value="{{ $dataFolders->id }}">{{ $dataFolders->title }} </option>
                  @endforeach
                </select><label for="floatingSelectAdmin">Dossier </label>
              </div>
            </div>

            <div class="col-sm-6 col-md-4">
              <div class="form-floating"><input class="form-control" id="budget" name="budget" type="number" placeholder="Budget" required /><label for="floatingInputBudget">Budget</label></div>
            </div>

            <div class="col-sm-6 col-md-4">
              <div class="flatpickr-input-container">
                <div class="form-floating"><input class="form-control datetimepicker" id="startdate" name="startdate" type="date" placeholder="end date" data-options='{"disableMobile":true}' required /><label class="ps-6" for="floatingInputStartDate">Date du commencement</label><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
              </div>
            </div>
            <div class="col-sm-6 col-md-4">
              <div class="flatpickr-input-container">
                <div class="form-floating"><input class="form-control datetimepicker" id="deadline" name="deadline" type="date" placeholder="deadline" data-options='{"disableMobile":true}' required /><label class="ps-6" for="floatingInputDeadline">Date de la fin</label><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
              </div>
            </div>

            <div class="col-12 gy-2">
              <div class="form-floating"><textarea class="form-control" id="description" name="description" placeholder="Description du projet" style="height: 100px" required></textarea><label for="floatingProjectOverview">Description du projet</label></div>
            </div>
            <div class="col-12 gy-4">
              <div class="row g-3 justify-content-end">
                <div class="col-auto"><button name="addProjectbtn" id="addProjectbtn" class="savebtn btn btn-primary px-5 px-sm-15">  Sauvegarder </button></div>
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
   save_btn = document.querySelector('.savebtn');
   
   save_btn.onclick = function() {
    // Add PROJECT ajax 
    $("#addProjectForm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);

      this.innerHTML = "<div class='loader'></div>";

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
            toastr.success("Creation projet avec succès !", "Enregistrement");

            $("#addProjectForm")[0].reset();
            $("#addProjectbtn").text('Enregistrer');

            var key = response.lastid;

            var url = key + '/view';


            window.location.href = url;

          }
          if (response.status == 201) {
            toastr.info("Vous ne pouvez pas enregitrer le project deux fois !", "Attention");

          }

          if (response.status == 202) {
            toastr.error("Erreur d'execution, verifier votre internet", "Attention ");

          }

          document.getElementById("connectBtn").disabled = false;

        }
   
      });
    });


  };
</script>


@endsection