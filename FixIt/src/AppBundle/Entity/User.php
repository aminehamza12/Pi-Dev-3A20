<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
<<<<<<< HEAD
use FOS\MessageBundle\Model\ParticipantInterface;

=======
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
<<<<<<< HEAD
class User extends BaseUser implements ParticipantInterface
=======
class User extends BaseUser
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    protected $prenom;

<<<<<<< HEAD
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_profil", type="boolean",)
     */
    protected $isprofil;

    /**
     * @return bool
     */
    public function isIsprofil()
    {
        return $this->isprofil;
    }

    /**
     * @param bool $isprofil
     */
    public function setIsprofil($isprofil)
    {
        $this->isprofil = $isprofil;
    }

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->isprofil = 0;
    }

=======
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
     * @return User
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }
<<<<<<< HEAD

    /**
     * @ORM\OneToMany(targetEntity="ForumBundle\Entity\Reclamation", mappedBy="user")
     */
    private $reclamations;

    /**
     * Add reclamation
     *
     * @param \ForumBundle\Entity\Reclamation $reclamation
     *
     * @return User
     */
    public function addReclamation(\ForumBundle\Entity\Reclamation $reclamation)
    {
        $this->reclamations[] = $reclamation;

        return $this;
    }

    /**
     * Remove reclamation
     *
     * @param \ForumBundle\Entity\Reclamation $reclamation
     */
    public function removeReclamation(\ForumBundle\Entity\Reclamation $reclamation)
    {
        $this->reclamations->removeElement($reclamation);
    }

    /**
     * Get reclamations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReclamations()
    {
        return $this->reclamations;
    }
=======
>>>>>>> 1cbb02caab7bb0b2d88eca07f7e88dcb96ab6a29
}

