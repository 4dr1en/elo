<?php

function displayCat(int $id= 0, $Page= null){
    if(!$id) $id= (int) $_GET['cat'];
    $Cat= new Cat();
    $DbCats= new CatsManager();
    $tab= $DbCats->get($id);
    
    if($tab){
        $Cat->hydrate($tab);
        require('view/catView.php');
    }
}

function displayTopcat(){
    $DbCats= new CatsManager();
    $q= $DbCats->gets(0 , 10);
    $cats= array();
    while ($h= $q->fetch()) {
        $cats[]= new Cat($h);
    }
    require('view/topCatView.php');
}

function displayAllCats(){
    $DbCats= new CatsManager();
    
    $Page['nCatsPage']= 5;
    $Page['nbCat']= $DbCats->count();
    $Page['numCurPage']= 1;
    $Page['nbPages']= ceil($Page['nbCat'] / $Page['nCatsPage']);
  
    $options = array("options" => array("min_range"=> 1, "max_range"=> $Page['nbPages']));
    if($numCurPage= filter_input(INPUT_GET, 'nPage', FILTER_VALIDATE_INT, $options)){
        $Page['numCurPage']= $numCurPage;
    }

    $q= $DbCats->gets(($Page['numCurPage']-1)*$Page['nCatsPage'] , $Page['nCatsPage']);

    $cats= array();
    while ($h= $q->fetch()) {
        $cats[]= new Cat($h);
    }
    require('view/allCatsView.php');  
}

function saveElo(){
    $curTime= time();
    if( isset($_SESSION['id1'], $_SESSION['id2'], $_SESSION['timeOpt'])
    && $_GET['cat1'] == $_SESSION['id1'] && $_GET['cat2'] == $_SESSION['id2']){

        $idCat1= (int) $_GET['cat1'];
        $idCat2= (int) $_GET['cat2']; 
        $v= (int) $_GET['v'];

        $DbCats= new CatsManager();
        $Cat1= new Cat($DbCats->get($idCat1));
        $Cat2= new Cat($DbCats->get($idCat2));

        if( $curTime > $_SESSION['timeOpt']+2 && $curTime < $_SESSION['timeOpt']+3600 && $Cat1 && $Cat2){    

            $nElo= $Cat1->newElo($Cat2->elo(), $v);
            $DbCats->updateElo($Cat1->id(), $nElo);

            if( $v) $v= Cat::DEFEAT;
            else $v= Cat::VICTORY;

            $nElo= $Cat2->newElo($Cat1->elo(), $v);
            $DbCats->updateElo($Cat2->id(), $nElo);
        }
        opt(array($Cat1->id(), $Cat2->id()));
    }
    
    else opt();
}

function opt(array $oldCats= null){
    $DbCats= new CatsManager();
    $r= $DbCats->get2rand($oldCats);
    $Cat1= new Cat($r->fetch());
    $Cat2= new Cat($r->fetch());

    $_SESSION['id1']= $Cat1->id();
    $_SESSION['id2']= $Cat2->id();
    $_SESSION['timeOpt']= time();

    require('view/optView.php');
}

function newCat(){
    include_once('vendor/phash.php');
    include_once('controler/newCat.php');

    $Page= [];
    $Page['tryNewCat']= false; 
    $return= false;

    if( isset($_POST['name'], $_FILES['image'], $_POST['age'], $_POST['infoAge'], $_POST['sex'])){
        $Page['tryNewCat']= 'error'; 

        $CatsManager= new CatsManager();
        $fiveDaysLater= date("Y-m-d", time()-3600*24*5);
        if( $CatsManager-> nbOfSendByIp($fiveDaysLater , $_SERVER['REMOTE_ADDR']) <= 3){
           
            $Cat= controlNewCat();
            if( $Cat){

                $cHash= controlHash($Cat->imgHash());
                if( !$cHash){

                    $return= saveNewCat($Cat);
                    if($return){
                        require('view/CatView.php');
                    }
                    else $Page['tryNewCat']= 'fileError';
                }
                else $Page['tryNewCat']= 'collision'; 
            }
        }
        else $Page['tryNewCat']= 'exessSend'; 
    }
    if( !$return){
        require('view/newCatView.php');
    }
}

function report(){
    $CatsManager= new CatsManager();
    if( strlen($_POST['reason']) > 0 && strlen($_POST['reason']) < 255 && $CatsManager->exist((int) $_POST['cat'])){
        include_once('model/reportsManager.php');
        $ReportsManager= new reportsManager();
        if( !$ReportsManager->itDouble($_POST['cat'])){
            
            $ReportsManager->newReport($_POST['cat'], $_POST['reason']);
            $Page['report']= 'success';
        }
        else $Page['report']= 'duplicate';
        displayCat((int) $_POST['cat'], $Page);
    }
    else opt();
}

function admin(){
    $connected= false;
    if( isset($_POST['pwd'])){
        /*$hash= password_hash ( $_POST['pwd'] , PASSWORD_ARGON2ID);
        $file= fopen("pwd", "a");
        fputs($file, $hash);
        fclose($file);*/

        $file= fopen("pwd", "r");
        $hash= fgets( $file);
        fclose($file);
        $connected= password_verify( $_POST['pwd'] ,$hash );
        if($connected){
            $_SESSION['admin']= true;
        }
    }
    elseif(isset($_SESSION['admin']) && $_SESSION['admin']){
        $connected= true;
        
        if(isset($_GET['idCat'], $_GET['idReport']) && ($_GET['admin'] == 'hide' || $_GET['admin'] == 'accept')){
            include_once('model/reportsManager.php');
            $CatsManager= new CatsManager();
            $ReportsManager= new ReportsManager();
            if($CatsManager->exist($_GET['idCat']) && $ReportsManager->exist($_GET['idCat'])){

                $CatsManager->updateStatut($_GET['idCat'], $_GET['admin']);
                $ReportsManager->treated($_GET['idReport']);
            }
        }
    }

    if($connected){
        include_once('model/reportsManager.php');
        $ReportsManager= new ReportsManager();
        $Reports= $ReportsManager->getAllReports();
        require('view/adminView/adminView.php');
        return 0;
    }
    require('view/adminView/adminLoginView.php');
}

function about(){
    require('view/aboutView.php');
}

