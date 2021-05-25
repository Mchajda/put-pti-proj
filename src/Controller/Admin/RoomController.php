<?php

namespace App\Controller\Admin;

use App\Provider\Interfaces\RoomProviderInterface;
use App\Service\Interfaces\RoomServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    private $roomProvider;
    private $roomService;

    public function __construct(
        RoomProviderInterface $roomProvider,
        RoomServiceInterface $roomService
    ){
        $this->roomProvider = $roomProvider;
        $this->roomService = $roomService;
    }

    /**
     * @Route("/admin/disable_room/{room_id}", name="admin_disable_room")
     */
    public function disableRoom($room_id): Response
    {
        $room = $this->roomProvider->getOneById($room_id);

        if ($room != null) {
            $room->setStatus("disabled");
            $this->roomService->save();
        }

        return $this->redirectToRoute('admin_panel', [

        ]);
    }

    /**
     * @Route("/admin/enable_room/{room_id}", name="admin_enable_room")
     */
    public function enableRoom($room_id): Response
    {
        $room = $this->roomProvider->getOneById($room_id);

        if ($room != null) {
            $room->setStatus("active");
            $this->roomService->save();
        }

        return $this->redirectToRoute('admin_panel', [

        ]);
    }
}
