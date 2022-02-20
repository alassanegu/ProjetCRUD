<?php
require "../Connexion/dsn.php";
class ObtenirScoreMetier {

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
     * PreparedStatement associé à un SELECT, calcule le nombre de OS de la table
     * @var PDOStatement;
     */
    private static $_pdos_count;

    /**
     * PreparedStatement associé à un SELECT, récupère tous les OS
     * @var PDOStatement;
     */
    private static $_pdos_selectAll;



    /**
     * Initialisation de la connexion et mémorisation de l'instance PDO dans ObtenirScoreMetier::$_pdo
     */
    public static function initPDO() {
        self::$_pdo = new PDO("mysql:host=".$_ENV['host'].";dbname=".$_ENV['db'],$_ENV['user'],$_ENV['passwd']);
        // pour récupérer aussi les exceptions provenant de PDOStatement
        self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * préparation de la requête SELECT * FROM g03_obtenir_score
     * instantiation de self::$_pdos_selectAll
     */
    public static function initPDOS_selectAll() {
        self::$_pdos_selectAll = self::$_pdo->prepare("SELECT * FROM g03_obtenir_score");
    }

    /**
     * méthode statique instanciant ObtenirScoreMetier::$_pdo_select
     */
    public static function initPDOS_select() {
        self::$_pdos_select = self::$_pdo->prepare('SELECT * FROM g03_obtenir_score WHERE id_equipe= :idEquipe and id_match= :idMatch');
    }

    /**
     * méthode statique instanciant ObtenirScoreMetier::$_pdo_update
     */
    public static function initPDOS_update() {
        self::$_pdos_update =  self::$_pdo->prepare('UPDATE g03_obtenir_score SET nbre_point=:nbrePoint or nbre_essai=:nbre_essai or nbre_penalite=:nbre_penalite or nbre_transforme=:nbre_transforme  WHERE id_equipe=:idEquipe and id_match= :idMatch ');
    }

    /**
     * méthode statique instanciant ObtenirScoreMetier::$_pdo_insert
     */
    public static function initPDOS_insert() {
        self::$_pdos_insert = self::$_pdo->prepare('INSERT INTO g03_obtenir_score VALUES(:idEquipe,:idMatch,:nbrePoint,:nbre_essai,:nbre_penalite,:nbre_transforme)');
    }

    /**
     * méthode statique instanciant ObtenirScoreMetier::$_pdo_delete
     */
    public static function initPDOS_delete() {
        self::$_pdos_delete = self::$_pdo->prepare('DELETE FROM g03_obtenir_score WHERE id_equipe=:idEquipe and id_match= :idMatch');
    }

    /**
     * préparation de la requête SELECT COUNT(*) FROM g03_obtenir_score
     * instantiation de self::$_pdos_count
     */
    public static function initPDOS_count() {
        if (!isset(self::$_pdo))
            self::initPDO();
        self::$_pdos_count = self::$_pdo->prepare('SELECT COUNT(*) FROM g03_obtenir_score');
    }


    /**
     * numéro du g03_obtenir_score (identifiant dans la table g03_obtenir_score)
     * @var int
     */
    protected $id_equipe;

    /**
     * nbrePoint du g03_obtenir_score
     * @var int
     */
    protected $id_match;

    /**
     * nbrePoint du g03_obtenir_score
     * @var int
     */
    protected $nbre_point;

    /**
     * nbrePoint du g03_obtenir_score
     * @var int
     */
    protected $nbre_essai;
    /**
     * nbrePoint du g03_obtenir_score
     * @var int
     */
    protected $nbre_penalite;

    /**
     * nbrePoint du g03_obtenir_score
     * @var int
     */
    protected $nbre_transforme;

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
    public function getNbrePoint(): int
    {
        return $this->nbre_point;
    }

    /**
     * @param int $nbre_point
     */
    public function setNbrePoint(int $nbre_point): void
    {
        $this->nbre_point = $nbre_point;
    }

    /**
     * @return int
     */
    public function getNbreEssai(): int
    {
        return $this->nbre_essai;
    }

    /**
     * @param int $nbre_essai
     */
    public function setNbreEssai(int $nbre_essai): void
    {
        $this->nbre_essai = $nbre_essai;
    }

    /**
     * @return int
     */
    public function getNbrePenalite(): int
    {
        return $this->nbre_penalite;
    }

    /**
     * @param int $nbre_penalite
     */
    public function setNbrePenalite(int $nbre_penalite): void
    {
        $this->nbre_penalite = $nbre_penalite;
    }

    /**
     * @return int
     */
    public function getNbreTransforme(): int
    {
        return $this->nbre_transforme;
    }

    /**
     * @param int $nbre_transforme
     */
    public function setNbreTransforme(int $nbre_transforme): void
    {
        $this->nbre_transforme = $nbre_transforme;
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
     * @return un tableau de tous les ObtenirScoreMetier
     */
    public static function getAll(): array {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_selectAll))
                self::initPDOS_selectAll();
            self::$_pdos_selectAll->execute();
            // résultat du fetch dans une instance de ObtenirScoreMetier
            $lesOS = self::$_pdos_selectAll->fetchAll(PDO::FETCH_CLASS,'ObtenirScoreMetier');
            return $lesOS;
        }
        catch (PDOException $e) {
            print($e);
        }
    }


    /**
     * initialisation d'un objet métier à partir d'un enregistrement de g03_obtenir_score
     * @param $id_equipe un identifiant de g03_obtenir_score
     * @return l'instance de ObtenirScoreMetier associée à $id_equipe et $id_match
     */
    public static function initObtenirScoreMetier($id_equipe,$id_match) : ObtenirScoreMetier {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_select))
                self::initPDOS_select();
            self::$_pdos_select->bindValue(':idEquipe',$id_equipe);
            self::$_pdos_select->bindValue(':idMatch',$id_match);
            self::$_pdos_select->execute();
            // résultat du fetch dans une instance de ObtenirScoreMetier
            $lm = self::$_pdos_select->fetchObject('ObtenirScoreMetier');
            if (isset($lm) && ! empty($lm))
                $lm->setNouveau(FALSE);
            if (empty($lm))
                throw new Exception("g03_obtenir_score $id_equipe inexistant dans la table saison.\n");
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
            self::$_pdos_insert->bindParam(':idMatch', $this->id_match);
            self::$_pdos_insert->bindParam(':nbrePoint', $this->nbre_point);
            self::$_pdos_insert->bindParam(':nbre_essai', $this->nbre_essai);
            self::$_pdos_insert->bindParam(':nbre_penalite', $this->nbre_penalite);
            self::$_pdos_insert->bindParam(':nbre_transforme', $this->nbre_transforme);
            self::$_pdos_insert->execute();
            $this->setNouveau(FALSE);
        }
        else {
            if (!isset(self::$_pdos_update))
                self::initPDOS_update();
            self::$_pdos_insert->bindParam(':idEquipe', $this->id_equipe);
            self::$_pdos_insert->bindParam(':idMatch', $this->id_match);
            self::$_pdos_insert->bindParam(':nbrePoint', $this->nbre_point);
            self::$_pdos_insert->bindParam(':nbre_essai', $this->nbre_essai);
            self::$_pdos_insert->bindParam(':nbre_penalite', $this->nbre_penalite);
            self::$_pdos_insert->bindParam(':nbre_transforme', $this->nbre_transforme);
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
            self::$_pdos_delete->bindParam(':idMatch', $this->id_match);
            self::$_pdos_delete->execute();
        }
        $this->setNouveau(TRUE);
    }

    /**
     * nombre d'objets metier disponible dans la table
     */
    public static function getNbOS() : int {
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
        $ch = "<table style='border: 1px solid'><tr><th>id Joueur</th> <th>id Match</th><th>nbre_point</th> <th>nbre_essai</th> <th>nbre_penalite</th> <th>nbre_transforme</th><th>nouveau</th></tr><tr>";
        $ch.= "<td>".$this->id_equipe."</td>";
        $ch.= "<td>".$this->id_match."</td>";
        $ch.= "<td>".$this->nbre_point."</td>";
        $ch.= "<td>".$this->nbre_essai."</td>";
        $ch.= "<td>".$this->nbre_penalite."</td>";
        $ch.= "<td>".$this->nbre_transforme."</td>";
        $ch.= "<td>".$this->nouveau."</td>";
        $ch.= "</tr></table>";
        return $ch;
    }
}

// teste

$t = ObtenirScoreMetier::getAll();
foreach ($t as $val){
    echo $val;
}