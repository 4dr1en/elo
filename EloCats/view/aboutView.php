<?php 
$Page= [];
$Page['title']= "top 10 - Elokitties";
ob_start(); 
?>
<div class="container">
    <h1 class="display-1 m-5">Le projet</h1>
    <div class="lead">
        <p>Elochat est un petit projet d'apprentissage écrit en php.</p>
        <p>Son code source est disponible sur Github.</p>
        <p>Le principe consiste à exploiter la méthode de <a href="https://fr.wikipedia.org/wiki/Classement_Elo">classement Elo</a> utilisée entre autres dans certains sports compétitifs tels que les échecs, le go, le tennis de table ou encore dans le jeu vidéo. Et de l'appliquer aux photos de chat de compagnie mises en ligne par les utilisateurs.</p>
        <p>N'hésitez pas à retourner les problèmes auquel vous serez confrontés sur la page Github du projet ou à l'adresse <em>postmaster[at]elokitties.fr</em> .</p>
        <br>
    </div>
    
    <p class="mt-5"><a href="admin.html">page d'administration</a></p>
</div>


<?php

$Page['mainContent'] = ob_get_clean();
require('view.php'); 
?>