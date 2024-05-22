<!-- resources/views/active-users.blade.php -->
@extends('layout/app')
@section('page-content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><i class="fa fa-users""></i> Liste des Utilisateurs Actifs</h4>
           
                </div>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card">
         
                <div class="table-responsive">
                    <table class="table table-bordered table-sm fs--1 mb-0">
                        <thead>
                            <tr style="background-color:#82E0AA">
                                <th class="align-middle ps-3 name">#</th>
                                <th>Nom</th>
                                <th>Staut</th>
                              
                            </tr>
                        </thead>
                        <tbody id="showpleincarburent">
                            <tr>
                            @foreach ($activeUsers as $user)
                                <td>{{ $user->identifiant }} </td> <td> Dernière activité : {{ $user->last_activity->diffForHumans() }}</td>
                            @endforeach
                            </tr>
                        </tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
</div> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
@endsection
