<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    // /**
    //  * @return Comment[] Returns an array of Comment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function updateViewedAdmin($idConversation)
    {
        return $this->createQueryBuilder('c')
            ->update()
            ->set('c.viewed', 0) 
            ->where('c.conversation = ?1')
            ->andwhere('c.viewed = ?2')
            ->setParameter(1, $idConversation)
            ->setParameter(2, 1)
            ->getQuery()
            ->getResult()
        ;
    }
    public function updateViewedUser($idConversation)
    {
        return $this->createQueryBuilder('c')
            ->update()
            ->set('c.viewed', 0) 
            ->where('c.conversation = ?1')
            ->andwhere('c.viewed = ?2')
            ->setParameter(1, $idConversation)
            ->setParameter(2, 3)
            ->getQuery()
            ->getResult()
        ;
    }
}
