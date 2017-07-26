<?php
//11-PDO/pdo.php

$pdo = new PDO('mysql:host=localhost;dbname=wf3_entreprise', 'root', '', array(
    //PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING // utilisable en developpement
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // utilisable en developpement
));

// interessant lors du developpement
try{
    // erreur de requete volontaire :
    $resultat = $pdo -> query("hfhzr");
}
catch(PDOException $e){
    echo '<div style="background: red; color: white; padding: 10px;">';
        echo 'Erreur SQL :<br/>';
        echo 'Message :' . $e -> getMessage() . '<br/>';
        echo 'Fichier :' . $e -> getFile() . '<br/>';
        echo 'Ligne :' . $e -> getLine() . '<br/>';
    echo '</div>';
    exit;
}
//----------------------------------

// Marqueur non nominatif - utile sur silex
// Exemple 1 : 1 seule valeur
$resultat = $pdo -> prepare("SELECT * FROM employes WHERE prenom = ?");
$resultat -> execute(array('Amandine'));

// Exemple 2 : plusieurs valeurs
$resultat= $pdo -> prepare("SELECT * FROM employes WHERE prenom = ? AND service = ? ");
$resultat -> execute(array('Amandine', 'communication'));


// Marqueur Nominatif
$resultat = $pdo -> prepare("SELECT * FROM employes WHERE prenom = :prenom AND service = :service");
$resultat -> execute(array(
    ':service' => 'communication',
    ':prenom' => 'Amandine' // les ":" sont facultatifs avec cette méthode, contrairement à bindParam.
));

// Query() + fetchAll à l'intérieur de la requête
$resultat = $pdo -> query("SELECT * FROM employes", PDO::FETCH_ASSOC);

echo '<pre>'; var_dump($resultat); echo '</pre>';

foreach($resultat as $valeur){
    echo 'Prenom: ' . $valeur['prenom'] . '<br/>';
}