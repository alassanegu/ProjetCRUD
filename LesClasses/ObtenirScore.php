<?php

require_once "AbstractEntite.php";

class ObtenirScore extends AbstractEntite
{
    protected $id_equipe;
    protected $id_match;
    protected $nbre_point;
    protected $nbre_essai;
    protected $nbre_penalite;
    protected $nbre_transforme;

    const TABLENAME = 'G03_SAISON';
    static $COLNAMES = array('id_equipe', 'id_match', 'nbre_point', 'nbre_essai', 'nbre_penalite', 'nbre_transforme');
    static $COLTYPES = array('number', 'number', 'number', 'number', 'number', 'number');
    static $PK = array('id_equipe', 'id_match');
    static $AUTOID = TRUE;
    static $FK = array('id_equipe', 'id_match');

    /**
     * @return int
     */
    public function getId_equipe(): int
    {
        return $this->id_equipe;
    }

    /**
     * @param int $id_equipe
     * @return ObtenirScore
     */
    public function setId_equipe(int $id_equipe): ObtenirScore
    {
        $this->id_equipe= $id_equipe;
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
     * @return ObtenirScore
     */
    public function setId_match(int $id_match): ObtenirScore
    {
        $this->id_match = $id_match;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbre_point(): int
    {
        return $this->nbre_point;
    }

    /**
     * @param int $nbre_point
     * @return ObtenirScore
     */
    public function setNbre_point(int $nbre_point): ObtenirScore
    {
        $this->nbre_point = $nbre_point;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbre_essai(): int
    {
        return $this->nbre_essai;
    }

    /**
     * @param int $nbre_essai
     * @return ObtenirScore
     */
    public function setNbre_essai(int $nbre_essai): ObtenirScore
    {
        $this->nbre_essai = $nbre_essai;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbre_penalite(): int
    {
        return $this->nbre_penalite;
    }

    /**
     * @param int $nbre_penalite
     * @return ObtenirScore
     */
    public function setNbre_penalite(int $nbre_penalite): ObtenirScore
    {
        $this->nbre_penalite = $nbre_penalite;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbre_transforme(): int
    {
        return $this->nbre_transforme;
    }

    /**
     * @param int $nbre_transforme
     * @return ObtenirScore
     */
    public function setNbre_transforme(int $nbre_transforme): ObtenirScore
    {
        $this->nbre_transforme = $nbre_transforme;
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
     * @return ObtenirScore
     */
    public function setPersistant(bool $p): ObtenirScore
    {
        $this->persistant = $p;
        return $this;
    }

    public function __toString()
    {
        return "object:ObtenirScore (".$this->id_equipe.", ".$this->id_match.", ".$this->nbre_point.", ".$this->nbre_essai.", ".$this->nbre_penalite.", ".$this->nbre_transforme.")";
    }
}

$o = new ObtenirScore();
$o->setId_equipe(3);
$o->setId_match(1);
$o->setNbre_point(10);
$o->setNbre_essai(1);
$o->setNbre_penalite(1);
$o->setNbre_transforme(1);
echo $o;