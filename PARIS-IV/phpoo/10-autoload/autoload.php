<?php
//10-autoload/autoload.php

function inclusion_automatique($className){ // normalement dans une classe (procédural pour l'exemple).

    // La classe A est dans le fichier A.class.php
    require $className . '.class.php';

    //----------------------------------------------
    echo 'On passe dans l\'autoload<br/>';
    echo 'On fait un : require "' . $className . '.class.php"<br/>';
}

//---------------------------------------------------
spl_autoload_register('inclusion_automatique');
//---------------------------------------------------
/*
Commentaires :
    spl_autoload_register :
        - Est une fonction super pratique qui va s'exécuter lorsqu'elle voit passer le mot clé "new".
        - Elle va lancer une fonction...celle que je vais lui préciser en argument.
        - Elle va apporter à ma fonction le mot qui suit le(s) mot(s) clé "new" --> cad le nom de la classe !

*/