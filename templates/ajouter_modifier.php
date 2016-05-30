<?php
// On vérifie si on accède pas directement au fichier
if(!defined('acces_permis')) {
    die('Vous devez être connecté');
}

include_once 'inc/header.php';

// Ajoute le contact si c'est une requete POST
Controleur::ajouter_modifier_contact();

// Récupère le contact si on veut modifier
$contact = Controleur::recuperer_contact();

?>

<div class="container ajout-modification">
    <div class="col-xs-12 col-sm-6 col-sm-offset-3">

        <div class="alert alert-info" role="alert">
            Renseignez les informations sur le contact
        </div>

        <?php Utilitaires::afficher_erreur() ?>

        <form method="post" class="formulaire ajout-modification-contact">
            <input type="hidden" name="idContact" value="<?php echo $_GET['id'] ?>" />
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" class="form-control" value="<?php if(isset($contact)) echo $contact->getNom() ?>"/>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" class="form-control" value="<?php if(isset($contact)) echo $contact->getPrenom() ?>"/>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" id="telephone" name="telephone" class="form-control" value="<?php if(isset($contact)) echo $contact->getTelephone() ?>"/>
            </div>

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php if(isset($contact)) echo $contact->getEmail() ?>"/>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary fleft">Valider</button>
                <a href="<?php echo Controleur::get_url('liste') ?>" class="btn btn-grey fleft">Retour</a>
            </div>

        </form>

    </div>
</div>

<?php include_once 'inc/footer.php'; ?>