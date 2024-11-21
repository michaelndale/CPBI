@extends('layout/app')
@section('page-content')
@php
    $cryptedId = Crypt::encrypt($dataFeb->id);
@endphp

<div class="main-content">
    <div class="page-content">
        
        <!-- Centrer la carte avec margin auto et div de largeur 5 -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">

                    <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                        <i class="mdi mdi-alert-circle-outline me-2"></i>
                        Pour continuer le processus d'ajout du document en annexe.<br>
                        Assurez-vous d'avoir le document à votre disposition.<br>
                        Vous pouvez le prendre en photo ou le scanner et l'envoyer en format (PDF, WORD, EXCEL, POWERPOINT).
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <br>
                    <!-- Card Container -->
                    <div class="card shadow-none border border-300 mb-3" style="margin: auto">
                        <!-- Card Header -->
                        <div class="card-header p-4 border-bottom border-300 bg-soft">
                            <div class="row g-3 justify-content-between align-items-end">
                                <div class="col-12 col-md">
                                    <h2 class="card-title mb-1">
                                        <i class="mdi mdi-plus-circle"></i> Annex de la FEB (N° {{ $dataFeb->numerofeb }})
                                    </h2>
                                </div>
                                <div class="col col-md-auto">
                                   
                                    <a href=" {{ route('key.viewFeb', $cryptedId ) }}" class="btn btn-primary waves-light waves-effect">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="{{ route('generate-pdf-feb', $dataFeb->id) }}" class="btn btn-primary waves-light waves-effect">
                                        <i class="fa fa-print"></i>
                                    </a>
                                    <a href="{{ route('showfeb', $cryptedId) }}" class="btn btn-primary waves-light waves-effect">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{ route('listfeb') }}" class="btn btn-primary waves-light waves-effect">
                                        <i class="fa fa-list"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body p-0">
                           
                           

                                <!-- Information Alert -->
                             
                                <!-- Document Upload Form -->
                                <form id="annexeForm" method="POST" action="{{ route('updat_annex', $dataFeb->id) }}" enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    @method('PUT')
                                
                                    <!-- Document Fields -->
                                    <div class="row" style="padding: 20px">
                                        @if ($getDocument->isNotEmpty()) 
                                            @foreach ($getDocument as $doc) 
                                                <div class="col-md-12">
                                                    <input type="hidden" name="annexid[]" value="{{ $doc->id }}" />
                                                    <input type="hidden" name="ancientdoc[]" value="{{ $doc->urldoc }}" />
                                                    <label class="text-1000 fw-bold mb-2">
                                                        {{ $doc->libelle }} ({{ $doc->abreviation }}) , 
                                                        @if ($doc->urldoc === NULL)
                                                            <i class="fa fa-times-circle" style="color: red;" title="Aucun document disponible"></i>
                                                            <span style="color: red;">Pas de document disponible</span>
                                                        @else
                                                            <a href="#" onclick="viewDocument('{{ asset($doc->urldoc) }}'); return false;" title="{{ $doc->urldoc }}">
                                                                <i class="fa fa-link"></i> Voir le document 
                                                            </a>
                                                        @endif
                                                    </label>
                                                    <input class="form-control" name="doc[]" type="file" onchange="validateFiles(this)" 
                                                    accept=".pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx" />
                                                    <div class="error-message" style="color: red; display: none;"></div>
                                                    <br>
                                                </div>
                                            @endforeach
                                        @else 
                                            <div class="col-md-12">
                                                <span>Pas de document disponible</span>
                                            </div>
                                        @endif
                                    </div>
                                
                                    <!-- Save Button -->
                                    <div class="card-footer p-4 border-top border-300 bg-soft">
                                        <div class="row g-3 justify-content-end">
                                            <div class="col-md-auto">
                                                <button type="submit" class="btn btn-primary" id="addfebbtn" name="addfebbtn" disabled>
                                                    <i class="fa fa-cloud-upload-alt"></i> Sauvegarder
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                
                                <!-- Modal for Document View -->
                                <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="documentModalLabel">Visualisation du Document</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <iframe id="documentFrame" style="width: 100%; height: 500px;" frameborder="0"></iframe>
                                                <div id="noDocumentMessage" style="color: red; display: none;">Il n'existe pas de document.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>





<script>
    function validateFiles(fileInput) {
        const maxSize = 2 * 1024 * 1024; // 2MB
        const file = fileInput.files[0];
        const errorMessageDiv = fileInput.nextElementSibling;

        // Clear previous error messages
        errorMessageDiv.textContent = '';
        errorMessageDiv.style.display = 'none';

        // Check if file size exceeds limit
        if (file && file.size > maxSize) {
            errorMessageDiv.textContent = 'La taille du fichier ne doit pas dépasser 2 Mo.';
            errorMessageDiv.style.display = 'block';
            document.getElementById('addfebbtn').disabled = true;
        } else {
            // Disable the button if any other files are invalid
            const inputs = document.querySelectorAll('input[type="file"]');
            let allValid = true;

            inputs.forEach(input => {
                if (input.files.length > 0 && input.files[0].size > maxSize) {
                    allValid = false;
                }
            });

            document.getElementById('addfebbtn').disabled = !allValid;
        }
    }

    function viewDocument(url) {
        const documentFrame = document.getElementById('documentFrame');
        const noDocumentMessage = document.getElementById('noDocumentMessage');

        // Clear previous message
        noDocumentMessage.style.display = 'none';

        // AJAX request to check if the document exists
        fetch(url)
            .then(response => {
                if (response.ok) {
                    documentFrame.src = url; // Load the PDF in the iframe
                    $('#documentModal').modal('show'); // Show the modal
                } else {
                    noDocumentMessage.style.display = 'block'; // Show error message
                }
            })
            .catch(error => {
                console.error('Error checking document:', error);
                noDocumentMessage.style.display = 'block'; // Show error message
            });
    }
</script>

<!-- Include Bootstrap JS and CSS (needed for modal functionality) -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>


@endsection
