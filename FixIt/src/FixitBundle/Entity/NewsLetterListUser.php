<?php

namespace FixitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NewsLetterListUser
 *
 * @ORM\Table(name="news_letter_list_user")
 * @ORM\Entity(repositoryClass="FixitBundle\Repository\NewsLetterListUserRepository")
 */
class NewsLetterListUser
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

