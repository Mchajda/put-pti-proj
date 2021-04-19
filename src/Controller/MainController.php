<?php

namespace App\Controller;

use App\Provider\Interfaces\RoomProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    protected $roomProvider;

    public function __construct(
        RoomProviderInterface $roomProvider
    ){
        $this->roomProvider = $roomProvider;
    }

    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        $rooms = $this->roomProvider->getAll();

        return $this->render('main/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }
}
