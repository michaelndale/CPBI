@extends('layout/app')
@section('page-content')
<style type="text/css">
    .has-error {
        border: 1px solid red;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-lg-5" style="margin:auto">

                    <div class="col-11" style="margin:auto">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0"><i class="fa fa-edit"></i> Changement de signature en image</h4>


                        </div>
                    </div>


                    {{-- new user modal --}}


                    <form method="POST" autocomplete="off" id="EditsignatureOnForm">
                        @method('post')
                        @csrf

                        <div class="modal-body">
                            <input type="hidden" value="{{ $user->idu }}" name="pid" id="pidp" readonly>
                            <input type="" value="{{ $user->nom }} {{ $user->prenom }}" class="form-control form-control-sm" readonly style="background-color:#c0c0c0"> <br>
                            @php
                                $signature = $user->signature;
                                $imagePath = public_path($signature);
                            @endphp

                            @if(file_exists($imagePath))
                            <img id="output_image" src="../../{{ $signature }}" alt="{{ $user->nom }} {{ $user->prenom }}" style="width:30% ">
                            @else
                            <h5> Pas de signature disponible </h5>
                            @endif
                            <br>
                            <input type="file" class="form-control" id="signatur" name="signatur" accept=".png" onchange="preview_image(event)" required>
                            <br>
                            <button type="submit" id="Editsignature" name="Editsignature" class="btn btn-primary"><i class="fas fa-check-circle"></i> Sauvegarder</button>
                        </div>
                </div>
                </form>
            </div>
        </div>

    </div>
</div>
</div>
</div> <!-- container-fluid -->
</div>
</div>
<br><br><br><br><br><br><br>
<script>
    $(function() {

        $("#EditsignatureOnForm").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#Editsignature").text('Mise à jour...');
            $.ajax({
                url: "{{ route('updatsignatureuser') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        toastr.success("Mise à jour reussi  avec succès !", "success");
                    // Recharger la page actuelle
                            window.location.reload();

                        
                    }

                    if (response.status == 202) {
                        toastr.error("Erreur d'execution, verifier votre internet", "error");
                    }

                    $("#Editsignature").text('Sauvegarder');
                }
            });
        });


    });
</script>

{{-- Edit function modal --}}

@endsection