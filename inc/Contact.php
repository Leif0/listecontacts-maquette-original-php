<?php

class Contact
{
    private $id;
    private $nom;
    private $prenom;
    private $telephone;
    private $email;
    private $id_utilisateur;

    public function __construct($id = null, $nom, $prenom, $telephone, $email, $id_utilisateur)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->id_utilisateur = $id_utilisateur;
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

    public function getEmail(){
        return $this->email;
    }

    public function getIdUtilisateur(){
        return $this->id_utilisateur;
    }
}