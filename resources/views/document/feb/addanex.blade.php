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

            @if ($dataFeb->bc==1 || $dataFeb->facture==1 || $dataFeb->om==1 || $dataFeb->nec==1 || $dataFeb->fpdevis==1 || $dataFeb->rm==1 || $dataFeb->tdr==1 || $dataFeb->bv==1 || $dataFeb->recu==1 || $dataFeb->ar==1 || $dataFeb->be==1 || $dataFeb->apc==1 )

            <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                        <i class="mdi mdi-alert-circle-outline me-2"></i>
                        
                        Pour continuer le processus d'ajout du document en annexe. <BR>Assurez-vous d'avoir le  document à votre disposition.
                        <BR><BR>Vous pouvez le prendre en photo ou le scanner et l'envoyer en format (IMAGE, PDF, WORD, EXCEL, POWERPOINT).

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

            <div class="row">
                <div class="col-xl-12">

                    <div class="card">

                        <form id="annexeForm" autocomplete="off" method="POST" action="{{ route('updat_annex', $dataFeb->id )}}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">

                                <input type="hidden" id="projetid" name="projetid" value="{{ Session::get('id') }}" />
                                <input type="hidden" id="febid" name="febid" value="{{ $dataFeb->id  }}" />

                                @if ($dataFeb->bc==1)
                                <div class="col-sm-12 col-md-12">
                                    <label class="text-1000 fw-bold mb-2">Bon de commande (BC)</label>

                                    <input class="form-control" name="boncommande" id="boncommande" type="file" />
                                </div>
                                @endif

                                @if ($dataFeb->facture==1)
                                <div class="col-sm-12 col-md-12">
                                    <label class="text-1000 fw-bold mb-2">Facture</label>
                                    <input class="form-control" name="facture" id="facture" type="file" />
                                </div>
                                @endif

                                @if ($dataFeb->om==1)
                                <div class="col-sm-12 col-md-12">
                                    <label class="text-1000 fw-bold mb-2">Ordre de Mission</label>
                                    <input class="form-control" name="ordreM" id="ordreM" type="file" />
                                </div>
                                @endif

                                @if ($dataFeb->nec==1)
                                <div class="col-sm-12 col-md-12">
                                    <label class="text-1000 fw-bold mb-2">P.V.A</label>
                                    <input class="form-control" name="url_pva" id="url_pva" type="file" />
                                </div>
                                @endif

                                @if ($dataFeb->fpdevis==1)
                                <div class="col-sm-12 col-md-12">
                                    <label class="text-1000 fw-bold mb-2">Facture proformat/Devis/Liste</label>
                                    <input class="form-control" name="factureP" id="factureP" type="file" />
                                </div>
                                @endif

                                @if ($dataFeb->rm==1)
                                <div class="col-sm-12 col-md-12">
                                    <label class="text-1000 fw-bold mb-2">Rapport de Mission</label>
                                    <input class="form-control" name="rapportM" id="rapportM" type="file" />
                                </div>
                                @endif

                                @if ($dataFeb->tdr==1)
                                <div class="col-sm-12 col-md-12">
                                    <label class="text-1000 fw-bold mb-2">Terme de reference</label>
                                    <input class="form-control" name="termeR" id="termeR" type="file" />
                                </div>
                                @endif

                                @if ($dataFeb->bv==1)
                                <div class="col-sm-12 col-md-12">
                                    <label class="text-1000 fw-bold mb-2">Bordereau de versement</label>
                                    <input class="form-control" name="bordereauV" id="bordereauV" type="file" />
                                </div>
                                @endif

                                @if ($dataFeb->recu==1)
                                <div class="col-sm-12 col-md-12">
                                    <label class="text-1000 fw-bold mb-2">Reçu</label>
                                    <input class="form-control" name="recu" id="recu" type="file" />
                                </div>
                                @endif

                                @if ($dataFeb->ar==1)
                                <div class="col-sm-12 col-md-12">
                                    <label class="text-1000 fw-bold mb-2">Accuse reception</label>
                                    <input class="form-control" name="auccuseR" id="auccuseR" type="file" />
                                </div>
                                @endif


                                @if ($dataFeb->be==1)
                                <div class="col-sm-12 col-md-12">
                                    <label class="text-1000 fw-bold mb-2">Bordereau d'expediction</label>
                                    <input class="form-control" name="bordereauE" id="bordereauE" type="file" />
                                </div>
                                @endif

                                @if ($dataFeb->apc==1)
                                <div class="col-sm-12 col-md-12">
                                    <label class="text-1000 fw-bold mb-2">Appel a la participation a la construction au CFK</label>
                                    <input class="form-control" name="appelP" id="appelP" type="file" />
                                </div>
                            </div>
                            @endif
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-cloud-upload-alt"></i> Sauvegarder</button>

                    </div>
                    </form>
                    @else

                    <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                        <i class="mdi mdi-alert-circle-outline me-2"></i>
                        Aucun document n'a été précisé comme étant joint à cette FEB lors de sa création. <br>
                        Sinon, veuillez <a href="{{ route('showfeb', $cryptedId ) }}"><i class="fa fa-edit"></i> modifier la FEB </a>
                        pour continuer le processus d'ajout du document en annexe. <BR>Assurez-vous de cocher la case correspondant au document que vous avez à votre disposition.
                        <BR><BR>Vous pouvez le prendre en photo ou le scanner et l'envoyer en format (IMAGE, PDF, WORD, EXCEL, POWERPOINT).

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    @endif




                    <br>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>

    @endsection