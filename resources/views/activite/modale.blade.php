<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

	
<style>
  input , select
{
  height: 35px;
  
}
</style>
<a href="javascript::;" type="button" data-bs-toggle="modal" data-bs-target="#addModale" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"> <i class="fa fa-plus-circle"></i> Nouvelle activite</a>

<div class="modal fade" id="addModale" tabindex="-1" aria-labelledby="addModale" style="display: none;" aria-hidden="true">
<div class="modal-dialog modal-xl modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="addModale">Nouvelle activité </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg><!-- <span class="fas fa-times fs--1"></span> Font Awesome fontawesome.com --></button>
    </div>
    <div class="modal-body">
    <form class="row g-3 mb-6" method="POST" id="addForm">
    @method('post')
    @csrf

    <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;name&quot;,&quot;email&quot;,&quot;age&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
        <div class="table-responsive">                  
            <table class="table table-striped table-sm fs--1 mb-0">
            <tbody class="list">

            <tr>
               <td class="align-middle ps-1 name"> Source projet</td>
               <td class="align-middle email" colspan="4">
                   <input value="{{ Session::get('id') }} " type="hidden" name="projetid" id="projetid" >
                   <input value="{{ Session::get('title') }} " class="form-control" disabled  >      
               </td>
           </tr>
            <tr>
                <td class="align-middle ps-3 name" style="width:10%">Titre</td>
                <td class="align-middle email" colspan="6">
                    <input type="text" class="form-control" name="titre" id="titre" style="width: 100%" />
                </td>
            </tr>
           
            
            <tr>
                <td class="align-middle ps-3 name">Pays </td>
                <td class="align-middle email" colspan="2">
                    <input type="text" class="form-control" name="pays" id="pays style="width: 100%" />
                </td>

                <td class="align-middle ps-3 name" style="width:10%">Montant </td>

                <td class="align-middle email" colspan="2">
                    <input type="text" class="form-control" name="montant" id="montant" style="width: 100%" />
                </td>
            </tr>

            <tr>
                <td class="align-middle ps-3 name" style="width:10%">Categorie</td>
                <td class="align-middle email" colspan="6">
                <select type="text" class="form-control" name="categorieid" id="categorieid" style="width: 100%" >
                            <option> -- Selection categorie -- </option>
                        @forelse ($dataCategorie as $dataCategorie)
                            <option value="{{ $dataCategorie->id }}"> {{ $dataCategorie->libelle }} </option> 
                        @empty
                        <option> -- Aucu categorie trouver -- </option>
                        @endforelse
                    </select>
                </td>
            </tr>

        </tbody>
        </table>
        </div>
    </div>
  </div>
  <div class="modal-footer">
        <button  type="submit" class="btn btn-primary addbtn" id="addbtn" >Enregistrer</button>
   </div>
</div>
</form>
</div>
</div>
