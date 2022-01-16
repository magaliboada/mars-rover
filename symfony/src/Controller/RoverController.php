<?php

namespace App\Controller;

use App\Entity\Planet;
use App\Entity\Rover;
use App\Form\ScenarioType;
use App\Model\Coordinate;
use App\UseCase\Rover\ExecuteCommands;
use App\UseCase\Rover\ExecuteCommandsRequest;
use App\UseCase\Rover\ExecuteCommandsResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/")
 */
class RoverController extends AbstractController
{
    /**
     * @Route("/", name="rover_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(ScenarioType::class);
        $form->handleRequest($request);

        return $this->render(
            'rover/index.html.twig',
            [
                'form' => $form->createView(),
                'action' => '',
            ]
        );
    }

    /**
     * @Route("/execute", name="rover_execute", methods={"POST"})
     */
    public function ajaxExecuteCommands(Request $request, ExecuteCommands $executeCommands): JsonResponse
    {
        if($scenario = $request->request->get('scenario')) {
            $planet = new Planet((int)$scenario['size'], (int)$scenario['obstacles']);
            $position = new Coordinate((int)$scenario['position']['x'], (int)$scenario['position']['y']);
            $rover = new Rover($position, $scenario['direction']);

            $executeCommandsRequest = new ExecuteCommandsRequest();
            $executeCommandsRequest->setCommands($scenario['commands']);
            $executeCommandsRequest->setPlanet($planet);
            $executeCommandsRequest->setRover($rover);
            /** @var ExecuteCommandsResponse $response */
            $response = $executeCommands->execute($executeCommandsRequest);
        }

        return new JsonResponse(
            [
                'success' => $response->isOk(),
                'message' => $response->getMessage(),
                'collided' => $response->isCollisionDetected(),
                'roverPosition' => $response->getRoverPosition()->getX() . ', ' . $response->getRoverPosition()->getY(),
            ]
        );
    }
}
