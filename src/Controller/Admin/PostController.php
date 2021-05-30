<?php

namespace App\Controller\Admin;

use App\Provider\Interfaces\PostProviderInterface;
use App\Service\Interfaces\PostServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    private $postProvider;
    private $postService;

    public function __construct(
        PostProviderInterface $postProvider,
        PostServiceInterface $postService
    ){
        $this->postProvider = $postProvider;
        $this->postService = $postService;
    }

    /**
     * @Route("/post/admin_delete/{post_id}", name="admin_delete_post")
     */
    public function deletePost(Request $request, $post_id): Response
    {
        $post = $this->postProvider->getOneById($post_id);

        if ($post->getParentId() == null) {
            $comments = $this->postProvider->getAllCommentsByPostId($post_id);

            foreach ($comments as $comment) {
                $this->postService->delete($comment);
            }
        }

        $this->postService->delete($post);

        return $this->redirectToRoute('admin_panel', [

        ]);
    }
}
