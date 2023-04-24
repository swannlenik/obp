<?php

class creneauModel {

    protected int $id;
    protected string $jour_creneau;
    protected int $id_jour;
    protected string $heure_debut;
    protected string $heure_fin;
    
    public function __construct(
        int $id,
        string $jourCreneau,
        int $idJour,
        string $heureDebut,
        string $heureFin
    ) {
        $this->id = $id;
        $this->jour_creneau = $jourCreneau;
        $this->id_jour = $idJour;
        $this->heure_debut = $heureDebut;
        $this->heure_fin = $heureFin;
    }
    
    public function buildFromObjectOuverture($objetCreneau) {
        $this->id = $objetCreneau->id ?? 0;
        $this->jour_creneau = $$objetCreneau->jourCreneau ?? '';
        $this->id_jour = $$objetCreneau->idJour ?? 0;
        $this->heure_debut = $$objetCreneau->heureDebut ?? '';
        $this->heure_fin = $$objetCreneau->heureFin ?? '';
    }
    
    public function getId(): int {
        return $this->id;
    }

    public function getJourCreneau(): string {
        return $this->jour_creneau;
    }

    public function getIdJour(): int {
        return $this->id_jour;
    }

    public function getHeureDebut(): string {
        return $this->heure_debut;
    }

    public function getHeureFin(): string {
        return $this->heure_fin;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setJourCreneau(string $jour_creneau): void {
        $this->jour_creneau = $jour_creneau;
    }

    public function setIdJour(int $id_jour): void {
        $this->id_jour = $id_jour;
    }

    public function setHeureDebut(string $heure_debut): void {
        $this->heure_debut = $heure_debut;
    }

    public function setHeureFin(string $heure_fin): void {
        $this->heure_fin = $heure_fin;
    }


}
