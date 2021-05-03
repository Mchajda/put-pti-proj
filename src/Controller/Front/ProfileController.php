<?php

namespace App\Controller\Front;

use App\Provider\Interfaces\PostProviderInterface;
use App\Provider\Interfaces\UserProviderInterface;
use App\RequestProcessor\Interfaces\UserRequestProcessorInterface;
use App\Service\Interfaces\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ProfileController extends AbstractController
{
    private $security;
    private $userRequestProcessor;
    private $userProvider;
    private $userService;
    private $postProvider;

    public function __construct(
        Security $security,
        UserRequestProcessorInterface $userRequestProcessor,
        UserProviderInterface $userProvider,
        UserServiceInterface $userService,
        PostProviderInterface $postProvider
    ){
        $this->security = $security;
        $this->userRequestProcessor = $userRequestProcessor;
        $this->userProvider = $userProvider;
        $this->userService = $userService;
        $this->postProvider = $postProvider;
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function index(): Response
    {
        $user = $this->userProvider->getOneByEmail($this->security->getUser()->getUsername());
        $last_activity = $this->postProvider->getLast3ByUserId($user->getId());

        return $this->render('front/profile/profile.html.twig', [
            'user' => $user, 'last_activity' => $last_activity,
        ]);
    }

    /**
     * @Route("/profile_edit_form", name="edit_profile_form")
     */
    public function editForm(): Response
    {
        $user = $this->security->getUser();

        return $this->render('front/profile/editForm.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/profile_edit", name="edit_profile")
     */
    public function editProfile(Request $request): Response
    {
        if($request->getMethod() == "POST") {
            $user = $this->userProvider->getOneByEmail($this->security->getUser()->getUsername());
            $this->userRequestProcessor->edit($request, $user);

            $this->userService->save();
        }

        return $this->redirectToRoute('profile');
    }
}
