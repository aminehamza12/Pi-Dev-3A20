<?php

namespace BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Blog
 *
 * @ORM\Table(name="blog")
 * @ORM\Entity(repositoryClass="BlogBundle\Repository\BlogRepository")
 * @Vich\Uploadable
 */
class Blog
{
    /**
     * @ORM\OneToMany(targetEntity="BlogTag", mappedBy="blog")
     */
    private $blogTags;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="blog")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="Reaction", mappedBy="blog")
     */
    private $reactions;



    /**
     * @ORM\OneToMany(targetEntity="BlogViews", mappedBy="blog")
     */
    private $views;


    /**
     * @ORM\ManyToOne(targetEntity="BlogCategorie", inversedBy="blogs")
     * @ORM\JoinColumn(name="blogCategorie_id", referencedColumnName="id")
     */
    private $blogCategorie;

    /**
     * @return mixed
     */
    public function getBlogCategorie()
    {
        return $this->blogCategorie;
    }

    /**
     * @param mixed $blogCategorie
     */
    public function setBlogCategorie($blogCategorie)
    {
        $this->blogCategorie = $blogCategorie;
    }

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
     * @ORM\Column(name="title", type="text")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedAt", type="datetime")
     */
    private $editedAt;


    /**
     * @var string
     *
     * @ORM\Column(name="notificationEnable", type="string", length=255)
     */
    private $notificationEnable;

    /**
     * @var string
     *
     * @ORM\Column(name="commentEnable", type="string", length=255)
     */
    private $commentEnable;


    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="blog_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    // ...

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
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
     * Set title
     *
     * @param string $title
     *
     * @return Blog
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Blog
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Blog
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Blog
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set editedAt
     *
     * @param \DateTime $editedAt
     *
     * @return Blog
     */
    public function setEditedAt($editedAt)
    {
        $this->editedAt = $editedAt;

        return $this;
    }

    /**
     * Get editedAt
     *
     * @return \DateTime
     */
    public function getEditedAt()
    {
        return $this->editedAt;
    }



    /**
     * Set notificationEnable
     *
     * @param string $notificationEnable
     *
     * @return Blog
     */
    public function setNotificationEnable($notificationEnable)
    {
        $this->notificationEnable = $notificationEnable;

        return $this;
    }

    /**
     * Get notificationEnable
     *
     * @return string
     */
    public function getNotificationEnable()
    {
        return $this->notificationEnable;
    }

    /**
     * Set commentEnable
     *
     * @param string $commentEnable
     *
     * @return Blog
     */
    public function setCommentEnable($commentEnable)
    {
        $this->commentEnable = $commentEnable;

        return $this;
    }

    /**
     * Get commentEnable
     *
     * @return string
     */
    public function getCommentEnable()
    {
        return $this->commentEnable;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function __construct()
    {
        $this->views = new ArrayCollection();
        $this->reactions = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->blogTags = new ArrayCollection();
    }
}

