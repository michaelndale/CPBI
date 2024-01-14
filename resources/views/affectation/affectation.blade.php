@extends('layout/app')
@section('page-content')



<div class="content" >
        
        <div class="row" >
          <div class="col-xl-9" style="margin:auto">
          <h4 class="mb-4"><i class="fa fa-users"></i>  Affectation des executants du projet</h4>

          @if (session()->has('success'))
          <div class="alert alert-outline-success d-flex align-items-center" role="alert">
            <span class="fas fa-check-circle text-success fs-3 me-3"></span>
            <p class="mb-0 flex-1">{{ session()->get('success') }} </p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif 

          @if($errors->any())
            <ul>
              @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }} </li>
              @endforeach
            </ul>

          @endif



          <form method="post" action="{{ route('storeAffectation') }}" enctype="multipart/form-data">
                @method('post')
                @csrf

                <div class="col-sm-6 col-md-12">

                <div class="form-floating">

                <input  id="project_id" class="form-control" name="project_id" type="hidden" value="{{ Session::get('id') }} "  readonly />

                <input  type="text" class="form-control"   value="{{ Session::get('numeroprojet') }} : {{ Session::get('title') }} "   disabled="disabled" />

                   
                    </div>
                </div>

                <br>
              
              <div class="col-sm-8 col-md-12" >
                <div class="form-floating">
                
                  <table class="table table-striped table-sm fs--0 mb-0">
                  @foreach ($member  as $members)
                    <tr>
                      <td  class="align-middle ps-3">
                         <input class="form-check-input"   name="personnel[]" type="checkbox" value="{{ $members->id }}" 
                            @php
                                foreach ($existe as $existes):
                                    $proj= $existes->projectid;
                                    $memb= $existes->memberid;
                                    $sessionprojec= Session::get('id');
                                    if($proj== $sessionprojec && $memb== $members->id):
                                      echo "checked";
                                    endif ;
                                endforeach
                              @endphp
                         
                         />  

                        

                            
                      

                      </td>
                      <td class="align-middle ps-0">
                          {{ ucfirst($members->name) }} {{ ucfirst($members->lastname) }} 
                      </td>
                    </tr>
                    @endforeach
                  </table>
              </div>
              </div>

              <br><br>

              <div class="col-12 gy-6">
                <div class="row g-3 justify-content-end">
 
                  <div class="col-auto"><button type name="addAffectationtbtn" id="addProjectbtn" class="btn btn-primary px-2 px-sm-5">Affectation projet</button></div>
                </div>
              </div>
            </form>
          </div>
        </div>
  @endsection