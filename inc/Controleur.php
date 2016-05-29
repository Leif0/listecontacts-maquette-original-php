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
            $contacts = Modele::get_contacts($user->getId());

            // Définie pour interdire l'accès direct à la page
            define('acces_permis', TRUE);

            require 'templates/liste.php';
        }else{
            //self::rediriger('accueil', "Impossible d'acceder à la liste de contacts");
        }
    }

    public static function connexion($login, $password){
        if(isset($login) && isset($password)){
            $_SESSION['idUtilisateur'] = 1;
        }else{
            Controleur::rediriger('accueil');
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

    public static function deconnexion(){
        if(isset($_SESSION['idUtilisateur'])){
            $_SESSION['idUtilisateur'] = null;
        }

        session_destroy();

        Controleur::rediriger('accueil');
    }

    public static function get_url($name){
        switch ($name){
            case 'liste':
                $url_absolue = self::get_path() . '/index.php/' . $name;
                break;
            case 'accueil':
                $url_absolue = self::get_path() . '/index.php';
                break;
            case 'inscription':
                $url_absolue = self::get_path() . '/index.php/inscription';
                break;
            case 'deconnexion':
                $url_absolue = self::get_path() . '/index.php/' . $name;
                break;
            default:
                $url_absolue = self::get_path();
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
