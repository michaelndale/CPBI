
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

	
<style>
  input , select
{
  height: 30px;
  
}
</style>

<button class="btn btn-sm  preview-btn ms-2" type="button" data-bs-toggle="modal" data-bs-target="#scrollingLong2" style="background-color:#228B22; color:white"><span class="me-2" data-feather="plus"></span>Nouvel fiche DAP</button></nav>
<div class="modal fade" id="scrollingLong2" tabindex="-1" aria-labelledby="scrollingLongModalLabel2" style="display: none;" aria-hidden="true">
<div class="modal-dialog modal-xl modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="scrollingLongModalLabel2">Demande et Autorisation de Paiement (DAP)</h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg><!-- <span class="fas fa-times fs--1"></span> Font Awesome fontawesome.com --></button>
    </div>
    <div class="modal-body">
     
    <form class="row g-3 mb-6" method="POST" id="addProjectForm">

@method('post')
@csrf
<table>
    <tr>

   
    <td align="right">Numéro fiche : <input type="text" style="width:20%;" class="form-control"></td>
    </tr>
</table>
           
                <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;name&quot;,&quot;email&quot;,&quot;age&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm fs--1 mb-0">
                            <tbody class="list">
                                <tr>
                                    <td class="align-middle ps-3 name" style="width:20%">
                                    Service
                                  
                                </td>
                                    <td class="align-middle email" colspan="6">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%" />
                                    </td>
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name">Composante/Projet/Section 
                                    </td>
                                    <td class="align-middle email" colspan="6">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%" />
                                    </td>
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name">Activite
                                    </td>
                                    <td class="align-middle email" colspan="6">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%" />
                                    </td>
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name">Lieu
                                    </td>
                                    <td class="align-middle email" colspan="1">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%" />
                                    </td>

                                    <td class="align-middle ps-3 name"> Référence FEB nº: 
                                    </td>

                                    <td class="align-middle email" colspan="1">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%" />
                                    </td>

                                    <td class="align-middle ps-3 name"> Taux d'exécution:
                                    </td>

                                    <td class="align-middle email" colspan="1">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%" />
                                    </td>
                                </tr>
                              
                                <tr>
                                <td class="align-middle ps-3 name" >Etablie par :</td>
                                    <td class="align-middle email" colspan="2">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
                                    </td>

                                    <td class="align-middle ps-3 name"> Ligne budgétaire:</td>
                                    <td class="align-middle email" colspan="2">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
                                    </td>
                                </tr>

                                <tr>
                                <td class="align-middle ps-3 name" >Compte bancaire (BQ):
                                </td>
                                    <td class="align-middle email" colspan="2">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
                                    </td>

                                    <td class="align-middle ps-3 name">Solde comptable BQ</td>
                                    <td class="align-middle email" colspan="2">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                        <table class="table table-striped table-sm fs--1 mb-0">
                            <tbody class="list">
                            
                                <tr>
                                <td class="align-middle ps-3 name" >OV  nº :
                                </td>
                                    <td class="align-middle email" colspan="2">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
                                    </td>

                                    <td class="align-middle ps-3 name">CHQ nº  </td>
                                    <td class="align-middle email" colspan="2">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
                                    </td>

                                    <td class="align-middle ps-3 name">Etabli au nom de:</td>
                                    <td class="align-middle email" colspan="2">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>

                        <hr>
                        <div class="table-repsonsive">
                          <span id="error"></span>
                          <table class="table table-bordered" id="item_table">
                            <tr>
                              <th style="width:5%">N<sup>O</sup></th>
                              <th>Description</th>
                              <th style="width:20%">Montant</th>
                              <th style="width:5% ;"><button type="button" name="add" class="btn btn-success btn-sm add"><i class="fas fa-plus"></i></button></th>
                            </tr>
                          </table>
                        </div>
                        <hr>
                       




                       
                    </div>
                </div>
            </form>
    
  </div>
    <div class="modal-footer"><button class="btn btn-primary" type="button" style="background-color:#228B22; color:white">Enregistrer</button>
   </div>
  </div>
</div>
</div>

<script>
$(document).ready(function(){

var count = 0;

function add_input_field(count)
{

  var html = '';

  html += '<tr>';

  html += '<td><input type="text" name="numero[]" class="form-control item_numero" /></td>';

  html += '<td><input type="text" name="description[]" class="form-control item_description" /></td>';

  html += '<td><input type="text" name="montant[]" class="form-control item_montant"  /></td>';

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

  $('#item_table').append(add_input_field(count));

  $('.selectpicker').selectpicker('refresh');

});

$(document).on('click', '.remove', function(){

  $(this).closest('tr').remove();

});

$('#insert_form').on('submit', function(event){

  event.preventDefault();

  var error = '';

  count = 1;

  $('.item_numero').each(function(){

    if($(this).val() == '')
    {

      error += "<li>Entrrer la description  "+count+" Row</li>";

    }

    count = count + 1;

  });

  count = 1;

  $('.item_description').each(function(){

    if($(this).val() == '')
    {

      error += "<li>Entrer la description "+count+" Row</li>";

    }

    count = count + 1;

  });

  count = 1;

  $('.item_montant').each(function(){

if($(this).val() == '')
{

  error += "<li>Entrer le montant  "+count+" Row</li>";

}

count = count + 1;

});

  var form_data = $(this).serialize();

  if(error == '')
  {

    $.ajax({

      url:"insert.php",

      method:"POST",

      data:form_data,

      beforeSend:function()
        {

          $('#submit_button').attr('disabled', 'disabled');

        },

      success:function(data)
      {

        if(data == 'ok')
        {

          $('#item_table').find('tr:gt(0)').remove();

          $('#error').html('<div class="alert alert-success">Item Details Saved</div>');

          $('#item_table').append(add_input_field(0));

          $('.selectpicker').selectpicker('refresh');

          $('#submit_button').attr('disabled', false);
        }

      }
    })

  }
  else
  {
    $('#error').html('<div class="alert alert-danger"><ul>'+error+'</ul></div>');
  }

});
 
});
</script>