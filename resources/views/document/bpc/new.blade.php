@extends('layout/app')
@section('page-content')

<div class="content">

    <div class="row">
        <div class="col-xl-10" style="margin:auto">
        <form class="row g-3 mb-6" method="POST" id="addProjectForm">

@method('post')
@csrf
<table>
    <tr>
    <td><h4 class="mb-4"><i class="fa fa-folder-open "></i> BON DE PETITE CAISSE </h4></td>
   
    <td align="right">Numéro fiche : <input type="text" style="width:50%;" class="form-control"></td>
    </tr>
</table>
           
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

                    </div>

                </div>

                <div class="col-12 gy-6">
                    <div class="row g-3 justify-content-end">
                        <div class="col-auto"><button type="reset" class="btn btn-danger px-5">Cancel</button></div>
                        <div class="col-auto"><button name="addProjectbtn" id="addProjectbtn" class="btn btn-primary px-5 px-sm-15">Create Project</button></div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
        $(function() {
            // Add PROJECT ajax 
            $("#addProjectForm").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#addProjectbtn").text('Adding...');
                $.ajax({
                    url: "{{ route('storeProject') }}",
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            $.notify("You have Successfully add a project !", "success");
                        }
                        $("#addProjectbtn").text('Add Project');
                        $("#addProjectForm")[0].reset();
                    }
                });
            });


        });
    </script>

    @endsection