<?php
include_once('controler/Cat.php');
include_once('model/catsManager.php');
include_once('controler/controler.php');
session_start();



if( isset($_GET['action'])){
    if($_GET['action'] == 'cat' && isset($_GET['cat'])){
        displayCat();
    }
    else if($_GET['action'] == 'topcat'){
        displayTopcat();
    }
    else if($_GET['action'] == 'allCats'){
        displayAllCats();
    }
    else if($_GET['action'] == 'opt'){
        opt();
    }
    else if($_GET['action'] == 'saveElo' && isset($_GET['cat1']) && isset($_GET['cat2']) && isset($_GET['v'])){
        saveElo();
    }
    else if($_GET['action'] == 'newcat' ){
        newCat();
    }
    else if($_GET['action'] == 'report' ){
        if(isset($_POST['reason'], $_POST['reason'])) report();
        else opt();
    }
    else if($_GET['action'] == 'about' ){
        about();
    }
    else if($_GET['action'] == 'admin' ){
        admin();
    }
    else opt();

}
else opt();

