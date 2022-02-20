<?php

require_once "AbstractEntite.php";

class Joueur extends AbstractEntite
{
    protected $id_joueur;
    protected $id_equipe;
    protected $nom_joueur;
    protected $prenom_joueur;

    const TABLENAME = 'G03_SAISON';
    static $COLNAMES = array('id_joueur', 'id_equipe', 'nom_joueur', 'prenom_joueur');
    static $COLTYPES = array('number', 'number', 'text', 'text');
    static $PK = array('id_joueur');
    static $AUTOID = TRUE;
    static $FK = array('id_equipe');

    /**
     * @return int
     */
    public function getId_joueur(): int
    {
        return $this->id_joueur;
    }

    /**
     * @param int $id_joueur
     * @return Joueur
     */
    public function setId_joueur(int $id_joueur): Joueur
    {
        $this->id_joueur = $id_joueur;
        return $this;
    }

    /**
     * @return int
     */
    public function getId_equipe(): int
    {
        return $this->id_equipe;
    }

    /**
     * @param int $id_equipe
     * @return Joueur
     */
    public function setId_equipe(int $id_equipe): Joueur
    {
        $this->id_equipe = $id_equipe;
        return $this;
    }

    /**
     * @return string
     */
    public function getNom_joueur(): string
    {
        return $this->nom_joueur;
    }

    /**
     * @param string $nom_joueur
     * @return Joueur
     */
    public function setNom_joueur(string $nom_joueur): Joueur
    {
        $this->nom_joueur = $nom_joueur;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrenom_joueur(): string
    {
        return $this->prenom_joueur;
    }

    /**
     * @param string $prenom_joueur
     * @return Joueur
     */
    public function setPrenom_joueur(string $prenom_joueur): Joueur
    {
        $this->prenom_joueur = $prenom_joueur;
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
     * @return Joueur
     */
    public function setPersistant(bool $p): Joueur
    {
        $this->persistant = $p;
        return $this;
    }

    public function __toString()
    {
        return "object:Joueur (".$this->id_equipe.", ".$this->id_joueur.", ".$this->nom_joueur.", ".$this->prenom_joueur.")";
    }
}

$j = new Joueur();
$j->setId_joueur(1);
$j->setId_equipe(1);
$j->setNom_joueur('Cowan-Dickie');
$j->setPrenom_joueur('Luke');
echo $j;