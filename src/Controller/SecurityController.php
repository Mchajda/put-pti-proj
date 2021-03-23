<?php

namespace App\Controller;

use App\Provider\Interfaces\UserProviderInterface;
use App\Provider\UserProvider;
use App\RequestProcessor\UserRequestProcessor;
use App\Service\Interfaces\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $userRequestProcessor;
    private $userProvider;
    private $userService;

    public function __construct(
        UserRequestProcessor $userRequestProcessor,
        UserProviderInterface $userProvider,
        UserServiceInterface $userService
    ){
        $this->userRequestProcessor = $userRequestProcessor;
        $this->userProvider = $userProvider;
        $this->userService = $userService;
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute("main");
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/register_form", name="app_register_form")
     */
    public function registerForm(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute("main");
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/register.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request){
        if($request->isMethod("POST")){
            if($request->request->get('password') == $request->request->get('password-repeat')){
                if($this->userProvider->getOneByEmail($request->request->get('email')) == null){
                    if($this->userProvider->getOneByNickname($request->request->get('nickname')) == null){
                        $newUser = $this->userRequestProcessor->register($request);
                        $this->userService->create($newUser);
                    }
                }
            }
        }

        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
