<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlogTag
 *
 * @ORM\Table(name="blog_tag")
 * @ORM\Entity(repositoryClass="BlogBundle\Repository\BlogTagRepository")
 */
class BlogTag
{
    /**
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="blogTags")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     */
    private $tag;

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
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
     * @ORM\ManyToOne(targetEntity="Blog", inversedBy="blogTags")
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

