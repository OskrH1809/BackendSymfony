<?php


namespace App\Service\Documentos;

use App\Entity\Documentos;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Type\DocumentosFormType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use App\Form\Model\DocumentosDto;
use App\Repository\DocumentosRepository;
use Symfony\Component\Form\FormFactoryInterface;
use App\Repository\TipoDocumentosRepository;
use App\Repository\UserRepository;

class DocumentosService
{

    private EntityManagerInterface $entityManager;
    private RequestStack $requestStack;
    private FileUploader $fileUploader;
    private FormFactoryInterface $formFactoryInterface;
    private TipoDocumentosRepository $tipoDocumentosRepository;
    private UserRepository $userRepository;
    private DocumentosRepository $documentosRepository;


    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        FileUploader $fileUploader,
        FormFactoryInterface $formFactoryInterface,
        TipoDocumentosRepository $tipoDocumentosRepository,
        UserRepository $userRepository,
        DocumentosRepository $documentosRepository
    ) {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
        $this->fileUploader = $fileUploader;
        $this->formFactoryInterface = $formFactoryInterface;
        $this->tipoDocumentosRepository = $tipoDocumentosRepository;
        $this->userRepository = $userRepository;
        $this->documentosRepository = $documentosRepository;
    }




    public function saveDocuments($user)
    {
        $request = $this->requestStack->getCurrentRequest();
        $documentosDto = new DocumentosDto();
        $form =  $this->formFactoryInterface->create(DocumentosFormType::class, $documentosDto);
        $form->handleRequest($request);
        if (!$form->isSubmitted()) {
            return new Response('error submit', Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            $documentos = new Documentos();
            $tipoDocumento = $this->tipoDocumentosRepository->find($documentosDto->tipo);
            $documentos->setTipo($tipoDocumento);
            $documentos->setUser($user);
            $documentos->setAprobado('0');
            $documentos->setRuta('storage/default/');
            $documentos->setVisualizar(0);
            $documentos->setDependent($documentosDto->dependent);

            $buscar_documento_anterior = $this->documentosRepository->documentoAnterior($user->getId(), $documentosDto->dependent, $documentosDto->tipo);

            if ($documentosDto->base64Image) {
                $filename = ($this->fileUploader)($documentosDto->base64Image);
                $documentos->setNombre($filename);
            }
            $this->entityManager->persist($documentos);


            if (!empty($buscar_documento_anterior)) {
                $id_documento_anterior = $buscar_documento_anterior[(sizeof($buscar_documento_anterior)) - 1]['id'];
                $documento_anterior = $this->documentosRepository->find($id_documento_anterior);
                $documento_anterior->setVisualizar(1);
            }
            $this->entityManager->flush();
            return $documentos;
        }
        return $form;
    }

    public function guardarDocumentoMesAnterior($user)
    {
        $request = $this->requestStack->getCurrentRequest();
        $documentosDto = new DocumentosDto();
        $form =  $this->formFactoryInterface->create(DocumentosFormType::class, $documentosDto);
        $form->handleRequest($request);
        if (!$form->isSubmitted()) {
            return new Response('error submit', Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            $documentos = new Documentos();
            $tipoDocumento = $this->tipoDocumentosRepository->find($documentosDto->tipo);
            $documentos->setTipo($tipoDocumento);
            $documentos->setUser($user);
            $documentos->setAprobado('0');
            $documentos->setRuta('storage/default/');
            $documentos->setVisualizar(0);
            $documentos->setDependent($documentosDto->dependent);

            $buscar_documento_anterior = $this->documentosRepository->documentoAnterior($user->getId(), $documentosDto->dependent, $documentosDto->tipo);

            if ($documentosDto->base64Image) {
                $filename = ($this->fileUploader)($documentosDto->base64Image);
                $documentos->setNombre($filename);
            }
            $this->entityManager->persist($documentos);


            if (!empty($buscar_documento_anterior)) {
                $id_documento_anterior = $buscar_documento_anterior[(sizeof($buscar_documento_anterior)) - 1]['id'];
                $documento_anterior = $this->documentosRepository->find($id_documento_anterior);
                $documento_anterior->setVisualizar(1);
            }
            $this->entityManager->flush();
            $documentos->setCreateAt(new \DateTime($documentosDto->createAt));
            $this->entityManager->flush();
            return $documentos;
        }
        return $form;
    }

    public function getDocumentoEspecifico()
    {

        $usuario = $this->userRepository->find($this->requestStack->getCurrentRequest()->get('usuario'));
        $tipoDocumento = $this->tipoDocumentosRepository->find($this->requestStack->getCurrentRequest()->get('tipo'));
        $dependent = $this->requestStack->getCurrentRequest()->get('dependent');
        if (empty($usuario) || empty($tipoDocumento) || empty($dependent)) {
            return new Response('Parametros vacios', Response::HTTP_BAD_REQUEST);
        }
        $documento = $this->documentosRepository->findBy(
            ['user' => $usuario, 'tipo' => $tipoDocumento, 'dependent' => $dependent]
        );
        return $documento;
    }

    public function cambiarAprobacionDocumento()
    {
        $documento = $this->documentosRepository->find($this->requestStack->getCurrentRequest()->get('idDocumento'));
        $opcion = $this->requestStack->getCurrentRequest()->get('opcion');

        if (empty($documento)) {
            return new Response('Parametros vacios', Response::HTTP_BAD_REQUEST);
        }

        if ($opcion == "1") {
            $documento->setAprobado('1');
        }
        if ($opcion == "0") {
            $documento->setAprobado('0');
        }
        if ($opcion != 0 && $opcion != 1) {
            return new Response('Parametro incorrecto', Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();
        return $documento;
    }
}
