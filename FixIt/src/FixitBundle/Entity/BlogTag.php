<?php

namespace FixitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlogTag
 *
 * @ORM\Table(name="blog_tag")
 * @ORM\Entity(repositoryClass="FixitBundle\Repository\BlogTagRepository")
 */
class BlogTag
{
    /**
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="blogTags")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     */
    private $tag;

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

