<?php
namespace App\Model\Entity;

class Post 
{
    protected $id;
    protected $title;
    protected $content;
    protected $creation_date;
    
    public function isValid(){
        return !(empty($this->title) || empty($this->content));
    }
    
    // ***** GETTERS *****
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getCreation_date() {
        return $this->creation_date;
    }

    //***** SETTERS *****
    
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function setCreation_date(\DateTime $creation_date) {
        $this->creation_date = $creation_date;
        return $this;
    }
    
}