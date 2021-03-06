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
        $requete = $bdd->prepare("SELECT login FROM utilisateurs WHERE login = :login OR email = :email");

        $requete->execute([
            ':login' => $login,
            ':email' => $email
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

    public static function recuperer_profil_utilisateur_par_id($id){
        $bdd = self::ouvrir_connexion();

        $requete = $bdd->prepare("SELECT id, login FROM utilisateurs WHERE id = :id");
        $requete->execute([
            'id' => $id
        ]);

        $resultat = $requete->fetch();

        if($resultat){
            $user = new Utilisateur($resultat['id'], $resultat['login']);
            return $user;
        }else{
            echo 'Id inconnu';
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

    public static function recuperer_contact_par_id($id){
        require_once 'inc/Contact.php';
        $bdd = self::ouvrir_connexion();

        $requete = $bdd->prepare("SELECT id, nom, prenom, telephone, email, description, id_utilisateur, id_entreprise FROM contacts WHERE id = :id");
        $requete->execute([
            'id' => $id
        ]);

        $resultat = $requete->fetch();

        if($resultat){
            // Le contact doit appartenir à l'utilisateur
            if($resultat['id_utilisateur'] == $_SESSION['idUtilisateur']){
                $contact = new Contact(
                    $resultat['id'],
                    $resultat['nom'],
                    $resultat['prenom'],
                    $resultat['telephone'],
                    $resultat['email'],
                    $resultat['description'],
                    $resultat['id_utilisateur'],
                    $resultat['id_entreprise']
                );

                return $contact;
            }
        }else{
            echo 'Contact inconnu';
        }
    }

    public static function get_contacts($id_utilisateur){
        require_once 'Contact.php';
        $bdd = Modele::ouvrir_connexion();

        $requete = $bdd->prepare(
            "SELECT id, nom, prenom, telephone, email, description, id_utilisateur, id_entreprise
             FROM contacts 
             WHERE id_utilisateur = :id_utilisateur"
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
                    $ligne->id,
                    $ligne->nom,
                    $ligne->prenom,
                    $ligne->telephone,
                    $ligne->email,
                    $ligne->description,
                    $ligne->id_utilisateur,
                    $ligne->id_entreprise
                );

                $contacts[] = $contact;
            }
        }

        Modele::fermer_connexion($bdd);

        return $contacts;
    }

    public static function get_entreprises(){
        $bdd = Modele::ouvrir_connexion();

        $requete = $bdd->prepare(
            "SELECT id, raison_sociale
             FROM entreprises"
        );

        $resultat = $requete->execute();
        
        if($resultat){
            $entreprises = $requete->fetchAll(PDO::FETCH_OBJ);
            Modele::fermer_connexion($bdd);
            return $entreprises;
        }
    }

    public static function get_raison_sociale_entreprise_par_id($id){
        $bdd = Modele::ouvrir_connexion();

        $requete = $bdd->prepare(
            "SELECT raison_sociale
             FROM entreprises
             WHERE id = :id"
        );

        $resultat = $requete->execute([
            'id' => $id
        ]);

        if($resultat){
            $entreprise = $requete->fetch(PDO::FETCH_OBJ);
            Modele::fermer_connexion($bdd);
            return $entreprise->raison_sociale;
        }
    }


    public static function creer_contact($contact){
        $bdd = self::ouvrir_connexion();

        // Afficher les erreurs
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        try{
            $requete = $bdd->prepare(
                'INSERT INTO contacts(id, nom, prenom, telephone, email, description, id_utilisateur, id_entreprise, date_creation) 
                 VALUES(DEFAULT, :nom, :prenom, :telephone, :email, :description, :id_utilisateur, :id_entreprise, now())'
            );

            $resultat = $requete->execute(array(
                'nom' => $contact->getNom(),
                'prenom' => $contact->getPrenom(),
                'telephone' => $contact->getTelephone(),
                'email' => $contact->getEmail(),
                'description' => $contact->getDescription(),
                'id_utilisateur' => $contact->getIdUtilisateur(),
                'id_entreprise' => $contact->getIdEntreprise()
            ));

            // Ajout OK
            if($resultat == 1){
                return true;
            }else{
                return false;
            }

        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public static function modifier_contact($contact){
        $bdd = self::ouvrir_connexion();

        // Afficher les erreurs
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        try{
            $requete = $bdd->prepare(
                'UPDATE contacts
                 SET nom = :nom, prenom = :prenom, telephone = :telephone, email = :email, description = :description,
                 id_entreprise = :id_entreprise
                 WHERE id = :id AND id_utilisateur = :id_utilisateur'
            );

            $resultat = $requete->execute(array(
                'id' => $contact->getId(),
                'nom' => $contact->getNom(),
                'prenom' => $contact->getPrenom(),
                'telephone' => $contact->getTelephone(),
                'email' => $contact->getEmail(),
                'description' => $contact->getDescription(),
                'id_utilisateur' => $_SESSION['idUtilisateur'],
                'id_entreprise' => $contact->getIdEntreprise()
            ));

            // Modification ok
            if($resultat == 1){
                return true;
            }else{
                return false;
            }

        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public static function supprimer_contact($idContact){
        // Récupère le contact en base
        $bdd = self::ouvrir_connexion();

        $requete = $bdd->prepare("SELECT id, id_utilisateur FROM contacts WHERE id = :id");

        $resultat = $requete->execute([
           ':id' => $idContact
        ]);

        // Vérifie si le contact appartient à la personne qui tente de supprimer

        if($resultat){
            $contact = $requete->fetch();
            if($contact['id_utilisateur'] == $_SESSION['idUtilisateur']){
                // Supprime le contact de la base
                $bdd->query("DELETE FROM contacts WHERE id = " . $idContact);

            }
        }
    }
}