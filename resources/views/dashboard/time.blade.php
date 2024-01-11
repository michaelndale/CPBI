<script "type=text/javascript">
    setInterval(function()
 {
document.getElementById('heure').innerHTML = new Date().toLocaleTimeString();
}, 1000);
</script>
 <e id="heure"></e>
                          
@php

    setlocale(LC_TIME, 'fra_fra');
    echo "&nbsp;"; 

    echo ucfirst(strftime('%A, %d-%m-%Y'));
    $t='%d';
@endphp
                          