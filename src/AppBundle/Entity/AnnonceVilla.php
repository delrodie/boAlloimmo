<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnnonceVilla
 *
 * @ORM\Table(name="annonce_villa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnnonceVillaRepository")
 */
class AnnonceVilla
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
     * @ORM\Column(name="piece", type="integer", nullable=true)
     */
    private $piece;

    /**
     * @var int
     *
     * @ORM\Column(name="douche", type="integer", nullable=true)
     */
    private $douche;

    /**
     * @var int
     *
     * @ORM\Column(name="toilette", type="integer", nullable=true)
     */
    private $toilette;

    /**
     * @var int
     *
     * @ORM\Column(name="dressing", type="boolean", nullable=true)
     */
    private $dressing;

    /**
     * @var int
     *
     * @ORM\Column(name="terasse", type="boolean", nullable=true)
     */
    private $terasse;

    /**
     * @var int
     *
     * @ORM\Column(name="superficie", type="integer", nullable=true)
     */
    private $superficie;

    /**
     * @var int
     *
     * @ORM\Column(name="cuisine", type="integer", nullable=true)
     */
    private $cuisine;

    /**
     * @var int
     *
     * @ORM\Column(name="garage", type="boolean", nullable=true)
     */
    private $garage;

    /**
     * @var bool
     *
     * @ORM\Column(name="piscine", type="boolean", nullable=true)
     */
    private $piscine;

    /**
     * @var int
     *
     * @ORM\Column(name="parking", type="integer", nullable=true)
     */
    private $parking;

    /**
     * @var int
     *
     * @ORM\Column(name="chauffeau", type="boolean", nullable=true)
     */
    private $chauffeau;

    /**
     * @var int
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
     * Une villa appartient a une annonce bien
     *
     * @ORM\OneToOne(targetEntity="AnnonceBien")
     * @ORM\JoinColumn(name="annoncebien_id", referencedColumnName="id")
     */
    private $annoncebien;


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
     * @return AnnonceVilla
     */
    public function setPiece($piece)
    {
        $this->piece = $piece;

        return $this;
    }

    /**
     * Get piece
     *
     * @return integer
     */
    public function getPiece()
    {
        return $this->piece;
    }

    /**
     * Set douche
     *
     * @param integer $douche
     *
     * @return AnnonceVilla
     */
    public function setDouche($douche)
    {
        $this->douche = $douche;

        return $this;
    }

    /**
     * Get douche
     *
     * @return integer
     */
    public function getDouche()
    {
        return $this->douche;
    }

    /**
     * Set toilette
     *
     * @param integer $toilette
     *
     * @return AnnonceVilla
     */
    public function setToilette($toilette)
    {
        $this->toilette = $toilette;

        return $this;
    }

    /**
     * Get toilette
     *
     * @return integer
     */
    public function getToilette()
    {
        return $this->toilette;
    }

    /**
     * Set dressing
     *
     * @param boolean $dressing
     *
     * @return AnnonceVilla
     */
    public function setDressing($dressing)
    {
        $this->dressing = $dressing;

        return $this;
    }

    /**
     * Get dressing
     *
     * @return boolean
     */
    public function getDressing()
    {
        return $this->dressing;
    }

    /**
     * Set terasse
     *
     * @param boolean $terasse
     *
     * @return AnnonceVilla
     */
    public function setTerasse($terasse)
    {
        $this->terasse = $terasse;

        return $this;
    }

    /**
     * Get terasse
     *
     * @return boolean
     */
    public function getTerasse()
    {
        return $this->terasse;
    }

    /**
     * Set superficie
     *
     * @param integer $superficie
     *
     * @return AnnonceVilla
     */
    public function setSuperficie($superficie)
    {
        $this->superficie = $superficie;

        return $this;
    }

    /**
     * Get superficie
     *
     * @return integer
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
     * @return AnnonceVilla
     */
    public function setCuisine($cuisine)
    {
        $this->cuisine = $cuisine;

        return $this;
    }

    /**
     * Get cuisine
     *
     * @return integer
     */
    public function getCuisine()
    {
        return $this->cuisine;
    }

    /**
     * Set garage
     *
     * @param boolean $garage
     *
     * @return AnnonceVilla
     */
    public function setGarage($garage)
    {
        $this->garage = $garage;

        return $this;
    }

    /**
     * Get garage
     *
     * @return boolean
     */
    public function getGarage()
    {
        return $this->garage;
    }

    /**
     * Set piscine
     *
     * @param boolean $piscine
     *
     * @return AnnonceVilla
     */
    public function setPiscine($piscine)
    {
        $this->piscine = $piscine;

        return $this;
    }

    /**
     * Get piscine
     *
     * @return boolean
     */
    public function getPiscine()
    {
        return $this->piscine;
    }

    /**
     * Set parking
     *
     * @param integer $parking
     *
     * @return AnnonceVilla
     */
    public function setParking($parking)
    {
        $this->parking = $parking;

        return $this;
    }

    /**
     * Get parking
     *
     * @return integer
     */
    public function getParking()
    {
        return $this->parking;
    }

    /**
     * Set chauffeau
     *
     * @param boolean $chauffeau
     *
     * @return AnnonceVilla
     */
    public function setChauffeau($chauffeau)
    {
        $this->chauffeau = $chauffeau;

        return $this;
    }

    /**
     * Get chauffeau
     *
     * @return boolean
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
     * @return AnnonceVilla
     */
    public function setVideosurveillance($videosurveillance)
    {
        $this->videosurveillance = $videosurveillance;

        return $this;
    }

    /**
     * Get videosurveillance
     *
     * @return boolean
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
     * @return AnnonceVilla
     */
    public function setAlarme($alarme)
    {
        $this->alarme = $alarme;

        return $this;
    }

    /**
     * Get alarme
     *
     * @return boolean
     */
    public function getAlarme()
    {
        return $this->alarme;
    }

    /**
     * Set buanderie
     *
     * @param boolean $buanderie
     *
     * @return AnnonceVilla
     */
    public function setBuanderie($buanderie)
    {
        $this->buanderie = $buanderie;

        return $this;
    }

    /**
     * Get buanderie
     *
     * @return boolean
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
     * @return AnnonceVilla
     */
    public function setInterphone($interphone)
    {
        $this->interphone = $interphone;

        return $this;
    }

    /**
     * Get interphone
     *
     * @return boolean
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
     * @return AnnonceVilla
     */
    public function setMeuble($meuble)
    {
        $this->meuble = $meuble;

        return $this;
    }

    /**
     * Get meuble
     *
     * @return boolean
     */
    public function getMeuble()
    {
        return $this->meuble;
    }

    /**
     * Set annoncebien
     *
     * @param \AppBundle\Entity\AnnonceBien $annoncebien
     *
     * @return AnnonceVilla
     */
    public function setAnnoncebien(\AppBundle\Entity\AnnonceBien $annoncebien = null)
    {
        $this->annoncebien = $annoncebien;

        return $this;
    }

    /**
     * Get annoncebien
     *
     * @return \AppBundle\Entity\AnnonceBien
     */
    public function getAnnoncebien()
    {
        return $this->annoncebien;
    }
}
