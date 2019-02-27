<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\CommentaireRepository")
 */
class Commentaire
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
     * @var \DateTime
     *
     * @ORM\Column(name="post", type="datetime")
     */
    private $post;
    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255)
     */

    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="etatCommentaire", type="string", nullable=true)
     */
    private $etatCommentaire;

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer",nullable=true)
     */
    private $rating;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $User;
    /**
     * @var \ForumBundle\Entity\Topic
     *
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\Topic",inversedBy="comments",cascade={"all"})
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_topic", referencedColumnName="id")
     * })
     */
    private $idTopic;



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
     * Set idCollocation
     *
     * @param integer $idCollocation
     *
     * @return Commentaire
     */
    public function setIdCollocation($idCollocation)
    {
        $this->idCollocation = $idCollocation;

        return $this;
    }

    /**
     * Get idCollocation
     *
     * @return int
     */
    public function getIdCollocation()
    {
        return $this->idCollocation;
    }
    /**
     * Set idUser
     *
     * @param \AppBundle\Entity\User $User
     *
     * @return Commentaire
     */
    public function setUser(\AppBundle\Entity\User $User = null)
    {
        $this->User = $User;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->User;
    }
    /**
     * Set post
     *
     * @param \DateTime $post
     *
     * @return Commentaire
     */
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \DateTime
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Commentaire
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set etatCommentaire
     *
     * @param string $etatCommentaire
     *
     * @return Commentaire
     */
    public function setEtatCommentaire($etatCommentaire)
    {
        $this->etatCommentaire = $etatCommentaire;

        return $this;
    }

    /**
     * Get etatCommentaire
     *
     * @return string
     */
    public function getEtatCommentaire()
    {
        return $this->etatCommentaire;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return Commentaire
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }
    public function setIdTopic(\ForumBundle\Entity\Topic $idTopic = null)
    {
        $this->idTopic = $idTopic;

        return $this;
    }

    /**
     * Get idTopic
     *
     * @return \FORUMBundle\Entity\Topic
     */
    public function getIdTopic()
    {
        return $this->idTopic;
    }
}

