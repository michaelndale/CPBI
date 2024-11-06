<script type="text/javascript">
    setInterval(function() {
        document.getElementById('heure').innerHTML = new Date().toLocaleTimeString('fr-FR');
    }, 1000);
</script>
<e id="heure"></e>
                          
 @php
 setlocale(LC_TIME, 'fr_FR');
 echo "&nbsp;";
 echo ucfirst(strftime('%A, %d-%B-%Y'));
 $t = '%d';
@endphp
                          