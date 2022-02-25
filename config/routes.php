<?php
    function getPage($db){
        $pages['accueil'] = "accueilControleur";
        $pages['contact'] = "contactControleur";
        $pages['inscription'] = "inscriptionControleur";
        $pages['connexion'] = "connexionControleur";
        $pages['deconnexion'] = "deconnexionControleur";
        $pages['profil'] = "profilControleur";
        $pages['nouvel_article'] = "nouvelArticleControleur";
        $pages['liste_articles'] = "listeArticlesControleur";
        $pages['mes_articles'] = "mesArticlesControleur";
        $pages['modif_article'] = "modifArticleControleur";
        $pages['utilisateurs'] = "utilisateursControleur";
        $pages['modif_user'] = "modifUtilisateurControleur";
        $pages['utilisateurs_en_ligne'] = "utilisateursEnLigneControleur";
        $pages['un_article'] = "unArticleControleur";

        if($db!=null){
            if (isset($_GET['page'])){
                $page = $_GET['page'];
            } else {
                $page = 'accueil';
            }

            if (isset($pages[$page])){
                $contenu = $pages[$page];
            } else {
                $contenu = $pages['accueil'];
            }
            return $contenu;
        } else {
            echo "site en maintenance";
        }
    }
?>