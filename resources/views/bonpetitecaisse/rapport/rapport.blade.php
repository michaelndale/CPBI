
<table class="table table-bordered table-striped table-sm fs--1 mb-0">
    <tr>
        <td> Compte caisse : {{ $classement->codes }}: {{ $classement->libelles }}</td>
        <td> Numéro de classement : {{ $classement->numero_groupe }}</td>
       
    </tr>
</table>

<table class="table table-bordered table-striped table-sm fs--1 mb-0">
    <thead>
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
        @foreach ($data as $item)
        <tr>
            <td style="width:8%">{{ $item->date   }}</td>
            <td style="width:5%" align="center">{{ $item->numerobon ?? '-' }}</td>
            <td style="width:30%">{{ ucfirst($item->description) }}</td>
            <td style="width:6%" align="center"> {{ $item->input ?? '-' }} </td>
            <td align="right">{{ number_format($item->debit, 0, ',', ' ') }}</td>
            <td align="right">{{ number_format($item->credit, 0, ',', ' ')  }}</td>
            <td align="right">{{ number_format($item->solde, 0, ',', ' ')   }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<table style="width:80% ; margin:auto">
    <tr>
        <td align="center">
            Etabli par <br>
            {{ $verifie_par->nom }} {{ $verifie_par->prenom }}
            <br>
            @if($verifie_par)
            @if ($classement->verifier_signature==1)
            <img src="{{ asset($verifie_par->signature) }}" width="150px" />
            @endif
            @endif
        </td>
        <td align="center">
            Vérifié par<br>
            {{ $approuver_par->nom }} {{ $approuver_par->prenom }}
            <br>
            @if($approuver_par)
            @if ($classement->approver_signature==1)
            <img src="{{ asset($approuver_par->signature) }}" width="150px" />
            @endif
            @endif
        </td>
    </tr>
</table>
<center>
    <br> Fait à {{ $classement->fait_a }} , le {{ date('d-m-Y', strtotime($classement->le))  }}
</center>
<br>
