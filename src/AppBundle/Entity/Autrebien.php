<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Autrebien
 *
 * @ORM\Table(name="autrebien")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AutrebienRepository")
 */
class Autrebien
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
     * @ORM\Column(name="superficie", type="string", length=255)
     */
    private $superficie;

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
     * Set superficie
     *
     * @param string $superficie
     *
     * @return Autrebien
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
     * Set bien
     *
     * @param \AppBundle\Entity\Bien $bien
     *
     * @return Autrebien
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
