<?php

require_once "AbstractEntite.php";

class Match  extends AbstractEntite
{
    protected $id_match;
    protected $date_match;
    protected $id_saison;
    protected $tour;

    const TABLENAME = 'G03_SAISON';
    static $COLNAMES = array('id_match', 'date_match', 'id_saison', 'tour');
    static $COLTYPES = array('number', 'date', 'number', 'number');
    static $PK = array('id_match');
    static $AUTOID = TRUE;
    static $FK = array('id_saison');

    /**
     * @return int
     */
    public function getId_match(): int
    {
        return $this->id_match;
    }

    /**
     * @param int $id_match
     * @return Match
     */
    public function setId_match(int $id_match): Match
    {
        $this->id_match = $id_match;
        return $this;
    }

    /**
     * @return int
     */
    public function getDate_match(): int
    {
        return $this->date_match;
    }

    /**
     * @param String $date_match
     * @return Match
     */
    public function setDate_match(String $date_match): Match
    {
        $this->date_match = $date_match;
        return $this;
    }

    /**
     * @return int
     */
    public function getId_saison(): int
    {
        return $this->id_saison;
    }

    /**
     * @param String $id_saison
     * @return Match
     */
    public function setId_saison(String $id_saison): Match
    {
        $this->id_saison = $id_saison;
        return $this;
    }

    /**
     * @return int
     */
    public function getTour(): int
    {
        return $this->tour;
    }

    /**
     * @param int $tour
     * @return Match
     */
    public function setTour(int $tour): Match
    {
        $this->tour = $tour;
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
     * @return Match
     */
    public function setPersistant(bool $p): Match
    {
        $this->persistant = $p;
        return $this;
    }

    public function __toString()
    {
        return "object:Match (".$this->id_match.", ".$this->date_match.", ".$this->id_saison.", ".$this->tour.")";
    }
}

$m = new Match();
$m->setId_match(1);
$m->setDate_match('2021-02-06');
$m->setId_saison(22);
$m->setTour(1);
echo $m;