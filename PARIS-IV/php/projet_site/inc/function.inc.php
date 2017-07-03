<?php

// fonction pour savoir si un utilisateur est connecté
function utilisateur_est_connecte()
{
    if(isset($_SESSION['utilisateur']))
    {
        // si l'indice utilisateur existe alors l'utilisateur est connecté car il est passé par la page de connexion
        return true; // on sort de la fonction et le return false en dessous ne sera pas pris en compte.
    }
    return false; // si on rentre pas dans le if, on retourne false.
}

// fonction pour savoir si un utilisateur est connecté mais aussi a la statut administrateur
function utilisateur_est_admin()
{
    if(utilisateur_est_connecte() && $_SESSION['utilisateur']['statut'] == 1)
    {
        return true;
    }
    return false;
}

// Création du panier
function creation_panier()
{
    if(!isset($_SESSION['panier']))
    {
        $_SESSION['panier'] = array();
        $_SESSION['panier']['id_article'] = array();
        $_SESSION['panier']['prix'] = array();
        $_SESSION['panier']['quantite'] = array();
        $_SESSION['panier']['titre'] = array();
    }
}

// function ajouter un article au panier
function ajouter_article_au_panier($id_article, $prix, $quantite, $titre)
{
    // avant d'ajouter, on verifie si l'article n'est pas déjà présent. si c'est le cas, on ne fait que modifier sa quantité.
    $position = array_search($id_article, $_SESSION['panier']['id_article']);
    // array_search() permet de vérifier si une valeur se trouve dans un tableau array. si c'est le cas, on récupère l'indice correspondant.

    if($position !== FALSE) // article déjà présent
    {
        $_SESSION['panier']['quantite'][$position] += $quantite;
    }
    else{
        $_SESSION['panier']['quantite'][] = $quantite;
        $_SESSION['panier']['id_article'][] = $id_article;
        $_SESSION['panier']['prix'][] = $prix;
        $_SESSION['panier']['titre'][] = $titre;
    }
}

/* fonction pour savoir si un utilisateur est connecté mais aussi a la statut administrateur
function utilisateur_est_admin_test()
{
    if(utilisateur_est_connecte() && $_SESSION['utilisateur']['statut'] == 1)
    {
        $retour = array();
        $retour['statut'] = true;

        return true;
    }
    return false;
}
*/