<?php

class Modele
{
    public static function ouvrir_connexion(){
        $bdd = new PDO('pgsql:user=postgres dbname=listecontacts password=123456');
        return $bdd;
    }

    public static function fermer_connexion(&$bdd){
        $bdd = null;
    }

    public static function connexion_utilisateur($login, $password){
        $bdd = self::ouvrir_connexion();

        $requete = $bdd->prepare("SELECT id, login, password FROM utilisateurs WHERE login = :login");

        $requete->execute([
            'login' => $login
        ]);

        $resultat = $requete->fetch();

        // L'utilisateur a été trouvé
        if($resultat){

            // Vérifie si le pass est bon
            $bon_password = password_verify($password, $resultat['password']);

            if($bon_password){
                $user = new Utilisateur($resultat['id'], $resultat['login']);
                $_SESSION['idUtilisateur'] = $resultat['id'];
                return $user;
            }
        }else{
            echo 'Mauvais identifiant ou mot de passe';
        }


    }
    
    public static function creer_utilisateur($login, $password, $email){
        $bdd = self::ouvrir_connexion();

        // Afficher les erreurs
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        // Vérifier si le login est déjà pris
        $requete = $bdd->prepare("SELECT login FROM utilisateurs WHERE login = :login");

        $requete->execute([
            ':login' => $login
        ]);

        $resultat = $requete->fetch();

        if(!empty($resultat)){
            // Login ou email déjà pris
            return null;
        }

        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        try{
            $requete = $bdd->prepare(
                'INSERT INTO utilisateurs(id, login, password, email) 
                 VALUES(DEFAULT, :login, :password, :email)
                 RETURNING id'
            );

            $resultat = $requete->execute(array(
                ':login' => $login,
                ':password' => $password_hash,
                ':email' => $email
            ));

            // Inscription OK
            if($resultat == 1){

                // Recupère l'id de l'utilisateur qui vient d'être crée
                $idUtilisateur = $requete->fetch()['id'];

                // Créer l'utilisateur
                $user = new Utilisateur($idUtilisateur, $login);

                // Met en session l'id utilisateur
                $_SESSION['idUtilisateur'] = $idUtilisateur;
                return $user;
            }

        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public static function recuperer_utilisateur_par_id($id){
        $bdd = self::ouvrir_connexion();

        $requete = $bdd->prepare("SELECT id, login FROM utilisateurs WHERE id = :id");
        $requete->execute([
            'id' => $id
        ]);

        $resultat = $requete->fetch();

        if($resultat){
            $user = new Utilisateur($resultat['id'], $resultat['login']);
            $_SESSION['idUtilisateur'] = $resultat['id'];
            return $user;
        }else{
            echo 'Id inconnu';
        }
    }

    public static function get_contacts($id_utilisateur){
        require_once 'Contact.php';
        $bdd = Modele::ouvrir_connexion();

        $requete = $bdd->prepare(
            "SELECT id, nom, prenom, telephone, email, id_utilisateur FROM contacts WHERE id_utilisateur = :id_utilisateur"
        );

        $resultat = $requete->execute([
            'id_utilisateur' => $id_utilisateur
        ]);

        // Liste de contacts
        $contacts = array();

        if($resultat){
            // On ajoute chaque contact à la liste
            while ($ligne = $requete->fetch(PDO::FETCH_OBJ)){
                $contact = new Contact(
                    $ligne->nom,
                    $ligne->prenom,
                    $ligne->telephone,
                    $ligne->email
                );

                $contacts[] = $contact;
            }
        }

        Modele::fermer_connexion($bdd);

        return $contacts;
    }
}