<?php 
$Page['title']= htmlspecialchars($Cat->name())." - Elokitties";
ob_start(); ?>

<div class="container">
    <?php
    if(isset($Page['report'])){
        if($Page['report'] == 'success'){
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Signalement enregistré !</strong> Le signalement a bien été enregisté, il sera traité dans les meilleurs délais.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php 
        }elseif($Page['report'] == 'duplicate'){
        ?>
        <div class="alert alert-warning fade show" role="alert">
            <strong>Doublon !</strong> Votre signalement a déjà été pris en compte.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php 
        }
    }
    ?>
    <div class=" text-center">
        <img src="<?= htmlspecialchars($Cat->image());?>" class="catImg"></img>
        <h1 class="display-1"><?= htmlspecialchars($Cat->name());?></h1>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <p><span class="lead">Age : </span><?= htmlspecialchars($Cat->fAge());?></p>
            <p><span class="lead">Sex : </span><?= htmlspecialchars($Cat->fSex());?></p>
            <p><span class="lead">Points Elo : </span><?= htmlspecialchars($Cat->elo());?></p>
            <p><span class="lead">Fiabilité du classement : </span><?= htmlspecialchars($Cat->reliability());?></p>
        </div>
        <div class="col-sm-5 mt-3">
            <?php require("view/components/formReport.php")?>
        </div>
    </div> 
</div>



<?php 
$Page['mainContent'] = ob_get_clean();
require('view.php'); 
?>