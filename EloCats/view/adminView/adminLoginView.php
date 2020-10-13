<?php 
$Page['title']= "admin - Elokitties";
ob_start(); ?>

<div class="container">

    <form action="http://elocats/index.php?action=admin" method="post">
        <div class="form-group">
            <label for="exampleInputPassword1">mot de pass</label>
            <input type="password" name="pwd" class="form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-primary">Connexion</button>
    </form>
</div>



<?php 
$Page['mainContent'] = ob_get_clean();
require('view/view.php');
?>