<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reaction
 *
 * @ORM\Table(name="reaction")
 * @ORM\Entity(repositoryClass="BlogBundle\Repository\ReactionRepository")
 */
class Reaction
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="reactions")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * @return mixed
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * @param mixed $blog
     */
    public function setBlog($blog)
    {
        $this->blog = $blog;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Blog", inversedBy="reactions")
     * @ORM\JoinColumn(name="blog_id", referencedColumnName="id")
     */
    private $blog;

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
     * @ORM\Column(name="likeBlog", type="integer")
     */
    private $likeBlog;

    /**
     * @var int
     *
     * @ORM\Column(name="dislikeBlog", type="integer")
     */
    private $dislikeBlog;


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
     * Set likeBlog
     *
     * @param integer $likeBlog
     *
     * @return Reaction
     */
    public function setLikeBlog($likeBlog)
    {
        $this->likeBlog = $likeBlog;

        return $this;
    }

    /**
     * Get likeBlog
     *
     * @return int
     */
    public function getLikeBlog()
    {
        return $this->likeBlog;
    }

    /**
     * Set dislikeBlog
     *
     * @param integer $dislikeBlog
     *
     * @return Reaction
     */
    public function setDislikeBlog($dislikeBlog)
    {
        $this->dislikeBlog = $dislikeBlog;

        return $this;
    }

    /**
     * Get dislikeBlog
     *
     * @return int
     */
    public function getDislikeBlog()
    {
        return $this->dislikeBlog;
    }
}

