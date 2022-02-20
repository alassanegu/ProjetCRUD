<?php

require_once "AbstractEntite.php";

class Equipe extends AbstractEntite
{
    protected $id_equipe;
    protected $nom_equipe;

    const TABLENAME = 'G03_EQUIPE';
    static $COLNAMES = array('id_equipe', 'nom_equipe');
    static $COLTYPES = array('number', 'text');
    static $PK = array('id_equipe');
    static $AUTOID = TRUE;
    static $FK = array();

    /**
    * @return int
    */
    public function getId_equipe(): int
    {
        return $this->id_equipe;
    }

    /**
     * @param int $id_equipe
     * @return Equipe
     */
    public function setId_equipe(int $id_equipe): Equipe
    {
        $this->id_equipe = $id_equipe;
        return $this;
    }

    /**
     * @return string
     */
    public function getNom_equipe(): string
    {
        return $this->nom_equipe;
    }

    /**
     * @param string $nom_equipe
     * @return Equipe
     */
    public function setNom_equipe(string  $nom_equipe): Equipe
    {
        $this->nom_equipe = $nom_equipe;
        return $this;
    }

    /**
     * @return bool
     */
    public function getPersistant(): bool
    {
        return $this->persistant;
    }

    /**
     * @param bool $p
     * @return Equipe
     */
    public function setPersistant(bool $p): Equipe
    {
        $this->persistant = $p;
        return $this;
    }

    public function __toString()
    {
        return "object:Equipe (".$this->id_equipe.", ".$this->nom_equipe.")";
    }
}

$fr = new Equipe();
$fr->setId_equipe(2);
$fr->setNom_equipe("France");
echo $fr;
