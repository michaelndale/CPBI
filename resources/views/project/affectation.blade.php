@extends('layout/app')
@section('page-content')

<div class="content" >
        
        <div class="row" >
          <div class="col-xl-9" style="margin:auto">
          <h4 class="mb-4"><i class="fa fa-users"></i>  Affectation des executants du projet</h4>

          <form method="post" action="{{ route('storeAffectation') }}" enctype="multipart/form-data">
                @method('post')
                @csrf

                <div class="col-sm-6 col-md-12">
                    <div class="form-floating"><select class="form-select" id="project_id" name="project_id">
                        <option selected="selected">Select  project </option>
                        @foreach ($project as $projects)
                        <option value="{{ $projects->id }}">{{ $projects->title }}</option>
                        @endforeach
                        </select><label for="floatingSelectAdmin">Project Lead</label>
                    </div>
                </div>

                <br><br>
              
              <div class="col-sm-8 col-md-12" style="margin-left:40px">
                <div class="form-floating">
                    Select members : <br>
                    @foreach ($member  as $members)
                        <input  id="member"  name="member" type="checkbox" value="{{ $members->id }}"  />  {{ ucfirst($members->first_name) }} {{ ucfirst($members->last_name) }} <br>
                    @endforeach

                    <br> <br>
              </div>
              </div>

              <div class="col-12 gy-6">
                <div class="row g-3 justify-content-end">
                  <div class="col-auto"><button type="reset" class="btn btn-danger px-5">Cancel</button></div>
                  <div class="col-auto"><button type name="addAffectationtbtn" id="addProjectbtn" class="btn btn-primary px-5 px-sm-15">Create Affectation</button></div>
                </div>
              </div>
            </form>
          </div>
        </div>
  

<script>
    $(function() {
      // Add PROJECT ajax 
      $("#addProjectForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#addProjectbtn").text('Adding...');
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
              $.notify("You have Successfully add a project !", "success");
            }
            $("#addProjectbtn").text('Add Project');
            $("#addProjectForm")[0].reset();
          }
        });
      });

   
    });
  </script>


  @endsection