<?php

    function utilisateursControleur($twig, $db){
        $form = array();
        $utilisateur = new Utilisateur($db);
        $userList = $utilisateur->mkUserList();

        if (isset($_GET['id'])){
            $exec=$utilisateur->delete($_GET['id']);

            if (!$exec){
                $etat = false;
            } else {
                $etat = true;
            }

            header('Location:index.php?page=utilisateurs&etat='.$etat);
            exit;
        }

        if(isset($_GET['etat'])){
            $form['etat'] = $_GET['etat'];
        }

        $userList = $utilisateur->mkUserList();
        echo $twig->render('utilisateurs.html.twig', array('form'=>$form, 'userList'=>$userList));
    }

    function modifUtilisateurControleur($twig, $db){
        $form = array();

        if(isset($_GET['id'])){
            $utilisateur = new Utilisateur($db);
            $unUtilisateur = $utilisateur->selectById($_GET['id']);

            if ($unUtilisateur!=null){
                $form['utilisateur'] = $unUtilisateur;
            } else {
                $form['message'] = 'Utilisateur incorrect';
            }
        } else {
            if(isset($_POST['btModifierUtilisateur'])){
                $utilisateur = new Utilisateur($db);
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $email = $_POST['email'];
                $role = $_POST['role'];
                $id = $_POST['id'];

                $exec=$utilisateur->update($nom, $prenom, $email, $role, $id);

                if(!$exec){
                    $form['valide'] = false;
                    $form['message'] = 'Echec de la modification';
                } else {
                    $form['valide'] = true;
                    $form['message'] = 'Modification réussie';
                }
            } else {
                $form['message'] = 'Utilisateur non spécifié';
            }
        }

        echo $twig->render('modif_user.html.twig', array('form'=>$form));
    }

    function utilisateursEnLigneControleur($twig, $db){
        $form = array();
        $utilisateur = new Utilisateur($db);
        $onlineUserList = $utilisateur->getOnlineUsers();
        echo $twig->render('utilisateurs_en_ligne.html.twig', array('form'=>$form, 'onlineUserList'=>$onlineUserList));
    }
?>