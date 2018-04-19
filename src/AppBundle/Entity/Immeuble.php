<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Immeuble
 *
 * @ORM\Table(name="immeuble")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImmeubleRepository")
 */
class Immeuble
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
     * @ORM\Column(name="appartement", type="integer", nullable=true)
     */
    private $appartement;

    /**
     * @var int
     *
     * @ORM\Column(name="etage", type="integer", nullable=true)
     */
    private $etage;

    /**
     * @var int
     *
     * @ORM\Column(name="parking", type="integer", nullable=true)
     */
    private $parking;

    /**
     * @var bool
     *
     * @ORM\Column(name="ascenceur", type="boolean", nullable=true)
     */
    private $ascenceur;

    /**
     * Un autrebien appartient a un bien
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
     * Set appartement
     *
     * @param integer $appartement
     *
     * @return Immeuble
     */
    public function setAppartement($appartement)
    {
        $this->appartement = $appartement;

        return $this;
    }

    /**
     * Get appartement
     *
     * @return int
     */
    public function getAppartement()
    {
        return $this->appartement;
    }

    /**
     * Set etage
     *
     * @param integer $etage
     *
     * @return Immeuble
     */
    public function setEtage($etage)
    {
        $this->etage = $etage;

        return $this;
    }

    /**
     * Get etage
     *
     * @return int
     */
    public function getEtage()
    {
        return $this->etage;
    }

    /**
     * Set parking
     *
     * @param integer $parking
     *
     * @return Immeuble
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
     * Set ascenceur
     *
     * @param boolean $ascenceur
     *
     * @return Immeuble
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
     * Set bien
     *
     * @param \AppBundle\Entity\Bien $bien
     *
     * @return Immeuble
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
