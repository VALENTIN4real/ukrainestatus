<?php
    class Article{
        private $db;
        private $selectArticle;
        private $selectUnArticle;
        private $insertArticle;
        private $selectById;
        private $update;
        private $delete;

        public function __construct($db){
            $this->db = $db;
            $this->insertArticle = $this->db->prepare("INSERT INTO article(idAuteur, auteur, titre, contenu, dateArticle, heure, dateComplete) VALUES(:idAuteur, :auteur, :titreArticle, :contenuArticle, NOW(), NOW(), NOW())");
            $this->selectArticle = $this->db->prepare("SELECT id, auteur, idAuteur, titre, contenu, DATE_FORMAT(dateArticle, '%d/%m/%Y') AS dateArticle, heure FROM article ORDER BY dateComplete DESC");
            $this->selectUnArticle = $this->db->prepare("SELECT id, auteur, idAuteur, titre, contenu, DATE_FORMAT(dateArticle, '%d/%m/%Y') AS dateArticle, heure FROM article WHERE id=:id");
            $this->selectMesArticles =$this->db->prepare("SELECT id, auteur, idAuteur, titre, contenu, DATE_FORMAT(dateArticle, '%d/%m/%Y') AS dateArticle, heure FROM article WHERE idAuteur = $_SESSION[id] ORDER BY dateComplete DESC");
            $this->selectById = $this->db->prepare("SELECT id, titre, contenu FROM article WHERE id=:id");
            $this->update = $db->prepare("UPDATE article SET titre=:titre, contenu=:contenu WHERE id=:id");
            $this->delete = $db->prepare("DELETE FROM article WHERE id=:id");
        }

        public function insertArticle($idAuteur, $auteur, $titreArticle, $contenuArticle){
            $r = true;
            $this->insertArticle->execute(array(':idAuteur'=>$idAuteur, ':auteur'=>$auteur, ':titreArticle'=>$titreArticle, ':contenuArticle'=>$contenuArticle));
            
            if ($this->insertArticle->errorCode()!=0){
                print_r($this->insertArticle->errorInfo());
                $r=false;
            }
            
            return $r;
        }

        public function selectArticle(){
            $this->selectArticle->execute();
            
            if ($this->selectArticle->errorCode()!=0){
                print_r($this->selectArticle->errorInfo());
            }
            
            return $this->selectArticle->fetchAll();
        }

        public function selectUnArticle($id){
            $this->selectUnArticle->execute(array(':id'=>$id));
            if ($this->selectUnArticle->errorCode()!=0){
                print_r($this->selectUnArticle->errorInfo());
            }
            
            return $this->selectUnArticle->fetch();
        }

        public function selectMesArticles() {
            $this->selectMesArticles->execute();
            
            if ($this->selectMesArticles->errorCode()!=0){
                print_r($this->selectMesArticles->errorInfo());
            }
            
            return $this->selectMesArticles->fetchAll();
        }

        public function selectById($id){
            $this->selectById->execute(array(':id'=>$id));
            if ($this->selectById->errorCode()!=0){
                print_r($this->selectById->errorInfo());
            }
            
            return $this->selectById->fetch();
        }

        public function update($titreArticle, $contenuArticle, $id){
            $r = true;
            $this->update->execute(array(':titre'=>$titreArticle, ':contenu'=>$contenuArticle, ':id'=>$id));

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
    }
?>