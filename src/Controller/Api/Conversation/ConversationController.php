<?php

namespace App\Controller\Api\Conversation;

use App\Repository\ConversationRepository;
use App\Service\Conversation\ConversationService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConversationController extends AbstractController
{
    /**
     * @Rest\Get(path="/conversations")
     * @Rest\View(serializerGroups={"conversation"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAllConversations(ConversationRepository $conversationRepository)
    {
        return $conversationRepository->findAll();
    }


    /**
     * @Rest\Post(path="/conversation")
     * @Rest\View(serializerGroups={"data"}, serializerEnableMaxDepthChecks=true)
     */
    public function newDataThisUser(ConversationService $conversationService)
    {
        return $conversationService->newConversation();
    }
}
