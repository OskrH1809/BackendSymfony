<?php

namespace App\Service;

use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;

class FileUploader {
    /**
     * @var FilesystemOperator
     */
    private $defaultStorage;

    public function __construct(FilesystemOperator $defaultStorage)
    {
        $this->defaultStorage = $defaultStorage;
    }

    public function __invoke($base64File): string
    {
        // $baseImagen = "data:image/jpg;base64,$base64File";
        // $cleanImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseImagen));
        // $filename = sprintf('%s.%s', uniqid('file_', true), 'jpg');
        $extension = explode('/', mime_content_type($base64File))[1];
        $data = explode(',', $base64File);
        $filename = sprintf('%s.%s', uniqid('name_', true), $extension);
        
        try {
            // $this->defaultStorage->write($filename, $cleanImage);
            $this->defaultStorage->write($filename, base64_decode($data[1]));
            return $filename;
        } catch (FilesystemException $e) {
            return $e->getMessage();
        }
    }

    /*public function uploadBase64File(string $base64File): string
    {
        //           $destino = $this->getParameter('directorio_publico') . '/storage/default/';

        $filepath = $destino . $filename;
        if (!file_exists($destino)) {
            mkdir($destino, 0775, true);
        }
        $resultado = file_put_contents($filepath, $data);
        if($resultado){
            $book->setTitle($bookDto->title);
            $book->setImage($filename);
            $entityManager->persist($book);
            $entityManager->flush();
            return $book;
        }
//            dump($filename);
//            dd();
//            $filepath = $rutaExpedientes . $rutaDestino . $nombre;

//            dump($bookDto->base64Image);
//            dd();
//            $extension = explode('/', mime_content_type($bookDto->base64Image))[1];
//            dump($extension);
//            Warning: mime_content_type(=): failed to open stream: No such file or directory
        $data = explode(',', $bookDto->base64Image);
        dump($data);
        dd();



    }*/
}
