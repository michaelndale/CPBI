<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <span style="color:#3CB371">
                    <i class="fas fa-spinner fa-spin"></i> Chargement en cours...
                </span>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="dapModale" tabindex="-1" aria-labelledby="dapModale" aria-hidden="true">
    <div class="modal-dialog modal-xl  modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="far fa-file-alt "></i> Demande et Autorisation de Paiement (DAP) </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1" style="color:#58D68D"></span></button>
            </div>
            <div class="modal-body">

                <form class="row g-3 mb-6" method="POST" id="adddapForm">
                    @method('post')
                    @csrf

                    <div id="tableExample2">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm fs--1 mb-0">
                                <tbody class="list">

                                    <tr>
                                        <td style="width:120px"> Numéro fiche </br>

                                            <input type="text" id="numerodap" name="numerodap" class="form-control form-control-sm" required>
                                        </td>
                                        <td style="width:300px"> Service <br>
                                            <select type="text" name="serviceid" id="serviceid" style="width: 100%" class="form-control form-control-sm" required>
                                                <option value="">--Aucun--</option>
                                                @forelse ($service as $services)
                                                <option value="{{ $services->id }}"> {{ $services->title }} </option>
                                                @empty
                                                <option value="">--Aucun service trouver--</option>
                                                @endforelse
                                            </select>
                                        </td>

                                        <td>
                                            <b>Composante/ Projet/Section </b><br>
                                            <input value="{{ Session::get('id') }}" type="hidden" name="projetid" id="projetid" required>
                                            <input value="{{ Session::get('title') }}" class="form-control form-control-sm" disabled>
                                        </td>


                                        <td class="align-middle" style="width:20% ;  background: rgba(76, 175, 80, 0.3)">
                                            <b>FEB Nº: </b> <br>
                                            <select type="text" class="form-control form-control-sm febid" style="width: 100%" required>
                                                <option value="">--Aucun--</option>
                                                @forelse ($feb as $febs)
                                                <option value="{{ $febs->numerofeb }}"> {{ $febs->numerofeb }} </option>
                                                @empty
                                                <option value="">--Aucun Numero FEB trouver--</option>
                                                @endforelse
                                            </select>

                                        </td>

                            </table>

                            <table class="table table-striped table-sm fs--1 mb-0 table-bordered">
                                <tr>

                                    <td> Lieu
                                        <input type="text" name="lieu" id="lieu" style="width: 100%" class="form-control form-control-sm"  required/>
                                    </td>

                                    <td> Compte bancaire (BQ):
                                        <input type="text" class="form-control form-control-sm" name="comptebanque" id="comptebanque" style="width: 100%" required>
                                    </td>

                                    <td> Solde comptable (Sc):
                                        <input type="text" class="form-control form-control-sm" value="{{ $somfeb }}" readonly style="background-color:#c0c0c0" required>
                                    </td>

                                    <td align="center"> OV nº : <br>
                                        <input  type="checkbox" class="form-check-input" name="ov" id="ov" >
                                    </td>

                                    <td align="center"> CHQ nº <br>
                                        <input  type="checkbox" class="form-check-input" name="ch" id="ch" >
                                    </td>
                                </tr>

                            </table>

                            <hr>

                            <div id="Showpoll" class="Showpoll">
                                <h6 style="margin-top:1% ;color:#c0c0c0">
                                    <center>
                                        <font size="5px"><i class="fa fa-search"></i> </font><br><br>
                                        En attente ... <br> Veuillez Sélectionner le FEB Nº:
                                    </center>
                                </h6>
                            </div>

                            <hr>
                            <table class="table table-striped table-sm fs--1 mb-0 table-bordered">

<tr>
    <td colspan="3"><b> Vérification et Approbation de la Demande de paiement </b></td>

</tr>
<tr>
    <td> <b> Demande établie par </b> <br>
        <small> Chef de Composante/Projet/Section </small>  
    </td>

    <td> <b> Vérifiée par :</b> <br>
        <small> Chef Comptable</small>
         
    </td>

    <td> <b> Approuvée par : </b> <br>
        <small>Chef de Service</small>
         
    </td>


</tr>
<tr>

    <td>
        <select type="text" class="form-control form-control-sm" name="demandeetablie" id="demandeetablie" required>
            <option value="">-- Chef de Composante/Projet/Section --</option>
            @foreach ($personnel as $personnels)
            <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <select type="text" class="form-control form-control-sm" name="verifier" id="verifier" required>
            <option value="">--Chef Comptable--</option>
            @foreach ($personnel as $personnels)
            <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
            @endforeach
        </select>
    </td>


    <td>
        <select type="text" class="form-control form-control-sm" name="approuver" id="approuver" required>
            <option value="">--Chef de Service --</option>
            @foreach ($personnel as $personnels)
            <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
            @endforeach
        </select>
    </td>
</tr>

</table>

<hr>

<table class="table table-striped table-sm fs--1 mb-0 table-bordered">

    <tr>
        <td colspan="4"><b> Autorisaction de paiement</b></td>

    </tr>

    </tr>

    <tr>
        <td aligne="center">Autorisé le <center> <input class="form-control form-control-sm" id="basic-form-dob" type="date" id="datesecretairegenerale" name="datesecretairegenerale" /></center>
        </td>
        <td>
            Responsable Administratif et Financier : <br>
            <select type="text" class="form-control form-control-sm" name="resposablefinancier" id="resposablefinancier" required>
                <option value="">--Selectionnez personnel--</option>
                @foreach ($personnel as $personnels)
                <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                @endforeach
            </select>
        </td>
        <td>
            Secrétaire Général de la CEPBU : <br>
            <select type="text" class="form-control form-control-sm" name="secretairegenerale" id="secretairegenerale" required>
                <option value="">--Selectionnez personnel--</option>
                @foreach ($personnel as $personnels)
                <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                @endforeach
            </select>
        </td>


        <td>
            Chef des Programmes </br>
            <select type="text" class="form-control form-control-sm" name="chefprogramme" id="chefprogramme" required>
                <option value="">--Selectionnez personnel--</option>
                @foreach ($personnel as $personnels)
                <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                @endforeach
            </select>
        </td>
    </tr>


    <tr>
        <td colspan="4"><b>Observations/Instructions du SG : </b> <br>
            <textarea class="form-control form-control-sm" name="observation" id="observation" >-</textarea>
        </td>
    </tr>
</table>



                        </div>
                    </div>
        
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="adddapbtn" name="adddapbtn"><i class="fa fa-check-circle"></i> Sauvegarder</button>
        </div>
        </form>
    </div>
</div>
</div>

<script>
    const checkbox1 = document.getElementById('ch');
    const checkbox2 = document.getElementById('ov');

    checkbox1.addEventListener('change', function() {
        if (this.checked) {
            checkbox2.checked = false;
        }
    });

    checkbox2.addEventListener('change', function() {
        if (this.checked) {
            checkbox1.checked = false;
        }
    });
</script>