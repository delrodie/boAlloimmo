<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PartenaireCompte
 *
 * @ORM\Table(name="partenaire_compte")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartenaireCompteRepository")
 */
class PartenaireCompte
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
     * @ORM\Column(name="partenaire", type="string", length=255)
     */
    private $partenaire;

    /**
     * @var string
     *
     * @ORM\Column(name="utilisateur", type="string", length=255)
     */
    private $user;


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
     * Set partenaire
     *
     * @param string $partenaire
     *
     * @return PartenaireCompte
     */
    public function setPartenaire($partenaire)
    {
        $this->partenaire = $partenaire;

        return $this;
    }

    /**
     * Get partenaire
     *
     * @return string
     */
    public function getPartenaire()
    {
        return $this->partenaire;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return PartenaireCompte
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }
}
