<?php
//05-heritage/animal.php

class Animal
{
    protected function deplacement(){ // protected peut être utilisé dans les classes enfants
        return 'Je me déplace';
    }

    public function manger(){
        return 'Je mange';
    }
}
//----------------------------------------
class Elephant extends Animal
{
    public function quiSuisJe(){
        return 'Je suis un éléphant et ' . $this -> deplacement() . ' !';
        // je peux appeler la méthode deplacement avec this -> car on hérite également des méthodes protected
    }
}

class Chat extends Animal
{
    public function quiSuisJe(){
        return 'Je suis un chat !';
    }

    public function manger(){
        return 'Je mange peu...car je suis un chat !';
        // La fonction manger existe déjà dans la classe mère (Animal)... Mais puisque mon entité chat a des caractéristiques particulières (manger peu), on peut REDEFINIR une méthode héritée.
    }
}
//-------------------------------------------------------------------------
$eleph = new Elephant;
echo 'Elephant: ' . $eleph -> quiSuisJe() . '<br />';
echo 'Elephant: ' . $eleph -> manger() . '<hr />';

$chat = new Chat;
echo 'Chat: ' . $chat -> quiSuisJe() . '<br />';
echo 'Chat: ' . $chat -> manger() . '<hr />';

/*
Commentairres:
    L'héritage est un des fondements de la programmation objet.
    Lorsqu'une classe hérite d'une autre classe, elle importe tout le code. Les éléments sont donc appelés avec $this -> (à l'intérieur de la classe).

    Redéfinition: Une classe enfant (héritière) peut modifier ENTIEREMENT le comportement d'une méthode dont elle a héritée. Lors de l'exécution, l'interpréteur va dans un premier temps regarder dans la classe enfant si la méthode existe...puis dans la classe mère.

    REDEFINITION != SURCHARGE (voir chapitre 6)
*/