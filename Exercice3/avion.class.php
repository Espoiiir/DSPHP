<?php


class Avion
{
    private $id;
    private $nom;
    private $paysOrigine;
    private $anneeMiseEnService;
    private $constructeur;

    // Constructeur
    public function __construct($nom, $paysOrigine, $anneeMiseEnService, $constructeur)
    {
        $this->nom = $nom;
        $this->paysOrigine = $paysOrigine;
        $this->anneeMiseEnService = $anneeMiseEnService;
        $this->constructeur = $constructeur;
    }


    public function hydrate(array $data)
    {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }
        if (isset($data['nom'])) {
            $this->nom = $data['nom'];
        }
        if (isset($data['pays_origine'])) {
            $this->paysOrigine = $data['pays_origine'];
        }
        if (isset($data['annee_mise_en_service'])) {
            $this->anneeMiseEnService = $data['annee_mise_en_service'];
        }
        if (isset($data['constructeur'])) {
            $this->constructeur = $data['constructeur'];
        }
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPaysOrigine()
    {
        return $this->paysOrigine;
    }

    public function getAnneeMiseEnService()
    {
        return $this->anneeMiseEnService;
    }

    public function getConstructeur()
    {
        return $this->constructeur;
    }

    // Setters
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function setPaysOrigine($paysOrigine)
    {
        $this->paysOrigine = $paysOrigine;
    }

    public function setAnneeMiseEnService($annee)
    {
        $this->anneeMiseEnService = $annee;
    }

    public function setConstructeur($constructeur)
    {
        $this->constructeur = $constructeur;
    }
}
