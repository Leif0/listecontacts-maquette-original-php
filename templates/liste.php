<?php
if(!defined('acces_permis')) {
    die('Accès direct impossible');
}
?>

<?php include_once 'inc/header.php'; ?>

    <div class="container liste">
        <div class="col-xs-12">
            
            <div class="deconnexion">
                <a href="<?php echo Controleur::get_url('deconnexion') ?>">Deconnexion</a>
            </div>

            <div class="boutons-principaux text-center">
                <a class="btn btn-primary" href="ajouter_modifier.php">Ajouter un contact</a>
            </div>

            <?php foreach ($contacts as $contact) : ?>

            <div class="contact">
                <div class="informations">
                    <div class="barre">
                        <h3><?php echo $contact->getPrenom() . ' ' . $contact->getNom() ?></h3>

                        <div class="actions">
                            <div class="afficher-actions btn btn-primary">
                                <i class="fa fa-plus-circle fa-2x" aria-hidden="true"></i>
                            </div>

                            <div class="action modifier" data-toggle="tooltip" data-placement="right" title="Modifier"><i class="fa fa-pencil" aria-hidden="true"></i></div>
                            <div class="action appeler" data-toggle="tooltip" data-placement="right" title="Appeler"><i class="fa fa-phone" aria-hidden="true"></i></div>
                            <div class="action contacter"  data-toggle="tooltip" data-placement="right" title="Contacter"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
                            <div class="action supprimer"  data-toggle="tooltip" data-placement="right" title="Supprimer"><i class="fa fa-trash" aria-hidden="true"></i></div>
                        </div>
                    </div>


                    <div class="elements">
                        <div class="description">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent fringilla leo volutpat, interdum massa vel,
                            ultricies ligula. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                        </div>

                        <ul>
                            <li class="telephone"><i class="fa fa-phone-square fa-2x" aria-hidden="true"></i> <span>06 58 74 95 63</span></li>
                            <li class="email"><i class="fa fa-envelope-square fa-2x" aria-hidden="true"></i> <span>contact@gmail.com</span></li>
                        </ul>
                    </div>
                </div>

                <div class="clearboth"></div>
            </div>

            <div class="separateur"></div>

        <?php endforeach; ?>

        </div>
    </div>

<?php include_once 'inc/footer.php'; ?>