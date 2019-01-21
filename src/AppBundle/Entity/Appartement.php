<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Appartement
 *
 * @ORM\Table(name="appartement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AppartementRepository")
 */
class Appartement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="piece", type="integer")
     */
    private $piece;

    /**
     * @var int
     *
     * @ORM\Column(name="wc", type="integer")
     */
    private $wc;

    /**
     * @var int
     *
     * @ORM\Column(name="douche", type="integer")
     */
    private $douche;

    /**
     * @var bool
     *
     * @ORM\Column(name="dressing", type="boolean", nullable=true)
     */
    private $dressing;

    /**
     * @var bool
     *
     * @ORM\Column(name="balcon", type="boolean", nullable=true)
     */
    private $balcon;

    /**
     * @var string
     *
     * @ORM\Column(name="superficie", type="string", length=255, nullable=true)
     */
    private $superficie;

    /**
     * @var string
     *
     * @ORM\Column(name="cuisine", type="string", length=255, nullable=true)
     */
    private $cuisine;

    /**
     * @var bool
     *
     * @ORM\Column(name="etage", type="boolean", nullable=true)
     */
    private $etage;

    /**
     * @var int
     *
     * @ORM\Column(name="netage", type="integer", nullable=true)
     */
    private $netage;

    /**
     * @var bool
     *
     * @ORM\Column(name="parking", type="boolean", nullable=true)
     */
    private $parking;

    /**
     * @var bool
     *
     * @ORM\Column(name="chauffeau", type="boolean", nullable=true)
     */
    private $chauffeau;

    /**
     * @var bool
     *
     * @ORM\Column(name="videosurveillance", type="boolean", nullable=true)
     */
    private $videosurveillance;

    /**
     * @var bool
     *
     * @ORM\Column(name="alarme", type="boolean", nullable=true)
     */
    private $alarme;

    /**
     * @var bool
     *
     * @ORM\Column(name="ascenceur", type="boolean", nullable=true)
     */
    private $ascenceur;

    /**
     * @var bool
     *
     * @ORM\Column(name="buanderie", type="boolean", nullable=true)
     */
    private $buanderie;

    /**
     * @var bool
     *
     * @ORM\Column(name="interphone", type="boolean", nullable=true)
     */
    private $interphone;

    /**
     * @var bool
     *
     * @ORM\Column(name="meuble", type="boolean", nullable=true)
     */
    private $meuble;

    /**
     * Un appartement appartient a un bien
     *
     * @ORM\OneToOne(targetEntity="Bien")
     * @ORM\JoinColumn(name="bien_id", referencedColumnName="id")
     */
    private $bien;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set piece
     *
     * @param integer $piece
     *
     * @return Appartement
     */
    public function setPiece($piece)
    {
        $this->piece = $piece;

        return $this;
    }

    /**
     * Get piece
     *
     * @return int
     */
    public function getPiece()
    {
        return $this->piece;
    }

    /**
     * Set wc
     *
     * @param integer $wc
     *
     * @return Appartement
     */
    public function setWc($wc)
    {
        $this->wc = $wc;

        return $this;
    }

    /**
     * Get wc
     *
     * @return int
     */
    public function getWc()
    {
        return $this->wc;
    }

    /**
     * Set douche
     *
     * @param integer $douche
     *
     * @return Appartement
     */
    public function setDouche($douche)
    {
        $this->douche = $douche;

        return $this;
    }

    /**
     * Get douche
     *
     * @return int
     */
    public function getDouche()
    {
        return $this->douche;
    }

    /**
     * Set dressing
     *
     * @param integer $dressing
     *
     * @return Appartement
     */
    public function setDressing($dressing)
    {
        $this->dressing = $dressing;

        return $this;
    }

    /**
     * Get dressing
     *
     * @return int
     */
    public function getDressing()
    {
        return $this->dressing;
    }

    /**
     * Set balcon
     *
     * @param integer $balcon
     *
     * @return Appartement
     */
    public function setBalcon($balcon)
    {
        $this->balcon = $balcon;

        return $this;
    }

    /**
     * Get balcon
     *
     * @return int
     */
    public function getBalcon()
    {
        return $this->balcon;
    }

    /**
     * Set superficie
     *
     * @param integer $superficie
     *
     * @return Appartement
     */
    public function setSuperficie($superficie)
    {
        $this->superficie = $superficie;

        return $this;
    }

    /**
     * Get superficie
     *
     * @return int
     */
    public function getSuperficie()
    {
        return $this->superficie;
    }

    /**
     * Set cuisine
     *
     * @param integer $cuisine
     *
     * @return Appartement
     */
    public function setCuisine($cuisine)
    {
        $this->cuisine = $cuisine;

        return $this;
    }

    /**
     * Get cuisine
     *
     * @return int
     */
    public function getCuisine()
    {
        return $this->cuisine;
    }

    /**
     * Set etage
     *
     * @param boolean $etage
     *
     * @return Appartement
     */
    public function setEtage($etage)
    {
        $this->etage = $etage;

        return $this;
    }

    /**
     * Get etage
     *
     * @return bool
     */
    public function getEtage()
    {
        return $this->etage;
    }

    /**
     * Set netage
     *
     * @param integer $netage
     *
     * @return Appartement
     */
    public function setNetage($netage)
    {
        $this->netage = $netage;

        return $this;
    }

    /**
     * Get netage
     *
     * @return int
     */
    public function getNetage()
    {
        return $this->netage;
    }

    /**
     * Set parking
     *
     * @param integer $parking
     *
     * @return Appartement
     */
    public function setParking($parking)
    {
        $this->parking = $parking;

        return $this;
    }

    /**
     * Get parking
     *
     * @return int
     */
    public function getParking()
    {
        return $this->parking;
    }

    /**
     * Set chauffeau
     *
     * @param string $chauffeau
     *
     * @return Appartement
     */
    public function setChauffeau($chauffeau)
    {
        $this->chauffeau = $chauffeau;

        return $this;
    }

    /**
     * Get chauffeau
     *
     * @return string
     */
    public function getChauffeau()
    {
        return $this->chauffeau;
    }

    /**
     * Set videosurveillance
     *
     * @param boolean $videosurveillance
     *
     * @return Appartement
     */
    public function setVideosurveillance($videosurveillance)
    {
        $this->videosurveillance = $videosurveillance;

        return $this;
    }

    /**
     * Get videosurveillance
     *
     * @return bool
     */
    public function getVideosurveillance()
    {
        return $this->videosurveillance;
    }

    /**
     * Set alarme
     *
     * @param boolean $alarme
     *
     * @return Appartement
     */
    public function setAlarme($alarme)
    {
        $this->alarme = $alarme;

        return $this;
    }

    /**
     * Get alarme
     *
     * @return bool
     */
    public function getAlarme()
    {
        return $this->alarme;
    }

    /**
     * Set ascenceur
     *
     * @param boolean $ascenceur
     *
     * @return Appartement
     */
    public function setAscenceur($ascenceur)
    {
        $this->ascenceur = $ascenceur;

        return $this;
    }

    /**
     * Get ascenceur
     *
     * @return bool
     */
    public function getAscenceur()
    {
        return $this->ascenceur;
    }

    /**
     * Set buanderie
     *
     * @param boolean $buanderie
     *
     * @return Appartement
     */
    public function setBuanderie($buanderie)
    {
        $this->buanderie = $buanderie;

        return $this;
    }

    /**
     * Get buanderie
     *
     * @return bool
     */
    public function getBuanderie()
    {
        return $this->buanderie;
    }

    /**
     * Set interphone
     *
     * @param boolean $interphone
     *
     * @return Appartement
     */
    public function setInterphone($interphone)
    {
        $this->interphone = $interphone;

        return $this;
    }

    /**
     * Get interphone
     *
     * @return bool
     */
    public function getInterphone()
    {
        return $this->interphone;
    }

    /**
     * Set meuble
     *
     * @param boolean $meuble
     *
     * @return Appartement
     */
    public function setMeuble($meuble)
    {
        $this->meuble = $meuble;

        return $this;
    }

    /**
     * Get meuble
     *
     * @return bool
     */
    public function getMeuble()
    {
        return $this->meuble;
    }

    /**
     * Set bien
     *
     * @param \AppBundle\Entity\Bien $bien
     *
     * @return Appartement
     */
    public function setBien(\AppBundle\Entity\Bien $bien = null)
    {
        $this->bien = $bien;

        return $this;
    }

    /**
     * Get bien
     *
     * @return \AppBundle\Entity\Bien
     */
    public function getBien()
    {
        return $this->bien;
    }
}
