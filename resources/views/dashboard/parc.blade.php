@extends('layout/app')
@section('page-content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Tableau Parc Automobile <BR> COMMUNAUTÉ DES EGLISES DE PENTECÔTE AU BURUNDI “CEPBU” </h4>
                        <div class="page-title-right">
                            <e class="form-control ps-6 "> @include('dashboard.time')</e>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

        

                    <div class="row">
                            <div class="col-lg-4">
                            <a href="{{ route('vehicule') }}">
                                <div class="card bg-primary text-white-50">
                                    <div class="card-body">
                                        <center>
                                        <font size="20px"> <i class="fa fa-car"></i></font>
                                        <h5 class="mb-4 text-white"> GESTION DES VÉHICULES</h5>

                                        </center>
                                      
                                    </div>
                                </div>
                            </a>
                            </div>

                           
                            <div class="col-lg-4">
                                <a href="{{ route('carburents') }}">
                                    <div class="card bg-warning text-white-50">
                                        <div class="card-body">
                                        <center>
                                            <font size="20px"> <i class="fa fa-gas-pump"></i></font>
                                            <h5 class="mb-4 text-white"> CARBURENTS</h5>

                                            </center>
                                        </div>
                                    </div>
                                </a>
                            </div>
        
        
                            <div class="col-lg-4">
                                <a href="{{ route('entretient') }}">
                                <div class="card bg-success text-white-50">
                                    <div class="card-body">
                                    <center>
                                        <font size="20px"> <i class="fas fa-car-crash"></i></font>
                                        <h5 class="mb-4 text-white"> ENTRETIENS </h5>

                                        </center>
                                    </div>
                                </div>
                                </a>
                            </div>

                            </div>
                            <div class="row">
        
                            <div class="col-lg-4">
                            <a href="{{ route('entretient') }}">
                                <div class="card bg-info text-white-50">
                                    <div class="card-body">
                                    <center>
                                        <font size="20px"> <i class="fa fa-wrench"></i></font>
                                        <h5 class="mb-4 text-white"> REPARATIONS </h5>

                                        </center>
                                    </div>
                                </div>
                            </a>
                            </div>
                
                        <!-- end row -->

                     
                            <div class="col-lg-4">
                                <div class="card bg-danger text-white-50">
                                    <div class="card-body">
                                    <center>
                                        <font size="20px"> <i class="fas fa-clipboard-list"></i></font>
                                        <h5 class="mb-4 text-white"> EDITIONS </h5>

                                        </center>
                                    </div>
                                </div>
                            </div>
        
                            <div class="col-lg-4">
                                <a href="{{ route('outilspa') }}"> 
                                <div class="card bg-dark text-light">
                                    <div class="card-body">
                                    <center>
                                        <font size="20px"> <i class="fa fa-cog"></i></font>
                                        <h5 class="mb-4 text-white">PARAMÉTRAGES DES OUTILS</h5>

                                        </center>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                        <!-- end row -->
      


                 
                </div>

<br><br>

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->



    @endsection