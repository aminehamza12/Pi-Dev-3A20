<?php

namespace FixitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
<<<<<<< HEAD
 * ifixit
=======
 * Ifixit
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
 *
 * @ORM\Table(name="ifixit")
 * @ORM\Entity(repositoryClass="FixitBundle\Repository\IfixitRepository")
 */
<<<<<<< HEAD
class ifixit
=======
class Ifixit
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
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
<<<<<<< HEAD
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @ORM\ManyToOne(targetEntity="categorieifixit")
     * @ORM\JoinColumn(name="categorie", referencedColumnName="id")
=======
     * @ORM\ManyToOne(targetEntity="categorieEvent")
     * @ORM\JoinColumn(name="categorie", referencedColumnName="type")
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
     */

    private $categorie;

    /**
<<<<<<< HEAD
     * @var integer
     *
     * @ORM\Column(name="nbr", type="integer")
     */
    private $nbr;

    /**
     * @return int
     */
    public function getNbr()
    {
        return $this->nbr;
    }

    /**
     * @param int $nbr
     */
    public function setNbr($nbr)
    {
        $this->nbr = $nbr;
    }



    /**
=======
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
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

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

<<<<<<< HEAD
    public function __toString()
    {
        return $this->nom;
    }

=======
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29

}

