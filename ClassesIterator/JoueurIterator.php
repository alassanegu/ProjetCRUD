<?php
  class EquipeIterator implements Iterator, Countable {

    protected $idJoueur = 1;

    public function count() {
      return JoueurMetier::initPDOS_count();
    }

    public function current() {
      return JoueurMetier::initJoueurMetier($this->idJoueur);
    }

    public function key() {
      return $this->idJoueur;
    }

    public function next() {
      $this->idJoueur = $this->idJoueur+1;
    }

    public function rewind (  ) {
      $this->idJoueur = 1;
    }

    public function valid () {
      return $this->idJoueur>0 && $this->idJoueur<=$this->count();
    }
  }
?>