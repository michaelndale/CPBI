@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      
      <!-- end page title -->

      <div class="row" >
        
        <div class="col-xl-8" style="margin:auto">
          <div class="card">

            @php
            $IDPJ= Session::get('id');
            $cryptedId = Crypt::encrypt($IDPJ);
            @endphp
           
          

            <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"
            style="padding: 0.10rem 1rem;">

            <h4 class="mb-sm-0"><i class="fa fa-users"></i> Les intervenants du projet</h4>
            </h4>

            <div class="page-title-right d-flex align-items-center justify-content-between gap-2" style="margin: 0;">
               
                <!-- Bouton Actualiser -->
                <a href="javascript:void(0)" id="fetchDataLink" class="btn btn-outline-primary rounded-pill btn-sm"
                    title="Actualiser">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <!-- Bouton Créer -->
                <a href="{{ route('key.viewProject', $cryptedId ) }}" class="btn btn-outline-primary rounded-pill btn-sm">
                    <span class="fa fa-arrow-left"></span> Retour
                </a>
            </div>
        </div>

        <form method="post" action="{{ route('storeAffectation') }}" enctype="multipart/form-data">
          @method('post')
          @csrf



            <div class="card-body">
              <div class="col-12 col-xl-12 col-xxl-12 pe-xl-0">
                <div class="mb-12 mb-xl-12">
                  <div class="row gx-0 gx-sm-12">
                    <div class="col-12">
                      <p>Les membres intervenants du projet ont apporté leur expertise et leur contribution à sa réalisation</p>

          
                     
                        <div class="col-sm-6 col-md-12">
                            <input id="project_id" class="form-control" name="project_id" type="hidden" value="{{ Session::get('id') }} " readonly />
          
                            <input type="text" class="form-control" value="{{ Session::get('numeroprojet') }} : {{ Session::get('title') }} " disabled="disabled" />
                        </div>
          
                        <br>
          
                        <div class="col-sm-8 col-md-12">
                          <div class="form-floating">
          
                            <table class="table table-striped table-sm fs--0 mb-0">
                              @foreach ($member as $members)
                              <tr>
                                <td class="align-middle ps-3">
                                  
                                  <input class="form-check-input" name="personnel[]" type="checkbox" value="{{ $members->userid }}" 
                                  @php 
                                  if(isset($existe)){
                                    foreach ($existe as $existes): 
          
                                    $proj=$existes->projectid;
                                    $memb= $existes->memberid;
          
                                    $sessionprojec= Session::get('id');
          
                                    if($proj== $sessionprojec && $memb== $members->userid):
                                    echo "checked";
                                    endif ;
                                    endforeach;
                                  }
                                  
                                  @endphp
          
                                  />
                                </td>
                                <td class="align-middle ps-0">
                                  {{ ucfirst($members->nom) }} {{ ucfirst($members->prenom) }}
                                </td>
          
                              
                              </tr>
                              @endforeach
                            </table>
                          </div>
                        </div>
          
                        <br><br>
                      
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
               
                <button type name="addAffectationtbtn" id="addProjectbtn" class="btn btn-primary px-2 px-sm-5">Enregistrer les affectations</button>
            </div>
            </div>

        </form>

          </div>
         
        </div>
       
       
        </div>

       


      </div>

    </div> <!-- container-fluid -->
  </div>
  <!-- End Page-content -->

  <!--  Extra Large modal example -->

</div>


<style>
  .swal-custom-content .swal-text {
    font-size: 14px;
    /* Ajustez la taille selon vos besoins */
  }

  th {
        font-weight: bold;
    }
</style>



@endsection
