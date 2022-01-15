<?php

namespace App\Controller;

use App\Entity\Rover;
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
    public function index(): Response
    {
        $rover = new Rover();

        dd($rover);

        return $this->render('rover/index.html.twig', [
            'rover' => null,
        ]);
    }


}
