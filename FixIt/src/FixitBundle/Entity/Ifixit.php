<?php

namespace FixitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ifixit
 *
 * @ORM\Table(name="ifixit")
 * @ORM\Entity(repositoryClass="FixitBundle\Repository\IfixitRepository")
 */
class ifixit
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
     */

    private $categorie;

    /**
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

    public function __toString()
    {
        return $this->nom;
    }


}

