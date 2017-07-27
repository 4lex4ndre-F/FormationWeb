<?php
//app/config.php

class Config
{
    protected $parameters;

    public function __construct(){
        require __DIR__ . '/Config/parameters.php';
        $this -> parameters = $parameters;
        // au moment où j'instancierai ma classe Config, je récupère les paramètres du site pour les stocker dans $parameters.
    }

    public function getParametersConnect(){
        return $this -> parameters['connect'];
        // cette fonction me retourne seulement la partie connexion des paramètres. elle sera utile à PDOManager.
    }
}
//-------------------------------------------------------------
//$config = new Config;
//echo '<pre>'; print_r($config -> getParametersConnect()); echo '</pre>';
// il faut instancier avant de tester trouduc !