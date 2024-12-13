<style>
  .arbre-container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap; /* Pour placer les lampes autour de l'arbre */
    position: relative;
    
}

.lampe {
    width: 10px;
    height: 10px;
    margin: 5px;
    border-radius: 50%;
    background-color: red;
    animation: clignoter 1s infinite alternate;
}

/* Animation de clignotement */
@keyframes clignoter {
    0% {
        opacity: 1;
    }
    100% {
        opacity: 0.2;
    }
}

  </style>

@if($showTree)
<div class="arbre-container">
   

    <div class="lampe rouge"></div>
    🎄
    <div class="lampe rouge"></div>
  
</div>

