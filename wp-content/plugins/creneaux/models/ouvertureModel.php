<?php

class ouvertureModel {
    protected int $id;
    protected int $id_creneau;
    protected string $jour;
    protected string $ouverture;
    protected string $heure_ouverture;
    protected string $fermeture;
    protected string $heure_fermeture;
    
    public function getId(): int {
        return $this->id;
    }

    public function getIdCreneau(): int {
        return $this->id_creneau;
    }

    public function getJour(): string {
        return $this->jour;
    }

    public function getOuverture(): string {
        return $this->ouverture;
    }

    public function getHeureOuverture(): string {
        return $this->heure_ouverture;
    }

    public function getFermeture(): string {
        return $this->fermeture;
    }

    public function getHeureFermeture(): string {
        return $this->heure_fermeture;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setIdCreneau(int $id_creneau): void {
        $this->id_creneau = $id_creneau;
    }

    public function setJour(string $jour): void {
        $this->jour = $jour;
    }

    public function setOuverture(string $ouverture): void {
        $this->ouverture = $ouverture;
    }

    public function setHeureOuverture(string $heure_ouverture): void {
        $this->heure_ouverture = $heure_ouverture;
    }

    public function setFermeture(string $fermeture): void {
        $this->fermeture = $fermeture;
    }

    public function setHeureFermeture(string $heure_fermeture): void {
        $this->heure_fermeture = $heure_fermeture;
    }


}
