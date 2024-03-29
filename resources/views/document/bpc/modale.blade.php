
<a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#scrollingLong2" ><span class="me-2" data-feather="plus-circle"></span>Nouvel Bon de petite caisse </a></nav>


<div class="modal fade" id="scrollingLong2" tabindex="-1" aria-labelledby="scrollingLongModalLabel2" style="display: none;" aria-hidden="true" data-keyboard="false" data-backdrop="static">
<div class="modal-dialog modal-xl modal-dialog-scrollable">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="scrollingLongModalLabel2">Fiche Bon de petite caisse (BPC) </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><svg class="svg-inline--fa fa-xmark fs--1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg><!-- <span class="fas fa-times fs--1"></span> Font Awesome fontawesome.com --></button>
    </div>
    <div class="modal-body">
     
    <form class="row g-3 mb-6" method="POST" id="addProjectForm">

@method('post')
@csrf
           
<div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;name&quot;,&quot;email&quot;,&quot;age&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
                    <div class="table-responsive">
                           <table class="table table-striped table-sm fs--1 mb-0">

<tbody class="list">

    
 
    <tr>
        <td class="align-middle ps-3 name" style="width:40%">
        Je soussigné (nom complet)
        <br>
        <small>  I undersigned (full name)</small>
    </td>
        <td class="align-middle email" colspan="6">
            <input type="text" class="form-control" name="titre" id="titre" style="width: 100%" />
        </td>
    </tr>

    <tr>
        <td class="align-middle ps-3 name">Titre (+ nom de l’organisation si différente de la CEPBU):
            <br>
        <small> (Title + organization if different from CEPBU)</small>
        </td>
        <td class="align-middle email" colspan="6">
            <input type="text" class="form-control" name="titre" id="titre" style="width: 100%" />
        </td>
    </tr>

    <tr>
        <td class="align-middle ps-3 name">Type de carte d’identité d’identité
            <br>
        <small>(Type of Identity card)</small>
        </td>
        <td class="align-middle email" colspan="2">
            <input type="text" class="form-control" name="titre" id="titre" style="width: 100%" />
        </td>

        <td class="align-middle ps-3 name"> Numéro de la pièce
            <br>
        <small>(Number of ID)</small>
        </td>

        <td class="align-middle email" colspan="2">
            <input type="text" class="form-control" name="titre" id="titre" style="width: 100%" />
        </td>
    </tr>
  
    <tr>
    <td class="align-middle ps-3 name" >Addresse:</td>
        <td class="align-middle email" colspan="2">
            <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
        </td>

        <td class="align-middle ps-3 name">Téléphone/Email:</td>
        <td class="align-middle email" colspan="2">
            <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
        </td>
    </tr>

    <tr>
        <td class="align-middle ps-3 name" style="width:40%">
        Reconnais avoir reçu de  CEPBU un montant de 
        <br>
        <small> (Recognize having received from CEPBU the amount of)</small>
    </td>
        <td class="align-middle email" colspan="6">
            <input type="text" class="form-control" name="titre" id="titre" style="width: 100%" />
        </td>
    </tr>


    <tr>
        <td class="align-middle ps-3 name" style="width:40%">
        Motif
        <br>
        <small> (Objective)</small>
    </td>
        <td class="align-middle email" colspan="6">
            <input type="text" class="form-control" name="titre" id="titre" style="width: 100%" />
        </td>
    </tr>

    <tr>
    <td class="align-middle ps-3 name" >Fait à:
        <br> (Done in)	
    </td>
        <td class="align-middle email" colspan="2">
            <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
        </td>

        <td class="align-middle ps-3 name">le (jour, mois, année) <br>  on (day, month, year)</td>
        <td class="align-middle email" colspan="2">
            <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
        </td>
    </tr>

    </tbody>
</table>
<br>

<table class="table table-striped table-sm fs--1 mb-0">
<tbody>
    <tr>
    <td class="align-middle ps-3 name" >Nom et signature du Bénéficiaire du Distributeur
        <br> <small>(Receiver name and signature)	</small> <br>
    
            <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
        </td>

        <td class="align-middle ps-3 name"> Nom et signature <br> 
        <small> (Distributor name and signature)</small>
            
        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
        </td>
    </tr>
</tbody>
</table>




                       
                    </div>
                </div>
            </form>
    
  </div>
    <div class="modal-footer"><button class="btn btn-primary" type="button" style="background-color:#228B22; color:white">Sauvegarder</button>
   </div>
  </div>
</div>
</div>
