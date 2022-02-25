<?php
    class Profil{
        private $db;
        private $getProfil;

        public function __construct($db){
            $this->db = $db;
            $this->getProfil = $this->db->prepare("SELECT id, email, idRole, nom, prenom, DATE_FORMAT(dateInscription, '%d/%m/%Y') AS dateInscription FROM utilisateur WHERE id=:idProfil");
        }

        public function getProfil($idProfil){
            $unProfil = $this->getProfil->execute(array(':idProfil'=>$idProfil));

            if($this->getProfil->errorCode()!=0){
                print_r($this->getProfil->errorInfo());
            }

            return $this->getProfil->fetch();
        }
    }

?>