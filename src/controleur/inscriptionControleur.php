<?php
    function inscriptionControleur($twig, $db){
        $form = array();

        if(isset($_POST['btInscription'])){
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];
            $role = $_POST['role'];
            $form['valide'] = true;

            if($password!=$password2){
                $form['valide'] = false;
                $form['message'] = 'Les mots de passes ne sont pas identiques, réessayez.';
            } else {
                $utilisateur = new Utilisateur($db);
                $exec = $utilisateur->insert($email, password_hash($password,PASSWORD_DEFAULT), $role, $nom, $prenom);
                
                if(!$exec){
                    $form['valide'] = false;
                    $form['message'] = 'Problème d\'insertion dans la table utilisateur';
                }
            }

            $form['email'] = $email;
            $form['nom'] = $nom;
            $form['prenom'] = $prenom;
        }
        echo $twig->render('inscription.html.twig', array('form'=>$form));
    }
?>