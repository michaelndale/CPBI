@extends('layout/app')
@section('page-content')
<div class="main-content">
    <div class="page-content">
        <div class="card shadow-none border border-300 mb-3" data-component-card="data-component-card" style=" margin:auto">
            <div class="card-header p-4 border-bottom border-300 bg-soft">
                <div class="row g-3 justify-content-between align-items-end">
                    <div class="col-12 col-md">
                        <h4 class="card-title mb-0"> <i class="fa fa-list"></i> 
                            Classement caisse du cloture numéro : {{ $classement->numero_groupe }} ,
                            Mois {{ date('m/Y', strtotime($classement->moianne))  }}

                            
                        
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div id="tableExample2">
                    <div class="table-responsive" id="table-container" style="overflow-y: auto;">
                        @if ($historiqueCompte->count() > 0)
                        <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                            <thead style="position: sticky; top: 0; background-color: white; z-index: 1;">
                                <tr style="background-color:#82E0AA">
                                    <th style="width:7%">Date</th>
                                    <th style="width:5%"><center>N<sup>o</sup> Bon</center></th>
                                    <th>Libellé</th>
                                    <th> <center> Imput</center> </th>
                                    <th> <center>Début</center> </th>
                                    <th> <center>Crédit</center>  </th>
                                    <th><center>Solde</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historiqueCompte as $historiqueComptes)
                                <tr>
                                    <td>{{ $historiqueComptes->dates }}</td>
                                    <td align="center">{{ $historiqueComptes->numerobons }}</td>
                                    <td style="width:30%">{{ $historiqueComptes->descriptions }}</td>
                                    <td style="width:7%" align="center">{{ $historiqueComptes->inputs }}</td>
                                    <td align="right">{{ number_format($historiqueComptes->debits, 0, ',', ' ') }}</td>
                                    <td align="right">{{ number_format($historiqueComptes->credits, 0, ',', ' ')  }}</td>
                                    <td align="right">{{ number_format($historiqueComptes->soldes, 0, ',', ' ')   }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                        <br>
                        <form method="POST" action="{{ route('update_signature_cloture') }}">
                            @method('post')
                            @csrf
                           <!-- <center>
                                <tabble>
                                    <tr>
                                        <td style="width:20%"> Fait à &nbsp;&nbsp; </td>
                                        <td style="width:50%">
                                            <input type="text" value="{{ $classement->fait_a }}" name="lieu" id="lieu" placeholder=" lieu " style="width:10%; border:none; border-bottom: 2px dotted #000;" />
                                        </td>
                                        <td style="width:30%">, le
                                            
                                        </td>
                                    </tr>
                                </tabble>
                            </center> -->
                            <br><br>


                            <input type="hidden" name="rapportid"  value="{{ $classement->id }} ">
                            <input type="hidden" name="soldeCaisse" value="{{ $classement->dernier_solde }}">
                            <input type="hidden" name="compteId" id="compteId" value="{{ $classement->compteid }}">
                            <input type="hidden" name="ProjetId" id="ProjetId" value="{{ $classement->projetid }}">




                            <table style="width:80% ; margin:auto">
                                <tr>


                                    <td align="center">
                                        Verifier par <br>

                                        {{ $verifie_par->nom }} {{ $verifie_par->prenom }}
                                        <br>

                                        @if(Auth::user()->id == $classement->verifier_par)
                                        <input class="form-check-input" type="checkbox" name="verifier" id="verifier"
                                            {{ $classement->verifier_signature=="1"? 'checked':'' }} style="border:2px solid red"> <small>Cochez pour Poser la signature</small>
                                        @endif
                                        <input type="hidden" name="clone_verifier" value="{{ $classement->verifier_signature }}" />
                                        <br>
                                        @if($verifie_par)
                                        @if ($classement->verifier_signature==1)
                                        <img src="{{ asset($verifie_par->signature) }}" width="150px" />
                                        <br>
                                        <input type="date" value="{{ $classement->le_etablie }}" name="le_etablie" id="le_etablie" placeholder="date" style="width:15%; border:none; border-bottom: 2px dotted #000;" />

                                        @endif
                                        @endif


                                    </td>

                                    <td align="center">
                                        Approver par <br>

                                        {{ $approuver_par->nom }} {{ $approuver_par->prenom }}
                                        <br>

                                        @if(Auth::user()->id == $classement->approver_par)
                                        <input class="form-check-input" type="checkbox" id="approver" name="approver"
                                            {{ $classement->approver_signature=="1"? 'checked':'' }} style="border:2px solid red"> <small>Cochez pour Poser la signature</small>
                                        @endif
                                        <input type="hidden" name="clone_approver" value="{{ $classement->approver_signature  }}" />


                                        
<br>

                                        @if($approuver_par)
                                        @if ($classement->approver_signature==1)
                                        <img src="{{ asset($approuver_par->signature) }}" width="150px" />
                                        
                                        @endif

                                        @endif
                                        <br>
                                        <input type="date" value="{{ $classement->le_verifier }}" name="le_verifier" id="le_verifier" placeholder="date" style="width:15%; border:none; border-bottom: 2px dotted #000;" />

                                    </td>
                                </tr>

                            </table>


                            @if(Auth::user()->id == $classement->verifier_par || Auth::user()->id == $classement->approver_par )
                            <div class="float-end" style="padding:50px">
                                <button type="submit" name="save" id="dave" class="btn btn-primary w-md"> <i class="fas fa-cloud-download-alt"> </i> Sauvegarder la signature </button>
                                <br>
                                <br><small>
                                    <center> <i class="fa fa-info-circle"></i><br> Cochez la case située en dessous <br> de votre nom si vous êtes accrédité <br> pour apposer votre signature <br> puis cliquez sur le boutton <br> sauvegarder la signature</center>
                                </small>
                            </div>

                            @endif



                        </form>


                        <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container-fluid -->
</div>



<style>
    .swal-custom-content .swal-text {
        font-size: 14px;
        /* Ajustez la taille selon vos besoins */
    }
</style>

@endsection