<?php

require_once "AbstractEntite.php";

class Saison extends AbstractEntite
{
    protected $id_saison;
    protected $annee_saison;

    const TABLENAME = 'G03_SAISON';
    static $COLNAMES = array('id_saison', 'annee_saison');
    static $COLTYPES = array('number', 'date');
    static $PK = array('id_saison');
    static $AUTOID = TRUE;
    static $FK = array();

    /**
     * @return int
     */
    public function getId_saison(): int
    {
        return $this->id_saison;
    }

    /**
     * @param int $id_saison
     * @return Saison
     */
    public function setId_saison(int $id_saison): Saison
    {
        $this->id_saison = $id_saison;
        return $this;
    }

    /**
     * @return int
     */
    public function getAnnee_saison(): int
    {
        return $this->annee_saison;
    }

    /**
     * @param int $annee_saison
     * @return Saison
     */
    public function setAnnee_saison(int $annee_saison): Saison
    {
        $this->annee_saison = $annee_saison;
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
     * @return Saison
     */
    public function setPersistant(bool $p): Saison
    {
        $this->persistant = $p;
        return $this;
    }

    public function __toString()
    {
        return "object:Saison (".$this->id_saison.", ".$this->annee_saison.")";
    }
}

$s = new Saison();
$s->setId_saison(22);
$s->setAnnee_saison(2021);
echo $s;