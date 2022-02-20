<?php
require "../Connexion/dsn.php";
class MatchMetier {

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
     * PreparedStatement associé à un SELECT, calcule le nombre de matchs de la table
     * @var PDOStatement;
     */
    private static $_pdos_count;

    /**
     * PreparedStatement associé à un SELECT, récupère tous les matchs
     * @var PDOStatement;
     */
    private static $_pdos_selectAll;



    /**
     * Initialisation de la connexion et mémorisation de l'instance PDO dans MatchMetier::$_pdo
     */
    public static function initPDO() {
        self::$_pdo = new PDO("mysql:host=".$_ENV['host'].";dbname=".$_ENV['db'],$_ENV['user'],$_ENV['passwd']);
        // pour récupérer aussi les exceptions provenant de PDOStatement
        self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * préparation de la requête SELECT * FROM g03_match
     * instantiation de self::$_pdos_selectAll
     */
    public static function initPDOS_selectAll() {
        self::$_pdos_selectAll = self::$_pdo->prepare("SELECT * FROM g03_match");
    }

    /**
     * méthode statique instanciant MatchMetier::$_pdo_select
     */
    public static function initPDOS_select() {
        self::$_pdos_select = self::$_pdo->prepare('SELECT * FROM g03_match WHERE id_match= :numero');
    }

    /**
     * méthode statique instanciant MatchMetier::$_pdo_update
     */
    public static function initPDOS_update() {
        self::$_pdos_update =  self::$_pdo->prepare('UPDATE g03_match SET date_match=:dateMatch  or id_saison=:idSaison or tour=:tour WHERE id_match=:numero');
    }

    /**
     * méthode statique instanciant MatchMetier::$_pdo_insert
     */
    public static function initPDOS_insert() {
        self::$_pdos_insert = self::$_pdo->prepare('INSERT INTO g03_match VALUES(:numero,:dateMatch,:idSaison,:tour)');
    }

    /**
     * méthode statique instanciant MatchMetier::$_pdo_delete
     */
    public static function initPDOS_delete() {
        self::$_pdos_delete = self::$_pdo->prepare('DELETE FROM g03_match WHERE id_match=:numero');
    }

    /**
     * préparation de la requête SELECT COUNT(*) FROM g03_match
     * instantiation de self::$_pdos_count
     */
    public static function initPDOS_count() {
        if (!isset(self::$_pdo))
            self::initPDO();
        self::$_pdos_count = self::$_pdo->prepare('SELECT COUNT(*) FROM g03_match');
    }


    /**
     * numéro du g03_match (identifiant dans la table g03_match)
     * @var int
     */
    protected $id_match;

    /**
     * dateMatch du g03_match
     * @var date
     */
    protected $date_match;

    /**
     * dateMatch du g03_match
     * @var int
     */
    protected $id_saison;

    /**
     * dateMatch du g03_match
     * @var string
     */
    protected $tour;

    /**
     * attribut interne pour différencier les nouveaux objets des objets créés côté applicatif de ceux issus du SGBD
     * @var bool
     */
    private $nouveau = TRUE;

    /**
     * @return int
     */
    public function getIdMatch(): int
    {
        return $this->id_match;
    }

    /**
     * @param int $id_match
     */
    public function setIdMatch(int $id_match): void
    {
        $this->id_match = $id_match;
    }

    /**
     * @return date
     */
    public function getDateMatch(): date
    {
        return $this->date_match;
    }

    /**
     * @param date $date_match
     */
    public function setDateMatch(date $date_match): void
    {
        $this->date_match = $date_match;
    }

    /**
     * @return int
     */
    public function getIdSaison(): int
    {
        return $this->id_saison;
    }

    /**
     * @param int $id_saison
     */
    public function setIdSaison(int $id_saison): void
    {
        $this->id_saison = $id_saison;
    }

    /**
     * @return string
     */
    public function getTour(): string
    {
        return $this->tour;
    }

    /**
     * @param string $tour
     */
    public function setTour(string $tour): void
    {
        $this->tour = $tour;
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
     * @return un tableau de tous les MatchMetier
     */
    public static function getAll(): array {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_selectAll))
                self::initPDOS_selectAll();
            self::$_pdos_selectAll->execute();
            // résultat du fetch dans une instance de MatchMetier
            $lesmatchs = self::$_pdos_selectAll->fetchAll(PDO::FETCH_CLASS,'MatchMetier');
            return $lesmatchs;
        }
        catch (PDOException $e) {
            print($e);
        }
    }


    /**
     * initialisation d'un objet métier à partir d'un enregistrement de g03_match
     * @param $id_match un identifiant de g03_match
     * @return l'instance de MatchMetier associée à $id_match
     */
    public static function initMatchMetier($id_match) : MatchMetier {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_select))
                self::initPDOS_select();
            self::$_pdos_select->bindValue(':numero',$id_match);
            self::$_pdos_select->execute();
            // résultat du fetch dans une instance de MatchMetier
            $lm = self::$_pdos_select->fetchObject('MatchMetier');
            if (isset($lm) && ! empty($lm))
                $lm->setNouveau(FALSE);
            if (empty($lm))
                throw new Exception("g03_match $id_match inexistant dans la table saison.\n");
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
            self::$_pdos_insert->bindParam(':numero', $this->id_match);
            self::$_pdos_insert->bindParam(':dateMatch', $this->date_match);
            self::$_pdos_insert->bindParam(':idSaison', $this->id_saison);
            self::$_pdos_insert->bindParam(':tour', $this->tour);
            self::$_pdos_insert->execute();
            $this->setNouveau(FALSE);
        }
        else {
            if (!isset(self::$_pdos_update))
                self::initPDOS_update();
            self::$_pdos_update->bindParam(':numero', $this->id_match);
            self::$_pdos_update->bindParam(':dateMatch', $this->date_match);
            self::$_pdos_insert->bindParam(':idSaison', $this->id_saison);
            self::$_pdos_insert->bindParam(':tour', $this->tour);
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
            self::$_pdos_delete->bindParam(':numero', $this->id_match);
            self::$_pdos_delete->execute();
        }
        $this->setNouveau(TRUE);
    }

    /**
     * nombre d'objets metier disponible dans la table
     */
    public static function getNbmatchs() : int {
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
        $ch = "<table><tr> <th>id match</th> <th>date match</th> <th>id Saison</th> <th>Tour</th> <th>nouveau</th></tr><tr>";
        $ch.= "<td style='border: 1px solid'>".$this->id_match."</td>";
        $ch.= "<td style='border: 1px solid'>".$this->date_match."</td>";
        $ch.= "<td style='border: 1px solid'>".$this->id_saison."</td>";
        $ch.= "<td style='border: 1px solid'>".$this->tour."</td>";
        $ch.= "<td style='border: 1px solid'>".$this->nouveau."</td>";
        $ch.= "</tr></table>";
        return $ch;
    }
}

// teste

$t = MatchMetier::getAll();
foreach ($t as $val){
    echo $val;
}