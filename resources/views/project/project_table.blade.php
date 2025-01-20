
    @foreach ($data as $datas)
        @php
            $accessCount = DB::table('affectations')
                ->where('memberid', Auth::id())
                ->where('projectid', $datas->idpr)
                ->count();
            $cryptedId = Crypt::encrypt($datas->idpr);
        @endphp

        <tr>
            <td>
                @if($accessCount == 1)
                    <a href="{{ route('key.viewProject', $cryptedId) }}" class="text-dark">{{ $datas->title }}</a>
                @else
                    <a href="javascript:void(0)" class="text-dark" onclick="showAccessDeniedAlert()">{{ $datas->title }}</a>
                @endif
            </td>
            <td><i class="ri-user-3-fill"></i> {{ ucfirst($datas->nom) }} {{ ucfirst($datas->prenom) }}</td>
            <td align="center">
                @if($accessCount == 1)
                    <font size="2px" color="green"><i class="mdi mdi-check-decagram"></i></font>
                @else
                    <font size="2px" color="red"><i class="mdi mdi-close-circle"></i></font>
                @endif
            </td>
            <td align="center">
                @if($accessCount == 1)
                    <span class="badge rounded-pill bg-primary">Ouvert</span>
                @else
                    <span class="badge rounded-pill bg-danger">Fermer</span>
                @endif
            </td>
            <td>{{ date('d-m-Y', strtotime($datas->start_date)) }}</td>
            <td>{{ date('d-m-Y', strtotime($datas->deadline)) }}</td>
        </tr>
    @endforeach
