@extends('layout/app')
@section('page-content')
<style type="text/css">
.has-error {
    border: 1px solid red;
}
</style>
<div class="content">
 
  <div id="members" data-list='{"valueNames":["customer","email","mobile_number","city","last_active","joined"],"page":10,"pagination":true}'>
    <div class="row align-items-center justify-content-between g-3 mb-4">
      <div class="col col-auto">
        <div class="search-box">
        <h4 class="text-bold text-1100 mb-5"><i class="fa fa-users"></i> Members</h4>
        </div>
      </div>
      <div class="col-auto">
        <div class="d-flex align-items-center">
         <button class="btn btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#addMemberModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent" style="background-color:#228B22;color:white"> <i class="fa fa-plus-circle"></i> Ajouter </button>
          <button class="btn btn-link text-900 me-4 px-0"><select type="text" class="form-control" name="forma" onchange="location = this.value;">
              <option>Filter for nomber </option>
              <option value="#">5</option>
            </select>
          </button>
        </div>
      </div>
    </div>
    <nav class="mb-2" aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>

        <li class="breadcrumb-item active"> Members</li>
      </ol>
    </nav>

    <div class="mx-n4 mx-lg-n6 px-4 px-lg-6 mb-9 bg-white border-y border-300 mt-2 position-relative top-1">
      <div class="table-responsive scrollbar ms-n1 ps-1">

      <table class="table table-sm fs--1 mb-0">
        <thead>
          <tr>
            <th class="white-space-nowrap fs--1 align-middle ps-0">
              <div class="form-check mb-0 fs-0"><input class="form-check-input" id="checkbox-bulk-members-select" type="checkbox" data-bulk-select='{"body":"members-table-body"}' /></div>
            </th>
            <th class="sort align-middle" scope="col" data-sort="customer" style="">First & Last name</th>
            <th class="sort align-middle" scope="col" data-sort="email" style="width:15%; min-width:50px;">Email </th>
            <th class="sort align-middle pe-3" scope="col" data-sort="mobile_number" style="width:20%; min-width:60px;">Phone</th>
            <th class="sort align-middle" scope="col" data-sort="email" style="width:15%; min-width:50px;">Fonction</th>
            <th class="sort align-middle" scope="col" data-sort="city" style="width:10%;">Statut</th>
            <th class="sort align-middle" scope="col" data-sort="city" style="width:10%;">Date</th>
            <th class="sort align-middle" scope="col" data-sort="city" style="width:10%;">Action</th>
          </tr>
        </thead>
        <tbody class="list" id="show_all_members">
        
        </tbody>
      </table>

      </div>
      <div class="row align-items-center justify-content-between py-2 pe-0 fs--1">
        <div class="col-auto d-flex">
          <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info"></p><a class="fw-semi-bold" href="#!" data-list-view="*">Show all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
        </div>
        <div class="col-auto d-flex"><button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
          <ul class="mb-0 pagination"></ul><button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
        </div>
      </div>
    </div>
  </div>


  {{-- new profile modal --}}

  <div class="modal fade" id="addMemberModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content border">
            <form id="addMemberForm" autocomplete="off">
            @method('post')
            @csrf
              <div class="modal-header px-card border-0">
                <div class="w-100 d-flex justify-content-between align-items-start">
                  <div>
                    <h5 class="mb-0 lh-sm text-1000"><i class="fa fa-user-plus"></i> Add new member</h5>
                    
                  </div><button class="btn p-1 fs--2 text-900" type="button" data-bs-dismiss="modal" aria-label="Close">DISCARD </button>
                </div>
              </div>
              <div class="modal-body p-card py-0">
                
              <div class="form-floating mb-3"><input class="form-control" id="firstname" type="text" name="firstname" required="required" placeholder="First name" /><label for="First name">First name</label></div>
              <div class="form-floating mb-3"><input class="form-control" id="lastname" type="text" name="lastname" required="required" placeholder="Last name" /><label for="First name">Last name</label></div>
              <div class="form-floating mb-3">
                <input class="form-control" id="email" type="text" name="email" required="required" placeholder="First name" />
                <label for="Email">Email</label>
                <span id="email_error" name="email_error" class="text text-danger" > </span>
              
              </div>
              <div class="form-floating mb-3"><input class="form-control" id="phone" type="text" name="phone" required="required" placeholder="Last name" /><label for="Phone">Phone</label></div>
             
              <div class="row" >
                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-5">
                <select class="form-select" id="function" name="function">
                    <option value="primary" selected="selected">Function</option>
                    @foreach ($fonction as $fonctions)
                      <option value="{{ $fonctions->title }}"> {{ $fonctions->title }}</option>
                    @endforeach
                  </select>
                  <label for="eventLabel">Function</label>
              </div>
               
                </div>

                <div class="col-sm-6 col-md-6">
                <div class="form-floating mb-5">
                  <select class="form-select" id="statut" name="statut">
                      <option value="" selected="selected">Statut</option>
                      @foreach ($statut as $statuts)
                        <option value="{{ $statuts->libelle }}">  {{ $statuts->libelle }}</option>
                      @endforeach
                    </select>
                    <label for="eventLabel">Status</label>
                </div>
                </div>
            </div>


             
              
                </div>
              <div class="modal-footer d-flex justify-content-between align-items-center border-0">

              <button class="btn btn-danger px-4" type="button" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                
                <button class="btn btn-primary px-4" id="add_member_btn"  type="submit">Enregistrer</button></div>
            </form>
          </div>
        </div>
      </div>




  {{-- Edit function modal --}}

  <div class="modal fade " id="edit_profileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addDealModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-100 p-4">
        <form method="POST" id="edit_profile_form">
          @method('post')
          @csrf
          <div class="modal-header border-0 p-0 mb-2">
            <h3 class="mb-0">Edit profile</h3><button class="btn btn-sm btn-phoenix-secondary" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times text-danger"></span></button>
          </div>
          <div class="modal-body px-0">
            <div class="row g-3">
              <div class="col-lg-12">
                <div class="mb-4">
                  <label class="text-1000 fw-bold mb-2">Title</label>
                  <input type="hidden" name="pro_id" id="pro_id">
                  <input class="form-control" name="pro_title" id="pro_title" type="text" placeholder="Entrer profil" required />
                
                </div>
         
              </div>
            </div>
          </div>
          <div class="modal-footer border-0 pt-6 px-0 pb-0">
            <button type="button" class="btn btn-danger px-3 my-0" data-bs-dismiss="modal" aria-label="Close"> Cancel </button>
            <button type="submit"  id="edit_profile_btn" class="btn btn-primary my-0"> Update profile</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <script>
    $(function() {
      // Add members ajax 
      $("#addMemberForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_member_btn").text('Adding...');
        $.ajax({
          url: "{{ route('storeMe') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              $.notify("Member Added Successfully !", "success");
              fetchAllMembers();
              $("#add_member_btn").text('Add member');
              $("#addMemberForm")[0].reset();
              $("#addMemberModal").modal('hide');
            }

            if (response.status == 201) 
            {
              $.notify("L'email personnel est déjà  renseigner !", "error");
              //Toastr::error('User add new account fail :)','Error');
              $("#add_member_btn").text('Enregistrement');
              $("#addMemberModal").modal('show');
              $("#email_error").text("L'email personnel est déjà  renseigner !");
              $('#email').addClass('has-error');
            }
           
          }
        });
      });

      // Edit fonction ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: "{{ route('editMe') }}",
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#fun_title").val(response.title);
            $("#fun_id").val(response.id);
          }
        });
      });

      // update function ajax request
      $("#edit_function_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_function_btn").text('Updating...');
        $.ajax({
          url: "{{ route('updateMe') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              $.notify("Function update Successfully !", "success");
              fetchAllMembers();
            }
            $("#edit_function_btn").text('Update function');
            $("#edit_function_form")[0].reset();
            $("#edit_functionModal").modal('hide');
          }
        });
      });

      // Delete department ajax request
      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "{{ route('deleteMe') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                $.notify("Member deleted Successfully !", "success");
                fetchAllMembers();
              }
            });
          }
        })
      });

      fetchAllMembers();

      function fetchAllMembers() {
        $.ajax({
          url: "{{ route('fetchAllMembers') }}",
          method: 'get',
          success: function(reponse) {
            $("#show_all_members").html(reponse);
          }
        });
      }
    });
  </script>


  @endsection