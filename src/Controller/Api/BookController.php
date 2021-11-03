<?php

namespace App\Controller\Api;

use App\Entity\Book;
use App\Form\Model\BookDto;
use App\Form\Type\BookFormType;
use App\Repository\BookRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractFOSRestController{

    /**
     * @Rest\Get(path="/books")
     * @Rest\View(serializerGroups={"book"}, serializerEnableMaxDepthChecks=true)
     */
    public function inicioAction(BookRepository $bookRepository)
    {
//        http://localhost:8030/api/books
//        $asa = $bookRepository->findByTitle('sdsdsd');
        return $bookRepository->findAll();
    }

    /**
     * @Rest\Post(path="/save_books")
     * @Rest\View(serializerGroups={"book"}, serializerEnableMaxDepthChecks=true)
     */
    public function saveBookAction(EntityManagerInterface $entityManager, Request $request, FileUploader $fileUploader)
    {
        $bookDto = new BookDto();
        $form = $this->createForm(BookFormType::class, $bookDto);
        $form->handleRequest($request);
        if(!$form->isSubmitted()){
            return new Response('', Response::HTTP_BAD_REQUEST );
        }
        if ($form->isValid()){
            $book = new Book();
            $book->setTitle($bookDto->title);
            if($bookDto->base64Image){
                $filename = ($fileUploader)($bookDto->base64Image);
                $book->setImage($filename);
            }
            $entityManager->persist($book);
            $entityManager->flush();
            return $book;
        }
        return $form;

    }

}