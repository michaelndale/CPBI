@extends('layout/app')
@section('page-content')
<style type="text/css">
  .has-error {
    border: 1px solid red;
  }
</style>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      
     
      <div class="row">
        <div class="col-lg-6" style="margin:auto">

        <div class="col-11" style="margin:auto">
          <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><i class="fa fa-edit"></i> Restauration  mot de passe</h4>

            
          </div>
        </div>
          
            
{{-- new user modal --}}


    <form method="POST" autocomplete="off" action="{{ route('updatePasswordone' , $user->id) }}">
      @method('PUT')
      @csrf
      
        <div class="modal-body">
        <input type="hidden" value="{{ $user->id }}" name="idmdp" readonly> 
        <input type="" value="{{ $user->nom }} {{ $user->prenom }}" class="form-control form-control-sm" readonly style="background-color:#c0c0c0"> <br>  

        Nouveau mot de passe<br>
        <input type="password" name="password" class="form-control form-control-sm" > <br> 

        confirme mot de passe<br>
        <input type="password" name="cpassword" class="form-control form-control-sm">  <br>
          <button type="submit"  class="btn btn-primary"><i class="fas fa-check-circle"></i> Sauvegarder</button>
        </div>
      </div>
    </form>
  </div>
</div>

          </div>
        </div>
      </div>
    </div> <!-- container-fluid -->
  </div>
</div>


{{-- Edit function modal --}}

@endsection