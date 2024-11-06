@extends('layout/app')
@section('page-content')
@php
     $cryptedId = Crypt::encrypt($dataFeb->id);
@endphp

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" style="margin:auto">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"><i class="fa fa-folder-plus"></i> Annex de la FEB (N° {{ $dataFeb->numerofeb }} ) </h4>
                        <div class="page-title-right">

                            <div class="btn-toolbar float-end" role="toolbar">
                                <div class="btn-group me-2 mb-2 mb-sm-0">
                                    <a href="{{ route('generate-pdf-feb', $dataFeb->id) }}" class="btn btn-primary waves-light waves-effect"><i class="fa fa-print"></i> </a>
                                    <a href="{{ route('showfeb', $cryptedId ) }}" class="btn btn-primary waves-light waves-effect"><i class="fa fa-edit"></i> </a>
                                    <a href="{{ route('listfeb') }}" class="btn btn-primary waves-light waves-effect"><i class="fa fa-list"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

      

            <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                        <i class="mdi mdi-alert-circle-outline me-2"></i>
                        
                        Pour continuer le processus d'ajout du document en annexe. <BR>Assurez-vous d'avoir le  document à votre disposition.
                        <BR>Vous pouvez le prendre en photo ou le scanner et l'envoyer en format (IMAGE, PDF, WORD, EXCEL, POWERPOINT).

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <br>

            <div class="row">
                <div class="col-xl-12">

                    <div class="card">

                        <form id="annexeForm" autocomplete="off" method="POST" action="{{ route('updat_annex', $dataFeb->id) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                @foreach ($getDocument as $getDocuments)
                                
                                <div class="col-sm-12 col-md-12">
                                    <!-- Use array names for annex ID and document URL to manage multiple inputs -->
                                    <input type="hidden" name="annexid[]" value="{{ $getDocuments->id }}" />
                                    <input type="hidden" name="ancientdoc[]" value="{{ $getDocuments->urldoc }}" />
                                    <label class="text-1000 fw-bold mb-2">{{ $getDocuments->libelle }} ({{ $getDocuments->abreviation }})</label>
                                    <!-- Array name for doc input to handle multiple files -->
                                    <input class="form-control" name="doc[]" type="file" />
                                </div>
                                
                                @endforeach
                            </div>
                        
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>
                            </div>
                        </form>
                        
                

                   <!-- <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                        <i class="mdi mdi-alert-circle-outline me-2"></i>
                        Aucun document n'a été précisé comme étant joint à cette FEB lors de sa création. <br>
                        Sinon, veuillez <a href="{{ route('showfeb', $cryptedId ) }}"><i class="fa fa-edit"></i> modifier la FEB </a>
                        pour continuer le processus d'ajout du document en annexe. <BR>Assurez-vous de cocher la case correspondant au document que vous avez à votre disposition.
                        <BR><BR>Vous pouvez le prendre en photo ou le scanner et l'envoyer en format (IMAGE, PDF, WORD, EXCEL, POWERPOINT).

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                  
                -->



                    <br>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>

    @endsection