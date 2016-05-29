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
        if(!empty($_SESSION['error'])) {
            echo '<div class="alert alert-danger">';
            echo $_SESSION['error'];
            echo '</div>';
            unset($_SESSION['error']);
        }
    }
}