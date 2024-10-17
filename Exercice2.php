<?php

// Classe Vehicule
 abstract class Vehicule
{
    protected $demarrer = false;
    protected $vitesse = 0;
    protected $vitesseMax;

    public function __construct($vitesseMax)
    {
        $this->vitesseMax = $vitesseMax;
    }

    abstract function decelerer($vitesse);
    abstract function accelerer($vitesse);

    public function demarrer()
    {
        $this->demarrer = true;
    }

    public function eteindre()
    {
        $this->demarrer = false;
    }

    public function estDemarre()
    {
        return $this->demarrer;
    }

    public function estEteint()
    {
        return !$this->demarrer;
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
        $chaine = "Ceci est un véhicule <br/>";
        $chaine .= "---------------------- <br/>";
        return $chaine;
    }
}

// Classe Avion
class Avion extends Vehicule
{
    private $altitude = 0;
    private $plafond;
    public $trainAtterrissage = false;

    const PLAFOND_MAX = 40000;
    const VITESSE_MAX_AVION = 2000;

    public function __construct($vitesseMax, $plafond)
    {
        parent::__construct($vitesseMax);
        $this->setPlafond($plafond);
    }

    public function setPlafond($plafond)
    {
        if ($plafond > self::PLAFOND_MAX) {
            throw new Exception("Le plafond ne peut pas dépasser " . self::PLAFOND_MAX . " mètres.");
        }
        $this->plafond = $plafond;
    }

    public function getPlafond()
    {
        return $this->plafond;
    }

    public function decoller()
    {
        if ($this->getVitesse() >= 120) {
            $this->altitude = 100;
        } else {
            trigger_error("L'avion doit atteindre une vitesse de 120 km/h pour décoller.", E_USER_WARNING);
        }
    }

    public function atterrir()
    {
        if ($this->altitude > 0) {
            $this->altitude = 0;

        } else {
            trigger_error("L'avion est déjà à une altitude de 0 m.", E_USER_WARNING);
        }
    }

    public function prendreAltitude($altitude)
    {
        if ($this->estDemarre() && $this->altitude >= 100) {
            $this->altitude += $altitude;
            if ($this->altitude > $this->plafond) {
                $this->altitude = $this->plafond;
            }
        } else {
            trigger_error("Impossible de prendre de l'altitude. L'avion doit être décollé et à une altitude de 100 m ou plus.", E_USER_WARNING);
        }
    }

    public function perdreAltitude($altitude)
    {
        if ($this->estDemarre() && $this->altitude > 0) {
            $this->altitude -= $altitude;
            if ($this->altitude < 0) {
                $this->altitude = 0;
            }
        } else {
            trigger_error("Impossible de perdre d'altitude. L'avion doit être décollé.", E_USER_WARNING);
        }
    }

    public function sortirTrainAtterrissage()
    {
        $this->trainAtterrissage = true;
    }

    public function rentrerTrainAtterrissage()
    {
        if ($this->altitude <= 300) {
            $this->trainAtterrissage = false;
        } else {
            trigger_error("Impossible de rentrer le train d'atterrissage à une altitude supérieure à 300 mètres.", E_USER_WARNING);
        }
    }

    public function getAltitude()
    {
        return $this->altitude;
    }

    public function __toString()
    {
        $chaine = parent::__toString();
        $chaine .= "L'avion a une altitude de " . $this->altitude . " m <br/>";
        $chaine .= "Le plafond de l'avion est de " . $this->plafond . " m <br/>";
        $chaine .= "La vitesse actuelle est de " . $this->getVitesse() . " km/h <br/>";
        $chaine .= "Le train d'atterrissage est " . ($this->trainAtterrissage ? "sorti" : "rentré") . "<br/>";
        return $chaine;
    }

    public function accelerer($vitesse)
    {
        $this->vitesse += $vitesse;
        if ($this->vitesse > $this->getVitesseMax()) {
            $this->vitesse = $this->getVitesseMax();
        }
    }

    public function decelerer($vitesse)
    {
        $this->vitesse -= $vitesse;
        if ($this->vitesse < 0) {
            $this->vitesse = 0;
        }
    }
}


try {
    $monAvion = new Avion(1500, 12000);

    echo $monAvion;

    $monAvion->demarrer();
    echo "L'avion est démarré.<br/>";

    $monAvion->accelerer(130);
    echo "Vitesse actuelle après accélération : " . $monAvion->getVitesse() . " km/h<br/>";

    $monAvion->decoller();
    echo "Altitude après décollage : " . $monAvion->getAltitude() . " m<br/>";

    $monAvion->prendreAltitude(5000);
    echo "Altitude après prise d'altitude : " . $monAvion->getAltitude() . " m<br/>";

    $monAvion->perdreAltitude(3000);
    echo "Altitude après perte d'altitude : " . $monAvion->getAltitude() . " m<br/>";

    $monAvion->atterrir();
    echo "Altitude après atterrissage : " . $monAvion->getAltitude() . " m<br/>";

    $monAvion->sortirTrainAtterrissage();
    echo "Le train d'atterrissage est maintenant " . ($monAvion->trainAtterrissage ? "sorti" : "rentré") . ".<br/>";

    $monAvion->rentrerTrainAtterrissage();
    echo "Le train d'atterrissage est maintenant " . ($monAvion->trainAtterrissage ? "sorti" : "rentré") . ".<br/>";

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "<br/>";
}
