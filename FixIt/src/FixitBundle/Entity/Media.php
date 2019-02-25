<?php
/**
 * Created by PhpStorm.
 * User: hamza
 * Date: 25/04/17
 * Time: 00:03
 */

namespace FixitBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 *
 */
class Media
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     *@ORM\ManyToOne(targetEntity="product")
     *@ORM\JoinColumn(name="product_id", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $product_id;
    /**
     *@ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     *@ORM\JoinColumn(name="User_id", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $User_id;

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param mixed $product_id
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->User_id;
    }

    /**
     * @param mixed $User_id
     */
    public function setUserId($User_id)
    {
        $this->User_id = $User_id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */



    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="SVP, charger l'image de votre Produit.")
     * @Assert\File(mimeTypes={ "image/jpeg","image/png" })
     */
    private $brochure;

    public function getBrochure()
    {
        return $this->brochure;
    }

    public function setBrochure($brochure)
    {
        $this->brochure = $brochure;

        return $this;
    }
}