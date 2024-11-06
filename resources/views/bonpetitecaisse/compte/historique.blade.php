<div class="page-title-right">
    <div class="input-group mb-3">
        <a href="javascript:void(0)" id="refreshData" class="btn btn-primary btn-sm" title="Actualiser">
            <i class="fas fa-sync-alt"></i>
        </a> &nbsp; &nbsp; &nbsp;
        <input type="date" class="form-control form-control-sm" id="dateDebut" name="dateDebut" required> &nbsp; &nbsp;
        &nbsp;
        <input type="date" class="form-control form-control-sm" id="dateFin" name="dateFin" required> &nbsp; &nbsp;
        &nbsp;
        <div class="input-group-append">
            <button class="btn btn-outline-primary btn-sm" id="searchBetweenDates" title="Rechercher"><i
                    class="fa fa-search"></i> Recherche</button>
        </div> &nbsp; &nbsp; &nbsp; &nbsp;
        <div class="float-end">
            <!-- Bouton d'impression -->
        </div>
    </div>
</div>

<table class="table table-bordered table-striped table-sm fs--1 mb-0">
    <thead style="position: sticky; top: 0; background-color: white; z-index: 1;">
        <tr style="background-color:#82E0AA">
            <th style="width:5%">Code</th>
            <th style="width:45%">Description</th>
            <th>Solde</th>
            <th>Créé par</th>
            <th>Créé le</th>
            <th>Mises à jour le</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $historique->code }}</td>
            <td>{{ ucfirst($historique->libelle) }}</td>
            <td>{{ number_format($historique->solde, 0, ',', ' ') }}</td>
            <td>{{ ucfirst($historique->personnel_prenom) }}</td>
            <td>{{ $historique->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $historique->updated_at->format('d/m/Y H:i') }}</td>
        </tr>
    </tbody>
</table>
<br>

