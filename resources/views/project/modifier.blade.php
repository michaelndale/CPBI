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

                    <div class="row">
                        <div class="col-xl-9" style="margin:auto">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0"> <i class="fa fa-info-circle"></i> Modification Information
                                        du projet </h5>
                                </div>
                                <div class="card-body">
                                    <div class="col-12 col-xl-12 col-xxl-12 pe-xl-0">
                                        <div class="mb-12 mb-xl-12">
                                            <div class="row gx-0 gx-sm-12">
                                                <div class="col-12">

                                                    <div class="row gx-0 gx-sm-12 gy-12 mb-12">
                                                        <label><b><i class="fa fa-info-circle"></i> Dénomination du projet:
                                                            </b></label>
                                                        <input name="pid" type="hidden"
                                                            value="{{ Session::get('id') }}" />
                                                        <input name="ptitre" class="form-control form-control-sm"
                                                            value="{{ $dataProject->title }}" />
                                                    </div>

                                                    <div class="row gx-0 gx-sm-12 gy-12 mb-12">
                                                      <label><b><i class="fa fa-info-circle"></i> Description:
                                                          </b></label>
                                                          <textarea name="description" class="form-control form-control-sm" >{{ $dataProject->description }} </textarea>
                                                  </div>
                                                    <br>
                                                    <div class="row gx-0 gx-sm-6 gy-8 mb-8">
                                                        <div class="col-12 col-xl-6 col-xxl-6 pe-xl-0">
                                                            <div class="mb-6 mb-xl-7">
                                                                <div class="row gx-0 gx-sm-7">
                                                                    <div class="col-12 col-sm-auto">
                                                                        <table class="lh-sm">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td class="align-top py-1">
                                                                                        <div class="d-flex">
                                                                                            <h5
                                                                                                class="text-900 mb-0 text-nowrap">
                                                                                                <i
                                                                                                    class="fa fa-user-circle"></i>
                                                                                                Responsable :
                                                                                            </h5>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="ps-1 py-1"><a
                                                                                            class="fw-semi-bold d-block lh-sm"
                                                                                            href="#!">

                                                                                            <select name="resid"
                                                                                                class="form-control form-control-sm">
                                                                                                <option
                                                                                                    value="{{ ucfirst($responsables->id) }}">
                                                                                                    {{ ucfirst($responsables->nom) }}
                                                                                                    {{ ucfirst($responsables->prenom) }}
                                                                                                </option>
                                                                                                @foreach ($alluser as $allusers)
                                                                                                    <option
                                                                                                        value="{{ $allusers->id }}">
                                                                                                        {{ ucfirst($allusers->nom) }}
                                                                                                        {{ ucfirst($allusers->prenom) }}
                                                                                                    </option>
                                                                                                @endforeach

                                                                                            </select>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="align-top py-1">
                                                                                        <div class="d-flex">
                                                                                            <h5
                                                                                                class="text-900 mb-0 text-nowrap">
                                                                                                <span
                                                                                                    class="fas fa-money-check-alt"></span>
                                                                                                Budget :
                                                                                            </h5>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="fw-bold ps-1 py-1 text-1000">
                                                                                        <input type="number" name="montant"
                                                                                            value="{{ $dataProject->budget }}"
                                                                                            class="form-control form-control-sm">
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td class="align-top py-1">
                                                                                        <div class="d-flex">
                                                                                            <h5
                                                                                                class="text-900 mb-0 text-nowrap">
                                                                                                <span
                                                                                                    class="fas fa-money-check-alt"></span>
                                                                                                Devise :
                                                                                            </h5>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="fw-bold ps-1 py-1 text-1000">
                                                                                        <input name="devise"
                                                                                            value="{{ $dataProject->devise }}"
                                                                                            class="form-control form-control-sm">
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td class="fw-bold ps-1 py-1 text-1000">
                                                                                        Numéro projet : </td>
                                                                                    <td class="fw-bold ps-1 py-1 text-1000">
                                                                                        <input name="numero"
                                                                                            value="{{ $dataProject->numeroprojet }}"
                                                                                            class="form-control form-control-sm">
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td
                                                                                        class="align-top py-1 text-900 text-nowrap fw-bold">
                                                                                        Début du
                                                                                        projet : </td>
                                                                                    <td class="fw-bold ps-1 py-1 text-1000">
                                                                                        <input type="date"
                                                                                            name="datedebut"
                                                                                            value="{{ $dataProject->start_date }}"
                                                                                            class="form-control form-control-sm">
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td
                                                                                        class="align-top py-1 text-900 text-nowrap fw-bold">
                                                                                        Fin du
                                                                                        projet :</td>
                                                                                    <td class="fw-bold ps-1 py-1 text-1000">
                                                                                        <input type="date" name="datefin"
                                                                                            value="{{ $dataProject->deadline }}"
                                                                                            class="form-control form-control-sm">
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td
                                                                                        class="align-top py-1 text-900 text-nowrap fw-bold">
                                                                                        Région :
                                                                                    </td>
                                                                                    <td class="fw-bold ps-1 py-1 text-1000">
                                                                                        <input name="region"
                                                                                            value="{{ $dataProject->region }}"
                                                                                            class="form-control form-control-sm">
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td
                                                                                        class="align-top py-1 text-900 text-nowrap fw-bold">
                                                                                        Lieu:
                                                                                    </td>
                                                                                    <td class="fw-bold ps-1 py-1 text-1000">
                                                                                        <input name="lieu"
                                                                                            value="{{ $dataProject->lieuprojet }}"
                                                                                            class="form-control form-control-sm">
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td
                                                                                        class="align-top py-1 text-900 text-nowrap fw-bold">
                                                                                        Période
                                                                                        <small>(T1,T2,T3,Tn...)</small>
                                                                                    </td>
                                                                                    <td class="fw-bold ps-1 py-1 text-1000">
                                                                                        <input name="periode" type="number"
                                                                                            placeholder="Periode"
                                                                                            value="{{ $dataProject->periode }}"
                                                                                            class="form-control form-control-sm"
                                                                                            required />
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td
                                                                                        class="align-top py-1 text-900 text-nowrap fw-bold">
                                                                                        Autorisation de modification</td>
                                                                                    <td class="fw-bold ps-1 py-1 text-1000">
                                                                                        <select name="autorisation"
                                                                                            type="text" required
                                                                                            class="form-control form-control-sm">
                                                                                            <option
                                                                                                value="{{ $dataProject->autorisation }}">
                                                                                                @if ($dataProject->autorisation == 0)
                                                                                                    Fermer
                                                                                                @else
                                                                                                    Ouvert
                                                                                                @endif
                                                                                            </option>
                                                                                            <option value="0">Fermer
                                                                                            </option>
                                                                                            <option value="1">Ouvert
                                                                                            </option>

                                                                                        </select>
                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td
                                                                                        class="align-top py-1 text-900 text-nowrap fw-bold">
                                                                                        Statut
                                                                                        du projet</td>
                                                                                    <td
                                                                                        class="fw-bold ps-1 py-1 text-1000">
                                                                                        <select name="statut"
                                                                                            type="text" required
                                                                                            class="form-control form-control-sm">
                                                                                            <option
                                                                                                value="{{ $dataProject->statut }}">
                                                                                                {{ $dataProject->statut }}
                                                                                            </option>
                                                                                            <option value="En attente">En
                                                                                                attente</option>
                                                                                            <option value="Activé">Activé
                                                                                            </option>
                                                                                            <option value="Bloqué">Bloqué
                                                                                            </option>
                                                                                        </select>
                                                                                    </td>
                                                                                </tr>
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                       

                                                     

                                                        <div class="col-12 col-xl-2 col-xxl-12">

                                                          <br><br>
                                                            <button type="submit" class="btn btn-lg btn-primary"
                                                                name="save" value="Enregistrer"> <i
                                                                    class="fas fa-cloud-download-alt"></i> Enregistrer
                                                            </button>
                                                        </div>
                                                        <br><br><br>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div> </div> </div>
    </form>
@endsection
