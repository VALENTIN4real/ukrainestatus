<?php
    class Utilisateur{
        private $db;
        private $insert;
        private $connect;
        private $disconnect;
        private $statutConnexion;
        private $statutDeconnexion;
        private $mkUserList;
        private $selectById;
        private $update;
        private $delete;
        private $getOnlineUsers;

        public function __construct($db){
            $this->db = $db;
            $this->insert = $this->db->prepare("INSERT INTO utilisateur(email,  mdp,  nom,  prenom, idRole, dateInscription, estConnecte) VALUES(:email, :mdp, :nom, :prenom, :role, NOW(), 0)");
            $this->connect = $this->db->prepare("SELECT id, email, mdp, idRole, nom, prenom, dateInscription FROM utilisateur WHERE email=:email");
            $this->statutConnexion = $this->db->prepare("UPDATE utilisateur SET estConnecte = 1 WHERE email=:email");
            $this->statutDeconnexion = $this->db->prepare("UPDATE utilisateur SET estConnecte = 0 WHERE email=:email");
            $this->mkUserList = $this->db->prepare("SELECT id, email, idRole, nom, prenom, DATE_FORMAT(dateInscription, '%d/%m/%Y') AS dateInscription FROM utilisateur ORDER BY id");
            $this->selectById = $this->db->prepare("SELECT nom, prenom, email, idRole, id FROM utilisateur WHERE id=:id");
            $this->update = $db->prepare("UPDATE utilisateur SET nom=:nom, prenom=:prenom, email=:email, idRole=:role WHERE id=:id");
            $this->delete = $db->prepare("DELETE FROM utilisateur WHERE id=:id");
            $this->getOnlineUsers = $db->prepare("SELECT prenom FROM utilisateur WHERE estConnecte = '1'");
        }

        public function insert($email, $mdp, $role, $nom, $prenom){
            $r = true;
            $this->insert->execute(array(':email'=>$email, ':mdp'=>$mdp, ':role'=>$role, ':nom'=>$nom,':prenom'=>$prenom));
            
            if ($this->insert->errorCode()!=0){
                print_r($this->insert->errorInfo());
                $r=false;
            }
            
            return $r;
        }

        public function connect($email){
            $unUtilisateur = $this->connect->execute(array(':email'=>$email));
            $statutUtilisateur = $this->statutConnexion->execute(array(':email'=>$email));
            if($this->connect->errorCode()!=0){
                print_r($this->connect->errorInfo());
            }

            return $this->connect->fetch();
        }

        public function disconnect($email){
            $statutUtilisateur = $this->statutDeconnexion->execute(array(':email'=>$email));
            return $this->statutDeconnexion->fetch();
        }

        public function mkUserList(){
            $this->mkUserList->execute();

            if($this->mkUserList->errorCode()!=0){
                print_r($this->mkUserList->errorInfo());
            }

            return $this->mkUserList->fetchAll();
        }

        public function selectById($id){
            $this->selectById->execute(array(':id'=>$id));
            if ($this->selectById->errorCode()!=0){
                print_r($this->selectById->errorInfo());
            }
            
            return $this->selectById->fetch();
        }

        public function update($nom, $prenom, $email, $role, $id){
            $r = true;
            $this->update->execute(array(':nom'=>$nom, ':prenom'=>$prenom, ':email'=>$email, ':role'=>$role, ':id'=>$id));

            if ($this->update->errorCode()!=0){
                print_r($this->update->errorInfo());
                $r = false;
            }

            return $r;
        }

        public function delete($id){
            $r = true;

            $this->delete->execute(array(':id'=>$id));

            if ($this->delete->errorCode()!=0){
                print_r($this->delete->errorInfo());
                $r = false;
            }

            return $r;
        }

        public function getOnlineUsers(){
            $this->getOnlineUsers->execute();

            if($this->getOnlineUsers->errorCode()!=0){
                print_r($this->getOnlineUsers->errorInfo());
            }

            return $this->getOnlineUsers->fetchAll();
        }
    }

?>