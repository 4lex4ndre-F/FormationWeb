<?php
//src/Model/ArticleModel.php_ini_loaded_file

namespace Model;

use PDO;

class ArticleModel extends Model
{
    // On renomme les fonction de Model.php afin de rendre leur nom plus facile à comprendre pour les objets de la classe ArticleModel
    public function getAllArticles(){
        return $this -> findAll();
    }

    public function getArticleById($id){
        return $this -> find($id);
    }

    public function deleteArticleById($id){
        return $this -> delete($id);
    }

    public function updateArticleById($id, $infos){
        return $this -> update($id, $infos);
    }

    public function registerArticle($infos){
        return $this -> register($infos);
    }

    //--------------------------------------------------------

    // requete qui récupère toutes les catégories :
    public function getAllCategories(){
        $requete = "SELECT DISTINCT categorie FROM article";
        $resultat = $this -> getDb() -> query($requete);

        $categories = $resultat -> fetchAll(PDO::FETCH_ASSOC);

        if(!$categories){
            return false;
        }
        else{
            return $categories;
        }
    }

    // requete qui récupère tous les enregistrements de la table article en fonction de la catégorie
    public function getAllArticlesByCategorie($categorie){
        $requete = "SELECT * FROM article WHERE categorie = :categorie";

        $resultat = $this -> getDb() -> prepare($requete);
        $resultat -> bindParam(':categorie', $categorie, PDO::PARAM_STR);
        $resultat -> execute();

        $resultat -> setFetchMode(PDO::FETCH_CLASS, 'Entity\Article');

        $articles = $resultat -> fetchAll();

        if(!$articles){
            return false;
        }
        else{
            return $articles;
        }        
    }
}