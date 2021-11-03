<?php

namespace App\Repository;

use App\Entity\Documentos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @method Documentos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Documentos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Documentos[]    findAll()
 * @method Documentos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Documentos::class);
    }

    // /**
    //  * @return Documentos[] Returns an array of Documentos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Documentos
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function documentoAnterior($user, $dependent, $tipo)
    {
        /*select s.id, s.name, sc.user_id, sc.servicio_id, d.id documento from services s
        left join servicios_contratados sc on sc.servicio_id = s.id
        left join documentos d on d.dependent = s.id
        -- where MONTH(d.create_at) = MONTH(NOW())*/
        $params = [
            ':userId' => $user,':depende' => $dependent,':tipo' => $tipo,
        ];
        $query = 'SELECT d.id, d.create_at
                  FROM documentos d
                  WHERE d.user_id=:userId and d.tipo_id=:tipo and d.dependent = :depende and MONTH(d.create_at)=(MONTH(NOW())-1) '; 
        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query, $params))->fetchAllAssociative();
    }
}
