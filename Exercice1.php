<?php

abstract class Vehicule
{
    protected $demarrer = FALSE;
    protected $vitesse = 0;
    protected $vitesseMax;
    protected $freinStationnement = TRUE;

    abstract function demarrer();
    abstract function eteindre();
    abstract function decelerer($vitesse);
    abstract function accelerer($vitesse);
    abstract function activerFreinStationnement();
    abstract function desactiverFreinStationnement();

    public function __toString()
    {
        $chaine = "Ceci est un véhicule <br/>";
        $chaine .= "---------------------- <br/>";
        return $chaine;
    }
}

class Voiture extends Vehicule
{
    const VITESSE_MAX = 360;
    private static $_compteur = 0;

    public static function getNombreVoiture()
    {
        return self::$_compteur;
    }

    public function __construct($vMax)
    {
        $this->setVitesseMax($vMax);
        self::$_compteur++;
    }

    public function demarrer()
    {
        $this->demarrer = TRUE;
    }

    public function eteindre()
    {
        $this->demarrer = FALSE;
        $this->setVitesse(0);
    }

    public function estDemarre()
    {
        return $this->demarrer;
    }

    public function accelerer($vitesse)
    {
        if ($this->freinStationnement) {
            trigger_error("Impossible d'accélérer avec le frein de stationnement activé !", E_USER_WARNING);
            return;
        }

        if ($this->estDemarre()) {
            if ($this->vitesse == 0) {
                $vitesseAcc = min(10, $vitesse);
            } else {
                $vitesseAcc = min($vitesse, $this->vitesse * 0.3);
            }

            $this->setVitesse($this->getVitesse() + $vitesseAcc);
        }
        else
        {
            trigger_error("On ne peut pas accélérer ! Le moteur est à l'arrêt !", E_USER_WARNING);
        }
    }

    public function decelerer($vitesse)
    {
        if ($this->estDemarre()) {
            $vitesseDec = min($vitesse, 20);
            $this->setVitesse($this->getVitesse() - $vitesseDec);
        }
    }

    public function activerFreinStationnement()
    {
        if ($this->vitesse == 0) {
            $this->freinStationnement = TRUE;
        } else {
            trigger_error("Le frein de stationnement ne peut être activé que lorsque la voiture est à l'arrêt !", E_USER_WARNING);
        }
    }

    public function desactiverFreinStationnement()
    {
        $this->freinStationnement = FALSE;
    }

    public function setVitesseMax($vMax)
    {
        if ($vMax > self::VITESSE_MAX)
        {
            $this->vitesseMax = self::VITESSE_MAX;
        }
        elseif ($vMax > 0)
        {
            $this->vitesseMax = $vMax;
        }
        else
        {
            $this->vitesseMax = 0;
        }
    }

    public function setVitesse($vitesse)
    {
        if ($vitesse > $this->getVitesseMax())
        {
            $this->vitesse = $this->getVitesseMax();
        }
        elseif ($vitesse > 0)
        {
            $this->vitesse = $vitesse;
        }
        else
        {
            $this->vitesse = 0;
        }
    }

    public function getVitesse()
    {
        return $this->vitesse;
    }

    public function getVitesseMax()
    {
        return $this->vitesseMax;
    }

    public function __toString()
    {
        $chaine = parent::__toString();
        $chaine .= "La voiture a une vitesse maximale de " . $this->vitesseMax . " km/h <br/>";
        if ($this->demarrer)
        {
            $chaine .= "Elle est démarrée <br/>";
            $chaine .= "Sa vitesse est actuellement de " . $this->getVitesse() . " km/h <br/>";
        }
        else
        {
            $chaine .= "Elle est arrêtée <br/>";
        }

        if ($this->freinStationnement) {
            $chaine .= "Le frein de stationnement est activé.<br/>";
        } else {
            $chaine .= "Le frein de stationnement est désactivé.<br/>";
        }

        return $chaine;
    }
}

// Tests

// Test 1 : Démarrage et accélération initiale
echo "<hr><strong>Test 1 :</strong> Démarrage et accélération initiale<br/>";
$veh1 = new Voiture(110);
$veh1->demarrer();
$vitesseAvant = $veh1->getVitesse();
$veh1->desactiverFreinStationnement();
$veh1->accelerer(40); // Limitée à 10 car c'est le démarrage
$vitesseApres = $veh1->getVitesse();
echo "Vitesse avant accélération : $vitesseAvant km/h<br/>";
echo "Vitesse après accélération : $vitesseApres km/h<br/>";
echo $veh1;

// Test 2 : Accélération avec limitation à 30%
echo "<hr><strong>Test 2 :</strong> Accélération avec limitation à 30%<br/>";
$veh2 = new Voiture(110);
$veh2->demarrer();
$vitesseAvant = $veh2->getVitesse();
$veh2->desactiverFreinStationnement();
$veh2->accelerer(20); // Peut accélérer de 30%, donc max 20 km/h
$vitesseApres = $veh2->getVitesse();
echo "Vitesse avant accélération : $vitesseAvant km/h<br/>";
echo "Vitesse après accélération : $vitesseApres km/h<br/>";
echo $veh2;

// Test 3 : Nouvelle accélération avec limitation à 30% sur la vitesse actuelle
echo "<hr><strong>Test 3 :</strong> Nouvelle accélération avec limitation à 30%<br/>";
$veh3 = new Voiture(110);
$veh3->demarrer();
$vitesseAvant = $veh3->getVitesse();
$veh3->desactiverFreinStationnement();
$veh3->accelerer(20); // Limitée à 10 pour démarrage
$vitesseApres = $veh3->getVitesse();
echo "Vitesse avant accélération : $vitesseAvant km/h<br/>";
echo "Vitesse après accélération : $vitesseApres km/h<br/>";
$veh3->accelerer(20);
$vitesseApres2 = $veh3->getVitesse();
echo "Vitesse après deuxième accélération : $vitesseApres2 km/h<br/>";
echo $veh3;

// Test 4 : Décélération limitée à 20 km/h
echo "<hr><strong>Test 4 :</strong> Décélération limitée à 20 km/h<br/>";
$veh4 = new Voiture(110);
$veh4->demarrer();
$veh4->desactiverFreinStationnement();
$veh4->accelerer(40);
$veh4->accelerer(20);
$vitesseAvant = $veh4->getVitesse();
$veh4->decelerer(30);
$vitesseApres = $veh4->getVitesse();
echo "Vitesse avant décélération : $vitesseAvant km/h<br/>";
echo "Vitesse après décélération : $vitesseApres km/h<br/>";
echo $veh4;

// Test 5 : Tentative d'accélération sans désactiver le frein de stationnement
echo "<hr><strong>Test 5 :</strong> Activation du frein de stationnement<br/>";
$veh5 = new Voiture(110);
$veh5->demarrer();
$veh5->accelerer(10);
echo $veh5;

// Test 6 : Désactivation du frein de stationnement et accélération
echo "<hr><strong>Test 6 :</strong> Désactivation du frein de stationnement et accélération<br/>";
$veh6 = new Voiture(110);
$veh6->demarrer();
$veh6->desactiverFreinStationnement(); // Désactivation du frein
$vitesseAvant = $veh6->getVitesse();
$veh6->accelerer(10); // Accélère normalement
$vitesseApres = $veh6->getVitesse();
echo "Vitesse avant accélération : $vitesseAvant km/h<br/>";
echo "Vitesse après accélération : $vitesseApres km/h<br/>";
echo $veh6;

echo "<hr>############################ <br/>";
echo "Nombre de voitures instanciées : " . Voiture::getNombreVoiture() . "<br/>";
