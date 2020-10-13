
<?php 
$Page= [];
$Page['title']= "top 10 - Elokitties";
ob_start(); 
$i= 0;
echo '<div class="container-fluid">';
echo '<div class="row d-flex justify-content-center"><div style="width:90%;" >';
foreach ($cats as $Cat) {
    $i++;
    
    if($i < 4){
        ?>
        <div class="row cat ">
            <div class="col-12 col-lg-11 col-xl-9 ">
                <div class="row d-flex  justify-content-center align-items-center">    
                    <div class="col-sm-5 catImg" >
                        <img src="<?=htmlspecialchars($Cat->image())?>" alt="<?=htmlspecialchars($Cat->name())?>" class="thumbnail">
                    </div>
    
                    <div class="col-sm-7">
                        <div class="row">
                            <div class="col-12 col-lg-2 d-flex justify-content-center align-items-center">
                            <?php 
                                echo '<p><span class="ranking">'.$i.'</span><span class="text-muted">';
                                if($i == 1) echo 'er</span></p>';
                                else echo 'ème</span></p>';
                            ?>
                            </div>

                            <div class="col-12 col-lg-5 d-flex justify-content-center align-items-center">
                                <a href='cat.html?cat=<?=htmlspecialchars($Cat->id()) ?>'>
                                    <h2 class="mt-0 display-4"><?=htmlspecialchars($Cat->name()) ?></h2>
                                </a>
                            </div>
                
                            <div class="col-12 col-lg-5 d-flex justify-content-center align-items-center">
                                <ul class="info">
                                    <li><span class="font-weight-bold">Age : </span><em><?=htmlspecialchars($Cat->fAge())?></em></li>
                                    <li><span class="font-weight-bold">Sexe : </span><em><?=htmlspecialchars($Cat->fSex())?></em></li>
                                    <li><span class="font-weight-bold">Points Elo : </span><em><?=htmlspecialchars($Cat->elo())?></em></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if($i == 3){?>
            </div></div><table class="container table mt-5"><tbody>
        <?php
        }
    }else{?>

        <tr>
            <th scope="row">
                <span class="ranking align-self-center"><?= $i ?></span>
             </th>
            <td>
                <a class="font-weight-bold align-self-center" href='cat.html?cat=<?=htmlspecialchars($Cat->id()) ?>'>
                    <h2 class="mt-0"><?=htmlspecialchars($Cat->name())?></h5>
                </a>
            </td>
            <td><span class="font-weight-bold">Age : </span><em><?=htmlspecialchars($Cat->fAge())?></em></td>
            <td><span class="font-weight-bold">Sexe : </span><em><?=htmlspecialchars($Cat->fSex())?></em></td>
            <td><span class="font-weight-bold">Points Elo : </span><em><?=htmlspecialchars($Cat->elo())?></em></td>
        </tr>

        <?php
    }
}
?>
        </tbody>
    </table>
    <div class="row">
        <span class="m-auto">
            <a href="allCats.html" class="btn btn-dark mb-5">tout voire</a>
        </span>
    </div>
</div>


<?php

$Page['mainContent'] = ob_get_clean();
require('view.php'); 
?>