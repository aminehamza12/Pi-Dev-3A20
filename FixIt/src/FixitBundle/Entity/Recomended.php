<?php

namespace FixitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recomended
 *
 * @ORM\Table(name="recomended")
 * @ORM\Entity(repositoryClass="FixitBundle\Repository\RecomendedRepository")
 */
class Recomended
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
     * @ORM\ManyToOne(targetEntity="categorieifixit")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */

    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */

    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="Value", type="integer")
     */
    private $value;

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
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return Recomended
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }
}

