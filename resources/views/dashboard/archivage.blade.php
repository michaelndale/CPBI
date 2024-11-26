@extends('layout/app')
@section('page-content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Tableau de bord des Archivage <BR><!-- COMMUNAUTÉ DES EGLISES DE PENTECÔTE AU BURUNDI “CEPBU” c--> </h4>
                        <div class="page-title-right">
                            <e class="form-control ps-6 "> @include('dashboard.time')</e>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">


                <div class="col-xl-12">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap pb-3 gap-3">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-truncate mb-2">Personnels</p>
                                            <h4 class="mt-2 mb-0">{{ $user->count(); }}<span class="badge bg-subtle-danger text-danger font-size-10 ms-1"><i class="mdi mdi-arrow-down"></i> {{ $user->count(); }}%</sup></h4>
                                        </div>
                                        <div class="text-primary">
                                            <div id="chart-mini2" class="apex-chart"></div>
                                        </div>
                                    </div>
                                    <p class="mb-0 font-size-14 fw-bold mt-2 text-truncate"><span class="text-muted fw-normal"> ~ Tous les personnels</span></p>
                                </div>
                            </div>
                        </div>




                    </div>
                    <!-- end row -->








                </div>


            </div>
            <!-- end row -->
            <br><br><br><br>


        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->




    @endsection