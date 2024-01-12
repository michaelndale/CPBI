@extends('layout/app')
@section('page-content')

<div class="content">
        <div class="row gy-3 mb-6 justify-content-between">
          <div class="col-md-8 col-auto">
            <h2 class="mb-2 text-1100">Tableau de bord des projets</h2>
            <h5 class="text-70 fw-semi-bold">COMMUNAUTÉ DES EGLISES DE PENTECÔTE AU BURUNDI “CEPBU” </h5>
          </div>
          <div class="col-md-4 col-auto">
          
          
           
            <div class="flatpickr-input-container">

            
              <e class="form-control ps-6 " >  @include('dashboard.time')</e>
              <span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
          </div>
        </div>
        <div class="row mb-3 gy-6">
          <div class="col-12 col-xxl-2">
            <div class="row align-items-center g-3 g-xxl-0 h-100 align-content-between">
              <div class="col-12 col-sm-6 col-md-3 col-lg-6 col-xl-3 col-xxl-12">
                <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-books text-primary-500"></span>
                  <div class="ms-2">
                    <div class="d-flex align-items-end">
                      <h2 class="mb-0 me-2"> {{ $project->count(); }}</h2><span class="fs-1 fw-semi-bold text-900">Projets</span>
                    </div>
                    <p class="text-800 fs--1 mb-0">Tous les classeurs</p>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3 col-lg-6 col-xl-3 col-xxl-12">
                <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-users-alt text-success-500"></span>
                  <div class="ms-2">
                    <div class="d-flex align-items-end">
                      <h2 class="mb-0 me-2">{{ $user->count(); }}</h2><span class="fs-1 fw-semi-bold text-900">Personneles</span>
                    </div>
                    <p class="text-800 fs--1 mb-0">Tous confondu</p>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3 col-lg-6 col-xl-3 col-xxl-12">
                <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-invoice text-warning-500"></span>
                  <div class="ms-2">
                    <div class="d-flex align-items-end">
                      <h2 class="mb-0 me-2"> {{ $activite->count(); }}</h2><span class="fs-1 fw-semi-bold text-900">Activite</span>
                    </div>
                    <p class="text-800 fs--1 mb-0">Toutes</p>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3 col-lg-6 col-xl-3 col-xxl-12">
                <div class="d-flex align-items-center"><span class="fs-4 lh-1 uil uil-refresh text-danger-500"></span>
                  <div class="ms-2">
                    <div class="d-flex align-items-end">
                      <h2 class="mb-0 me-2"> {{ $encours }}</h2><span class="fs-1 fw-semi-bold text-900">Projet</span>
                    </div>
                    <p class="text-800 fs--1 mb-0">Encours d'execution</p>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="mx-lg-n4 mt-3">
          <div class="row g-3">
            <div class="col-12 col-xl-12 col-xxl-7">
              <div class="card todo-list h-100">
                <div class="card-header border-bottom-0 pb-0">
                  <div class="row justify-content-between align-items-center mb-3">
                    <div class="col-12 col-sm-6 col-md-4 ">
                      <h3 class="text-1100">Projet </h3>
                      <p class="mb-0 text-700">Bref résumé de tous les projets</p>
                    </div>
                    <div class="col-12 col-sm-2 col-md-7">
                      <div class="row align-items-center g-0 justify-content-between">
                         <div class="col-2 col-sm-2 col-md-8 ">
                          <div class="search-box w-100 mb-2 mb-sm-0" style="max-width:30rem;">
                         
                            <select class="form-select classcategory" id="compte_id" aria-label="Default select example">
                              <option disabled="true" selected="true"> --Classement de dossier--</option>
                              @foreach ($folder as $folders)
                              <option value="{{ $folders->id }}">{{ $folders->title }} </option>
                              @endforeach
                            </select>
                             
                           
                          </div>
                        </div>
                        <div class="col-2 col-sm-2 col-md-3">
                        <select  class="form-select annee" id="annee">
                              <option value="0" disabled="true" selected="true">-- Année --</option>
                            
                            </select>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="card-body py-0 scrollbar to-do-list-body">

                <table class="table table-striped table-sm fs--1 mb-0">
                  <tr>
                    <th>Numéro du projet:</th>
                    <th>Titre projet</th>
                    <th>Date debut </th>
                    <th>Date fin </th>
                    <th>Année </th>
                  </tr>
                 <tbody class="list tableviewsclass">
                          <td colspan="5">
                          <h4 style="margin-top:10% ;color:#c0c0c0"> <center><font size="100px"><i class="fa fa-search"  ></i> </font><br><br>
                                        Sélectionner le classeur et l'année</center> </h4>

                          </td>
               
                 </tbody>

                </table>

             
                 
                </div>
                <div class="card-footer border-0"><a class="fw-bold fs--1 mt-4" href="{{ route('new_project') }}"><span class="fas fa-plus me-1"></span>Ajouter nouveau projet </a></div>
              </div>
            </div>
            
          </div>
        </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){

		$(document).on('change','.classcategory',function(){
			var cat_id=$(this).val();
			var div=$(this).parent();
			var op=" ";
			$.ajax({
				type:'get',
				url:"{{ route ('findClaseur') }}",
				data:{'id':cat_id},
				success:function(data){
          console.log(data);
          if(data.length == 0){
            op+='<option value="0" selected disabled> --Année-- </option>';
            op+='<option value="0" selected disabled>Aucun</option>';
            document.getElementById("annee").innerHTML = op
            alert("Attention!!\n le classeur n'a pas de projet refferencer ! ");

            
          }else{
            op+='<option value="0" selected disabled> --Année-- </option>';
					for(var i=0;i<data.length;i++){
					op+='<option value="'+data[i].annee+'">'+data[i].annee+'</option>';
          document.getElementById("annee").innerHTML = op
          }
          }
				 
				},
				error:function(){
          alert("Attention! \n Erreur de connexion a la base de donnee ,\n verifier votre connection");
				}
			});
		});

		$(document).on('change','.annee',function () {
			var ann_id=$(this).val();
    

			var a=$(this).parent();
		
			var op="";
			$.ajax({
				type:'get',
				
        url:"{{ route ('findAnnee') }}",
				data:{'id':ann_id},
				dataType:'json',
				success:function(data){

          if(data.length !== 0){
        var tarea = '';
        
        for(var i=0;i<data.length;i++){
          var idr = data[i].id;
         
          var url = "{{route('key.viewProject', ':id')}}";
          url = url.replace(':id', idr);

          tarea += '<tr>';
          tarea += '<td><a href='+url+'>#'+data[i].numeroprojet+'</a></td>';
          tarea += '<td class="align-middle ">'+data[i].title+'</td>';
          tarea += '<td class="align-middle">'+data[i].start_date+'</td>';
          tarea += '<td class="align-middle">'+data[i].deadline+'</td>';
          tarea += '<td class="align-middle">'+data[i].annee+'</td>';
          tarea += '</tr>';
        
         }
        $('.tableviewsclass').html(" ");
        $('.tableviewsclass').html(tarea);
        }else{

          tarea += '<tr>';
          tarea += '<td class="align-middle">Pas de projet </td>';
          tarea += '</tr>';
        }

				},
				error:function(){

				}
			});


		});

	});
</script>



  
@endsection