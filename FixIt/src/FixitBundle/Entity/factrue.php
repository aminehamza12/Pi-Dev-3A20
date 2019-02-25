<?php

namespace FixitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * factrue
 *
 * @ORM\Table(name="factrue")
 * @ORM\Entity(repositoryClass="FixitBundle\Repository\factrueRepository")
 */
class factrue
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
     * @ORM\Column(name="dateF", type="date")
     */
    private $dateF;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     */
    private $montant;

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
     * Set dateF
     *
     * @param \DateTime $dateF
     *
     * @return factrue
     */
    public function setDateF($dateF)
    {
        $this->dateF = $dateF;

        return $this;
    }

    /**
     * Get dateF
     *
     * @return \DateTime
     */
    public function getDateF()
    {
        return $this->dateF;
    }

    /**
     * Set montant
     *
     * @param float $montant
     *
     * @return factrue
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }
}

