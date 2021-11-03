<?php


namespace App\Service\Conversation;

use App\Entity\Conversation;
use App\Repository\DataUserRepository;
use App\Repository\TareasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ConversationService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;
    private DataUserRepository $dataUserRepository;
    private TareasRepository $tareasRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        DataUserRepository $dataUserRepository,
        TareasRepository $tareasRepository
    ) {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
        $this->dataUserRepository = $dataUserRepository;
        $this->tareasRepository = $tareasRepository;
    }


    public function newConversation()
    {
        $data = json_decode($this->requestStack->getCurrentRequest()->getContent());
        $tarea = $this->tareasRepository->find($data->tarea);
        $Conversation = new Conversation();
        $Conversation->setTarea($tarea);
        $this->entityManager->persist($Conversation);
        $this->entityManager->flush();
        return $Conversation->getId();
    }
}
