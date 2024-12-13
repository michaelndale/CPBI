@extends('layout/app')
@section('page-content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      
      <!-- end page title -->

      <div class="row" >
        
        <div class="col-xl-12" >
          <div class="card">

            @php
            $IDPJ= Session::get('id');
            $cryptedId = Crypt::encrypt($IDPJ);
            @endphp
           
          

            <div class="card-header page-title-box d-sm-flex align-items-center justify-content-between"
            style="padding: 0.10rem 1rem;">

            <h4 class="mb-sm-0"><i class="mdi mdi-book-open-page-variant"></i> Liste des Révisions Budgétaires 
            </h4>

            <div class="page-title-right d-flex align-items-center justify-content-between gap-2" style="margin: 0;">
               
                <!-- Bouton Actualiser -->
                <a href="javascript:void(0)" id="fetchDataLink" class="btn btn-outline-primary rounded-pill btn-sm"
                    title="Actualiser">
                    <i class="fas fa-sync-alt"></i>
                </a>
                <!-- Bouton Créer -->
                <a href="{{ route('key.viewProject', $cryptedId ) }}" class="btn btn-outline-primary rounded-pill btn-sm">
                    <span class="fa fa-arrow-left"></span> Retour
                </a>
            </div>
        </div>


            <div class="card-body">
              <div class="col-12 col-xl-12 col-xxl-12 pe-xl-0">
                <div class="mb-12 mb-xl-12">
                  <div class="row gx-0 gx-sm-12">
                    <div class="col-12">
                        <table class="table table-bordered table-striped table-sm fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th class="font-weight-bold">#</th>
                                    <th class="font-weight-bold">Description</th>
                                    <th class="font-weight-bold">Ancien Montant</th>
                                    <th class="font-weight-bold">Nouveau Montant</th>
                                    <th class="font-weight-bold">Créé par</th>
                                    <th class="font-weight-bold">Créé le</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($revisions as $revision)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $revision->description }}</td>
                                        <td>{{ $revision->ancien_montant }}</td>
                                        <td>{{ $revision->nouveau_montant }}</td>
                                     
                                        <td>{{ $revision->nom }} {{ $revision->prenom }}</td> <!-- Assurez-vous que l'utilisateur a un attribut `name` -->
                                        <td>{{ \Carbon\Carbon::parse($revision->created_at)->format('d-m-y') }}
                                        </td>
                                       
                                        <!-- <td>
                                           
                                            <a href="#" class="btn btn-info btn-sm">Voir</a>
                                            <a href="#" class="btn btn-danger btn-sm">Supprimer</a>
                                        </td>  -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
         
        </div>
       
       
        </div>

       


      </div>

    </div> <!-- container-fluid -->
  </div>
  <!-- End Page-content -->

  <!--  Extra Large modal example -->

</div>

<style>
  .swal-custom-content .swal-text {
    font-size: 14px;
    /* Ajustez la taille selon vos besoins */
  }

  th {
        font-weight: bold;
    }
</style>



@endsection