<?php
class Commentaire{

    public function __construct($db){
        $this->db = $db;
        $this->insertCommentaire = $this->db->prepare("INSERT INTO commentaire(pseudo, commentaire, idArticle, dateComplete) VALUES(:pseudo, :commentaire, :idArticle, NOW())");
        $this->selectCommentaire = $this->db->prepare("SELECT pseudo, commentaire, idArticle, dateComplete FROM commentaire WHERE idArticle=:idArticle ORDER BY dateComplete DESC");
        $this->delete = $db->prepare("DELETE FROM commentaire WHERE id=:id");
    }

    public function insertCommentaire($pseudo, $commentaire, $idArticle){
        $r = true;
        $this->insertCommentaire->execute(array(':pseudo'=>$pseudo, ':commentaire'=>$commentaire, ':idArticle'=>$idArticle));
        
        if ($this->insertCommentaire->errorCode()!=0){
            print_r($this->insertCommentaire->errorInfo());
            $r=false;
        }
        
        return $r;
    }

    public function selectCommentaire($idArticle){
        $this->selectCommentaire->execute(array(':idArticle'=>$idArticle));
        if ($this->selectCommentaire->errorCode()!=0){
            print_r($this->selectCommentaire->errorInfo());
        }
        
        return $this->selectCommentaire->fetchAll();
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