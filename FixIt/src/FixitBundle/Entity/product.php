<?php

namespace FixitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="FixitBundle\Repository\productRepository")
 */
class product
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
     * @var int
     *
     * @ORM\Column(name="name",  type="string", length=255)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var bool
     *
     * @ORM\Column(name="delivery", type="boolean")
     */
    private $delivery;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255)
     */
    private $adress;

    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    /**
     * @var integer
     *
     * @ORM\Column(name="tel", type="integer")
     */
    private $tel;

    /**
     * @var integer
     *
     * @ORM\Column(name="view", type="integer")
     */
    private $view;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbcommande", type="integer")
     */
    private $nbcommande;

    /**
     * @ORM\ManyToOne(targetEntity="CategoryProduct")
     * @ORM\JoinColumn(name="category",referencedColumnName="id",onDelete="CASCADE")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user",referencedColumnName="id",onDelete="CASCADE")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }



    /**
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }



    /**
     * @return int
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param int $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
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
     * Set name
     *
     * @param integer $name
     *
     * @return product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return int
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set quantity
     *
     * @param float $quantity
     *
     * @return product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set delivery
     *
     * @param boolean $delivery
     *
     * @return product
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * Get delivery
     *
     * @return bool
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return product
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * @return int
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param int $view
     */
    public function setView($view)
    {
        $this->view = $view;
    }

    /**
     * @return int
     */
    public function getNbcommande()
    {
        return $this->nbcommande;
    }

    /**
     * @param int $nbcommande
     */
    public function setNbcommande($nbcommande)
    {
        $this->nbcommande = $nbcommande;
    }



}

