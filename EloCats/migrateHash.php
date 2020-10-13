<?php
include_once('vendor/phash.php');

try{
    $db= new PDO('mysql:host=localhost;dbname=elocats;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e){
    die('Erreur : ' . $e->getMessage());
}

$q= $db->query('SELECT * FROM cats');
while ($l= $q->fetch()) {
    print_r($l);
    echo "<br>";
    $phasher = new Phash;
    $phash2 = $phasher->getHash($l['image'], false);
    
    echo $imgHash= $phasher->hashAsString($phash2);
    echo "<br><br>";
    $update= $db->prepare('UPDATE cats SET img_hash = ? where id = ?');

    $update->execute(array($imgHash, $l['id']));

}