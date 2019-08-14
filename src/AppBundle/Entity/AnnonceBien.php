<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * AnnonceBien
 *
 * @ORM\Table(name="annonce_bien")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnnonceBienRepository")
 * @Vich\Uploadable
 */
class AnnonceBien
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="resume", type="text", nullable=true)
     */
    private $resume;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="string", length=255, nullable=true)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255, nullable=true)
     */
    private $localisation;

    /**
     * @var bool
     *
     * @ORM\Column(name="disponibilite", type="boolean", nullable=true)
     */
    private $disponibilite;

    /**
     * @var string
     *
     * @ORM\Column(name="tags", type="string", length=255, nullable=true)
     */
    private $tags;

    /**
     * @var string
     *
     * @ORM\Column(name="typebienslug", type="string", length=5, nullable=true)
     */
    private $typebienslug;

    /**
     * @var bool
     *
     * @ORM\Column(name="affichage_prix", type="boolean", nullable=true)
     */
    private $affichagePrix;

    /**
     * @var bool
     *
     * @ORM\Column(name="promotion", type="boolean", nullable=true)
     */
    private $promotion;

    /**
     * @var string
     *
     * @ORM\Column(name="datedebut", type="string", length=255, nullable=true)
     */
    private $datedebut;

    /**
     * @var string
     *
     * @ORM\Column(name="datefin", type="string", length=255, nullable=true)
     */
    private $datefin;

    /**
     * @var bool
     *
     * @ORM\Column(name="fille", type="boolean", nullable=true)
     */
    private $fille;

    /**
     * @var bool
     *
     * @ORM\Column(name="statut", type="boolean", nullable=true, options={"default": 1})
     */
    private $statut;

    /**
     * @var int
     *
     * @ORM\Column(name="vue", type="integer", nullable=true)
     */
    private $vue;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Typebien", inversedBy="annoncebiens")
     * @ORM\JoinColumn(name="typebien_id", referencedColumnName="id")
     */
    private $typebien;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Zone", inversedBy="annoncebiens")
     * @ORM\JoinColumn(name="zone_id", referencedColumnName="id")
     */
    private $zone;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Mode", inversedBy="annoncebiens")
     * @ORM\JoinColumn(name="mode_id", referencedColumnName="id")
     */
    private $mode;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Utilisateur", inversedBy="annoncebiens")
     * @ORM\JoinColumn(name="utilisateur_id", referencedColumnName="id")
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\GallerieAnnonce", mappedBy="annonce")
     */
    private $photos;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="bien_image", fileNameProperty="imageName", size="imageSize", nullable=true)
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $imageSize;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"titre"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\Column(name="publie_par", type="string", length=25, nullable=true)
     */
    private $publiePar;

    /**
     * @var string
     *
     * @Gedmo\Blameable(on="update")
     * @ORM\Column(name="modifie_par", type="string", length=25, nullable=true)
     */
    private $modifiePar;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="publie_le", type="datetimetz", nullable=true)
     */
    private $publieLe;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="modifie_le", type="datetimetz", nullable=true)
     */
    private $modifieLe;


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
     * Set titre
     *
     * @param string $titre
     *
     * @return AnnonceBien
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return AnnonceBien
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set resume
     *
     * @param string $resume
     *
     * @return AnnonceBien
     */
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return string
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * Set prix
     *
     * @param string $prix
     *
     * @return AnnonceBien
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set localisation
     *
     * @param string $localisation
     *
     * @return AnnonceBien
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * Get localisation
     *
     * @return string
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * Set disponibilite
     *
     * @param boolean $disponibilite
     *
     * @return AnnonceBien
     */
    public function setDisponibilite($disponibilite)
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    /**
     * Get disponibilite
     *
     * @return boolean
     */
    public function getDisponibilite()
    {
        return $this->disponibilite;
    }

    /**
     * Set tags
     *
     * @param string $tags
     *
     * @return AnnonceBien
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set typebienslug
     *
     * @param string $typebienslug
     *
     * @return AnnonceBien
     */
    public function setTypebienslug($typebienslug)
    {
        $this->typebienslug = $typebienslug;

        return $this;
    }

    /**
     * Get typebienslug
     *
     * @return string
     */
    public function getTypebienslug()
    {
        return $this->typebienslug;
    }

    /**
     * Set affichagePrix
     *
     * @param boolean $affichagePrix
     *
     * @return AnnonceBien
     */
    public function setAffichagePrix($affichagePrix)
    {
        $this->affichagePrix = $affichagePrix;

        return $this;
    }

    /**
     * Get affichagePrix
     *
     * @return boolean
     */
    public function getAffichagePrix()
    {
        return $this->affichagePrix;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return AnnonceBien
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set imageSize
     *
     * @param integer $imageSize
     *
     * @return AnnonceBien
     */
    public function setImageSize($imageSize)
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    /**
     * Get imageSize
     *
     * @return integer
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return AnnonceBien
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return AnnonceBien
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return AnnonceBien
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set publiePar
     *
     * @param string $publiePar
     *
     * @return AnnonceBien
     */
    public function setPubliePar($publiePar)
    {
        $this->publiePar = $publiePar;

        return $this;
    }

    /**
     * Get publiePar
     *
     * @return string
     */
    public function getPubliePar()
    {
        return $this->publiePar;
    }

    /**
     * Set modifiePar
     *
     * @param string $modifiePar
     *
     * @return AnnonceBien
     */
    public function setModifiePar($modifiePar)
    {
        $this->modifiePar = $modifiePar;

        return $this;
    }

    /**
     * Get modifiePar
     *
     * @return string
     */
    public function getModifiePar()
    {
        return $this->modifiePar;
    }

    /**
     * Set publieLe
     *
     * @param \DateTime $publieLe
     *
     * @return AnnonceBien
     */
    public function setPublieLe($publieLe)
    {
        $this->publieLe = $publieLe;

        return $this;
    }

    /**
     * Get publieLe
     *
     * @return \DateTime
     */
    public function getPublieLe()
    {
        return $this->publieLe;
    }

    /**
     * Set modifieLe
     *
     * @param \DateTime $modifieLe
     *
     * @return AnnonceBien
     */
    public function setModifieLe($modifieLe)
    {
        $this->modifieLe = $modifieLe;

        return $this;
    }

    /**
     * Get modifieLe
     *
     * @return \DateTime
     */
    public function getModifieLe()
    {
        return $this->modifieLe;
    }

    /**
     * Set typebien
     *
     * @param \AppBundle\Entity\Typebien $typebien
     *
     * @return AnnonceBien
     */
    public function setTypebien(\AppBundle\Entity\Typebien $typebien = null)
    {
        $this->typebien = $typebien;

        return $this;
    }

    /**
     * Get typebien
     *
     * @return \AppBundle\Entity\Typebien
     */
    public function getTypebien()
    {
        return $this->typebien;
    }

    /**
     * Set zone
     *
     * @param \AppBundle\Entity\Zone $zone
     *
     * @return AnnonceBien
     */
    public function setZone(\AppBundle\Entity\Zone $zone = null)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return \AppBundle\Entity\Zone
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Set mode
     *
     * @param \AppBundle\Entity\Mode $mode
     *
     * @return AnnonceBien
     */
    public function setMode(\AppBundle\Entity\Mode $mode = null)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get mode
     *
     * @return \AppBundle\Entity\Mode
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set utilisateur
     *
     * @param \AppBundle\Entity\Utilisateur $utilisateur
     *
     * @return AnnonceBien
     */
    public function setUtilisateur(\AppBundle\Entity\Utilisateur $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \AppBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set fille
     *
     * @param boolean $fille
     *
     * @return AnnonceBien
     */
    public function setFille($fille)
    {
        $this->fille = $fille;

        return $this;
    }

    /**
     * Get fille
     *
     * @return boolean
     */
    public function getFille()
    {
        return $this->fille;
    }

    /**
     * Set statut
     *
     * @param boolean $statut
     *
     * @return Annoncebien
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return boolean
     */
    public function getStatut()
    {
        return $this->statut;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add photo
     *
     * @param \AppBundle\Entity\GallerieAnnonce $photo
     *
     * @return AnnonceBien
     */
    public function addPhoto(\AppBundle\Entity\GallerieAnnonce $photo)
    {
        $this->photos[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \AppBundle\Entity\GallerieAnnonce $photo
     */
    public function removePhoto(\AppBundle\Entity\GallerieAnnonce $photo)
    {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set vue
     *
     * @param integer $vue
     *
     * @return AnnonceBien
     */
    public function setVue($vue)
    {
        $this->vue = $vue;

        return $this;
    }

    /**
     * Get vue
     *
     * @return integer
     */
    public function getVue()
    {
        return $this->vue;
    }

    /**
     * Set promotion
     *
     * @param boolean $promotion
     *
     * @return AnnonceBien
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * Get promotion
     *
     * @return boolean
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * Set datedebut
     *
     * @param string $datedebut
     *
     * @return AnnonceBien
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    /**
     * Get datedebut
     *
     * @return string
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * Set datefin
     *
     * @param string $datefin
     *
     * @return AnnonceBien
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;

        return $this;
    }

    /**
     * Get datefin
     *
     * @return string
     */
    public function getDatefin()
    {
        return $this->datefin;
    }
}
