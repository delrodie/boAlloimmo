<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnnonceImmeuble
 *
 * @ORM\Table(name="annonce_immeuble")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnnonceImmeubleRepository")
 */
class AnnonceImmeuble
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
     * Set appartement
     *
     * @param integer $appartement
     *
     * @return AnnonceImmeuble
     */
    public function setAppartement($appartement)
    {
        $this->appartement = $appartement;

        return $this;
    }

    /**
     * Get appartement
     *
     * @return integer
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
     * @return AnnonceImmeuble
     */
    public function setEtage($etage)
    {
        $this->etage = $etage;

        return $this;
    }

    /**
     * Get etage
     *
     * @return integer
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
     * @return AnnonceImmeuble
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
     * Set ascenceur
     *
     * @param boolean $ascenceur
     *
     * @return AnnonceImmeuble
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
     * Set annoncebien
     *
     * @param \AppBundle\Entity\AnnonceBien $annoncebien
     *
     * @return AnnonceImmeuble
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
