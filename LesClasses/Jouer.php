<?php

require_once "AbstractEntite.php";

class Jouer  extends AbstractEntite
{
    protected $id_joueur;
    protected $id_match;
    protected $essais_joueur;
    protected $position;
    protected $penalite;

    const TABLENAME = 'G03_SAISON';
    static $COLNAMES = array('id_joueur', 'id_match', 'essais_joueur', 'position', 'penalite');
    static $COLTYPES = array('number', 'number', 'number', 'text', 'number');
    static $PK = array('id_joueur', 'id_match');
    static $AUTOID = TRUE;
    static $FK = array('id_joueur', 'id_match');

    /**
     * @return int
     */
    public function getId_joueur(): int
    {
        return $this->id_joueur;
    }

    /**
     * @param int $id_joueur
     * @return Jouer
     */
    public function setId_joueur(int $id_joueur): Jouer
    {
        $this->id_joueur = $id_joueur;
        return $this;
    }

    /**
     * @return int
     */
    public function getId_match(): int
    {
        return $this->id_match;
    }

    /**
     * @param int $id_match
     * @return Jouer
     */
    public function setId_match(int $id_match): Jouer
    {
        $this->id_match = $id_match;
        return $this;
    }

    /**
     * @return int
     */
    public function getEssais_joueur(): int
    {
        return $this->essais_joueur;
    }

    /**
     * @param int $essais_joueur
     * @return Jouer
     */
    public function setEssais_joueur(int $essais_joueur): Jouer
    {
        $this->essais_joueur = $essais_joueur;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return Jouer
     */
    public function setPosition(int $position): Jouer
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return int
     */
    public function getPenalite(): int
    {
        return $this->penalite;
    }

    /**
     * @param int $penalite
     * @return Jouer
     */
    public function setPenalite(int $penalite): Jouer
    {
        $this->penalite = $penalite;
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
     * @return Jouer
     */
    public function setPersistant(bool $p): Jouer
    {
        $this->persistant = $p;
        return $this;
    }

    public function __toString()
    {
        return "object:Jouer (".$this->id_joueur.", ".$this->id_match.", ".$this->essais_joueur.", ".$this->position.", ".$this->penalite.")";
    }
}

$j = new Jouer();
$j->setId_joueur(13);
$j->setId_match(1);
$j->setEssais_joueur(2);
$j->setPenalite(0);
echo $j;