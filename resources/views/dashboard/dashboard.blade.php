@extends('layout/app')
@section('page-content')

            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Tableau de bord des projets <BR> COMMUNAUTÉ DES EGLISES DE PENTECÔTE AU BURUNDI “CEPBU” </h4>

                                    <div class="page-title-right">
                                    <e class="form-control ps-6 " >  @include('dashboard.time')</e>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap pb-3 gap-3">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-truncate mb-2">Projets</p>
                                                        <h4 class="mt-2 mb-0">{{ $project->count(); }} <span class="badge bg-subtle-primary text-primary font-size-10 ms-1"><i class="mdi mdi-arrow-up"></i> {{ $project->count(); }}%</sup></h4>
                                                    </div>
                                                    <div class="text-primary">
                                                        <div id="chart-mini1" class="apex-chart"></div>
                                                    </div>
                                                </div>
                                                <p class="mb-0 font-size-14 fw-bold mt-2 "> ~Tout les projets</span></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap pb-3 gap-3">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-truncate mb-2">Personnel</p>
                                                        <h4 class="mt-2 mb-0">{{ $user->count(); }}<span class="badge bg-subtle-danger text-danger font-size-10 ms-1"><i class="mdi mdi-arrow-down"></i> {{ $user->count(); }}%</sup></h4>
                                                    </div>
                                                    <div class="text-primary">
                                                        <div id="chart-mini2" class="apex-chart"></div>
                                                    </div>
                                                </div>
                                                <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate"> ~ Tous les personnels</span></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap pb-3 gap-3">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-truncate mb-2">Activités</p>
                                                        <h4 class="mt-2 mb-0">{{ $activite->count(); }} <span class="badge bg-subtle-primary text-primary font-size-10 ms-1"><i class="mdi mdi-arrow-up"></i> 32%</sup></h4>
                                                    </div>
                                                    <div class="text-primary">
                                                        <div id="chart-mini3" class="apex-chart"></div>
                                                    </div>
                                                </div>
                                                <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate">232<span class="text-muted fw-normal"> ~ vs. previous month</span></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap pb-3 gap-3">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="text-truncate mb-2">Projet</p>
                                                        <h4 class="mt-2 mb-0">{{ $encours }} <span class="badge bg-subtle-danger text-danger font-size-10 ms-1"><i class="mdi mdi-arrow-down"></i> {{ $encours }}%</sup></h4>
                                                    </div>
                                                    <div class="text-primary">
                                                        <div id="chart-mini4" class="apex-chart"></div>
                                                    </div>
                                                </div>
                                                <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate">Encours d'exécution<span class="text-muted fw-normal"> ~ vs. previous month</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->


                                
                        <!-- end row -->

                        <div class="row">
                            <div class="col-xl-3">
                                <div class="card">
                                    <div class="card-body">
                                       

                                        <h4 class="card-title">Recherche projet</h4>
                                        <div class="mt-4">
                                           
        
                                            <div class="mt-4 text-center">
                                            <select class="form-select classcategory"  >
                                                <option disabled="true" selected="true">--Classement de dossier--</option>
                                                @foreach ($folder as $folders)
                                                <option value="{{ $folders->id }}">{{ $folders->title }} </option>
                                                @endforeach
                                              </select>
                                            </div>

                                            <div class="mt-4 text-center">

                                            <select  class="form-select annee" id="annee">
                                              <option value="0" disabled="true" selected="true">--Année--</option>
                                            </select>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-9">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="card-title mb-3">Bref résumé de tous les projets en recherche</h4>


                                        <div class="table-responsive">
                                            <table class="table table-centered align-middle table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 20px;" class="align-middle">
                                                            <div class="form-check font-size-15">
                                                                <input class="form-check-input" type="checkbox" id="checkAll">
                                                                <label class="form-check-label" for="checkAll"></label>
                                                            </div>
                                                        </th>
                                                        <th>Numéro</th>
                                                        <th>Titre projet</th>
                                                        <th>Date debut</th>
                                                        <th>Statut</th>
                                                        <th>Année</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list tableviewsclass" >
                                                  <tr>
                                                    <td colspan="6">
                                                      <h5 style="margin-top:1% ;color:#c0c0c0"> 
                                                      <center><font size="5px"><i class="fa fa-search"  ></i> </font><br><br>
                                                      Sélectionner le classeur et l'année</center> </h5>
                                                   </td>
                        
                                                  </tr>
                                                      
                                                     
                                                    
                                                </tbody>
                                            </table>

                                            <a class="fw-bold fs--1 mt-4" href="{{ route('new_project') }}"><span class="fas fa-plus me-1"></span>Ajouter nouveau projet </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                            
                            </div>
    
                           
                        </div>
                        <!-- end row -->

                      

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->





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
            op+='<option value="0" selected disabled>--Année--</option>';
            op+='<option value="0" selected disabled>Aucun </option>';
            document.getElementById("annee").innerHTML = op

            alert("Attention!!\n le classeur n'a pas de projet refferencer ! ");

            
          }else{
            op+='<option value="0" selected disabled>--Année--</option>';
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

          var dateChange= "";

          if(data[i].statut==0){
            var statut = 'Encours';
          }else if(data[i].statut==1){
            var statut = 'Conclue';
          }

          tarea += '<tr class="hover-actions-trigger btn-reveal-trigger position-static">';
          tarea += '<td class="closed-won border-end"><b><a href='+url+'>#'+data[i].numeroprojet+'</a></b></td>';
          tarea += '<td class="closed-won border-end ">'+data[i].title+'</td>';
          tarea += '<td class="closed-won border-end "><center>'+data[i].start_date+'</center></td>';
          tarea += '<td class="closed-won border-end"><center>'+data[i].deadline+'</center></td>';
          tarea += '<td class="closed-won border-end"><center>'+statut+'</center></td>';
          tarea += '<td ><center>'+data[i].annee+'</center></td>';
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