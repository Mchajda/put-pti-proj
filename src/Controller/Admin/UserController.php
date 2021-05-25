<?php

namespace App\Controller\Admin;

use App\Provider\Interfaces\UserProviderInterface;
use App\Service\Interfaces\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $userProvider;
    private $userService;

    public function __construct(
        UserProviderInterface $userProvider,
        UserServiceInterface $userService
    ){
        $this->userProvider = $userProvider;
        $this->userService = $userService;
    }

    /**
     * @Route("/admin/ban_user/{user_id}", name="admin_ban_user")
     */
    public function banUser(Request $request, $user_id): Response
    {
        $user = $this->userProvider->getOneById($user_id);

        if ($user != null) {
            $user->setStatus("banned");
            $this->userService->save();
        }

        return $this->redirectToRoute('admin_panel', [

        ]);
    }

    /**
     * @Route("/admin/unban_user/{user_id}", name="admin_unban_user")
     */
    public function unbanUser(Request $request, $user_id): Response
    {
        $user = $this->userProvider->getOneById($user_id);

        if ($user != null) {
            $user->setStatus("active");
            $this->userService->save();
        }

        return $this->redirectToRoute('admin_panel', [

        ]);
    }
}
