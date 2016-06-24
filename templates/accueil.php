<?php include_once 'inc/header.php'; ?>

<div class="container main">
    <div class="formulaire">

        <h2>Connexion</h2>

        <?php Utilitaires::afficher_erreur(); ?>

        <form action="<?php echo Controleur::get_url('liste') ?>" method="post">
            <div class="form-group">
                <label for="login">Login</label>
                <input id="login" name="login" type="text" class="form-control" aria-describedby="sizing-addon2"/>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input id="password" name="password" type="password" class="form-control"/>
            </div>

            <div class="text-center">
                <button class="btn btn-primary">Connexion</button>
                <a href="<?php echo Controleur::get_url('prix') ?>" class="btn btn-grey">Créer un compte</a>
            </div>
        </form>
    </div>
</div>

<?php include_once 'inc/footer.php'; ?>