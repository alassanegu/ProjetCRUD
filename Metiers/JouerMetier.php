<?php
require "../Connexion/dsn.php";
class JouerMetier {

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
     * PreparedStatement associé à un SELECT, calcule le nombre de joués de la table
     * @var PDOStatement;
     */
    private static $_pdos_count;

    /**
     * PreparedStatement associé à un SELECT, récupère tous les joués
     * @var PDOStatement;
     */
    private static $_pdos_selectAll;



    /**
     * Initialisation de la connexion et mémorisation de l'instance PDO dans JouerMetier::$_pdo
     */
    public static function initPDO() {
        self::$_pdo = new PDO("mysql:host=".$_ENV['host'].";dbname=".$_ENV['db'],$_ENV['user'],$_ENV['passwd']);
        // pour récupérer aussi les exceptions provenant de PDOStatement
        self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * préparation de la requête SELECT * FROM g03_jouer
     * instantiation de self::$_pdos_selectAll
     */
    public static function initPDOS_selectAll() {
        self::$_pdos_selectAll = self::$_pdo->prepare("SELECT * FROM g03_jouer");
    }

    /**
     * méthode statique instanciant JouerMetier::$_pdo_select
     */
    public static function initPDOS_select() {
        self::$_pdos_select = self::$_pdo->prepare('SELECT * FROM g03_jouer WHERE id_joueur= :idJoueur and id_match= :idMatch');
    }

    /**
     * méthode statique instanciant JouerMetier::$_pdo_update
     */
    public static function initPDOS_update() {
        self::$_pdos_update =  self::$_pdo->prepare('UPDATE g03_jouer SET essais_joueur=:essaisJoueur or position=:position or penalite=:penalite  WHERE id_joueur=:idJoueur and id_match= :idMatch ');
    }

    /**
     * méthode statique instanciant JouerMetier::$_pdo_insert
     */
    public static function initPDOS_insert() {
        self::$_pdos_insert = self::$_pdo->prepare('INSERT INTO g03_jouer VALUES(:idJoueur,:idMatch,:essaisJoueur,:position,:penalite)');
    }

    /**
     * méthode statique instanciant JouerMetier::$_pdo_delete
     */
    public static function initPDOS_delete() {
        self::$_pdos_delete = self::$_pdo->prepare('DELETE FROM g03_jouer WHERE id_joueur=:idJoueur and id_match= :idMatch');
    }

    /**
     * préparation de la requête SELECT COUNT(*) FROM g03_jouer
     * instantiation de self::$_pdos_count
     */
    public static function initPDOS_count() {
        if (!isset(self::$_pdo))
            self::initPDO();
        self::$_pdos_count = self::$_pdo->prepare('SELECT COUNT(*) FROM g03_jouer');
    }


    /**
     * numéro du g03_jouer (identifiant dans la table g03_jouer)
     * @var int
     */
    protected $id_joueur;

    /**
     * essaisJoueur du g03_jouer
     * @var int
     */
    protected $id_match;

    /**
     * essaisJoueur du g03_jouer
     * @var int
     */
    protected $essais_joueur;

    /**
     * essaisJoueur du g03_jouer
     * @var string
     */
    protected $position;
    /**
     * essaisJoueur du g03_jouer
     * @var int
     */
    protected $penalite;

    /**
     * attribut interne pour différencier les nouveaux objets des objets créés côté applicatif de ceux issus du SGBD
     * @var bool
     */
    private $nouveau = TRUE;

    /**
     * @return int
     */
    public function getIdJoueur(): int
    {
        return $this->id_joueur;
    }

    /**
     * @param int $id_joueur
     */
    public function setIdJoueur(int $id_joueur): void
    {
        $this->id_joueur = $id_joueur;
    }

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
     * @return int
     */
    public function getEssaisJoueur(): int
    {
        return $this->essais_joueur;
    }

    /**
     * @param int $essais_joueur
     */
    public function setEssaisJoueur(int $essais_joueur): void
    {
        $this->essais_joueur = $essais_joueur;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition(string $position): void
    {
        $this->position = $position;
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
     */
    public function setPenalite(int $penalite): void
    {
        $this->penalite = $penalite;
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
     * @return un tableau de tous les JouerMetier
     */
    public static function getAll(): array {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_selectAll))
                self::initPDOS_selectAll();
            self::$_pdos_selectAll->execute();
            // résultat du fetch dans une instance de JouerMetier
            $lesjoués = self::$_pdos_selectAll->fetchAll(PDO::FETCH_CLASS,'JouerMetier');
            return $lesjoués;
        }
        catch (PDOException $e) {
            print($e);
        }
    }


    /**
     * initialisation d'un objet métier à partir d'un enregistrement de g03_jouer
     * @param $id_joueur un identifiant de g03_jouer
     * @return l'instance de JouerMetier associée à $id_joueur
     */
    public static function initJouerMetier($id_joueur,$id_match) : JouerMetier {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_select))
                self::initPDOS_select();
            self::$_pdos_select->bindValue(':idJoueur',$id_joueur);
            self::$_pdos_select->bindValue(':idMatch',$id_match);
            self::$_pdos_select->execute();
            // résultat du fetch dans une instance de JouerMetier
            $lm = self::$_pdos_select->fetchObject('JouerMetier');
            if (isset($lm) && ! empty($lm))
                $lm->setNouveau(FALSE);
            if (empty($lm))
                throw new Exception("g03_jouer $id_joueur inexistant dans la table saison.\n");
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
            self::$_pdos_insert->bindParam(':idJoueur', $this->id_joueur);
            self::$_pdos_insert->bindParam(':idMatch', $this->id_match);
            self::$_pdos_insert->bindParam(':essaisJoueur', $this->essais_joueur);
            self::$_pdos_insert->bindParam(':position', $this->position);
            self::$_pdos_insert->bindParam(':penalite', $this->penalite);
            self::$_pdos_insert->execute();
            $this->setNouveau(FALSE);
        }
        else {
            if (!isset(self::$_pdos_update))
                self::initPDOS_update();
            self::$_pdos_insert->bindParam(':idJoueur', $this->id_joueur);
            self::$_pdos_insert->bindParam(':idMatch', $this->id_match);
            self::$_pdos_insert->bindParam(':essaisJoueur', $this->essais_joueur);
            self::$_pdos_insert->bindParam(':position', $this->position);
            self::$_pdos_insert->bindParam(':penalite', $this->penalite);
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
            self::$_pdos_delete->bindParam(':idJoueur', $this->id_joueur);
            self::$_pdos_delete->bindParam(':idMatch', $this->id_match);
            self::$_pdos_delete->execute();
        }
        $this->setNouveau(TRUE);
    }

    /**
     * nombre d'objets metier disponible dans la table
     */
    public static function getNbjoués() : int {
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
        $ch = "<table style='border: 1px solid'><tr><th>id Joueur</th> <th>id Match</th><th>essais_joueur</th> <th>Position</th> <th>penalite</th><th>nouveau</th></tr><tr>";
        $ch.= "<td>".$this->id_joueur."</td>";
        $ch.= "<td>".$this->id_match."</td>";
        $ch.= "<td>".$this->essais_joueur."</td>";
        $ch.= "<td>".$this->position."</td>";
        $ch.= "<td>".$this->penalite."</td>";
        $ch.= "<td>".$this->nouveau."</td>";
        $ch.= "</tr></table>";
        return $ch;
    }
}

// teste

$t = JouerMetier::getAll();
foreach ($t as $val){
    echo $val;
}