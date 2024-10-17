<?php


require 'Avion.class.php';
require 'ManagerAvion.class.php';

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=Avion', 'root', 'root');


$manager = new ManagerAvion($pdo);


$avion1 = new Avion('F4U Corsair', 'Etats-Unis', 1943, 'Chance Vought Aircraft Division');
$avion2 = new Avion('Spitfire', 'Royaume-Uni', 1938, 'Supermarine');
$avion3 = new Avion('Messerschmitt Bf 109', 'Allemagne', 1937, 'Messerschmitt');

// Ajout des avions à la base de données
$manager->add($avion1);
$manager->add($avion2);
$manager->add($avion3);

// Récupérer tous les avions
$avions = $manager->getAll();

// Afficher les avions
foreach ($avions as $avion) {
    echo "Nom : " . $avion->getNom() . "<br/>";
    echo "Pays d'origine : " . $avion->getPaysOrigine() . "<br/>";
    echo "Année de mise en service : " . $avion->getAnneeMiseEnService() . "<br/>";
    echo "Constructeur : " . $avion->getConstructeur() . "<br/>";
    echo "<hr/>";
}
