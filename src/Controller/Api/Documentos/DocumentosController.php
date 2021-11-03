<?php

namespace App\Controller\Api\Documentos;

use App\Repository\DocumentosRepository;
use App\Service\Documentos\DocumentosService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DocumentosController extends AbstractController
{
    /**
     * @Rest\Get(path="/documents")
     * @Rest\View(serializerGroups={"documentos"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAllDocuments(DocumentosRepository $documentosRepository)
    {
        return $documentosRepository->findAll();
    }

    /**
     * @Rest\Get(path="/documents/{usuario}/{tipo}/{dependent}")
     * @Rest\View(serializerGroups={"documentos"}, serializerEnableMaxDepthChecks=true)
     */
    public function getOneDocumentSpecificServicesContracted(DocumentosService $documentosService)
    {
        return $documentosService->getDocumentoEspecifico();
    }



    /**
     * @Rest\Post(path="/documents")
     * @Rest\View(serializerGroups={"documentos"}, serializerEnableMaxDepthChecks=true)
     */
    public function postDocuments(DocumentosService $documentosService)
    {
        return $documentosService->saveDocuments($this->getUser());
    }

    /**
     * @Rest\Post(path="/documentos_mes_anterior")
     * @Rest\View(serializerGroups={"documentos"}, serializerEnableMaxDepthChecks=true)
     */
    public function postDocumentosMesAnterior(DocumentosService $documentosService)
    {
        return $documentosService->guardarDocumentoMesAnterior($this->getUser());
    }

    /**
     * @Rest\Post(path="/aprobar_documento")
     * @Rest\View(serializerGroups={"documentos"}, serializerEnableMaxDepthChecks=true)
     */
    public function aprobarDocumento(DocumentosService $documentosService)
    {
        return $documentosService->cambiarAprobacionDocumento();
    }
}
