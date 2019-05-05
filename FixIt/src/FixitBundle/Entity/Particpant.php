<?php

namespace FixitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Particpant
 *
 * @ORM\Table(name="particpant")
 * @ORM\Entity(repositoryClass="FixitBundle\Repository\ParticpantRepository")
 */
class Particpant
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity="Workshops")
     * @ORM\JoinColumn(name="workshop_id", referencedColumnName="id")
     */
    private $idworkshop;

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return mixed
     */
    public function getIdworkshop()
    {
        return $this->idworkshop;
    }

    /**
     * @param mixed $idworkshop
     */
    public function setIdworkshop($idworkshop)
    {
        $this->idworkshop = $idworkshop;
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
}

