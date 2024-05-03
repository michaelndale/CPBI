@extends('layout/app')
@section('page-content')
<style>
    /* Style pour le texte caché */
    .hidden-link {
        display: none;
    }

    /* Style de la classe difference */
.difference {
    /* Ajoutez votre style pour différencier visuellement la cellule */
    background-color: #ffcccc; /* Par exemple, couleur de fond différente */
}

/* Positionnement du drapeau à côté de la cellule différence */


</style>

<div class="main-content">
  <div class="content">
    <div class="card-header p-4 border-bottom border-300 bg-soft">
      <div class="row g-3 justify-content-between align-items-end">
        <div class="col-12 col-md">
          <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="mdi mdi-book-open-page-variant-outline"></i> Budgétisation <a href=""><i class="ri-refresh-line"></i></a> </h4>
        </div>
      

        @if($projetdatat->autorisation == 1)
       
        <div class="col col-md-auto">
          <a href="javascript::;" chauffeur="button" data-bs-toggle="modal" data-bs-target="#addDealModal" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Ajouter le budget </a>
        </div>
        @endif

      </div>
    </div>
    <div class="card-body">
      <div class="card">

      <table>
  
    <!-- Autres lignes -->
</table>




        <div class="float-end d-none d-md-inline-block">
        <div class="table-responsive">
                                         

          <div id="show_all_rallonge" class="scrollme">
            <center>
              <br><br><br><br> @include('layout.partiels.load') <br><br><br><br>
            </center>
          </div>
        </div>
      </div>
      <br>  <br>
    </div>
  </div>
</div>


@include('rallonge.modale')


<script>


function toggleUrldocInput(checkbox) {
    var urldocInput = document.getElementById("urldoc");
    urldocInput.style.display = checkbox.checked ? "block" : "none";
}

// Vérifier l'état initial de la case à cocher au chargement de la page
window.onload = function() {
    var retructionCheckbox = document.getElementById("retruction");
    toggleUrldocInput(retructionCheckbox);
};



    // Sélection des lignes (<tr>) avec la classe "hoverable-tr"
    const hoverableTrs = document.querySelectorAll('.hoverable-tr');

    // Écoute des événements de survol pour chaque ligne
    hoverableTrs.forEach(tr => {
        tr.addEventListener('mouseover', () => {
            // Sélection de l'élément <a> à l'intérieur de la ligne
            const editLink = tr.querySelector('.edit-link');
            // Ajout de la classe pour afficher le lien
            editLink.classList.remove('hidden-link');
        });
        // Événement pour cacher le lien lorsque la souris quitte la ligne
        tr.addEventListener('mouseleave', () => {
            // Sélection de l'élément <a> à l'intérieur de la ligne
            const editLink = tr.querySelector('.edit-link');
            // Suppression de la classe pour cacher le lien
            editLink.classList.add('hidden-link');
        });
    });
</script>

<script>
  $(document).ready(function() {
    $('#dtHorizontalVerticalExample').DataTable({
      "scrollX": true,
      "scrollY": 200,
    });
    $('.dataTables_length').addClass('bs-select');
  });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>



<script type="text/javascript">
  $(document).ready(function() {

    $(document).on('change', '.compteid', function() {
      var cat_id = $(this).val();
      var div = $(this).parent();
      var op = " ";
      $.ajax({
        type: 'get',
        url: "{{ route ('findSousCompte') }}",
        data: {
          'id': cat_id
        },
        success: function(data) {
          console.log(data);
          if (data.length == 0) {
            op += '<option value="0" selected disabled>--Ligne compte--</option>';
            op += '<option value="0" selected disabled>Aucun </option>';
            document.getElementById("scomptef").innerHTML = op
            toastr.error("Attention!!\n la ligne  n'a pas de sous ligne", "Information");
          } else {

            for (var i = 0; i < data.length; i++) {
              op += '<option value="' + data[i].id + '">' + data[i].numero + '.' + data[i].libelle + '</option>';
              document.getElementById("scomptef").innerHTML = op
            }
          }

        },
        error: function() {

          toastr.error("Erreur de connexion a la base de donnee ,\n verifier votre connection", "Attention");
        }
      });
    });



  });
</script>



<script>
  $(function() {
    // Add rallonge budgetaire ajax 
    $("#addFOrm").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#addcompte").text('Enregistrement encours...');
      $.ajax({
        url: "{{ route('storerallonge') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.success("Budget reussi avec succès !", "Enregistrement");
            fetchAllrallonge();
            $("#addFOrm")[0].reset();
            $("#addDealModal").modal('hide');
          }

          if (response.status == 201) {
            toastr.error("Le montant est supérieur au montant globale du budget !", "Attention");

            $("#addDealModal").modal('show');
          }

          if (response.status == 202) {
            toastr.error("Erreur d'execution  !", "Erreur");

            $("#addDealModal").modal('show');
          }

          if (response.status == 203) {
            toastr.error("Une ligne de compte n'est peut recevoir de fois le montant !", "Erreur");

            $("#addDealModal").modal('show');
          }

          $("#savebtn").text('Sauvegarder');

        }
      });
    });


    // Edit fonction ajax request
    $(document).on('click', '.editIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('editGc') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#gc_title").val(response.title);
          $("#gc_id").val(response.id);
        }
      });
    });


    // Edit fonction ajax request
    $(document).on('click', '.savesc', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('ShowCompte') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#ctitle").val(response.libelle);
          $("#cid").val(response.id);
        }
      });
    });

    // Edit fonction ajax request
    $(document).on('click', '.ssavesc', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: "{{ route('ShowCompte') }}",
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#sctitle").val(response.libelle);
          $("#scid").val(response.compteid);
          $("#sscid").val(response.id);
        }
      });
    });

    // update function ajax request
    $("#editcompteform").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#editcomptebtn").text('Updating...');
      $.ajax({
        url: "{{ route('updateGc') }}",
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            toastr.info("Compte update Successfully !", "success");
            Selectdcompte();
            fetchAlldcompte();
            Selectsouscompte();
          }
          $("#editcomptebtn").text('Update compte');
          $("#editcompteModal").modal('hide');
        }
      });
    });

    // Delete compte ajax request
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
            url: "{{ route('deleteGc') }}",
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {
              console.log(response);
              toastr.success("Compte deleted Successfully !", "success");
              fetchAllrallonge();
            }
          });
        }
      })
    });



    fetchAllrallonge();

    function fetchAllrallonge() {
      $.ajax({
        url: "{{ route('fetchRallonge') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all_rallonge").html(reponse);
        }
      });
    }

    fetchAllrallonge();

    function fetchAllrallonge() {
      $.ajax({
        url: "{{ route('fetchRallonge') }}",
        method: 'get',
        success: function(reponse) {
          $("#show_all_rallonge").html(reponse);
        }
      });
    }



  });
</script>

@endsection