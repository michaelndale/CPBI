@extends('layout/app')
@section('page-content')

<div class="main-content">
    <br>
    <div class="content">
    <a href="{{ route('listfeb') }}"> <i class="fas fa-long-arrow-alt-left"></i> Retour en arrière.</a> 
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-sm-12">


                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"> <i class="far fa-edit "></i> MODIFICATION DE FICHE D’EXPRESSION DES BESOINS "FEB" <br></h5> <br> <br>
                            </div>
                            <div class="modal-body">

                                <form class="row g-3 mb-6" method="POST" id="addfebForm" action="{{ route('updateallfeb', $dataFe->id )}}">
                                @method('PUT')
                                @csrf

                                    <input type="hidden" id="febid" name="febid" class="form-control form-control-sm" style="width: 100% ; background-color:#c0c0c0" value="{{ $dataFe->idfb  }}" readonly>
                                    <div id="tableExample2">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-sm fs--1 mb-0">
                                                <tbody class="list">
                                                    <tr>
                                                        <td class="align-middle ps-3 name" style="width:20%">Composante/ Projet/Section</td>
                                                        <td class="align-middle email" colspan="8">
                                                            <input value="{{ Session::get('id') }} " type="hidden" name="projetid" id="projetid">
                                                            <input value="{{ Session::get('title') }} " class="form-control form-control-sm" disabled>
                                                        </td>
                                                    </tr>
                                                  
                                                    <tr>
                                                    <td class="align-middle ps-3 name" colo>Activités </td>
                                                    <td colspan="4">
                                                    <input style="width:100%" type="hidden" id="idlibelle" name="idlibelle" class="form-control form-control-sm" value="{{ $datElementgene->libellee }}">
                                                                        <input style="width:100%" type="hidden" id="eligne" name="eligne" class="form-control form-control-sm" value="{{ $datElementgene->eligne }}">
                                                                        <input style="width:100%" type="hidden" id="grandligne" name="grandligne" class="form-control form-control-sm" value="{{ $datElementgene->grandligne }}">
                                                                
                                                                        <input type="text" class="form-control form-control-sm" name="descriptionf" id="descriptionf" value="{{ $dataFe->descriptionf}}" required>
                                                    </td>

                                                    <td class="align-middle ps-3 name" colo>Bénéficiaire </td>
                                                    <td colspan="3" >
                                                        
                                                        <select class="form-control  form-control-sm" id="beneficiaire" name="beneficiaire" required>

                                                            @if (isset($onebeneficaire->libelle) && !empty($onebeneficaire->libelle)) 
                                                            <option value="{{ $onebeneficaire->id }}">{{ $onebeneficaire->libelle }} </option>

                                                                @else
                                                                        <option> Select un benef</option>
                                                                @endif

                                                            @foreach ($beneficaire as $beneficaires)
                                                                <option value="{{ $beneficaires->id }}">{{ $beneficaires->libelle }}</option>
                                                            @endforeach
                                                         </select>
                                                   
                                                   
                                                    </td>
                                            </tr>





                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-middle ps-3 name">Numéro FEB <br>
                                                    
                                                            <input type="text" class="form-control form-control-sm" name="numerofeb" id="numerofeb" value="{{ $dataFe->numerofeb }}" >
                                                        </td>

                                                        <td class="align-middle ps-3 name">Période: <br>
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
                                                            <input type="date" class="form-control form-control-sm" name="datelimite" value="{{ $dataFe->datelimite }}" id="datelimite" style="width: 100%" >
                                                        </td>

                                                        <td class="align-middle ps-3 name" style="width:8%">
                                                            <center>
                                                                BC : <br> <input type="checkbox"  name="bc" id="bc" class="form-check-input" readonly
                                                                @if ($dataFe->bc==1)
                                                                        checked value="{{ $dataFe->bc }}"
                                                                @else
                                                                        value="{{ $dataFe->bc }}" 
                                                                @endif /> 
                                                            </center>
                                                        </td>

                                                        <td class="align-middle ps-3 name" style="width:8%" >
                                                            
                                                            <center>Facture: <br>
                                                            <input type="checkbox"  name="facture" id="facture" class="form-check-input" readonly
                                                                @if($dataFe->facture==1)
                                                                        checked value="{{ $dataFe->facture }}"
                                                                @else
                                                                        value="{{ $dataFe->facture }}" 
                                                                @endif 
                                                                    
                                                                    />
                                                            </center>
                                                        </td>

                                                        <td class="align-middle ps-3 name" style="width:8%">
                                                            <center>O.M: <br>
                                                            <input type="checkbox"  name="om" id="om" class="form-check-input" readonly
                                                                @if($dataFe->om==1)
                                                                    checked value="{{ $dataFe->om }}"
                                                            @else
                                                                    value="{{ $dataFe->om }}" 
                                                            @endif 
                                                                />
                                                            </center>
                                                        </td>

                                                        <td class="align-middle ps-3 name" style="width:8%">
                                                            <center>NEC: <br>
                                                            <input type="checkbox"  class="form-check-input" name="nec" readonly
                                                                @if($dataFe->nec==1)
                                                                    checked value="{{ $dataFe->nec }}"
                                                            @else
                                                                    value="{{ $dataFe->nec }}" 
                                                            @endif 
                                                                
                                                                />
                                                            </center>
                                                        </td>

                                                        <td class="align-middle ps-3 name" style="width:8%">
                                                            <center>FP/Devis <br>
                                                            <input type="checkbox"   class="form-check-input" name="fpdevis" readonly
                                                            @if($dataFe->fpdevis==1)
                                                                checked value="{{ $dataFe->fpdevis }}"
                                                        @else
                                                                value="{{ $dataFe->fpdevis }}" 
                                                        @endif 
                                                            />

                                                            </center>
                                                        </td>

                                                    </tr>

                                                    <tr>

                                                    </tr>
                                                </tbody>
                                            </table>

                                            <hr>



                                            <div class="table-responsive">
                                                <table class="table table-hover table-white" id="tableEstimate">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:80px">Num</th>
                                                            <th>Designation de la ligne</th>
                                                            <th>Description</th>
                                                            <th style="width:150px">Unité</th>
                                                            <th style="width:100px">Q<sup>té</sup></th>
                                                            <th style="width:50px">Frequence</th>
                                                            <th style="width:150px">P.U</th>
                                                            <th style="width:200px">P.T</th>

                                                            <th> <a href="javascript:void(0)" class="text-primary font-18" title="Add" id="addBtn"><i class="fa fa-plus-circle"></i></a></th>
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
                                                            <input style="width:100%" type="" id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="{{ $ndale }}"></td>


                                                            <td>

                                                                <select class="form-control form-control-sm" name="libelleid[]" id="libelleid">
                                                                    <option  value="{{ $datElements->libellee }}"  seleted >{{ $datElements->titrea }} </option>
                                                                    @foreach ($activiteligne as $activitelignes)
                                                                        <option  value="{{ $activitelignes->id }}"> {{ $activitelignes->titre }}</option>
                                                                    @endforeach
                                                                </select>
                                                               
                                                            </td>
                                                            <td> 
                                                                
                                                            <input style="width:100%" value="{{ $datElements->libelle_description }}" type="text" id="libelle_description" name="libelle_description[]" class="form-control form-control-sm" required>
                                                            <input  value="{{ $datElements->id }}" type="hidden" id="libelle_description_id" name="libelle_description_id[]" >
                                                          </td>
                                                            <td><input style="width:100%" value="{{ $datElements->unite }}" type="text" id="unit_cost" name="unit_cost[]" class="form-control form-control-sm unit_price" required  min="1"> </td>
                                                            <td><input style="width:100%" value="{{ $datElements->quantite }}" type="text" id="qty" name="qty[]" class="form-control form-control-sm qty" required  min="1"></td>
                                                            <td><input style="width:100%" value="{{ $datElements->frequence }}" type="text" id="frenquency" name="frenquency[]" class="form-control form-control-sm frenquency" required  min="1"></td>
                                                            <td><input style="width:100%" value="{{ $datElements->pu }}" type="text" id="pu" name="pu[]" class="form-control form-control-sm pu" required  min="1"></td>
                                                            <td><input style="width:100%" value="{{ $datElements->montant }}" type="text" id="amount" name="amount[]" class="form-control form-control-sm total" value="0" readonly></td>
                                                            <td><a href="{{ route('deleteelementsfeb', $datElements->idef) }}" id="{{ $datElements->idef }}" class="text-danger font-18 deleteIcon" title="Enlever"><i class="far fa-trash-alt"></i></a></td>

                                                        </tr>
                                                        @php
                                                            $ndale++;
                                                        @endphp
                                                            
                                                        @endforeach
                                                       
                                                       

                                                    </tbody>
                                                </table>

                                                <table class="table table-striped table-sm fs--1 mb-0">
                                                    <tfoot style="background-color:#c0c0c0">
                                                        <tr>
                                                            <td colspan="8">Total global :  </td>
                                                            <td align="right"><span class="total-global">{{ $sommefeb }} {{ Session::get('devise') }} </span></td>
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
                                                        </td>
                                                        <td>
                                                            <select type="text" class="form-control form-control-sm" name="comptable" id="comptable" required>
                                                                <option value="{{ $comptable_nom->userid }}">{{ ucfirst($comptable_nom->nom) }} {{ ucfirst($comptable_nom->prenom) }} </option>
                                                                @foreach ($personnel as $personnels)
                                                                <option value="{{ $personnels->userid }}">{{ $personnels->nom }} {{ $personnels->prenom }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select type="text" class="form-control form-control-sm" name="chefcomposante" id="chefcomposante" required>
                                                                <option value="{{ $checcomposant_nom->userid }}">{{ $checcomposant_nom->nom }} {{ $checcomposant_nom->prenom }}</option>
                                                                @foreach ($personnel as $chefcompables)
                                                                <option value="{{ $chefcompables->userid }}">{{ $chefcompables->nom }} {{ $chefcompables->prenom }}</option>
                                                                @endforeach
                                                            </select>
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
                                <button type="submit" class="btn btn-primary" ><i class="fa fa-check-circle"></i> Sauvegarder</button>
                            </div>
                            </form>
                            <br>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {

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
        <tr>
            <td><input style="width:100%" type="number" id="numerodetail" name="numerodetail[]" class="form-control form-control-sm" value="${rowIdx}" ></td>
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
            <td><input style="width:100%" type="text" id="pu" name="pu[]" class="form-control form-control-sm pu" required  min="1"></td>
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


    @endsection