<?php

namespace App\Controller\Front;

use App\Provider\Interfaces\RoomProviderInterface;
use App\RequestProcessor\Interfaces\RoomRequestProcessorInterface;
use App\Service\Interfaces\RoomServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class RoomController extends AbstractController
{
    private $security;
    private $roomRequestProcessor;
    private $roomProvider;
    private $roomService;

    public function __construct(
        Security $security,
        RoomRequestProcessorInterface $roomRequestProcessor,
        RoomProviderInterface $roomProvider,
        RoomServiceInterface $roomService
    ){
        $this->security = $security;
        $this->roomRequestProcessor = $roomRequestProcessor;
        $this->roomProvider = $roomProvider;
        $this->roomService = $roomService;
    }

    /**
     * @Route("/room_create_farm", name="room_create_form")
     */
    public function index(): Response
    {
        return $this->render('front/room/createRoom.html.twig', [

        ]);
    }

    /**
     * @Route("/room_create", name="room_create")
     */
    public function create(Request $request): Response
    {
        $user = $this->security->getUser();

        if ($request->getMethod() == "POST") {
            if (!$this->roomProvider->getOneByName($request->request->get('name'))) {
                $room = $this->roomRequestProcessor->create($request, $user);
                $this->roomService->create($room);
            }
        }

        return $this->redirectToRoute('profile');
    }
}
