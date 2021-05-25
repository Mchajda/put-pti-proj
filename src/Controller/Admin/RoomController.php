<?php

namespace App\Controller\Admin;

use App\Provider\Interfaces\RoomProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    private $roomProvider;

    public function __construct(
        RoomProviderInterface $roomProvider
    ){
        $this->roomProvider = $roomProvider;
    }

    /**
     * @Route("/admin/disable_room/{room_id}", name="admin_disable_room")
     */
    public function disableRoom($room_id): Response
    {
        
        return $this->redirectToRoute('admin_panel', [

        ]);
    }
}
