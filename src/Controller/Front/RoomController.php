<?php

namespace App\Controller\Front;

use App\Provider\Interfaces\RoomProviderInterface;
use App\Provider\Interfaces\UserProviderInterface;
use App\RequestProcessor\Interfaces\RoomRequestProcessorInterface;
use App\Service\Interfaces\RoomServiceInterface;
use App\Service\Interfaces\UserServiceInterface;
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
    private $userProvider;
    private $userService;

    public function __construct(
        Security $security,
        RoomRequestProcessorInterface $roomRequestProcessor,
        RoomProviderInterface $roomProvider,
        RoomServiceInterface $roomService,
        UserProviderInterface $userProvider,
        UserServiceInterface $userService
    ){
        $this->security = $security;
        $this->roomRequestProcessor = $roomRequestProcessor;
        $this->roomProvider = $roomProvider;
        $this->roomService = $roomService;
        $this->userProvider = $userProvider;
        $this->userService = $userService;
    }


    /**
     * @Route("/rooms", name="rooms")
     */
    public function index(Request $request): Response
    {
        $alert = (string)$request->query->get('alert');
        $user = $this->userProvider->getOneByEmail($this->security->getUser()->getUsername());

        $rooms_user_belongs = $user->getParticipatingInRooms();
        $all_rooms = $this->roomProvider->getAll();
        $rooms_user_does_not_belong = $this->roomProvider->getRoomsUserDoesNotBelongTo($rooms_user_belongs, $all_rooms);

        return $this->render('front/room/index.html.twig', [
            'alert' => $alert,
            'rooms_user_does_not_belong' => $rooms_user_does_not_belong,
            'rooms_user_belongs' => $rooms_user_belongs,
            'user' => $user,
        ]);
    }

    /**
     * @Route("/room_create_farm", name="room_create_form")
     */
    public function createRoomForm(): Response
    {
        return $this->render('front/room/createRoom.html.twig', [

        ]);
    }

    /**
     * @Route("/room_create", name="room_create")
     */
    public function create(Request $request): Response
    {
        $user = $this->userProvider->getOneByEmail($this->security->getUser()->getUsername());

        if ($request->getMethod() == "POST") {
            if (!$this->roomProvider->getOneByName($request->request->get('name'))) {
                $room = $this->roomRequestProcessor->create($request, $user);
                $this->roomService->create($room);
                $user->addParticipatingInRoom($room);
                $room->addMember($user);
                $this->roomService->save();
                $this->userService->save();
            }
        }

        return $this->redirectToRoute('profile');
    }

    /**
     * @Route("/room_delete/{room_id}", name="room_delete")
     */
    public function delete(Request $request, $room_id): Response
    {
        $user = $this->userProvider->getOneByEmail($this->security->getUser()->getUsername());
        $room = $this->roomProvider->getOneById($room_id);

        if ($this->security->getUser() && $room->getCreator() == $user) {
            $this->roomService->delete($room);
        }

        return $this->redirectToRoute('profile');
    }

    /**
     * @Route("/room_join/{room_id}", name="room_join")
     */
    public function joinRoom(Request $request, $room_id): Response
    {
        $user = $this->userProvider->getOneByEmail($this->security->getUser()->getUsername());
        $room = $this->roomProvider->getOneById($room_id);

        if ($room->getCreator() != $user) {
            foreach ($room->getMember() as $member) {
                if ($member == $user) {
                    return $this->redirectToRoute('main', ['alert' => 'you already belongs here']);
                }
            }
            //you are neither member nor creator of this room
            $room->addMember($user);
            $user->addParticipatingInRoom($room);
            $this->roomService->save();
            $this->userService->save();
        } else {
            return $this->redirectToRoute('main', ['alert' => 'you already belongs here']);
        }

        return $this->redirectToRoute('rooms');
    }

    /**
     * @Route("/room_leave/{room_id}", name="room_leave")
     */
    public function leaveRoom(Request $request, $room_id): Response
    {
        $user = $this->userProvider->getOneByEmail($this->security->getUser()->getUsername());
        $room = $this->roomProvider->getOneById($room_id);

        if ($room->getCreator() != $user) {
            //you are not a creator of this room
            $room->removeMember($user);
            $user->removeParticipatingInRoom($room);
            $this->roomService->save();
            $this->userService->save();
        } else {
            return $this->redirectToRoute('main', ['alert' => 'you are a creator of this room, you cant leave it']);
        }

        return $this->redirectToRoute('profile');
    }

    /**
     * @Route("/room/{room_name}", name="room")
     */
    public function openRoom(Request $request, $room_name): Response
    {
        $user = $this->userProvider->getOneByEmail($this->security->getUser()->getUsername());
        $room = $this->roomProvider->getOneByName($room_name);

        if ($room) {
            return $this->render('front/room/room.html.twig', [
                'room' => $room
            ]);
        } else {
            return $this->redirectToRoute('main');
        }
    }
}
