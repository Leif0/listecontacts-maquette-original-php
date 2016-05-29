<?php include_once 'inc/header.php'; ?>

<div class="container ajout-modification">
    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
        <div class="alert alert-info" role="alert">
            Renseignez les informations sur le contact
        </div>

        <form action="#">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" class="form-control"/>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" class="form-control"/>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" id="telephone" name="telephone" class="form-control"/>
            </div>

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" class="form-control"/>
            </div>

        </form>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Valider</button>
            <a href="liste.php" class="btn btn-grey">Retour</a>
        </div>
    </div>
</div>

<?php include_once 'inc/footer.php'; ?>