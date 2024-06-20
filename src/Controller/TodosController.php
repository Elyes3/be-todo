<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ODM\MongoDB\DocumentManager; 
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Log\LoggerInterface;
use App\Document\Todo;
use Doctrine\ODM\MongoDB\Configuration;
use MongoDB\Client;
use Symfony\Component\HttpFoundation\JsonResponse;
#[Route('/api', name: 'api_')]
class TodosController extends AbstractFOSRestController
{
    
    #[Route('/todos', name: 'get_todos', methods:['GET'] )]
    public function getTodos(DocumentManager $dm): JsonResponse
    {

      $todos = $dm -> getRepository(Todo::class)->findAll();
      if (empty($todos))
        return new JsonResponse(["message" => "No todos found"], 404);
      return $this->json($todos,[],200,["groups" => "todo"]);
    }
}
