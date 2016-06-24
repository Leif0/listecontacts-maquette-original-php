<?php

class Contact
{
    private $id;
    private $nom;
    private $prenom;
    private $telephone;
    private $email;
    private $description;
    private $id_utilisateur;
    private $id_entreprise;

    public function __construct($id = null, $nom, $prenom, $telephone, $email, $description = null, $id_utilisateur, $id_entreprise)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->description = $description;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_entreprise = $id_entreprise;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getPrenom(){
        return $this->prenom;
    }

    public function getTelephone(){
        return $this->telephone;
    }

    public function getIdEntreprise(){
        return $this->id_entreprise;
    }

    public function setIdEntreprise($idEntreprise){
        $this->id_entreprise = $idEntreprise;
    }

    public function getRaisonSocialeEntreprise(){
        return Modele::get_raison_sociale_entreprise_par_id($this->id_entreprise);
    }

    public function getEmail(){
        return $this->email;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getIdUtilisateur(){
        return $this->id_utilisateur;
    }
}