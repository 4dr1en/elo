
<?php 

$Page['title']= "départagez les chats !";
ob_start(); ?>

<div class="container-fluid mt-5">
    <div class="col12 m-5 text-center center">
        <h1 class="display-2">Lequel est le plus mignon ?</h1>
    </div>
    <div class="row mx-sm-3 mx-md-3 mx-lg-5">

    <?php for($i= 1; $i < 3; $i++){
        $nCat= 'Cat'.$i;
        $Cat= $$nCat;
        if($i==1) $v=1;
        else $v= 0;
        $link= "saveElo.html?cat1=". htmlspecialchars($Cat1->id())."&cat2=". htmlspecialchars($Cat2->id())."&v=".$v;
        ?>

        <div class="col-md-6">
            <div class="card bg-light mb-2 choiceCard">
                <a href="<?=$link?>" class="stetched-link">
                    <div style="max-height: 450px; overflow: hidden;" class="choiceImg"><img class="card-img-top center-block" src="<?= htmlspecialchars($Cat->image())?>" alt="<?= htmlspecialchars($Cat->name());?>" ></div>
                </a>
                <div class="card-body ml-5 mr-2">
                    <h2 class="card-title display-5"><?= htmlspecialchars($Cat->name());?></h2>
                    <p class="card-subtitle"><?=htmlspecialchars($Cat->fAge());?> <span class="text-muted pl-1">(<?=htmlspecialchars($Cat->fSex());?>)</span></p>
                    <div class="float-right col-xl-5 mt-1 ">
                        <?php require("view/components/formReport.php")?>
                    </div>
                </div>
            </div>
        </div>

    <?php }?>

    </div>
</div>
<script src="/public/js/opt.js"></script>
<?php 
$Page['mainContent'] = ob_get_clean();
require('view.php'); 
?>