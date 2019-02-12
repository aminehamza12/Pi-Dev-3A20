<?php

namespace FixitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ifixit
 *
 * @ORM\Table(name="ifixit")
 * @ORM\Entity(repositoryClass="FixitBundle\Repository\IfixitRepository")
 */
class Ifixit
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
     * @ORM\Column(name="categorie", type="string", length=255)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="souscategorie", type="string", length=255)
     */
    private $souscategorie;


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
     * Set categorie
     *
     * @param string $categorie
     *
     * @return Ifixit
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set souscategorie
     *
     * @param string $souscategorie
     *
     * @return Ifixit
     */
    public function setSouscategorie($souscategorie)
    {
        $this->souscategorie = $souscategorie;

        return $this;
    }

    /**
     * Get souscategorie
     *
     * @return string
     */
    public function getSouscategorie()
    {
        return $this->souscategorie;
    }
}

