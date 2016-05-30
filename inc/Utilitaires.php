<?php

/**
 * Created by PhpStorm.
 * User: Leif
 * Date: 28/05/2016
 * Time: 13:42
 */
class Utilitaires
{
    public static function afficher_erreur(){
        if(!empty($_SESSION['message'])) {
            echo '<div class="alert alert-success">';
            echo $_SESSION['message']['text'];
            echo '</div>';

            // Si un contact a été ajouté on montre un lien de retour à la liste

            if($_SESSION['message']['type'] == 'ajout_contact_valide'){
                echo '<a href="'. Controleur::get_url('liste') .'">Retour à la liste</a>';
            }

            unset($_SESSION['message']);
        }

        if(!empty($_SESSION['error'])) {
            echo '<div class="alert alert-danger">';
            echo $_SESSION['error'];
            echo '</div>';
            unset($_SESSION['error']);
        }
    }
}