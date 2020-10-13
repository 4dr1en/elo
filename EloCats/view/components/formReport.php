<a class="btn btn-outline-dark btn-sm card-link" data-toggle="collapse" href="#reportForm<?=$Cat->id()?>" role="button" aria-expanded="false" aria-controls="reportForm<?=$Cat->id()?>">Signaler ce contenu</a>
<div id="reportForm<?=$Cat->id()?>" class="collapse border-left p-3">
    <form action="http://elocats/index.php?action=report" method="POST">
        <div class="form-group">
            <label for="reason" class="col-form-label">Raison du signalement :</label>
            <select id="reason" name="reason" class="form-control" required>
                <option value="" class="text-muted">- Selectionnez le problème -</option>
                <option value="sexual">Contenu à caractère sexuel</option>
                <option value="racism">Contenu à caractère raciste</option>
                <option value="abuses">Insultes ou contenu injurieux</option>
                <option value="personalInformations">Contient des informations personnelles</option>
                <option value="irrelevant">Ce n'est pas un chat</option>
                <option value="other">Autre</option>
            </select>
        </div>
        <div class="form-group">
            <input name="cat" value="<?=$Cat->id()?>" type="hidden"></input>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-warning mr-2">Signaler</button>
        </div>
    </form>
</div>        