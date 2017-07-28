<?php
//vendor/autoload.php

class Autoload
{
    public static function inclusion_automatique($className){

        // Voilà ce qu'on attend de notre autoload :

        // new Controller\ArticleController
        // require "src/Controller/ArticleController.php"

        // new Entity\Article
        // require 'src/Entity/Article.php'

        // new controller\Controller
        // require 'vendor/Controller/Controller.php'

        // new Manager\PDOManager
        // require 'vendor/Manager/PDOManager.php'


        $tab = explode('\\', $className);

        if($tab[0] == 'Manager' 
            || 
            ($tab[0] == 'Controller' && $tab[1] == 'Controller') 
            || 
            ($tab[0] == 'Model' && $tab[1] == 'Model')){

                $path = __DIR__ . '/' . implode('/', $tab) . '.php'; // on reste dans vendor/

        }
        else{

                $path = __DIR__ . '/../src/' . implode('/', $tab) . '.php'; // on va dans src/

        }

        //-----En phase de dev' pour constater le chemin parcouru par l'autoload-----
        echo '<pre>Autoload: ' . $className . '<br/>';
        echo '==> require "' . $path . '"</pre>';
        //-----------------------------------------------------------------

        require $path;

    }
}

//------------------------------------------------------------------
spl_autoload_register(array('Autoload', 'inclusion_automatique'));
//------------------------------------------------------------------
/*
Commentaires:
    spl_autoload_register() en POO attend en argument un array avec les valeurs suivantes:
        1- le nom de la classe
        2- le nom de la méthode qui va être static (OBLIGATOIREMENT)
        ---> Autoload::inclusion_automatique($className);
*/