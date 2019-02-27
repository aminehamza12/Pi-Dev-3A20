<?php

namespace GestionCvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Profil
 *
 * @ORM\Table(name="profil")
 * @ORM\Entity(repositoryClass="GestionCvBundle\Repository\ProfilRepository")
 * @Vich\Uploadable
 */
class Profil
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
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User")
     */
    protected $user;
    /**
     * @var string
     *
     * @ORM\Column(name="Logo", type="string", length=255)
     */
    private $logo;


    /**
     * @var string
     *
     * @ORM\Column(name="Banner", type="string", length=255)
     */
    private $banner;

    /**
     * @Vich\UploadableField(mapping="profilLogo_images", fileNameProperty="logo")
     * @var File
     */
    private $logoFile;

    /**
     * @Vich\UploadableField(mapping="profilBanner_images", fileNameProperty="banner")
     * @var File
     */
    private $bannerFile;


    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedBannerAt;


    public function setLogoFile(File $image = null)
    {
        $this->logoFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function setBannerFile(File $image = null)
    {
        $this->bannerFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedBannerAt = new \DateTime('now');
        }
    }



    public function getLogoFile()
    {
        return $this->logoFile;
    }

    public function getBannerFile()
    {
        return $this->bannerFile;
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
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return string
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * @param string $banner
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="Mobile", type="integer")
     */
    private $mobile;

    /**
     * @var int
     *
     * @ORM\Column(name="Fax", type="integer")
     */
    private $fax;
    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return int
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param int $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return int
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param int $Fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
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

