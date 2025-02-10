<div class="modal fade" id="editsignatureModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="EditsignatureForm" autocomplete="off" enctype='multipart/form-data'>
        @method('post')
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> <i class="fa fa-user-edit"></i> Modifier le signature </h5><button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1"></span></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="custom-file">
                <input id="personneidp" name="personneidp" type="hidden" value="{{ Auth::user()->id }}" />
                <input type="file" class="form-control" id="customFile" name="signature" accept="image/*" onchange="preview_image(event)">
              </div>
              <br><br>
              <div id="wrapper">
                @php
                $signature = Auth::user()->signature;
                @endphp
                <img src="{{  asset($signature) }}" id="output_image" class="" style="width:50%; border-radius:10px ; margin-left:25% ">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="addsignaturebtn" id="addsignaturebtn" class="btn btn-primary">Sauvegarder</button>
          </div>
        </div>
      </form>
    </div>
  </div>