<?php
    function nouvelArticleControleur($twig, $db){
        $formArticle = array();
        if(isset($_POST['btArticle'])){
            $idAuteur = $_SESSION['id'];
            $auteur = $_SESSION['prenom'];
            $titreArticle = $_POST['titreArticle'];
            $contenuArticle = $_POST['contenuArticle'];
            $formArticle['valide'] = true;
            $lienArticle = $_POST['lienArticle'];
            $lienImage = $_POST['lienImage'];

            $unArticle = new Article($db);
            $exec = $unArticle->insertArticle($idAuteur, $auteur, $titreArticle, $contenuArticle, $lienArticle, $lienImage);
            
            if(!$exec){
                $formArticle['valide'] = false;
                $formArticle['message'] = 'Problème d\'insertion dans la table article';
            }

            $formArticle['idAuteur'] = $idAuteur;
            $formArticle['auteur'] = $auteur;
            $formArticle['titre'] = $titreArticle;
            $formArticle['contenu'] = $contenuArticle;
            $formArticle['lien'] = $lienArticle;
            $formArticle['lienImage'] = $lienImage;
        }
        echo $twig->render('nouvel_article.html.twig', array('formArticle'=>$formArticle));
        
    }

    function listeArticlesControleur($twig, $db){
        $form = array();
        $article = new Article($db);

        if (isset($_GET['id'])){
            $exec=$article->delete($_GET['id']);

            if (!$exec){
                $etat = false;
            } else {
                $etat = true;
            }

            header('Location:index.php?page=liste_articles&etat='.$etat);
            exit;
        }

        if(isset($_GET['etat'])){
            $form['etat'] = $_GET['etat'];
        }

        $listeArticles = $article->selectArticle();
        echo $twig->render('liste_articles.html.twig', array('form'=>$form,'listeArticles'=>$listeArticles));
    }

    function mesArticlesControleur($twig, $db){
        $form = array();
        $article = new Article($db);

        if (isset($_GET['id'])){
            $exec=$article->delete($_GET['id']);

            if (!$exec){
                $etat = false;
            } else {
                $etat = true;
            }

            header('Location:index.php?page=mes_articles&etat='.$etat);
            exit;
        }

        if(isset($_GET['etat'])){
            $form['etat'] = $_GET['etat'];
        }
        $listeMesArticles = $article->selectMesArticles();
        echo $twig->render('mes_articles.html.twig', array('form'=>$form,'listeMesArticles'=>$listeMesArticles));
    }

    function unArticleControleur($twig, $db){
        $form = array();

        if(isset($_GET['id'])){
            $article = new Article($db);
            $unArticle = $article->selectUnArticle($_GET['id']);

            if ($unArticle!=null){
                $form['article'] = $unArticle;
            } else {
                $form['message'] = 'Article incorrect';
            }
        }

        if(isset($_POST['btCommentaire'])){
            $idArticle = $_GET['id'];
            $pseudo = $_POST['pseudo'];
            $commentaire = $_POST['commentaire'];
            
            $unCommentaire = new Commentaire($db);
            $exec = $unCommentaire->insertCommentaire($pseudo, $commentaire, $idArticle);
            
            if(!$exec){
                $formCommentaire['valide'] = false;
                $formCommentaire['message'] = 'Problème d\'insertion dans la table Commentaire';
            }
            
            $formCommentaire['valide'] = true;
            $formCommentaire['idArticle'] = $idArticle;
            $formCommentaire['pseudo'] = $pseudo;
            $formCommentaire['commentaire'] = $commentaire;
        }

        $commentaire = new Commentaire($db);

        $listeCommentaires = $commentaire->selectCommentaire($_GET['id']);
        echo $twig->render('un_article.html.twig', array('form'=>$form, 'unArticle'=>$unArticle, 'formCommentaire'=>$formCommentaire, 'listeCommentaires'=>$listeCommentaires));
    }

    function modifArticleControleur($twig, $db){
        $form = array();

        if(isset($_GET['id'])){
            $article = new Article($db);
            $unArticle = $article->selectById($_GET['id']);

            if ($unArticle!=null){
                $form['article'] = $unArticle;
            } else {
                $form['message'] = 'Article incorrect';
            }
        } else {
            if(isset($_POST['btModifierArticle'])){
                $article = new Article($db);
                $titreArticle = $_POST['titreArticle'];
                $contenuArticle = $_POST['contenuArticle'];
                $lienArticle = $_POST['lienArticle'];
                $lienImage = $_POST['lienImage'];
                $id = $_POST['id'];

                $exec=$article->update($titreArticle, $contenuArticle, $lienArticle, $lienImage, $id);

                if(!$exec){
                    $form['valide'] = false;
                    $form['message'] = 'Echec de la modification';
                } else {
                    $form['valide'] = true;
                    $form['message'] = 'Modification réussie';
                }
            } else {
                $form['message'] = 'Article non spécifié';
            }
        }

        echo $twig->render('modif_article.html.twig', array('form'=>$form));
    }
?>