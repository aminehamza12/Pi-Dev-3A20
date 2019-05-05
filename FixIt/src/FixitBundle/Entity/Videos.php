<?php

namespace FixitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Videos
 *
 * @ORM\Table(name="videos")
 * @ORM\Entity(repositoryClass="FixitBundle\Repository\VideosRepository")
 * @Vich\Uploadable
 */
class Videos
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $video;

    /**
     * @Vich\UploadableField(mapping="videos", fileNameProperty="video")
     * @var File
     */
    private $videoFile;

    /**
     * @ORM\ManyToOne(targetEntity="ifixit")
     * @ORM\JoinColumn(name="ifixit_id", referencedColumnName="id")
     */

    private $ifixit;

    /**
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param string $video
     */
    public function setVideo($video)
    {
        $this->video = $video;
    }

    /**
     * @return File
     */
    public function getVideoFile()
    {
        return $this->videoFile;
    }

    /**
     * @param File $videoFile
     */
    public function setVideoFile($videoFile)
    {
        $this->videoFile = $videoFile;
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Videos
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

