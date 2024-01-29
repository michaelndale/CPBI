@extends('layout/app')
@section('page-content')
@foreach ($info as $info)

<div class="content" >
        
        <div class="row" >
          <div class="col-xl-8" style="margin:auto">
          <h4 class="mb-4"><i class="fa fa-home"></i> Edit Identification </h4>

            <form class="row g-3 mb-6" method="POST"  enctype="multipart/form-data" id="addIdentificationForm" >
                @method('post')
                @csrf

              <div class="col-sm-12 gy-3">
                <div class="form-floating">
                <input  name="info_id" id="info_id" type="hidden"  value="{{ $info->id }}" />
                <input type="hidden" name="emp_avatar" id="emp_avatar" value="{{ $info->urllogo }}" >
                    <input class="form-control" name="name" id="name" type="text" placeholder="Name intitution"  value="{{ $info->nominstitution	 }}" /><label for="floatingInputGrid">Name intitution </label></div>
              </div>
            
              <div class="col-md-6 gy-3">
                <div class="form-floating"><input class="form-control" id="nif"  name="nif" type="text" placeholder="NIF" value="{{ $info->nif }}" /><label for="floatingInputBudget">NIF</label></div>
              </div>

              <div class="col-md-6 gy-3">
                <div class="form-floating"><input class="form-control" id="phone"  name="phone" type="text" placeholder="Phone"  value="{{ $info->phone }}" /><label for="floatingInputBudget">Phone number</label></div>
              </div>

              <div class="col-md-6 gy-3">
                <div class="form-floating"><input class="form-control" id="bp"  name="bp" type="text" placeholder="BP" value="{{ $info->bp }}" /><label for="floatingInputBudget">B.P</label></div>
              </div>

              <div class="col-md-6 gy-3">
                <div class="form-floating"><input class="form-control" id="fax"  name="fax" type="text" placeholder="fax"  value="{{ $info->fax }}" /><label for="floatingInputBudget">Fax</label></div>
              </div>

              <div class="col-12 gy-3">
                <div class="form-floating"><textarea class="form-control" id="adresse" name="adresse" placeholder="Leave a comment here" 
                 style="height: 70px">{{ $info->adresse }}</textarea><label for="floatingProjectOverview">Adress</label></div>
              </div>

              <div class="col-md-6 gy-3">
                <div class="form-floating"><input class="form-control" id="email"  name="email" type="text" placeholder="Email" value="{{ $info->email }}" /><label for="floatingInputBudget">Email</label></div>
              </div>

              <div class="col-md-6 gy-3">
                <div class="form-floating"><input class="form-control" id="file"  name="file" type="file"   /><label for="floatingInputBudget"></label></div>
              </div>

              <div class="col-12 gy-3">
                <div class="form-floating"><textarea class="form-control" id="description" name="description" placeholder="Leave a comment here" style="height: 100px">{{ $info->description }} </textarea><label for="floatingProjectOverview"> Description</label></div>
              </div>
             
              <div class="col-12 gy-6">
                <div class="row g-3 justify-content-end">
               
                  <div class="col-auto"><button name="addIndetificationbtn" id="addIndetificationbtn" class="btn btn-primary px-5 px-sm-15">Sauvegarder</button></div>
                </div>
              </div>
            </form>
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
            $.notify("You have Successfully update a identification !", "success");
          }
        });
      });

   
    });
  </script>


  @endsection