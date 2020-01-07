<?php
namespace App\Library;
//J'ai modifié cette class pour l'adapter à des getter écrit avec get... possible qu'il y ait des bug car pas encore testé.
abstract class Entity implements \ArrayAccess
{
    // Utilisation du trait Hydrator pour que nos entités puissent être hydratées
    use Hydrator;
    protected $erreurs = [],
              $id;

    public function __construct(array $donnees = [])
    {
        if (!empty($donnees))
        {
            $this->hydrate($donnees);
        }
    }

    public function isNew()
    {
        return empty($this->id);
    }

    public function getErreurs()
    {
        return $this->erreurs;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function offsetGet($var)
    {
        $method = 'get'.ucfirst($var);
        
        if (isset($this->$var) && is_callable([$this, $method]))
        {
            return $this->$method();
        }
    }

    public function offsetSet($var, $value)
    {
        $method = 'set'.ucfirst($var);

        if (isset($this->$var) && is_callable([$this, $method]))
        {
            $this->$method($value);
        }
    }

    public function offsetExists($var)
    {
        $method = 'get'.ucfirst($var);
        return isset($this->$method()) && is_callable([$this, $method]);
    }

    public function offsetUnset($var)
    {
        throw new \Exception('Impossible de supprimer une quelconque valeur');
    }
}