<?php

require_once "AbstractEntite.php";

class Participer extends AbstractEntite
{
    protected $id_equipe;
    protected $id_saison;
    protected $nbre_victoire;
    protected $nbre_nul;
    protected $nbre_defaite;
    protected $total_point;

    const TABLENAME = 'G03_SAISON';
    static $COLNAMES = array('id_equipe', 'id_saison', 'nbre_victoire', 'nbre_nul', 'nbre_defaite', 'total_point ');
    static $COLTYPES = array('number', 'number', 'number', 'number', 'number', 'number');
    static $PK = array('id_equipe', 'id_saison');
    static $AUTOID = TRUE;
    static $FK = array('id_equipe', 'id_saison');

    /**
     * @return int
     */
    public function getId_equipe(): int
    {
        return $this->id_equipe;
    }

    /**
     * @param int $id_equipe
     * @return Participer
     */
    public function setId_equipe(int $id_equipe): Participer
    {
        $this->id_equipe= $id_equipe;
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
     * @param int $id_saison
     * @return Participer
     */
    public function setId_saison(int $id_saison): Participer
    {
        $this->id_saison = $id_saison;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbre_victoire(): int
    {
        return $this->nbre_victoire;
    }

    /**
     * @param int $nbre_victoire
     * @return Participer
     */
    public function setNbre_victoire(int $nbre_victoire): Participer
    {
        $this->nbre_victoire = $nbre_victoire;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbre_nul(): int
    {
        return $this->nbre_nul;
    }

    /**
     * @param int $nbre_nul
     * @return Participer
     */
    public function setNbre_nul(int $nbre_nul): Participer
    {
        $this->nbre_nul = $nbre_nul;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbre_defaite(): int
    {
        return $this->nbre_defaite;
    }

    /**
     * @param int $nbre_defaite
     * @return Participer
     */
    public function setNbre_defaite(int $nbre_defaite): Participer
    {
        $this->nbre_defaite = $nbre_defaite;
        return $this;
    }

    /**
     * @return int
     */
    public function getTotal_point(): int
    {
        return $this->total_point;
    }

    /**
     * @param int $total_point
     * @return Participer
     */
    public function setTotal_point(int $total_point): Participer
    {
        $this->total_point = $total_point;
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
     * @return Participer
     */
    public function setPersistant(bool $p): Participer
    {
        $this->persistant = $p;
        return $this;
    }

    public function __toString()
    {
        return "object:Participer (".$this->id_equipe.", ".$this->id_saison.", ".$this->nbre_victoire.", ".$this->nbre_nul.", ".$this->nbre_defaite.", ".$this->total_point.")";
    }
}

$p = new Participer();
$p->setId_equipe(1);
$p->setId_saison(22);
$p->setNbre_victoire(2);
$p->setNbre_nul(0);
$p->setNbre_defaite(3);
$p->setTotal_point(10);
echo $p;