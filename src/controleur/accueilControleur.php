<?php

    function accueilControleur($twig, $db){
        $form = array();
        $article = new Article($db);
        $listeArticles = $article->selectArticle();
        echo $twig->render('liste_articles.html.twig', array('form'=>$form,'listeArticles'=>$listeArticles));
    }
    
?>