<?php

namespace App\Controller;

use App\Provider\Interfaces\RoomProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    //for debugging

    private $roomProvider;

    public function __construct(
        RoomProviderInterface $roomProvider
    ){
        $this->roomProvider = $roomProvider;
    }

    /**
     * @Route("/", name="main")
     */
    public function index(Request $request): Response
    {
        $alert = (string)$request->query->get('alert');
        $rooms = $this->roomProvider->getAll();

        return $this->render('main/index.html.twig', [
            'alert' => $alert,
            'rooms' => $rooms,
        ]);
    }
}
