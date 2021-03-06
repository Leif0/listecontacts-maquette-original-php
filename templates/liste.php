<?php
if(!defined('acces_permis')) {
    die('Vous devez être connecté');
}
?>

<?php include_once 'inc/header.php'; ?>

    <div class="container liste">
        <div class="col-xs-12">

            <div class="boutons-principaux text-center">
                <a class="btn btn-primary" href="<?php echo Controleur::get_url('ajouter_modifier_contact') ?>">Ajouter un contact</a>
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

                            <a href="<?php echo Controleur::get_url('ajouter_modifier_contact') . '?id=' . $contact->getId() ?>">
                                <div class="action modifier" data-toggle="tooltip" data-placement="right" title="Modifier"><i class="fa fa-pencil" aria-hidden="true"></i></div>
                            </a>
                            <a href="tel:<?php echo $contact->getTelephone() ?>">
                                <div class="action appeler" data-toggle="tooltip" data-placement="right" title="Appeler"><i class="fa fa-phone" aria-hidden="true"></i></div>
                            </a>
                            <a href="mailto:<?php echo $contact->getEmail() ?>">
                                <div class="action contacter"  data-toggle="tooltip" data-placement="right" title="Contacter"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
                            </a>
                            <a href="<?php echo Controleur::get_url('supprimer_contact') . '/' . $contact->getId() ?>">
                                <div class="action supprimer" data-idcontact="<?php echo $contact->getId() ?>" data-toggle="tooltip" data-placement="right" title="Supprimer"><i class="fa fa-trash" aria-hidden="true"></i></div>
                            </a>
                        </div>
                    </div>


                    <div class="elements">
                        <div class="description">
                            <?php echo $contact->getDescription() ?>

                            <div class="plus">
                                <i class="fa fa-plus-square" aria-hidden="true" style="color:#3EC1D3"></i>
                            </div>
                        </div>

                        <ul>
                            <li class="telephone"><i class="fa fa-phone fa-2x" aria-hidden="true"></i> <span><?php echo $contact->getTelephone() ?></span></li>
                            <li class="email"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i> <span><?php echo $contact->getemail() ?></span></li>
                            <li class="entreprise"><i class="fa fa-building-o fa-2x" aria-hidden="true"></i> <span><?php echo $contact->getRaisonSocialeEntreprise() ?></span></li
                        </ul>
                        <div class="clearboth"></div>
                    </div>
                </div>

                <div class="clearboth"></div>
            </div>

            <div class="separateur"></div>

        <?php endforeach; ?>

        </div>
    </div>

<?php include_once 'inc/footer.php'; ?>