<?php

namespace App\Controller\Admin;

use App\Provider\Interfaces\PostProviderInterface;
use App\Provider\Interfaces\RoomProviderInterface;
use App\Provider\Interfaces\UserProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $userProvider;
    private $roomProvider;
    private $postProvider;

    public function __construct(
        UserProviderInterface $userProvider,
        RoomProviderInterface $roomProvider,
        PostProviderInterface $postProvider
    ){
        $this->userProvider = $userProvider;
        $this->roomProvider = $roomProvider;
        $this->postProvider = $postProvider;
    }

    /**
     * @Route("/admin_panel", name="admin_panel")
     */
    public function index(): Response
    {
        $users = $this->userProvider->getUsersForAdmin();

        return $this->render('admin/index.html.twig', [
            //'users' => $users,
        ]);
    }
}
