<?php
    function connexionControleur($twig, $db){
        $form = array();

        if(isset($_POST['btConnexion'])){
            $form['valide'] = true;
            $email = $_POST['email'];
            $password = $_POST['password'];
            $utilisateur = new Utilisateur($db);

            $unUtilisateur = $utilisateur->connect($email);
            
            if($unUtilisateur!=null){
                if(!password_verify($password,$unUtilisateur['mdp'])){
                    $form['valide'] = false;
                    $form['message'] = 'Login ou mot de passe incorrect';
                } else {
                    $_SESSION['login'] = $email;
                    $_SESSION['role'] = $unUtilisateur['idRole'];
                    $_SESSION['prenom'] = $unUtilisateur['prenom'];
                    $_SESSION['nom'] = $unUtilisateur['nom'];
                    $_SESSION['id'] = $unUtilisateur['id'];
                    $_SESSION['dateInscription'] = $unUtilisateur['dateInscription'];
                    
                    header("Location:index.php");
                }
            } else {
                $form['valide'] = false;
                $form['message'] = 'Login ou mot de passe incorrect';
            }
        }
        
        echo $twig->render('connexion.html.twig', array('form'=>$form));
    }

    function deconnexionControleur($twig, $db){
        $email = $_SESSION['login'];
        $utilisateur = new Utilisateur($db);

        $unUtilisateur = $utilisateur->disconnect($email);
        session_unset();
        session_destroy();
        header("Location:index.php");
    }
?>