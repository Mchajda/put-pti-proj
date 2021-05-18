<?php

namespace App\Controller;

use App\Provider\Interfaces\RoomProviderInterface;
use App\Provider\Interfaces\UserProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MainController extends AbstractController
{
    private $security;
    private $roomProvider;
    private $userProvider;

    public function __construct(
        Security $security,
        RoomProviderInterface $roomProvider,
        UserProviderInterface $userProvider
    ){
        $this->security = $security;
        $this->roomProvider = $roomProvider;
        $this->userProvider = $userProvider;
    }

    /**
     * @Route("/", name="main")
     */
    public function index(Request $request): Response
    {
        $alert = (string)$request->query->get('alert');
        $most_active_rooms = $this->roomProvider->getMostActiveRooms();

        return $this->render('main/index.html.twig', [
            'alert' => $alert, 'most_active_rooms' => $most_active_rooms,
        ]);
    }
}
