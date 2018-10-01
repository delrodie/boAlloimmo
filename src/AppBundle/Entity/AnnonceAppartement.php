<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnnonceAppartement
 *
 * @ORM\Table(name="annonce_appartement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnnonceAppartementRepository")
 */
class AnnonceAppartement
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
     * @return AnnonceAppartement
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
     * Set wc
     *
     * @param integer $wc
     *
     * @return AnnonceAppartement
     */
    public function setWc($wc)
    {
        $this->wc = $wc;

        return $this;
    }

    /**
     * Get wc
     *
     * @return integer
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
     * @return AnnonceAppartement
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
     * Set dressing
     *
     * @param boolean $dressing
     *
     * @return AnnonceAppartement
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
     * Set balcon
     *
     * @param boolean $balcon
     *
     * @return AnnonceAppartement
     */
    public function setBalcon($balcon)
    {
        $this->balcon = $balcon;

        return $this;
    }

    /**
     * Get balcon
     *
     * @return boolean
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
     * @return AnnonceAppartement
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
     * @return AnnonceAppartement
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
     * Set etage
     *
     * @param boolean $etage
     *
     * @return AnnonceAppartement
     */
    public function setEtage($etage)
    {
        $this->etage = $etage;

        return $this;
    }

    /**
     * Get etage
     *
     * @return boolean
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
     * @return AnnonceAppartement
     */
    public function setNetage($netage)
    {
        $this->netage = $netage;

        return $this;
    }

    /**
     * Get netage
     *
     * @return integer
     */
    public function getNetage()
    {
        return $this->netage;
    }

    /**
     * Set parking
     *
     * @param boolean $parking
     *
     * @return AnnonceAppartement
     */
    public function setParking($parking)
    {
        $this->parking = $parking;

        return $this;
    }

    /**
     * Get parking
     *
     * @return boolean
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
     * @return AnnonceAppartement
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
     * @return AnnonceAppartement
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
     * @return AnnonceAppartement
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
     * Set ascenceur
     *
     * @param boolean $ascenceur
     *
     * @return AnnonceAppartement
     */
    public function setAscenceur($ascenceur)
    {
        $this->ascenceur = $ascenceur;

        return $this;
    }

    /**
     * Get ascenceur
     *
     * @return boolean
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
     * @return AnnonceAppartement
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
     * @return AnnonceAppartement
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
     * @return AnnonceAppartement
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
     * @return AnnonceAppartement
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
