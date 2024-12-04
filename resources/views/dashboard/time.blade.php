<script type="text/javascript">
    setInterval(function() {
        document.getElementById('heure').innerHTML = new Date().toLocaleTimeString('fr-FR');
    }, 1000);
</script>
<e id="heure"></e>
                          
@php
    setlocale(LC_TIME, 'fr_FR.UTF-8'); // Configure la locale en UTF-8
    echo "&nbsp;";
    // Formater la date avec accents corrigés
    $date = strftime('%A, %d-%B-%Y');
    $date = mb_convert_case($date, MB_CASE_TITLE, 'UTF-8'); // Mettre la première lettre de chaque mot en majuscule
    echo $date;
@endphp

                          