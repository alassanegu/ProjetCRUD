<?php
  class EquipeIterator implements Iterator, Countable {

    protected $idEquipe = 1;

    public function count() {
      return EquipeMetier::initPDOS_count();
    }

    public function current() {
      return EquipeMetier::initEquipeMetier($this->idEquipe);
    }

    public function key() {
      return $this->idEquipe;
    }

    public function next() {
      $this->idEquipe = $this->idEquipe+1;
    }

    public function rewind (  ) {
      $this->idEquipe = 1;
    }

    public function valid () {
      return $this->idEquipe>0 && $this->idEquipe<=$this->count();
    }
  }
?>