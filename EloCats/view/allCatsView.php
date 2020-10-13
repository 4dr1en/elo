<?php 
$Page['title']= "Liste- Elokitties";
ob_start(); 
$i= ($Page['numCurPage']-1)*$Page['nCatsPage'];
?>
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <table class="container table mt-5">
            <tbody>
                <?php
foreach ($cats as $Cat) {
    $i++;
    ?>
                <tr>
                    <th scope="row">
                        <span class="ranking align-self-center"><?= $i ?></span>
                    </th>
                    <td>
                        <a class="font-weight-bold align-self-center"
                            href='cat.html?cat=<?=htmlspecialchars($Cat->id()) ?>'>
                            <h2 class="mt-0"><?=htmlspecialchars($Cat->name())?></h5>
                        </a>
                    </td>
                    <td><span class="font-weight-bold">Age : </span><em><?=htmlspecialchars($Cat->fAge())?></em></td>
                    <td><span class="font-weight-bold">Sexe : </span><em><?=htmlspecialchars($Cat->fSex())?></em></td>
                    <td><span class="font-weight-bold">Points Elo : </span><em><?=htmlspecialchars($Cat->elo())?></em>
                    </td>
                </tr>

                <?php
}
?>

            </tbody>
        </table>
    </div>
    
<?php


if($Page['nbCat'] > $Page['nCatsPage']){
?>
    <nav aria-label="navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if($Page['numCurPage'] == 1){echo "disabled";}?>">
                <a class="page-link " href="allCats.html?nPage=<?=$Page['numCurPage']-1?>">Précédent</a>
            </li>

            <?php
            for ($i= 1; $i <= $Page['nbPages']; $i++) { ?>
                <li class="page-item <?php if($Page['numCurPage'] == $i){echo "active";}?>">
                    <a class="page-link" href="allCats.html?nPage=<?=$i?>"><?=$i?></a>
                </li>
            <?php
            }
            ?>
            <li class="page-item <?php if($Page['numCurPage'] == $Page['nbPages']){echo "disabled";}?>" >
                <a class="page-link " href="allCats.html?nPage=<?=$Page['numCurPage']+1?>">Suivant</a>
            </li>
        </ul>        
    </nav>
</div>

<?php
}
$Page['mainContent'] = ob_get_clean();
require('view.php'); 
?>