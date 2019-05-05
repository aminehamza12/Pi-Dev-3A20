<?php

namespace FixitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
<<<<<<< HEAD
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
=======
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29

/**
 * Workshops
 *
 * @ORM\Table(name="workshops")
 * @ORM\Entity(repositoryClass="FixitBundle\Repository\WorkshopsRepository")
<<<<<<< HEAD
 * @Vich\Uploadable
=======
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
 */
class Workshops
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
<<<<<<< HEAD
     * @ORM\ManyToOne(targetEntity="categorieifixit")
     * @ORM\JoinColumn(name="categorie", referencedColumnName="id")
=======
     * @ORM\ManyToOne(targetEntity="categorieEvent")
     * @ORM\JoinColumn(name="categorie", referencedColumnName="type")
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
     */

    private $categorie;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="date")
     */
    private $dateDebut;

    /**
<<<<<<< HEAD
     *  @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="date")
=======
     * @var string
     *
     * @ORM\Column(name="dateFin", type="string", length=255)
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=255)
     */
    private $lieu;

    /**
<<<<<<< HEAD
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255)
     */
    private $long;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255)
     */
    private $lat;

    /**
=======
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
     * @var int
     *
     * @ORM\Column(name="vu", type="integer")
     */
    private $vu;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrjaime", type="integer")
     */
    private $nbrjaime;

    /**
     * @var int
     *
<<<<<<< HEAD
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;

    /**
     * @var int
     *
=======
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
     * @ORM\Column(name="nbrparticipant", type="integer")
     */
    private $nbrparticipant;

    /**
<<<<<<< HEAD
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="workshop_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    // ...



    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    /**
     * Workshops constructor.
     */
    public function __construct()
    {
    }
=======
     * @var string
     *
     * @ORM\Column(name="imageurl", type="string", length=255)
     */
    private $imageurl;
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Workshops
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Workshops
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
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

<<<<<<< HEAD
    /**
     * @return string
     */
    public function getLong()
    {
        return $this->long;
    }

    /**
     * @param string $long
     */
    public function setLong($long)
    {
        $this->long = $long;
    }

    /**
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param string $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

=======
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29


    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Workshops
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
<<<<<<< HEAD
     * @param  \DateTime $dateFin
=======
     * @param string $dateFin
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
     *
     * @return Workshops
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
<<<<<<< HEAD
     * @return \DateTime
=======
     * @return string
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set lieu
     *
     * @param string $lieu
     *
     * @return Workshops
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set vu
     *
     * @param integer $vu
     *
     * @return Workshops
     */
    public function setVu($vu)
    {
        $this->vu = $vu;

        return $this;
    }

    /**
     * Get vu
     *
     * @return int
     */
    public function getVu()
    {
        return $this->vu;
    }

    /**
     * Set nbrjaime
     *
     * @param integer $nbrjaime
     *
     * @return Workshops
     */
    public function setNbrjaime($nbrjaime)
    {
        $this->nbrjaime = $nbrjaime;

        return $this;
    }

    /**
     * Get nbrjaime
     *
     * @return int
     */
    public function getNbrjaime()
    {
        return $this->nbrjaime;
    }

    /**
     * Set nbrparticipant
     *
     * @param integer $nbrparticipant
     *
     * @return Workshops
     */
    public function setNbrparticipant($nbrparticipant)
    {
        $this->nbrparticipant = $nbrparticipant;

        return $this;
    }

    /**
     * Get nbrparticipant
     *
     * @return int
     */
    public function getNbrparticipant()
    {
        return $this->nbrparticipant;
    }

<<<<<<< HEAD
    public function __toString()
    {
        return (string)$this->id;
    }


=======
    /**
     * Set imageurl
     *
     * @param string $imageurl
     *
     * @return Workshops
     */
    public function setImageurl($imageurl)
    {
        $this->imageurl = $imageurl;

        return $this;
    }

    /**
     * Get imageurl
     *
     * @return string
     */
    public function getImageurl()
    {
        return $this->imageurl;
    }
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
}

