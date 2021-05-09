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

        return $this->redirectToRoute('room', ['slug' => $room->getSlug(), ]);
    }

    /**
     * @Route("/{room_slug}/post/{post_id}", name="show_post")
     */
    public function showPost(Request $request, $room_slug, $post_id): Response
    {
        $room = $this->roomProvider->getOneBySlug($room_slug);
        $post = $this->postProvider->getOneById($post_id);
        $comments = $this->postProvider->getAllCommentsByPostId($post_id);

        $user = $this->userProvider->getOneByEmail($this->security->getUser()->getUsername());
        $is_participating = false;

        foreach ($user->getParticipatingInRooms() as $user_room) {
            if($user_room == $room)
                $is_participating = true;
        }

        return $this->render('front/post/index.html.twig', [
            'room' => $room, 'post' => $post,
            'comments' => $comments, 'is_participating' => $is_participating,
        ]);
    }

    /**
     * @Route("/post/create/{room_id}/{parent_post_id}", name="create_comment")
     */
    public function createComment(Request $request, $room_id, $parent_post_id): Response
    {
        $user = $this->userProvider->getOneByEmail($this->security->getUser()->getUsername());
        $room = $this->roomProvider->getOneById($room_id);

        if ($request->getMethod() == "POST") {
            $newPost = $this->postRequestProcessor->create($request, $user, $room, $parent_post_id);
            $this->postService->create($newPost);
        }

        return $this->redirectToRoute('show_post', [
            'room_slug' => $room->getSlug(), 'post_id' => $parent_post_id,
        ]);
    }
}
