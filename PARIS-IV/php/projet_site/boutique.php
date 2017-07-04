<?php
require("inc/init.inc.php");



// requetes tous les articles && filtre par catégorie
if(empty($_GET['categorie']))
{
    $liste_article = $pdo->query("SELECT * FROM article");
}
else
{
    $cat = $_GET['categorie'];
    $liste_article = $pdo->prepare("SELECT * FROM article WHERE categorie = :categorie");
    $liste_article->bindParam(":categorie", $cat, PDO::PARAM_STR);
    $liste_article->execute();
}


// requete toutes les categories
$liste_categorie = $pdo->query("SELECT DISTINCT categorie FROM article");


/******************************************************************************************************
                                        RECHERCHE
******************************************************************************************************/
// déclaration d'une variable de récupération du terme recherché
$demande = "";
$nb_resultats = 0;

// vérification de la demande par l'utilisateur d'une recherche sur mot clé
if(isset($_POST['recherche']) && !empty($_POST['recherche']))
{
    $message .= '<div class="alert alert-success" role="alert" style="margin-top: 20px;">Vous avez recherché le terme "' . $_POST['recherche'] . '"</div>';
    $demande = '%' . $_POST['recherche'] . '%';
    echo '<pre>'; print_r($demande); echo '</pre>';
}

// préparation d'une requete
$req = $pdo->prepare("SELECT * FROM article WHERE titre LIKE :titre OR description LIKE :description");
$req->bindParam(':titre',$demande, PDO::PARAM_STR);
$req->bindParam(':description',$demande, PDO::PARAM_STR);
$req->execute();

    /*while($requete = $req->fetch(PDO::FETCH_ASSOC))
    {
        // nbre de résultat de la recherche
        $nb_resultats = count($req);
        echo '<pre>'; print_r($requete); echo '</pre>';
        for($i = 0; $i < $nb_resultats; $i++)
        {

        }    
    }*/



// la ligne suivante commence les affichages dans la page
require("inc/header.inc.php");
require("inc/nav.inc.php");
?>



    <div class="container">

        <div class="starter-template">
            <h1>Boutique</h1>
            <?php //echo $message; // messages destinés à l'utilisateur ?>
            <?= $message; // cette balise php inclue un echo, elle est équivalente à la ligne du dessus ?>
        </div>

        <div class="row">
            <!-- menu latéral -->
            <div class="col-sm-2">
                <?php
                    // récupérer toutes les catégories en BDD et les afficher dans une liste ul li sous forme de liens href avec une information GET par exemple: ?categorie=pantalon

                    
                    echo '<ul class="list-group">';
                    echo '<li class="list-group-item"><a href="boutique.php">Tous les articles</a></li>';
                    while($liste = $liste_categorie->fetch(PDO::FETCH_ASSOC))
                    {
                        // echo '<pre>'; print_r($liste); echo '</pre>';
                        echo '<li class="list-group-item"><a href="?categorie=' . $liste['categorie'] .'">' . $liste['categorie'] . '</a></li>';
                    }
                    echo '</ul>';
                    echo '<hr />';
                    echo    '<form action="" method="post">
                                <div class="form-group">
                                    <label for="recherche" class="recherche" ><span class="glyphicon glyphicon-search"></span>  Rechercher un mot</label>
                                    <input type="text" class="form-control" name="recherche" id="recherche" />
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="form-control btn btn-primary" value="Rechercher" name="bouton" id="bouton" />
                                </div>
                            </form>';

                ?>
            </div><!-- /menu lateral -->
        

            <!-- articles -->
            <div class="col-sm-10">
                <?php
                    // vérification de la demande par l'utilisateur d'une recherche sur mot clé
                    if(isset($_POST['recherche']) && !empty($_POST['recherche']))
                    {
                        $message .= '<div class="alert alert-success" role="alert" style="margin-top: 20px;">Vous avez recherché le terme "' . $_POST['recherche'] . '"</div>';
                        $demande = $_POST['recherche'];                        
                        echo '<pre>'; print_r($demande); echo '</pre>';

                        // afficher tous les élément comprenant les mots recherchés
                        echo '<div class="row">';
                        $compteur ="";
                        while($article = $req->fetch(PDO::FETCH_ASSOC))
                        {
                            // afin de ne pas avoir de soucis avec le float, on ferme et on ouvre une ligne bootstrap (class="row") pour gérer les lignes d'afffichage
                            if($compteur%4 == 0 && $compteur != 0) { echo '</div><div class="row">'; }
                            $compteur ++;                            

                            echo '<div class="col-sm-3">';
                            echo '<div class="panel panel-default">';
                            echo '<div class="panel-body text-center">';
                            echo '<h5>' . $article['titre'] . '</h5>';
                            echo '<img src="' . URL . 'photo/' . $article['photo'] . '" class="img-responsive" />';
                            echo '<br /><p><b>Prix :</b>' . $article['prix'] . '€</p>';
                            echo '<hr />';
                            echo '<a href="fiche_article.php?id_article=' . $article['id_article'] . '" class="btn btn-primary">Voir la fiche article</a>';
                            echo '</div></div></div>';
                        }
                        echo '</div>'; 

                    }
                    else
                    {                   
                        // afficher tous les produits dans cette page par exemple: un block avec image + titre + prix produit                    
                        echo '<div class="row">';
                            $compteur ="";
                            while($article = $liste_article->fetch(PDO::FETCH_ASSOC))
                            {
                                // afin de ne pas avoir de soucis avec le float, on ferme et on ouvre une ligne bootstrap (class="row") pour gérer les lignes d'afffichage
                                if($compteur%4 == 0 && $compteur != 0) { echo '</div><div class="row">'; }
                                $compteur ++;

                                echo '<div class="col-sm-3">';
                                echo '<div class="panel panel-default">';
                                echo '<div class="panel-body text-center">';
                                echo '<h5>' . $article['titre'] . '</h5>';
                                echo '<img src="' . URL . 'photo/' . $article['photo'] . '" class="img-responsive" />';
                                echo '<br /><p><b>Prix :</b>' . $article['prix'] . '€</p>';
                                echo '<hr />';
                                echo '<a href="fiche_article.php?id_article=' . $article['id_article'] . '" class="btn btn-primary">Voir la fiche article</a>';
                                echo '</div></div></div>';
                            }
                        echo '</div>';  
                    }              
                ?>
            </div>
        </div>


    </div><!-- /.container -->

    <?php
    require("inc/footer.inc.php");