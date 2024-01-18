@extends('layout/app')
@section('page-content')

<div class="content">
  <div class="row">
    <div class="col-xl-12" >
    <div class="row g-3 justify-content-between align-items-center">
      <div class="col-12 col-md">
        <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="fa fa-folder-open "></i> Fiche d'Expression des Besoins "FEB" </h4>
      </div>
      <div class="col col-md-auto">
        <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
          <a  href="javascript::;" data-bs-toggle="modal" data-bs-target="#addfebModal"  aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fa fa-plus-circle"></span> Nouvel fiche FEB</a></nav>
        </nav>
      </div>
    <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;num&quot;,&quot;febnum&quot;,&quot;facture&quot;date&quot;bc&quot;periode&quot;om&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
      <div class="table-responsive">
        <table class="table table-striped table-sm fs--1 mb-0">
          <thead>
                              <tr>
                              <th class="sort border-top" data-sort="num">#</th>
                                <th class="sort border-top" data-sort="febnum">Numero Feb</th>
                                <th class="sort border-top ps-3" data-sort="facture">Facture</th>
                                <th class="sort border-top" data-sort="date">Date feb</th>
                                <th class="sort border-top" data-sort="bc">BC</th>
                                <th class="sort border-top" data-sort="periode">Periode</th>
                                <th class="sort border-top" data-sort="om">OM</th>
                                <th class="sort border-top " >ACTION</th>
                              </tr>
                            </thead>
                            <tbody class="show_all" id="show_all">
                              <tr>
                              <td colspan="8"><h5 class="text-center text-secondery my-5">
                                @include('layout.partiels.load')
                               </td>
                              </tr>

                            </tbody>
        </table>
    </div>
        <div class="d-flex justify-content-center mt-3">
          <button class="page-link disabled" data-list-pagination="prev" disabled="">
            <svg class="svg-inline--fa fa-chevron-left" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"></path></svg></button>
              <ul class="mb-0 pagination"><li class="active"><button class="page" type="button" data-i="1" data-page="5">1</button></li><li><button class="page" type="button" data-i="2" data-page="5">2</button></li><li><button class="page" type="button" data-i="3" data-page="5">3</button></li><li class="disabled"><button class="page" type="button">...</button></li><li><button class="page" type="button" data-i="9" data-page="5">9</button></li></ul><button class="page-link pe-0" data-list-pagination="next"><svg class="svg-inline--fa fa-chevron-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"></path></svg><!-- <span class="fas fa-chevron-right"></span> Font Awesome fontawesome.com --></button>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

@include('document.feb.modale')

<script>
$(function(){

   $("#addForm").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#addbtn").text('Ajouter...');
                $.ajax({
                    url: "{{ route('storefeb') }}",
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                      if (response.status == 200) 
                      {
                        fetchAllfeb();
                        $.notify("Feb ajouté avec succès !", "success");
                        $("#addbtn").text('Sauvegarder');
                        $("#numerofeb_error").text("");
                        $('#numerofeb').addClass('');

                        $("#addForm")[0].reset();
                        $("#addfebModal").modal('hide');
                  
                        
                      }
                      if (response.status == 201) {
                        $.notify("Attention: FEB fonction existe déjà !", "info");
                        $("#addfebModal").modal('show');
                      }

                      if (response.status == 202) {
                        $.notify("Erreur d'execution, verifier votre internet", "error");
                        $("#addfebModal").modal('show');
                      }

                      $("#addbtn").text('Sauvegarder');
                    }
                });
            });

                 // Delete feb ajax request

      $(document).on('click', '.deleteIcon', function(e) 
      {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Êtes-vous sûr ?',
          text: "FEB est sur le point d'être DÉTRUITE ! Faut-il vraiment exécuter « la Suppression » ?  !",
        
          showCancelButton: true,
          confirmButtonColor: 'green',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Oui, Supprimer !',
          cancelButtonText: 'Annuller'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "{{ route('deletefeb') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                $.notify("FEB supprimer avec succès !", "success");
                fetchAllfeb();
              }
            });
          }
        })
      });



        fetchAllfeb();
        function fetchAllfeb() {
        $.ajax({
          url: "{{ route('fetchAllfeb') }}",
          method: 'get',
          success: function(reponse) {
            $("#show_all").html(reponse);
          }
        });
        }




var count = 0;
var nombre = 1;
function add_input_field(count)
{

  var html = '';
  html += '<tr>';
  html += '<td><input type="text" name="numerodetail[]" id="numerodetail" class="form-control item_numero" value="'+nombre+'" /></td>';
  html += '<td><input type="text" name="description[]" id="description" class="form-control item_description" /></td>';
  html += '<td><input type="text" name="montant[]" id="montant" class="form-control item_montant"  /></td>';
  var remove_button = '';

  if(count > 0)
  {
    remove_button = '<button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fas fa-minus"></i></button>';
  }

  html += '<td>'+remove_button+'</td></tr>';

  return html;

}

$('#item_table').append(add_input_field(0));

$('.selectpicker').selectpicker('refresh');

$(document).on('click', '.add', function(){

  count++;
  nombre++;

  $('#item_table').append(add_input_field(count));

  $('.selectpicker').selectpicker('refresh');

});

$(document).on('click', '.remove', function(){

  $(this).closest('tr').remove();

});


 
});
</script>

    @endsection