<?php
/*
  Test
*/
class Controleur
{
    private static $path = 'http://localhost/listecontacts-maquette-original-php';

    public static function afficher_accueil(){
        $titre = "Accueil";
        $body_class = "accueil";

        if(!empty($_SESSION['idUtilisateur'])){
            self::rediriger('liste');
        }else{
            require 'templates/accueil.php';
        }
    }

    public static function afficher_inscription(){
        $titre = "Inscription";
        $body_class = "accueil";

        if(!empty($_SESSION['idUtilisateur'])){
            self::rediriger('liste');
        }else{
            require 'templates/inscription.php';
        }
    }


    public static function afficher_profil($idUtilisateur){
        $titre = "Profil";
        $body_class = "profil";

        $utilisateur = Modele::recuperer_profil_utilisateur_par_id($idUtilisateur);

        require 'templates/profil.php';
    }

    public static function afficher_prix(){
        $titre = "Prix";
        $body_class = "prix";

        if(!empty($_SESSION['idUtilisateur'])){
            self::rediriger('liste');
        }else{
            require 'templates/prix.php';
        }
    }

    public static function afficher_ajouter_modifier_contact(){
        if(!empty($_SESSION['idUtilisateur'])){
            // Définie pour interdire l'accès direct à la page
            define('acces_permis', TRUE);
        }

        $titre = "Ajouter un contact";
        $body_class = "ajouter-contact";

        if(empty($_SESSION['idUtilisateur'])){
            self::rediriger('accueil');
        }else{
            $entreprises = Modele::get_entreprises();
            require 'templates/ajouter_modifier.php';
        }
    }

    public static function afficher_liste(){
        $titre = "Mes contacts";
        
        // Si la session est vide (utilisateur non connecté) on tente de se connecter
        if(empty($_SESSION['idUtilisateur'])){
            if(isset($_POST['login']) && isset($_POST['password'])){
                $user = Modele::connexion_utilisateur($_POST['login'], $_POST['password']);
            }
        }else{
            $user = Modele::recuperer_utilisateur_par_id($_SESSION['idUtilisateur']);
        }

        // Si l'utilisateur existe on récupère ses contacts et on affiche la liste
        // Sinon on le redirige vers l'accueil
        if(!empty($user)){
            $_SESSION['login'] = $user->getLogin();
            $contacts = Modele::get_contacts($user->getId());

            // Définie pour interdire l'accès direct à la page
            define('acces_permis', TRUE);

            require 'templates/liste.php';
        }else{
            //self::rediriger('accueil', "Impossible d'acceder à la liste de contacts");
        }
    }

    public static function ajouter_modifier_contact(){
        if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['telephone']) && isset($_POST['email']) && isset($_POST['entreprise'])){
            if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['telephone']) && !empty($_POST['email']) && !empty($_POST['entreprise'])){
                require_once 'inc/Contact.php';

                $contact = new Contact(
                    null,
                    $_POST['nom'],
                    $_POST['prenom'],
                    $_POST['telephone'],
                    $_POST['email'],
                    $_POST['description'],
                    $_SESSION['idUtilisateur'],
                    $_POST['entreprise']);

                // Si idContact n'est pas vide c'est qu'on cherche à modifier le contact
                if(!empty($_POST['idContact'])){
                    $contact->setId($_POST['idContact']);
                    $resultat = Modele::modifier_contact($contact);

                    $_SESSION['message'] = array(
                        'text' => "Contact modifié",
                        'type' => "ajout_contact_valide"
                    );
                }else{
                    $resultat = Modele::creer_contact($contact);

                    $_SESSION['message'] = array(
                        'text' => "Contact modifié",
                        'type' => "ajout_contact_valide"
                    );
                }
            }else{
                $_SESSION['error'] = "Veuillez remplir tous les champs !";
            }
        }
    }

    public static function inscription($login, $password, $email){
        $user = Modele::creer_utilisateur($login, $password, $email);
        
        if($user == null){
            $_SESSION['error'] = "Login ou email déjà utilisé !";
        }else{
            self::rediriger('liste');
        }
    }

    public static function recuperer_contact(){
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $idContact = intval($_GET['id']);
            $contact = Modele::recuperer_contact_par_id($idContact);
            return $contact;
        }
    }

    public static function deconnexion(){
        if(isset($_SESSION['idUtilisateur'])){
            $_SESSION['idUtilisateur'] = null;
        }

        session_destroy();

        Controleur::rediriger('accueil');
    }

    public static function get_url($name){
        if(isset($name)){
            switch ($name){
                case 'accueil':
                    $url_absolue = self::get_path() . '/index.php';
                    break;
                default:
                    $url_absolue = self::get_path() . '/index.php/' . $name;
                    break;
            }
        }

        return $url_absolue;
    }

    public static function rediriger($name, $message = null){
        $_SESSION['error'] = $message;
        header("Location: " . self::get_url($name));
    }

    public static function get_path(){
        return self::$path;
    }
}
