<?php

namespace FixitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="FixitBundle\Repository\VideoRepository")
 */
class Video
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
     * @ORM\Column(name="videourl", type="string", length=255)
     */
    private $videourl;

    /**
     * @ORM\ManyToOne(targetEntity="Ifixit")
     * @ORM\JoinColumn(name="ifixit_id", referencedColumnName="id")
     */

    private $ifixit;

    /**
     * @return mixed
     */
    public function getIfixit()
    {
        return $this->ifixit;
    }

    /**
     * @param mixed $ifixit
     */
    public function setIfixit($ifixit)
    {
        $this->ifixit = $ifixit;
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
     * Set videourl
     *
     * @param string $videourl
     *
     * @return Video
     */
    public function setVideourl($videourl)
    {
        $this->videourl = $videourl;

        return $this;
    }

    /**
     * Get videourl
     *
     * @return string
     */
    public function getVideourl()
    {
        return $this->videourl;
    }
}

