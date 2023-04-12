<?php

namespace App\Repository;

use App\Entity\Stagiaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stagiaire>
 *
 * @method Stagiaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stagiaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stagiaire[]    findAll()
 * @method Stagiaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StagiaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stagiaire::class);
    }

    public function save(Stagiaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Stagiaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // FIXME:
    // public function findInternsNotInSession($id): array
    // {
    //     $qb  = $this->_em->createQueryBuilder();

    //     $nots = $qb->select('st')
    //     ->from('App\Entity\Stagiaire', 'st')
    //     ->innerJoin('st.stagiaire_session', 'ss')
    //     ->Where($qb->expr()->eq('ss.id', ':id'))
    //     ->setParameter('id',$id);


    //     $linked = $qb->select('ss')
    //     ->from('App\Entity\Stagiaire', 'ss')
    //     ->where($qb->expr()->notIn('ss.id', $nots->getDQL()));


    //     return $linked->getQuery()->getResult();

    //     // SELECT *
    //     // FROM stagiaire st
    //     // WHERE st.id NOT IN (SELECT stagiaire_id FROM stagiaire_session ss 
    //     // WHERE ss.session_id = 1)

    // }

    
    
    
    
//    /**
//     * @return Stagiaire[] Returns an array of Stagiaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
//    public function findOneBySomeField($value): ?Stagiaire
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


}

