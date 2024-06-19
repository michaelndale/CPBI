@extends('layout/app')
@section('page-content')

<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="row">
          <div class="col-xl-9" style="margin:auto">
            <h4 class="mb-4"><i class="fa fa-users"></i> Les intervenants du projet</h4>
            <p>Les membres intervenants du projet ont apporté leur expertise et leur contribution à sa réalisation</p>

          
            <form method="post" action="{{ route('storeAffectation') }}" enctype="multipart/form-data">
              @method('post')
              @csrf

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

              <div class="col-12 gy-6">
                <div class="row g-3 justify-content-end">
                  <div class="col-auto"><button type name="addAffectationtbtn" id="addProjectbtn" class="btn btn-primary px-2 px-sm-5">Enregistrer les affectations</button></div>
                </div>
              </div>
            </form>
            <br><br>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  @endsection