<!-- VERIFIER CONNECTION   -->

<div class="container">
  		
    <h1 align="center"></h1>
          
</div>
      
<div class="toast" style="position: absolute; top: 25px; right: 25px;">
  <div class="toast-header">
      <i class="bi bi-wifi"></i>&nbsp;&nbsp;&nbsp;
      <strong class="mr-auto"><span class="text-success"> <!--You're online now --> Vous êtes en ligne maintenant</span></strong>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="toast-body">
      <!-- Hurray! Internet is connected. --> <?= $_SESSION["prenom"] ?>! Internet est connecté.
  </div>
</div>

<script>

var status = 'online';
var current_status = 'online';

function check_internet_connection()
{
  if(navigator.onLine)
  {
      status = 'online';
  }
  else
  {
      status = 'offline';
  }

  if(current_status != status)
  {
      if(status == 'online')
      {
          $('i.bi').addClass('bi-wifi');
          $('i.bi').removeClass('bi-wifi-off');
          $('.mr-auto').html("<span class='text-success'> Vous êtes en ligne maintenant </span>");
          $('.toast-body').text('<?= $_SESSION["prenom"] ?> ! Internet est connecté.');
      }
      else
      {
          $('i.bi').addClass('bi-wifi-off');
          $('i.bi').removeClass('bi-wifi');
          $('.mr-auto').html("<span class='text-danger'>Vous êtes maintenant hors ligne</span>");
          $('.toast-body').text('<?= $_SESSION["prenom"] ?> ! Internet est déconnecté.')
      }

      current_status = status;

      $('.toast').toast({
          autohide:false
      });

      $('.toast').toast('show');
  }
}

check_internet_connection();

setInterval(function(){
  check_internet_connection();
}, 300);

</script>

<!--  FIN  -->


