<?php

require "../Connexion/dsn.php";
class JoueurMetier {

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
     * PreparedStatement associé à un SELECT, calcule le nombre de joueurs de la table
     * @var PDOStatement;
     */
    private static $_pdos_count;

    /**
     * PreparedStatement associé à un SELECT, récupère tous les joueurs
     * @var PDOStatement;
     */
    private static $_pdos_selectAll;



    /**
     * Initialisation de la connexion et mémorisation de l'instance PDO dans JoueurMetier::$_pdo
     */
    public static function initPDO() {
        self::$_pdo = new PDO("mysql:host=".$_ENV['host'].";dbname=".$_ENV['db'],$_ENV['user'],$_ENV['passwd']);
        // pour récupérer aussi les exceptions provenant de PDOStatement
        self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * préparation de la requête SELECT * FROM g03_joueur
     * instantiation de self::$_pdos_selectAll
     */
    public static function initPDOS_selectAll() {
        self::$_pdos_selectAll = self::$_pdo->prepare("SELECT * FROM g03_joueur");
    }

    /**
     * méthode statique instanciant JoueurMetier::$_pdo_select
     */
    public static function initPDOS_select() {
        self::$_pdos_select = self::$_pdo->prepare('SELECT * FROM g03_joueur WHERE id_joueur= :numero');
    }

    /**
     * méthode statique instanciant JoueurMetier::$_pdo_update
     */
    public static function initPDOS_update() {
        self::$_pdos_update =  self::$_pdo->prepare('UPDATE g03_joueur SET nom_joueur=:nomJoueur or prenom_joueur=:prenomJoueur or id_equipe=:idEquipe WHERE id_joueur=:numero');
    }

    /**
     * méthode statique instanciant JoueurMetier::$_pdo_insert
     */
    public static function initPDOS_insert() {
        self::$_pdos_insert = self::$_pdo->prepare('INSERT INTO g03_joueur VALUES(:numero,:nomJoueur,:prenomJoueur,:idEquipe)');
    }

    /**
     * méthode statique instanciant JoueurMetier::$_pdo_delete
     */
    public static function initPDOS_delete() {
        self::$_pdos_delete = self::$_pdo->prepare('DELETE FROM g03_joueur WHERE id_joueur=:numero');
    }

    /**
     * préparation de la requête SELECT COUNT(*) FROM g03_joueur
     * instantiation de self::$_pdos_count
     */
    public static function initPDOS_count() {
        if (!isset(self::$_pdo))
            self::initPDO();
        self::$_pdos_count = self::$_pdo->prepare('SELECT COUNT(*) FROM g03_joueur');
    }


    /**
     * numéro du g03_joueur (identifiant dans la table g03_joueur)
     * @var int
     */
    protected $id_joueur;

    /**
     * nomJoueur du g03_joueur
     * @var string
     */
    protected $nom_joueur;

    /**
     * prenomJoueur du g03_joueur
     * @var string
     */
    protected $prenom_joueur;

    /**
     * id_equipe du g03_joueur
     * @var string
     */
    protected $id_equipe;

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
     * @return string
     */
    public function getNomJoueur(): string
    {
        return $this->nom_joueur;
    }

    /**
     * @param string $nom_joueur
     */
    public function setNomJoueur(string $nom_joueur): void
    {
        $this->nom_joueur = $nom_joueur;
    }

    /**
     * @return string
     */
    public function getPrenomJoueur(): string
    {
        return $this->prenom_joueur;
    }

    /**
     * @param string $prenom_joueur
     */
    public function setPrenomJoueur(string $prenom_joueur): void
    {
        $this->prenom_joueur = $prenom_joueur;
    }

    /**
     * @return string
     */
    public function getIdEquipe(): string
    {
        return $this->id_equipe;
    }

    /**
     * @param string $id_equipe
     */
    public function setIdEquipe(string $id_equipe): void
    {
        $this->id_equipe = $id_equipe;
    }

    /**
     * @return bool
     */
    public function isNouveau(): bool
    {
        return $this->nouveau;
    }

    /**
     * @param bool $nouveau
     */
    public function setNouveau(bool $nouveau): void
    {
        $this->nouveau = $nouveau;
    }



    /**
     * @return un tableau de tous les JoueurMetier
     */
    public static function getAll(): array {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_selectAll))
                self::initPDOS_selectAll();
            self::$_pdos_selectAll->execute();
            // résultat du fetch dans une instance de JoueurMetier
            $lesjoueurs = self::$_pdos_selectAll->fetchAll(PDO::FETCH_CLASS,'JoueurMetier');
            return $lesjoueurs;
        }
        catch (PDOException $e) {
            print($e);
        }
    }


    /**
     * initialisation d'un objet métier à partir d'un enregistrement de g03_joueur
     * @param $id_joueur un identifiant de g03_joueur
     * @return l'instance de JoueurMetier associée à $id_joueur
     */
    public static function initJoueurMetier($id_joueur) : JoueurMetier {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_select))
                self::initPDOS_select();
            self::$_pdos_select->bindValue(':numero',$id_joueur);
            self::$_pdos_select->execute();
            // résultat du fetch dans une instance de JoueurMetier
            $lm = self::$_pdos_select->fetchObject('JoueurMetier');
            if (isset($lm) && ! empty($lm))
                $lm->setNouveau(FALSE);
            if (empty($lm))
                throw new Exception("g03_joueur $id_joueur inexistant dans la table joueur.\n");
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
            self::$_pdos_insert->bindParam(':numero', $this->id_joueur);
            self::$_pdos_insert->bindParam(':nomJoueur', $this->nom_joueur);
            self::$_pdos_insert->bindParam(':prenomJoueur', $this->prenom_joueur);
            self::$_pdos_insert->bindParam(':idEquipe', $this->id_equipe);
            self::$_pdos_insert->execute();
            $this->setNouveau(FALSE);
        }
        else {
            if (!isset(self::$_pdos_update))
                self::initPDOS_update();
            self::$_pdos_update->bindParam(':numero', $this->id_joueur);
            self::$_pdos_update->bindParam(':nomJoueur', $this->nom_joueur);
            self::$_pdos_insert->bindParam(':prenomJoueur', $this->prenom_joueur);
            self::$_pdos_insert->bindParam(':idEquipe', $this->id_equipe);
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
            self::$_pdos_delete->bindParam(':numero', $this->id_joueur);
            self::$_pdos_delete->execute();
        }
        $this->setNouveau(TRUE);
    }

    /**
     * nombre d'objets metier disponible dans la table
     */
    public static function getNbjoueurs() : int {
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
        $ch = "<table style='border: 1px solid'><tr><th>id joueur</th><th>nom joueur</th><th>prenom joueur</th><th>id equipe</th><th>nouveau</th></tr><tr>";
        $ch.= "<td>".$this->id_joueur."</td>";
        $ch.= "<td>".$this->nom_joueur."</td>";
        $ch.= "<td>".$this->prenom_joueur."</td>";
        $ch.= "<td>".$this->id_equipe."</td>";
        $ch.= "<td>".$this->nouveau."</td>";
        $ch.= "</tr></table>";
        return $ch;
    }
}

// teste
$n = JoueurMetier::getNbjoueurs();
echo $n;

$t = JoueurMetier::getAll();
foreach ($t as $val){
    echo $val;
}
