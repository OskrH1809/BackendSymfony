<?php

namespace App\Controller\Api\Comment;

use App\Repository\CommentRepository;
use App\Service\Comment\CommentService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends AbstractController
{
    /**
     * @Rest\Get(path="/comments")
     * @Rest\View(serializerGroups={"comment"}, serializerEnableMaxDepthChecks=true)
     */
    public function getAllComments(CommentRepository $commentRepository)
    {
        return $commentRepository->findAll();
    }

    /**
     * @Rest\Get(path="/comments/{id}")
     * @Rest\View(serializerGroups={"comment"}, serializerEnableMaxDepthChecks=true)
     */
    public function getCommentsOfConversationSpecific(CommentService $commentService, Request $request)
    {
        return $commentService->getCommentsOfConversationSpecific($request->get('id'));
    }

    /**
     * @Rest\Post(path="/comment")
     * @Rest\View(serializerGroups={"comment"}, serializerEnableMaxDepthChecks=true)
     */
    public function newComment(CommentService $CommentService)
    {
        return $CommentService->newComment($this->getUser()->getId());
    }

    /**
     * @Rest\Post(path="/change_viewed_user")
     * @Rest\View(serializerGroups={"comment"}, serializerEnableMaxDepthChecks=true)
     */
    public function change_viewe_user(CommentService $CommentService)
    {
        return $CommentService->updateViewedUser();
    }

    /**
     * @Rest\Post(path="/change_viewed_admin")
     * @Rest\View(serializerGroups={"comment"}, serializerEnableMaxDepthChecks=true)
     */
    public function change_viewe_admin(CommentService $CommentService)
    {
        return $CommentService->updateViewedAdmin();
    }
}
