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
    <td><h4 class="mb-4"><i class="fa fa-folder-open "></i> FICHE D’EXPRESSION DES BESOINS</h4></td>
   
    <td align="right">Numéro fiche : <input type="text" style="width:50%;" class="form-control"></td>
    </tr>
</table>
           
                <div id="tableExample2" data-list="{&quot;valueNames&quot;:[&quot;name&quot;,&quot;email&quot;,&quot;age&quot;],&quot;page&quot;:5,&quot;pagination&quot;:{&quot;innerWindow&quot;:2,&quot;left&quot;:1,&quot;right&quot;:1}}">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm fs--1 mb-0">

                            <tbody class="list">

                                
                             
                                <tr>
                                    <td class="align-middle ps-3 name" style="width:20%">Composante/ Projet/Section</td>
                                    <td class="align-middle email" colspan="6">
                                        <textarea type="text" class="form-control" name="titre" id="titre" style="width: 100%"></textarea>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name">Activité</td>
                                    <td class="align-middle email" colspan="6">
                                        <textarea type="text" class="form-control" name="titre" id="titre" style="width: 100%"></textarea>
                                    </td>
                                </tr>
                              
                                <tr>
                                <td class="align-middle ps-3 name">Période:</td>
                                    <td class="align-middle email">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
                                    </td>

                                    <td class="align-middle ps-3 name">Date:</td>
                                    <td class="align-middle email">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="align-middle ps-3 name">Ligne budgétaire:    </td>
                                    <td class="align-middle email" colspan="3">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
                                    </td>
                                    <td class="align-middle ps-3 name" style="width:20%"> Taux d’exécution: %</td>
                                    <td class="align-middle email">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
                                    </td>
                                </tr>

                                <tr>
                                <td class="align-middle ps-3 name">BC:</td>
                                    <td class="align-middle email">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
                                    </td>

                                    <td class="align-middle ps-3 name">Facture:</td>
                                    <td class="align-middle email">
                                        <input type="text" class="form-control" name="titre" id="titre" style="width: 100%">
                                    </td>

                                      <td class="align-middle ps-3 name">O.M:</td>
                                    <td class="align-middle email">
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