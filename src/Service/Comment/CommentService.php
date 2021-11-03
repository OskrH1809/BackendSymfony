<?php


namespace App\Service\Comment;

use App\Entity\Comment;
use App\Entity\Conversation;
use App\Repository\CommentRepository;
use App\Repository\ConversationRepository;
use App\Repository\DataUserRepository;
use App\Repository\TareasRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class CommentService
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
    private UserRepository $userRepository;
    private CommentRepository $commentRepository;
    private ConversationRepository $conversationRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
        DataUserRepository $dataUserRepository,
        TareasRepository $tareasRepository,
        UserRepository $userRepository,
        CommentRepository $commentRepository,
        ConversationRepository $conversationRepository
    ) {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
        $this->dataUserRepository = $dataUserRepository;
        $this->tareasRepository = $tareasRepository;
        $this->userRepository = $userRepository;
        $this->commentRepository = $commentRepository;
        $this->conversationRepository = $conversationRepository;
    }


    public function newComment($idUser)
    {
        $data = json_decode($this->requestStack->getCurrentRequest()->getContent());
        $tarea = $this->tareasRepository->find($data->tarea);
        $conversation = $this->conversationRepository->findOneBy(['tarea' => $tarea]);

        $user = $this->userRepository->find($idUser);

        if (!$conversation) {
            $newConversation = new Conversation();
            $newConversation->setTarea($tarea);
            $this->entityManager->persist($newConversation);
            $this->entityManager->flush();
            $conversation = $newConversation;
        }

        $newComment = new Comment();
        $newComment->setViewed($user->getPerfil()->getId());
        $newComment->setText($data->text);
        $newComment->setUser($user);
        $newComment->setConversation($conversation);
        $this->entityManager->persist($newComment);
        $this->entityManager->flush();
        return $newComment;
    }


    public function getCommentsOfConversationSpecific($id): array
    {
        $conversation = $this->conversationRepository->findBy(['tarea' => $id]);
        $comments = $this->commentRepository->findBy(['conversation' => $conversation], ['createAt' => 'Desc']);


        return $comments;
    }

    public function updateViewedAdmin()
    {
        $data = json_decode($this->requestStack->getCurrentRequest()->getContent());
        $tarea = $this->tareasRepository->find($data->tarea);
        $conversation = $this->conversationRepository->findOneBy(['tarea' => $tarea]);
        // dump($conversation->getId());
        // exit();
        $this->commentRepository->updateViewedAdmin($conversation->getId());
        return new JsonResponse('Exito', JsonResponse::HTTP_OK);
    }

    public function updateViewedUser()
    {
        $data = json_decode($this->requestStack->getCurrentRequest()->getContent());
        $tarea = $this->tareasRepository->find($data->tarea);
        $conversation = $this->conversationRepository->findOneBy(['tarea' => $tarea]);
        // dump($conversation->getId());
        // exit();
        $this->commentRepository->updateViewedUser($conversation->getId());

        return new JsonResponse('Exito', JsonResponse::HTTP_OK);
    }
}
