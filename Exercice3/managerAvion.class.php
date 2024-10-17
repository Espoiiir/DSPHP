<?php


class ManagerAvion
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Ajouter un avion
    public function add(Avion $avion)
    {
        $stmt = $this->pdo->prepare("INSERT INTO avions (nom, pays_origine, annee_mise_en_service, constructeur) VALUES (:nom, :pays_origine, :annee_mise_en_service, :constructeur)");

        $stmt->bindValue(':nom', $avion->getNom());
        $stmt->bindValue(':pays_origine', $avion->getPaysOrigine());
        $stmt->bindValue(':annee_mise_en_service', $avion->getAnneeMiseEnService());
        $stmt->bindValue(':constructeur', $avion->getConstructeur());

        $stmt->execute();
    }

    // Récupérer tous les avions
    public function getAll()
    {
        $avions = [];
        $stmt = $this->pdo->query("SELECT * FROM avions");

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $avion = new Avion($data['nom'], $data['pays_origine'], $data['annee_mise_en_service'], $data['constructeur']);
            $avion->hydrate($data); // hydrate l'objet avec les données de la base
            $avions[] = $avion;
        }

        return $avions;
    }
}
