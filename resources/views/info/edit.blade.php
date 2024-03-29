@extends('layout/app')
@section('page-content')
@foreach ($info as $info)

<div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
        <div class="row" >
          <div class="col-xl-7" style="margin:auto">
          <h4 class="mb-4"><i class="fa fa-home"></i> Modification de la structure </h4>

            <form class="row g-3 mb-6" method="POST"  enctype="multipart/form-data" id="addIdentificationForm" >
                @method('post')
                @csrf

              <div class="col-sm-12 gy-1">
                
                <label for="floatingInputGrid">Nom institution </label>
                <input  name="info_id" id="info_id" type="hidden"  value="{{ $info->id }}" />
                <input type="hidden" name="emp_avatar" id="emp_avatar" value="{{ $info->urllogo }}" >
                    <input class="form-control form-control-sm" name="name" id="name" type="text" placeholder="Nom intitution"  value="{{ $info->nominstitution	 }}" />
                    </div>

            
              <div class="col-md-6 gy-1">
              <label for="floatingInputBudget">NIF</label>
               <input class="form-control form-control-sm" id="nif"  name="nif" type="text" placeholder="NIF" value="{{ $info->nif }}" />
              
              </div>

              <div class="col-md-6 gy-1">
                
                <label for="floatingInputBudget">Numero de telephone</label>
                  <input class="form-control form-control-sm" id="phone"  name="phone" type="text" placeholder="Telephone"  value="{{ $info->phone }}" />
                 
              </div>

              <div class="col-md-6 gy-1">
              <label for="floatingInputBudget">B.P</label>
              
                  <input class="form-control form-control-sm" id="bp"  name="bp" type="text" placeholder="BP" value="{{ $info->bp }}" />
                
              </div>

              <div class="col-md-6 gy-1">
              <label >Fax</label>
                  <input class="form-control form-control-sm" id="fax"  name="fax" type="text" placeholder="fax"  value="{{ $info->fax }}" />
                 
              </div>

              <div class="col-12 gy-1">
                <label for="floatingProjectOverview">En tete </label>
                  <input class="form-control form-control-sm" id="entete" name="entete" value="{{ $info->entete }}" />
              </div>

              <div class="col-12 gy-1">
                <label for="floatingProjectOverview">Devise</label>
                  <input class="form-control form-control-sm" id="sousentete" name="sousentete" value="{{ $info->sousentete }}" />
              </div>

              <div class="col-12 gy-1">
                <label for="floatingProjectOverview">Pied page</label>
                  <input class="form-control form-control-sm" id="piedpage" name="piedpage" value="{{ $info->piedpage }}" />
              </div>

              <div class="col-6 gy-1">
                <label for="floatingProjectOverview">Adresse</label>
                <input class="form-control form-control-sm" id="adresse" name="adresse" value="{{ $info->adresse }}" />
              </div>

              <div class="col-md-6 gy-1">
              <label for="floatingInputBudget">Email</label>
                  <input class=" form-control form-control-sm"" id="email"  name="email" type="text" placeholder="Email" value="{{ $info->email }}" />
                  
              </div>

              <div class="col-md-12 gy-1">
              <label for="floatingInputBudget">Logo ,  <a href="" class="form-control-sm"> Voir le logo ici </a>
                </label>
                <input class="form-control form-control-sm" id="file"  name="file" type="file"   />
                
              </div>
              <br>

              


              <div class="col-12 gy-1">
                  <label for="floatingProjectOverview"> Description</label>
                  <textarea class="form-control form-control-sm"" id="description" name="description" placeholder="Description" >{{ $info->description }} </textarea>
                  
              </div>
             
              <div class="col-12 gy-2">
                <div class="row g-3 justify-content-end">
               
                  <div class="col-auto"><button name="addIndetificationbtn" id="addIndetificationbtn" class="btn btn-primary px-5 px-sm-15">Sauvegarder</button></div>
                </div>
              </div>
             
            </form>
            <br>
            
          </div>
        </div>
          </div>
      </div>
</div>
    
        @endforeach
  
<script>


    $(function() {
      // Add PROJECT ajax 
      $("#addIdentificationForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#addIndetificationbtn").text('Edditing...');
        $.ajax({
          url: "{{ route('EditIdentification') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
             
            }else{
              
            }
            $("#addIndetificationbtn").text('Edit identification');
            toastr.success('Identification mises ajours succes .', 'Enregitrement');
          }
        });
      });

   
    });
  </script>


  @endsection