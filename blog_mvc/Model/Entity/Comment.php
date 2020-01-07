<?php

namespace App\Model\Entity;

use App\Library\Entity;

class Comment extends Entity
{
    protected $news,
              $auteur,
              $contenu,
              $date;

    const AUTEUR_INVALIDE = 1;
    const CONTENU_INVALIDE = 2;

    public function isValid()
    {
      return !(empty($this->auteur) || empty($this->contenu));
    }
    
    // ***** GETTERS *****
    
    public function getNews() {
        return $this->news;
    }

    public function getAuteur() {
        return $this->auteur;
    }

    public function getContenu() {
        return $this->contenu;
    }

    public function getDate() {
        return $this->date;
    }
    
    // ***** SETTERS *****
    
    public function setNews($news) {
        $this->news = (int) $news;
        return $this;
    }

    public function setAuteur($auteur) {
        if (!is_string($auteur) || empty($auteur))
        {
          $this->erreurs[] = self::AUTEUR_INVALIDE;
        }
        $this->auteur = $auteur;
        return $this;
    }

    public function setContenu($contenu) {
        if (!is_string($contenu) || empty($contenu))
        {
          $this->erreurs[] = self::CONTENU_INVALIDE;
        }
        $this->contenu = $contenu;
        return $this;
    }

    public function setDate(\DateTime $date) {
        $this->date = $date;
        return $this;
    }
  
}