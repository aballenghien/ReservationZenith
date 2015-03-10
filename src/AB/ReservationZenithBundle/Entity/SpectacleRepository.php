<?php

namespace AB\ReservationZenithBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SpectacleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SpectacleRepository extends EntityRepository
{
	public function getSpectacleByDates($datemin, $datemax){

        $query = $this->getQueryBuilderSpectacleByDates($datemin,$datemax)->getQuery();

        try {
            return $query->execute();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function getQueryBuilderSpectacleByDates($datemin, $datemax){
        $em= $this->getEntityManager();
        $qb = $em->createQueryBuilder();
       
        $qb->select('sp')
           ->addSelect('se')
           ->from('Seance','se')
           ->leftJoin('Spectacle','sp','WITH',null,'sp.id')
           ->where('se.date <= ?1 AND se.date>= ?2')
           ->setParameter(1,$datemax)
           ->setParameter(2,$datemin);
            /*SELECT DISTINCT sp.id, sp.titre, sp.genre, sp.duree, sp.affiche, sp.commentaires FROM ABReservationZenithBundle:Seance se
            LEFT JOIN se.spectacle sp
            WHERE se.date >= :datemin AND se.date<= :datemax'*/
        return $qb;
    }
}
