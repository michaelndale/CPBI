@extends('layout/app')
@section('page-content')

@foreach ($dataJon as $dataJons)
@endforeach

<div class="main-content">
  <div class="content">
    <div class="card-header p-4 border-bottom border-300 bg-soft">
      <div class="row g-3 justify-content-between align-items-end">
        <div class="col-12 col-md">
          <h4 class="text-900 mb-0" data-anchor="data-anchor"><i class="fa fa-edit"></i> Revision  de la ligne budgetaire </h4>
        </div>
        <div class="col col-md-auto">
        <form action="{{ route('rallonge.delete', $dataJons->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button   class="btn btn-danger" type="button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet ligne ?')"> <i class="fa fa-times-circle"></i> Supprimer </button>
        </form>
    
    </div>
      </div>
    </div>
    <div class="card-body">
      <div class="card">

<div class="modal-dialog modal-lg  modal-dialog-centered">
    <div class="modal-content">
    <form action="{{ route('updatligne', $dataJons->id ) }}" method="POST">
            @method('PUT')
            @csrf
     <br><br>
      <div class="modal-body">
      <div class="row g-3">

        <div class="col-sm-6 col-lg-12 col-xl-12">
            <label class="text-1000 fw-bold mb-2">Code </label>
            <input class="form-control" id="souscompteid" name="souscompteid"  type="hidden"    value="{{ $dataJons->souscompte }}" required/>
            <input class="form-control" id="code" name="code"  type="text"  placeholder="Budget"  value="{{ $dataJons->numero }}" required/>
        </div>

        <div class="col-sm-6 col-lg-12 col-xl-12">
          
          <label class="text-1000 fw-bold mb-2">Sous compte</label>
          <input type="hidden"  name="id" id="id" class="id"  value="{{ $dataJons->id }}" />
          <textarea class="form-control"  id="titreligne" name="titreligne" type="text" >{{ $dataJons->libelle }}</textarea>
        </div>

          
        <div class="col-sm-6 col-lg-12 col-xl-12">
            <label class="text-1000 fw-bold mb-2">Budget </label>
            <input id="ancienmontantligne" name="ancienmontantligne"  type="hidden" value="{{ $dataJons->budgetactuel }}" />
            <input class="form-control" id="montantligne" name="montantligne"  type="number"  placeholder="Budget"  value="{{ $dataJons->budgetactuel }}" required/>
        </div>
          
        </div>
      </div>

      <br><br>
      <div class="modal-footer">
       
        <button type="submit" name="editRbtn" id="editRbtn" class="btn btn-primary" type="button"> <i class="fa fa-checked"></i>  Sauvegarder le mis ajours</button>
      </div>


    
      </form>
      <br>  <br>

  </div>
</div>
</div>
<br>  <br>
@endsection