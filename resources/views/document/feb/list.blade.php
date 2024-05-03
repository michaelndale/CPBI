@extends('layout/app')
@section('page-content')
<style>
  .custom-modal-dialog {
  max-width: 400px; /* Réglez la largeur maximale du popup selon vos besoins */
  max-height: 50px; /* Réglez la hauteur maximale du popup selon vos besoins */
}
</style>
<div class="main-content">
<br>
    
    <div class="content">
      <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">
        <div class="card-header p-4 border-bottom border-300 bg-soft">
          <div class="row g-3 justify-content-between align-items-end">
            <div class="col-12 col-md">
              <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="mdi mdi-book-open-page-variant-outline"></i> Fiche d'Expression des Besoins "FEB"   </h4>
            </div>
            <div class="col col-md-auto">

            <a href="#" id="fetchDataLink"  > <i class="fas fa-sync-alt"></i> Actualiser</a>

    
            <a href="javascript::;" data-bs-toggle="modal" data-bs-target="#addfebModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fa fa-plus-circle"></span> Nouvel fiche FEB</a>
             
            </div>
          </div>
        </div>
        <div class="card-body p-0">

            <div id="tableExample2" >
              <div class="table-responsive">
                <table class="table table-striped table-sm fs--1 mb-0"  style="background-color:#3CB371;color:white">
                 
                  <tbody   id="showSommefeb">
                    
                  </tbody>

                </table>
             
              </div>
             
            </div>



            <div id="tableExample2" >
              <div class="table-responsive">
                <table class="table table-striped table-sm fs--1 mb-0" >
                  <thead>
                    <tr>
                      <th class="sort border-top "><center> <b> Actions </b></center></th>
                      <th class="sort border-top" data-sort="febnum"><center><b>N<sup>o</sup> FEB </b></center></th>
                      <th class="sort border-top" data-sort="om"> <b> <center>Montant total </center></b></th>
                      <th class="sort border-top" data-sort="periode"><center><b>Période</b></center></th>
                      <th class="sort border-top ps-3" data-sort="facture"><center><b>Facture</b></center></th>
                      <th class="sort border-top" data-sort="om"><center><b>OM</b></center></th>
                      <th class="sort border-top" data-sort="bc"><center><b>BC</b></center></th>
                      <th class="sort border-top" data-sort="bc"><center><b>NEC</b></center></th>
                      <th class="sort border-top" data-sort="bc"><center><b>FP/Devis</b></center></th>
                      <th class="sort border-top" data-sort="date"><center><b>Date</b></center></th>
                      <th class="sort border-top" data-sort="om"> <b>%</b> </th>
                      
                    </tr>
                  </thead>


                  <tbody class="show_all" id="show_all" >
                    <tr >
                      <td colspan="11">
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

 


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {

    $(document).on('change', '.ligneid', function() {
      var cat_id = $(this).val();
      var div = $(this).parent();
   
      $.ajax({
        type: 'get',
        url: "{{ route ('condictionsearch') }}",
        data: {
          'id': cat_id
        },
        success: function(reponse) {
            if(reponse.trim() !== "") {
                // La réponse n'est pas vide, mettre à jour le contenu HTML
                $("#showcondition").html(reponse);
            } else {
                // La réponse est vide ou nulle, faire quelque chose d'autre ou ne rien faire
                console.log("La réponse est vide ou nulle.");
            }
        }
      });
    });

    $(document).on('change', '.ligneid', function() {
      var ligid = $(this).val();
      var div = $(this).parent();
      var op = " ";
      $.ajax({
        type: 'get',
        url: "{{ route ('getactivite') }}",
        data: {
          'id': ligid
        },
        success: function(reponse) {
          $("#Showpoll").html(reponse);
        },
        error: function() {
          alert("Attention! \n Erreur de connexion a la base de donnee ,\n verifier votre connection");
        }
      });
    });
  });
</script>

  <script>

    // Variable pour stocker le numéro de ligne actuel
var rowIdx = 2;

