<?php
namespace App\Model\Entity;

use App\Library\Entity;

class Post extends Entity
{
    protected $auteur,
              $titre,
              $contenu,
              $dateAjout,
              $dateModif;

    const AUTEUR_INVALIDE = 1;
    const TITRE_INVALIDE = 2;
    const CONTENU_INVALIDE = 3;

    public function isValid()
    {
      return !(empty($this->auteur) || empty($this->titre) || empty($this->contenu));
    }
    
    // ***** GETTERS *****
    
    public function getAuteur() {
        return $this->auteur;
    }

    public function getTitre() {
        return $this->titre;
    }

    public function getContenu() {
        return $this->contenu;
    }

    public function getDateAjout() {
        return $this->dateAjout;
    }

    public function getDateModif() {
        return $this->dateModif;
    }

    // ***** SETTERS *****
    
    public function setAuteur($auteur) {
        if (!is_string($auteur) || empty($auteur))
        {
          $this->erreurs[] = self::AUTEUR_INVALIDE;
        }
        $this->auteur = $auteur;
        return $this;
    }

    public function setTitre($titre) {
        if (!is_string($titre) || empty($titre))
        {
          $this->erreurs[] = self::TITRE_INVALIDE;
        }
        $this->titre = $titre;
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

    public function setDateAjout(\DateTime $dateAjout) {
        $this->dateAjout = $dateAjout;
        return $this;
    }

    public function setDateModif(\DateTime $dateModif) {
        $this->dateModif = $dateModif;
        return $this;
    }
}