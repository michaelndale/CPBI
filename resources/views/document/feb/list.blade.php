@extends('layout/app')
@section('page-content')
<div class="main-content">
<br>
    
    <div class="content">
      <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">
        <div class="card-header p-4 border-bottom border-300 bg-soft">
          <div class="row g-3 justify-content-between align-items-end">
            <div class="col-12 col-md">
              <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="mdi mdi-book-open-page-variant-outline"></i> Fiche d'Expression des Besoins "FEB"  </h4>
            </div>
            <div class="col col-md-auto">
    
            <a href="javascript::;" data-bs-toggle="modal" data-bs-target="#addfebModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fa fa-plus-circle"></span> Nouvel fiche FEB</a>
             
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
                      <th class="sort border-top" data-sort="febnum">N<sup>o</sup> FEB </th>
                      <th class="sort border-top ps-3" data-sort="facture">Facture</th>
                      <th class="sort border-top" data-sort="date">Date FEB</th>
                      <th class="sort border-top" data-sort="bc">BC</th>
                      <th class="sort border-top" data-sort="periode">Période</th>
                      <th class="sort border-top" data-sort="om">OM</th>
                      <th class="sort border-top" data-sort="om">Montant total</th>
                      <th class="sort border-top" data-sort="om"> % </th>
                      
                    </tr>
                  </thead>


                  <tbody class="show_all" id="show_all" >
                    <tr >
                      <td colspan="10">
                        <h5 class="text-center text-secondery my-5">
                          <center> @include('layout.partiels.load') </center>
                      </td>
                    </tr>
                  </tbody>

                </table>

                <br><br><br><br>
                <br><br><br><br>
                <br>
             
                
              </div>
             
            </div>
          </div>
        </div>
      </div>
    </div>
  


  @include('document.feb.modale')

  <BR><BR>

  <script>
    var rowIdx = 1;
    $("#addBtn").on("click", function() {
      // Adding a row inside the tbody.
      $("#tableEstimate tbody").append(` 
                <tr id="R${++rowIdx}">
                    <td><input style="width:100%" type="number"    id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="${rowIdx}" ></td>
                    <td><input style="width:100%" type="text"    id="description"  name="description[]"  class="form-control form-control-sm" ></td>
                    <td><input style="width:100%" type="text"    id="unit_cost"    name="unit_cost[]"    class="form-control form-control-sm" ></td>
                    <td><input style="width:100%" type="number"  id="qty"          name="qty[]"          class="form-control form-control-sm qty"     ></td>
                    <td><input style="width:100%" type="number"  id="frenquency"   name="frenquency[]"   class="form-control form-control-sm frenquency"   ></td>
                    <td><input style="width:100%" type="number"  id="pu"           name="pu[]"           class="form-control form-control-sm pu"   ></td>
                    <td><input style="width:100%" type="text"    id="amount"       name="amount[]"       class="form-control form-control-sm total"   value="0" readonly></td>
                    
                    <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Enlever"><i class="far fa-trash-alt"></i></a></td>
                    </tr>`);
    });
    $("#tableEstimate tbody").on("click", ".remove", function() {
      // Getting all the rows next to the row
      // containing the clicked button
      var child = $(this).closest("tr").nextAll();
      // Iterating across all the rows
      // obtained to change the index
      child.each(function() {
        // Getting <tr> id.
        var id = $(this).attr("id");

        // Getting the <p> inside the .row-index class.
        var idx = $(this).children(".row-index").children("p");

        // Gets the row number from <tr> id.
        var dig = parseInt(id.substring(1));

        // Modifying row index.
        idx.html(`${dig - 1}`);

        // Modifying row id.
        $(this).attr("id", `R${dig - 1}`);
      });

      // Removing the current row.
      $(this).closest("tr").remove();

      // Decreasing total number of rows by 1.
      rowIdx--;
    });

    $("#tableEstimate tbody").on("input", ".pu", function() {
      var pu = parseFloat($(this).val());
      var qty = parseFloat($(this).closest("tr").find(".qty").val());
      var total = $(this).closest("tr").find(".total");
      total.val(pu * qty * frenquency);

      calc_total();
    });

    $("#tableEstimate tbody").on("input", ".qty", function() {
      var qty = parseFloat($(this).val());
      var pu = parseFloat($(this).closest("tr").find(".pu").val());
      var total = $(this).closest("tr").find(".total");
      total.val(pu * qty * frenquency);
      calc_total();
    });

    function calc_total() {
      var sum = 0;
      $(".total").each(function() {
        sum += parseFloat($(this).val());
      });
      $(".subtotal").text(sum);

    }

    $(function() {
      $(document).on('change', '.soldeligne', function() {
        var cat_id = $(this).val();
        var div = $(this).parent();
        var op = " ";
        $.ajax({
          type: 'get',
          url: "{{ route ('findligne') }}",
          data: {
            'id': cat_id
          },
          success: function(data) {
            console.log(data);

            if (status == 200) {
              if (data.length == 0) {
                op += '<input value="0" selected disabled />';
                document.getElementById("tauxexecution").innerHTML = op
              } else {

                for (var i = 0; i < data.length; i++) {
                  op += '<input  value="' + data[i].annee + '" />';
                  document.getElementById("tauxecution").innerHTML = op
                }
              }


            }
            if (status == 201) {
              alerte('aucune');
            }

            if (status == 202) {
              toastr.success("Feb ajouté avec succès !", "Enregistrement");
            }

            


          },
          error: function() {
            alert("Attention! \n Erreur de connexion a la base de donnee ,\n verifier votre connection");
          }
        });
      });

      $("#addfebForm").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#addfebbtn").text('Ajouter...');
        $.ajax({
          url: "{{ route('storefeb') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {

              fetchAllfeb();
              Sommefeb();

              $("#addfebbtn").text('Sauvegarder');
              $("#numerofeb_error").text("");
              $('#numerofeb').addClass('');

              $("#addfebForm")[0].reset();
              $("#addfebModal").modal('hide');

              toastr.success("Feb ajouté avec succès !", "Enregistrement");


            }
            if (response.status == 201) {
              toastr.error("Attention: FEB numéro existe déjà !", "AAttention");
              $("#addfebModal").modal('show');
              $("#numerofeb_error").text("Numéro existe");
              $('#numerofeb').addClass('has-error');
            }

            if (response.status == 202) {
              toastr.error("Erreur d'execution, verifier votre internet", "Attention");
              $("#addfebModal").modal('show');
            }

            if (response.status == 203) {
              toastr.error("Le montant global du feb depasse le budget de la ligne encours", "Attention");
              $("#addfebModal").modal('show');
            }

            $("#addfebbtn").text('Sauvegarder');
          }
        });
      });

      // Delete feb ajax request

      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Êtes-vous sûr ?',
          text: "FEB est sur le point d'être DÉTRUITE ! Faut-il vraiment exécuter « la Suppression » ?  ",

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
                toastr.success("FEB supprimer avec succès !", "Suppression");
                fetchAllfeb();
                Sommefeb();
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


      Sommefeb();

      function Sommefeb() {
        $.ajax({
          url: "{{ route('Sommefeb') }}",
          method: 'get',
          success: function(reponse) {
            $("#showSommefeb").html(reponse);
          }
        });
      }

    });
  </script>

  @endsection