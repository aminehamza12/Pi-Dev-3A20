<?php

namespace FixitBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Blog
 *
 * @ORM\Table(name="blog")
 * @ORM\Entity(repositoryClass="FixitBundle\Repository\BlogRepository")
 */
class Blog
{
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
     * @ORM\Column(name="urlImage", type="text")
     */
    private $urlImage;

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
     * Set urlImage
     *
     * @param string $urlImage
     *
     * @return Blog
     */
    public function setUrlImage($urlImage)
    {
        $this->urlImage = $urlImage;

        return $this;
    }

    /**
     * Get urlImage
     *
     * @return string
     */
    public function getUrlImage()
    {
        return $this->urlImage;
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

    public function __construct()
    {
        $this->views = new ArrayCollection();
        $this->reactions = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }
}

