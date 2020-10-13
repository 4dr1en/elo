<?php

/*Save the newcat informantions and the image in the db*/
function saveNewCat($Cat){
    $CatsManager= new CatsManager();
    $id= $CatsManager->add($Cat);

    $pathImage= 'user/cats/'.$id.'.'.pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $return= move_uploaded_file($_FILES['image']['tmp_name'], $pathImage);

    $CatsManager->updateImage($id, $pathImage);
    if($return){
        $Cat->hydrate($CatsManager->get($id));
    }
    return $return;
}

/*control the informations of the newCat form, 
if they are corrects return a filled Cat object
else return false
*/
function controlNewCat(){
    if(($_POST['sex'] === "0" || $_POST['sex'] === "1")
    && ($_POST['infoAge'] == 'year' || ($_POST['infoAge'] == 'month' && $_POST['age'] < 12))
    && $_FILES['image']['error'] == UPLOAD_ERR_OK
    && in_array($_FILES['image']['type'], array("image/png", "image/jpg", "image/jpeg", "image/gif"))
    && in_array(pathinfo($_FILES['image']["name"], PATHINFO_EXTENSION), array("png", "jpg", "jpeg", "gif"))
    && $_FILES['image']['size'] > 10000
    && $_FILES['image']['size'] < 4000000){
        $age= $_POST['age'];
        if($_POST['infoAge'] == 'month'){
            $age/= 100;
        }

        $phasher = new Phash;
        $phash = $phasher->getHash($_FILES['image']['tmp_name'], false);
        $imgHash= $phasher->hashAsString($phash);

        $Cat= new Cat();
        $r= $Cat->hydrate(["name"=> $_POST['name'] ,"img_hash"=> $imgHash ,"age"=> $age ,"sex"=> (bool) $_POST['sex'], "img_hash"=> $imgHash]);

        if($r) return $Cat;
    }
    return false;
}
/*control if the image is similar to the images in the data base
if yes return an array with the id of the image in the db and the % of similarity (>90%)
if no return 0*/
function controlHash($hash){
    $CatsManager= new CatsManager();
    $r= $CatsManager->getAllHashs();

    $phasher = new Phash;

    while($l = $r->fetch()){
        $similarity= $phasher->getSimilarity($hash, $l['img_hash']);
        if($similarity > 90) return [$l['id'], $similarity];
    }
    return 0;
}