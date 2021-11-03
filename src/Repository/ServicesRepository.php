<?php

namespace App\Repository;

use App\Entity\Services;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;



/**
 * @method Services|null find($id, $lockMode = null, $lockVersion = null)
 * @method Services|null findOneBy(array $criteria, array $orderBy = null)
 * @method Services[]    findAll()
 * @method Services[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Services::class);
        
    }

    // /**
    //  * @return Services[] Returns an array of Services objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Services
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findPayServices($request): array
    {
        /*select s.id, s.name, sc.user_id, sc.servicio_id, d.id documento from services s
        left join servicios_contratados sc on sc.servicio_id = s.id
        left join documentos d on d.dependent = s.id
        -- where MONTH(d.create_at) = MONTH(NOW())*/
        $params = [
            ':userId' => $this->getEntityManager()->getConnection()->quote($request->get('userId')),
        ];
        $query = 'SELECT s.id, s.name, sc.user_id, sc.servicio_id, d.id documento,concat(d.ruta,d.nombre) as documento_ruta,d.aprobado, MONTH(d.create_at) subido FROM services s
        LEFT JOIN servicios_contratados sc ON sc.servicio_id = s.id
        LEFT JOIN documentos d ON d.dependent = s.id
        WHERE sc.user_id = :userId and d.tipo_id= 1';
        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query, $params))->fetchAllAssociative();
    }
    
   
    public function findPayServicesByUser($id): array
    {
        /*select s.id, s.name, sc.user_id, sc.servicio_id, d.id documento from services s
        left join servicios_contratados sc on sc.servicio_id = s.id
        left join documentos d on d.dependent = s.id
        -- where MONTH(d.create_at) = MONTH(NOW())*/
        $params = [
            ':userId' => $id
        ];
        $query = 'SELECT s.id, s.name,s.price,s.hours_service,s.activo servicio_activo,
                         sc.periodo_pago, sc.id servicio_contratado_id,sc.activo servicio_contratado_activo, sc.user_id, sc.servicio_id,DATE_FORMAT(sc.create_at, "%d-%m-%Y %H:%m:%s") mes_contratacion_servicio,MONTH(sc.create_at) mes_contratado,YEAR(sc.create_at) anio_contratado, 
                         d.id documento,concat(d.ruta,d.nombre) as documento_ruta,d.aprobado, MONTH(d.create_at) subido,d.visualizar
                         FROM services s
        LEFT JOIN servicios_contratados sc ON sc.servicio_id = s.id
        LEFT JOIN documentos d ON d.dependent = sc.id 
        WHERE sc.user_id = :userId and (d.tipo_id= 1 OR d.tipo_id is null)' ;
    
        return ['data'=>$this->getEntityManager()->getConnection()->executeQuery(strtr($query, $params))->fetchAllAssociative(), 'user'=>$id];
    }
}
