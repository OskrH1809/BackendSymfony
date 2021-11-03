<?php

namespace App\Repository;

use App\Entity\Tareas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tareas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tareas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tareas[]    findAll()
 * @method Tareas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TareasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tareas::class);
    }

    // /**
    //  * @return Tareas[] Returns an array of Tareas objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tareas
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function contadorMensajesAdmin($id)
    {

        $params = [
            ':tarea' => $id
        ];
        $query = 'SELECT count(com.id) nuevos_mensajes_admin FROM comment com
        LEFT JOIN conversation con ON con.id = com.conversation_id
        LEFT JOIN tareas t ON t.id = con.tarea_id
        WHERE t.id = :tarea && com.viewed=1'    ;
        return $this->getEntityManager()->getConnection()->executeQuery($query, $params)->fetchAssociative(); 

    }

    public function contadorMensajesUser($id)
    {

        $params = [
            ':tarea' => $id
        ];
        $query = 'SELECT count(com.id) nuevos_mensajes_user FROM comment com
        LEFT JOIN conversation con ON con.id = com.conversation_id
        LEFT JOIN tareas t ON t.id = con.tarea_id
        WHERE t.id = :tarea && com.viewed=3';
        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query, $params))->fetchAssociative();
    }
}