// Ajouter une ligne au clic sur le bouton "Ajouter"
// Ajouter une ligne au clic sur le bouton "Ajouter"
$("#addBtn").on("click", function() {
    // Ajouter une nouvelle ligne au tableau
    $("#tableEstimate tbody").append(`
        <tr id="R${rowIdx}">
            <td><input style="width:100%" type="number" id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="${rowIdx}" ></td>
            <td> 
                <div id="Showpoll${rowIdx}" class="Showpoll">
                  
                </div>
            </td>
            <td><input style="width:100%" type="text" id="libelle_description" name="libelle_description[]" class="form-control form-control-sm"></td>
            <td><input style="width:100%" type="text" id="unit_cost" name="unit_cost[]" class="form-control form-control-sm" ></td>
            <td><input style="width:100%" type="number" id="qty" name="qty[]" class="form-control form-control-sm qty" ></td>
            <td><input style="width:100%" type="number" id="frenquency" name="frenquency[]" class="form-control form-control-sm frenquency" ></td>
            <td><input style="width:100%" type="number" id="pu" name="pu[]" class="form-control form-control-sm pu" ></td>
            <td><input style="width:100%" type="text" id="amount" name="amount[]" class="form-control form-control-sm total" value="0" readonly></td>
            <td><a href="javascript:void(0)" class="text-danger font-18 remove" title="Enlever"><i class="far fa-trash-alt"></i></a></td>
        </tr>
    `);

    // Cloner le contenu de l'élément Showpoll dans la nouvelle ligne
    var $originalShowpoll = $('#Showpoll');
    var $newShowpoll = $originalShowpoll.clone().attr('id', `Showpoll${rowIdx}`);
    $(`#R${rowIdx}`).find('.Showpoll').replaceWith($newShowpoll);

    // Incrémenter le numéro de ligne
    rowIdx++;
});


// Supprimer une ligne au clic sur le bouton "Enlever"
$("#tableEstimate tbody").on("click", ".remove", function() {
    // Récupérer toutes les lignes suivant la ligne supprimée
    var child = $(this).closest("tr").nextAll();
    
    // Modifier les numéros de ligne des lignes suivantes
    child.each(function() {
        var id = $(this).attr("id");
        var dig = parseInt(id.substring(1));
        $(this).attr("id", `R${dig - 1}`);
        $(this).find(".row-index").text(dig - 1);
    });

    // Supprimer la ligne
    $(this).closest("tr").remove();

    // Mettre à jour le numéro de ligne
    rowIdx--;
});

// Mettre à jour les totaux lors de la modification des champs "pu", "qty", et "frenquency"
$("#tableEstimate tbody").on("input", ".pu, .qty, .frenquency", function() {
    var pu = parseFloat($(this).closest("tr").find(".pu").val()) || 0;
    var qty = parseFloat($(this).closest("tr").find(".qty").val()) || 0;
    var frenquency = parseFloat($(this).closest("tr").find(".frenquency").val()) || 0;
    var total = pu * qty * frenquency;
    $(this).closest("tr").find(".total").val(total.toFixed(2));

    calc_total();
});

// Fonction pour calculer le total


function calc_total() {
    var sum = 0;
    $(".total").each(function() {
        sum += parseFloat($(this).val()) || 0;
    });
    $(".subtotal").text(sum.toFixed(2));

    // Mettre à jour le total global
    $(".total-global").text(sum.toFixed(2));
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
        $("#addfebbtn").html('<i class="fas fa-spinner fa-spin"></i>');
        $("#loadingModal").modal('show'); // Affiche le popup de chargement
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
              toastr.error("Attention: FEB numéro existe déjà !", "Attention");
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
            $("#loadingModal").modal('hide'); 
            setTimeout(function() {
                $("#loadingModal").modal('hide');
            }, 600); // 2000 millisecondes = 2 secondes
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
              
                if (response.status == 200) {
                toastr.success("FEB supprimer avec succès !", "Suppression");
                fetchAllfeb();
                Sommefeb();
              }

              if (response.status == 205) {
                toastr.error("Vous n'avez pas l'accreditation de supprimer ce FEB!", "Erreur");
              }

              if (response.status == 202) {
                toastr.error("Erreur d'execution !", "Erreur");
              }
                fetchAllfeb();
                Sommefeb();

              }
            });
          }
        })
      });

      $(document).ready(function() {
    // Attachement de l'événement click au lien
    
        $("#fetchDataLink").click(function(e) {
          $("#loadingModal").modal('show'); // Affiche le popup de chargement
            e.preventDefault(); // Empêche le comportement par défaut du lien (rechargement de la page)
            fetchAllfeb(); // Appel à la fonction pour charger les données
            setTimeout(function() {
                $("#loadingModal").modal('hide');
            }, 1000); // 2000 millisecondes = 2 secondes
        });
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