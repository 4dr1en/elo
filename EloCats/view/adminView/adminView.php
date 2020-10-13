<?php 
$Page['title']= "admin - Elokitties";
ob_start(); ?>
<div class="container">
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">id Chat</th>
            <th scope="col">raison du signalement</th>
            <th scope="col">date du signalement</th>
            <th scope="col">traité ?</th>
            <th scope="col">ip du signalement</th>
            <th scope="col">action</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($report= $Reports->fetch()) {
    ?>
    <tr>
        <th scope="row"><?=htmlspecialchars($report['id']) ?></th>
        <td><a href="http://elocats/index?action=cat&cat=<?=htmlspecialchars($report['id_cat']) ?>" class="font-weight-bold lead" target="_blank"><?=htmlspecialchars($report['id_cat']) ?></a></td>
        <td><?=htmlspecialchars($report['reason']) ?></td>
        <td><?=htmlspecialchars($report['date_report']) ?></td>
        <td><?php if($report['treatment']){echo "oui";}else{echo "non";} ?></td>
        <td><?=htmlspecialchars($report['ip_reporter']) ?></td>
        <td>
            <a href="http://elocats/index?action=admin&idReport=<?=htmlspecialchars($report['id']) ?>&admin=hide&idCat=<?=htmlspecialchars($report['id_cat']) ?>" class="btn btn-warning">modérer</a>
            <a href="http://elocats/index?action=admin&idReport=<?=htmlspecialchars($report['id']) ?>&admin=accept&idCat=<?=htmlspecialchars($report['id_cat']) ?>" class="btn btn-success">décliner</a>
        </td>
    </tr>
    <?php    
    }?>
</div>
<a href=""></a>
<?php 
$Page['mainContent'] = ob_get_clean();
require('view/view.php'); 
?>