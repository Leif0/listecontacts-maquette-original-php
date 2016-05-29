<?php include_once 'inc/header.php'; ?>

<?php
if(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])){
    Controleur::inscription($_POST['login'], $_POST['password'], $_POST['email']);
}
?>

<div class="container main">
    <div class="formulaire inscription">

        <h2>Créer mon compte iContacts</h2>

        <?php Utilitaires::afficher_erreur(); ?>

        <form method="post" onsubmit="return validerInscription()">
            <div class="form-group">
                <label for="login">Login</label>
                <input id="login" name="login" type="text" class="form-control" required/>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input id="password" name="password" type="password" class="form-control" required/>
            </div>

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input id="email" name="email" type="text" class="form-control" required/>
            </div>

            <div class="form-group text-center spam">
                <input id="spam" name="spam" type="checkbox"> Accepter de recevoir plein de spams
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Valider</button>
                <a href="<?php echo Controleur::get_url('accueil') ?>" class="btn btn-grey">Retour à l'accueil</a>
            </div>
        </form>
    </div>
</div>

<?php include_once 'inc/footer.php'; ?>