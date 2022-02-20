<?php
require "../Connexion/dsn.php";
class ParticiperMetier {

    /**
     * gestion statique des accès SGBD
     * @var PDO
     */
    private static $_pdo;

    /**
     * gestion statique de la requête préparée de selection
     * @var PDOStatement
     */
    private static $_pdos_select;

    /**
     * gestion statique de la requête préparée de mise à jour
     *  @var PDOStatement
     */
    private static $_pdos_update;

    /**
     * gestion statique de la requête préparée de d'insertion
     * @var PDOStatement
     */
    private static $_pdos_insert;

    /**
     * gestion statique de la requête préparée de suppression
     * @var PDOStatement
     */
    private static $_pdos_delete;

    /**
     * PreparedStatement associé à un SELECT, calcule le nombre de participes de la table
     * @var PDOStatement;
     */
    private static $_pdos_count;

    /**
     * PreparedStatement associé à un SELECT, récupère tous les participes
     * @var PDOStatement;
     */
    private static $_pdos_selectAll;



    /**
     * Initialisation de la connexion et mémorisation de l'instance PDO dans ParticiperMetier::$_pdo
     */
    public static function initPDO() {
        self::$_pdo = new PDO("mysql:host=".$_ENV['host'].";dbname=".$_ENV['db'],$_ENV['user'],$_ENV['passwd']);
        // pour récupérer aussi les exceptions provenant de PDOStatement
        self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * préparation de la requête SELECT * FROM g03_participer
     * instantiation de self::$_pdos_selectAll
     */
    public static function initPDOS_selectAll() {
        self::$_pdos_selectAll = self::$_pdo->prepare("SELECT * FROM g03_participer");
    }

    /**
     * méthode statique instanciant ParticiperMetier::$_pdo_select
     */
    public static function initPDOS_select() {
        self::$_pdos_select = self::$_pdo->prepare('SELECT * FROM g03_participer WHERE id_equipe= :idEquipe and id_saison= :idSaison');
    }

    /**
     * méthode statique instanciant ParticiperMetier::$_pdo_update
     */
    public static function initPDOS_update() {
        self::$_pdos_update =  self::$_pdo->prepare('UPDATE g03_participer SET nbre_victoire=:nbreVictoire or nbre_nul=:nbre_nul or nbre_defaite=:nbre_defaite or total_point=:total_point  WHERE id_equipe=:idEquipe and id_saison= :idSaison ');
    }

    /**
     * méthode statique instanciant ParticiperMetier::$_pdo_insert
     */
    public static function initPDOS_insert() {
        self::$_pdos_insert = self::$_pdo->prepare('INSERT INTO g03_participer VALUES(:idEquipe,:idSaison,:nbreVictoire,:nbre_nul,:nbre_defaite,:total_point)');
    }

    /**
     * méthode statique instanciant ParticiperMetier::$_pdo_delete
     */
    public static function initPDOS_delete() {
        self::$_pdos_delete = self::$_pdo->prepare('DELETE FROM g03_participer WHERE id_equipe=:idEquipe and id_saison= :idSaison');
    }

    /**
     * préparation de la requête SELECT COUNT(*) FROM g03_participer
     * instantiation de self::$_pdos_count
     */
    public static function initPDOS_count() {
        if (!isset(self::$_pdo))
            self::initPDO();
        self::$_pdos_count = self::$_pdo->prepare('SELECT COUNT(*) FROM g03_participer');
    }


    /**
     * numéro du g03_participer (identifiant dans la table g03_participer)
     * @var int
     */
    protected $id_equipe;

    /**
     * nbreVictoire du g03_participer
     * @var int
     */
    protected $id_saison;

    /**
     * nbreVictoire du g03_participer
     * @var int
     */
    protected $nbre_victoire;

    /**
     * nbreVictoire du g03_participer
     * @var int
     */
    protected $nbre_nul;
    /**
     * nbreVictoire du g03_participer
     * @var int
     */
    protected $nbre_defaite;

    /**
     * nbreVictoire du g03_participer
     * @var int
     */
    protected $total_point;

    /**
     * attribut interne pour différencier les nouveaux objets des objets créés côté applicatif de ceux issus du SGBD
     * @var bool
     */
    private $nouveau = TRUE;

    /**
     * @return int
     */
    public function getIdEquipe(): int
    {
        return $this->id_equipe;
    }

    /**
     * @param int $id_equipe
     */
    public function setIdEquipe(int $id_equipe): void
    {
        $this->id_equipe = $id_equipe;
    }

    /**
     * @return int
     */
    public function getidSaison(): int
    {
        return $this->id_saison;
    }

    /**
     * @param int $id_saison
     */
    public function setidSaison(int $id_saison): void
    {
        $this->id_saison = $id_saison;
    }

    /**
     * @return int
     */
    public function getnbreVictoire(): int
    {
        return $this->nbre_victoire;
    }

    /**
     * @param int $nbre_victoire
     */
    public function setnbreVictoire(int $nbre_victoire): void
    {
        $this->nbre_victoire = $nbre_victoire;
    }

    /**
     * @return int
     */
    public function getNbreEssai(): int
    {
        return $this->nbre_nul;
    }

    /**
     * @param int $nbre_nul
     */
    public function setNbreEssai(int $nbre_nul): void
    {
        $this->nbre_nul = $nbre_nul;
    }

    /**
     * @return int
     */
    public function getNbrePenalite(): int
    {
        return $this->nbre_defaite;
    }

    /**
     * @param int $nbre_defaite
     */
    public function setNbrePenalite(int $nbre_defaite): void
    {
        $this->nbre_defaite = $nbre_defaite;
    }

    /**
     * @return int
     */
    public function getNbreTransforme(): int
    {
        return $this->total_point;
    }

    /**
     * @param int $total_point
     */
    public function setNbreTransforme(int $total_point): void
    {
        $this->total_point = $total_point;
    }


    /**
     * @return $this->nouveau
     */
    public function getNouveau() : bool {
        return $this->nouveau;
    }

    /**
     * @param $nouveau
     */
    public function setNouveau($nouveau) {
        $this->nouveau=$nouveau;
    }

    /**
     * @return un tableau de tous les ParticiperMetier
     */
    public static function getAll(): array {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_selectAll))
                self::initPDOS_selectAll();
            self::$_pdos_selectAll->execute();
            // résultat du fetch dans une instance de ParticiperMetier
            $lesParticipes = self::$_pdos_selectAll->fetchAll(PDO::FETCH_CLASS,'ParticiperMetier');
            return $lesParticipes;
        }
        catch (PDOException $e) {
            print($e);
        }
    }


    /**
     * initialisation d'un objet métier à partir d'un enregistrement de g03_participer
     * @param $id_equipe un identifiant de g03_participer
     * @return l'instance de ParticiperMetier associée à $id_equipe et $id_saison
     */
    public static function initParticiperMetier($id_equipe,$id_saison) : ParticiperMetier {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_select))
                self::initPDOS_select();
            self::$_pdos_select->bindValue(':idEquipe',$id_equipe);
            self::$_pdos_select->bindValue(':idSaison',$id_saison);
            self::$_pdos_select->execute();
            // résultat du fetch dans une instance de ParticiperMetier
            $lm = self::$_pdos_select->fetchObject('ParticiperMetier');
            if (isset($lm) && ! empty($lm))
                $lm->setNouveau(FALSE);
            if (empty($lm))
                throw new Exception("g03_participer $id_equipe inexistant dans la table saison.\n");
            return $lm;
        }
        catch (PDOException $e) {
            print($e);
        }
    }

    /**
     * sauvegarde d'un objet métier
     * soit on insère un nouvel objet
     * soit on le met à jour
     */
    public function save()  {
        if (!isset(self::$_pdo))
            self::initPDO();
        if ($this->nouveau) {
            if (!isset(self::$_pdos_insert)) {
                self::initPDOS_insert();
            }
            self::$_pdos_insert->bindParam(':idEquipe', $this->id_equipe);
            self::$_pdos_insert->bindParam(':idSaison', $this->id_saison);
            self::$_pdos_insert->bindParam(':nbreVictoire', $this->nbre_victoire);
            self::$_pdos_insert->bindParam(':nbre_nul', $this->nbre_nul);
            self::$_pdos_insert->bindParam(':nbre_defaite', $this->nbre_defaite);
            self::$_pdos_insert->bindParam(':total_point', $this->total_point);
            self::$_pdos_insert->execute();
            $this->setNouveau(FALSE);
        }
        else {
            if (!isset(self::$_pdos_update))
                self::initPDOS_update();
            self::$_pdos_insert->bindParam(':idEquipe', $this->id_equipe);
            self::$_pdos_insert->bindParam(':idSaison', $this->id_saison);
            self::$_pdos_insert->bindParam(':nbreVictoire', $this->nbre_victoire);
            self::$_pdos_insert->bindParam(':nbre_nul', $this->nbre_nul);
            self::$_pdos_insert->bindParam(':nbre_defaite', $this->nbre_defaite);
            self::$_pdos_insert->bindParam(':total_point', $this->total_point);
            self::$_pdos_update->execute();
        }
    }

    /**
     * suppression d'un objet métier
     */
    public function delete()  {
        if (!isset(self::$_pdo))
            self::initPDO();
        if (!$this->nouveau) {
            if (!isset(self::$_pdos_delete)) {
                self::initPDOS_delete();
            }
            self::$_pdos_delete->bindParam(':idEquipe', $this->id_equipe);
            self::$_pdos_delete->bindParam(':idSaison', $this->id_saison);
            self::$_pdos_delete->execute();
        }
        $this->setNouveau(TRUE);
    }

    /**
     * nombre d'objets metier disponible dans la table
     */
    public static function getNbParticipes() : int {
        if (!isset(self::$_pdos_count)) {
            self::initPDOS_count();
        }
        self::$_pdos_count->execute();
        $resu = self::$_pdos_count->fetch();
        return $resu[0];
    }



    /**
     * affichage élémentaire
     */
    public function __toString() : string {
        $ch = "<table style='border: 1px solid'><tr><th>id Joueur</th> <th>id Match</th><th>nbre_victoire</th> <th>nbre_nul</th> <th>nbre_defaite</th> <th>total_point</th><th>nouveau</th></tr><tr>";
        $ch.= "<td>".$this->id_equipe."</td>";
        $ch.= "<td>".$this->id_saison."</td>";
        $ch.= "<td>".$this->nbre_victoire."</td>";
        $ch.= "<td>".$this->nbre_nul."</td>";
        $ch.= "<td>".$this->nbre_defaite."</td>";
        $ch.= "<td>".$this->total_point."</td>";
        $ch.= "<td>".$this->nouveau."</td>";
        $ch.= "</tr></table>";
        return $ch;
    }
}

// teste

$t = ParticiperMetier::getAll();
foreach ($t as $val){
    echo $val;
}