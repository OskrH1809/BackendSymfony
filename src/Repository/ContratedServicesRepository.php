<?php

namespace App\Repository;

use App\Entity\ServiciosContratados;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Query\AST\Join;
use Doctrine\Persistence\ManagerRegistry;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

/**
 * @method ServiciosContratados|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiciosContratados|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiciosContratados[]    findAll()
 * @method ServiciosContratados[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratedServicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiciosContratados::class);
    }

    // /**
    //  * @return ServiciosContratados[] Returns an array of ServiciosContratados objects
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
    public function findOneBySomeField($value): ?ServiciosContratados
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function countDocumentsServiceContracted($request): array
    {
        /*select s.id, s.name, sc.user_id, sc.servicio_id, d.id documento from services s
        left join servicios_contratados sc on sc.servicio_id = s.id
        left join documentos d on d.dependent = s.id
        -- where MONTH(d.create_at) = MONTH(NOW())*/
        $params = [
            ':idServicioContratado' => $this->getEntityManager()->getConnection()->quote($request->get('idServicioContratado')),
        ];
        $query = 'SELECT  count(d.id) documentos, sc.id, sc.create_at creado
                  FROM servicios_contratados sc
                  LEFT JOIN documentos d ON d.dependent = sc.id
                  WHERE sc.id = :idServicioContratado and d.tipo_id= 1
        ';
        return $this->getEntityManager()->getConnection()->executeQuery(strtr($query, $params))->fetchAllAssociative();
    }

    public function findPayServicesAll(): array
    {
        /*select s.id, s.name, sc.user_id, sc.servicio_id, d.id documento from services s
        left join servicios_contratados sc on sc.servicio_id = s.id
        left join documentos d on d.dependent = s.id
        -- where MONTH(d.create_at) = MONTH(NOW())*/
        $params = [
            ':userId' => ''
        ];
        $query = 'SELECT sc.activo servicio_contratado_activo,sc.id,sc.user_id,sc.servicio_id servicio, sc.activo servicio_contratado_activo, sc.periodo_pago,sc.create_at,
                         s.name servicio_name, s.hours_service,s.time_remaining,
                         d.tipo_id tipo_documento_id,concat(d.ruta,d.nombre) ruta,d.dependent, d.aprobado
                    FROM servicios_contratados sc 
                    LEFT JOIN services s ON s.id =sc.servicio_id  
        LEFT JOIN documentos d ON d.dependent = sc.id 
        where d.tipo_id= 1';
        // return $this->getEntityManager()->getConnection()->executeQuery(strtr($query, $params))->fetchAllAssociative();
        return ['data'=>$this->getEntityManager()->getConnection()->executeQuery($query)->fetchAllAssociative()];

    }

    public function serviciosContratadosSinAprobar(): array
    {
        /*select s.id, s.name, sc.user_id, sc.servicio_id, d.id documento from services s
        left join servicios_contratados sc on sc.servicio_id = s.id
        left join documentos d on d.dependent = s.id
        -- where MONTH(d.create_at) = MONTH(NOW())*/
 
        $query = 'SELECT sc.activo servicio_contratado_activo,s.activo servicio_activo,sc.id, sc.user_id,u.email,s.id servicio_id, s.name, s.price, sc.periodo_pago,MONTH(d.create_at) subido, concat(d.ruta,d.nombre) as documento_ruta
                    FROM servicios_contratados sc 
                    LEFT JOIN services s ON s.id =sc.servicio_id  
                    LEFT JOIN documentos d ON d.dependent = sc.id
                    LEFT JOIN user u ON u.id = sc.user_id
                    WHERE (sc.activo=1 and s.activo=1 and  MONTH(d.create_at) = (MONTH(NOW())-1) and d.tipo_id= 1 and NOT EXISTS (SELECT * FROM documentos d
                                                                 WHERE sc.activo=1 and s.activo=1 and MONTH(d.create_at)= MONTH(NOW()) and d.user_id=sc.user_id 
                                                                 and d.tipo_id= 1 and d.dependent=sc.id)) 
                    OR (sc.activo=1 and s.activo=1 and d.create_at is null)';
        // return $this->getEntityManager()->getConnection()->executeQuery(strtr($query, $params))->fetchAllAssociative();
        return ['data'=>$this->getEntityManager()->getConnection()->executeQuery($query)->fetchAllAssociative()];
    }

    public function serviciosContratadosPendientesDeAprobar(): array
    {
        /*select s.id, s.name, sc.user_id, sc.servicio_id, d.id documento from services s
        left join servicios_contratados sc on sc.servicio_id = s.id
        left join documentos d on d.dependent = s.id
        -- where MONTH(d.create_at) = MONTH(NOW())*/
        $params = [
            ':userId' => ''
        ];
        $query = 'SELECT sc.activo servicio_contratado_activo, s.activo servicio_activo,sc.id, sc.user_id,u.email,s.id servicio_id, s.name, s.price, sc.periodo_pago,MONTH(d.create_at) subido, concat(d.ruta,d.nombre) as documento_ruta,d.id documento_id, d.aprobado
                    FROM servicios_contratados sc 
                    LEFT JOIN services s ON s.id =sc.servicio_id  
                    LEFT JOIN documentos d ON d.dependent = sc.id
                    LEFT JOIN user u ON u.id = sc.user_id
                    WHERE sc.activo=1 and s.activo=1 and MONTH(d.create_at) = MONTH(NOW()) and d.aprobado=0 and d.tipo_id= 1';
        return ['data'=>$this->getEntityManager()->getConnection()->executeQuery($query)->fetchAllAssociative()];
    }

    public function serviciosContratadosAprobados(): array
    {
        /*select s.id, s.name, sc.user_id, sc.servicio_id, d.id documento from services s
        left join servicios_contratados sc on sc.servicio_id = s.id
        left join documentos d on d.dependent = s.id
        -- where MONTH(d.create_at) = MONTH(NOW())*/
    
        $query = 'SELECT sc.activo servicio_contratado_activo, s.activo servicio_activo,sc.id, sc.user_id,u.email,s.id servicio_id, s.name, s.price, sc.periodo_pago,MONTH(d.create_at) subido,concat(d.ruta,d.nombre) as documento_ruta,d.id documento_id,d.aprobado
                    FROM servicios_contratados sc 
                    LEFT JOIN services s ON s.id =sc.servicio_id  
                    LEFT JOIN documentos d ON d.dependent = sc.id
                    LEFT JOIN user u ON u.id = sc.user_id
                    WHERE sc.activo=1 and s.activo=1 and MONTH(d.create_at) = MONTH(NOW()) and d.tipo_id= 1  and d.aprobado=1';
       return ['data'=>$this->getEntityManager()->getConnection()->executeQuery($query)->fetchAllAssociative()];
    }


    // ByUser
    public function serviciosContratadosSinAprobarByUser($request): array
    {
        /*select s.id, s.name, sc.user_id, sc.servicio_id, d.id documento from services s
        left join servicios_contratados sc on sc.servicio_id = s.id
        left join documentos d on d.dependent = s.id
        -- where MONTH(d.create_at) = MONTH(NOW())*/
        $params = [
            ':userId' => $this->getEntityManager()->getConnection()->quote($request->get('userId')),
        ];
        $query = 'SELECT sc.activo servicio_contratado_activo,u.email,s.activo servicio_activo,sc.id, sc.user_id,u.email,s.id servicio_id, s.name, s.price, sc.periodo_pago,MONTH(d.create_at) subido, concat(d.ruta,d.nombre) as documento_ruta
                    FROM servicios_contratados sc 
                    LEFT JOIN services s ON s.id =sc.servicio_id  
                    LEFT JOIN documentos d ON d.dependent = sc.id
                    LEFT JOIN user u ON u.id = sc.user_id
                    WHERE (sc.user_id=:userId and d.tipo_id= 1 and MONTH(d.create_at) = (MONTH(NOW())-1) and NOT EXISTS (SELECT * FROM documentos d
                                                                 WHERE MONTH(d.create_at)= MONTH(NOW()) and d.user_id=sc.user_id and d.tipo_id= 1 and d.dependent=sc.id )) 
                    OR (sc.user_id=:userId and d.tipo_id is null and sc.activo=1 and s.activo=1 and d.create_at is null)';
        // return $this->getEntityManager()->getConnection()->executeQuery(strtr($query, $params))->fetchAllAssociative();
        return ['data'=>$this->getEntityManager()->getConnection()->executeQuery(strtr($query, $params))->fetchAllAssociative(), 'user_id'=>$this->getEntityManager()->getConnection()->quote($request->get('userId'))];
    }

    public function serviciosContratadosPendientesDeAprobarByUser($request): array
    {
        /*select s.id, s.name, sc.user_id, sc.servicio_id, d.id documento from services s
        left join servicios_contratados sc on sc.servicio_id = s.id
        left join documentos d on d.dependent = s.id
        -- where MONTH(d.create_at) = MONTH(NOW())*/
        $params = [
            ':userId' => $this->getEntityManager()->getConnection()->quote($request->get('userId')),
        ];
        $query = 'SELECT sc.activo servicio_contratado_activo,u.email,s.activo servicio_activo,sc.id, sc.user_id,u.email,s.id servicio_id, s.name, s.price, sc.periodo_pago,MONTH(d.create_at) subido, concat(d.ruta,d.nombre) as documento_ruta,d.id documento_id, d.aprobado
                    FROM servicios_contratados sc 
                    LEFT JOIN services s ON s.id =sc.servicio_id  
                    LEFT JOIN documentos d ON d.dependent = sc.id
                    LEFT JOIN user u ON u.id = sc.user_id
                    WHERE sc.user_id=:userId and MONTH(d.create_at) = MONTH(NOW()) and d.aprobado=0 and d.tipo_id= 1';
        // return $this->getEntityManager()->getConnection()->executeQuery(strtr($query, $params))->fetchAllAssociative();
        return ['data'=>$this->getEntityManager()->getConnection()->executeQuery(strtr($query, $params))->fetchAllAssociative(), 'user_id'=>$this->getEntityManager()->getConnection()->quote($request->get('userId'))];

    }

    public function serviciosContratadosAprobadosByUser($request): array
    {
        /*select s.id, s.name, sc.user_id, sc.servicio_id, d.id documento from services s
        left join servicios_contratados sc on sc.servicio_id = s.id
        left join documentos d on d.dependent = s.id
        -- where MONTH(d.create_at) = MONTH(NOW())*/
        $params = [
            ':userId' => $this->getEntityManager()->getConnection()->quote($request->get('userId')),
        ];
        $query = 'SELECT sc.activo servicio_contratado_activo,u.email,s.activo servicio_activo,sc.id, sc.user_id,u.email,s.id servicio_id, s.name, s.price, sc.periodo_pago,MONTH(d.create_at) subido,concat(d.ruta,d.nombre) as documento_ruta,d.id documento_id,d.aprobado
                    FROM servicios_contratados sc 
                    LEFT JOIN services s ON s.id =sc.servicio_id  
                    LEFT JOIN documentos d ON d.dependent = sc.id
                    LEFT JOIN user u ON u.id = sc.user_id
                    WHERE sc.user_id=:userId and MONTH(d.create_at) = MONTH(NOW())  and d.aprobado=1 and d.tipo_id= 1';
        // return $this->getEntityManager()->getConnection()->executeQuery(strtr($query, $params))->fetchAllAssociative();
        return ['data'=>$this->getEntityManager()->getConnection()->executeQuery(strtr($query, $params))->fetchAllAssociative(), 'user_id'=>$this->getEntityManager()->getConnection()->quote($request->get('userId'))];

    }


        public function serviciosContratadoEntreFechas(\DateTime  $fecha1, \DateTime  $fecha2)
        {
            return $this->createQueryBuilder('c')
            ->andWhere('c.createAt >= :val')
            ->andWhere('c.createAt <= :val2')
            ->setParameter('val', $fecha1)
            ->setParameter('val2', $fecha2)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
        }
    
    

    

}
