<?php
// APPEL DE INIT.INC.PHP
require("inc/init.inc.php");

// requete en-t^^ete tableau
$en_tete = $pdo->query("SELECT * FROM annuaire");
$nb_col = $en_tete->columnCount();


// Affichage sur la page
require("inc/header.inc.php");
require("inc/nav.inc.php");

?>

<div class="container">
    <div class="">

        <div class="starter-template">
            <h1><span class="glyphicon glyphicon-user"></span> Liste des contacts</h1>
            <div><?= $message ?></div>
        </div><!-- /.starter-template -->

        <?php

            // affichage de toutes les entrées dans un array
            echo '<table class="table table-hover">';

                // le header:
                echo '<thead>';
                    echo '<tr>';          
                        for ($i=0; $i < $nb_col ; $i++) { 
                            $col_table = $en_tete->getColumnMeta($i);
                            //echo '<pre>';  print_r($no['name']); echo '</pre>';
                            echo '<th>' . $col_table['name'] . '</th>';
                        }
                    echo '</tr>';
                echo '</thead>';

                // le reste du tableau:
                echo '<tbody>';
                
                echo '</tbody>';

            echo '</table>';
        ?>
            
    </div><!-- /.col-sm-6 col-sm-offset-3 -->
</div><!-- /.container -->