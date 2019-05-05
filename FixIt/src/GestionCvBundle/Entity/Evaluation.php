<?php

namespace GestionCvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation")
 * @ORM\Entity(repositoryClass="GesstionCvBundle\Repository\EvaluationRepository")
 */
class Evaluation
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
     * @var int
     *
     * @ORM\Column(name="Rating", type="integer")
     */
    private $rating;
    /**
     * @var int
     *
     * @ORM\Column(name="Votes", type="integer")
     */
    private $votes;
    /**
     * @var int
     *
     * @ORM\Column(name="commenter_id", type="integer")
     */
    private $commenter;
    /**
     * @var text
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @return int
     */
    public function getCommenter()
    {
        return $this->commenter;
    }

    /**
     * @param int $commenter
     */
    public function setCommenter($commenter)
    {
        $this->commenter = $commenter;
    }

    /**
     * @return text
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param text $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
    /**
     * @ORM\ManyToOne(targetEntity="Competences")
     * @ORM\JoinColumn(name="competences_id", referencedColumnName="id")
     */
    private $competence;

    /**
     * @ORM\ManyToOne(targetEntity="Profil")
     * @ORM\JoinColumn(name="Profil_id", referencedColumnName="id")
     */
    private $profil;

    /**
     * @return mixed
     */
    public function getCompetence()
    {
        return $this->competence;
    }

    /**
     * @param mixed $competence
     */
    public function setCompetence($competence)
    {
        $this->competence = $competence;
    }

    /**
     * @return mixed
     */
    public function getProfil()
    {
        return $this->profil;
    }

    /**
     * @param mixed $profil
     */
    public function setProfil($profil)
    {
        $this->profil = $profil;
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
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return int
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * @param int $votes
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;
    }


}

