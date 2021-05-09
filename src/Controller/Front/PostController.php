<?php

namespace App\Controller\Front;

use App\Provider\Interfaces\PostProviderInterface;
use App\Provider\Interfaces\RoomProviderInterface;
use App\Provider\Interfaces\UserProviderInterface;
use App\RequestProcessor\Interfaces\PostRequestProcessorInterface;
use App\Service\Interfaces\PostServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PostController extends AbstractController
{
    private $postRequestProcessor;
    private $postProvider;
    private $postService;

    private $userProvider;
    private $roomProvider;
    private $security;

    public function __construct(
        PostRequestProcessorInterface $postRequestProcessor,
        PostProviderInterface $postProvider,
        PostServiceInterface $postService,

        UserProviderInterface $userProvider,
        RoomProviderInterface $roomProvider,
        Security $security
    ){
        $this->postRequestProcessor = $postRequestProcessor;
        $this->postProvider = $postProvider;
        $this->postService = $postService;

        $this->userProvider = $userProvider;
        $this->roomProvider = $roomProvider;
        $this->security = $security;
    }

    /**
     * @Route("/post/create/{room_id}", name="create_post")
     */
    public function createPost(Request $request, $room_id): Response
    {
        $user = $this->userProvider->getOneByEmail($this->security->getUser()->getUsername());
        $room = $this->roomProvider->getOneById($room_id);

        if ($request->getMethod() == "POST") {
            $newPost = $this->postRequestProcessor->create($request, $user, $room, null);
            $this->postService->create($newPost);
        }

        return $this->redirectToRoute('room', ['room_name' => $room->getName(), ]);
    }

    /**
     * @Route("/{room_slug}/post/{post_id}", name="show_post")
     */
    public function showPost(Request $request, $room_slug, $post_id): Response
    {
        $room = $this->roomProvider->getOneBySlug($room_slug);
        $post = $this->postProvider->getOneById($post_id);

        return $this->render('front/post/index.html.twig', ['room_name' => $room->getName(), 'post' => $post ]);
    }
}
