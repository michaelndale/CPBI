@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-12">
          <div class="row g-3 justify-content-between align-items-center">
            <div class="col-12 col-md">
              <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="fa fa-folder-open "></i> Fiche d'Expression des Besoins "FEB" </h4>
            </div>
            <div class="col col-md-auto">
              <nav class="nav nav-underline justify-content-end doc-tab-nav align-items-center" role="tablist">
                <a href="javascript::;" data-bs-toggle="modal" data-bs-target="#addfebModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fa fa-plus-circle"></span> Nouvel fiche FEB</a>
              </nav>
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
                      <th class="sort border-top ">ACTION</th>
                    </tr>
                  </thead>


                  <tbody class="show_all" id="show_all">
                    <tr>
                      <td colspan="6">
                        <h5 class="text-center text-secondery my-5">
                          <center> @include('layout.partiels.load') </center>
                      </td>
                    </tr>
                  </tbody>

                </table>
                <BR>
              </div>
              <div class="d-flex justify-content-center mt-3">
                <button class="page-link disabled" data-list-pagination="prev" disabled="">
                  <svg class="svg-inline--fa fa-chevron-left" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                    <path fill="currentColor" d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z"></path>
                  </svg></button>
                <ul class="mb-0 pagination">
                  <li class="active"><button class="page" type="button" data-i="1" data-page="5">1</button></li>
                  <li><button class="page" type="button" data-i="2" data-page="5">2</button></li>
                  <li><button class="page" type="button" data-i="3" data-page="5">3</button></li>
                  <li class="disabled"><button class="page" type="button">...</button></li>
                  <li><button class="page" type="button" data-i="9" data-page="5">9</button></li>
                </ul><button class="page-link pe-0" data-list-pagination="next"><svg class="svg-inline--fa fa-chevron-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                    <path fill="currentColor" d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z"></path>
                  </svg><!-- <span class="fas fa-chevron-right"></span> Font Awesome fontawesome.com --></button>
              </div>
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
                    <td class="row-index text-center"><p> ${rowIdx}</p></td>
                    <td><input class="form-control" type="text" style="min-width:150px" id="description" name="description[]"></td>
                    <td><input class="form-control unit_price" style="width:100px" type="text" id="unit_cost" value="1" name="unit_cost[]"></td>
                    <td><input class="form-control qty" style="width:80px" type="hidden" value= "1"  id="qty" name="qty[]"></td>
                    <td><input class="form-control total" style="width:120px" type="text" id="amount" name="amount[]" value="0" readonly></td>
                    <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Remove"><i class="far fa-trash-alt"></i></a></td>
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

    $("#tableEstimate tbody").on("input", ".unit_price", function() {
      var unit_price = parseFloat($(this).val());
      var qty = parseFloat($(this).closest("tr").find(".qty").val());
      var total = $(this).closest("tr").find(".total");
      total.val(unit_price * qty);

      calc_total();
    });

    $("#tableEstimate tbody").on("input", ".qty", function() {
      var qty = parseFloat($(this).val());
      var unit_price = parseFloat($(this).closest("tr").find(".unit_price").val());
      var total = $(this).closest("tr").find(".total");
      total.val(unit_price * qty);
      calc_total();
    });

    function calc_total() {
      var sum = 0;
      $(".total").each(function() {
        sum += parseFloat($(this).val());
      });
      $(".subtotal").text(sum);

      var amounts = sum;
      var tax = 100;
      $(document).on("change keyup blur", "#qty", function() {
        var qty = $("#qty").val();
        var discount = $(".discount").val();
        $(".total").val(amounts * qty);
        $("#sum_total").val(amounts * qty);
        $("#tax_1").val((amounts * qty) / tax);
        $("#grand_total").val((parseInt(amounts)) - (parseInt(discount)));
      });
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
              $.notify("Feb ajouté avec succès !", "success");
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
              $.notify("Feb ajouté avec succès !", "success");
              $("#addfebbtn").text('Sauvegarder');
              $("#numerofeb_error").text("");
              $('#numerofeb').addClass('');

              $("#addfebForm")[0].reset();
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



    });
  </script>

  @endsection