@if ($historiqueCompte->count() > 0)

    <table class="table table-bordered table-striped table-sm fs--1 mb-0">
        <thead style="position: sticky; top: 0; background-color: white; z-index: 1;">
            <tr style="background-color:#82E0AA">
                <th>Date</th>
                <th>
                    <center> N<sup>o </sup> Bon</center>
                </th>
                <th>Libellé</th>
                <th>
                    <center>Imput </center>
                </th>
                <th>
                    <center>Début</center>
                </th>
                <th>
                    <center>Crédit</center>
                </th>
                <th>
                    <center>Solde</center>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($historiqueCompte as $historiqueComptes)
                <tr>
                    <td style="width:8%">{{ $historiqueComptes->date }}</td>
                    <td style="width:5%" align="center">{{ $historiqueComptes->numerobon ?? '-' }}</td>
                    <td style="width:30%">{{ ucfirst($historiqueComptes->description) }}</td>
                    <td style="width:6%" align="center"> {{ $historiqueComptes->input ?? '-' }} </td>
                    <td align="right">{{ number_format($historiqueComptes->debit, 0, ',', ' ') }}</td>
                    <td align="right">{{ number_format($historiqueComptes->credit, 0, ',', ' ') }}</td>
                    <td align="right">{{ number_format($historiqueComptes->solde, 0, ',', ' ') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Aucun historique disponible.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <br>

    <form method="POST" id="addOnCaisse">
        <!-- Utilisation de id="modifierLigneForm" au lieu de id="modifierLigneModal" pour le formulaire -->
        @method('post')
        @csrf

        <div class="table-repsonsive">
            <span id="error"></span>
            <table class="table table-striped table-sm fs--1 mb-0">

                <tr style="background-color: rgba(255, 0, 0, 0.3);">
                    <th><i class="fa fa-plus-circle"></i> <strong>Clôture du mouvement de caisse </strong> </th>
                    <th>
                      <label for="monthInput">Sélectionnez le mois et l'année :</label>
                      <input type="month" id="moiAnne" name="moiAnne"  required />
                    </th>
                </tr>
                <tr>
                    <td>Etabli par <span class="text-danger">*</span> </td>
                    <td>Vérifiée par <span class="text-danger">*</span></td>
                </tr>
                <tr>
                    <td>
                        <div class="col-sm-12 col-lg-12 col-xl-12 ">
                            <select type="text" class="form-control form-control-sm" name="verifie_par"
                                id="verifie_par" required>
                                <option disabled="true" selected="true" value="">--Sélectionner personnel --
                                </option>
                                @foreach ($personnel as $personnels)
                                    <option value="{{ $personnels->userid }}">{{ $personnels->nom }}
                                        {{ $personnels->prenom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <select type="text" class="form-control form-control-sm" name="approuver_par"
                            id="approuver_par" required>
                            <option disabled="true" selected="true" value="">--Sélectionner personnel --</option>
                            @foreach ($personnel as $personnels)
                                <option value="{{ $personnels->userid }}">{{ $personnels->nom }}
                                    {{ $personnels->prenom }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
        </div>

        <table>
            @foreach ($historiqueCompte as $historiqueComptes)
                <tr>
                    <td><input type="hidden" name="caisseId[]" id="caisseId[]" value="{{ $historiqueComptes->idcc }}">
                    </td>
                </tr>
            @endforeach
        </table>

        <input type="hidden" name="soldeCaisse" value="{{ $historique->solde }}">
        <input type="hidden" name="compteId" id="compteId" value="{{ $historique->compid }}">

        <div class="modal-footer">
            <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal"><i
                    class="fa fa-times"></i> Fermer</button>
            <button type="submit" name="sendCloture" id="sendCloture" class="btn btn-primary waves-effect waves-light">
                <i class="fa fa-cloud-upload-alt"></i> Sauvegarder cloture caisse</button>
        </div>

    </form>

    <div class="pagination-wrapper">
        {!! $historiqueCompte->links() !!}
    </div>

@endif



<script>
    $(function() {
        // Add Compte ajax 
        $("#addOnCaisse").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#sendCompte").html('<i class="fas fa-spinner fa-spin"></i>');
            document.getElementById("sendCompte").disabled = true;

            $.ajax({
                url: "{{ route('clotureCaisse') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    try {
                        if (response.status == 200) {
                            toastr.success(
                                "  Clôture du mouvement de caisse fais avec succès. !",
                                "Cloture caisse");

                            $("#sendCompte").html(
                                '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                            window.location.href = "{{ route('Rapport.cloture.caisse') }}";
                        } else if (response.status == 201) {
                            toastr.error("La ligne de compte dans ce projet existe déjà !",
                                "Attention");
                        } else if (response.status == 202) {
                            toastr.error("Erreur lors de l'exécution : " + response.error,
                                "Erreur");
                        } else if (response.status == 203) {
                            toastr.error(
                                "Le solde du compte est insuffisant pour exécuter cette demande. Veuillez créditer le compte. : " +
                                response.error, "Erreur");
                        } else {
                            toastr.error("Réponse inattendue du serveur.", "Erreur");
                        }
                    } catch (error) {
                        toastr.error("Erreur inattendue : " + error.message, "Erreur");
                    } finally {
                        $("#sendCompte").html(
                            '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                        document.getElementById("sendCompte").disabled = false;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    let errorMessage;
                    if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                        errorMessage = jqXHR.responseJSON.error;
                    } else if (jqXHR.responseText) {
                        errorMessage = jqXHR.responseText;
                    } else if (textStatus) {
                        errorMessage = textStatus;
                    } else if (errorThrown) {
                        errorMessage = errorThrown;
                    } else {
                        errorMessage = "Erreur inconnue";
                    }

                    toastr.error("Erreur lors de la requête : " + errorMessage, "Erreur");
                    $("#sendCompte").html(
                        '<i class="fa fa-cloud-upload-alt"></i> Sauvegarder');
                    document.getElementById("sendCompte").disabled = false;
                }
            });
        });
    });
</script>
