<?php

class Contact
{
    private $nom;
    private $prenom;
    private $telephone;
    private $email;

    public function __construct($nom, $prenom, $telephone, $email)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->telephone = $telephone;
        $this->email = $email;
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
}