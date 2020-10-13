<?php 
$Page['title']= "Nouveau chat - Elokitties";
ob_start(); ?>
<div class="container">
    <?php 
        if($Page['tryNewCat'] == 'error'){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erreur ! </strong> les informations envoyés sont invalides, réfèrez-vous aux messages d'erreurs et vérifiez que votre image entre dans la limite de taille.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php 
        }
        elseif($Page['tryNewCat'] == 'collision'){
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Erreur ! </strong> Cette image à déjà été posté <a href="http://elocats/index?action=cat&cat=<?=$cHash[0]?>">ici</a>.  <small class="text-muted">(<?=$cHash[1]?> %)</small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php 
        }
        elseif($Page['tryNewCat'] == 'fileError'){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erreur ! </strong>Fichier corrompu, selectionnez une autre image.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php 
        }
        elseif($Page['tryNewCat'] == 'exessSend'){
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Trop d'envoi ! </strong>Vous avez atteint votre limite d'envoi pour le moment.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php 
        }
    ?>
    <div class="col12 m-5 text-center center">
        <h1 class="display-2">Votre chat !</h1>
    </div>
    <form enctype="multipart/form-data" action="http://elocats/index.php?action=newcat" method="post">
        <div class="row align-bottom">
            <div class="form-group col-lg-4 ">
                <div class="form-group row">
                    <label for="inputCatName" class="col-sm-2 col-lg-10 col-form-label">Nom du chat</label>
                    <div class="col-sm-10 ">
                        <input type="text" name="name" class="form-control" id="inputCatName" required>
                    </div>
                </div>
            </div>
            <div class="form-group col-lg-5">
                <div class="input-group row">
                    <label for="inputAge" class="col-sm-2 col-lg-10 col-form-label">Age <em class="font-weight-light">(sur la photo)</em></label>
                    <div class="col-8 col-sm-7 col-lg-8 gluedRight" id="gluedRight">
                        <input type="number" name="age" class="form-control" id="inputAge" min="0" max="40" step="1" required>
                    </div>
                    <div class=" col-4 col-sm-3 gluedLeft">
                        <select name="infoAge" class="form-control">
                            <option value="year">ans</option>
                            <option value="month">mois</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group col-lg-3">
                <div class="row">
                    <legend class="col-form-label col-sm-2 col-lg-10">Sex</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sex" id="female" value="0" required>
                            <label class="form-check-label" for="female">
                                Femelle
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sex" id="male" value="1">
                            <label class="form-check-label" for="male">
                                Male
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="custom-file">
            <input type="file" name="image" class="custom-file-input" id="customFile" accept=".jpg, .jpeg, .png, .gif" capture="environment" lang="fr" required>
            <label id="fileLabel" class="custom-file-label" for="customFile">photo de votre chat 😻</label>
        </div>

        
        <div class="form-group row">
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" name="license" type="checkbox" id="gridCheck1" required>
                    <label class="form-check-label small" for="gridCheck1">
                        Je certifie être l'auteur de cette photographie et je consens à diffuser cette image sous licence CC0 (créative commons).*
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col text-center mt-5">
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </div>
        </div>
    </form>
</div>
<script src="/public/js/formNewCat.js"></script>
<?php 
$Page['mainContent'] = ob_get_clean();
require('view.php'); 
?>