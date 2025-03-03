{{-- Edit banque modal --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form method="POST" id="editform">
          @method('post')
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="verticallyCenteredModalLabel"><i class="fa fa-edit"></i> Modification banque </h5>
            
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </button>
          </div>
          <div class="modal-body">
            <label class="text-1000 fw-bold mb-2">Libellé </label>
            <input type="hidden" name="bid" id="bid">
            <input class="form-control" name="blibelle" id="blibelle" type="text" placeholder="Entrer function" name="blibelle" required />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">Fermer</button>
            <button type="submit" id="editbtn" class="btn btn-primary" type="button"><i class="fa fa-cloud-upload-alt"></i> Modifier</button>
          </div>
        </form>
      </div>
    </div>
  </div>




<script>
    $(function() {
        // Add profil ajax 

        // Edit profil ajax request
        $(document).on('click', '.editIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: "{{ route('edibanque') }}",
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#blibelle").val(response.libelle);
                    $("#bid").val(response.id);
                }
            });
        });

        $("#editform").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);

            $("#editbtn").html('<i class="fas fa-spinner fa-spin"></i>');
            document.getElementById("editbtn").disabled = true;

            $.ajax({
                url: "{{ route('updatebanque') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        toastr.success("Banque modifier avec succès !", "Modification");
                        fetchAllbanque();

                        $("#editbtn").html(
                            '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        $("#editform")[0].reset();
                        $("#editModal").modal('hide');
                        document.getElementById("editbtn").disabled = false;
                    }

                    if (response.status == 201) {
                        toastr.error("Le titre du dossier existe déjà !", "Erreur");
                        $("#editbtn").html(
                            '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        document.getElementById("editbtn").disabled = false;
                    }

                    if (response.status == 205) {
                        toastr.error(
                            "Vous n'avez pas l'accreditation de Modifier cette banque!",
                            "Erreur");

                        $("#editbtn").html(
                            '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        document.getElementById("editbtn").disabled = false;
                    }

                }
            });
        });



        // Delete classeur ajax request'

    


        fetchAllbanque();

        function fetchAllbanque() {
            $.ajax({
                url: "{{ route('fetchAllBanque') }}",
                method: 'get',
                success: function(reponse) {
                    $("#show_all").html(reponse);
                }
            });
        }
    });
</script>
