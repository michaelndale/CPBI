@extends('layout/app')
@section('page-content')
@php
    $cryptedId = Crypt::encrypt($dataFe->id);
@endphp
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <div class="col-12" style="margin:auto">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> MODIFICATION DE FICHE D’EXPRESSION DES BESOINS "FEB"(N° {{ $dataFe->numerofeb }}) </h4>
                    <div class="page-title-right">
                        <div class="btn-toolbar float-end" role="toolbar">
                            <div class="btn-group me-2 mb-2 mb-sm-0">
                                @if($attachedDocIds)
                                    <a href="{{ route('showannex',$cryptedId) }}" type="button" class="btn btn-primary waves-light waves-effect" title="Annexer les documents"><i class="fa fa-link"></i></a>
                                @endif

                                

                                <a href="{{ route('generate-pdf-feb', $dataFe->id) }}" class="btn btn-primary waves-light waves-effect" title="Imprimer FEB encours"><i class="fa fa-print"></i> </a>
                                <a href="{{ route('key.viewFeb', $cryptedId ) }}" class="btn btn-primary waves-light waves-effect" title="Previsualisation du FEB" ><i class="fa fa-eye"></i> </a>
                                <a href="{{ route('listfeb') }}" type="button" class="btn btn-primary waves-light waves-effect" title="Liste des FEBS"><i class="fa fa-list"></i></a>
                                <a href="{{ route('nouveau.feb') }}" type="button" class="btn btn-primary waves-light waves-effect" itle="Creer Nouvelle FEB" ><i class="fa fa-plus-circle"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <form class="row g-3 mb-6" method="POST" id="addfebForm" action="{{ route('updateallfeb', $dataFe->id )}}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="febid" name="febid" class="form-control form-control-sm" style="width: 100% ; background-color:#c0c0c0" value="{{ $dataFe->idfb  }}" readonly>
                        <div id="tableExample2">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm fs--1 mb-0">
                                    <tbody class="list">
                                        <tr>
                                            <td class="align-middle ps-3 name" colspan="2">Composante/ Projet/Section </br>
                                                <input value="{{ Session::get('id') }} " type="hidden" name="projetid" id="projetid">
                                                <input value="{{ Session::get('title') }} " class="form-control form-control-sm" disabled>
                                            </td>
                                            <td rowspan="2" style="width:40%">
                                                Référence des documents à attacher
                                                
                                                <select class="form-control form-control-sm" id="annex" name="annex[]" multiple>
                                                    <option disabled selected value="">-- Sélectionner les documents attachés --</option>
                                                    @foreach ($attache as $attaches)
                                                        <option value="{{ $attaches->id }}" 
                                                                class="{{ in_array($attaches->id, $attachedDocIds) ? 'attached-option' : '' }}" 
                                                                {{ in_array($attaches->id, $attachedDocIds) ? 'selected' : '' }}>
                                                            {{ $attaches->libelle }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @if($attachedDocIds)
                                                <a href="{{ route('showannex',$cryptedId) }}" title="Annexer les documents">  <i class="fa fa-plus-circle"></i> Attacher le document physique </a>
                                                @endif
                                               
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle ps-3 name" colspan="2">Ligne budgétaire: 
                                                <select class="form-control  form-control-sm" id="ligneid" name="ligneid" required>
                                                    <option value="{{ $dataFe->ligne_bugdetaire }} - {{ $dataFe->sous_ligne_bugdetaire }}">{{ $dataFe->numeroc }}: {{ $dataFe->libellec }}</option>
                                                    @foreach ($compte as $comptes)
                                                    <optgroup label="{{ $comptes->libelle }}">
                                                        @php
                                                        $idc = $comptes->id ;
                                                        $res= DB::select("SELECT * FROM comptes WHERE compteid= $idc");
                                                        @endphp
                                                        @foreach($res as $re)
                                                        <option value="{{ $comptes->id }} - {{ $re->id }}"> {{ $re->numero }}. {{ $re->libelle }} </option>
                                                        @endforeach
                                                    </optgroup>
                                                    @endforeach
                                                </select>
                                                <input style="width:100%" type="hidden" id="idlibelle" name="idlibelle" class="form-control form-control-sm" value="{{ $datElementgene ? $datElementgene->libellee : '' }}">
                                                @if(!$datElementgene || !$datElementgene || !$datElementgene)
                                                <small class="text-danger">Erreur: Propriété 'libellee' introuvable.</small>
                                                @endif

                                                <input style="width:100%" type="hidden" id="eligne" name="eligne" class="form-control form-control-sm" value="{{ $datElementgene ? $datElementgene->eligne : '' }}">
                                                @if(!$datElementgene)
                                                <small class="text-danger">Erreur: Propriété 'eligne' introuvable.</small>
                                                @endif

                                               
                                                @if(!$datElementgene)
                                                <small class="text-danger">Erreur: Propriété 'grandligne' introuvable.</small>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="0" class="align-middle ps-3 name">Activités
                                                <input type="text" class="form-control form-control-sm" name="descriptionf" id="descriptionf" value="{{ $dataFe->descriptionf}}" required>
                                            </td>
                                            <!-- Dans la vue Blade -->
                                                <td class="align-middle ps-3 name" colo>
                                                    Bénéficiaire
                                                    <select class="form-control form-control-sm" id="beneficiaire" name="beneficiaire" >
                                                        @if (isset($onebeneficaire->libelle) && !empty($onebeneficaire->libelle))
                                                            <option value="{{ $onebeneficaire->id }}">{{ $onebeneficaire->libelle }} </option>
                                                        @else
                                                            <option value="autres">Sélectionner un bénéficiaire</option>
                                                        @endif
                                                        @foreach ($beneficaire as $beneficaires)
                                                            <option value="{{ $beneficaires->id }}">{{ $beneficaires->libelle }}</option>
                                                        @endforeach
                                                        <option value="autres">Autres</option>
                                                    </select>
                                                </td>

                                                <td colspan="0">
                                                    <!-- Conteneur du champ Nom & Prénom, caché par défaut en CSS -->
                                                    <div id="nomPrenomContainer" style="display: {{ isset($dataFe->beneficiaire) && !empty($dataFe->beneficiaire) ? 'none' : 'block' }};">
                                                        Nom & Prénom du bénéficiaire<br>
                                                        <input type="text" name="autresBeneficiaire" id="nomPrenomBeneficiaire" value="{{ $dataFe->autresBeneficiaire }} "
                                                            class="form-control form-control-sm" style="width: 100%;">
                                                    </div>
                                                </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table style="width:80%">
                                    <tbody>
                                        <tr>
                                            
                                            <td class="align-middle ps-3 name" colspan="0">
                                                Numéro FEB <br>
                                                <input type="text" class="form-control form-control-sm" name="numerofeb" id="numerofeb" value="{{ $dataFe->numerofeb }}">
                                            </td>

                                            <td class="align-middle ps-3 name" >Période: <br>
                                                <select type="text" class="form-control form-control-sm" name="periode" id="periode" style="width: 100%" required>
                                                    <option value="{{ $dataFe->periode }}"> {{ $dataFe->periode }} </option>
                                                    @php
                                                    $periode= Session::get('periode')
                                                    @endphp
                                                    @for($i =1 ; $i <= $periode ; $i++ ) <option value="T{{$i}}"> T{{$i}} </option>
                                                        @endfor
                                                </select>
                                            </td>

                                            <td class="align-middle ps-3 name"> Date du dossier FEB: <br>
                                                <input type="date" class="form-control form-control-sm" name="datefeb" id="datefeb" style="width: 100%" value="{{ $dataFe->datefeb }}" required>
                                            </td>

                                            <td class="align-middle ps-3 name"> Date limite: <br>
                                                <input type="date" class="form-control form-control-sm" name="datelimite" value="{{ $dataFe->datelimite }}" id="datelimite" style="width: 100%">
                                            </td>

                                        </tr>

                                       
                                        <tr>

                                        </tr>
                                    </tbody>
                                </table>

                              
                                <div class="table-responsive">
                                    <br>
                                    <table class="table table-striped table-sm fs--1 mb-0" id="tableEstimate">
                                        <thead>
                                            <tr style="background-color:#3CB371; color:white">
                                                <th style="width:10px; color:white">Num</th>
                                                <th style="width:300px; color:white">Designation de la ligne</th>
                                                <th style="width:200px; color:white">Description</th>
                                                <th style="width:50px; color:white">Unité</th>
                                                <th style="width:30px; color:white">Q<sup>té</sup></th>
                                                <th style="width:30px; color:white">Freq.</th>
                                                <th style="width:70px; color:white">P.U</th>
                                                <th style="width:70px; color:white">P.T</th>

                                                <th> <a href="javascript:void(0)" class="text-primary font-18" title="Add" id="addBtn"><i class="fa fa-plus-circle" style="color:white"></i></a></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $ndale=1;
                                            @endphp

                                            @foreach ($datElement as $datElements)
                                            <tr>
                                                <td>
                                                    <input style="width:100%" type="hidden" id="idelements" name="idelements[]" class="form-control form-control-sm" value="{{ $datElements->idef }}">
                                                    <input style="width:100%" type="hidden" id="referencefeb" name="referencefeb[]" class="form-control form-control-sm" value="{{ $datElements->febid }}">
                                                    <input style="width:100%; border:none;" type="" id="numerodetail" name="numerodetail[]" value="{{ $ndale }}" readonly>
                                                </td>

                                                <td>
                                                    <select class="form-control form-control-sm" name="libelleid[]" id="libelleid">
                                                        <option value="{{ $datElements->libellee }}" seleted> {{ $datElements->titrea }} </option>
                                                        @foreach ($activiteligne as $activitelignes)
                                                        <option value="{{ $activitelignes->id }}"> {{ $activitelignes->titre }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input style="width:100%" value="{{ $datElements->libelle_description }}" type="text" id="libelle_description" name="libelle_description[]" class="form-control form-control-sm" required>
                                                   
                                                </td>
                                                <td><input style="width:100%" value="{{ $datElements->unite }}" type="text" id="unit_cost" name="unit_cost[]" class="form-control form-control-sm unit_price" required > </td>
                                                <td><input style="width:100%" value="{{ $datElements->quantite }}" type="text" id="qty" name="qty[]" class="form-control form-control-sm qty" required min="1"></td>
                                                <td><input style="width:100%" value="{{ $datElements->frequence }}" type="text" id="frenquency" name="frenquency[]" class="form-control form-control-sm frenquency" required min="1"></td>
                                                <td><input style="width:100%" value="{{ $datElements->pu }}" type="number" id="pu" name="pu[]" class="form-control form-control-sm pu" required min="1"></td>
                                                <td><input style="width:100%" value="{{ $datElements->montant }}" type="text" id="amount" name="amount[]" class="form-control form-control-sm total" value="0" readonly></td>
                                                <td style="width:3%;"><a href="{{ route('deleteelementsfeb', $datElements->idef) }}" id="{{ $datElements->idef }}" class="text-danger font-18 deleteIcon" title="Supprimer la ligne"><i class="far fa-trash-alt"></i></a></td>
                                            </tr>
                                           
                                            @php
                                            $ndale++;
                                            @endphp
                                            @endforeach
                                        </tbody>

                                        <tfoot style="background-color:#8FBC8F">
                                            <tr>
                                                <td colspan="7"><b>Total global :</b></td>
                                                <td align="right"><span class="total-global"><b>{{ $sommefeb }} {{ Session::get('devise') }}</b> </span></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <hr>
                                </div>
                                <div class="table-repsonsive">
                                    <span id="error"></span>
                                    <table class="table table-striped table-sm fs--1 mb-0">
                                        <tr>
                                        <tr>
                                            <td>Etablie par (AC/CE/CS) </td>
                                            <td>Vérifiée par (Comptable)</td>
                                            <td>Approuvée par (Chef de Composante/Projet/Section):</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select type="text" class="form-control form-control-sm" name="acce" id="acce" required>
                                                    <option value="{{ $etablienom->userid }}"> {{ ucfirst($etablienom->nom) }} {{ ucfirst($etablienom->prenom) }} </option>
                                                    @foreach ($personnel as $personnels)
                                                    <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="acce_signe" id="acce_signe" value="{{ $dataFe->acce_signe }}" />

                                                <input type="hidden" name="ancien_acce" id="ancien_acce" value="{{ $dataFe->acce }}" />
                                            </td>
                                            <td>
                                                <select type="text" class="form-control form-control-sm" name="comptable" id="comptable" required>
                                                    <option value="{{ $comptable_nom->userid }}">{{ ucfirst($comptable_nom->nom) }} {{ ucfirst($comptable_nom->prenom) }} </option>
                                                    @foreach ($personnel as $personnels)
                                                    <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="comptable_signe" id="comptable_signe" value="{{ $dataFe->comptable_signe }}" />
                                                <input type="hidden" name="ancien_comptable" id="ancien_comptable" value="{{ $dataFe->comptable }}" />
                                            </td>
                                            <td>
                                                <select type="text" class="form-control form-control-sm" name="chefcomposante" id="chefcomposante" required>
                                                    <option value="{{ $checcomposant_nom->userid }}">{{ $checcomposant_nom->nom }} {{ $checcomposant_nom->prenom }}</option>
                                                    @foreach ($personnel as $chefcompables)
                                                    <option value="{{ $chefcompables->userid }}">{{ $chefcompables->nom }} {{ $chefcompables->prenom }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="chef_signe" id="chef_signe" value="{{ $dataFe->chef_signe }}" />
                                                <input type="hidden" name="ancien_chefcomposante" id="ancien_chefcomposante" value="{{ $dataFe->chefcomposante }}" />
                                            </td>
                                        </tr>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <br><br><br>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                </div>
                </form>
                <br>
            </div>
        </div>
    </div>



</div>
</div>
</div>
</div>
</div>

@include('document.feb.annex')

<style>
    .attached-option {
    color: blue; /* Changez la couleur selon votre préférence */
    font-weight: bold; /* Ajout de gras pour les distinguer encore plus */
}
</style>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    document.getElementById('beneficiaire').addEventListener('change', function () {
        const nomPrenomContainer = document.getElementById('nomPrenomContainer');
        if (this.value === 'autres' || this.value === '') {
            nomPrenomContainer.style.display = 'block';  // Affiche le champ si "Autres" est sélectionné
        } else {
            nomPrenomContainer.style.display = 'none';  // Cache le champ pour les autres options
        }
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
        <tr>
            <td><input style="width:100%" type="number" id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="${rowIdx}" readonly></td>
            <td> 
               <select class="form-control form-control-sm" name="libelleid[]" id="libelleid" required>
               <option> Aucun</option>
               @foreach ($activiteligne as $activitelignes)
               <option  value="{{ $activitelignes->id }}" > {{ $activitelignes->titre }}</option>
               @endforeach
               </select>
            </td>
            <td><input style="width:100%" type="text" id="libelle_description" name="libelle_description[]" class="form-control form-control-sm" required></td>
            <td><input style="width:100%" type="text" id="unit_cost" name="unit_cost[]" class="form-control form-control-sm" required ></td>
            <td><input style="width:100%" type="text" id="qty" name="qty[]" class="form-control form-control-sm qty" required min="1"></td>
            <td><input style="width:100%" type="text" id="frenquency" name="frenquency[]" class="form-control form-control-sm frenquency" required  min="1"></td>
            <td><input style="width:100%" type="number" id="pu" name="pu[]" class="form-control form-control-sm pu" required  min="1"></td>
            <td><input style="width:100%" type="text" id="amount" name="amount[]" class="form-control form-control-sm total" value="0" readonly required></td>
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
</script>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {


        $(document).on('click', '.deleteIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
            Swal.fire({

                title: 'Êtes-vous sûr ?',
                text: "Un element du FEB est sur le point d'être DÉTRUITE ! Faut-il vraiment exécuter « la Suppression » ?  ",

                showCancelButton: true,
                confirmButtonColor: 'green',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, Supprimer !',
                cancelButtonText: 'Annuller'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('deleteelementsfeb') }}",
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {

                            if (response.status == 200) {
                                window.location.reload();
                                toastr.success("Elements FEB supprimer avec succès !", "Suppression");

                            }

                            if (response.status == 205) {
                                toastr.error("Vous n'avez pas l'accreditation de supprimer cet elements de la feb!", "Erreur");
                            }

                            if (response.status == 202) {
                                toastr.error("Erreur d'execution !", "Erreur");
                            }
                            //window.location.reload();

                        }
                    });
                }
            })
        });

    });
</script>


@endsection