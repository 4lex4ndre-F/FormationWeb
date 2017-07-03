<?php
require("inc/init.inc.php");

// si on a cliqué sur vider le panier
if(isset($_GET['action']) && $_GET['action'] == 'delete')
{
    unset($_SESSION['panier']);
}

// création du panier
creation_panier();

// 
if(isset($_POST['ajout_panier']))
{
    // si l'indice existe dans post alors l'utilisateur a cliqué sur le bouton ajouter au panier (depuis la page fiche_article.php)
    $info_article = $pdo->prepare("SELECT * FROM article WHERE id_article = :id_article");
    $info_article->bindParam(":id_article", $_POST['id_article'], PDO::PARAM_STR);
    $info_article->execute();

    $article = $info_article->fetch(PDO::FETCH_ASSOC);

    // ajout de la tva sur le prix
    $article['prix'] = $article['prix'] * 1.2;

    ajouter_article_au_panier($_POST['id_article'], $article['prix'], $_POST['quantite'], $article['titre']);

    // on redirige vers la même page pour perdre les informations dans le post afin d'éviter que la touche F5 rajoute un article au panier.
    header("location:panier.php");
}





// la ligne suivante commence les affichages dans la page
require("inc/header.inc.php");
require("inc/nav.inc.php");
echo '<pre>'; print_r($_POST); echo '</pre>';
echo '<pre>'; print_r($_SESSION); echo '</pre>';
?>



    <div class="container">

        <div class="starter-template">
            <h1><span class="glyphicon glyphicon-shopping-cart"></span> Panier</h1>
            <?php //echo $message; // messages destinés à l'utilisateur ?>
            <?= $message; // cette balise php inclue un echo, elle est équivalente à la ligne du dessus ?>
        </div>

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">

            <table class="table table-bordered">
                <tr>
                    <th colspan="5">Panier</th>
                </tr>
                <tr>
                    <th>Article</th>
                    <th>Titre</th>
                    <th>Quantité</th>
                    <th>Prix unitaire TTC</th>
                    <th>Prix total</th>           
                </tr>
                <?php

                    // vérification si le panier est vide sur n'importe quel tableau array du dernier niveau
                    if(empty($_SESSION['panier']['id_article']))
                    {
                        echo '<tr><th colspan="5">Aucun article dans le panier</th></tr>';
                    }
                    else
                    {
                        // sinon on affiche tous les produits dans un tableau html sur n'importe quel tableau array du dernier niveau
                        $taille_tableau = sizeof($_SESSION['panier']['titre']);
                        for($i = 0; $i < $taille_tableau; $i++)
                        {
                            echo '<tr>';
                                echo '<td>' . $_SESSION['panier']['id_article'][$i] . '</td>';
                                echo '<td>' . $_SESSION['panier']['titre'][$i] . '</td>';
                                echo '<td>' . $_SESSION['panier']['quantite'][$i] . '</td>';
                                echo '<td>' . $_SESSION['panier']['prix'][$i] . ' €</td>';
                                echo '<td>' . $_SESSION['panier']['prix'][$i] * $_SESSION['panier']['quantite'][$i] . ' €</td>';
                            echo '</tr>';
                        }
                        // rajouter une ligne du tableau qui affiche un bouton vider le panier uniquement si le panier n'est pas vide. Et faire le traitement afin que si on clique sur le bouton, le panier se vide. unset()
                        echo '<tr>';
                            echo '<td colspan="5"><a class="btn btn-warning" href="?action=delete">Vider le panier</a></td>';
                        echo '</tr>';                        
                    }
                    // rajouter une ligne du tableau qui affiche un lien a href (?action=payer) pour payer le panier si l'utilisateur est connecté. Sinon proposer un texte pour proposer à l'utilisateur de s'inscrire ou de se connecter
                    if(utilisateur_est_connecte())
                    {
                        // ok bouton payer
                        echo '<tr>';
                            echo '<td colspan="2"><a class="btn btn-success" href="?action=payer">Payer</a></td>';
                            echo '<td colspan="2">Total:</td>';
                            echo '<td></td>';

                        echo '</tr>';
                    }
                    else{
                        // pas ok. s'inscrire, se connecter
                        echo '<tr>';
                            echo '<td colspan="2"><a class="btn btn-warning" href="inscription.php">S\'inscrire</a></td>';
                            echo '<td colspan="2"><a class="btn btn-warning" href="connexion.php">Se connecter</a></td>';
                        echo '</tr>';
                    }

                    // rajouter une ligne du tableau qui affiche un bouton vider le panier uniquement si le panier n'est pas vide. Et faire le traitement afin que si on clique sur le bouton, le panier se vide. unset()



                ?>
            </table>
            
            </div>
        </div><!-- /row -->
    </div><!-- /.container -->

    <?php
    require("inc/footer.inc.php");