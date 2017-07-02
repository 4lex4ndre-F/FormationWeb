<style>
	* { font-family: sans-serif; }
	h3 { padding: 10px; background-color: darkred; color: white; }
</style>
<?php
// récupérer 5 images sur le web et les rennomer de cette façon:
// image1.jpg
// image2.jpg
// image3.jpg
// image4.jpg
// image5.jpg
// pixabay.com

// 1 - afficher une image avec une balise <img />
// 2 - afficher une image 5 fois toujours en écrivant 1 seule balise <img />
// 3 - afficher les 5 images différentes toujours en écrivant une seule balise <img />

echo '<h3>1 - afficher une image avec une balise img </h3>';
echo '<img src="image1.jpg" width="300" />';

echo '<h3>2 - afficher une image 5 fois toujours en écrivant 1 seule balise img </h3>';

for($i = 1; $i <= 5; $i++)
{
	echo '<img src="image1.jpg" width="300" />';
}

echo '<h3>3 - afficher les 5 images différentes toujours en écrivant une seule balise img </h3>';

for($i = 1; $i <= 5; $i++)
{
	echo '<img src="image' . $i . '.jpg" width="300" />';
}












