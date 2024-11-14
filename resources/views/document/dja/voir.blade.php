@extends('layout/app')
@section('page-content')
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-12" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> MOdification du DEMANDE ET JUSTIFICATION
                            D'AVANCE (DJA) N<sup>o</sup> : {{ $data->numerudja }} </h4>
                        <div class="page-title-right">
                            <div class="btn-toolbar float-end" role="toolbar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form class="needs-validation" novalidate method="POST" id="EditdjdaForm">
                @method('post')
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                            <tr>
                                                <td colspan="2">
                                                    <label class="form-label">Présumé Bénéficiaire/Fournisseur/Prestataire à
                                                        payer:</label> <br>
                                                    @php
                                                        // Join the 'numerofeb' values with commas
                                                        $benefNom = $numerofeb->pluck('beneficiaireNom')->join(', ');
                                                    @endphp

                                                    {{ $benefNom }}

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    Adresse :
                                                    @php
                                                        $adresse_benef = collect($numerofeb)
                                                            ->pluck('adresse')
                                                            ->join(', ');
                                                    @endphp

                                                    {{ $adresse_benef }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="form-label">Téléphone1:</label>
                                                    @php
                                                        // Join the 'numerofeb' values with commas
                                                        $benefPhone_un = $numerofeb->pluck('telephoneone')->join(', ');
                                                    @endphp

                                                    {{ $benefPhone_un }}

                                                </td>
                                                <td>
                                                    <label class="form-label">Téléphone2:</label>
                                                    @php
                                                        // Join the 'numerofeb' values with commas
                                                        $benefPhone_deux = $numerofeb
                                                            ->pluck('telephonedeux')
                                                            ->join(', ');
                                                    @endphp

                                                    {{ $benefPhone_deux }}

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <label>DESCRIPTION/MOTIF:</label> <br>
                                                    @php
                                                        // Join the 'numerofeb' values with commas
                                                        $benefPhone_decription = $numerofeb
                                                            ->pluck('description')
                                                            ->join(', ');
                                                    @endphp
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- end card -->
                                    </div> <!-- end col -->

                                    <div class="col-xl-6">
                                        <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                                            <tr>
                                                <td>
                                                    <label class="form-label">Les fonds devront être reçus le
                                                        {{ $data->fond_recu_le }}</label>
                                                </td>
                                                <td>
                                                    <label class="form-label"> Référence (s) : FEB Nº</label>
                                                    @php
                                                        // Join the 'numerofeb' values with commas
                                                        $referenceFeb = $numerofeb->pluck('numerofeb')->join(', ');
                                                    @endphp

                                                    {{ $referenceFeb }}
                                                </td>
                                                <td>
                                                    DAP Nº {{ $data->nume_dap }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>OV/CHQ Nº {{ $data->cho }} </td>
                                                <td colspan="2">
                                                    @php
                                                        // Join the 'numerofeb' values with commas
                                                        $ligneB = $numerofeb->pluck('libelle_compte')->join(', ');
                                                    @endphp
                                                    Ligne budgétaire: {{ $ligneB }} </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Montant de l'avance :
                                                    {{ $data->montant_avance_un }}
                                                </td>
                                                <td>Dévise: {{ $devise }} </td>
                                                <td>
                                                    Durée de l’avance:(Jours) : {{ $data->duree_avance }}
                                                </td>
                                            </tr>
                                        </table>
                                        <br>
                                        <br>
                                    </div>
                                    <div class="col-xl-12">

                                        <table style="width:100%">
                                            <tr>
                                                <td>
                                                    Fonds demandes par : <br>
                                                    {{ $data->fonds_demandes_nom }} {{ $data->fonds_demandes_prenom }}
                                                </td>
                                                <td>
                                                    Signature
                                                </td>
                                                <td>
                                                    Date: <br>
                                                    {{ $data->date_fonds_demande_par }}

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Avance Approuvée par (2 personnes au moins) : <br>
                                                    {{ $data->avance_approuver_un_nom }}
                                                    {{ $data->avance_approuver_un_prenom }}</td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                        </table>


                                        <div class="card">
                                            <div class="card-body">



                                                <hr>

                                                <div class="row">
                                                    <!-- Approval by the first person -->
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Avance Approuvée par (2 personnes au
                                                                moins) :</label>
                                                            <select type="text" class="form-control form-control-sm"
                                                                name="avance_approuver_par_un" id="acce" required>
                                                                <option value="{{ $data->avance_approuver_un_userid }}">

                                                                </option>
                                                                @foreach ($personnel as $personnels)
                                                                    <option value="{{ $personnels->userid }}">
                                                                        {{ $personnels->nom }} {{ $personnels->prenom }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label class="form-label">Date</label>
                                                            <input name="date_signature_avance_approuver_un"
                                                                value="{{ $data->date_avance_approuver_par }}"
                                                                type="date" class="form-control form-control-sm" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3"></div>

                                                    <!-- Approval by the second person -->
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Nom</label>
                                                            <select type="text" class="form-control form-control-sm"
                                                                name="avance_approuver_par_deux" id="acce" required>
                                                                <option value="{{ $data->avance_approuver_par_deux }}">
                                                                    {{ $data->avance_approuver_par_deux_nom }}
                                                                    {{ $data->avance_approuver_par_deux_prenom }}
                                                                </option>
                                                                @foreach ($personnel as $personnels)
                                                                    <option value="{{ $personnels->userid }}">
                                                                        {{ $personnels->nom }} {{ $personnels->prenom }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label class="form-label">Date</label>
                                                            <input name="date_signature_avance_approuver_deux"
                                                                value="{{ $data->date_avance_approuver_par_deux }}"
                                                                type="date" class="form-control form-control-sm" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-2">
                                                            <label class="form-label">Fonds déboursés par: </label>
                                                            <select type="text" class="form-control form-control-sm"
                                                                name="fond_debourse_par" required>
                                                                <option value="{{ $data->fond_debourser_par }}">

                                                                    {{ $data->fond_debourser_nom }}
                                                                    {{ $data->fond_debourser_prenom }}

                                                                </option>
                                                                @foreach ($personnel as $personnels)
                                                                    <option value="{{ $personnels->userid }}">
                                                                        {{ $personnels->nom }} {{ $personnels->prenom }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-1">

                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <label class="form-label"> Date</label>
                                                            <input name="date_signe_fond_debourses" type="date"
                                                                value="{{ $data->date_fond_debourser_par }}"
                                                                class="form-control form-control-sm" />

                                                        </div>
                                                    </div>
                                                </div>


            </form>
        </div>
    </div>
    <!-- end card -->
    </div> <!-- end col -->

    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-2">
                            <label class="form-label">Fonds demandes par : </label>
                            <select type="text" class="form-control form-control-sm" name="fondPayea" id="acce"
                                required>
                                <option value="{{ $data->pfond_paye }}"> {{ $data->pfond_paye_nom }}
                                    {{ $data->pfond_paye_prenom }}
                                </option>
                                @foreach ($personnel as $personnels)
                                    <option value="{{ $personnels->userid }}">
                                        {{ $personnels->nom }} {{ $personnels->prenom }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <!-- DESCRIPTION/MOTIF Field -->
                    <div class="col-md-5">
                        <div class="mb-2">
                            <label>DESCRIPTION/MOTIF:</label>
                            <div>
                                <textarea name="fondPayeDescription" id="descriptionMotif" required class="form-control" rows="2">{{ $data->description_avance }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Plaque vehicule Field (Initially Hidden) -->
                    <div class="col-md-3" id="plaqueVehiculeDiv" style="display: none;">
                        <div class="mb-2">
                            <label class="form-label">Plaque vehicule utilisat</label>
                            <select type="text" class="form-control form-control-sm" name="plaque" id="acce"
                                required>
                                <option value="{{ $data->plaque }}">{{ $data->plaque }}</option>
                                @foreach ($vehicule as $vehicules)
                                    <option value="{{ $vehicules->matricule }}">
                                        {{ $vehicules->matricule }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>

                    <div class="col-md-3">
                        <div class="mb-2">
                            <label class="form-label">Montant de l'Avance</label>
                            <input name="montantAvancedeux" value="{{ $data->montant_avance }}" type="text"
                                class="form-control form-control-sm" />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-2">
                            <label class="form-label">Montant utilisé*</label>
                            <input name="montantUtilise" value="{{ $data->montant_utiliser }}" type="text"
                                class="form-control form-control-sm" />

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-2">
                            <label class="form-label">Surplus/Manque*</label>
                            <input name="surplusManque" value="{{ $data->montant_surplus }}" type="text"
                                class="form-control form-control-sm" />

                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="mb-2">
                            <label class="form-label">Montant retourné
                                à la caisse ou au compte(Si Surplus)
                            </label>
                            <input name="montantRetourne" value="{{ $data->montant_retourne }}" type="text"
                                class="form-control form-control-sm" />

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-2">
                            <label class="form-label">Réception des fonds retournés à la caisse par: <br>Noms de la
                                Caissière :
                            </label>
                            <select type="text" class="form-control form-control-sm" name="fond_retourne"
                                id="acce" required>
                                <option disabled="true" selected="true"
                                    value="{{ $data->fonds_retournes_caisse_par }} ">
                                    {{ $data->fonds_retournes_caisse_nom }} {{ $data->fonds_retournes_caisse_prenom }}
                                </option>
                                @foreach ($personnel as $personnels)
                                    <option value="{{ $personnels->userid }}">{{ $personnels->nom }}
                                        {{ $personnels->prenom }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-2">
                            <label class="form-label">ou Borderau de versement <br>nº <br>
                            </label>
                            <input name="bordereauVersement" value="{{ $data->bordereau_versement }}" type="text"
                                class="form-control form-control-sm" />

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-2">
                            <label class="form-label">Du <br>nº <br>
                            </label>
                            <input name="du" type="date" value="{{ $data->du_num }}"
                                class="form-control form-control-sm" />

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label">Réception des pièces justificatives de l'utilisation de l'avance
                                par:
                            </label>
                            <select type="text" class="form-control form-control-sm" name="reception_pieces_par"
                                id="acce" required>
                                <option disabled="true" selected="true"
                                    value="{{ $data->reception_pieces_justificatives }} ">
                                    {{ $data->reception_pieces_nom }} {{ $data->reception_pieces_prenom }}</option>
                                @foreach ($personnel as $personnels)
                                    <option value="{{ $personnels->userid }}">{{ $personnels->nom }}
                                        {{ $personnels->prenom }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>

                <br><br>
                <button id="edjitustifierbtn" name="editjustifierbtn" class="btn btn-primary editjustifierbtn"
                    type="submit"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                <br><br>

                </form>
            </div>
        </div>
        <!-- end card -->
    </div> <!-- end col -->
    </div>
    </div>
    </div>
    <!-- end card -->
    </div> <!-- end col -->
    </div>
    </form>
    </div>
    </div>
@endsection
