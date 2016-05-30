<?php
session_start();

/*
 * Front controller
 */

// Initialisation du modèle et du controleur

require_once 'inc/Modele.php';
require_once 'inc/Controleur.php';
require_once 'inc/Utilisateur.php';
require_once 'inc/Utilitaires.php';

$user = '';

// Récupère l'url demandée

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace("/listecontacts-maquette-original-php/index.php", '', $uri);

// Selon l'url, on affiche le bon template
switch($uri) {
    case '':
        Controleur::afficher_accueil();
        break;
    case '/liste':
        Controleur::afficher_liste();
        break;
    case '/inscription':
        Controleur::afficher_inscription();
        break;
    case '/ajouter_modifier_contact':
        Controleur::afficher_ajouter_modifier_contact();
        break;
    case '/deconnexion':
        Controleur::deconnexion();
        break;
    default:
        // Test si on veut supprimer un contact
        $regexSupprimerContact = "/\/supprimer_contact\/[0-9]+/";

        // Trouve l'id du contact qu'on veut supprimer
        if(preg_match($regexSupprimerContact, $uri)){
            $idContact = intval(str_replace('/supprimer_contact/', '', $uri));

            // Supprime le contact
            Modele::supprimer_contact($idContact);

            // Redirige vers la liste
            Controleur::rediriger('liste');
        }else{
            header('HTTP/1.1 404 Not Found');
            echo '<html><body><h1>Erreur 404 : page non trouvée</h1></body></html>';
        }

        break;
}

?>
