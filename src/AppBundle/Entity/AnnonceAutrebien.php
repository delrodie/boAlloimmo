<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnnonceAutrebien
 *
 * @ORM\Table(name="annonce_autrebien")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnnonceAutrebienRepository")
 */
class AnnonceAutrebien
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
     * @var string
     *
     * @ORM\Column(name="superficie", type="string", length=255, nullable=true)
     */
    private $superficie;

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
     * Set superficie
     *
     * @param string $superficie
     *
     * @return AnnonceAutrebien
     */
    public function setSuperficie($superficie)
    {
        $this->superficie = $superficie;

        return $this;
    }

    /**
     * Get superficie
     *
     * @return string
     */
    public function getSuperficie()
    {
        return $this->superficie;
    }

    /**
     * Set annoncebien
     *
     * @param \AppBundle\Entity\AnnonceBien $annoncebien
     *
     * @return AnnonceAutrebien
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
