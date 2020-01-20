<?php

namespace App\Model\Entity;

class Comment
{
    protected $id;
    protected $post_id;
    protected $author;
    protected $comment;
    protected $comment_date;
    
    public function isValid(){
        //vérifie que le post_id est bien un nombre 
        //vérifie que l'auteur et le commentaire n'est pas vide
    }
    
    //***** GETTERS *****
    public function getId() {
        return $this->id;
    }

    public function getPost_id() {
        return $this->post_id;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getComment_date() {
        return $this->comment_date;
    }

    //***** SETTERS *****
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setPost_id($post_id) {
        $this->post_id = $post_id;
        return $this;
    }

    public function setAuthor($author) {
        $this->author = $author;
        return $this;
    }

    public function setComment($comment) {
        $this->comment = $comment;
        return $this;
    }

    public function setComment_date(\DateTime $comment_date) {
        $this->comment_date = $comment_date;
        return $this;
    }

  
}