<?php
    function profilControleur($twig, $db){
        $form = array();

        $idProfil = $_GET['profil_id'];

        $profil = new Profil($db);
        $unProfil = $profil->getProfil($idProfil);
        
        echo $twig->render('profil.html.twig', array('form'=>$form, 'profil'=>$unProfil));
    }
?>