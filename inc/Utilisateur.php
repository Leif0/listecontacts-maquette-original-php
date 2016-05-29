<?php

/**
 * Created by PhpStorm.
 * User: Leif
 * Date: 27/05/2016
 * Time: 16:04
 */
class Utilisateur
{
    private $id;
    private $login;
    
    public function __construct($id, $login)
    {
        $this->id = $id;
        $this->login = $login;
    }

    public function getLogin(){
        return $this->login;
    }

    public function getId(){
        return $this->id;
    }
}