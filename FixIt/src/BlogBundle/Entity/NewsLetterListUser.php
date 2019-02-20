<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NewsLetterListUser
 *
 * @ORM\Table(name="news_letter_list_user")
 * @ORM\Entity(repositoryClass="BlogBundle\Repository\NewsLetterListUserRepository")
 */
class NewsLetterListUser
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="newsLetterListUsers")
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
    public function getNewsLetterList()
    {
        return $this->newsLetterList;
    }

    /**
     * @param mixed $newsLetterList
     */
    public function setNewsLetterList($newsLetterList)
    {
        $this->newsLetterList = $newsLetterList;
    }

    /**
     * @ORM\ManyToOne(targetEntity="NewsLetterList", inversedBy="newsLetterListUsers")
     * @ORM\JoinColumn(name="newsLetterList_id", referencedColumnName="id")
     */
    private $newsLetterList;

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

