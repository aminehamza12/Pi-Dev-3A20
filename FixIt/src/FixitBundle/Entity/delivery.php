<?php

namespace FixitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * delivery
 *
 * @ORM\Table(name="delivery")
 * @ORM\Entity(repositoryClass="FixitBundle\Repository\deliveryRepository")
 */
class delivery
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="product")
     * @ORM\JoinColumn(name="product",referencedColumnName="id",onDelete="CASCADE")
     */
    private $product;

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return delivery
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set commande
     *
     * @param \stdClass $commande
     *
     * @return delivery
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \stdClass
     */
    public function getCommande()
    {
        return $this->commande;
    }
}

