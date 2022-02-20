<?php
require "../Connexion/dsn.php";
class EquipeMetier {

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
     * PreparedStatement associé à un SELECT, calcule le nombre de equipes de la table
     * @var PDOStatement;
     */
    private static $_pdos_count;

    /**
     * PreparedStatement associé à un SELECT, récupère tous les equipes
     * @var PDOStatement;
     */
    private static $_pdos_selectAll;



    /**
     * Initialisation de la connexion et mémorisation de l'instance PDO dans EquipeMetier::$_pdo
     */
    public static function initPDO() {
        self::$_pdo = new PDO("mysql:host=".$_ENV['host'].";dbname=".$_ENV['db'],$_ENV['user'],$_ENV['passwd']);
        // pour récupérer aussi les exceptions provenant de PDOStatement
        self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * préparation de la requête SELECT * FROM g03_equipe
     * instantiation de self::$_pdos_selectAll
     */
    public static function initPDOS_selectAll() {
        self::$_pdos_selectAll = self::$_pdo->prepare("SELECT * FROM g03_equipe");
    }

    /**
     * méthode statique instanciant EquipeMetier::$_pdo_select
     */
    public static function initPDOS_select() {
        self::$_pdos_select = self::$_pdo->prepare('SELECT * FROM g03_equipe WHERE id_equipe= :numero');
    }

    /**
     * méthode statique instanciant EquipeMetier::$_pdo_update
     */
    public static function initPDOS_update() {
        self::$_pdos_update =  self::$_pdo->prepare('UPDATE g03_equipe SET nom_equipe=:nomEquipe WHERE id_equipe=:numero');
    }

    /**
     * méthode statique instanciant EquipeMetier::$_pdo_insert
     */
    public static function initPDOS_insert() {
        self::$_pdos_insert = self::$_pdo->prepare('INSERT INTO g03_equipe VALUES(:numero,:nomEquipe)');
    }

    /**
     * méthode statique instanciant EquipeMetier::$_pdo_delete
     */
    public static function initPDOS_delete() {
        self::$_pdos_delete = self::$_pdo->prepare('DELETE FROM g03_equipe WHERE id_equipe=:numero');
    }

    /**
     * préparation de la requête SELECT COUNT(*) FROM g03_equipe
     * instantiation de self::$_pdos_count
     */
    public static function initPDOS_count() {
        if (!isset(self::$_pdo))
            self::initPDO();
        self::$_pdos_count = self::$_pdo->prepare('SELECT COUNT(*) FROM g03_equipe');
    }


    /**
     * numéro du g03_equipe (identifiant dans la table g03_equipe)
     * @var int
     */
    protected $id_equipe;

    /**
     * nomEquipe du g03_equipe
     * @var string
     */
    protected $nom_equipe;

    /**
     * attribut interne pour différencier les nouveaux objets des objets créés côté applicatif de ceux issus du SGBD
     * @var bool
     */
    private $nouveau = TRUE;

    /**
     * @return $this->id_equipe
     */
    public function getid_equipe() : int {
        return $this->id_equipe;
    }

    /**
     * @param $id_equipe
     */
    public function setid_equipe($id_equipe) {
        $this->id_equipe=$id_equipe;
    }

    /**
     * @return $this->nom_equipe
     */
    public function getnom_equipe() : string {
        return $this->nom_equipe;
    }

    /**
     * @param $nom_equipe
     */
    public function setnom_equipe($nom_equipe) {
        $this->nom_equipe=$nom_equipe;
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
     * @return un tableau de tous les EquipeMetier
     */
    public static function getAll(): array {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_selectAll))
                self::initPDOS_selectAll();
            self::$_pdos_selectAll->execute();
            // résultat du fetch dans une instance de EquipeMetier
            $lesequipes = self::$_pdos_selectAll->fetchAll(PDO::FETCH_CLASS,'EquipeMetier');
            return $lesequipes;
        }
        catch (PDOException $e) {
            print($e);
        }
    }


    /**
     * initialisation d'un objet métier à partir d'un enregistrement de g03_equipe
     * @param $id_equipe un identifiant de g03_equipe
     * @return l'instance de EquipeMetier associée à $id_equipe
     */
    public static function initEquipeMetier($id_equipe) : EquipeMetier {
        try {
            if (!isset(self::$_pdo))
                self::initPDO();
            if (!isset(self::$_pdos_select))
                self::initPDOS_select();
            self::$_pdos_select->bindValue(':numero',$id_equipe);
            self::$_pdos_select->execute();
            // résultat du fetch dans une instance de EquipeMetier
            $lm = self::$_pdos_select->fetchObject('EquipeMetier');
            if (isset($lm) && ! empty($lm))
                $lm->setNouveau(FALSE);
            if (empty($lm))
                throw new Exception("g03_equipe $id_equipe inexistant dans la table equipe.\n");
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
            self::$_pdos_insert->bindParam(':numero', $this->id_equipe);
            self::$_pdos_insert->bindParam(':nomEquipe', $this->nom_equipe);
            self::$_pdos_insert->execute();
            $this->setNouveau(FALSE);
        }
        else {
            if (!isset(self::$_pdos_update))
                self::initPDOS_update();
            self::$_pdos_update->bindParam(':numero', $this->id_equipe);
            self::$_pdos_update->bindParam(':nomEquipe', $this->nom_equipe);
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
            self::$_pdos_delete->bindParam(':numero', $this->id_equipe);
            self::$_pdos_delete->execute();
        }
        $this->setNouveau(TRUE);
    }

    /**
     * nombre d'objets metier disponible dans la table
     */
    public static function getNbequipes() : int {
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
        $ch = "<table style='border: 1px solid'><tr><th>id_equipe</th><th>nom_equipe</th><th>nouveau</th></tr><tr>";
        $ch.= "<td>".$this->id_equipe."</td>";
        $ch.= "<td>".$this->nom_equipe."</td>";
        $ch.= "<td>".$this->nouveau."</td>";
        $ch.= "</tr></table>";
        return $ch;
    }
}

