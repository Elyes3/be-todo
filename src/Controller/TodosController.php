<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
    public function getTodos(Request $request, DocumentManager $dm): JsonResponse
    {
      // millis represents the date of the selected todo converted in milliseconds
      $millis = $request->query->get('millis');
      if ($millis == null){
        return new JsonResponse(["error" => "The date must be referenced"],500);
      }
      $criteria['millis'] = $millis;
      $todos = $dm -> getRepository(Todo::class)->findBy($criteria);
      return $this->json($todos, 200, []);
    }
      #[Route('/todos', name: 'post_todo', methods:['POST'] )]
    public function createTodo(Request $request, DocumentManager $dm): JsonResponse
    {
      $data = json_decode($request->getContent(), true);
      // handle empty fields
      if (!$data["millis"] || !$data["description"]){
        return new JsonResponse(["error" => "The millis or description field must be referenced"],500);
      }
      // create a new todo to affect the new values
      $todo = new Todo();
      $todo->setDescription($data["description"]);
      $todo->setMillis($data["millis"]);
      $todo->setCompleted(false);
      // persist data
      $dm->persist($todo);
      $dm->flush();
      return $this->json(["todo" => $todo, "message" => "Todo created successfully"], 201, []);
    }
    #[Route('/todos/{id}/description', name: 'update_description', methods:['PATCH'] )]
    public function updateTodo(Request $request, DocumentManager $dm, string $id): JsonResponse{
      $data = json_decode($request->getContent(), true);
      // Only the description can be updated the millis isn't designed to be updated

      $criteria['id'] = $id;
      // Find the todo with the specified id in params
      $currentTodo = $dm ->getRepository(Todo::class)->find($criteria);
      if (!$currentTodo){
        // Check can also be done through CreateNotFoundException
        return new JsonResponse(["error" => "The todo with the referenced id does not exist"],404);
      }
      // Change the description if it exists else keep the same description
      $currentTodo->setDescription($data["description"] ?? $currentTodo->getDescription());
      $dm->flush();
      return $this->json(["todo" => $currentTodo, "message" => "Todo updated successfully"],200,[]);
    }  
    #[Route('/todos/{id}', name: 'delete_todo', methods:['DELETE'] )]
    public function deleteTodo(Request $request, DocumentManager $dm, string $id){
      $criteria['id'] = $id;
      $currentTodo = $dm ->getRepository(Todo::class)->find($criteria);
      if (!$currentTodo){
        // Check can also be done through CreateNotFoundException
        return new JsonResponse(["error" => "The todo with the referenced id does not exist"],500);
      }
      $dm->remove($currentTodo);
      $dm->flush();
      return $this->json(["todo" => $currentTodo, "message" => "Todo deleted successfully"], 200, []);
    }
    #[Route('/todos/{id}/completed', name: 'complete-todo', methods:['PATCH'] )]
    public function completeTodo(Request $request, DocumentManager $dm, string $id){
      $data = json_decode($request->getContent(), true);
      // Only the description can be updated the millis isn't designed to be updated

      $criteria['id'] = $id;
      // Find the todo with the specified id in params
      $currentTodo = $dm ->getRepository(Todo::class)->find($criteria);
      if (!$currentTodo){
        // Check can also be done through CreateNotFoundException
        return new JsonResponse(["error" => "The todo with the referenced id does not exist"],404);
      }
      // Change the description if it exists else keep the same description
      $currentTodo->setCompleted($data["completed"] ?? $currentTodo->getCompleted());
      $dm->flush();
      return $this->json(["todo" => $currentTodo, "message" => "Todo updated successfully"],200,[]);
    }
  }

