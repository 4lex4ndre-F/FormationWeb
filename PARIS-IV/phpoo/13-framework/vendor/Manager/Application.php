<?php
// vendor/Manager/Application.php_ini_loaded_file

namespace Manager;

final class Application
{

    private $controller;
    private $action;
    private $argument = "ddd";

    // La fonction construct() va récupérer les infos dans l'URL et les stocker
    //index.php?controller=article&action=afficheall
    //index.php?controller=article&action=affiche&id=6
    //index.php?controller=membre&action=inscription


    public function __construct(){

        if(isset($_GET['controller'])){
            if(file_exists(__DIR__ . '/../../src/Controller/' . ucfirst($_GET['controller']) . 'Controller.php') ){

                $this -> controller = 'Controller\\' . ucfirst($_GET['controller']) . 'Controller';
                // Si le controlleur existe bien dans mon dossier controller alors je stocke son "nom" dans ma propriété $controller.
            }
            else{
                // Sinon j'affiche la page 404
                require __DIR__ . '/../../src/View/404.html';
            }
        }
        else{
            $this -> controller = 'Controller\ArticleController';
            $this -> action = 'afficheAll';
            // Cela correspond finalement à notre homepage
        }

        // Récupération de l'action (méthode) à exécuter :
        if(isset($_GET['action'])){
            $this -> action = $_GET['action'];
            // S'il y a une action je stocke
        }
        else{
            $this -> controller = 'Controller\ArticleController';
            $this -> action = 'afficheAll';
            // Cela correspond finalement à notre homepage
        }

        // Récupération de l'id s'il y en a un
        if(isset($_GET['id']) && !empty($_GET['id']) ){
            $this -> argument = (int) $_GET['id'];
        }

        // Récupération de la catégorie s'il y en a une
        if(isset($_GET['cat']) && !empty($_GET['cat']) ){
            $this -> argument = (string) $_GET['cat'];
        }

        // récupération du terme de recherche qui sera passé en POST :
        if(isset($_POST['recherche']) && !empty($_POST['search']) ){
            // "recherche" sera le name de note input type submit
            // "search" sera le name de note input type text ou search (ajoute un bouton pour vider le champ).
            $this -> controller = "Controller\ArticleController";
            $this -> action = 'rechercher';
            $this -> argument = $_POST('search');
        }
    }

    // La fonction run() va instancier le bon controller, et lancer la bonne action (méthode)
    public function run(){

        if(!is_null($this -> controller)){
            $a = new $this -> controller;
            // J'instancie le controleur demandé dont on avait stocké le nom dans $this -> controlleur

            if(!is_null($this -> action) && method_exists($a, $this -> action) ){
                // Si $this -> action n'est pas null et que la méthode existe dans mon objet $a.

                $action = $this -> action;
                if(!is_null($this -> argument)){
                    $a -> $action($this -> argument);
                    //$a -> affiche(6)
                    //$a -> affiche(chemise)
                }
                else{
                    $a -> $action();
                    //$a -> afficheAll();
                }

            }
            else{
            // Sinon j'affiche la page 404
            require __DIR__ . '/../../src/View/404.html';
            }
        }
        else{
            // Sinon j'affiche la page 404
            require __DIR__ . '/../../src/View/404.html';
        }
    }
}