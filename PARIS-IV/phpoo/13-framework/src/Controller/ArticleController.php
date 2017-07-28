<?php
//src/Controller/ArticleController.php

namespace Controller;

class ArticleController extends Controller
{
    // Via l'héritage avec Controller, j'ai accès à getModel() et à render().

    // autant de fonctions que d'action possible

    // Affichage de la page boutique
    public function afficheAll(){
        // 1 : Récupérer tous les produits
        // 2 : Récupérer totutes les catégories
        // 3 : Envoyer la vue boutique.php (plus tard ce sera boutique.html)

        $articles = $this -> getModel() -> getAllArticles();
        $categories = $this -> getModel() -> getAllCategories();

        $params = array(
            'articles' => $articles,
            'categories' => $categories,
            'title' => 'Ma super Boutique'
        );

        return $this -> render('layout.html', 'boutique.html', $params);


    }

    // Affichage d'une page article
    public function affiche($id){
        // 1 : Récupérer l'article'
        // 1.2: Récupérer toutes les suggestions de produit
        // 2 : Afficher la vue fiche_produit.php

        $article = $this -> getModel() -> getArticleById($id);
        
        if(!$article){
            require __DIR__ . '/../../src/View/404.html';
        }else {
            $params = array(
                'article' => $article,
                'title' => 'Produit : ' . $article -> getTitre()
            );

            return $this -> render('layout.html', 'fiche_article.html', $params);
        }

    }

    // Affichage des articles d'une catégorie
    public function categorie($categorie){
        // 1 : Récupérer tous les articles d'une catégorie
        // 2 : Récupérer toutes les catégories
        // 3 : Envoyer la vue boutique.php
        if($articles){

            $articles = $this -> getModel() -> getAllArticlesByCategorie($categorie);
            $categories = $this -> getModel() -> getAllCategories();

            $params = array(
                'articles' => $articles,
                'categories' => $categories,
                'title' => 'Categorie de produit : ' . $categorie
            );

        return $this -> render('layout.html', 'boutique.html', $params);
        }
        else{
            require __DIR__ . '/../../src/View/404.html';
        }
    }

}