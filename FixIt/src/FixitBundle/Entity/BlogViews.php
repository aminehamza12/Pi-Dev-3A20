<?php

namespace FixitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlogViews
 *
 * @ORM\Table(name="blog_views")
 * @ORM\Entity(repositoryClass="FixitBundle\Repository\BlogViewsRepository")
 */
class BlogViews
{
    /**
     * @ORM\ManyToOne(targetEntity="Blog", inversedBy="views")
     * @ORM\JoinColumn(name="blogViews_id", referencedColumnName="id")
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
     * @ORM\Column(name="visites", type="integer")
     */
    private $visites;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateVisite", type="datetime")
     */
    private $dateVisite;


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
     * Set visites
     *
     * @param integer $visites
     *
     * @return BlogViews
     */
    public function setVisites($visites)
    {
        $this->visites = $visites;

        return $this;
    }

    /**
     * Get visites
     *
     * @return int
     */
    public function getVisites()
    {
        return $this->visites;
    }

    /**
     * Set dateVisite
     *
     * @param \DateTime $dateVisite
     *
     * @return BlogViews
     */
    public function setDateVisite($dateVisite)
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    /**
     * Get dateVisite
     *
     * @return \DateTime
     */
    public function getDateVisite()
    {
        return $this->dateVisite;
    }
}

