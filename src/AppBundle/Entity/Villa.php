<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Villa
 *
 * @ORM\Table(name="villa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VillaRepository")
 */
class Villa
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
     * @ORM\Column(name="douche", type="integer")
     */
    private $douche;

    /**
     * @var int
     *
     * @ORM\Column(name="toilette", type="integer")
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
     * @ORM\Column(name="superficie", type="integer")
     */
    private $superficie;

    /**
     * @var int
     *
     * @ORM\Column(name="cuisine", type="integer")
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
     * Une villa appartient a un bien
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
     * @return Villa
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
     * Set douche
     *
     * @param integer $douche
     *
     * @return Villa
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
     * Set toilette
     *
     * @param integer $toilette
     *
     * @return Villa
     */
    public function setToilette($toilette)
    {
        $this->toilette = $toilette;

        return $this;
    }

    /**
     * Get toilette
     *
     * @return int
     */
    public function getToilette()
    {
        return $this->toilette;
    }

    /**
     * Set dressing
     *
     * @param integer $dressing
     *
     * @return Villa
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
     * Set terasse
     *
     * @param integer $terasse
     *
     * @return Villa
     */
    public function setTerasse($terasse)
    {
        $this->terasse = $terasse;

        return $this;
    }

    /**
     * Get terasse
     *
     * @return int
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
     * @return Villa
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
     * @return Villa
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
     * Set garage
     *
     * @param integer $garage
     *
     * @return Villa
     */
    public function setGarage($garage)
    {
        $this->garage = $garage;

        return $this;
    }

    /**
     * Get garage
     *
     * @return int
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
     * @return Villa
     */
    public function setPiscine($piscine)
    {
        $this->piscine = $piscine;

        return $this;
    }

    /**
     * Get piscine
     *
     * @return bool
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
     * @return Villa
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
     * @param integer $chauffeau
     *
     * @return Villa
     */
    public function setchauffeau($chauffeau)
    {
        $this->chauffeau = $chauffeau;

        return $this;
    }

    /**
     * Get chauffeau
     *
     * @return int
     */
    public function getChauffeau()
    {
        return $this->chauffeau;
    }

    /**
     * Set videosurveillance
     *
     * @param integer $videosurveillance
     *
     * @return Villa
     */
    public function setVideosurveillance($videosurveillance)
    {
        $this->videosurveillance = $videosurveillance;

        return $this;
    }

    /**
     * Get videosurveillance
     *
     * @return int
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
     * @return Villa
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
     * Set buanderie
     *
     * @param boolean $buanderie
     *
     * @return Villa
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
     * @return Villa
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
     * @return Villa
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
     * @return Villa
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
