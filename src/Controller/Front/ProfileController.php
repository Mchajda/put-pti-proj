<?php

namespace App\Controller\Front;

use App\Provider\Interfaces\UserProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ProfileController extends AbstractController
{
    private $security;

    public function __construct(
        Security $security
    ){
        $this->security = $security;
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function index(): Response
    {
        $user = $this->security->getUser();

        return $this->render('front/profile/index.html.twig', [
            'user' => $user
        ]);
    }
}