// teste

$t = EquipeMetier::getAll();
foreach ($t as $val){
    echo $val;
}
//$lmsf1 = EquipeMetier::initEquipeMetier(6);
//echo "<p>Livre numéro 1</p>";
//echo $lmsf1;
//
//$eq = EquipeMetier::initEquipeMetier(6);
//echo "<p>Modification de l'equipe numero 7</p>";
//$eq->setnom_equipe("Pays de Galles");
////echo "<p>Sauvegarde de l'equipe numero 6</p>";
//$eq->save();
//echo $eq;
//
//$eq7 = new EquipeMetier();
//echo "<p>Création de l'equipe numero 7</p>";
//$eq7->setId_equipe(7);
//$eq7->setNom_equipe('Espagne');
//$eq7->setNouveau(TRUE);
//echo $eq7;
//
//echo "<p>Sauvegarde de l'equipe numero 7</p>";
//$eq7->save();
//echo $eq7;
//
//
//echo "<p>Récupération de l'equipe numero 7 sauvegardé puis suppression</p>";
//try {
//    $eq7bis = EquipeMetier::initEquipeMetier(7);
//    echo "<p>Livre numéro 7 après sauvegarde et récupération</p>";
//    echo($eq7bis);
//
//    $eq7bis->delete();
//    echo "<p>Livre numéro 7 après suppression</p>";
//    echo($eq7bis);
//    echo "<p>L'instance existe toujours mais n'a plus de pendant coté SGBD</p>";
//
//    echo "<p>Tentative d'initialisation d'une equipe inexistant</p>";
//    $eq7ter = EquipeMetier::initEquipeMetier(7);
//    if (isset($eq7))
//        echo($eq7ter);
//} catch (Exception $e) {
//    print $e;
//}