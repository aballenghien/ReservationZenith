<?php

namespace AB\ReservationZenithBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SeanceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SeanceRepository extends EntityRepository
{
	public function isLibre ($heure){
        $ok = true;
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('sp.id, sp.duree, se.heure')
           ->from('ABReservationZenithBundle:Spectacle','sp')
           ->leftJoin('ABReservationZenithBundle:Seance','se','WITH','se.spectacle=sp.id')
           ->where('t.spectacle= ?1 and se.date = ?2')
           ->setParameter(1,$id_spectacle)
           ->setParameter(2,$date);
        $query = $qb->getQuery();
        try {
            $result = $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return false;
        }        
        if($result){
                foreach ($result as $r) {
                    if($heure>=$r[heure] && $heure <= ($r['heure']+strtotime('+'.$r['duree'].' minute'))){
                        if($ok){
                            $ok = false;
                        }
                    }
                }
        }
        return $ok;
        
    }
	
}
