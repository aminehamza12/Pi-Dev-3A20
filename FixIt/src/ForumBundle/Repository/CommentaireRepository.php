<?php

namespace ForumBundle\Repository;

use ForumBundle\Entity\Commentaire;
/**
 * CommentaireRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentaireRepository extends \Doctrine\ORM\EntityRepository
{
    public function diffDate($x){

        $query =$this->getEntityManager()
            ->createQuery("SELECT c FROM ForumBundle:Commentaire c WHERE c.idTopic =:x ")
            ->setParameter("x",$x);
        return $query->getResult();
    }

    public function nbComment(){


        $query =$this->getEntityManager()
            ->createQuery("SELECT count(c.id) x FROM ForumBundle:Commentaire c ");
        return $query->getSingleScalarResult();

    }

    public function countCommentaires()
    {
        $query  = $this->getEntityManager()->createQuery('SELECT count(C.id) as nm FROM ForumBundle:Commentaire C WHERE C.statut = :o');
        $query->setParameter(':o','Commentaire');
        return $query->getResult();
    }

}
