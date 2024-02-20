@extends('layout/app')
@section('page-content')
<div class="main-content">
<br>
    
    <div class="content">
      <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">
        <div class="card-header p-4 border-bottom border-300 bg-soft">
          <div class="row g-3 justify-content-between align-items-end">
            <div class="col-12 col-md">
              <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="mdi mdi-book-open-page-variant-outline"></i> Demande et Justification d'Avance "DJA"  </h4>
            </div>
            <div class="col col-md-auto">
    
            <a href="javascript:voide(0)" data-bs-toggle="modal" data-bs-target="#scrollingLong2"  data-keyboard="false" data-backdrop="static"> <span data-feather="plus-circle"></span> Nouvel fiche DJA </a></nav>

             
            </div>
          </div>
        </div>
        <div class="card-body p-0">

            <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;num&quot;,&quot;febnum&quot;,&quot;facture&quot;date&quot;bc&quot;periode&quot;om&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
              <div class="table-responsive">
                <table class="table table-striped table-sm fs--1 mb-0"  style="background-color:#c0c0c0">
                 


                  <tbody   id="showSommefeb">
                    
                  </tbody>

                </table>
                <BR>
              </div>
             
            </div>



            <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;num&quot;,&quot;febnum&quot;,&quot;facture&quot;date&quot;bc&quot;periode&quot;om&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
              <div class="table-responsive">
                <table class="table table-striped table-sm fs--1 mb-0" >
                  <thead>
                    <tr>
                    <th class="sort border-top "><center>Action</center></th>
                   
                      <th class="sort border-top" data-sort="febnum">Numéro </th>
                      <th class="sort border-top ps-3" data-sort="facture">Facture</th>
                      <th class="sort border-top" data-sort="date">Date feb</th>
                      <th class="sort border-top" data-sort="bc">BC</th>
                      <th class="sort border-top" data-sort="periode">Periode</th>
                      <th class="sort border-top" data-sort="om">OM</th>
                      <th class="sort border-top" data-sort="om">Montant total</th>
                      <th class="sort border-top" data-sort="om"> % </th>
                      
                    </tr>
                  </thead>


                  <tbody class="show_all" id="show_all" >
                    <tr >
                    <td colspan="9"><h5 class="text-center text-secondery my-5">
                                @include('layout.partiels.load')
                               </td>
                    </tr>
                  </tbody>

                </table>
                
              </div>
             
            </div>
          </div>
        </div>
      </div>
    </div>
  


    @include('document.dja.modale')



    <script>
        $(function() {
        
            // Add  ajax 
            $("#addjdaForm").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#adddjabtn").text('Adding...');
                $.ajax({
                    url: "{{ route('storedja') }}",
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
                        $("#adddjabtn").text('Add Project');
                        $("#addjdaForm")[0].reset();
                    }
                });
            });
        });
    </script>

    @endsection