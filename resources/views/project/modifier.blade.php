@extends('layout/app')
@section('page-content')

@foreach ($responsable as $responsables)
@endforeach

<form action="{{ route('updatprojet', $dataProject->id) }}" method="POST">
  @method('PUT')
  @csrf
  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <div class="row g-0">
          <div class="col-12 col-xxl-8 px-0 bg-soft">
            <div class="px-4 px-lg-6 pt-6 pb-9">
              <div class="mb-5">
                <div class="d-flex justify-content-between">
                  <h2> <i class="fa fa-edit"></i> Modification du projet</h2>
                </div>
                <b><i class="fa fa-info-circle"></i> Statut du projet :</b> <span class="badge rounded-pill bg-success"> {{ $dataProject->statut }} </span> <br>
                <b><i class="fa fa-edit"></i> Autorisation de modification :</b>
                @if($dataProject->autorisation==1)
                <span class="badge rounded-pill bg-primary"> Projet Ouvert </span>
                @else
                <span class="badge rounded-pill bg-danger"> Fermer </span>
                @endif



              </div>
              <div class="row gx-0 gx-sm-12 gy-12 mb-12">
                <label><b><i class="fa fa-info-circle"></i> Dénomination du projet: </b></label>
                <input name="pid" type="hidden" value="{{ Session::get('id') }}" />
                <input name="ptitre" class="form-control form-control-sm" value="{{ $dataProject->title }}" />
              </div>
              <br>
              <div class="row gx-0 gx-sm-5 gy-8 mb-8">
                <div class="col-12 col-xl-6 col-xxl-4 pe-xl-0">
                  <div class="mb-4 mb-xl-7">
                    <div class="row gx-0 gx-sm-7">
                      <div class="col-12 col-sm-auto">
                        <table class="lh-sm">
                          <tbody>
                            <tr>
                              <td class="align-top py-1">
                                <div class="d-flex">
                                  <h5 class="text-900 mb-0 text-nowrap"><i class="fa fa-user-circle"></i> Responsable :</h5>
                                </div>
                              </td>
                              <td class="ps-1 py-1"><a class="fw-semi-bold d-block lh-sm" href="#!">
                                  <input type="hidden" value="{{ ucfirst($responsables->id) }}" name="resid">
                                  <input value="{{ ucfirst($responsables->nom) }} {{ ucfirst($responsables->prenom) }}" class="form-control form-control-sm"> </a></td>
                            </tr>
                            <tr>
                              <td class="align-top py-1">
                                <div class="d-flex">
                                  <h5 class="text-900 mb-0 text-nowrap"> <span class="fas fa-money-check-alt"></span> Budget : </h5>
                                </div>
                              </td>
                              <td class="fw-bold ps-1 py-1 text-1000">
                                <input name="montant" value="{{ $dataProject->budget}}" class="form-control form-control-sm">
                              </td>
                            </tr>

                            <tr>
                              <td class="align-top py-1">
                                <div class="d-flex">
                                  <h5 class="text-900 mb-0 text-nowrap"> <span class="fas fa-money-check-alt"></span> Devise : </h5>
                                </div>
                              </td>
                              <td class="fw-bold ps-1 py-1 text-1000">
                                <input name="devise" value="{{ $dataProject->devise }}" class="form-control form-control-sm">
                              </td>
                            </tr>
                         
                            <tr>
                              <td class="fw-bold ps-1 py-1 text-1000">Numéro projet : </td>
                              <td class="fw-bold ps-1 py-1 text-1000">
                                <input name="numero" value="{{ $dataProject->numeroprojet }}" class="form-control form-control-sm">
                              </td>
                            </tr>

                            <tr>
                              <td class="align-top py-1 text-900 text-nowrap fw-bold">Début du projet : </td>
                              <td class="fw-bold ps-1 py-1 text-1000">
                                <input type="date" name="datedebut" value="{{ $dataProject->start_date }}" class="form-control form-control-sm">
                              </td>
                            </tr>
                            <tr>
                              <td class="align-top py-1 text-900 text-nowrap fw-bold">Fin du projet :</td>
                              <td class="fw-bold ps-1 py-1 text-1000">
                                <input type="date" name="datefin" value="{{ $dataProject->deadline }}" class="form-control form-control-sm">
                              </td>
                            </tr>
                            <tr>
                              <td class="align-top py-1 text-900 text-nowrap fw-bold">Date de creation projet :</td>
                              <td class="fw-bold ps-1 py-1 text-1000">
                                <input type="date" name="datecreation" value="{{  date_format($dataProject->created_at, 'Y-m-d')  }}" class="form-control form-control-sm">
                              </td>
                            </tr>

                            <tr>
                              <td class="align-top py-1 text-900 text-nowrap fw-bold">Région : </td>
                              <td class="fw-bold ps-1 py-1 text-1000">
                                <input name="region" value="{{ $dataProject->region }}" class="form-control form-control-sm">
                              </td>
                            </tr>
                            <tr>
                              <td class="align-top py-1 text-900 text-nowrap fw-bold">Lieu:</td>
                              <td class="fw-bold ps-1 py-1 text-1000">
                                <input name="lieu" value="{{ $dataProject->lieuprojet }}" class="form-control form-control-sm">
                              </td>
                            </tr>
                            <tr>
                              <td class="align-top py-1 text-900 text-nowrap fw-bold">Période <small>(T1,T2,T3,Tn...)</small></td>
                              <td class="fw-bold ps-1 py-1 text-1000">
                                <input name="periode"  type="number" placeholder="Periode" value="{{ $dataProject->periode }}" class="form-control form-control-sm" required />
                              </td>
                            </tr>

                            <tr>
                              <td class="align-top py-1 text-900 text-nowrap fw-bold">Autorisation de modification</td>
                              <td class="fw-bold ps-1 py-1 text-1000">
                                <select name="autorisation"  type="text" required class="form-control form-control-sm">
                                  <option value="{{ $dataProject->autorisation }}">
                                    @if ($dataProject->autorisation==0)
                                      Fermer
                                    @else
                                      Ouvert
                                    @endif
                                  </option>
                                  <option value="0">Fermer</option>
                                  <option value="1">Ouvert</option>

                                </select>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-12 col-xl-6 col-xxl-8">
                  <div class="row flex-between-center mb-12 g-12">

                    <h4 class="text-black">Description</h4>
                    <textarea name="description" class="form-control form-control-sm" style="width:100%; height:250px">{{ $dataProject->description }} </textarea>
                  </div>

                </div>

                <div class="col-12 col-xl-6 col-xxl-8">
                  <input type="submit" class="btn btn-primary" name="save" value="Soumetre le modification">
                </div>
                <br><br><br>
              </div>

            </div>
          </div>
  </div>
</form>

@endsection