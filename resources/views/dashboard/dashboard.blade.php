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
                              <option disabled="true" selected="true"> --classement de dossier--</option>
                              @foreach ($folder as $folders)
                              <option value="{{ $folders->id }}">{{ $folders->title }} </option>
                              @endforeach
                            </select>
                             
                           
                          </div>
                        </div>
                        <div class="col-2 col-sm-2 col-md-3">
                        <select class="annee" id="annee">
                              <option value="0" disabled="true" selected="true"> Annee</option>
                            
                            </select>

                         

                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="card-body py-0 scrollbar to-do-list-body">
               
                  <div class="d-flex hover-actions-trigger py-3 border-top border-bottom">

                  <table class="table table-sm fs--1 mb-0">
                  <thead>
                    <tr>
                      <th class="sort align-middle" scope="col" data-sort="customer"> Nom & prenom </th>
                      <th class="sort align-middle" scope="col" data-sort="email">Telephone</th>
                      <th class="sort align-middle" scope="col" data-sort="city" >Fonction</th>
                      <th class="sort align-middle" scope="col" data-sort="email">Permis de conduire</th>
                      <th class="sort align-middle" scope="col" data-sort="city">Statut</th>
                      <th class="sort align-middle" scope="col" data-sort="city">Date</th>
                      <th class="sort align-middle" scope="col" data-sort="city">Action</th>
                    </tr>
                  </thead>
                  <tbody class="list" id="show_all">
                  </tbody>
                </table>
                    
                  
                  
                  
                  
                  <input class="form-check-input form-check-input-todolist flex-shrink-0 my-1 me-2 form-check-input-undefined" type="checkbox" id="checkbox-todo-10" data-event-propagation-prevent="data-event-propagation-prevent" />
                    <div class="row justify-content-between align-items-md-center btn-reveal-trigger border-200 gx-0 flex-1 cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal">
                      <div class="col-12 col-md-auto col-xl-12 col-xxl-auto" >
                        <div class="mb-1 mb-md-0 d-flex align-items-center lh-1"><label class="form-check-label mb-1 mb-md-0 mb-xl-1 mb-xxl-0 fs-0 me-2 line-clamp-1 text-900 cursor-pointer">Delete overlapping tasks and articles</label><span class="badge badge-phoenix ms-auto fs--2 badge-phoenix-secondary">CLOSE</span></div>
                      </div>
                      <div class="col-12 col-md-auto col-xl-12 col-xxl-auto">
                        <div class="d-flex lh-1 align-items-center"><a class="text-700 fw-bold fs--2 me-2" href="#!"><span class="fas fa-paperclip me-1"></span>2</a>
                          <p class="text-700 fs--2 mb-md-0 me-2 me-md-3 me-xl-2 me-xxl-3 mb-0">25 Nov, 2021</p>
                          <div class="hover-md-hide hover-xl-show hover-xxl-hide">
                            <p class="text-700 fs--2 fw-bold mb-md-0 mb-0 ps-md-3 ps-xl-0 ps-xxl-3 border-start-md border-xl-0 border-start-xxl border-300">1:00 AM</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-none d-md-block d-xl-none d-xxl-block end-0 position-absolute" style="top: 23%;" data-event-propagation-prevent="data-event-propagation-prevent">
                      <div class="hover-actions end-0" data-event-propagation-prevent="data-event-propagation-prevent"><button class="btn btn-phoenix-secondary btn-icon me-1 fs--2 text-900 px-0 me-1" data-event-propagation-prevent="data-event-propagation-prevent"><span class="fas fa-edit"></span></button><button class="btn btn-phoenix-secondary btn-icon fs--2 text-danger px-0" data-event-propagation-prevent="data-event-propagation-prevent"><span class="fas fa-trash"></span></button></div>
                    </div>
                  </div>
                  <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content bg-soft overflow-hidden">
                        <div class="modal-header px-6 py-5 border-300 pe-sm-5 px-md-6 dark__bg-1100">
                          <h3 class="text-1000 fw-bolder mb-0">Designing the Dungeon Blueprint</h3><button class="btn btn-phoenix-secondary btn-icon btn-icon-xl flex-shrink-0" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fa-solid fa-xmark"></span></button>
                        </div>
                        <div class="modal-body bg-100 px-6 py-0">
                          <div class="row gx-14">
                            <div class="col-12 col-lg-7 border-end-lg border-300">
                              <div class="py-6">
                                <div class="mb-7">
                                  <div class="d-flex align-items-center mb-3">
                                    <h4 class="text-900 me-3">Description</h4><a class="btn btn-link text-decoration-none p-0" href="#!"><span class="fa-solid fa-pen"></span></a>
                                  </div>
                                  <p class="text-1000 mb-0">The female circus horse-rider is a recurring subject in Chagall’s work. In 1926 the art dealer Ambroise Vollard invited Chagall to make a project based on the circus. They visited Paris’s historic Cirque d’Hiver Bouglione together; Vollard lent Chagall his private box seats. Chagall completed 19 gouaches Chagall’s work. In 1926 the art dealer Ambroise Vollard invited Chagall to make a project based on the circus.</p>
                                </div>
                                <div class="mb-7">
                                  <h4 class="mb-3">Subtasks</h4>
                                  <div class="d-flex flex-between-center hover-actions-trigger border-300 py-3 border-top">
                                    <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1 min-h-auto"><input class="subtask-checkbox form-check-input form-check-line-through mt-0 me-3" type="checkbox" id="subtaskundefined1" /><label class="form-check-label mb-0 fs-0" for="subtaskundefined1">Study Dragons</label></div>
                                    <div class="hover-actions end-0"><button class="btn btn-sm me-1 fs--2 text-700 px-0 me-3"><span class="fa-solid fa-pencil"></span></button><button class="btn btn-sm text-700 px-0"><span class="fa-solid fa-xmark fs-0"></span></button></div>
                                  </div>
                                  <div class="d-flex flex-between-center hover-actions-trigger border-300 py-3 border-top">
                                    <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1 min-h-auto"><input class="subtask-checkbox form-check-input form-check-line-through mt-0 me-3" type="checkbox" id="subtaskundefined2" /><label class="form-check-label mb-0 fs-0" for="subtaskundefined2">Procrastinate a bit</label></div>
                                    <div class="hover-actions end-0"><button class="btn btn-sm me-1 fs--2 text-700 px-0 me-3"><span class="fa-solid fa-pencil"></span></button><button class="btn btn-sm text-700 px-0"><span class="fa-solid fa-xmark fs-0"></span></button></div>
                                  </div>
                                  <div class="d-flex flex-between-center hover-actions-trigger border-300 py-3 border-top border-bottom mb-3">
                                    <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1 min-h-auto"><input class="subtask-checkbox form-check-input form-check-line-through mt-0 me-3" type="checkbox" id="subtaskundefined3" /><label class="form-check-label mb-0 fs-0" for="subtaskundefined3">Staring at the notebook for 5 mins</label></div>
                                    <div class="hover-actions end-0"><button class="btn btn-sm me-1 fs--2 text-700 px-0 me-3"><span class="fa-solid fa-pencil"></span></button><button class="btn btn-sm text-700 px-0"><span class="fa-solid fa-xmark fs-0"></span></button></div>
                                  </div><a class="fw-bold fs--1" href="#!"><span class="fas fa-plus me-1"></span>Add subtask</a>
                                </div>
                                <div class="mb-3">
                                  <div>
                                    <h4 class="mb-3">Files</h4>
                                  </div>
                                  <div class="border-top border-300 px-0 pt-4 pb-3">
                                    <div class="me-n3">
                                      <div class="d-flex flex-between-center">
                                        <div class="d-flex mb-1"><span class="fa-solid fa-image me-2 text-700 fs--1"></span>
                                          <p class="text-1000 mb-0 lh-1">Silly_sight_1.png</p>
                                        </div>
                                        <div class="font-sans-serif btn-reveal-trigger"><button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h"></span></button>
                                          <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item text-danger" href="#!">Delete</a><a class="dropdown-item" href="#!">Download</a><a class="dropdown-item" href="#!">Report abuse</a></div>
                                        </div>
                                      </div>
                                      <div class="d-flex fs--1 text-700 mb-2 flex-wrap"><span>768 kb</span><span class="text-400 mx-1">| </span><a href="#!">Shantinan Mekalan </a><span class="text-400 mx-1">| </span><span class="text-nowrap">21st Dec, 12:56 PM</span></div><img class="rounded-2" src="../assets/img/generic/40.png" alt="" style="max-width:230px" />
                                    </div>
                                  </div>
                                  <div class="border-top border-300 px-0 pt-4 pb-3">
                                    <div class="me-n3">
                                      <div class="d-flex flex-between-center">
                                        <div>
                                          <div class="d-flex align-items-center mb-1"><span class="fa-solid fa-image me-2 fs--1 text-700"></span>
                                            <p class="text-1000 mb-0 lh-1">All_images.zip</p>
                                          </div>
                                          <div class="d-flex fs--1 text-700 mb-0 flex-wrap"><span>12.8 mb</span><span class="text-400 mx-1">| </span><a href="#!">Yves Tanguy </a><span class="text-400 mx-1">| </span><span class="text-nowrap">19th Dec, 08:56 PM</span></div>
                                        </div>
                                        <div class="font-sans-serif btn-reveal-trigger"><button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h"></span></button>
                                          <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item text-danger" href="#!">Delete</a><a class="dropdown-item" href="#!">Download</a><a class="dropdown-item" href="#!">Report abuse</a></div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="border-top border-bottom border-300 px-0 pt-4 pb-3">
                                    <div class="me-n3">
                                      <div class="d-flex flex-between-center">
                                        <div>
                                          <div class="d-flex align-items-center mb-1 flex-wrap"><span class="fa-solid fa-file-lines me-2 fs--1 text-700"></span>
                                            <p class="text-1000 mb-0 lh-1">Project.txt</p>
                                          </div>
                                          <div class="d-flex fs--1 text-700 mb-0 flex-wrap"><span>123 kb</span><span class="text-400 mx-1">| </span><a href="#!">Shantinan Mekalan </a><span class="text-400 mx-1">| </span><span class="text-nowrap">12th Dec, 12:56 PM</span></div>
                                        </div>
                                        <div class="font-sans-serif btn-reveal-trigger"><button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h"></span></button>
                                          <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item text-danger" href="#!">Delete</a><a class="dropdown-item" href="#!">Download</a><a class="dropdown-item" href="#!">Report abuse</a></div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div><a class="fw-bold fs--1" href="#!"><span class="fas fa-plus me-1"></span>Add file(s)</a>
                              </div>
                            </div>
                            <div class="col-12 col-lg-5">
                              <div class="py-6">
                                <h4 class="mb-4 text-black">Others Information</h4>
                                <h5 class="text-1000 mb-2">Status</h5><select class="form-select mb-4" aria-label="Default select example">
                                  <option selected="">Select</option>
                                  <option value="1">One</option>
                                  <option value="2">Two</option>
                                  <option value="3">Three</option>
                                </select>
                                <h5 class="text-1000 mb-2">Due Date</h5>
                                <div class="flatpickr-input-container mb-4"><input class="form-control datetimepicker ps-6" type="text" placeholder="Set the due date" data-options='{"disableMobile":true}' /><span class="uil uil-calendar-alt flatpickr-icon text-700"></span></div>
                                <h5 class="text-1000 mb-2">Reminder</h5>
                                <div class="flatpickr-input-container mb-4"><input class="form-control datetimepicker ps-6" type="text" placeholder="Reminder" data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i","disableMobile":true,"static":true}' /><span class="uil uil-bell-school flatpickr-icon text-700"></span></div>
                                <h5 class="text-1000 mb-2">Tag</h5>
                                <div class="choices-select-container mb-6"><select class="form-select" data-choices="data-choices" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}'>
                                    <option value="">Select organizer...</option>
                                    <option>Massachusetts Institute of Technology</option>
                                    <option>University of Chicago</option>
                                    <option>GSAS Open Labs At Harvard</option>
                                    <option>California Institute of Technology</option>
                                  </select><span class="uil uil-tag-alt choices-icon text-700" style="top: 26%;"></span></div>
                                <div class="text-end mb-9"><button class="btn btn-phoenix-danger">Delete Task</button></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer border-0"><a class="fw-bold fs--1 mt-4" href="#!"><span class="fas fa-plus me-1"></span>Ajouter nouveau projet </a></div>
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
         

					op+='<option value="0" selected disabled>Choisire annee</option>';
					for(var i=0;i<data.length;i++){
					op+='<option value="'+data[i].annee+'">'+data[i].annee+'</option>';
          document.getElementById("annee").innerHTML = op
         
        
				   }

				 
				},
				error:function(){
          alert("Hello! I am an alert box!!");
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
				success: function(reponse) {
            $("#show_all").html(reponse);
          },
				error:function(){

				}
			});


		});

	});
</script>



  
@endsection